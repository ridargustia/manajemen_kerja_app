<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_pindah_model extends CI_Model
{
    public $table = 'sk_pindah';
    public $id    = 'id_sk_pindah';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('sk_pindah.id_sk_pindah, sk_pindah.nik, sk_pindah.name, sk_pindah.created_at, sk_pindah.is_readed');

        $this->db->where('sk_pindah.is_delete', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('sk_pindah.is_readed', '0');
        $this->db->where('sk_pindah.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
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

    function soft_delete($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
}
