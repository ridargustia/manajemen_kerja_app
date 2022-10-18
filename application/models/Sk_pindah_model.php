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
        $this->db->select('sk_pindah.id_sk_pindah, sk_pindah.nik, sk_pindah.name, sk_pindah.signature_image, sk_pindah.created_at, sk_pindah.is_readed');

        $this->db->where('sk_pindah.is_delete', '0');

        $this->db->order_by('sk_pindah.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_numbering()
    {
        $this->db->select('sk_pindah.id_sk_pindah, sk_pindah.nik, sk_pindah.name, sk_pindah.signature_image, sk_pindah.created_at, sk_pindah.is_readed_masteradmin');

        $this->db->where('sk_pindah.is_delete', '0');
        $this->db->where('sk_pindah.no_surat !=', NULL);

        $this->db->order_by('sk_pindah.is_readed_masteradmin', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('sk_pindah.is_readed', '0');
        $this->db->where('sk_pindah.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_is_not_readed_masteradmin()
    {
        $this->db->where('sk_pindah.is_readed', '1');
        $this->db->where('sk_pindah.is_readed_masteradmin', '0');
        $this->db->where('sk_pindah.is_delete', '0');
        $this->db->where('sk_pindah.no_surat !=', NULL);

        return $this->db->get($this->table)->num_rows();
    }

    function get_pengikut_by_id_sk_pindah($id)
    {
        $this->db->select('pengikut_sk_pindah.id_pengikut_sk_pindah, pengikut_sk_pindah.nik_pengikut, pengikut_sk_pindah.pengikut_name, pengikut_sk_pindah.keterangan');

        $this->db->where('pengikut_sk_pindah.sk_pindah_id', $id);
        $this->db->where('pengikut_sk_pindah.is_delete', 0);

        return $this->db->get('pengikut_sk_pindah')->result();
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

    function delete_pengikut_by_id_sk_pindah($id)
    {
        $this->db->where('pengikut_sk_pindah.sk_pindah_id', $id);
        $this->db->delete('pengikut_sk_pindah');
    }

    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}
