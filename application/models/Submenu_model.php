<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submenu_model extends CI_Model
{

  public $table = 'submenu';
  public $id    = 'id_submenu';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->select('id_menu, menu_id, menu_name, id_submenu, submenu_name, submenu_function, submenu.order_no');
    $this->db->join('menu', 'submenu.menu_id = menu.id_menu');
    return $this->db->get($this->table)->result();
  }

  function get_all_combobox($id)
  {
    $this->db->where('menu_id', $id);
    $this->db->order_by('submenu_name');
    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Please Choose Submenu';
        $result[$row['id_submenu']] = $row['submenu_name'];
      }
      return $result;
    }
  }

  function get_by_id($id)
  {
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }

  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function insert($data)
  {
    $this->db->insert($this->table, $data);
  }

  function update($id, $data)
  {
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);
  }

  function delete($id)
  {
    $this->db->where($this->id, $id);
    $this->db->delete($this->table);
  }

  function lock_account($id, $data)
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
