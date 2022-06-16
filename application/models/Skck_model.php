<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Skck_model extends CI_Model
{
    public $table = 'skck';
    public $id    = 'id_skck';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('skck.nik, skck.name, skck.created_at, skck.is_readed');

        $this->db->where('skck.is_delete', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('skck.is_readed', '0');
        $this->db->where('skck.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }
}
