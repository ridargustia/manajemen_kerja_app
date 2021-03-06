<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'User';

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
    $this->data['add_action'] = base_url('admin/auth/create');

    is_login();
  }

  function index()
  {
    is_read();

    //TODO Authentikasi hak akses usertype
    if (is_superadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Inisialisasi variabel
    $this->data['page_title'] = 'Data ' . $this->data['module'];

    //TODO Get data user berdasarkan usertype
    if (is_grandadmin()) {
      $this->data['get_all'] = $this->Auth_model->get_all();
    } elseif (is_masteradmin()) {
      $this->data['get_all'] = $this->Auth_model->get_all_by_instansi();
    }

    //TODO Load view dengan kirim data
    $this->load->view('back/auth/user_list', $this->data);
  }

  function create()
  {
    is_create();

    //TODO Authentikasi hak akses usertype
    if (is_superadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Get value combobox berdasarkan usertype
    if (is_grandadmin()) {
      $this->data['get_all_combobox_instansi']     = $this->Instansi_model->get_all_combobox();
      $this->data['get_all_combobox_usertype']     = $this->Usertype_model->get_all_combobox();
    } elseif (is_masteradmin()) {
      $this->data['get_all_combobox_divisi']       = $this->Divisi_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_usertype']     = $this->Usertype_model->get_all_combobox_by_instansi();
    }

    //TODO Get data access dari database
    $this->data['get_all_data_access']            = $this->Dataaccess_model->get_all();

    //TODO Inisialisasi variabel
    $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
    $this->data['action']     = 'admin/auth/create_action';

    //TODO Rancangan form
    $this->data['name'] = [
      'name'          => 'name',
      'id'            => 'name',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('name'),
    ];
    $this->data['gender'] = [
      'name'          => 'gender',
      'id'            => 'gender',
      'class'         => 'form-control',
    ];
    $this->data['gender_value'] = [
      ''              => '- Pilih Jenis Kelamin -',
      '1'             => 'Laki-laki',
      '2'             => 'Perempuan',
    ];
    $this->data['birthplace'] = [
      'name'          => 'birthplace',
      'id'            => 'birthplace',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'value'         => $this->form_validation->set_value('birthplace'),
    ];
    $this->data['birthdate'] = [
      'name'          => 'birthdate',
      'id'            => 'birthdate',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'value'         => $this->form_validation->set_value('birthdate'),
    ];
    $this->data['phone'] = [
      'name'          => 'phone',
      'id'            => 'phone',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'value'         => $this->form_validation->set_value('phone'),
    ];
    $this->data['address'] = [
      'name'          => 'address',
      'id'            => 'address',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'rows'          => '2',
      'value'         => $this->form_validation->set_value('address'),
    ];
    $this->data['username'] = [
      'name'          => 'username',
      'id'            => 'username',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'onChange'      => 'checkUsername()',
      'required'      => '',
      'value'         => $this->form_validation->set_value('username'),
    ];
    $this->data['email'] = [
      'name'          => 'email',
      'id'            => 'email',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'onChange'      => 'checkEmail()',
      'required'      => '',
      'value'         => $this->form_validation->set_value('email'),
    ];
    $this->data['password'] = [
      'name'          => 'password',
      'id'            => 'password',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('password'),
    ];
    $this->data['password_confirm'] = [
      'name'          => 'password_confirm',
      'id'            => 'password_confirm',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('password_confirm'),
    ];
    $this->data['instansi_id'] = [
      'name'          => 'instansi_id',
      'id'            => 'instansi_id',
      'class'         => 'form-control',
      'onChange'      => 'tampilDivisi()',
      'required'      => '',
    ];
    $this->data['divisi_id'] = [
      'name'          => 'divisi_id',
      'id'            => 'divisi_id',
      'class'         => 'form-control',
      'required'      => '',
    ];
    $this->data['usertype_id'] = [
      'name'          => 'usertype_id',
      'id'            => 'usertype_id',
      'class'         => 'form-control',
      'required'      => '',
    ];

    //TODO Load View dengan kirim data
    $this->load->view('back/auth/user_add', $this->data);
  }

  function create_action()
  {
    //TODO Proses Validasi
    $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required');
    $this->form_validation->set_rules('phone', 'No. HP', 'trim|is_numeric');
    $this->form_validation->set_rules('username', 'Username', 'trim|is_unique[users.username]|required');
    $this->form_validation->set_rules('email', 'Email', 'valid_email|is_unique[users.email]|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]|required');
    $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'trim|matches[password]|required');
    $this->form_validation->set_rules('divisi_id', 'Divisi', 'required');
    $this->form_validation->set_rules('usertype_id', 'Usertype', 'required');
    $this->form_validation->set_rules('data_access_id[]', 'Data Access', 'required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('is_numeric', '{field} harus angka');
    $this->form_validation->set_message('min_length', '{field} minimal 8 huruf/karakter');
    $this->form_validation->set_message('is_unique', '{field} telah ada, silahkan ganti yang lain');
    $this->form_validation->set_message('matches', '{field} harus sama');
    $this->form_validation->set_message('valid_email', '{field} format email tidak benar');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    //TODO Input data instansi dan divisi berdasarkan usertype
    if (is_grandadmin()) {
      $instansi_id  = $this->input->post('instansi_id');
      $divisi_id    = $this->input->post('divisi_id');
    } elseif (is_masteradmin()) {
      $instansi_id  = $this->session->userdata('instansi_id');
      $divisi_id    = $this->input->post('divisi_id');
    }

    //TODO Pengkondisian hasil validasi
    if ($this->form_validation->run() === FALSE) {
      $this->create();
    } else {
      //TODO Enkripsi password
      $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

      //TODO Kondisi tgl lahir tidak memiliki value
      if ($this->input->post('birthdate') === '') {
        $birthdate = NULL;
      } else {
        $birthdate = $this->input->post('birthdate');
      }

      //TODO Kondisi terdapat inputan foto
      if ($_FILES['photo']['error'] <> 4) {
        //TODO Penamaan file foto
        $nmfile = strtolower(url_title($this->input->post('username'))) . date('YmdHis');

        //TODO Konfigurasi library upload foto
        $config['upload_path']      = './assets/images/user/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048; // 2Mb
        $config['file_name']        = $nmfile;

        //TODO Import library upload
        $this->load->library('upload', $config);

        //TODO kondisi Gagal upload (ERROR)
        if (!$this->upload->do_upload('photo')) {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');
          //TODO Redirect ke form create
          $this->create();
        } else {
          //TODO Kondisi berhasil upload foto
          $photo = $this->upload->data();

          //TODO Konfigurasi library image_lib untuk resize foto
          $config['image_library']    = 'gd2';
          $config['source_image']     = './assets/images/user/' . $photo['file_name'] . '';
          $config['create_thumb']     = TRUE;
          $config['maintain_ratio']   = TRUE;
          $config['width']            = 250;
          $config['height']           = 250;

          //TODO import library
          $this->load->library('image_lib', $config);
          //TODO Eksekusi library
          $this->image_lib->resize();

          //TODO Data inputan dikelompokkan pada variabel array
          $data = array(
            'name'              => $this->input->post('name'),
            'gender'            => $this->input->post('gender'),
            'birthplace'        => $this->input->post('birthplace'),
            'birthdate'         => $birthdate,
            'phone'             => $this->input->post('phone'),
            'address'           => $this->input->post('address'),
            'username'          => strtolower($this->input->post('username')),
            'email'             => $this->input->post('email'),
            'password'          => $password,
            'instansi_id'       => $instansi_id,
            'divisi_id'         => $divisi_id,
            'jabatan_id'        => $this->input->post('usertype_id'),
            'usertype_id'       => $this->input->post('usertype_id'),
            'created_by'        => $this->session->username,
            'ip_add_reg'        => $this->input->ip_address(),
            'photo'             => $this->upload->data('file_name'),
            'photo_thumb'       => $nmfile . '_thumb' . $this->upload->data('file_ext'),
          );

          //TODO Simpan ke database
          $this->Auth_model->insert($data);
          //TODO Ambil id dari data yang baru saja disimpan ke database
          $user_id = $this->db->insert_id();

          write_log();

          //TODO Simpan data_access_id dalam bentuk array ke database
          if (!empty($this->input->post('data_access_id'))) {
            $data_access_id = count($this->input->post('data_access_id'));

            for ($i_data_access_id = 0; $i_data_access_id < $data_access_id; $i_data_access_id++) {
              $datas_data_access_id[$i_data_access_id] = array(
                'user_id'           => $user_id,
                'data_access_id'    => $this->input->post('data_access_id[' . $i_data_access_id . ']'),
              );

              $this->db->insert('users_data_access', $datas_data_access_id[$i_data_access_id]);

              write_log();
            }
          }

          //TODO kirim notifikasi
          $this->session->set_flashdata('message', 'Sukses');
          redirect('admin/auth');
        }
      } else {
        //TODO Data inputan dikelompokkan pada variabel array
        $data = array(
          'name'              => $this->input->post('name'),
          'gender'            => $this->input->post('gender'),
          'birthplace'        => $this->input->post('birthplace'),
          'birthdate'         => $birthdate,
          'phone'             => $this->input->post('phone'),
          'address'           => $this->input->post('address'),
          'username'          => strtolower($this->input->post('username')),
          'email'             => $this->input->post('email'),
          'password'          => $password,
          'instansi_id'       => $instansi_id,
          'divisi_id'         => $divisi_id,
          'jabatan_id'        => $this->input->post('usertype_id'),
          'usertype_id'       => $this->input->post('usertype_id'),
          'created_by'        => $this->session->username,
          'ip_add_reg'        => $this->input->ip_address(),
        );

        //TODO Simpan ke database
        $this->Auth_model->insert($data);
        //TODO Ambil id dari data yang baru saja disimpan ke database
        $user_id = $this->db->insert_id();

        write_log();

        //TODO Simpan data_access_id dalam bentuk array ke database
        if (!empty($this->input->post('data_access_id'))) {
          $data_access_id = count($this->input->post('data_access_id'));

          for ($i_data_access_id = 0; $i_data_access_id < $data_access_id; $i_data_access_id++) {
            $datas_data_access_id[$i_data_access_id] = array(
              'user_id'           => $user_id,
              'data_access_id'    => $this->input->post('data_access_id[' . $i_data_access_id . ']'),
            );

            $this->db->insert('users_data_access', $datas_data_access_id[$i_data_access_id]);

            write_log();
          }
        }

        //TODO kirim notifikasi
        $this->session->set_flashdata('message', 'Sukses');
        redirect('admin/auth');
      }
    }
  }

  function update($id)
  {
    is_update();

    //TODO Get data user by id
    $this->data['user']     = $this->Auth_model->get_by_id($id);
    $user                   = $this->data['user'];

    //TODO superadmin tidak memiliki akses
    if (is_superadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Kondisi masteradmin dan data instansi dari user (yg akan di edit) berbeda dengan data instansi dari akun yang sedang login, maka tidak memiliki hak akses
    if (is_masteradmin() && $user->instansi_id != $this->session->instansi_id) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/auth');
    }

    //TODO Get value combobox for form
    if (is_grandadmin()) {
      $this->data['get_all_combobox_usertype']     = $this->Usertype_model->get_all_combobox();
      $this->data['get_all_combobox_instansi']     = $this->Instansi_model->get_all_combobox();
      $this->data['get_all_combobox_divisi']       = $this->Divisi_model->get_all_combobox_update($this->data['user']->instansi_id);
    } elseif (is_masteradmin()) {
      $this->data['get_all_combobox_divisi']       = $this->Divisi_model->get_all_combobox_by_instansi($this->data['user']->instansi_id);
      $this->data['get_all_combobox_usertype']     = $this->Usertype_model->get_all_combobox_by_instansi();
    }

    $this->data['get_all_data_access']            = $this->Dataaccess_model->get_all();

    //TODO Inisialisasi Variabel
    $this->data['page_title'] = 'Update Data ' . $this->data['module'];
    $this->data['action']     = 'admin/auth/update_action';

    //TODO Kondisi user tersedia
    if ($this->data['user']) {
      //TODO Rancangan Form
      $this->data['id_users'] = [
        'name'          => 'id_users',
        'type'          => 'hidden',
      ];
      $this->data['name'] = [
        'name'          => 'name',
        'id'            => 'name',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['gender'] = [
        'name'          => 'gender',
        'id'            => 'gender',
        'class'         => 'form-control',
      ];
      $this->data['gender_value'] = [
        ''              => '- Pilih Jenis Kelamin -',
        '1'             => 'Laki-laki',
        '2'             => 'Perempuan',
      ];
      $this->data['birthplace'] = [
        'name'          => 'birthplace',
        'id'            => 'birthplace',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['birthdate'] = [
        'name'          => 'birthdate',
        'id'            => 'birthdate',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['phone'] = [
        'name'          => 'phone',
        'id'            => 'phone',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['address'] = [
        'name'          => 'address',
        'id'            => 'address',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'rows'           => '2',
      ];
      $this->data['username'] = [
        'name'          => 'username',
        'id'            => 'username',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['email'] = [
        'name'          => 'email',
        'id'            => 'email',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['instansi_id'] = [
        'name'          => 'instansi_id',
        'id'            => 'instansi_id',
        'class'         => 'form-control',
        'onChange'      => 'tampilDivisi()',
        'required'      => '',
      ];
      $this->data['divisi_id'] = [
        'name'          => 'divisi_id',
        'id'            => 'divisi_id',
        'class'         => 'form-control',
        'required'      => '',
      ];
      $this->data['usertype_id'] = [
        'name'          => 'usertype_id',
        'id'            => 'usertype_id',
        'class'         => 'form-control',
        'required'      => '',
      ];

      //TODO Load view dengan kirim data
      $this->load->view('back/auth/user_edit', $this->data);
    } else {
      //TODO Kondisi data tidak ditemukan
      $this->session->set_flashdata('message', 'tidak ditemukan');
      redirect('admin/auth');
    }
  }

  function update_action()
  {
    //TODO validasi data inputan user
    $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required');
    $this->form_validation->set_rules('phone', 'No. HP/Telepon', 'trim|is_numeric');
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'valid_email|required');
    $this->form_validation->set_rules('divisi_id', 'Divisi', 'required');
    $this->form_validation->set_rules('usertype_id', 'Usertype', 'required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('is_numeric', '{field} harus angka');
    $this->form_validation->set_message('valid_email', '{field} format email tidak benar');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    //TODO Pengecekan form validasi
    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_users'));
    } else {
      //TODO Inisialisasi variabel berdasarkan usertype
      if (is_grandadmin()) {
        $instansi_id  = $this->input->post('instansi_id');
        $divisi_id    = $this->input->post('divisi_id');
      } elseif (is_masteradmin()) {
        $instansi_id  = $this->session->userdata('instansi_id');
        $divisi_id    = $this->input->post('divisi_id');
      }

      //TODO Kondisi tgl lahir tidak memiliki value
      if ($this->input->post('birthdate') === '') {
        $birthdate = NULL;
      } else {
        $birthdate = $this->input->post('birthdate');
      }

      //TODO Kondisi form photo berisi value
      if ($_FILES['photo']['error'] <> 4) {
        //TODO Penamaan file foto
        $nmfile = strtolower(url_title($this->input->post('username'))) . date('YmdHis');

        //TODO Konfigurasi library upload foto
        $config['upload_path']      = './assets/images/user/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048; // 2Mb
        $config['file_name']        = $nmfile;

        //TODO Import library upload
        $this->load->library('upload', $config);

        //TODO Get data user by id untuk mengambil nama photo dari database by id users
        $delete = $this->Auth_model->get_by_id($this->input->post('id_users'));

        //TODO Definisi direktori letak foto disimpan pada folder project
        $dir        = "./assets/images/user/" . $delete->photo;
        $dir_thumb  = "./assets/images/user/" . $delete->photo_thumb;

        //TODO Proses hapus file foto (current) pada direktori project sebelum upload photo baru
        if (is_file($dir)) {
          unlink($dir);
          unlink($dir_thumb);
        }

        //TODO kondisi Gagal upload (ERROR)
        if (!$this->upload->do_upload('photo')) {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');
          //TODO Redirect ke form update
          $this->update($this->input->post('id_users'));
        } else {
          //TODO Kondisi berhasil upload foto
          $photo = $this->upload->data();

          //TODO Konfigurasi library image_lib untuk resize foto
          $config['image_library']    = 'gd2';
          $config['source_image']     = './assets/images/user/' . $photo['file_name'] . '';
          $config['create_thumb']     = TRUE;
          $config['maintain_ratio']   = TRUE;
          $config['width']            = 250;
          $config['height']           = 250;

          //TODO import library
          $this->load->library('image_lib', $config);
          //TODO Eksekusi library
          $this->image_lib->resize();

          //TODO Data inputan dikelompokkan pada variabel array
          $data = array(
            'name'              => $this->input->post('name'),
            'gender'            => $this->input->post('gender'),
            'birthplace'        => $this->input->post('birthplace'),
            'birthdate'         => $birthdate,
            'phone'             => $this->input->post('phone'),
            'address'           => $this->input->post('address'),
            'username'          => strtolower($this->input->post('username')),
            'email'             => $this->input->post('email'),
            'instansi_id'       => $instansi_id,
            'divisi_id'         => $divisi_id,
            'jabatan_id'        => $this->input->post('usertype_id'),
            'usertype_id'       => $this->input->post('usertype_id'),
            'modified_by'       => $this->session->username,
            'photo'             => $this->upload->data('file_name'),
            'photo_thumb'       => $nmfile . '_thumb' . $this->upload->data('file_ext'),
          );

          //TODO Simpan data baru ke database by id users
          $this->Auth_model->update($this->input->post('id_users'), $data);

          write_log();

          //TODO Simpan data access baru dan hapus data access lama
          if (!empty($this->input->post('data_access_id'))) {
            $this->db->where('user_id', $this->input->post('id_users'));
            $this->db->delete('users_data_access');

            $data_access_id = count($this->input->post('data_access_id'));

            for ($i_data_access_id = 0; $i_data_access_id < $data_access_id; $i_data_access_id++) {
              $datas_data_access_id[$i_data_access_id] = array(
                'user_id'           => $this->input->post('id_users'),
                'data_access_id'    => $this->input->post('data_access_id[' . $i_data_access_id . ']'),
              );

              $this->db->insert('users_data_access', $datas_data_access_id[$i_data_access_id]);

              write_log();
            }
          }

          //TODO kirim notifikasi
          $this->session->set_flashdata('message', 'Sukses');
          redirect('admin/auth');
        }
      } else {
        //TODO Data inputan dikelompokkan pada variabel array
        $data = array(
          'name'              => $this->input->post('name'),
          'gender'            => $this->input->post('gender'),
          'birthplace'        => $this->input->post('birthplace'),
          'birthdate'         => $birthdate,
          'phone'             => $this->input->post('phone'),
          'address'           => $this->input->post('address'),
          'username'          => strtolower($this->input->post('username')),
          'email'             => $this->input->post('email'),
          'instansi_id'       => $instansi_id,
          'divisi_id'         => $divisi_id,
          'jabatan_id'        => $this->input->post('usertype_id'),
          'usertype_id'       => $this->input->post('usertype_id'),
          'modified_by'       => $this->session->username,
        );

        //TODO Simpan data baru ke database by id users
        $this->Auth_model->update($this->input->post('id_users'), $data);

        write_log();

        //TODO Simpan data access baru dan hapus data access lama
        if (!empty($this->input->post('data_access_id'))) {
          $this->db->where('user_id', $this->input->post('id_users'));
          $this->db->delete('users_data_access');

          $data_access_id = count($this->input->post('data_access_id'));

          for ($i_data_access_id = 0; $i_data_access_id < $data_access_id; $i_data_access_id++) {
            $datas_data_access_id[$i_data_access_id] = array(
              'user_id'           => $this->input->post('id_users'),
              'data_access_id'    => $this->input->post('data_access_id[' . $i_data_access_id . ']'),
            );

            $this->db->insert('users_data_access', $datas_data_access_id[$i_data_access_id]);

            write_log();
          }
        }

        //TODO kirim notifikasi
        $this->session->set_flashdata('message', 'Sukses');
        redirect('admin/auth');
      }
    }
  }

  function delete($id)
  {
    is_delete();

    //TODO Authentikasi usertype
    if (is_superadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Get data users by id
    $delete = $this->Auth_model->get_by_id($id);

    //TODO Kondisi data users ditemukan
    if ($delete) {
      //TODO Data yang akan diubah kelompokkan dalam array
      $data = array(
        'is_delete'   => '1',
        'is_active'   => '0',
        'deleted_by'  => $this->session->username,
        'deleted_at'  => date('Y-m-d H:i:a'),
      );

      //TODO eksekusi soft delete data user
      $this->Auth_model->soft_delete($id, $data);

      write_log();

      //TODO Kirim notifikasi berhasil dihapus
      $this->session->set_flashdata('message', 'dihapus');
      redirect('admin/auth');
    } else {
      //TODO Kirim notifikasi data tidak ditemukan pada database
      $this->session->set_flashdata('message', 'tidak ditemukan');
      redirect('admin/auth');
    }
  }

  function delete_permanent($id)
  {
    is_delete();

    //TODO Authentikasi usertype
    if (is_superadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Get data users by id
    $delete = $this->Auth_model->get_by_id($id);

    //TODO Kondisi user ditemukan
    if ($delete) {
      //TODO Definisikan direktori tempat file foto disimpan
      $dir        = "./assets/images/user/" . $delete->photo;
      $dir_thumb  = "./assets/images/user/" . $delete->photo_thumb;

      //TODO Proses hapus file foto di direktori project
      if (is_file($dir)) {
        unlink($dir);
        unlink($dir_thumb);
      }

      //TODO Eksekusi proses hapus data user secara permanen
      $this->Auth_model->delete($id);

      //TODO Kirim notifikasi berhasil dihapus
      $this->session->set_flashdata('message', 'dihapus');
      redirect('admin/auth/deleted_list');
    } else {
      //TODO Kirim notifikasi data tidak ditemukan
      $this->session->set_flashdata('message', 'tidak ditemukan');
      redirect('admin/auth');
    }
  }

  function deleted_list()
  {
    is_restore();

    //TODO Authentikasi usertype
    if (is_superadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Inisialisasi variabel
    $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

    //TODO Get data user yang telah dihapus berdasarkan usertype
    if (is_grandadmin()) {
      $this->data['get_all_deleted'] = $this->Auth_model->get_all_deleted();
    } elseif (is_masteradmin()) {
      $this->data['get_all_deleted'] = $this->Auth_model->get_all_deleted_by_instansi();
    }

    //TODO Load view dengan kirim data
    $this->load->view('back/auth/user_deleted_list', $this->data);
  }

  function restore($id)
  {
    is_restore();

    //TODO Authentikasi usertype
    if (is_superadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Get data user by id
    $row = $this->Auth_model->get_by_id($id);

    //TODO Kondisi data user ditemukan
    if ($row) {
      //TODO Tampung data yang akan diedit dalam array
      $data = array(
        'is_delete'   => '0',
        'is_active'   => '1',
        'deleted_by'  => NULL,
        'deleted_at'  => NULL,
      );

      //TODO eksekusi proses update data berdasarkan id
      $this->Auth_model->update($id, $data);

      //TODO Kirim notifikasi berhasil dikembalikan
      $this->session->set_flashdata('message', 'dikembalikan');
      redirect('admin/auth/deleted_list');
    } else {
      //TODO kirim notifikasi data tidak ditemukan
      $this->session->set_flashdata('message', 'tidak ditemukan');
      redirect('admin/auth');
    }
  }

  function activate($id)
  {
    //TODO Authentikasi usertype
    if (is_superadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Proses update data is active
    $this->Auth_model->update($this->uri->segment('4'), array('is_active' => '1'));

    //TODO kirim notifikasi berhasil diaktifkan
    $this->session->set_flashdata('message', 'diaktifkan');
    redirect('admin/auth');
  }

  function deactivate($id)
  {
    //TODO Authentikasi usertype
    if (is_superadmin()) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Proses update data is active
    $this->Auth_model->update($this->uri->segment('4'), array('is_active' => '0'));

    //TODO Kirim notifikasi data dinonaktifkan
    $this->session->set_flashdata('message', 'dinonaktifkan');
    redirect('admin/auth');
  }

  function update_profile($id)
  {
    //TODO Get data user by id
    $this->data['user']     = $this->Auth_model->get_by_id($id);

    //TODO Authentikasi id user
    if ($id != $this->session->id_users) {
      $this->session->set_flashdata('message', 'tidak memiliki akses');
      redirect('admin/dashboard');
    }

    //TODO Kondisi user ditemukan
    if ($this->data['user']) {
      //TODO Inisialisasi variabel
      $this->data['page_title'] = 'Update Profile';
      $this->data['action']     = 'admin/auth/update_profile_action';

      //TODO Get data access yang dimiliki user tsb
      $this->data['get_all_data_access_old']        = $this->Dataaccess_model->get_all_data_access_old($id);

      //TODO Rancangan form
      $this->data['id_users'] = [
        'name'          => 'id_users',
        'type'          => 'hidden',
      ];
      $this->data['name'] = [
        'name'          => 'name',
        'id'            => 'name',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['gender'] = [
        'name'          => 'gender',
        'id'            => 'gender',
        'class'         => 'form-control',
      ];
      $this->data['gender_value'] = [
        ''              => '- Pilih Jenis Kelamin -',
        '1'             => 'Laki-laki',
        '2'             => 'Perempuan',
      ];
      $this->data['birthplace'] = [
        'name'          => 'birthplace',
        'id'            => 'birthplace',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['birthdate'] = [
        'name'          => 'birthdate',
        'id'            => 'birthdate',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['phone'] = [
        'name'          => 'phone',
        'id'            => 'phone',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['address'] = [
        'name'          => 'address',
        'id'            => 'address',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'rows'           => '2',
      ];
      $this->data['username'] = [
        'name'          => 'username',
        'id'            => 'username',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['email'] = [
        'name'          => 'email',
        'id'            => 'email',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];

      //TODO Load view dengan kirim data
      $this->load->view('back/auth/update_profile', $this->data);
    } else {
      //TODO Kondisi data user tidak ditemukan
      $this->session->set_flashdata('message', 'tidak ditemukan');
      redirect('admin/dashboard');
    }
  }

  function update_profile_action()
  {
    //TODO Setup validasi form
    $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required');
    $this->form_validation->set_rules('phone', 'No. HP/Telepon', 'trim|is_numeric');
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'valid_email|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('valid_email', '{field} format email tidak benar');
    $this->form_validation->set_message('is_numeric', '{field} format harus angka');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    //TODO Kondisi data tidak lolos validasi
    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_users'));
    } else {
      //TODO Kondisi data lolos validasi
      //TODO Jika user mengganti/upload foto baru
      if ($_FILES['photo']['error'] <> 4) {
        //TODO Definisikan nama file foto yang akan disimpan ke direktori
        $nmfile = strtolower(url_title($this->input->post('username'))) . date('YmdHis');

        //TODO Konfigurasi library upload
        $config['upload_path']      = './assets/images/user/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048; // 2Mb
        $config['file_name']        = $nmfile;

        //TODO import library upload
        $this->load->library('upload', $config);

        //TODO Get data user by id
        $delete = $this->Auth_model->get_by_id($this->input->post('id_users'));

        //TODO Definisikan letak direktori penyimpanan filenya
        $dir        = "./assets/images/user/" . $delete->photo;
        $dir_thumb  = "./assets/images/user/" . $delete->photo_thumb;

        //TODO Jika file ditemukan pada direktori maka hapus file
        if (is_file($dir)) {
          unlink($dir);
          unlink($dir_thumb);
        }

        //TODO Kondisi file foto gagal diupload
        if (!$this->upload->do_upload('photo')) {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');

          $this->update($this->input->post('id_users'));
        } else {
          //TODO Menjalankan library upload
          $photo = $this->upload->data();

          //TODO Konfigurasi library image_lib
          $config['image_library']    = 'gd2';
          $config['source_image']     = './assets/images/user/' . $photo['file_name'] . '';
          $config['create_thumb']     = TRUE;
          $config['maintain_ratio']   = TRUE;
          $config['width']            = 250;
          $config['height']           = 250;

          //TODO import library image_lib
          $this->load->library('image_lib', $config);
          //TODO Jalankan library image_lib
          $this->image_lib->resize();

          //TODO Tampung data ke variabel array
          $data = array(
            'name'              => $this->input->post('name'),
            'gender'            => $this->input->post('gender'),
            'birthplace'        => $this->input->post('birthplace'),
            'birthdate'         => $this->input->post('birthdate'),
            'phone'             => $this->input->post('phone'),
            'address'           => $this->input->post('address'),
            'username'          => $this->input->post('username'),
            'email'             => $this->input->post('email'),
            'modified_by'       => $this->session->username,
            'photo'             => $this->upload->data('file_name'),
            'photo_thumb'       => $nmfile . '_thumb' . $this->upload->data('file_ext'),
          );

          //TODO Proses update data by id user
          $this->Auth_model->update($this->input->post('id_users'), $data);

          write_log();

          //TODO Kirim notifikasi sukses disimpan
          $this->session->set_flashdata('message', 'Sukses');
          redirect('admin/auth/update_profile/' . $this->session->id_users);
        }
      } else {
        //TODO Kondisi user tidak upload file foto baru
        //TODO Tampung data ke variabel array
        $data = array(
          'name'              => $this->input->post('name'),
          'gender'            => $this->input->post('gender'),
          'birthplace'        => $this->input->post('birthplace'),
          'birthdate'         => $this->input->post('birthdate'),
          'phone'             => $this->input->post('phone'),
          'address'           => $this->input->post('address'),
          'username'          => $this->input->post('username'),
          'email'             => $this->input->post('email'),
          'modified_by'       => $this->session->username,
        );

        //TODO Proses update data by id user
        $this->Auth_model->update($this->input->post('id_users'), $data);

        write_log();

        //TODO Kirim notifikasi sukses disimpan
        $this->session->set_flashdata('message', 'Sukses');
        redirect('admin/auth/update_profile/' . $this->session->id_users);
      }
    }
  }

  function change_password()
  {
    //TODO Definisi variabel
    $this->data['page_title'] = 'Ubah Password';
    $this->data['action']     = 'admin/auth/change_password_action';

    //TODO Get value Combobox by usertype
    if (is_grandadmin()) {
      $this->data['get_all_users']      = $this->Auth_model->get_all_combobox();
    } elseif (is_masteradmin()) {
      $this->data['get_all_users']      = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
    }

    //TODO Rancangan form
    $this->data['user_id'] = [
      'name'          => 'user_id',
      'id'            => 'user_id',
      'class'         => 'form-control',
    ];
    $this->data['new_password'] = [
      'name'          => 'new_password',
      'id'            => 'new_password',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
    ];
    $this->data['confirm_new_password'] = [
      'name'          => 'confirm_new_password',
      'id'            => 'confirm_new_password',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
    ];

    //TODO Load view dengan kirim data
    $this->load->view('back/auth/change_password', $this->data);
  }

  function change_password_action()
  {
    //TODO Validasi form
    $this->form_validation->set_rules('new_password', 'Password', 'min_length[8]|required');
    $this->form_validation->set_rules('confirm_new_password', 'Password Confirmation', 'matches[new_password]|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('matches', '{field} harus sama');
    $this->form_validation->set_message('min_length', '{field} minimal 8 karakter');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    //TODO Kondisi tidak lolos validasi form
    if ($this->form_validation->run() == FALSE) {
      $this->change_password();
    } else {
      //TODO Kondisi lolos validasi form
      //TODO Enkripsi password
      $password = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);

      //TODO Definisi variabel id_user
      if (is_superadmin()) {
        $id_user = $this->session->id_users;
      } else {
        $id_user = $this->input->post('user_id');
      }

      //TODO Data yang akan diubah
      $data = array(
        'password' => $password
      );

      //TODO Proses update data user by id
      $this->Auth_model->update($id_user, $data);

      write_log();

      //TODO Kirim notifikasi sukses ganti password
      $this->session->set_flashdata('message', 'Sukses');
      redirect('admin/auth/change_password');
    }
  }

  function logout()
  {
    //TODO Hapus session
    $this->session->sess_destroy();

    //TODO Redirect to form login
    redirect('auth/login');
  }

  function pilih_user()
  {
    $this->data['user'] = $this->Auth_model->get_user_by_divisi_combobox($this->uri->segment(4));
    $this->load->view('back/auth/v_user', $this->data);
  }

  function check_username()
  {
    //TODO Ambil inputan username dari form
    $username = $this->input->post('username');

    //TODO Get data user by username
    $check_username     = $this->Auth_model->get_by_username($username);

    //TODO Kondisi username tidak kosong
    if (!empty($username)) {
      //TODO Kondisi username telah ada di database
      if ($check_username) {
        echo "<div class='text-red'>Username telah ada, silahkan ganti yang lain</div>";
      } else {
        echo "<div class='text-green'>Username tersedia</div>";
      }
    } else {
      echo "<div class='text-red'>Wajib diisi</div>";
    }
  }

  function check_email()
  {
    //TODO Ambil inputan email dari form
    $email = $this->input->post('email');

    //TODO Get data user by email
    $check_email     = $this->Auth_model->get_by_email($email);

    //TODO Kondisi email tidak kosong
    if (!empty($email)) {
      //TODO Kondisi email telah ada di database
      if ($check_email) {
        echo "<div class='text-red'>Email telah ada, silahkan ganti yang lain</div>";
      } else {
        //TODO Cek format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          echo "<div class='text-red'>Format email belum benar</div>";
        } else {
          echo "<div class='text-green'>Email tersedia</div>";
        }
      }
    } else {
      echo "<div class='text-red'>Wajib diisi</div>";
    }
  }
}
