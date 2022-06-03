<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menuaccess_model extends CI_Model
{

  public $table = 'menu_access';
  public $id    = 'id_menu_access';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->join('usertype', 'menu_access.usertype_id = usertype.id_usertype');
    $this->db->join('menu', 'menu_access.menu_id = menu.id_menu');
    $this->db->join('submenu', 'menu_access.submenu_id = submenu.id_submenu', 'left');
    return $this->db->get($this->table)->result();
  }

  function get_menuAccess_by_user()
  {
    $this->db->join('usertype', 'menu_access.usertype_id = usertype.id_usertype');
    $this->db->join('menu', 'menu_access.menu_id = menu.id_menu');
    $this->db->join('submenu', 'menu_access.submenu_id = submenu.id_submenu', 'left');

    $this->db->where('usertype_id', $this->session->usertype_id);
    $this->db->where('menu_controller', $this->uri->segment(2));

    return $this->db->get($this->table)->row();
  }

  function get_subMenuAccess_by_user()
  {
    $this->db->join('usertype', 'menu_access.usertype_id = usertype.id_usertype');
    $this->db->join('menu', 'menu_access.menu_id = menu.id_menu');
    $this->db->join('submenu', 'menu_access.submenu_id = submenu.id_submenu', 'left');

    $this->db->where('usertype_id', $this->session->usertype_id);
    $this->db->where('menu_controller', $this->uri->segment(2));
    $this->db->where('submenu_function', $this->uri->segment(3));

    return $this->db->get($this->table)->row();
  }

  function get_all_combobox()
  {
    $this->db->order_by('name');
    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Please Choose Users';
        $result[$row['id_menu_access']] = $row['name'];
      }
      return $result;
    }
  }

  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function get_all_deleted()
  {
    $this->db->join('usertype', 'menu_access.usertype = usertype.id_usertype');
    $this->db->where('is_delete', '1');
    $this->db->order_by('name', $this->order);
    return $this->db->get($this->table)->result();
  }

  function get_by_id($id)
  {
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }

  function get_by_username($id)
  {
    $this->db->where('username', $id);
    return $this->db->get($this->table)->row();
  }

  function get_by_email($id)
  {
    $this->db->select('email');
    $this->db->where('email', $id);
    return $this->db->get($this->table)->row();
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

  function update_by_email($id, $data)
  {
    $this->db->where('email', $id);
    $this->db->update($this->table, $data);
  }

  function get_by_code_forgotten($code)
  {
    $this->db->where('code_forgotten', $code);
    return $this->db->get($this->table);
  }

  function update_by_code_forgotten($id, $data)
  {
    $this->db->where('code_forgotten', $id);
    $this->db->update($this->table, $data);
  }

  function soft_delete($id, $data)
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

  function get_access_read()
  {
    $this->db->select('id_menu_access, data_access_id');
    $this->db->join('menu_access_data_access', 'menu_access.id_menu_access = menu_access_data_access.user_id', 'left');
    $this->db->where('id_menu_access', $this->session->id_menu_access);
    $this->db->where('data_access_id', '1');
    return $this->db->get($this->table)->row();
  }

  function get_access_create()
  {
    $this->db->select('id_menu_access, data_access_id');
    $this->db->join('menu_access_data_access', 'menu_access.id_menu_access = menu_access_data_access.user_id', 'left');
    $this->db->where('id_menu_access', $this->session->id_menu_access);
    $this->db->where('data_access_id', '2');
    return $this->db->get($this->table)->row();
  }

  function get_access_update()
  {
    $this->db->select('id_menu_access, data_access_id');
    $this->db->join('menu_access_data_access', 'menu_access.id_menu_access = menu_access_data_access.user_id', 'left');
    $this->db->where('id_menu_access', $this->session->id_menu_access);
    $this->db->where('data_access_id', '3');
    return $this->db->get($this->table)->row();
  }

  function get_access_delete()
  {
    $this->db->select('id_menu_access, data_access_id');
    $this->db->join('menu_access_data_access', 'menu_access.id_menu_access = menu_access_data_access.user_id', 'left');
    $this->db->where('id_menu_access', $this->session->id_menu_access);
    $this->db->where('data_access_id', '4');
    return $this->db->get($this->table)->row();
  }

  function get_access_restore()
  {
    $this->db->select('id_menu_access, data_access_id');
    $this->db->join('menu_access_data_access', 'menu_access.id_menu_access = menu_access_data_access.user_id', 'left');
    $this->db->where('id_menu_access', $this->session->id_menu_access);
    $this->db->where('data_access_id', '5');
    return $this->db->get($this->table)->row();
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
