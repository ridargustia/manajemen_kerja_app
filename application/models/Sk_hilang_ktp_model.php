<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_hilang_ktp_model extends CI_Model
{
    public $table = 'sk_hilang_ktp';
    public $id    = 'id_sk_hilang_ktp';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('sk_hilang_ktp.id_sk_hilang_ktp, sk_hilang_ktp.nik, sk_hilang_ktp.name, sk_hilang_ktp.created_at, sk_hilang_ktp.is_readed');

        $this->db->where('sk_hilang_ktp.is_delete', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('sk_hilang_ktp.is_readed', '0');
        $this->db->where('sk_hilang_ktp.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_is_not_readed_masteradmin()
    {
        $this->db->where('sk_hilang_ktp.is_readed', '1');
        $this->db->where('sk_hilang_ktp.is_readed_masteradmin', '0');
        $this->db->where('sk_hilang_ktp.is_delete', '0');
        $this->db->where('sk_hilang_ktp.no_surat !=', NULL);

        return $this->db->get($this->table)->num_rows();
    }

    function get_by_token($id)
    {
        $this->db->where('token', $id);
        $this->db->where('no_surat !=', NULL);
        $this->db->where('signature_image !=', NULL);

        return $this->db->get($this->table)->row();
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
