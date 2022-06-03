<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_model extends CI_Model{

  public $table = 'jenis_arsip';
  public $id    = 'id_jenis';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->order_by($this->id, $this->order);
    $this->db->where('is_delete_jenis', '0');
    return $this->db->get($this->table)->result();
  }

  function get_all_combobox()
  {
    $this->db->order_by('jenis_name');
    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[$row['id_jenis']] = $row['jenis_name'];
      }
      return $result;
    }
  }

  function get_all_jenis_arsip_old($id)
  {
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'left');
    $this->db->where('arsip_jenis.arsip_id', $id);
    return $this->db->get('arsip_jenis')->result();
  }

  function get_all_deleted()
  {
    $this->db->where('is_delete_jenis', '1');
    $this->db->order_by('jenis_name', $this->order);
    return $this->db->get($this->table)->result();
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

  function soft_delete($id,$data)
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
