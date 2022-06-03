<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Home';

    $this->load->model(array('Arsip_model', 'Rak_model', 'Baris_model'));

    $this->data['company_data']      = $this->Company_model->company_profile();
    $this->data['footer']            = $this->Footer_model->footer();

    is_login_front();
    is_active_instansi_front();
  }

  function index()
  {
    $this->data['page_title'] = 'Home';

    $this->data['get_instansi']       = $this->Instansi_model->get_by_id($this->session->instansi_id);

    if (is_grandadmin()) {
      $this->data['get_all_instansi'] = $this->Instansi_model->get_all_active();
    } elseif (is_masteradmin()) {
      $this->data['get_all_cabang']   = $this->Cabang_model->get_all_by_instansi();
    } else {
      $this->data['get_all_divisi']   = $this->Divisi_model->get_all_by_cabang();
    }

    $this->load->view('front/home/body', $this->data);
  }
}
