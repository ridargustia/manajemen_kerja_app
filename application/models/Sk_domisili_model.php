<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_domisili_model extends CI_Model
{
    public $table = 'sk_domisili';
    public $id    = 'id_sk_domisili';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('sk_domisili.id_sk_domisili, sk_domisili.nik, sk_domisili.name, sk_domisili.signature_image, sk_domisili.created_at, sk_domisili.is_readed');

        $this->db->where('sk_domisili.is_delete', '0');

        $this->db->order_by('sk_domisili.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_numbering()
    {
        $this->db->select('sk_domisili.id_sk_domisili, sk_domisili.nik, sk_domisili.name, sk_domisili.signature_image, sk_domisili.created_at, sk_domisili.is_readed_masteradmin');

        $this->db->where('sk_domisili.is_delete', '0');
        $this->db->where('sk_domisili.no_surat !=', NULL);

        $this->db->order_by('sk_domisili.is_readed_masteradmin', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted()
    {
        $this->db->select('sk_domisili.id_sk_domisili, sk_domisili.nik, sk_domisili.name, sk_domisili.signature_image, sk_domisili.created_at, sk_domisili.is_readed');

        $this->db->where('sk_domisili.is_delete', '1');

        $this->db->order_by('sk_domisili.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted_for_masteradmin()
    {
        $this->db->select('sk_domisili.id_sk_domisili, sk_domisili.nik, sk_domisili.name, sk_domisili.signature_image, sk_domisili.created_at, sk_domisili.is_readed_masteradmin');

        $this->db->where('sk_domisili.is_delete', '1');
        $this->db->where('sk_domisili.no_surat !=', NULL);

        $this->db->order_by('sk_domisili.is_readed_masteradmin', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('sk_domisili.is_readed', '0');
        $this->db->where('sk_domisili.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_is_not_readed_masteradmin()
    {
        $this->db->where('sk_domisili.is_readed', '1');
        $this->db->where('sk_domisili.is_readed_masteradmin', '0');
        $this->db->where('sk_domisili.is_delete', '0');
        $this->db->where('sk_domisili.no_surat !=', NULL);

        return $this->db->get($this->table)->num_rows();
    }

    function get_by_id_for_document($id)
    {
        $this->db->join('status', 'sk_domisili.status_id = status.id_status');
        $this->db->join('agama', 'sk_domisili.agama_id = agama.id_agama');

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
