<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Policy extends CI_Controller{

  function privacy()
  {
    $this->load->view('front/policy/privacy');
  }

}
