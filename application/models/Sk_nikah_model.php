<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_nikah_model extends CI_Model
{
    public $table = 'sk_nikah';
    public $id    = 'id_sk_nikah';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('sk_nikah.id_sk_nikah, sk_nikah.suami_name, sk_nikah.istri_name, sk_nikah.created_at, sk_nikah.is_readed');

        $this->db->where('sk_nikah.is_delete', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('sk_nikah.is_readed', '0');
        $this->db->where('sk_nikah.is_delete', '0');

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
