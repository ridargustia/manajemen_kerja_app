<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_pengantar_nikah_model extends CI_Model
{
    public $table = 'surat_pengantar_nikah';
    public $id    = 'id_surat_pengantar_nikah';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('surat_pengantar_nikah.nik, surat_pengantar_nikah.name, surat_pengantar_nikah.created_at, surat_pengantar_nikah.is_readed');

        $this->db->where('surat_pengantar_nikah.is_delete', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('surat_pengantar_nikah.is_readed', '0');
        $this->db->where('surat_pengantar_nikah.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }
}
