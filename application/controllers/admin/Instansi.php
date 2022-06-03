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

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $this->data['page_title'] = 'Data ' . $this->data['module'];

    $this->data['get_all'] = $this->Instansi_model->get_all();

    $this->load->view('back/instansi/instansi_list', $this->data);
  }

  function create()
  {
    is_create();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
    $this->data['action']     = 'admin/instansi/create_action';

    $this->data['instansi_name'] = [
      'name'          => 'instansi_name',
      'id'            => 'instansi_name',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_name'),
    ];
    $this->data['instansi_phone'] = [
      'name'          => 'instansi_phone',
      'id'            => 'instansi_phone',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_phone'),
    ];
    $this->data['instansi_address'] = [
      'name'          => 'instansi_address',
      'id'            => 'instansi_address',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_address'),
    ];
    $this->data['active_date'] = [
      'name'          => 'active_date',
      'id'            => 'active_date',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('active_date'),
    ];

    $this->load->view('back/instansi/instansi_add', $this->data);
  }

  function create_action()
  {
    $this->form_validation->set_rules('instansi_name', 'Nama Instansi', 'trim|required');
    $this->form_validation->set_rules('instansi_phone', 'No. HP / Telpon', 'trim|required');
    $this->form_validation->set_rules('instansi_address', 'Alamat', 'trim|required');
    $this->form_validation->set_rules('active_date', 'Aktif Sampai', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if ($this->form_validation->run() === FALSE) {
      $this->create();
    } else {
      if ($_FILES['photo']['error'] <> 4) {
        $nmfile = strtolower(url_title($this->input->post('instansi_name'))) . date('YmdHis');

        $config['upload_path']      = './assets/images/instansi/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048; // 2Mb
        $config['file_name']        = $nmfile;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');

          $this->create();
        } else {
          $photo = $this->upload->data();

          $config['image_library']    = 'gd2';
          $config['source_image']     = './assets/images/instansi/' . $photo['file_name'] . '';
          $config['create_thumb']     = TRUE;
          $config['maintain_ratio']   = TRUE;
          $config['width']            = 250;
          $config['height']           = 250;

          $this->load->library('image_lib', $config);
          $this->image_lib->resize();

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

          $this->Instansi_model->insert($data);

          write_log();

          $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');
          redirect('admin/instansi');
        }
      } else {
        $data = array(
          'instansi_name'       => $this->input->post('instansi_name'),
          'instansi_address'    => $this->input->post('instansi_address'),
          'instansi_phone'      => $this->input->post('instansi_phone'),
          'active_date'         => $this->input->post('active_date'),
          'is_active'           => '1',
          'created_by'          => $this->session->username,
        );

        $this->Instansi_model->insert($data);

        write_log();

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');
        redirect('admin/instansi');
      }
    }
  }

  function update($id)
  {
    is_update();

    $this->data['instansi']     = $this->Instansi_model->get_by_id($id);

    if (is_superadmin() or is_masteradmin() && $this->data['instansi']->id_instansi != $this->session->instansi_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak mengubah data orang lain</div>');
      redirect('admin/dashboard');
    }

    if ($this->data['instansi']) {
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/instansi/update_action';

      $this->data['id_instansi'] = [
        'name'          => 'id_instansi',
        'type'          => 'hidden',
      ];

      if (is_grandadmin()) {
        $this->data['instansi_name'] = [
          'name'          => 'instansi_name',
          'id'            => 'instansi_name',
          'class'         => 'form-control',
          'autocomplete'  => 'off',
          'required'      => '',
        ];
      }
      $this->data['instansi_phone'] = [
        'name'          => 'instansi_phone',
        'id'            => 'instansi_phone',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['instansi_address'] = [
        'name'          => 'instansi_address',
        'id'            => 'instansi_address',
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

      $this->load->view('back/instansi/instansi_edit', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/instansi');
    }
  }

  function update_action()
  {
    // $this->form_validation->set_rules('instansi_name', 'Nama Instansi', 'trim|required');
    $this->form_validation->set_rules('instansi_phone', 'No. HP / Telpon', 'trim|required');
    $this->form_validation->set_rules('instansi_address', 'Alamat', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if ($this->input->post('active_date') < date('Y-m-d')) {
      $is_active = '0';
    } else {
      $is_active = '1';
    }

    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_instansi'));
    } else {
      if ($_FILES['photo']['error'] <> 4) {
        $nmfile = strtolower(url_title($this->input->post('instansi_name'))) . date('YmdHis');

        $config['upload_path']      = './assets/images/instansi/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048; // 2Mb
        $config['file_name']        = $nmfile;

        $this->load->library('upload', $config);

        $delete = $this->Instansi_model->get_by_id($this->input->post('id_instansi'));

        $dir        = "./assets/images/instansi/" . $delete->instansi_img;
        $dir_thumb  = "./assets/images/instansi/" . $delete->instansi_img_thumb;

        if (is_file($dir)) {
          unlink($dir);
          unlink($dir_thumb);
        }

        if (!$this->upload->do_upload('photo')) {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');

          $this->update($this->input->post('id_instansi'));
        } else {
          $photo = $this->upload->data();

          $config['image_library']    = 'gd2';
          $config['source_image']     = './assets/images/instansi/' . $photo['file_name'] . '';
          $config['create_thumb']     = TRUE;
          $config['maintain_ratio']   = TRUE;
          $config['width']            = 250;
          $config['height']           = 250;

          $this->load->library('image_lib', $config);
          $this->image_lib->resize();

          if (is_grandadmin()) {
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
            } else {
              $data = array(
                'instansi_name'       => $this->input->post('instansi_name'),
                'instansi_address'    => $this->input->post('instansi_address'),
                'instansi_phone'      => $this->input->post('instansi_phone'),
                'instansi_img'        => $this->upload->data('file_name'),
                'instansi_img_thumb'  => $nmfile . '_thumb' . $this->upload->data('file_ext'),
                'modified_by'         => $this->session->username,
              );
            }
          } else {
            if ($this->input->post('active_date') != NULL) {
              $data = array(
                'instansi_address'    => $this->input->post('instansi_address'),
                'instansi_phone'      => $this->input->post('instansi_phone'),
                'active_date'         => $this->input->post('active_date'),
                'is_active'           => $is_active,
                'instansi_img'        => $this->upload->data('file_name'),
                'instansi_img_thumb'  => $nmfile . '_thumb' . $this->upload->data('file_ext'),
                'modified_by'         => $this->session->username,
              );
            } else {
              $data = array(
                'instansi_address'    => $this->input->post('instansi_address'),
                'instansi_phone'      => $this->input->post('instansi_phone'),
                'instansi_img'        => $this->upload->data('file_name'),
                'instansi_img_thumb'  => $nmfile . '_thumb' . $this->upload->data('file_ext'),
                'modified_by'         => $this->session->username,
              );
            }
          }

          $this->Instansi_model->update($this->input->post('id_instansi'), $data);

          write_log();

          $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');

          if (is_grandadmin()) {
            redirect('admin/instansi');
          } else {
            redirect('admin/instansi/update/' . $this->session->instansi_id);
          }
        }
      } else {
        if (is_grandadmin()) {
          if ($this->input->post('active_date') != NULL) {
            $data = array(
              'instansi_name'       => $this->input->post('instansi_name'),
              'instansi_address'    => $this->input->post('instansi_address'),
              'instansi_phone'      => $this->input->post('instansi_phone'),
              'active_date'         => $this->input->post('active_date'),
              'is_active'           => $is_active,              
              'modified_by'         => $this->session->username,
            );
          } else {
            $data = array(
              'instansi_name'       => $this->input->post('instansi_name'),
              'instansi_address'    => $this->input->post('instansi_address'),
              'instansi_phone'      => $this->input->post('instansi_phone'),              
              'modified_by'         => $this->session->username,
            );
          }
        } else {
          if ($this->input->post('active_date') != NULL) {
            $data = array(
              'instansi_address'    => $this->input->post('instansi_address'),
              'instansi_phone'      => $this->input->post('instansi_phone'),
              'active_date'         => $this->input->post('active_date'),
              'is_active'           => $is_active,              
              'modified_by'         => $this->session->username,
            );
          } else {
            $data = array(
              'instansi_address'    => $this->input->post('instansi_address'),
              'instansi_phone'      => $this->input->post('instansi_phone'),              
              'modified_by'         => $this->session->username,
            );
          }
        }

        $this->Instansi_model->update($this->input->post('id_instansi'), $data);

        write_log();

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');

        if (is_grandadmin()) {
          redirect('admin/instansi');
        } else {
          redirect('admin/instansi/update/' . $this->session->instansi_id);
        }
      }
    }
  }

  function delete($id)
  {
    is_delete();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $delete = $this->Instansi_model->get_by_id($id);

    if ($delete) {
      $data = array(
        'is_delete_instansi'   => '1',
        'deleted_by'        => $this->session->username,
        'deleted_at'        => date('Y-m-d H:i:a'),
      );

      $this->Instansi_model->soft_delete($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus</div>');
      redirect('admin/instansi');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/instansi');
    }
  }

  function delete_permanent($id)
  {
    is_delete();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    $delete = $this->Instansi_model->get_by_id($id);

    if ($delete) {
      $this->Instansi_model->delete($id);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus permanen</div>');
      redirect('admin/instansi/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
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
