<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usertype_model extends CI_Model{

  public $table = 'usertype';
  public $id    = 'id_usertype';
  public $order = 'DESC';

  function get_all()
  {
    return $this->db->get($this->table)->result();
  }

  function get_all_combobox()
  {
    $this->db->order_by('id_usertype');
    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Please Choose Usertype';
        $result[$row['id_usertype']] = $row['usertype_name'];
      }
      return $result;
    }
  }

  function get_all_combobox_by_instansi()
  {
    $this->db->where('id_usertype >', '1');
    $this->db->where('id_usertype <', '5');

    $this->db->order_by('id_usertype');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Usertype';
        $result[$row['id_usertype']] = $row['usertype_name'];
      }
      return $result;
    }
  }

  function get_all_combobox_by_cabang()
  {
    $this->db->where('id_usertype >', '2');
    $this->db->where('id_usertype <', '5');

    $this->db->order_by('id_usertype');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Usertype';
        $result[$row['id_usertype']] = $row['usertype_name'];
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

}
