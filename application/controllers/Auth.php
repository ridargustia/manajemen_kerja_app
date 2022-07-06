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

    $this->data['module'] = 'Auth';

    $this->data['company_data']      = $this->Company_model->company_profile();
    $this->data['footer']            = $this->Footer_model->footer();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
  }

  function login()
  {
    //TODO Inisialisasi variabel
    $this->data['page_title'] = 'Login';
    $this->data['action']     = 'auth/login';

    //TODO Membuat validasi form
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    //? Apakah data yang diinput sudah valid?
    if ($this->form_validation->run() === TRUE) {
      //TODO Ambil data users berdasarkan username
      $row = $this->Auth_model->get_by_username($this->input->post('username'));

      //TODO Cek status aktif instansi dari user
      $instansi_is_active_check = $this->Auth_model->get_user_by_instansi($this->input->post('username'));

      //TODO Ambil data-data yang diperlukan
      $usertype_id = $this->Usertype_model->get_by_id($row->usertype_id);
      $jabatan_id = $this->Jabatan_model->get_by_id($row->jabatan_id);
      $instansi_id = $this->Instansi_model->get_by_id($row->instansi_id);
      $divisi_id   = $this->Divisi_model->get_by_id($row->divisi_id);

      if (!$row->username) {  //?Apakah username ada?
        //TODO Kondisi dimana username tersedia
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Username tidak ditemukan</div>');
        redirect('auth/login');
      } elseif ($instansi_is_active_check->is_active == '0') {  //? Apakah instansi aktif?
        //TODO Kondisi dimana instansi status inaktif
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Instansi Anda sedang tidak aktif, silahkan perpanjang dan hubungi MASTERADMIN dulu</div>');
        redirect('auth/login');
      } elseif ($row->is_active == 0) { //? Apakah akun ybs status aktif?
        //TODO Kondisi dimana akun ybs status inaktif
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Akun Anda sedang tidak Aktif</div>');
        redirect('auth/login');
      } elseif (!password_verify($this->input->post('password'), $row->password)) { //? Apakah inputan password cocok dengan password data user dengan username ybs dari database?
        //TODO Kondisi inputan password tidak cocok dengan password user dari database (Status Gagal Login)
        //TODO Hitung jumlah percobaan login by username di database
        $log = $this->Auth_model->get_total_login_attempts_per_user($this->input->post('username'));

        //TODO Kunci/block akun Jika gagal input password 3x
        if ($log > 2) {
          //TODO Kunci/block akun dengan update status is_active menjadi 0
          $this->Auth_model->lock_account($this->input->post('username'), array('is_active' => '0'));

          //TODO Hapus data user by username pada database tabel login_attemps (catatan gagal login)
          $this->Auth_model->clear_login_attempt($this->input->post('username'));

          //TODO Tampilkan notifikasi akun diblokir
          $this->session->set_flashdata('message', '<div class="alert alert-danger">Terlalu banyak percobaan login, akun Anda kami nonaktifkan sementara. Silahkan kontak SUPERADMIN untuk membukanya kembali.</div>');
          redirect('auth/login');
        } else {
          //TODO Simpan catatan gagal login ke database
          $this->Auth_model->insert_login_attempt(array('ip_address' => $this->input->ip_address(), 'username' => $this->input->post('username')));

          //TODO Tampilkan notifikasi dan redirect
          $this->session->set_flashdata('message', '<div class="alert alert-danger">Password Salah</div>');
          redirect('auth/login');
        }
      } else {
        //TODO Kondisi proses login SUKSES/BERHASIL
        //TODO Hapus data user by username pada database tabel login_attemps (catatan gagal login)
        $this->Auth_model->clear_login_attempt($this->input->post('username'));

        //TODO Buat Session dengan value sebagai berikut
        $session = array(
          'id_users'            => $row->id_users,
          'name'                => $row->name,
          'username'            => $row->username,
          'email'               => $row->email,
          'usertype_id'         => $row->usertype_id,
          'usertype_name'       => $usertype_id->usertype_name,
          'jabatan_name'        => $jabatan_id->jabatan_name,
          'instansi_id'         => $row->instansi_id,
          'instansi_name'       => $instansi_id->instansi_name,
          'instansi_img'        => $instansi_id->instansi_img,
          'instansi_img_thumb'  => $instansi_id->instansi_img_thumb,
          'divisi_id'           => $row->divisi_id,
          'divisi_name'         => $divisi_id->divisi_name,
          'photo'               => $row->photo,
          'photo_thumb'         => $row->photo_thumb,
          'created_at'          => $row->created_at,
        );

        //TODO setup userdata
        $this->session->set_userdata($session);

        //TODO update data last login
        $this->Auth_model->update($this->session->id_users, array('last_login' => date('Y-m-d H:i:s')));

        redirect('admin/dashboard');
      }
    } else {
      //TODO Kondisi menampilkan halaman login
      $this->data['username'] = [
        'name'              => 'username',
        'id'                => 'username',
        'class'             => 'form-control',
        'placeholder'       => 'username',
        'required'          => '',
        'value'             => $this->form_validation->set_value('username'),
      ];

      $this->data['password'] = [
        'name'              => 'password',
        'id'                => 'password',
        'class'             => 'form-control',
        'placeholder'       => 'password',
        'required'          => '',
        'value'             => $this->form_validation->set_value('password'),
      ];

      //TODO Load view halaman login
      $this->load->view('front/auth/login', $this->data);
    }
  }

  function forgot_password()
  {
    //TODO Inisialisasi variabel
    $this->data['page_title'] = "Lupa Password | Desa Saobi";
    $this->data['action']     = 'auth/forgot_password_process';

    //TODO Rancangan form
    $this->data['email'] = [
      'name'          => 'email',
      'id'            => 'email',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
    ];

    //TODO Load view dengan kirim data
    $this->load->view('back/auth/forgot_password', $this->data);
  }

  function forgot_password_process()
  {
    //TODO import helper random_str untuk generate string random
    $this->load->helper('random_str');

    //TODO Kondisi form telah submit
    if (isset($_POST['submit'])) {
      //TODO Validasi form
      $this->form_validation->set_rules('email', 'Email', 'valid_email|required');

      $this->form_validation->set_message('required', '{field} wajib diisi');
      $this->form_validation->set_message('valid_email', 'Format {field} salah');

      $this->form_validation->set_error_delimiters('<div class="col-lg-12"><div class="alert alert-danger alert">', '</div></div>');

      //TODO Kondisi data tidak lolos validasi
      if ($this->form_validation->run() == FALSE) {
        $this->login();
      } else {
        //TODO Ambil data user by email
        $email_check = $this->Auth_model->get_by_email($this->input->post('email'));

        //TODO Kondisi email tidak ditemukan di database
        if (!$email_check) {
          //TODO Kirim notifikasi data tidak ditemukan
          $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger">Maaf, email tidak ditemukan.</div>');
          redirect('auth/forgot_password', 'refresh');
        } else {
          //TODO Kondisi data ditemukan
          $hash   = random_str(50);
          $email   = $this->input->post('email');

          //TODO Konfigurasi fitur mailing
          $config = [
            'mailtype'   => 'html',
            'priority'   => 5,
          ];

          //TODO import library email
          $this->load->library('email', $config);

          //TODO sender / from
          $this->email->from($this->data['company_data']->company_email, $this->data['company_data']->company_name);
          //TODO target / mail receiver
          $this->email->to($email);
          //TODO reply to
          $this->email->reply_to($this->data['company_data']->company_email);
          //TODO subject
          $this->email->subject('Password Reset Request');
          //TODO message.
          $this->email->message('
								<h3>Hi, ' . $email . '</h3>
                Hi, beberapa saat yang lalu, sistem menerima permintaan untuk mereset password Anda. <br>
                Supaya dapat mereset password, silahkan klik link berikut ini:
								<p><a href="' . base_url('auth/reset_password/' . $hash) . '">' . $hash . '</a></p>
								<p>Jika Anda merasa tidak melakukan permintaan ini, Anda dapat mengabaikannya saja.</p>
								<hr>
								<b>EMAIL INI TERKIRIM SECARA OTOMATIS. JANGAN MENGIRIM / MEMBALAS PESAN KE EMAIL INI.</b>
								<hr>
								<b>' . $this->data['company_data']->company_name . '</b>
								<br>Alamat: ' . $this->data['company_data']->company_address . '
								<br>No. HP: ' . $this->data['company_data']->company_phone . '
								<br>Fax: ' . $this->data['company_data']->company_fax . '
								<br>Email: ' . $this->data['company_data']->company_email . '');

          //TODO Kondisi email terkirim
          if ($this->email->send()) {
            //TODO update data code_forgotten user by email
            $this->Auth_model->update_by_email($email, array('code_forgotten' => $hash));

            //TODO Kirim notifikasi email berhasil dikirim
            $this->session->set_flashdata('message', '<div class="alert alert-block alert-success">Password Anda berhasil kami reset. Silahkan cek email Anda.</div>');
            redirect('auth/login', 'refresh');
          } else {
            //TODO Kirim notifikasi percobaan reset password gagal
            $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger">Maaf, percobaan reset password gagal. Silahkan coba kembali.</div>');
            redirect('auth/login', 'refresh');
          }
        }
      }
    } else {
      //TODO Kondisi tombol submit belum ditekan
      $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger">Tekan tombolnya dulu!</div>');
      redirect('auth/login', 'refresh');
    }
  }

  function reset_password($code = NULL)
  {
    $this->data['reset'] = $this->Auth_model->get_by_code_forgotten($code);

    if (!$this->data['reset'] or $code == NULL) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Maaf, kami tidak dapat menemukan kode reset password. Silahkan ulangi kembali.</div>');
      redirect('auth/forgot_password');
    } else {
      $this->data['page_title'] = 'Reset Password';
      $this->data['action']     = 'auth/reset_password_process/' . $code;

      $this->data['code_forgotten'] = [
        'name'      => 'code_forgotten',
        'type'      => 'hidden',
        'value'     => $this->uri->segment(3),
      ];
      $this->data['new_password'] = [
        'name'          => 'new_password',
        'class'         => 'form-control',
        'placeholder'   => 'Insert your New Password',
        'required'      => '',
      ];

      $this->load->view('back/auth/reset_password', $this->data);
    }
  }

  function reset_password_process()
  {
    $this->form_validation->set_rules('new_password', 'New Password', 'min_length[8]|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('min_length', '{field} minimal 8 huruf/karakter');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if ($this->form_validation->run() == FALSE) {
      $this->reset_password($this->input->post('code_forgotten'));
    } else {
      $password = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);

      $data = array(
        'password'        => $password,
        'code_forgotten'  => '',
      );

      $this->Auth_model->update_by_code_forgotten($this->input->post('code_forgotten'), $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success">Password baru berhasil disimpan. Anda bisa login sekarang.</div>');
      redirect('auth/login');
    }
  }
}
