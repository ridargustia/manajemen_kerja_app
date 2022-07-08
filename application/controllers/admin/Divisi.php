<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Divisi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Divisi';

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
    $this->data['add_action'] = base_url('admin/divisi/create');

    is_login();

    if (is_superadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
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

    //TODO Inisialisasi variabel
    $this->data['page_title'] = 'Data ' . $this->data['module'];

    //TODO Get data divisi berdasarkan hak akses usertype
    if (is_grandadmin()) {
      $this->data['get_all'] = $this->Divisi_model->get_all();
    } elseif (is_masteradmin()) {
      $this->data['get_all'] = $this->Divisi_model->get_all_by_instansi();
    }

    //TODO Load view list divisi dengan kirim data
    $this->load->view('back/divisi/divisi_list', $this->data);
  }

  function create()
  {
    is_create();

    //TODO Inisialisasi variabel
    $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
    $this->data['action']     = 'admin/divisi/create_action';

    //TODO Get combobox value by usertype
    if (is_grandadmin()) {
      $this->data['get_all_combobox_instansi']      = $this->Instansi_model->get_all_combobox();
    }

    //TODO Rancangan form
    $this->data['instansi_id'] = [
      'name'          => 'instansi_id',
      'id'            => 'instansi_id',
      'class'         => 'form-control',
      'required'      => '',
    ];
    $this->data['divisi_name'] = [
      'name'          => 'divisi_name',
      'id'            => 'divisi_name',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('divisi_name'),
    ];

    //TODO Load view form add dengan kirim data
    $this->load->view('back/divisi/divisi_add', $this->data);
  }

  function create_action()
  {
    //TODO Form Validation
    $this->form_validation->set_rules('divisi_name', 'Nama Divisi', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    //TODO Definisi variabel berdasarkan usertype
    if (is_grandadmin()) {
      $instansi_id  = $this->input->post('instansi_id');
    } elseif (is_masteradmin()) {
      $instansi_id  = $this->session->instansi_id;
    }

    //TODO Jika inputan data tidak lolos validasi
    if ($this->form_validation->run() === FALSE) {
      $this->create();
    } else {
      $data = array(
        'instansi_id'     => $instansi_id,
        'divisi_name'     => strtoupper($this->input->post('divisi_name')),
        'divisi_slug'     => strtolower(url_title($this->input->post('divisi_name'))),
        'created_by'      => $this->session->username,
      );

      //TODO Proses post data ke database
      $this->Divisi_model->insert($data);

      write_log();

      //TODO Kirim notifikasi berhasil disimpan
      $this->session->set_flashdata('message', 'Sukses');
      redirect('admin/divisi');
    }
  }

  function update($id)
  {
    is_update();

    //TODO Get data divisi by id
    $this->data['divisi']     = $this->Divisi_model->get_by_id($id);

    //TODO Jika data divisi ditemukan
    if ($this->data['divisi']) {
      //TODO Authentikasi hak akses usertype
      if (!is_grandadmin() and !is_masteradmin() and $this->data['divisi']->instansi_id != $this->session->instansi_id) {
        //TODO Kirim notifikasi tidak memiliki akses
        $this->session->set_flashdata('message', 'tidak memiliki akses');
        redirect('admin/divisi');
      }

      //TODO Inisialisasi variabel
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/divisi/update_action';

      //TODO Get value combobox by usertype
      if (is_grandadmin()) {
        $this->data['get_all_combobox_instansi']      = $this->Instansi_model->get_all_combobox();
      }

      //TODO Rancangan form
      $this->data['id_divisi'] = [
        'name'          => 'id_divisi',
        'type'          => 'hidden',
      ];
      $this->data['divisi_name'] = [
        'name'          => 'divisi_name',
        'id'            => 'divisi_name',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['instansi_id'] = [
        'name'          => 'instansi_id',
        'id'            => 'instansi_id',
        'class'         => 'form-control',
        'required'      => '',
      ];

      //TODO Load view form edit divisi
      $this->load->view('back/divisi/divisi_edit', $this->data);
    } else {
      //TODO Kirim notifikasi data tidak ditemukan
      $this->session->set_flashdata('message', 'tidak ditemukan');
      redirect('admin/divisi');
    }
  }

  function update_action()
  {
    //TODO Validasi form
    $this->form_validation->set_rules('divisi_name', 'Nama Divisi', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    //TODO Inisialisasi variabel berdasarkan hak akses usertype
    if (is_grandadmin()) {
      $instansi_id  = $this->input->post('instansi_id');
    } elseif (is_masteradmin()) {
      $instansi_id  = $this->session->instansi_id;
    }

    //TODO Kondisi data inputan tidak lolos validasi
    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_divisi'));
    } else {
      $data = array(
        'instansi_id'     => $instansi_id,
        'divisi_name'     => strtoupper($this->input->post('divisi_name')),
        'divisi_slug'     => strtolower(url_title($this->input->post('divisi_name'))),
        'modified_by'     => $this->session->username,
      );

      //TODO Jalankan proses update by id
      $this->Divisi_model->update($this->input->post('id_divisi'), $data);

      write_log();

      //TODO Kirim notifikasi berhasil disimpan
      $this->session->set_flashdata('message', 'Sukses');
      redirect('admin/divisi');
    }
  }

  function delete($id)
  {
    is_delete();

    //TODO Get data divisi by id
    $delete = $this->Divisi_model->get_by_id($id);

    //TODO Jika data divisi ditemukan
    if ($delete) {
      $data = array(
        'is_delete_divisi'  => '1',
        'deleted_by'        => $this->session->username,
        'deleted_at'        => date('Y-m-d H:i:a'),
      );

      //TODO Jalankan proses softdelete
      $this->Divisi_model->soft_delete($id, $data);

      write_log();

      //TODO Kirim notifikasi berhasil dihapus
      $this->session->set_flashdata('message', 'dihapus');
      redirect('admin/divisi');
    } else {
      //TODO Kirim notifikasi data tidak ditemukan
      $this->session->set_flashdata('message', 'tidak ditemukan');
      redirect('admin/divisi');
    }
  }

  function delete_permanent($id)
  {
    is_delete();

    $delete = $this->Divisi_model->get_by_id($id);

    if ($delete) {
      $this->Divisi_model->delete($id);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus permanen</div>');
      redirect('admin/divisi/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/divisi');
    }
  }

  function deleted_list()
  {
    is_restore();

    $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

    if (is_grandadmin()) {
      $this->data['get_all_deleted'] = $this->Divisi_model->get_all_deleted();
    } elseif (is_masteradmin()) {
      $this->data['get_all_deleted'] = $this->Divisi_model->get_all_deleted_by_instansi();
    } elseif (is_superadmin()) {
      $this->data['get_all_deleted'] = $this->Divisi_model->get_all_deleted_by_cabang();
    }


    $this->load->view('back/divisi/divisi_deleted_list', $this->data);
  }

  function restore($id)
  {
    is_restore();

    $row = $this->Divisi_model->get_by_id($id);

    if ($row) {
      $data = array(
        'is_delete_divisi'   => '0',
        'deleted_by'        => NULL,
        'deleted_at'        => NULL,
      );

      $this->Divisi_model->update($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dikembalikan</div>');
      redirect('admin/divisi/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/divisi');
    }
  }

  function pilih_divisi()
  {
    $this->data['divisi'] = $this->Divisi_model->get_divisi_by_instansi_combobox($this->uri->segment(4));
    $this->load->view('back/divisi/v_divisi', $this->data);
  }
}
