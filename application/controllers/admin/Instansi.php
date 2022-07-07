<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instansi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Instansi';

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
    $this->data['add_action'] = base_url('admin/instansi/create');

    is_login();
  }

  function index()
  {
    is_read();

    //TODO Authentikasi usertype
    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Inisialisasi variabel
    $this->data['page_title'] = 'Data ' . $this->data['module'];

    //TODO Get all data instansi
    $this->data['get_all'] = $this->Instansi_model->get_all();

    //TODO Load view dengan kirim data
    $this->load->view('back/instansi/instansi_list', $this->data);
  }

  function create()
  {
    is_create();

    //TODO Authentikasi usertype
    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Inisialisasi variabel
    $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
    $this->data['action']     = 'admin/instansi/create_action';

    //TODO Rancangan form
    $this->data['instansi_name'] = [
      'name'          => 'instansi_name',
      'id'            => 'instansi_name',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_name'),
    ];
    $this->data['instansi_address'] = [
      'name'          => 'instansi_address',
      'id'            => 'instansi_address',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_address'),
    ];
    $this->data['instansi_phone'] = [
      'name'          => 'instansi_phone',
      'id'            => 'instansi_phone',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_phone'),
    ];
    $this->data['active_date'] = [
      'name'          => 'active_date',
      'id'            => 'active_date',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('active_date'),
    ];

    //TODO Load view dengan kirim data
    $this->load->view('back/instansi/instansi_add', $this->data);
  }

  function create_action()
  {
    //TODO validasi form
    $this->form_validation->set_rules('instansi_name', 'Nama Instansi', 'trim|required');
    $this->form_validation->set_rules('instansi_phone', 'No. HP / Telpon', 'trim|required');
    $this->form_validation->set_rules('instansi_address', 'Alamat', 'trim|required');
    $this->form_validation->set_rules('active_date', 'Aktif Sampai', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    //TODO Kondisi data tidak lolos validasi
    if ($this->form_validation->run() === FALSE) {
      $this->create();
    } else {
      //TODO Kondisi data lolos validasi
      //TODO Kondisi user upload file foto/logo
      if ($_FILES['photo']['error'] <> 4) {
        //TODO Definisi nama file
        $nmfile = strtolower(url_title($this->input->post('instansi_name'))) . date('YmdHis');

        //TODO Konfigurasi library upload
        $config['upload_path']      = './assets/images/instansi/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048; // 2Mb
        $config['file_name']        = $nmfile;

        //TODO Import library upload
        $this->load->library('upload', $config);

        //TODO Kondisi file gagal diupload
        if (!$this->upload->do_upload('photo')) {
          //TODO Kirim notifikasi
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');

          $this->create();
        } else {
          //TODO Kondisi file berhasil diupload
          $photo = $this->upload->data();

          //TODO Konfigurasi library image_lib
          $config['image_library']    = 'gd2';
          $config['source_image']     = './assets/images/instansi/' . $photo['file_name'] . '';
          $config['create_thumb']     = TRUE;
          $config['maintain_ratio']   = TRUE;
          $config['width']            = 250;
          $config['height']           = 250;

          //TODO import library image_lib
          $this->load->library('image_lib', $config);
          //TODO Jalankan library image_lib
          $this->image_lib->resize();

          //TODO Tampung inputan form ke dalam variabel array
          $data = array(
            'instansi_name'       => $this->input->post('instansi_name'),
            'instansi_address'    => $this->input->post('instansi_address'),
            'instansi_phone'      => $this->input->post('instansi_phone'),
            'active_date'         => $this->input->post('active_date'),
            'is_active'           => '1',
            'instansi_img'        => $this->upload->data('file_name'),
            'instansi_img_thumb'  => $nmfile . '_thumb' . $this->upload->data('file_ext'),
            'created_by'          => $this->session->username,
          );

          //TODO Simpan data ke database
          $this->Instansi_model->insert($data);

          write_log();

          //TODO Kirim notifikasi data berhasil disimpan
          $this->session->set_flashdata('message', 'Sukses');
          redirect('admin/instansi');
        }
      } else {
        //TODO Tampung inputan form ke dalam variabel array
        $data = array(
          'instansi_name'       => $this->input->post('instansi_name'),
          'instansi_address'    => $this->input->post('instansi_address'),
          'instansi_phone'      => $this->input->post('instansi_phone'),
          'active_date'         => $this->input->post('active_date'),
          'is_active'           => '1',
          'created_by'          => $this->session->username,
        );

        //TODO Simpan data ke database
        $this->Instansi_model->insert($data);

        write_log();

        //TODO Kirim notifikasi data berhasil disimpan
        $this->session->set_flashdata('message', 'Sukses');
        redirect('admin/instansi');
      }
    }
  }

  function update($id)
  {
    is_update();

    //TODO Get data instansi by id
    $this->data['instansi']     = $this->Instansi_model->get_by_id($id);

    //TODO Authentikasi usertype
    if (is_superadmin() or is_masteradmin() && $this->data['instansi']->id_instansi != $this->session->instansi_id) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Kondisi data instansi ditemukan
    if ($this->data['instansi']) {
      //TODO Inisialisasi variabel
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/instansi/update_action';

      //TODO Rancangan form
      $this->data['id_instansi'] = [
        'name'          => 'id_instansi',
        'type'          => 'hidden',
      ];

      //TODO Jika grandadmin tampilkan form input instansi_name
      if (is_grandadmin()) {
        $this->data['instansi_name'] = [
          'name'          => 'instansi_name',
          'id'            => 'instansi_name',
          'class'         => 'form-control',
          'autocomplete'  => 'off',
          'required'      => '',
        ];
      }
      $this->data['instansi_address'] = [
        'name'          => 'instansi_address',
        'id'            => 'instansi_address',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['instansi_phone'] = [
        'name'          => 'instansi_phone',
        'id'            => 'instansi_phone',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['active_date'] = [
        'name'          => 'active_date',
        'id'            => 'active_date',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];

      //TODO Load view form update dengan kirim data
      $this->load->view('back/instansi/instansi_edit', $this->data);
    } else {
      //TODO Kirim notifikasi data tidak ditemukan
      $this->session->set_flashdata('message', 'tidak ditemukan');
      redirect('admin/instansi');
    }
  }

  function update_action()
  {
    //TODO Form validation
    if (is_grandadmin()) {
      $this->form_validation->set_rules('instansi_name', 'Nama Instansi', 'trim|required');
      $this->form_validation->set_rules('active_date', 'Masa Aktif', 'required');
    }
    $this->form_validation->set_rules('instansi_phone', 'No. HP / Telpon', 'trim|required');
    $this->form_validation->set_rules('instansi_address', 'Alamat', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    //TODO Perbandingan tanggal dari form dengan tgl sekarang
    if ($this->input->post('active_date') < date('Y-m-d')) {
      //TODO Kondisi status instansi tidak aktif
      $is_active = '0';
    } else {
      //TODO Kondisi status instansi aktif
      $is_active = '1';
    }

    //TODO Kondisi data form tidak lolos validasi
    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_instansi'));
    } else {
      //TODO Kondisi user upload file logo baru
      if ($_FILES['photo']['error'] <> 4) {
        //TODO Definisi penamaan file
        $nmfile = strtolower(url_title($this->input->post('instansi_name'))) . date('YmdHis');

        //TODO Konfigurasi library upload
        $config['upload_path']      = './assets/images/instansi/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048; // 2Mb
        $config['file_name']        = $nmfile;

        //TODO Import library upload
        $this->load->library('upload', $config);

        //TODO Ambil data instansi by id untuk hapus file lama di direktori
        $delete = $this->Instansi_model->get_by_id($this->input->post('id_instansi'));

        //TODO Definisi letak file di direktori project
        $dir        = "./assets/images/instansi/" . $delete->instansi_img;
        $dir_thumb  = "./assets/images/instansi/" . $delete->instansi_img_thumb;

        //TODO Cek apakah direktori ditemukan
        if (is_file($dir)) {
          //TODO Hapus file pada direktori
          unlink($dir);
          unlink($dir_thumb);
        }

        //TODO Kondisi gagal upload file
        if (!$this->upload->do_upload('photo')) {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');

          $this->update($this->input->post('id_instansi'));
        } else {
          //TODO Jalankan library upload
          $photo = $this->upload->data();

          //TODO Konfigurasi library image_lib
          $config['image_library']    = 'gd2';
          $config['source_image']     = './assets/images/instansi/' . $photo['file_name'] . '';
          $config['create_thumb']     = TRUE;
          $config['maintain_ratio']   = TRUE;
          $config['width']            = 250;
          $config['height']           = 250;

          //TODO Import library image_lib
          $this->load->library('image_lib', $config);
          //TODO Jalankan library image_lib
          $this->image_lib->resize();

          //TODO Jika Grandadmin
          if (is_grandadmin()) {
            //TODO Jika form active date diisi
            if ($this->input->post('active_date') != NULL) {
              $data = array(
                'instansi_name'       => $this->input->post('instansi_name'),
                'instansi_address'    => $this->input->post('instansi_address'),
                'instansi_phone'      => $this->input->post('instansi_phone'),
                'active_date'         => $this->input->post('active_date'),
                'is_active'           => $is_active,
                'instansi_img'        => $this->upload->data('file_name'),
                'instansi_img_thumb'  => $nmfile . '_thumb' . $this->upload->data('file_ext'),
                'modified_by'         => $this->session->username,
              );
            }
          } else {
            //TODO Jika selain Grandadmin
            if ($this->input->post('active_date') != NULL) {
              //TODO Jika active date diisi
              $data = array(
                'instansi_address'    => $this->input->post('instansi_address'),
                'instansi_phone'      => $this->input->post('instansi_phone'),
                'active_date'         => $this->input->post('active_date'),
                'is_active'           => $is_active,
                'instansi_img'        => $this->upload->data('file_name'),
                'instansi_img_thumb'  => $nmfile . '_thumb' . $this->upload->data('file_ext'),
                'modified_by'         => $this->session->username,
              );
            }
          }

          //TODO Jalankan proses update
          $this->Instansi_model->update($this->input->post('id_instansi'), $data);

          write_log();

          //TODO Kirim notifikasi data berhasil disimpan
          $this->session->set_flashdata('message', 'Sukses');

          //TODO Jika grandadmin maka redirect ke menu list instansi
          if (is_grandadmin()) {
            redirect('admin/instansi');
          } else {
            //TODO Jika selain grandadmin redirect ke menu form edit profile instansi
            redirect('admin/instansi/update/' . $this->session->instansi_id);
          }
        }
      } else {
        //TODO Jika User tidak upload file logo baru
        //TODO Jika Grandadmin
        if (is_grandadmin()) {
          //TODO Jika active date diisi
          if ($this->input->post('active_date') != NULL) {
            $data = array(
              'instansi_name'       => $this->input->post('instansi_name'),
              'instansi_address'    => $this->input->post('instansi_address'),
              'instansi_phone'      => $this->input->post('instansi_phone'),
              'active_date'         => $this->input->post('active_date'),
              'is_active'           => $is_active,
              'modified_by'         => $this->session->username,
            );
          }
        } else {
          //TODO Jika selain grandadmin
          //TODO Jika active date diisi
          if ($this->input->post('active_date') != NULL) {
            $data = array(
              'instansi_address'    => $this->input->post('instansi_address'),
              'instansi_phone'      => $this->input->post('instansi_phone'),
              'active_date'         => $this->input->post('active_date'),
              'is_active'           => $is_active,
              'modified_by'         => $this->session->username,
            );
          }
        }

        //TODO Jalankan proses update
        $this->Instansi_model->update($this->input->post('id_instansi'), $data);

        write_log();

        //TODO Kirim notifikasi data berhasil disimpan
        $this->session->set_flashdata('message', 'Sukses');

        //TODO Jika grandadmin maka redirect ke menu list instansi
        if (is_grandadmin()) {
          redirect('admin/instansi');
        } else {
          //TODO Jika selain grandadmin maka redirect ke menu form edit profile instansi
          redirect('admin/instansi/update/' . $this->session->instansi_id);
        }
      }
    }
  }

  function delete($id)
  {
    is_delete();

    //TODO Authentikasi hak akses usertype
    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Get data intansi by id
    $delete = $this->Instansi_model->get_by_id($id);

    //TODO Jika data instansi ditemukan
    if ($delete) {
      $data = array(
        'is_delete_instansi'    => '1',
        'deleted_by'            => $this->session->username,
        'deleted_at'            => date('Y-m-d H:i:a'),
      );

      //TODO Jalankan softdelete
      $this->Instansi_model->soft_delete($id, $data);

      write_log();

      //TODO Kirim notifikasi berhasil dihapus
      $this->session->set_flashdata('message', 'dihapus');
      redirect('admin/instansi');
    } else {
      //TODO Kirim notifikasi data instansi tidak ditemukan
      $this->session->set_flashdata('message', 'tidak ditemukan');
      redirect('admin/instansi');
    }
  }

  function delete_permanent($id)
  {
    is_delete();

    //TODO Authentikasi hak akses usertype
    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Get instansi by id
    $delete = $this->Instansi_model->get_by_id($id);

    //TODO Jika data instansi ditemukan
    if ($delete) {
      //TODO Jalankan proses hapus secara permanen
      $this->Instansi_model->delete($id);

      write_log();

      //TODO Kirim notifikasi data berhasil dihapus permanen
      $this->session->set_flashdata('message', 'dihapus');
      redirect('admin/instansi/deleted_list');
    } else {
      //TODO Kirim notifikasi data tidak ditemukan
      $this->session->set_flashdata('message', 'tidak ditemukan');
      redirect('admin/instansi');
    }
  }

  function deleted_list()
  {
    is_restore();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

    $this->data['get_all_deleted'] = $this->Instansi_model->get_all_deleted();

    $this->load->view('back/instansi/instansi_deleted_list', $this->data);
  }

  function restore($id)
  {
    is_restore();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $row = $this->Instansi_model->get_by_id($id);

    if ($row) {
      $data = array(
        'is_delete_instansi'   => '0',
        'deleted_by'        => NULL,
        'deleted_at'        => NULL,
      );

      $this->Instansi_model->update($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dikembalikan</div>');
      redirect('admin/instansi/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/instansi');
    }
  }
}
