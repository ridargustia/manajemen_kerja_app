<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  function menuaccess_check()
  {
    $CI =& get_instance();

    if($CI->Menuaccess_model->get_menuAccess_by_user() == NULL)
    {
      $CI->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }
  }

  function submenuaccess_check()
  {
    $CI =& get_instance();

    if($CI->Menuaccess_model->get_subMenuAccess_by_user() == NULL)
    {
      $CI->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }
  }

?>
