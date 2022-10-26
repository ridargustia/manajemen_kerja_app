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
        $this->db->select('surat_pengantar_nikah.id_surat_pengantar_nikah, surat_pengantar_nikah.nik, surat_pengantar_nikah.name, surat_pengantar_nikah.signature_image, surat_pengantar_nikah.created_at, surat_pengantar_nikah.is_readed');

        $this->db->where('surat_pengantar_nikah.is_delete', '0');

        $this->db->order_by('surat_pengantar_nikah.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_numbering()
    {
        $this->db->select('surat_pengantar_nikah.id_surat_pengantar_nikah, surat_pengantar_nikah.nik, surat_pengantar_nikah.name, surat_pengantar_nikah.signature_image, surat_pengantar_nikah.created_at, surat_pengantar_nikah.is_readed_masteradmin');

        $this->db->where('surat_pengantar_nikah.is_delete', '0');
        $this->db->where('surat_pengantar_nikah.no_surat !=', NULL);

        $this->db->order_by('surat_pengantar_nikah.is_readed_masteradmin', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted()
    {
        $this->db->select('surat_pengantar_nikah.id_surat_pengantar_nikah, surat_pengantar_nikah.nik, surat_pengantar_nikah.name, surat_pengantar_nikah.signature_image, surat_pengantar_nikah.created_at, surat_pengantar_nikah.is_readed');

        $this->db->where('surat_pengantar_nikah.is_delete', '1');

        $this->db->order_by('surat_pengantar_nikah.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted_for_masteradmin()
    {
        $this->db->select('surat_pengantar_nikah.id_surat_pengantar_nikah, surat_pengantar_nikah.nik, surat_pengantar_nikah.name, surat_pengantar_nikah.signature_image, surat_pengantar_nikah.created_at, surat_pengantar_nikah.is_readed_masteradmin');

        $this->db->where('surat_pengantar_nikah.is_delete', '1');
        $this->db->where('surat_pengantar_nikah.no_surat !=', NULL);

        $this->db->order_by('surat_pengantar_nikah.is_readed_masteradmin', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('surat_pengantar_nikah.is_readed', '0');
        $this->db->where('surat_pengantar_nikah.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_is_not_readed_masteradmin()
    {
        $this->db->where('surat_pengantar_nikah.is_readed', '1');
        $this->db->where('surat_pengantar_nikah.is_readed_masteradmin', '0');
        $this->db->where('surat_pengantar_nikah.is_delete', '0');
        $this->db->where('surat_pengantar_nikah.no_surat !=', NULL);

        return $this->db->get($this->table)->num_rows();
    }

    function get_by_id_for_document($id)
    {
        $this->db->join('status', 'surat_pengantar_nikah.status_id = status.id_status');
        $this->db->join('agama', 'surat_pengantar_nikah.agama_id = agama.id_agama');
        $this->db->join('pekerjaan', 'surat_pengantar_nikah.pekerjaan_id = pekerjaan.id_pekerjaan');

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

    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}
