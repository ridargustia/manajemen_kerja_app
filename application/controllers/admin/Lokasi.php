<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lokasi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Lokasi';

    $this->load->model(array('Lokasi_model'));

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
    $this->data['add_action'] = base_url('admin/lokasi/create');

    is_login();

    if (is_admin() and is_pegawai()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    if ($this->uri->segment(2) != NULL) {
      menuaccess_check();
    } elseif ($this->uri->segment(3) != NULL) {
      submenuaccess_check();
    }
  }

  function index()
  {
    is_read();

    $this->data['page_title'] = 'Data ' . $this->data['module'];

    if (is_grandadmin()) {
      $this->data['get_all'] = $this->Lokasi_model->get_all();
    } elseif (is_masteradmin()) {
      $this->data['get_all'] = $this->Lokasi_model->get_all_by_instansi();
    } elseif (is_superadmin()) {
      $this->data['get_all'] = $this->Lokasi_model->get_all_by_cabang();
    }

    $this->load->view('back/lokasi/lokasi_list', $this->data);
  }

  function create()
  {
    is_create();

    $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
    $this->data['action']     = 'admin/lokasi/create_action';

    if (is_grandadmin()) {
      $this->data['get_all_combobox_instansi']     = $this->Instansi_model->get_all_combobox();
      $this->data['get_all_combobox_cabang']       = $this->Cabang_model->get_all_combobox();
    } elseif (is_masteradmin()) {
      $this->data['get_all_combobox_cabang']       = $this->Cabang_model->get_all_combobox_by_instansi($this->session->instansi_id);
    }

    $this->data['lokasi_name'] = [
      'name'          => 'lokasi_name',
      'id'            => 'lokasi_name',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('lokasi_name'),
    ];
    $this->data['instansi_id'] = [
      'name'          => 'instansi_id',
      'id'            => 'instansi_id',
      'class'         => 'form-control',
      'onChange'      => 'tampilCabang()',
      'required'      => '',
    ];
    $this->data['cabang_id'] = [
      'name'          => 'cabang_id',
      'id'            => 'cabang_id',
      'class'         => 'form-control',
      'required'      => '',
    ];

    $this->load->view('back/lokasi/lokasi_add', $this->data);
  }

  function create_action()
  {
    $this->form_validation->set_rules('lokasi_name', 'Nama Lokasi', 'trim|required');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if (is_grandadmin()) {
      $instansi_id  = $this->input->post('instansi_id');
      $cabang_id    = $this->input->post('cabang_id');
      $this->data['check_by_name']  = $this->Lokasi_model->check_by_name_and_instansi_and_cabang($this->input->post('lokasi_name'), $instansi_id, $cabang_id);
    } elseif (is_masteradmin()) {
      $instansi_id  = $this->session->instansi_id;
      $cabang_id    = $this->input->post('cabang_id');
      $this->data['check_by_name']  = $this->Lokasi_model->check_by_name_and_instansi_and_cabang($this->input->post('lokasi_name'), $instansi_id, $cabang_id);
    } elseif (is_superadmin()) {
      $instansi_id  = $this->session->instansi_id;
      $cabang_id    = $this->session->cabang_id;
      $this->data['check_by_name']  = $this->Lokasi_model->check_by_name_and_instansi_and_cabang($this->input->post('lokasi_name'), $instansi_id, $cabang_id);
    }

    if ($this->form_validation->run() === FALSE) {
      $this->create();
    } elseif ($this->input->post('lokasi_name') == $this->data['check_by_name']->lokasi_name) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Nama ' . $this->data['module'] . ' telah ada, silahkan ganti yang lain</div>');
      $this->create();
    } else {
      $data = array(
        'lokasi_name'          => $this->input->post('lokasi_name'),
        'instansi_id'       => $instansi_id,
        'cabang_id'         => $cabang_id,
        'created_by'        => $this->session->username,
      );

      $this->Lokasi_model->insert($data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');
      redirect('admin/lokasi');
    }
  }

  function update($id)
  {
    is_update();

    $this->data['lokasi']     = $this->Lokasi_model->get_by_id($id);

    if ($this->data['lokasi']) {
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/lokasi/update_action';

      if (is_grandadmin()) {
        $this->data['get_all_combobox_instansi']     = $this->Instansi_model->get_all_combobox();
        $this->data['get_all_combobox_cabang']       = $this->Cabang_model->get_all_combobox_update($this->data['lokasi']->instansi_id);
      } elseif (is_masteradmin()) {
        $this->data['get_all_combobox_cabang']       = $this->Cabang_model->get_all_combobox_update($this->session->instansi_id);
        $this->data['get_all_combobox_divisi']       = $this->Divisi_model->get_all_combobox_by_instansi($this->session->instansi_id);
      }

      $this->data['id_lokasi'] = [
        'name'          => 'id_lokasi',
        'type'          => 'hidden',
      ];
      $this->data['lokasi_name'] = [
        'name'          => 'lokasi_name',
        'id'            => 'lokasi_name',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['instansi_id'] = [
        'name'          => 'instansi_id',
        'id'            => 'instansi_id',
        'class'         => 'form-control',
        'onChange'      => 'tampilCabang()',
        'required'      => '',
      ];
      $this->data['cabang_id'] = [
        'name'          => 'cabang_id',
        'id'            => 'cabang_id',
        'class'         => 'form-control',
        'required'      => '',
      ];

      $this->load->view('back/lokasi/lokasi_edit', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/lokasi');
    }
  }

  function update_action()
  {
    $this->form_validation->set_rules('lokasi_name', 'Nama Lokasi', 'trim|required');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if (is_grandadmin()) {
      $instansi_id  = $this->input->post('instansi_id');
      $cabang_id    = $this->input->post('cabang_id');
    } elseif (is_masteradmin()) {
      $instansi_id  = $this->session->instansi_id;
      $cabang_id    = $this->input->post('cabang_id');
    } elseif (is_superadmin()) {
      $instansi_id  = $this->session->instansi_id;
      $cabang_id    = $this->session->cabang_id;
    }

    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_lokasi'));
    } else {
      $data = array(
        'lokasi_name'            => $this->input->post('lokasi_name'),
        'instansi_id'         => $instansi_id,
        'cabang_id'           => $cabang_id,
        'modified_by'         => $this->session->username,
      );

      $this->Lokasi_model->update($this->input->post('id_lokasi'), $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');
      redirect('admin/lokasi');
    }
  }

  function delete($id)
  {
    is_delete();

    $delete = $this->Lokasi_model->get_by_id($id);

    if ($delete) {
      $data = array(
        'is_delete_lokasi'   => '1',
        'deleted_by'        => $this->session->username,
        'deleted_at'        => date('Y-m-d H:i:a'),
      );

      $this->Lokasi_model->soft_delete($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus</div>');
      redirect('admin/lokasi');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/lokasi');
    }
  }

  function delete_permanent($id)
  {
    is_delete();

    $delete = $this->Lokasi_model->get_by_id($id);

    if ($delete) {
      $this->Lokasi_model->delete($id);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus permanen</div>');
      redirect('admin/lokasi/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/lokasi');
    }
  }

  function deleted_list()
  {
    is_restore();

    $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

    if (is_grandadmin()) {
      $this->data['get_all_deleted'] = $this->Lokasi_model->get_all_deleted();
    } elseif (is_masteradmin()) {
      $this->data['get_all_deleted'] = $this->Lokasi_model->get_all_deleted_by_instansi();
    } elseif (is_superadmin()) {
      $this->data['get_all_deleted'] = $this->Lokasi_model->get_all_deleted_by_cabang();
    }

    $this->load->view('back/lokasi/lokasi_deleted_list', $this->data);
  }

  function restore($id)
  {
    is_restore();

    $row = $this->Lokasi_model->get_by_id($id);

    if ($row) {
      $data = array(
        'is_delete_lokasi'   => '0',
        'deleted_by'        => NULL,
        'deleted_at'        => NULL,
      );

      $this->Lokasi_model->update($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dikembalikan</div>');
      redirect('admin/lokasi/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/lokasi');
    }
  }

  function pilih_lokasi()
  {
    $this->data['lokasi'] = $this->Lokasi_model->get_lokasi_by_cabang_combobox($this->uri->segment(4));
    $this->load->view('back/lokasi/v_lokasi', $this->data);
  }
}
