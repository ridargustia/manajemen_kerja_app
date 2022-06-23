<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_domisili_model extends CI_Model
{
    public $table = 'sk_domisili';
    public $id    = 'id_sk_domisili';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('sk_domisili.nik, sk_domisili.name, sk_domisili.created_at, sk_domisili.is_readed');

        $this->db->where('sk_domisili.is_delete', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('sk_domisili.is_readed', '0');
        $this->db->where('sk_domisili.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }

    function total_rows()
    {
        return $this->db->get($this->table)->num_rows();
    }
}
