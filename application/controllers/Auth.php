<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
    $this->data['page_title'] = 'Login';
    $this->data['action']     = 'auth/login';

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
        redirect('auth/login');
      } elseif ($instansi_is_active_check->is_active == '0') {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Instansi Anda sedang tidak aktif, silahkan perpanjang dan hubungi MASTERADMIN dulu</div>');
        redirect('auth/login');
      } elseif ($row->is_active == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Akun Anda sedang tidak Aktif</div>');
        redirect('auth/login');
      } elseif (!password_verify($this->input->post('password'), $row->password)) {
        $log = $this->Auth_model->get_total_login_attempts_per_user($this->input->post('username'));

        // kunci akun kalau gagal input password 3x
        if ($log > 2) {
          $this->Auth_model->lock_account($this->input->post('username'), array('is_active' => '0'));

          $this->Auth_model->clear_login_attempt($this->input->post('username'));

          $this->session->set_flashdata('message', '<div class="alert alert-danger">Terlalu banyak percobaan login, akun Anda kami nonaktifkan sementara. Silahkan kontak SUPERADMIN untuk membukanya kembali.</div>');
          redirect('auth/login');
        } else {
          $this->Auth_model->insert_login_attempt(array('ip_address' => $this->input->ip_address(), 'username' => $this->input->post('username')));

          $this->session->set_flashdata('message', '<div class="alert alert-danger">Password Salah</div>');
          redirect('auth/login');
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

        redirect('home');
      }
    } else {
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

      $this->load->view('front/auth/login', $this->data);
    }
  }

  function logout()
  {
    $this->session->sess_destroy();

    redirect('auth/login');
  }

  function update_profile($id)
  {
    is_login();

    $this->data['user']     = $this->Auth_model->get_by_id($id);

    if ($id != $this->session->id_users) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak dapat mengganti akun user lain!</div>');
      redirect('home');
    }

    if ($this->data['user']) {
      $this->data['page_title'] = 'Update Profil';
      $this->data['action']     = 'auth/update_profile_action';

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

      $this->load->view('front/auth/update_profile', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">User idak ditemukan</div>');
      redirect('home');
    }
  }

  function update_profile_action()
  {
    $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required');
    $this->form_validation->set_rules('phone', 'No. HP', 'trim|is_numeric');
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'valid_email|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('is_numeric', '{field} isi angka saja');
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
          redirect('auth/update_profile/' . $this->session->id_users);
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
        redirect('auth/update_profile/' . $this->session->id_users);
      }
    }
  }

  function change_password()
  {
    is_login();

    $this->data['page_title'] = 'Ubah Password';
    $this->data['action']     = 'auth/change_password_action';

    $this->data['get_all_users']     = $this->Auth_model->get_all_combobox();

    $this->data['user_id'] = [
      'name'          => 'user_id',
      'type'          => 'hidden',
      'class'          => 'form-control',
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

    $this->load->view('front/auth/change_password', $this->data);
  }

  function change_password_action()
  {
    $this->form_validation->set_rules('new_password', 'Password', 'min_length[8]|required');
    $this->form_validation->set_rules('confirm_new_password', 'Konfirmasi Password', 'matches[new_password]|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('matches', '{field} password tidak sama');
    $this->form_validation->set_message('min_length', '{field} minimal 8 huruf');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if ($this->form_validation->run() == FALSE) {
      $this->change_password();
    } else {
      $password = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);

      $id_user = $this->session->id_users;

      $data = array(
        'password' => $password
      );

      $this->Auth_model->update($id_user, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Password baru berhasil disimpan</div>');
      redirect('auth/change_password');
    }
  }

  function forgot_password()
  {
    $this->data['page_title'] = "Lupa Password";
    $this->data['action']     = 'auth/forgot_password_process';

    $this->data['email'] = [
      'name'          => 'email',
      'id'            => 'email',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
    ];

    $this->load->view('back/auth/forgot_password', $this->data);
  }

  function forgot_password_process()
  {
    $this->load->helper('random_str');

    if (isset($_POST['submit'])) {
      $this->form_validation->set_rules('email', 'Email', 'valid_email|required');

      $this->form_validation->set_message('required', '{field} wajib diisi');

      $this->form_validation->set_error_delimiters('<div class="col-lg-12"><div class="alert alert-danger alert">', '</div></div>');

      if ($this->form_validation->run() == FALSE) {
        $this->login();
      } else {
        $email_check = $this->Auth_model->get_by_email($this->input->post('email'));

        if (!$email_check) {
          $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger">Maaf, email tidak ditemukan.</div>');
          redirect('auth/forgot_password', 'refresh');
        } else {
          $hash   = random_str(50);
          $email   = $this->input->post('email');

          $config = [
            'mailtype'   => 'html',
            'priority'   => 5,
          ];

          $this->load->library('email', $config);
        
          // sender / from
          $this->email->from($this->data['company_data']->company_email, $this->data['company_data']->company_name);
          // target / mail receiver
          $this->email->to($email);
          // reply to
          $this->email->reply_to($this->data['company_data']->company_email);
          // subject
          $this->email->subject('Password Reset Request');
          // message.
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
								<br>Email: ' . $this->data['company_data']->company_email . ' / ' . $this->data['company_data']->company_gmail . '
							');

          if ($this->email->send()) {
            $this->Auth_model->update_by_email($email, array('code_forgotten' => $hash));

            $this->session->set_flashdata('message', '<div class="alert alert-block alert-success">Password Anda berhasil kami reset. Silahkan cek email Anda.</div>');
            redirect('auth/login', 'refresh');
          } else {
            $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger">Maaf, percobaan reset password gagal. Silahkan coba kembali.</div>');
            redirect('auth/login', 'refresh');
          }
        }
      }
    } else {
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
