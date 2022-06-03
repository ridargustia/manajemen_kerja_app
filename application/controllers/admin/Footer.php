<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Footer extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Footer';

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';

    is_login();

    if(!is_grandadmin())
    {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }
  }

  function update($id)
  {
    is_update();

    $this->data['footer']     = $this->Footer_model->get_by_id($id);

    if ($this->data['footer']) {      
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/footer/update_action';
      
      $this->data['id_footer'] = [
        'name'          => 'id_footer',
        'type'          => 'hidden',
      ];
      $this->data['content'] = [
        'name'          => 'content',
        'id'            => 'content',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];      

      $this->load->view('back/template/footer_edit', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/footer');
    }
  }

  function update_action()
  {
    $this->form_validation->set_rules('content', 'Isi Footer', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');    

    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_footer'));
    } else {
      $data = array(
        'content'     => $this->input->post('content'),
      );

      $this->Footer_model->update($this->input->post('id_footer'), $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');
      redirect('admin/footer/update/1');
    }
  }
}
