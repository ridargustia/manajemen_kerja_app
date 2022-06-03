<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Template';

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';

  }

  function update($id)
  {
    is_login();

    if(!is_grandadmin())
    {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $this->data['template']     = $this->Template_model->get_by_id($id);

    if($this->data['template'])
    {
      $this->data['page_title'] = 'Update Template';
      $this->data['action']     = 'admin/template/update_action';

      $this->data['id'] = [
        'name'          => 'id',
        'type'          => 'hidden',
      ];
      $this->data['name'] = [
        'name'          => 'name',
        'class'         => 'form-control',
        'readonly'      => '',
      ];
      $this->data['value'] = [
        'name'          => 'value',
        'class'         => 'form-control',
      ];
      $this->data['layout_value'] = [
        ''                    => 'Normal',
        'fixed'               => 'Fixed',
        'layout-boxed'        => 'Boxed',
        'sidebar-collapse'    => 'Collapsed Sidebar',
      ];
      $this->data['skins_value'] = [
        'skin-blue'             => 'Blue',
        'skin-black'            => 'Black',
        'skin-purple'           => 'Purple',
        'skin-green'            => 'Green',
        'skin-red'              => 'Red',
        'skin-yellow'           => 'Yellow',
        'skin-blue-light'       => 'Blue Light',
        'skin-black-light'      => 'Black Light',
        'skin-purple-light'     => 'Purple Light',
        'skin-green-light'      => 'Green Light',
        'skin-red-light'        => 'Red Light',
        'skin-yellow-light'     => 'Yellow Light',
      ];

      $this->load->view('back/template/template_edit', $this->data);
    }
    else
    {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data not found</div>');
      redirect('admin/dashboard');
    }

  }

  function update_action()
  {
    $data = array(
      'value'             => $this->input->post('value'),
    );

    $this->Template_model->update($this->input->post('id'),$data);

    write_log();

    $this->session->set_flashdata('message', '<div class="alert alert-success">Data update succesfully</div>');
    redirect('admin/template/update/'.$this->input->post('id'));
  }

}
