<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_model extends CI_Model
{
    public $table = 'surat';
    public $id    = 'id_surat';
    public $order = 'DESC';

    function total_rows_skck()
    {
        $this->db->where('jenis_surat_id', '1');
        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_sk_domisili()
    {
        $this->db->where('jenis_surat_id', '2');
        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_sk_jalan()
    {
        $this->db->where('jenis_surat_id', '3');
        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_sk_hilang_ktp()
    {
        $this->db->where('jenis_surat_id', '4');
        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_sk_meninggal_dunia()
    {
        $this->db->where('jenis_surat_id', '5');
        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_sk_nikah()
    {
        $this->db->where('jenis_surat_id', '6');
        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_sk_pindah()
    {
        $this->db->where('jenis_surat_id', '7');
        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_sk_usaha()
    {
        $this->db->where('jenis_surat_id', '8');
        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_surat_pengantar_nikah()
    {
        $this->db->where('jenis_surat_id', '9');
        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_surat_pernyataan_miskin()
    {
        $this->db->where('jenis_surat_id', '10');
        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_surat_rekomendasi()
    {
        $this->db->where('jenis_surat_id', '11');
        return $this->db->get($this->table)->num_rows();
    }
}
