<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  function is_active_instansi_front()
  {
    $CI =& get_instance();

    $instansi_is_active = $CI->session->instansi_is_active;

    if($instansi_is_active == '0')
    {
      $CI->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak dapat login karna instansi belum memperpanjang masa aktif akun. Silahkan hubungi MasterAdmin.</div>');

      redirect('auth/login');
    }
  }

  function is_active_instansi_back()
  {
    $CI =& get_instance();

    $instansi_is_active = $CI->session->instansi_is_active;

    if($instansi_is_active == '0')
    {
      $CI->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak dapat login karna instansi belum memperpanjang masa aktif akun. Silahkan hubungi MasterAdmin.</div>');

      redirect('admin/auth/login');
    }
  }
