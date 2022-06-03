<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

  public $table = 'users';
  public $id    = 'id_users';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->select('
      users.id_users, users.name, users.gender, users.username, users.email, users.divisi_id, users.cabang_id, users.instansi_id, users.usertype_id, users.is_active, users.is_delete,
      usertype.usertype_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');
    $this->db->join('usertype', 'users.usertype_id = usertype.id_usertype', 'left');
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'users.cabang_id = cabang.id_cabang', 'left');
    $this->db->join('divisi', 'users.divisi_id = divisi.id_divisi', 'left');

    $this->db->where('is_delete', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function check_by_name_and_instansi_and_cabang_and_divisi($name, $instansi_id, $cabang_id, $divisi_id)
  {
    $this->db->where('username', $name);
    $this->db->where('instansi_id', $instansi_id);
    $this->db->where('cabang_id', $cabang_id);
    $this->db->where('divisi_id', $divisi_id);

    return $this->db->get($this->table)->row();
  }

  function get_all_by_instansi()
  {
    $this->db->select('
      users.id_users, users.name, users.gender, users.username, users.email, users.divisi_id, users.cabang_id, users.instansi_id, users.usertype_id, users.is_active, users.is_delete,
      usertype.usertype_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');
    $this->db->join('usertype', 'users.usertype_id = usertype.id_usertype', 'left');
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'users.cabang_id = cabang.id_cabang', 'left');
    $this->db->join('divisi', 'users.divisi_id = divisi.id_divisi', 'left');

    $this->db->where('users.instansi_id', $this->session->instansi_id);
    $this->db->where('users.usertype_id >', '1');
    $this->db->where('users.usertype_id <', '5');
    $this->db->where('is_delete', '0');

    $this->db->order_by('name', $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_cabang()
  {
    $this->db->select('
      users.id_users, users.name, users.gender, users.username, users.email, users.divisi_id, users.cabang_id, users.instansi_id, users.usertype_id, users.is_active, users.is_delete,
      usertype.usertype_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'users.cabang_id = cabang.id_cabang', 'left');
    $this->db->join('divisi', 'users.divisi_id = divisi.id_divisi', 'left');
    $this->db->join('usertype', 'users.usertype_id = usertype.id_usertype', 'left');

    $this->db->where('users.cabang_id', $this->session->cabang_id);
    $this->db->where('users.usertype_id >', '2');
    $this->db->where('users.usertype_id <', '5');
    $this->db->where('is_delete', '0');

    $this->db->order_by('name', $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_combobox_by_divisi_update($divisi_id)
  {
    $this->db->order_by('name');

    $this->db->where('divisi_id', $divisi_id);
    $this->db->where('is_delete', '0');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$row['id_users']] = $row['name'];
      }
      return $result;
    }
  }

  function get_all_combobox()
  {
    $this->db->order_by('name');

    $this->db->where('is_delete', '0');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$row['id_users']] = $row['name'];
      }
      return $result;
    }
  }

  function get_all_combobox_sadmin_and_adminOnly()
  {
    $this->db->order_by('name');

    $this->db->where('usertype_id !=', '4');
    $this->db->where('is_delete', '0');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$row['id_users']] = $row['name'];
      }
      return $result;
    }
  }

  function get_all_combobox_grandAdmin_by_instansi($instansi_id)
  {
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('instansi_id', $instansi_id);    

    $this->db->order_by('name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$row['id_users']] = $row['name'];
      }
      return $result;
    }
  }

  function get_all_combobox_grandAdmin_by_cabang($cabang_id)
  {
    $this->db->join('cabang', 'users.cabang_id = cabang.id_cabang');

    $this->db->where('cabang_id', $cabang_id);    

    $this->db->order_by('name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$row['id_users']] = $row['name'];
      }
      return $result;
    }
  }

  function get_all_combobox_grandAdmin_by_divisi($divisi_id)
  {
    $this->db->join('divisi', 'users.divisi_id = divisi.id_divisi');    

    $this->db->where('divisi_id', $divisi_id);    

    $this->db->order_by('name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$row['id_users']] = $row['name'];
      }
      return $result;
    }
  }

  function get_all_combobox_by_instansi($instansi_id)
  {
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('instansi_id', $instansi_id);
    $this->db->where('usertype_id <', '4');

    $this->db->order_by('name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$row['id_users']] = $row['name'];
      }
      return $result;
    }
  }

  function get_all_combobox_by_cabang($cabang_id)
  {
    $this->db->join('cabang', 'users.cabang_id = cabang.id_cabang');

    $this->db->where('cabang_id', $cabang_id);    
    $this->db->where('usertype_id <', '4');
    $this->db->where('usertype_id >', '1');

    $this->db->order_by('name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$row['id_users']] = $row['name'];
      }
      return $result;
    }
  }

  function get_all_combobox_by_divisi($divisi_id)
  {
    $this->db->join('divisi', 'users.divisi_id = divisi.id_divisi');    

    $this->db->where('divisi_id', $divisi_id);
    // $this->db->where('divisi.instansi_id', $this->session->instansi_id);
    $this->db->where('usertype_id', '4');

    $this->db->order_by('name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$row['id_users']] = $row['name'];
      }
      return $result;
    }
  }

  function get_all_combobox_by_pegawai_per_instansi()
  {
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);
    $this->db->where('usertype_id', '4');

    $this->db->order_by('name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$this->session->id_users] = $this->session->name;
        $result[$row['id_users']] = $row['name'];
      }
      return $result;
    }
  }

  function get_all_combobox_by_pegawai_per_divisi()
  {
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi');

    $this->db->where('divisi_id', $this->session->divisi_id);
    $this->db->where('instansi_id', $this->session->instansi_id);
    $this->db->where('usertype_id', '4');

    $this->db->order_by('name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Users -';
        $result[$this->session->id_users] = $this->session->name;
        $result[$row['id_users']] = $row['name'];
      }
    } else {
      $result[''] = '- Belum Ada Pegawai di Divisi Anda -';
    }
    return $result;
  }

  function get_all_deleted()
  {
    $this->db->join('usertype', 'users.usertype_id = usertype.id_usertype');
    $this->db->where('is_delete', '1');
    $this->db->order_by('name', $this->order);
    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_instansi()
  {
    $this->db->select('
      users.id_users, users.name, users.gender, users.username, users.email, users.divisi_id, users.cabang_id, users.instansi_id, users.usertype_id, users.is_active, users.is_delete,
      usertype.usertype_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');
    $this->db->join('usertype', 'users.usertype_id = usertype.id_usertype', 'left');
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'users.cabang_id = cabang.id_cabang', 'left');
    $this->db->join('divisi', 'users.divisi_id = divisi.id_divisi', 'left');

    $this->db->where('users.instansi_id', $this->session->instansi_id);
    $this->db->where('users.usertype_id >', '1');
    $this->db->where('users.usertype_id <', '5');
    $this->db->where('is_delete', '1');

    $this->db->order_by('name', $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_cabang()
  {
    $this->db->select('
      users.id_users, users.name, users.gender, users.username, users.email, users.divisi_id, users.cabang_id, users.instansi_id, users.usertype_id, users.is_active, users.is_delete,
      usertype.usertype_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');
    $this->db->join('usertype', 'users.usertype_id = usertype.id_usertype', 'left');
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'users.cabang_id = cabang.id_cabang', 'left');
    $this->db->join('divisi', 'users.divisi_id = divisi.id_divisi', 'left');

    $this->db->where('users.instansi_id', $this->session->instansi_id);
    $this->db->where('users.cabang_id', $this->session->cabang_id);
    $this->db->where('users.usertype_id >', '2');
    $this->db->where('users.usertype_id <', '5');
    $this->db->where('is_delete', '1');

    $this->db->order_by('name', $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_by_id($id)
  {
    $this->db->join('usertype', 'users.usertype_id = usertype.id_usertype');

    $this->db->where($this->id, $id);

    return $this->db->get($this->table)->row();
  }

  function get_user_by_instansi($id)
  {
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi');

    $this->db->where('username', $id);

    return $this->db->get($this->table)->row();
  }

  function get_user_by_divisi_combobox($divisi_id)
  {
    $this->db->where('divisi_id', $divisi_id);
    //$this->db->where('usertype_id !=', '4');

    $this->db->order_by('name');

    $sql = $this->db->get('users');

    if ($sql->num_rows() > 0) {
      foreach ($sql->result_array() as $row) {
        $result[''] = '- Silahkan Pilih User -';
        $result[$row['id_users']] = ucwords(strtolower($row['name']));
      }
    } else {
      $result['-'] = '- Belum Ada User -';
    }
    return $result;
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

  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_instansi()
  {
    $this->db->join('instansi', 'users.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);

    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_cabang()
  {
    $this->db->join('cabang', 'users.cabang_id = cabang.id_cabang');

    $this->db->where('cabang_id', $this->session->cabang_id);

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
    $this->db->select('id_users, data_access_id');
    $this->db->join('users_data_access', 'users.id_users = users_data_access.user_id', 'left');
    $this->db->where('id_users', $this->session->id_users);
    $this->db->where('data_access_id', '1');
    return $this->db->get($this->table)->row();
  }

  function get_access_create()
  {
    $this->db->select('id_users, data_access_id');
    $this->db->join('users_data_access', 'users.id_users = users_data_access.user_id', 'left');
    $this->db->where('id_users', $this->session->id_users);
    $this->db->where('data_access_id', '2');
    return $this->db->get($this->table)->row();
  }

  function get_access_update()
  {
    $this->db->select('id_users, data_access_id');
    $this->db->join('users_data_access', 'users.id_users = users_data_access.user_id', 'left');
    $this->db->where('id_users', $this->session->id_users);
    $this->db->where('data_access_id', '3');
    return $this->db->get($this->table)->row();
  }

  function get_access_delete()
  {
    $this->db->select('id_users, data_access_id');
    $this->db->join('users_data_access', 'users.id_users = users_data_access.user_id', 'left');
    $this->db->where('id_users', $this->session->id_users);
    $this->db->where('data_access_id', '4');
    return $this->db->get($this->table)->row();
  }

  function get_access_restore()
  {
    $this->db->select('id_users, data_access_id');
    $this->db->join('users_data_access', 'users.id_users = users_data_access.user_id', 'left');
    $this->db->where('id_users', $this->session->id_users);
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
