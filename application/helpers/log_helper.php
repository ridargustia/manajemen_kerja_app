<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  function write_log()
  {
    $CI =& get_instance();

    $data = array(
      'content'    => $CI->db->last_query(),
      'created_by' => $CI->session->name,
      'ip_address' => $CI->input->ip_address(),
      'user_agent' => $CI->input->user_agent(),
    );

    $CI->db->insert('log_queries', $data);
  }

  function write_log_cronjobs_retensi_arsip()
  {
    $CI =& get_instance();

    $data = array(
      'content'    => $CI->db->last_query(),
      'created_by' => 'cronjobs_retensi_arsip',
      'ip_address' => $CI->input->ip_address(),
      'user_agent' => $CI->input->user_agent(),
    );

    $CI->db->insert('log_queries', $data);
  }

  function write_log_cronjobs_inactive_instansi()
  {
    $CI =& get_instance();

    $data = array(
      'content'    => $CI->db->last_query(),
      'created_by' => 'cronjobs_inactive_instansi',
      'ip_address' => $CI->input->ip_address(),
      'user_agent' => $CI->input->user_agent(),
    );

    $CI->db->insert('log_queries', $data);
  }

?>
