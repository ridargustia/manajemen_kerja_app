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
        $this->db->select('sk_hilang_ktp.id_sk_hilang_ktp, sk_hilang_ktp.nik, sk_hilang_ktp.name, sk_hilang_ktp.signature_image, sk_hilang_ktp.created_at, sk_hilang_ktp.is_readed');

        $this->db->where('sk_hilang_ktp.is_delete', '0');

        $this->db->order_by('sk_hilang_ktp.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_numbering()
    {
        $this->db->select('sk_hilang_ktp.id_sk_hilang_ktp, sk_hilang_ktp.nik, sk_hilang_ktp.name, sk_hilang_ktp.signature_image, sk_hilang_ktp.created_at, sk_hilang_ktp.is_readed_masteradmin');

        $this->db->where('sk_hilang_ktp.is_delete', '0');
        $this->db->where('sk_hilang_ktp.no_surat !=', NULL);

        $this->db->order_by('sk_hilang_ktp.is_readed_masteradmin', 'ASC');
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

    function get_by_id_for_document($id)
    {
        $this->db->join('status', 'sk_hilang_ktp.status_id = status.id_status');
        $this->db->join('agama', 'sk_hilang_ktp.agama_id = agama.id_agama');
        $this->db->join('pekerjaan', 'sk_hilang_ktp.pekerjaan_id = pekerjaan.id_pekerjaan');

        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
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

    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
}
