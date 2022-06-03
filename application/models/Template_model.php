<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_model extends CI_Model{

  public $table = 'template';
  public $id    = 'id';
  public $order = 'DESC';

  function get_by_id($id)
  {
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }

  function layout()
  {
    $this->db->where($this->id, '1');
    return $this->db->get($this->table)->row();
  }

  function skins()
  {
    $this->db->where($this->id, '2');
    return $this->db->get($this->table)->row();
  }

  function update($id,$data)
  {
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);
  }

}
