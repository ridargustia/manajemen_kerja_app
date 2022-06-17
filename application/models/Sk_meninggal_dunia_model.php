<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_meninggal_dunia_model extends CI_Model
{
    public $table = 'sk_meninggal_dunia';
    public $id    = 'id_sk_meninggal_dunia';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('sk_meninggal_dunia.nik, sk_meninggal_dunia.name, sk_meninggal_dunia.created_at, sk_meninggal_dunia.is_readed');

        $this->db->where('sk_meninggal_dunia.is_delete', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('sk_meninggal_dunia.is_readed', '0');
        $this->db->where('sk_meninggal_dunia.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }
}
