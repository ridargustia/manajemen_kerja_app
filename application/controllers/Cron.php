<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function set_inactive_retensi_arsip()
  {
    $now = date('Y-m-d');

    $this->db->set('status_retensi', '0');
    $this->db->where('masa_retensi <', $now);
    $this->db->update("arsip");

    write_log_cronjobs_retensi_arsip();
  }

  function set_inactive_instansi()
  {
    $now = date('Y-m-d');

    $this->db->set('is_active', '0');
    $this->db->where('active_date <', $now);
    $this->db->update("instansi");

    write_log_cronjobs_inactive_instansi();
  }

}
