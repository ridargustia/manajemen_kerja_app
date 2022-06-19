<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_rekomendasi_model extends CI_Model
{
    public $table = 'surat_rekomendasi';
    public $id    = 'id_surat_rekomendasi';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('surat_rekomendasi.nik, surat_rekomendasi.name, surat_rekomendasi.created_at, surat_rekomendasi.is_readed');

        $this->db->where('surat_rekomendasi.is_delete', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('surat_rekomendasi.is_readed', '0');
        $this->db->where('surat_rekomendasi.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }
}
