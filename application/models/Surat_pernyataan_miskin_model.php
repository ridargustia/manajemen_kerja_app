<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_pernyataan_miskin_model extends CI_Model
{
    public $table = 'surat_pernyataan_miskin';
    public $id    = 'id_surat_pernyataan_miskin';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('surat_pernyataan_miskin.nik, surat_pernyataan_miskin.name, surat_pernyataan_miskin.created_at, surat_pernyataan_miskin.is_readed');

        $this->db->where('surat_pernyataan_miskin.is_delete', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('surat_pernyataan_miskin.is_readed', '0');
        $this->db->where('surat_pernyataan_miskin.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }

    function total_rows()
    {
        return $this->db->get($this->table)->num_rows();
    }
}
