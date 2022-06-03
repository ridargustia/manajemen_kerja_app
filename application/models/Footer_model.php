<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Footer_model extends CI_Model
{

  public $table = 'footer';
  public $id    = 'id_footer';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->select('id_instansi, instansi_name, cabang.id_cabang, cabang.cabang_name, footer.id_footer, footer.footer_name, footer.instansi_id');

    $this->db->join('instansi', 'footer.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'footer.cabang_id = cabang.id_cabang', 'left');

    $this->db->where('is_delete_footer', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_by_id($id)
  {
    $this->db->where($this->id, $id);

    return $this->db->get($this->table)->row();
  }

  function footer()
  {
    $this->db->where($this->id, '1');

    return $this->db->get($this->table)->row();
  }

  function update($id, $data)
  {
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);
  }

}
