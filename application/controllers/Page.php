<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller{

  public function __construct()
  {
    parent::__construct();

    $this->data['company_data']    					= $this->Company_model->company_profile();
    $this->data['footer']            = $this->Footer_model->footer();

    is_active_instansi_front();
  }

  function profile()
  {
    $this->data['page_title'] = 'Company Profile';

    $this->load->view('front/page/profile', $this->data);
  }

}
