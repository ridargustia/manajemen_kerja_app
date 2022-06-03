<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model{

  public $table = 'company';
  public $id    = 'id_company';
  public $order = 'DESC';

  function company_profile()
  {
    $this->db->where($this->id, '1');
    return $this->db->get($this->table)->row();
  }

  function get_by_id($id)
  {
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }

  function insert($data)
  {
    $this->db->insert($this->table, $data);
  }

  function update($id,$data)
  {
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);
  }

  function delete($id)
  {
    $this->db->where($this->id, $id);
    $this->db->delete($this->table);
  }

  function lock_account($id,$data)
  {
    $this->db->where('username', $id);
    $this->db->update($this->table, $data);
  }

  // login attempt
  function get_total_login_attempts_per_user($id)
  {
    $this->db->where('username', $id);
    return $this->db->get('login_attempts')->num_rows();
  }

  function insert_login_attempt($data)
  {
    $this->db->insert('login_attempts', $data);
  }

  function clear_login_attempt($id)
  {
    $this->db->where('username', $id);
    $this->db->delete('login_attempts');
  }

}
