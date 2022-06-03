<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Peminjaman';

    $this->load->model(array('Peminjaman_model', 'Pengembalian_model', 'Arsip_model'));

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
    $this->data['add_action'] = base_url('admin/peminjaman/create');

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
      $this->data['get_all'] = $this->Peminjaman_model->get_all();
    } elseif (is_masteradmin()) {
      $this->data['get_all'] = $this->Peminjaman_model->get_all_by_instansi();
    } elseif (is_superadmin()) {
      $this->data['get_all'] = $this->Peminjaman_model->get_all_by_cabang();
    } else {
      $this->data['get_all'] = $this->Peminjaman_model->get_all_by_divisi();
    }

    $this->load->view('back/peminjaman/peminjaman_list', $this->data);
  }

  function create()
  {
    is_create();

    $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
    $this->data['action']     = 'admin/peminjaman/create_action';

    if (is_grandadmin()) {
      $this->data['get_all_combobox_user']                = $this->Auth_model->get_all_combobox();
      $this->data['get_all_combobox_arsip_available']     = $this->Arsip_model->get_all_combobox_arsip_available();
      $this->data['get_all_combobox_instansi']            = $this->Instansi_model->get_all_combobox();
      $this->data['get_all_combobox_divisi']              = $this->Divisi_model->get_all_combobox();
    } elseif (is_masteradmin()) {
      $this->data['get_all_combobox_user']                = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_arsip_available']     = $this->Arsip_model->get_all_combobox_arsip_available_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_instansi']            = $this->Instansi_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_cabang']              = $this->Cabang_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_divisi']              = $this->Divisi_model->get_all_combobox_by_instansi($this->session->instansi_id);
    } elseif (is_superadmin()) {
      $this->data['get_all_combobox_user']                = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_arsip_available']     = $this->Arsip_model->get_all_combobox_arsip_available_by_cabang($this->session->cabang_id);
      $this->data['get_all_combobox_divisi']              = $this->Divisi_model->get_all_combobox_by_cabang($this->session->cabang_id);
    } elseif (is_admin()) {
      $this->data['get_all_combobox_user']                = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_arsip_available']     = $this->Arsip_model->get_all_combobox_arsip_available_by_divisi($this->session->divisi_id);
    }

    $this->data['tgl_peminjaman'] = [
      'name'          => 'tgl_peminjaman',
      'id'            => 'tgl_peminjaman',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('tgl_peminjaman'),
    ];
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
      'required'      => '',
    ];
    $this->data['user_id'] = [
      'name'          => 'user_id',
      'id'            => 'user_id',
      'class'         => 'form-control',
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
      'onChange'      => 'tampilDivisi()',
      'required'      => '',
    ];
    $this->data['divisi_id'] = [
      'name'          => 'divisi_id',
      'id'            => 'divisi_id',
      'class'         => 'form-control',
      'onChange'      => 'tampilArsip()',
      'required'      => '',
    ];

    $this->load->view('back/peminjaman/peminjaman_add', $this->data);
  }

  function create_action()
  {
    $this->form_validation->set_rules('tgl_peminjaman', 'Tanggal Peminjaman', 'trim|required');
    $this->form_validation->set_rules('tgl_kembali', 'Tanggal Pengembalian', 'trim|required');
    $this->form_validation->set_rules('arsip_id', 'Nama Arsip yang Dipinjam', 'trim|required');
    $this->form_validation->set_rules('user_id', 'Nama Peminjam', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    // $data_user = $this->Auth_model->get_by_id($this->input->post('user_id'));

    if (is_grandadmin()) {
      $instansi_id  = $this->input->post('instansi_id');
      $divisi_id    = $this->input->post('divisi_id');
      $cabang_id    = $this->input->post('cabang_id');
    } elseif (is_masteradmin()) {
      $instansi_id  = $this->session->instansi_id;
      $divisi_id    = $this->input->post('divisi_id');
      $cabang_id    = $this->input->post('cabang_id');
    } elseif (is_superadmin()) {
      $instansi_id  = $this->session->instansi_id;
      $cabang_id    = $this->session->cabang_id;
      $divisi_id    = $this->input->post('divisi_id');
    } elseif (is_admin()) {
      $instansi_id  = $this->session->instansi_id;
      $cabang_id    = $this->session->cabang_id;
      $divisi_id    = $this->session->divisi_id;
    }

    if ($this->form_validation->run() === FALSE) {
      $this->create();
    } else {
      $data = array(
        'tgl_peminjaman'    => $this->input->post('tgl_peminjaman'),
        'tgl_kembali'       => $this->input->post('tgl_kembali'),
        'arsip_id'          => $this->input->post('arsip_id'),
        'user_id'           => $this->input->post('user_id'),
        'instansi_id'       => $instansi_id,
        'cabang_id'         => $cabang_id,
        'divisi_id'         => $divisi_id,
        // 'instansi_id'       => $data_user->instansi_id,
        // 'cabang_id'         => $data_user->cabang_id,
        // 'divisi_id'         => $data_user->divisi_id,
        'created_by'        => $this->session->username,
      );

      $this->Peminjaman_model->insert($data);
      write_log();

      // mengganti status is_available arsip menjadi sedang dipinjam
      $this->db->where('id_arsip', $this->input->post('arsip_id'));
      $this->db->update('arsip', array('is_available' => '0'));

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');
      redirect('admin/peminjaman');
    }
  }

  function update($id)
  {
    is_update();

    $this->data['peminjaman']           = $this->Peminjaman_model->get_by_id($id);

    if ($this->data['peminjaman']) {
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/peminjaman/update_action';

      if (is_grandadmin()) {
        $this->data['get_all_combobox_user']                = $this->Auth_model->get_all_combobox();
        $this->data['get_all_combobox_arsip_available']     = $this->Arsip_model->get_all_combobox_arsip_available();
        $this->data['get_all_combobox_instansi']            = $this->Instansi_model->get_all_combobox();
        $this->data['get_all_combobox_divisi']              = $this->Divisi_model->get_all_combobox();
      } elseif (is_masteradmin()) {
        $this->data['get_all_combobox_user']                = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_arsip_available']     = $this->Arsip_model->get_all_combobox_arsip_available_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_instansi']            = $this->Instansi_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_cabang']              = $this->Cabang_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_divisi']              = $this->Divisi_model->get_all_combobox_by_instansi($this->session->instansi_id);
      } elseif (is_superadmin()) {
        $this->data['get_all_combobox_user']                = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_arsip_available']     = $this->Arsip_model->get_all_combobox_arsip_available_by_cabang($this->session->instansi_id);
        $this->data['get_all_combobox_divisi']              = $this->Divisi_model->get_all_combobox_by_cabang($this->session->cabang_id);
      } elseif (is_admin()) {
        $this->data['get_all_combobox_user']                = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_arsip_available']     = $this->Arsip_model->get_all_combobox_arsip_available_by_divisi($this->session->divisi_id);
      }

      $this->data['id_peminjaman'] = [
        'name'          => 'id_peminjaman',
        'type'          => 'hidden',
      ];
      $this->data['tgl_peminjaman'] = [
        'name'          => 'tgl_peminjaman',
        'id'            => 'tgl_peminjaman',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['tgl_kembali'] = [
        'name'          => 'tgl_kembali',
        'id'            => 'tgl_kembali',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['user_id'] = [
        'name'          => 'user_id',
        'id'            => 'user_id',
        'class'         => 'form-control',
      ];
      $this->data['new_arsip'] = [
        'name'          => 'new_arsip',
        'id'            => 'new_arsip',
        'class'         => 'form-control',
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
        'onChange'      => 'tampilDivisi()',
        'required'      => '',
      ];
      $this->data['divisi_id'] = [
        'name'          => 'divisi_id',
        'id'            => 'divisi_id',
        'class'         => 'form-control',
        'onChange'      => 'tampilArsip(); tampilUser();',
        'required'      => '',
      ];

      $this->load->view('back/peminjaman/peminjaman_edit', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/peminjaman');
    }
  }

  function update_action()
  {
    $this->form_validation->set_rules('tgl_peminjaman', 'Tanggal Peminjaman', 'trim|required');
    $this->form_validation->set_rules('tgl_kembali', 'Tanggal Pengembalian', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    $data_user = $this->Auth_model->get_by_id($this->input->post('user_id'));

    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_peminjaman'));
    } else {
      // jika nilai arsip baru tidak diisi, maka isikan dengan nilai dari current arsip
      if ($this->input->post('new_arsip') == NULL) {
        // echo "ARSIP BARU KOSONG";

        $data = array(
          'tgl_peminjaman'    => $this->input->post('tgl_peminjaman'),
          'tgl_kembali'       => $this->input->post('tgl_kembali'),
          'modified_by'       => $this->session->username,
        );
      }
      // tapi jika nilai arsip baru diisi maka masukkan nilai new_arsip
      else {
        $data = array(
          'tgl_peminjaman'    => $this->input->post('tgl_peminjaman'),
          'user_id'           => $this->input->post('user_id'),
          'arsip_id'          => $this->input->post('new_arsip'),
          'instansi_id'       => $data_user->instansi_id,
          'cabang_id'         => $data_user->cabang_id,
          'divisi_id'         => $data_user->divisi_id,
          'modified_by'       => $this->session->username,
        );

        // ubah arsip baru menjadi dipinjam
        $this->db->where('id_arsip', $this->input->post('new_arsip'));
        $this->db->update('arsip', array('is_available' => '0'));

        write_log();

        // ubah arsip lama / saat ini menjadi tersedia
        $this->db->where('id_arsip', $this->input->post('current_arsip'));
        $this->db->update('arsip', array('is_available' => '1'));

        write_log();
      }

      $this->Peminjaman_model->update($this->input->post('id_peminjaman'), $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');
      redirect('admin/peminjaman');
    }
  }

  function delete($id)
  {
    is_delete();

    $delete = $this->Peminjaman_model->get_by_id($id);

    if ($delete) {
      $data = array(
        'is_delete_peminjaman'   => '1',
        'deleted_by'  => $this->session->username,
        'deleted_at'  => date('Y-m-d H:i:a'),
      );

      $this->Peminjaman_model->soft_delete($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus</div>');
      redirect('admin/peminjaman');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/peminjaman');
    }
  }

  function delete_permanent($id)
  {
    is_delete();

    $delete = $this->Peminjaman_model->get_by_id($id);

    if ($delete) {
      $data = array(
        'is_available'   => '1',
      );

      $this->Arsip_model->set_available($id, $data);

      $this->Peminjaman_model->delete($id);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus secara permanen</div>');
      redirect('admin/peminjaman/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Tidak ada data yang ditemukan</div>');
      redirect('admin/peminjaman');
    }
  }

  function deleted_list()
  {
    is_restore();

    $this->data['page_title'] = 'Deleted ' . $this->data['module'] . ' List';

    if (is_grandadmin()) {
      $this->data['get_all_deleted'] = $this->Peminjaman_model->get_all_deleted();
    } elseif (is_masteradmin()) {
      $this->data['get_all_deleted'] = $this->Peminjaman_model->get_all_deleted_by_instansi();
    } elseif (is_superadmin()) {
      $this->data['get_all_deleted'] = $this->Peminjaman_model->get_all_deleted_by_cabang();
    } elseif (is_admin()) {
      $this->data['get_all_deleted'] = $this->Peminjaman_model->get_all_deleted_by_divisi();
    }

    $this->load->view('back/peminjaman/peminjaman_deleted_list', $this->data);
  }

  function restore($id)
  {
    is_restore();

    $row = $this->Peminjaman_model->get_by_id($id);

    if ($row) {
      $data = array(
        'is_delete_peminjaman'   => '0',
        'deleted_by'  => NULL,
        'deleted_at'  => NULL,
      );

      $this->Peminjaman_model->update($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data restored successfully</div>');
      redirect('admin/peminjaman/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">No data found</div>');
      redirect('admin/peminjaman');
    }
  }

  function set_kembali($id)
  {
    $row = $this->Peminjaman_model->get_by_id($id);

    if ($row) {
      if ($row->is_kembali == '1') {
        $this->session->set_flashdata('message', '<div class="alert alert-success">Arsip Telah Dikembalikan</div>');
        redirect('admin/pengembalian');
      } else {
        $data_peminjaman = array(
          'is_kembali'    => '1',
        );

        $this->Peminjaman_model->update($id, $data_peminjaman);

        write_log();

        // mengganti status is_available arsip
        $this->db->where('id_arsip', $row->arsip_id);
        $this->db->update('arsip', array('is_available' => '1'));

        write_log();

        $data_pengembalian = array(
          'tgl_kembali'   => date('Y-m-d'),
          'peminjaman_id' => $id,
          'arsip_id'      => $row->arsip_id,
          'user_id'       => $row->user_id,
          'instansi_id'   => $row->instansi_id,
          'cabang_id'     => $row->cabang_id,
          'divisi_id'     => $row->divisi_id,
          'created_by'    => $this->session->username,
        );

        $this->Pengembalian_model->insert($data_pengembalian);

        write_log();

        $this->session->set_flashdata('message', '<div class="alert alert-success">Arsip Telah Dikembalikan</div>');
        redirect('admin/pengembalian');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">No data found</div>');
      redirect('admin/peminjaman');
    }
  }

  // function choose_arsip_dipinjam()
  // {
  //   $this->data['arsip']  = $this->Peminjaman_model->get_all_combobox_peminjaman($this->uri->segment(4));
  //   $this->load->view('back/peminjaman/form_arsip', $this->data);
  // }

  function get_cabang_divisi_instansi_by_user($user_id = '')
  {
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi');
    $this->db->join('cabang', 'users.cabang_id = cabang.id_cabang');
    $this->db->join('divisi', 'users.divisi_id = divisi.id_divisi');

    $data_user = $this->db->get_where('users', array('id_users' => $user_id, 'is_delete' => '0'));

    if ($data_user->num_rows() != 0) {
      $output['success'] = 1;

      $output['instansi_name']  = $data_user->row()->instansi_name;
      $output['cabang_name']    = $data_user->row()->cabang_name;
      $output['divisi_name']    = $data_user->row()->divisi_name;
    } else {
      $output['success'] = 0;
    }

    echo json_encode($output);
  }

  function get_peminjaman($peminjaman_id = '')
  {
    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi');

    $data = $this->db->get_where('peminjaman', array('id_peminjaman' => $peminjaman_id, 'is_kembali' => 0));

    if ($data->num_rows() != 0) {
      $output['success'] = 1;

      $output['arsip_id']       = $data->row()->arsip_id;
      $output['name']           = $data->row()->name;
      $output['divisi_name']    = $data->row()->divisi_name;
      $output['cabang_name']    = $data->row()->cabang_name;
      $output['instansi_name']  = $data->row()->instansi_name;
    } else {
      $output['success'] = 0;
    }

    echo json_encode($output);
  }

  function get_divisi_by_peminjam()
  {
    $this->data['divisi']  = $this->Divisi_model->get_all_combobox_by_user($this->uri->segment(4));
    $this->load->view('back/peminjaman/form_divisi', $this->data);
  }
}
