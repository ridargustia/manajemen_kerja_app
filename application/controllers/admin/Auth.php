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
    is_login();
    is_delete();

    if (is_superadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $delete = $this->Auth_model->get_by_id($id);

    if ($delete) {
      $data = array(
        'is_delete'   => '1',
        'deleted_by'  => $this->session->username,
        'deleted_at'  => date('Y-m-d H:i:a'),
      );

      $this->Auth_model->soft_delete($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus</div>');
      redirect('admin/auth');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/auth');
    }
  }

  function delete_permanent($id)
  {
    is_login();
    is_delete();

    if (is_superadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $delete = $this->Auth_model->get_by_id($id);

    if ($delete) {
      $dir        = "./assets/images/user/" . $delete->photo;
      $dir_thumb  = "./assets/images/user/" . $delete->photo_thumb;

      if (is_file($dir)) {
        unlink($dir);
        unlink($dir_thumb);
      }

      $this->Auth_model->delete($id);

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus permanen</div>');
      redirect('admin/auth/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/auth');
    }
  }

  function deleted_list()
  {
    is_login();
    is_restore();

    if (is_superadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $this->data['page_title'] = 'Deleted ' . $this->data['module'] . ' List';

    if (is_grandadmin()) {
      $this->data['get_all_deleted'] = $this->Auth_model->get_all_deleted();
    } elseif (is_masteradmin()) {
      $this->data['get_all_deleted'] = $this->Auth_model->get_all_deleted_by_instansi();
    } elseif (is_superadmin()) {
      $this->data['get_all_deleted'] = $this->Auth_model->get_all_deleted_by_cabang();
    }


    $this->load->view('back/auth/user_deleted_list', $this->data);
  }

  function restore($id)
  {
    is_login();
    is_restore();

    if (is_superadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $row = $this->Auth_model->get_by_id($id);

    if ($row) {
      $data = array(
        'is_delete'   => '0',
        'deleted_by'  => NULL,
        'deleted_at'  => NULL,
      );

      $this->Auth_model->update($id, $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dikembalikan</div>');
      redirect('admin/auth/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/auth');
    }
  }

  function activate($id)
  {
    is_login();

    if (is_superadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $this->Auth_model->update($this->uri->segment('4'), array('is_active' => '1'));

    $this->session->set_flashdata('message', '<div class="alert alert-success">Akun berhasil diaktifkan</div>');
    redirect('admin/auth');
  }

  function deactivate($id)
  {
    is_login();

    if (is_superadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $this->Auth_model->update($this->uri->segment('4'), array('is_active' => '0'));

    $this->session->set_flashdata('message', '<div class="alert alert-success">Akun berhasil dinonaktifkan</div>');
    redirect('admin/auth');
  }

  function update_profile($id)
  {
    is_login();

    $this->data['user']     = $this->Auth_model->get_by_id($id);

    if ($id != $this->session->id_users) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak mengubah data user lain</div>');
      redirect('admin/dashboard');
    }

    if ($this->data['user']) {
      $this->data['page_title'] = 'Update Profile';
      $this->data['action']     = 'admin/auth/update_profile_action';

      $this->data['get_all_data_access_old']        = $this->Dataaccess_model->get_all_data_access_old($id);

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
      $this->data['birthdate'] = [
        'name'          => 'birthdate',
        'id'            => 'birthdate',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['birthplace'] = [
        'name'          => 'birthplace',
        'id'            => 'birthplace',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['gender'] = [
        'name'          => 'gender',
        'id'            => 'gender',
        'class'         => 'form-control',
      ];
      $this->data['gender_value'] = [
        '1'             => 'Male',
        '2'             => 'Female',
      ];
      $this->data['address'] = [
        'name'          => 'address',
        'id'            => 'address',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'rows'           => '3',
      ];
      $this->data['phone'] = [
        'name'          => 'phone',
        'id'            => 'phone',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['email'] = [
        'name'          => 'email',
        'id'            => 'email',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['username'] = [
        'name'          => 'username',
        'id'            => 'username',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['usertype'] = [
        'name'          => 'usertype',
        'id'            => 'usertype',
        'class'         => 'form-control',
        'required'      => '',
      ];

      $this->load->view('back/auth/update_profile', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/dashboard');
    }
  }

  function update_profile_action()
  {
    $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
    $this->form_validation->set_rules('phone', 'Phone No', 'trim|is_numeric');
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'valid_email|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('valid_email', '{field} format email tidak benar');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_users'));
    } else {
      if ($_FILES['photo']['error'] <> 4) {
        $nmfile = strtolower(url_title($this->input->post('username'))) . date('YmdHis');

        $config['upload_path']      = './assets/images/user/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048; // 2Mb
        $config['file_name']        = $nmfile;

        $this->load->library('upload', $config);

        $delete = $this->Auth_model->get_by_id($this->input->post('id_users'));

        $dir        = "./assets/images/user/" . $delete->photo;
        $dir_thumb  = "./assets/images/user/" . $delete->photo_thumb;

        if (is_file($dir)) {
          unlink($dir);
          unlink($dir_thumb);
        }

        if (!$this->upload->do_upload('photo')) {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');

          $this->update($this->input->post('id_users'));
        } else {
          $photo = $this->upload->data();

          $config['image_library']    = 'gd2';
          $config['source_image']     = './assets/images/user/' . $photo['file_name'] . '';
          $config['create_thumb']     = TRUE;
          $config['maintain_ratio']   = TRUE;
          $config['width']            = 250;
          $config['height']           = 250;

          $this->load->library('image_lib', $config);
          $this->image_lib->resize();

          $data = array(
            'name'              => $this->input->post('name'),
            'birthdate'         => $this->input->post('birthdate'),
            'birthplace'        => $this->input->post('birthplace'),
            'gender'            => $this->input->post('gender'),
            'address'           => $this->input->post('address'),
            'phone'             => $this->input->post('phone'),
            'email'             => $this->input->post('email'),
            'username'          => $this->input->post('username'),
            'modified_by'       => $this->session->username,
            'photo'             => $this->upload->data('file_name'),
            'photo_thumb'       => $nmfile . '_thumb' . $this->upload->data('file_ext'),
          );

          $this->Auth_model->update($this->input->post('id_users'), $data);

          write_log();

          $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');
          redirect('admin/auth/update_profile/' . $this->session->id_users);
        }
      } else {
        $data = array(
          'name'              => $this->input->post('name'),
          'birthdate'         => $this->input->post('birthdate'),
          'birthplace'        => $this->input->post('birthplace'),
          'gender'            => $this->input->post('gender'),
          'address'           => $this->input->post('address'),
          'phone'             => $this->input->post('phone'),
          'email'             => $this->input->post('email'),
          'username'          => $this->input->post('username'),
          'modified_by'       => $this->session->username,
        );

        $this->Auth_model->update($this->input->post('id_users'), $data);

        write_log();

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');
        redirect('admin/auth/update_profile/' . $this->session->id_users);
      }
    }
  }

  function change_password()
  {
    is_login();

    $this->data['page_title'] = 'Ubah Password';
    $this->data['action']     = 'admin/auth/change_password_action';

    if (is_grandadmin()) {
      $this->data['get_all_users']      = $this->Auth_model->get_all_combobox();
    } elseif (is_masteradmin()) {
      $this->data['get_all_users']      = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
    } elseif (is_superadmin()) {
      $this->data['get_all_users']      = $this->Auth_model->get_all_combobox_by_cabang($this->session->cabang_id);
    }

    $this->data['user_id'] = [
      'name'          => 'user_id',
      'id'            => 'user_id',
      'type'          => 'hidden',
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

    $this->load->view('back/auth/change_password', $this->data);
  }

  function change_password_action()
  {
    $this->form_validation->set_rules('new_password', 'Password', 'min_length[8]|required');
    $this->form_validation->set_rules('confirm_new_password', 'Password Confirmation', 'matches[new_password]|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('matches', '{field} harus sama');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if ($this->form_validation->run() == FALSE) {
      $this->change_password();
    } else {
      $password = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);

      if (is_superadmin()) {
        $id_user = $this->session->user_id;
      } else {
        $id_user = $this->input->post('user_id');
      }

      $data = array(
        'password' => $password
      );

      $this->Auth_model->update($id_user, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Password berhasil diganti</div>');
      redirect('admin/auth/change_password');
    }
  }

  function login()
  {
    $this->data['page_title'] = 'Login';
    $this->data['action']     = 'admin/auth/login';

    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    if ($this->form_validation->run() === TRUE) {
      $row = $this->Auth_model->get_by_username($this->input->post('username'));

      $instansi_is_active_check = $this->Auth_model->get_user_by_instansi($this->input->post('username'));

      $usertype_id = $this->Usertype_model->get_by_id($row->usertype_id);
      $instansi_id = $this->Instansi_model->get_by_id($row->instansi_id);
      $cabang_id   = $this->Cabang_model->get_by_id($row->cabang_id);
      $divisi_id   = $this->Divisi_model->get_by_id($row->divisi_id);

      if (!$row->username) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Username tidak ditemukan</div>');
        redirect('admin/auth/login');
      } elseif ($instansi_is_active_check->is_active == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Instansi Anda sedang tidak aktif, silahkan perpanjang dan hubungi MASTERADMIN dulu</div>');
        redirect('admin/auth/login');
      } elseif ($row->is_active == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Akun Anda sedang tidak aktif</div>');
        redirect('admin/auth/login');
      } elseif (!password_verify($this->input->post('password'), $row->password)) {
        $log = $this->Auth_model->get_total_login_attempts_per_user($this->input->post('username'));

        // kunci akun kalau gagal input password 3x
        if ($log > 2) {
          $this->Auth_model->lock_account($this->input->post('username'), array('is_active' => '0'));

          $this->Auth_model->clear_login_attempt($this->input->post('username'));

          $this->session->set_flashdata('message', '<div class="alert alert-danger">Terlalu banyak percobaan login, akun Anda kami nonaktifkan sementara. Silahkan kontak SUPERADMIN untuk membukanya kembali.</div>');
          redirect('admin/auth/login');
        } else {
          $this->Auth_model->insert_login_attempt(array('ip_address' => $this->input->ip_address(), 'username' => $this->input->post('username')));

          $this->session->set_flashdata('message', '<div class="alert alert-danger">Password Salah</div>');
          redirect('admin/auth/login');
        }
      } else {
        $this->Auth_model->clear_login_attempt($this->input->post('username'));

        $session = array(
          'id_users'            => $row->id_users,
          'name'                => $row->name,
          'username'            => $row->username,
          'email'               => $row->email,
          'usertype_id'         => $row->usertype_id,
          'usertype_name'       => $usertype_id->usertype_name,
          'instansi_id'         => $row->instansi_id,
          'instansi_name'       => $instansi_id->instansi_name,
          'instansi_img'        => $instansi_id->instansi_img,
          'instansi_img_thumb'  => $instansi_id->instansi_img_thumb,
          'cabang_id'           => $row->cabang_id,
          'cabang_name'         => $cabang_id->cabang_name,
          'divisi_id'           => $row->divisi_id,
          'divisi_name'         => $divisi_id->divisi_name,
          'photo'               => $row->photo,
          'photo_thumb'         => $row->photo_thumb,
          'created_at'          => $row->created_at,
        );

        $this->session->set_userdata($session);

        $this->Auth_model->update($this->session->id_users, array('last_login' => date('Y-m-d H:i:s')));

        redirect('admin/dashboard');
      }
    } else {
      $this->data['username'] = [
        'name'              => 'username',
        'id'                => 'username',
        'class'             => 'form-control',
        'placeholder'       => 'Silahkan masukkan username',
        'value'             => $this->form_validation->set_value('username'),
      ];

      $this->data['password'] = [
        'name'              => 'password',
        'id'                => 'password',
        'class'             => 'form-control',
        'placeholder'       => 'Silahkan masukkan password',
        'value'             => $this->form_validation->set_value('password'),
      ];

      $this->load->view('back/auth/login', $this->data);
    }
  }

  function logout()
  {
    $this->session->sess_destroy();

    redirect('auth/login');
  }

  function pilih_user()
  {
    $this->data['user'] = $this->Auth_model->get_user_by_divisi_combobox($this->uri->segment(4));
    $this->load->view('back/auth/v_user', $this->data);
  }

  function check_username()
  {
    $username = $this->input->post('username');

    $check_username     = $this->Auth_model->get_by_username($username);

    if (!empty($username)) {
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
    $email = $this->input->post('email');

    $check_email     = $this->Auth_model->get_by_email($email);

    if (!empty($email)) {
      if ($check_email) {
        echo "<div class='text-red'>Email telah ada, silahkan ganti yang lain</div>";
      } else {
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
