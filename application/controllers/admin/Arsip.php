<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

class Arsip extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Arsip';

    $this->load->model(array(
      'Arsip_model', 'Baris_model', 'Box_model', 'File_model', 'Jenis_model', 'Map_model', 'Rak_model', 'Token_model'
    ));

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
    $this->data['add_action'] = base_url('admin/arsip/create');

    is_login();

    if (is_pegawai()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('home');
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
      $this->data['get_all'] = $this->Arsip_model->get_all();
      $this->load->view('back/arsip/arsip_list_grandadmin', $this->data);
    } elseif (is_masteradmin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_by_instansi();
      $this->load->view('back/arsip/arsip_list_masteradmin', $this->data);
    } elseif (is_superadmin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_by_cabang();
      $this->load->view('back/arsip/arsip_list_superadmin', $this->data);
    } elseif (is_admin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_by_divisi();
      $this->load->view('back/arsip/arsip_list_admin', $this->data);
    }
  }

  function aktif()
  {
    is_read();

    $this->data['page_title'] = 'Data ' . $this->data['module'] . ' Aktif';

    if (is_grandadmin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_aktif();
      $this->load->view('back/arsip/arsip_list_grandadmin', $this->data);
    } elseif (is_masteradmin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_aktif_by_instansi();
      $this->load->view('back/arsip/arsip_list_masteradmin', $this->data);
    } elseif (is_superadmin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_aktif_by_cabang();
      $this->load->view('back/arsip/arsip_list_superadmin', $this->data);
    } elseif (is_admin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_aktif_by_divisi();
      $this->load->view('back/arsip/arsip_list_admin', $this->data);
    }
  }

  function inaktif()
  {
    is_read();

    $this->data['page_title'] = 'Data ' . $this->data['module'] . ' InAktif';

    if (is_grandadmin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_inaktif();
      $this->load->view('back/arsip/arsip_list_grandadmin', $this->data);
    } elseif (is_masteradmin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_inaktif_by_instansi();
      $this->load->view('back/arsip/arsip_list_masteradmin', $this->data);
    } elseif (is_superadmin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_inaktif_by_cabang();
      $this->load->view('back/arsip/arsip_list_superadmin', $this->data);
    } elseif (is_admin()) {
      $this->data['get_all'] = $this->Arsip_model->get_all_inaktif_by_divisi();
      $this->load->view('back/arsip/arsip_list_admin', $this->data);
    }
  }

  function detail($id)
  {
    $this->data['detail_arsip']   = $this->Arsip_model->get_detail($id);
    $this->data['file_upload']    = $this->File_model->get_by_arsip_id($id);
    
    $instansi                     = $this->Instansi_model->get_by_id($this->data['detail_arsip']->instansi_id);
    $this->data['instansiName']   = $instansi->instansi_name;

    $row = $this->data['detail_arsip'];

    // GrandAdmin bisa akses ke semua data
    // MasterAdmin akses ke data instansinya saja
    // SuperAdmin akses ke data cabangnya saja
    // Admin akses data divisinya saja
    if (is_masteradmin() && $row->instansi_id != $this->session->instansi_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak melihat data orang lain</div>');
      redirect('admin/arsip');
    }
    if (is_superadmin() && $row->cabang_id != $this->session->cabang_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak melihat data orang lain</div>');
      redirect('admin/arsip');
    }
    if (is_admin() && $row->divisi_id != $this->session->divisi_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak melihat data orang lain</div>');
      redirect('admin/arsip');
    } elseif ($this->data['detail_arsip']) {
      $this->data['page_title']   = 'Detail Arsip';
      $this->data['arsip_files']  = $this->Arsip_model->get_files_id_result($this->data['detail_arsip']->id_arsip);

      $this->load->view('back/arsip/arsip_detail', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/arsip');
    }
  }

  function create()
  {
    is_create();

    $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
    $this->data['action']     = 'admin/arsip/create_action';

    $this->data['get_all_jenis_arsip'] = $this->Jenis_model->get_all();

    if (is_grandadmin()) {
      $this->data['get_all_combobox_instansi']  = $this->Instansi_model->get_all_combobox();
      $this->data['get_all_combobox_cabang']    = $this->Cabang_model->get_all_combobox();
      $this->data['get_all_combobox_divisi']    = $this->Divisi_model->get_all_combobox();
      $this->data['get_all_combobox_user']      = $this->Auth_model->get_all_combobox();
      $this->data['get_all_combobox_rak']       = $this->Rak_model->get_all_combobox();
      $this->data['get_all_combobox_box']       = $this->Box_model->get_all_combobox();
      $this->data['get_all_combobox_map']       = $this->Map_model->get_all_combobox();
      $this->data['get_all_combobox_baris']     = $this->Baris_model->get_all_combobox();
    } elseif (is_masteradmin()) {
      $this->data['get_all_combobox_cabang']    = $this->Cabang_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_divisi']    = $this->Divisi_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_user']      = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_rak']       = $this->Rak_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_box']       = $this->Box_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_map']       = $this->Map_model->get_all_combobox_by_instansi($this->session->instansi_id);
      $this->data['get_all_combobox_baris']     = $this->Baris_model->get_all_combobox_by_instansi($this->session->instansi_id);
    } elseif (is_superadmin() or is_admin()) {
      $this->data['get_all_combobox_divisi']    = $this->Divisi_model->get_all_combobox_by_cabang($this->session->cabang_id);
      $this->data['get_all_combobox_lokasi']    = $this->Lokasi_model->get_all_combobox_by_cabang($this->session->cabang_id);
      $this->data['get_all_combobox_user']      = $this->Auth_model->get_all_combobox_by_cabang($this->session->cabang_id);
      $this->data['get_all_combobox_rak']       = $this->Rak_model->get_all_combobox_by_cabang($this->session->cabang_id);
      $this->data['get_all_combobox_box']       = $this->Box_model->get_all_combobox_by_cabang($this->session->cabang_id);
      $this->data['get_all_combobox_map']       = $this->Map_model->get_all_combobox_by_cabang($this->session->cabang_id);
      $this->data['get_all_combobox_baris']     = $this->Baris_model->get_all_combobox_by_cabang($this->session->cabang_id);
    }

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
      'onChange'      => 'tampilDivisi(); tampilLokasi(); tampilRak(); tampilBox(); tampilMap(); tampilBaris()',
      'required'      => '',
    ];
    $this->data['divisi_id'] = [
      'name'          => 'divisi_id',
      'id'            => 'divisi_id',
      'class'         => 'form-control',
      'onChange'      => 'tampilKepemilikanArsip()',
      'required'      => ''
    ];
    $this->data['lokasi_id'] = [
      'name'          => 'lokasi_id',
      'id'            => 'lokasi_id',
      'class'         => 'form-control',
      'required'      => ''
    ];
    $this->data['user_id'] = [
      'name'          => 'user_id',
      'id'            => 'user_id',
      'class'         => 'form-control',
      'required'      => '',
    ];
    $this->data['rak_id'] = [
      'name'          => 'rak_id',
      'id'            => 'rak_id',
      'class'         => 'form-control',
      'required'      => '',
    ];
    $this->data['box_id'] = [
      'name'          => 'box_id',
      'id'            => 'box_id',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
    ];
    $this->data['map_id'] = [
      'name'          => 'map_id',
      'id'            => 'map_id',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
    ];
    $this->data['baris_id'] = [
      'name'          => 'baris_id',
      'id'            => 'baris_id',
      'class'         => 'form-control',
      'required'      => '',
    ];
    $this->data['no_arsip'] = [
      'name'          => 'no_arsip',
      'id'            => 'no_arsip',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'onChange'      => 'checkNoArsip()',
      'required'      => '',
      'value'         => $this->form_validation->set_value('no_arsip'),
    ];
    $this->data['arsip_name'] = [
      'name'          => 'arsip_name',
      'id'            => 'arsip_name',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'onChange'      => 'checkArsipName()',
      'required'      => '',
      'value'         => $this->form_validation->set_value('arsip_name'),
    ];
    $this->data['deskripsi_arsip'] = [
      'name'          => 'deskripsi_arsip',
      'id'            => 'deskripsi_arsip',
      'class'         => 'form-control',
      'rows'          => '5',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('deskripsi_arsip'),
    ];
    $this->data['jenis_arsip_id'] = [
      'name'          => 'jenis_arsip_id[]',
      'id'            => 'jenis_arsip_id',
      'class'         => 'form-control select2',
      'multiple'      => '',
      'required'      => '',
    ];
    $this->data['masa_retensi'] = [
      'name'          => 'masa_retensi',
      'id'            => 'masa_retensi',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'value'         => $this->form_validation->set_value('masa_retensi'),
    ];
    $this->data['status_file'] = [
      'name'          => 'status_file',
      'id'            => 'status_file',
      'class'         => 'form-control',
    ];
    $this->data['email'] = [
      'name'          => 'email',
      'id'            => 'email',
      'class'         => 'form-control',
    ];
    $this->data['folder_name'] = [
      'name'          => 'folder_name',
      'id'            => 'folder_name',
      'class'         => 'form-control',
      'readonly'      => '',
    ];
    $this->data['keterangan'] = [
      'name'          => 'keterangan',
      'id'            => 'keterangan',
      'class'         => 'form-control',
    ];
    $this->data['keterangan_value'] = [
      '1'          => 'Permanen',
      '2'          => 'Musnah',
    ];

    $this->load->view('back/arsip/arsip_add', $this->data);
  }

  function create_action()
  {
    $this->form_validation->set_rules('no_arsip', 'Nomor Arsip', 'trim|required');
    $this->form_validation->set_rules('arsip_name', 'Nama Arsip', 'trim|required');

    $this->form_validation->set_rules('lokasi_id', 'Lokasi Arsip', 'required');
    $this->form_validation->set_rules('rak_id', 'Rak', 'required');
    $this->form_validation->set_rules('box_id', 'Box', 'required');
    $this->form_validation->set_rules('map_id', 'Map', 'required');
    $this->form_validation->set_rules('baris_id', 'Baris', 'required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('is_unique', '{field} sudah ada, ganti dengan yang lain');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if (is_grandadmin()) {
      $instansi_id  = $this->input->post('instansi_id');
      $divisi_id    = $this->input->post('divisi_id');
      $cabang_id    = $this->input->post('cabang_id');
      $user_id      = $this->input->post('user_id');
    } elseif (is_masteradmin()) {
      $instansi_id  = $this->session->instansi_id;
      $divisi_id    = $this->input->post('divisi_id');
      $cabang_id    = $this->input->post('cabang_id');
      $user_id      = $this->input->post('user_id');
    } elseif (is_superadmin()) {
      $instansi_id  = $this->session->instansi_id;
      $cabang_id    = $this->session->cabang_id;
      $divisi_id    = $this->input->post('divisi_id');
      $user_id      = $this->input->post('user_id');
    } else {
      $instansi_id  = $this->session->instansi_id;
      $cabang_id    = $this->session->cabang_id;
      $divisi_id    = $this->session->divisi_id;
      $user_id      = $this->session->id_users;
    }
    
    $no_arsip = $this->input->post('no_arsip');
    $arsip_name = $this->input->post('arsip_name');
    $check_no_arsip     = $this->Arsip_model->get_no_arsip_by_cabang($no_arsip, $cabang_id, $instansi_id);
    $check_arsip_name     = $this->Arsip_model->get_arsip_name_by_instansi_and_cabang($arsip_name, $cabang_id, $instansi_id);

     
    if ($this->form_validation->run() === FALSE || $check_no_arsip || $check_arsip_name) {
        $json = 'success';
        
        header('Content-Type: application/json');
        echo json_encode($json);
        
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert">Nama Arsip atau No Arsip telah ada ya, silahkan ganti yang lain</div>');
      //$this->create();
    } else {
      if ($this->input->post('masa_retensi') == NULL) {
        $masa_retensi = NULL;
      } else {
        $masa_retensi = $this->input->post('masa_retensi');
      }

      $data = array(
        'instansi_id'                     => $instansi_id,
        'cabang_id'                       => $cabang_id,
        'divisi_id'                       => $divisi_id,
        'user_id'                         => $user_id,
        'lokasi_id'                       => $this->input->post('lokasi_id'),
        'rak_id'                          => $this->input->post('rak_id'),
        'box_id'                          => $this->input->post('box_id'),
        'map_id'                          => $this->input->post('map_id'),
        'baris_id'                        => $this->input->post('baris_id'),
        'no_arsip'                        => $this->input->post('no_arsip'),
        'arsip_name'                      => $this->input->post('arsip_name'),
        'deskripsi_arsip'                 => $this->input->post('deskripsi_arsip'),
        'keterangan'                      => $this->input->post('keterangan'),
        'masa_retensi'                    => $masa_retensi,
        'status_file'                     => $this->input->post('status_file'),
        'is_available'                    => '1',
        'created_by'                      => $this->session->userdata('username'),
      );

      // eksekusi query INSERT
      $this->Arsip_model->insert($data);

      $arsip_id = $this->db->insert_id();

      write_log();

      $instansi     = $this->Instansi_model->get_by_id($instansi_id);
      $instansiName = $instansi->instansi_name;
      // $nmfile       = strtolower(url_title($instansiName . '-' . $this->input->post('arsip_name'))) . '-' . date('YmdHis');

      // kalau upload foto tambahan
      if (!empty($_FILES['file_upload']['name'])) {
        $filesCount = count($_FILES['file_upload']['name']);

        for ($i = 0; $i < $filesCount; $i++) {
          // File upload configuration
          // atur lokasi upload berdasarkan nama instansi
          $config2['upload_path'] = './assets/file_arsip/' . $instansiName;
          if (!is_dir($config2['upload_path'])) {
            mkdir($config2['upload_path'], 0777, TRUE);
          }

          $config2['allowed_types']  = '*';
          

          $_FILES['file']['name']       = $_FILES['file_upload']['name'][$i];
          $_FILES['file']['type']       = $_FILES['file_upload']['type'][$i];
          $_FILES['file']['tmp_name']   = $_FILES['file_upload']['tmp_name'][$i];
          $_FILES['file']['error']      = $_FILES['file_upload']['error'][$i];
          $_FILES['file']['size']       = $_FILES['file_upload']['size'][$i];

          // Load and initialize upload library
          $this->load->library('upload', $config2);
          $this->upload->initialize($config2);

          // Upload file to server
          if (!$this->upload->do_upload('file')) {
            
            //file gagal diupload -> kembali ke form tambah
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('message', '<div class="col-lg-12"><div class="alert alert-danger alert">' . $error['error'] . '</div></div>');
            
            $json = 'failed';
            header('Content-Type: application/json');
            echo json_encode($error['error']);
            // $this->create();
          } else {
            
            // Uploaded file data
            $fileData = $this->upload->data();

            $datas = array(
              'arsip_id'        => $arsip_id,
              'file_upload'     => $fileData['file_name'],
              'created_by'      => $this->session->userdata('username'),
            );

            
            // Insert files data into the database
            $this->Arsip_model->insert_files($datas);
          }
        }
      }

      if (!empty($this->input->post('jenis_arsip_id'))) {
        $jenis_arsip_id = count($this->input->post('jenis_arsip_id'));

        for ($i_jenis_arsip_id = 0; $i_jenis_arsip_id < $jenis_arsip_id; $i_jenis_arsip_id++) {
          $datas_jenis_arsip_id[$i_jenis_arsip_id] = array(
            'arsip_id'          => $arsip_id,
            'jenis_arsip_id'    => $this->input->post('jenis_arsip_id[' . $i_jenis_arsip_id . ']'),
          );

          $this->db->insert('arsip_jenis', $datas_jenis_arsip_id[$i_jenis_arsip_id]);

          write_log();
        }
      }      
      
    //   header('Content-Type: application/json');
    //   echo json_encode($fileData['file_name']);

      
      if ($fileData['file_name'] != NULL) {
        $json = 'success';
        header('Content-Type: application/json');
        echo json_encode($json);
        
      }
      $this->session->set_flashdata('message', '<div class="alert alert-success alert">Data berhasil disimpan</div>');
      //redirect(base_url('admin/arsip'));
    }
  }

  function update($id)
  {
    is_update();

    $this->data['arsip']                  = $this->Arsip_model->get_by_id($id);
    $this->data['file_upload']            = $this->File_model->get_by_arsip_id($id);

    $instansi                     = $this->Instansi_model->get_by_id($this->data['arsip']->instansi_id);
    $this->data['instansiName']   = $instansi->instansi_name;

    $row = $this->data['arsip'];

    // GrandAdmin bisa akses ke semua data
    // MasterAdmin akses ke data instansinya saja
    // SuperAdmin akses ke data cabangnya saja
    // Admin akses data divisinya saja
    if (is_masteradmin() && $row->instansi_id != $this->session->instansi_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak mengubah data orang lain</div>');
      redirect('admin/arsip');
    }
    if (is_superadmin() && $row->cabang_id != $this->session->cabang_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak mengubah data orang lain</div>');
      redirect('admin/arsip');
    }
    // jika punya dia sendiri (admin) maka tampilkan semua tombol
    if (is_admin() && $row->user_id != $this->session->id_users) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak mengubah data orang lain</div>');
      redirect('admin/arsip');
    } elseif ($this->data['arsip']) {
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/arsip/update_action';

      if (is_grandadmin()) {
        $this->data['get_all_combobox_instansi']    = $this->Instansi_model->get_all_combobox();
        $this->data['get_all_combobox_cabang']      = $this->Cabang_model->get_all_combobox_update($this->data['arsip']->instansi_id);
        $this->data['get_all_combobox_divisi']      = $this->Divisi_model->get_all_combobox_update($this->data['arsip']->cabang_id);
        $this->data['get_all_combobox_user']        = $this->Auth_model->get_all_combobox_grandAdmin_by_cabang($this->data['arsip']->cabang_id);
        $this->data['get_all_combobox_lokasi']      = $this->Lokasi_model->get_all_combobox_by_cabang($this->data['arsip']->cabang_id);
        $this->data['get_all_combobox_rak']         = $this->Rak_model->get_all_combobox_by_cabang($this->data['arsip']->cabang_id);
        $this->data['get_all_combobox_box']         = $this->Box_model->get_all_combobox_by_cabang($this->data['arsip']->cabang_id);
        $this->data['get_all_combobox_map']         = $this->Map_model->get_all_combobox_by_cabang($this->data['arsip']->cabang_id);
        $this->data['get_all_combobox_baris']       = $this->Baris_model->get_all_combobox_by_cabang($this->data['arsip']->cabang_id);
      } elseif (is_masteradmin()) {
        $this->data['get_all_combobox_cabang']      = $this->Cabang_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_divisi']      = $this->Divisi_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_user']        = $this->Auth_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_lokasi']      = $this->Lokasi_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_rak']         = $this->Rak_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_box']         = $this->Box_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_map']         = $this->Map_model->get_all_combobox_by_instansi($this->session->instansi_id);
        $this->data['get_all_combobox_baris']       = $this->Baris_model->get_all_combobox_by_instansi($this->session->instansi_id);
      } elseif (is_superadmin() or is_admin()) {
        $this->data['get_all_combobox_divisi']      = $this->Divisi_model->get_all_combobox_by_cabang($this->session->cabang_id);
        $this->data['get_all_combobox_lokasi']      = $this->Lokasi_model->get_all_combobox_by_cabang($this->session->cabang_id);
        $this->data['get_all_combobox_user']        = $this->Auth_model->get_all_combobox_by_cabang($this->session->cabang_id);
        $this->data['get_all_combobox_rak']         = $this->Rak_model->get_all_combobox_by_cabang($this->session->cabang_id);
        $this->data['get_all_combobox_baris']       = $this->Baris_model->get_all_combobox_by_cabang($this->session->cabang_id);
        $this->data['get_all_combobox_box']         = $this->Box_model->get_all_combobox_by_cabang($this->session->cabang_id);
        $this->data['get_all_combobox_map']         = $this->Map_model->get_all_combobox_by_cabang($this->session->cabang_id);
      }

      $this->data['get_all_jenis_arsip'] = $this->Jenis_model->get_all();
      $this->data['arsip_files']         = $this->Arsip_model->get_files_id_result($this->data['arsip']->id_arsip);

      $this->data['id_arsip'] = [
        'name'          => 'id_arsip',
        'type'          => 'hidden',
      ];
      $this->data['no_arsip'] = [
        'name'          => 'no_arsip',
        'id'            => 'no_arsip',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['arsip_name'] = [
        'name'          => 'arsip_name',
        'id'            => 'arsip_name',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['rak_id'] = [
        'name'          => 'rak_id',
        'id'            => 'rak_id',
        'class'         => 'form-control',
        'required'      => '',
      ];
      $this->data['baris_id'] = [
        'name'          => 'baris_id',
        'id'            => 'baris_id',
        'class'         => 'form-control',
        'required'      => '',
      ];
      $this->data['lokasi_id'] = [
        'name'          => 'lokasi_id',
        'id'            => 'lokasi_id',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'autofocus'     => '',
        'required'      => '',
      ];
      $this->data['box_id'] = [
        'name'          => 'box_id',
        'id'            => 'box_id',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['map_id'] = [
        'name'          => 'map_id',
        'id'            => 'map_id',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['deskripsi_arsip'] = [
        'name'          => 'deskripsi_arsip',
        'id'            => 'deskripsi_arsip',
        'class'         => 'form-control',
        'rows'          => '5',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['masa_retensi'] = [
        'name'          => 'masa_retensi',
        'id'            => 'masa_retensi',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['link_gdrive'] = [
        'name'          => 'link_gdrive',
        'id'            => 'link_gdrive',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
      ];
      $this->data['instansi_id'] = [
        'name'          => 'instansi_id',
        'id'            => 'instansi_id',
        'class'         => 'form-control',
        'onChange'      => 'tampilCabang()',
        'required'      => ''
      ];
      $this->data['cabang_id'] = [
        'name'          => 'cabang_id',
        'id'            => 'cabang_id',
        'class'         => 'form-control',
        'onChange'      => 'tampilDivisi(); tampilLokasi(); tampilRak(); tampilBox(); tampilMap(); tampilBaris()',
        'required'      => ''
      ];
      $this->data['divisi_id'] = [
        'name'          => 'divisi_id',
        'id'            => 'divisi_id',
        'class'         => 'form-control',
        'onChange'      => 'tampilKepemilikanArsip()',
        'required'      => ''
      ];
      $this->data['lokasi_id'] = [
        'name'          => 'lokasi_id',
        'id'            => 'lokasi_id',
        'class'         => 'form-control',
        'required'      => ''
      ];
      $this->data['jenis_arsip_id'] = [
        'name'          => 'jenis_arsip_id[]',
        'id'            => 'jenis_arsip_id',
        'class'         => 'form-control select2',
        'multiple'      => '',
      ];
      $this->data['status_file'] = [
        'name'          => 'status_file',
        'id'            => 'status_file',
        'class'         => 'form-control',
      ];
      $this->data['user_id'] = [
        'name'          => 'user_id',
        'id'            => 'user_id',
        'class'         => 'form-control',
        'required'      => '',
      ];

      $this->load->view('back/arsip/arsip_edit', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/arsip');
    }
  }

  function update_action()
  {
    $this->form_validation->set_rules('lokasi_id', 'Lokasi Arsip', 'required');
    $this->form_validation->set_rules('rak_id', 'Rak', 'required');
    $this->form_validation->set_rules('box_id', 'Box', 'required');
    $this->form_validation->set_rules('map_id', 'Map', 'required');
    $this->form_validation->set_rules('baris_id', 'Baris', 'required');
    $this->form_validation->set_rules('arsip_name', 'Nama Arsip', 'trim|required');
    $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if (is_grandadmin()) {
      $instansi_id  = $this->input->post('instansi_id');
      $divisi_id    = $this->input->post('divisi_id');
      $cabang_id    = $this->input->post('cabang_id');
      $user_id      = $this->input->post('user_id');
    } elseif (is_masteradmin()) {
      $instansi_id  = $this->session->instansi_id;
      $divisi_id    = $this->input->post('divisi_id');
      $cabang_id    = $this->input->post('cabang_id');
      $user_id      = $this->input->post('user_id');
    } elseif (is_superadmin()) {
      $instansi_id  = $this->session->instansi_id;
      $cabang_id    = $this->session->cabang_id;
      $divisi_id    = $this->input->post('divisi_id');
      $user_id      = $this->input->post('user_id');
    } else {
      $instansi_id  = $this->session->instansi_id;
      $cabang_id    = $this->session->cabang_id;
      $divisi_id    = $this->session->divisi_id;
      $user_id      = $this->session->id_users;
    }

    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_arsip'));
    } else {
      if ($this->input->post('masa_retensi') == NULL) {
        $masa_retensi = NULL;
      } else {
        $masa_retensi = $this->input->post('masa_retensi');
        $tgl_retensi = new DateTime($this->input->post('masa_retensi'));
        $today = new DateTime(date('Y-m-d'));
        if ($tgl_retensi > $today) {
          $status_retensi = 1;
        } else {
          $status_retensi = 0;
        }
      }

      $data = array(
        'instansi_id'                     => $instansi_id,
        'cabang_id'                       => $cabang_id,
        'divisi_id'                       => $divisi_id,
        'user_id'                         => $user_id,
        'lokasi_id'                       => $this->input->post('lokasi_id'),
        'rak_id'                          => $this->input->post('rak_id'),
        'box_id'                          => $this->input->post('box_id'),
        'map_id'                          => $this->input->post('map_id'),
        'baris_id'                        => $this->input->post('baris_id'),
        'no_arsip'                        => $this->input->post('no_arsip'),
        'arsip_name'                      => $this->input->post('arsip_name'),
        'deskripsi_arsip'                 => $this->input->post('deskripsi_arsip'),
        'keterangan'                      => $this->input->post('keterangan'),
        'masa_retensi'                    => $masa_retensi,
        'status_retensi'                  => $status_retensi,
        'status_file'                     => $this->input->post('status_file'),
        'modified_by'                     => $this->session->userdata('username'),
      );

      // eksekusi query UPDATE
      $this->Arsip_model->update($this->input->post('id_arsip'), $data);

      write_log();

      $instansi     = $this->Instansi_model->get_by_id($instansi_id);
      $instansiName = $instansi->instansi_name;

      // kalau upload foto tambahan
      if (!empty($_FILES['file_upload']['name'])) {
        $filesCount = count($_FILES['file_upload']['name']);

        for ($i = 0; $i < $filesCount; $i++) {
          // File upload configuration          
          // atur lokasi upload berdasarkan nama instansi
          $config2['upload_path'] = './assets/file_arsip/' . $instansiName;
          if (!is_dir($config2['upload_path'])) {
            mkdir($config2['upload_path'], 0777, TRUE);
          }

          $config2['allowed_types']  = '*';

          $_FILES['file']['name']       = $_FILES['file_upload']['name'][$i];
          $_FILES['file']['type']       = $_FILES['file_upload']['type'][$i];
          $_FILES['file']['tmp_name']   = $_FILES['file_upload']['tmp_name'][$i];
          $_FILES['file']['error']      = $_FILES['file_upload']['error'][$i];
          $_FILES['file']['size']       = $_FILES['file_upload']['size'][$i];

          // Load and initialize upload library
          $this->load->library('upload', $config2);
          $this->upload->initialize($config2);

          // Upload file to server
          if (!$this->upload->do_upload('file')) {
            //file gagal diupload -> kembali ke form tambah
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('message', '<div class="col-lg-12"><div class="alert alert-danger alert">' . $error['error'] . '</div></div>');

            $this->update($this->input->post('id_arsip'));
          } else {
            // Uploaded file data
            $fileData = $this->upload->data();

            $datas = array(
              'arsip_id'        => $this->input->post('id_arsip'),
              'file_upload'     => $fileData['file_name'],
              'created_by'      => $this->session->userdata('username'),
            );

            // Insert files data into the database
            $this->Arsip_model->insert_files($datas);
          }
        }
      }

      if (!empty($this->input->post('jenis_arsip_id'))) {
        $this->db->where('arsip_id', $this->input->post('id_arsip'));
        $this->db->delete('arsip_jenis');

        $jenis_arsip_id = count($this->input->post('jenis_arsip_id'));

        for ($i_jenis_arsip_id = 0; $i_jenis_arsip_id < $jenis_arsip_id; $i_jenis_arsip_id++) {
          $datas_jenis_arsip_id[$i_jenis_arsip_id] = array(
            'arsip_id'          => $this->input->post('id_arsip'),
            'jenis_arsip_id'    => $this->input->post('jenis_arsip_id[' . $i_jenis_arsip_id . ']'),
          );

          $this->db->insert('arsip_jenis', $datas_jenis_arsip_id[$i_jenis_arsip_id]);

          write_log();
        }
      }

      $this->session->set_flashdata('message', '<div class="alert alert-success alert">Data berhasil disimpan</div>');
      redirect(base_url('admin/arsip'));
    }
  }

  function delete($id)
  {
    is_delete();

    $delete = $this->Arsip_model->get_by_id($id);

    if ($delete) {
      $data = array(
        'is_delete'   => '1',
        'deleted_by'  => $this->session->arsip_name,
        'deleted_at'  => date('Y-m-d H:i:a'),
      );

      $this->Arsip_model->soft_delete($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus</div>');
      redirect('admin/arsip');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/arsip');
    }
  }

  public function ajax_delete($id)
  {
    $row = $this->Arsip_model->get_by_id($id);

    // jika punya dia sendiri (admin) maka tampilkan semua tombol
    if (is_admin() && $row->user_id != $this->session->id_users) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak mengubah data orang lain</div>');
      redirect('admin/arsip');
    } else {
      if ($row) {
        $instansi     = $this->Instansi_model->get_by_id($row->instansi_id);
        $instansiName = $instansi->instansi_name;

        // ambil detail arsip_files        
        $this->db->from('arsip_files');
        $this->db->where('arsip_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
          $file_name         = "assets/file_arsip/" . $instansiName . "/" . $row->file_upload;

          // Hapus file
          unlink($file_name);
        }

        $this->Arsip_model->delete_by_id($id);

        // hapus data tabel arsip_files
        $this->db->where('arsip_id', $id);
        $this->db->delete('arsip_files');

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus permanen beserta filenya</div>');
        redirect('admin/arsip/deleted_list');
      }
    }
  }

  public function delete_files_by_id($id)
  {
    $data = $this->File_model->get_by_id($id);

    $instansi     = $this->Instansi_model->get_by_id($data->instansi_id);
    $instansiName = $instansi->instansi_name;

    if ($data) {
      // menyimpan lokasi gambar dalam variable
      $file_name         = "assets/file_arsip/" . $instansiName . "/" . $data->file_upload;

      // Hapus foto
      unlink($file_name);

      $this->File_model->delete_by_id($id);

      $this->session->set_flashdata('message', '
      <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
        File berhasil dihapus
      </div>');
      redirect('admin/arsip/update/' . $data->arsip_id);
    } else {
      $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
					File tidak ditemukan
        </div>');
      redirect('admin/arsip/update/' . $data->arsip_id);
    }
  }

  function deleted_list()
  {
    is_restore();

    $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

    if (is_grandadmin()) {
      $this->data['get_all_deleted'] = $this->Arsip_model->get_all_deleted();
      $this->load->view('back/arsip/arsip_deleted_list_grandadmin', $this->data);
    } elseif (is_masteradmin()) {
      $this->data['get_all_deleted'] = $this->Arsip_model->get_all_deleted_by_instansi();
      $this->load->view('back/arsip/arsip_deleted_list_masteradmin', $this->data);
    } elseif (is_superadmin()) {
      $this->data['get_all_deleted'] = $this->Arsip_model->get_all_deleted_by_cabang();
      $this->load->view('back/arsip/arsip_deleted_list_superadmin', $this->data);
    } elseif (is_admin()) {
      $this->data['get_all_deleted'] = $this->Arsip_model->get_all_deleted_by_divisi();
      $this->load->view('back/arsip/arsip_deleted_list_admin', $this->data);
    }
  }

  function restore($id)
  {
    is_restore();

    $row = $this->Arsip_model->get_by_id($id);

    // jika punya dia sendiri (admin) maka tampilkan semua tombol
    if (is_admin() && $row->user_id != $this->session->id_users) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak mengubah data orang lain</div>');
      redirect('admin/arsip');
    } else {
      if ($row) {
        $data = array(
          'is_delete'   => '0',
          'deleted_by'  => NULL,
          'deleted_at'  => NULL,
        );

        $this->Arsip_model->update($id, $data);

        write_log();

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dikembalikan</div>');
        redirect('admin/arsip/deleted_list');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
        redirect('admin/arsip');
      }
    }
  }

  function pilih_arsip()
  {
    $this->data['arsip']  = $this->Arsip_model->get_all_combobox_by_divisi($this->uri->segment(4));
    $this->load->view('back/arsip/v_arsip', $this->data);
  }

  function pilih_arsip_available()
  {
    $this->data['arsip']  = $this->Arsip_model->get_all_combobox_arsip_available_by_divisi($this->uri->segment(4));

    $this->load->view('back/arsip/v_arsip', $this->data);
  }

  function check_no_arsip()
  {
    $no_arsip = $this->input->post('no_arsip');

    $check_no_arsip     = $this->Arsip_model->get_no_arsip_by_instansi($no_arsip);

    if ($check_no_arsip) {
      // var_dump($check_no_arsip);
      echo "<div class='text-red'>Nomor Arsip telah ada, silahkan ganti yang lain</div>";
    } else {
      // var_dump($check_no_arsip);
      echo "<div class='text-green'>Nomor Arsip tersedia</div>";
    }
  }

  function check_arsip_name()
  {
    $arsip_name = $this->input->post('arsip_name');

    $check_arsip_name     = $this->Arsip_model->get_arsip_name_by_cabang($arsip_name);

    if ($check_arsip_name) {
      // var_dump($check_no_arsip);
      echo "<div class='text-red'>Nama Arsip telah ada, silahkan ganti yang lain</div>";
    } else {
      // var_dump($check_no_arsip);
      echo "<div class='text-green'>Nama Arsip tersedia</div>";
    }
  }
}
