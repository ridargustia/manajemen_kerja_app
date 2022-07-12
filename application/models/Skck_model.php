<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Skck_model extends CI_Model
{
    public $table = 'skck';
    public $id    = 'id_skck';
    public $order = 'DESC';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_all()
    {
        $this->db->select('skck.id_skck, skck.nik, skck.name, skck.created_at, skck.is_readed');

        $this->db->where('skck.is_delete', '0');

        $this->db->order_by('skck.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_numbering()
    {
        $this->db->select('skck.id_skck, skck.nik, skck.name, skck.created_at, skck.is_readed_masteradmin');

        $this->db->where('skck.is_delete', '0');
        $this->db->where('skck.no_surat !=', NULL);

        $this->db->order_by('skck.is_readed_masteradmin', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted()
    {
        $this->db->select('skck.id_skck, skck.nik, skck.name, skck.created_at, skck.is_readed');

        $this->db->where('skck.is_delete', '1');

        $this->db->order_by('skck.is_readed', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted_for_masteradmin()
    {
        $this->db->select('skck.id_skck, skck.nik, skck.name, skck.created_at, skck.is_readed_masteradmin');

        $this->db->where('skck.is_delete', '1');
        $this->db->where('skck.no_surat !=', NULL);

        $this->db->order_by('skck.is_readed_masteradmin', 'ASC');
        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows_is_not_readed()
    {
        $this->db->where('skck.is_readed', '0');
        $this->db->where('skck.is_delete', '0');

        return $this->db->get($this->table)->num_rows();
    }

    function total_rows_is_not_readed_masteradmin()
    {
        $this->db->where('skck.is_readed', '1');
        $this->db->where('skck.is_readed_masteradmin', '0');
        $this->db->where('skck.is_delete', '0');
        $this->db->where('skck.no_surat !=', NULL);

        return $this->db->get($this->table)->num_rows();
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
