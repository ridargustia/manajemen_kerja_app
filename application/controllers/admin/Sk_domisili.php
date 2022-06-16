<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_domisili extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Domisili';

        $this->data['company_data']             = $this->Company_model->company_profile();
        $this->data['layout_template']          = $this->Template_model->layout();
        $this->data['skins_template']           = $this->Template_model->skins();
        $this->data['footer']                   = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Simpan';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['add_action'] = base_url('admin/sk_domisili/create');

        is_login();

        //TODO Autentikasi hak akses user
        if ($this->uri->segment(2) != NULL) {
            menuaccess_check();
        } elseif ($this->uri->segment(3) != NULL) {
            submenuaccess_check();
        }
    }

    function index()
    {
        //TODO Authentication hak akses usertype
        is_read();
        //TODO Inisialisasi variabel judul
        $this->data['page_title'] = 'Data ' . $this->data['module'];
        //TODO Get data SKCK dari database
        $this->data['get_all'] = $this->Sk_domisili_model->get_all();

        $this->load->view('back/sk_domisili/sk_domisili_list', $this->data);
    }
}