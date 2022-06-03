<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dataaccess_model extends CI_Model{

  public $table = 'data_access';
  public $id    = 'id_data_access';
  public $order = 'DESC';

  function get_all()
  {
    return $this->db->get($this->table)->result();
  }

  function get_all_combobox()
  {
    $this->db->order_by('data_access_name');
    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[$row['id_data_access']] = $row['data_access_name'];
      }
      return $result;
    }
  }

  function get_all_data_access_old($id)
  {
    $this->db->join('data_access', 'users_data_access.data_access_id = data_access.id_data_access', 'left');
    $this->db->where('users_data_access.user_id', $id);
    return $this->db->get('users_data_access')->result();
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
