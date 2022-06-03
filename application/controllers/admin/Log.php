<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->model('Log_model');

    $this->data['module'] = 'Log';

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert">', '</div>');

    // login check
    is_login();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }
  }

  public function index()
  {
    $this->data['page_title'] = 'Data '.$this->data['module'];
    $this->data['add_new_data'] = site_url('log/create');

    $this->load->view('back/log/log_list', $this->data);
  }

  public function ajax_list()
	{
		//get_datatables terletak di model
    $list = $this->Log_model->get_datatables();
    $data = array();
		$no = $_POST['start'];

    // Membuat loop/ perulangan
    foreach ($list as $data_log) {
			$no++;

			$row = array();
      $row[] = '<p style="text-align: center">'.datetime_indo($data_log->created_at).'</p>';
      $row[] = '<p style="text-align: left">'.$data_log->content.'</p>';
			$row[] = '<p style="text-align: center">'.$data_log->created_by.'</p>';
			$row[] = '<p style="text-align: center">'.$data_log->ip_address.'</p>';
      $row[] = '<p style="text-align: left">'.$data_log->user_agent.'</p>';

      $data[] = $row;
    }

    $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->Log_model->count_all(),
              "recordsFiltered" => $this->Log_model->count_filtered(),
              "data" => $data
              );
    //output to json format
    echo json_encode($output);
  }

}
