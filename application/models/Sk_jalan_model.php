<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_jalan_model extends CI_Model
{
    public $table = 'sk_jalan';
    public $id    = 'id_sk_jalan';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('sk_jalan.id_sk_jalan, sk_jalan.nik, sk_jalan.name, sk_jalan.signature_image, sk_jalan.created_at, sk_jalan.is_readed');

        $this->db->where('sk_jalan.is_delete', '0');

        $this->db->order_by('sk_jalan.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_numbering()
    {
        $this->db->select('sk_jalan.id_sk_jalan, sk_jalan.nik, sk_jalan.name, sk_jalan.signature_image, sk_jalan.created_at, sk_jalan.is_readed_masteradmin');

        $this->db->where('sk_jalan.is_delete', '0');
        $this->db->where('sk_jalan.no_surat !=', NULL);

        $this->db->order_by('sk_jalan.is_readed_masteradmin', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('sk_jalan.is_readed', '0');
        $this->db->where('sk_jalan.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_is_not_readed_masteradmin()
    {
        $this->db->where('sk_jalan.is_readed', '1');
        $this->db->where('sk_jalan.is_readed_masteradmin', '0');
        $this->db->where('sk_jalan.is_delete', '0');
        $this->db->where('sk_jalan.no_surat !=', NULL);

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
