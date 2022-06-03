<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengembalian extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Pengembalian';

    $this->load->model(array('Pengembalian_model', 'Arsip_model', 'Peminjaman_model'));

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->data['get_all_combobox_instansi']  = $this->Instansi_model->get_all_combobox();
    $this->data['get_all_combobox_divisi']  = $this->Divisi_model->get_all_combobox();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
    $this->data['add_action'] = base_url('admin/pengembalian/create');

    is_login();

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
      $this->data['get_all'] = $this->Pengembalian_model->get_all();
    } elseif (is_masteradmin()) {
      $this->data['get_all'] = $this->Pengembalian_model->get_all_by_instansi();
    } elseif (is_superadmin()) {
      $this->data['get_all'] = $this->Pengembalian_model->get_all_by_cabang();
    } else {
      $this->data['get_all'] = $this->Pengembalian_model->get_all_by_divisi();
    }

    $this->load->view('back/pengembalian/pengembalian_list', $this->data);
  }

  function create()
  {
    is_create();

    $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
    $this->data['action']     = 'admin/pengembalian/create_action';

    if (is_grandadmin()) {
      $this->data['get_all_combobox_user']                  = $this->Auth_model->get_all_combobox();
      $this->data['get_all_combobox_arsip_peminjaman']      = $this->Peminjaman_model->get_all_combobox_arsip_peminjaman();
    } elseif (is_masteradmin()) {
      $this->data['get_all_combobox_user']                  = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_arsip_peminjaman']      = $this->Peminjaman_model->get_all_combobox_arsip_peminjaman_by_instansi($this->session->instansi_id);
    } elseif (is_superadmin()) {
      $this->data['get_all_combobox_user']                  = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_arsip_peminjaman']      = $this->Peminjaman_model->get_all_combobox_arsip_peminjaman_by_cabang($this->session->cabang_id);
    } else {
      $this->data['get_all_combobox_arsip_peminjaman']      = $this->Peminjaman_model->get_all_combobox_arsip_peminjaman_by_divisi($this->session->divisi_id);
    }

    $this->data['tgl_kembali'] = [
      'name'          => 'tgl_kembali',
      'id'            => 'tgl_kembali',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('tgl_kembali'),
    ];
    $this->data['arsip_id'] = [
      'name'          => 'arsip_id',
      'id'            => 'arsip_id',
      'class'         => 'form-control',
      'type'          => 'hidden',
      'required'      => '',
    ];
    $this->data['peminjaman_id'] = [
      'name'          => 'peminjaman_id',
      'id'            => 'peminjaman_id',
      'class'         => 'form-control',
      'required'      => '',
    ];
    $this->data['user_id'] = [
      'name'          => 'user_id',
      'id'            => 'user_id',
      'class'         => 'form-control',
      'required'      => '',
      'readonly'      => '',
    ];
    $this->data['instansi_id'] = [
      'name'          => 'instansi_id',
      'id'            => 'instansi_id',
      'class'         => 'form-control',
      'required'      => '',
      'readonly'      => '',
    ];
    $this->data['cabang_id'] = [
      'name'          => 'cabang_id',
      'id'            => 'cabang_id',
      'class'         => 'form-control',
      'required'      => '',
      'readonly'      => '',
    ];
    $this->data['divisi_id'] = [
      'name'          => 'divisi_id',
      'id'            => 'divisi_id',
      'class'         => 'form-control',
      'required'      => '',
      'readonly'      => '',
    ];

    $this->load->view('back/pengembalian/pengembalian_add', $this->data);
  }

  function create_action()
  {
    $this->form_validation->set_rules('tgl_kembali', 'Tanggal Pengembalian', 'trim|required');
    $this->form_validation->set_rules('peminjaman_id', 'Nama Arsip yang Dipinjam', 'trim|required');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    $data_peminjaman = $this->Peminjaman_model->get_by_id($this->input->post('peminjaman_id'));

    if ($this->form_validation->run() === FALSE) {
      $this->create();
    } else {
      $data = array(
        'tgl_kembali'         => $this->input->post('tgl_kembali'),
        'peminjaman_id'       => $this->input->post('peminjaman_id'),
        'arsip_id'            => $this->input->post('arsip_id'),
        'user_id'             => $data_peminjaman->user_id,
        'instansi_id'         => $data_peminjaman->instansi_id,
        'cabang_id'           => $data_peminjaman->cabang_id,
        'divisi_id'           => $data_peminjaman->divisi_id,
        'created_by'          => $this->session->username,
      );

      $this->Pengembalian_model->insert($data);

      write_log();

      // mengganti status is_available arsip
      $this->db->where('id_arsip', $this->input->post('arsip_id'));
      $this->db->update('arsip', array('is_available' => '1'));

      write_log();

      // mengganti status is_kembali peminjaman arsip
      $this->db->where('arsip_id', $this->input->post('arsip_id'));
      $this->db->update('peminjaman', array('is_kembali' => '1'));

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data saved succesfully</div>');
      redirect('admin/pengembalian');
    }
  }

  function update($id)
  {
    is_update();

    $this->data['pengembalian']     = $this->Pengembalian_model->get_by_id($id);

    if ($this->data['pengembalian']) {
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/pengembalian/update_action';

      if (is_grandadmin()) {
        $this->data['get_all_combobox_user']                  = $this->Auth_model->get_all_combobox();
        $this->data['get_all_combobox_arsip_peminjaman']      = $this->Peminjaman_model->get_all_combobox_arsip_peminjaman();
      } elseif (is_masteradmin()) {
        $this->data['get_all_combobox_user']                  = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_arsip_peminjaman']      = $this->Peminjaman_model->get_all_combobox_arsip_peminjaman_by_instansi($this->session->instansi_id);
      } elseif (is_superadmin()) {
        $this->data['get_all_combobox_user']                  = $this->Auth_model->get_all_combobox_by_cabang($this->session->instansi_id);
        $this->data['get_all_combobox_arsip_peminjaman']      = $this->Peminjaman_model->get_all_combobox_arsip_peminjaman_by_cabang($this->session->cabang_id);
      } else {
        $this->data['get_all_combobox_arsip_peminjaman']      = $this->Peminjaman_model->get_all_combobox_arsip_peminjaman_by_divisi($this->session->divisi_id);
      }

      $this->data['id_pengembalian'] = [
        'name'          => 'id_pengembalian',
        'type'          => 'hidden',
      ];
      $this->data['tgl_kembali'] = [
        'name'          => 'tgl_kembali',
        'id'            => 'tgl_kembali',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['peminjaman_id'] = [
        'name'          => 'peminjaman_id',
        'id'            => 'peminjaman_id',
        'class'         => 'form-control',
        'required'      => '',
      ];
      $this->data['user_id'] = [
        'name'          => 'user_id',
        'id'            => 'user_id',
        'class'         => 'form-control',
        'required'      => '',
        'readonly'      => '',
      ];
      $this->data['instansi_id'] = [
        'name'          => 'instansi_id',
        'id'            => 'instansi_id',
        'class'         => 'form-control',
        'required'      => '',
        'readonly'      => '',
      ];
      $this->data['cabang_id'] = [
        'name'          => 'cabang_id',
        'id'            => 'cabang_id',
        'class'         => 'form-control',
        'required'      => '',
        'readonly'      => '',
      ];
      $this->data['divisi_id'] = [
        'name'          => 'divisi_id',
        'id'            => 'divisi_id',
        'class'         => 'form-control',
        'required'      => '',
        'readonly'      => '',
      ];

      $this->load->view('back/pengembalian/pengembalian_edit', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/pengembalian');
    }
  }

  function update_action()
  {
    $this->form_validation->set_rules('tgl_kembali', 'Tanggal Pengembalian', 'trim|required');
    // $this->form_validation->set_rules('arsip_id', 'Nama Arsip', 'trim|required');
    // $this->form_validation->set_rules('user_id', 'Nama Peminjam', 'trim|required');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    $this->db->select('
      id_peminjaman, peminjaman.arsip_id, peminjaman.user_id,
      users.id_users, users.name, users.divisi, users.instansi,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');
    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi');

    $this->db->where('id_peminjaman', $this->input->post('peminjaman_id'));

    $data_peminjaman = $this->db->get('peminjaman')->row();

    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_pengembalian'));
    } else {
      if ($this->input->post('peminjaman_id') == NULL) {
        $data = array(
          'tgl_kembali'         => $this->input->post('tgl_kembali'),
          'modified_by'         => $this->session->username,
        );

        $this->Pengembalian_model->update($this->input->post('id_pengembalian'), $data);

        write_log();
      } else {
        $data = array(
          'tgl_kembali'         => $this->input->post('tgl_kembali'),
          'arsip_id'            => $data_peminjaman->arsip_id,
          'user_id'             => $data_peminjaman->user_id,
          'instansi_id'         => $data_peminjaman->instansi_id,
          'cabang_id'           => $data_peminjaman->cabang_id,
          'divisi_id'           => $data_peminjaman->divisi_id,
          'modified_by'         => $this->session->username,
        );

        $this->Pengembalian_model->update($this->input->post('id_pengembalian'), $data);

        write_log();

        // ubah arsip baru menjadi dipinjam
        $this->db->where('id_arsip', $data_peminjaman->arsip_id);
        $this->db->update('arsip', array('is_available' => '0'));

        write_log();

        // ubah arsip lama / saat ini menjadi tersedia
        $this->db->where('id_arsip', $data_peminjaman->arsip_id);
        $this->db->update('arsip', array('is_available' => '1'));

        write_log();

        // mengganti status is_kembali peminjaman arsip
        $this->db->where('arsip_id', $data_peminjaman->arsip_id);
        $this->db->update('peminjaman', array('is_kembali' => '1'));

        write_log();
      }

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data saved succesfully</div>');
      redirect('admin/pengembalian');
    }
  }

  function delete($id)
  {
    is_delete();

    $delete = $this->Pengembalian_model->get_by_id($id);

    if ($delete) {
      $data = array(
        'is_delete_pengembalian'   => '1',
        'deleted_by'  => $this->session->username,
        'deleted_at'  => date('Y-m-d H:i:a'),
      );

      $this->Pengembalian_model->soft_delete($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus</div>');
      redirect('admin/pengembalian');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/pengembalian');
    }
  }

  function delete_permanent($id)
  {
    is_delete();

    $delete = $this->Pengembalian_model->get_by_id($id);

    if ($delete) {
      $this->Pengembalian_model->delete($id);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus secara permanen</div>');
      redirect('admin/pengembalian/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/pengembalian');
    }
  }

  function deleted_list()
  {
    is_restore();

    $this->data['page_title'] = 'Deleted ' . $this->data['module'] . ' List';

    if (is_grandadmin()) {
      $this->data['get_all_deleted'] = $this->Pengembalian_model->get_all_deleted();
    } elseif (is_masteradmin()) {
      $this->data['get_all_deleted'] = $this->Pengembalian_model->get_all_deleted_by_instansi();
    } elseif (is_superadmin()) {
      $this->data['get_all_deleted'] = $this->Pengembalian_model->get_all_deleted_by_cabang();
    } elseif (is_admin()) {
      $this->data['get_all_deleted'] = $this->Pengembalian_model->get_all_deleted_by_divisi();
    }

    $this->load->view('back/pengembalian/pengembalian_deleted_list', $this->data);
  }

  function restore($id)
  {
    is_restore();

    $row = $this->Pengembalian_model->get_by_id($id);

    if ($row) {
      $data = array(
        'is_delete_pengembalian'   => '0',
        'deleted_by'  => NULL,
        'deleted_at'  => NULL,
      );

      $this->Pengembalian_model->update($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data restored successfully</div>');
      redirect('admin/pengembalian/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">No data found</div>');
      redirect('admin/pengembalian');
    }
  }
}
