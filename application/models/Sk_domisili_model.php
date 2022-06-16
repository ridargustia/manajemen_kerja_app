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

    function total_rows_is_not_readed()
    {
        $this->db->where('sk_domisili.is_readed', '0');
        $this->db->where('sk_domisili.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }
}
