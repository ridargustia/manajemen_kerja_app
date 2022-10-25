<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_usaha_model extends CI_Model
{
    public $table = 'sk_usaha';
    public $id    = 'id_sk_usaha';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('sk_usaha.id_sk_usaha, sk_usaha.nik, sk_usaha.name, sk_usaha.signature_image, sk_usaha.created_at, sk_usaha.is_readed');

        $this->db->where('sk_usaha.is_delete', '0');

        $this->db->order_by('sk_usaha.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_numbering()
    {
        $this->db->select('sk_usaha.id_sk_usaha, sk_usaha.nik, sk_usaha.name, sk_usaha.signature_image, sk_usaha.created_at, sk_usaha.is_readed_masteradmin');

        $this->db->where('sk_usaha.is_delete', '0');
        $this->db->where('sk_usaha.no_surat !=', NULL);

        $this->db->order_by('sk_usaha.is_readed_masteradmin', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted()
    {
        $this->db->select('sk_usaha.id_sk_usaha, sk_usaha.nik, sk_usaha.name, sk_usaha.signature_image, sk_usaha.created_at, sk_usaha.is_readed');

        $this->db->where('sk_usaha.is_delete', '1');

        $this->db->order_by('sk_usaha.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted_for_masteradmin()
    {
        $this->db->select('sk_usaha.id_sk_usaha, sk_usaha.nik, sk_usaha.name, sk_usaha.signature_image, sk_usaha.created_at, sk_usaha.is_readed_masteradmin');

        $this->db->where('sk_usaha.is_delete', '1');
        $this->db->where('sk_usaha.no_surat !=', NULL);

        $this->db->order_by('sk_usaha.is_readed_masteradmin', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('sk_usaha.is_readed', '0');
        $this->db->where('sk_usaha.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_is_not_readed_masteradmin()
    {
        $this->db->where('sk_usaha.is_readed', '1');
        $this->db->where('sk_usaha.is_readed_masteradmin', '0');
        $this->db->where('sk_usaha.is_delete', '0');
        $this->db->where('sk_usaha.no_surat !=', NULL);

        return $this->db->get($this->table)->num_rows();
    }

    function get_by_id_for_document($id)
    {
        $this->db->join('agama', 'sk_usaha.agama_id = agama.id_agama');

        $this->db->where($this->id, $id);
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
