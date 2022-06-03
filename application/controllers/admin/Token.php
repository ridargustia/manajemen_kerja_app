<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Token extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Akun Google';

    $this->load->helper('gdrive');

    $this->load->model(array('Token_model'));

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
    $this->data['add_action'] = base_url('admin/token/create');

    is_login();

    if(!is_grandadmin())
    {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }
  }

  function index()
  {
    is_read();

    $this->data['page_title'] = 'Data ' . $this->data['module'];

    $this->load->view('back/tokens/tokens_list', $this->data);
  }

  public function ajax_list()
  {
    $list = $this->Token_model->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $token) {
      $no++;

			$row = array();
      $row[] = '<p style="text-align: center">'.$no++.'</p>';
			$row[] = '<p style="text-align: center">'.$token->email.'</p>';
      $row[] = '<p style="text-align: center">'.$token->instansi_name.'</p>';
      $row[] = '<p style="text-align: center">'.$token->folder_name.'</p>';
      $row[] = '
      <p style="text-align: center">
        <a class="btn btn-sm btn-warning" href=" '.base_url('admin/token/update/'.$token->id_tokens).' " title="Edit"><i class="fa fa-pencil"></i></a>
        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_token(' . "'" . $token->id_tokens . "'" . ')"><i class="fa fa-trash"></i></a>
      </p>';
      $data[] = $row;
    }

    $output = array(
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->Token_model->count_all(),
      "recordsFiltered" => $this->Token_model->count_filtered(),
      "data"            => $data,
    );
    //output to json format
    echo json_encode($output);
  }

  function update($id)
  {
    is_update();

    $this->data['tokens']     = $this->Token_model->get_by_id($id);    

    if ($this->data['tokens']) {
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/token/update_action';

      $this->data['get_all_combobox_instansi']  = $this->Instansi_model->get_all_combobox();

      $this->data['id_tokens'] = [
        'name'          => 'id_tokens',
        'type'          => 'hidden',
      ];
      $this->data['instansi_id'] = [
        'name'          => 'instansi_id',
        'id'            => 'instansi_id',
        'class'         => 'form-control',        
        'required'      => '',
      ];
      $this->data['folder_name'] = [
        'name'          => 'folder_name',
        'id'            => 'folder_name',
        'class'         => 'form-control',
        'required'      => '',
      ];

      $this->load->view('back/tokens/tokens_edit', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/token');
    }
  }

  function update_action()
  {
    $this->form_validation->set_rules('instansi_id', 'Nama Instansi', 'trim|required');
    $this->form_validation->set_rules('folder_name', 'Nama Folder', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    
    if ($this->form_validation->run() === FALSE) {
      $this->update($this->input->post('id_tokens'));
    } else {
      $data = array(
        'instansi_id'     => $this->input->post('instansi_id'),
        'folder_name'     => $this->input->post('folder_name'),
        'modified_by'     => $this->session->username,
      );

      $this->Token_model->update($this->input->post('id_tokens'), $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil disimpan</div>');
      redirect('admin/token');
    }
  }

  public function ajax_delete($id)
  {
    $this->Token_model->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }

  function delete($id)
  {
    is_delete();

    $delete = $this->Token_model->get_by_id($id);

    if ($delete) {
      $data = array(
        'is_delete_token'   => '1',
        'deleted_by'        => $this->session->username,
        'deleted_at'        => date('Y-m-d H:i:a'),
      );

      $this->Token_model->soft_delete($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus</div>');
      redirect('admin/token');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/token');
    }
  }

  public function postAuthUrlRequest()
  {
    include 'third-party/gdrive.php';

    $response = array();
    $response['response_status'] = true;
    $response['auth_url'] = getClient();
    
    echo json_encode($response);
  }

  function pilih_folder()
  {
    $id   = $this->input->post('email');
    $data = $this->Token_model->get_by_id($id);

    echo json_encode($data);
  }
}
