<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendidikan_akhir_model extends CI_Model
{
    public $table = 'pendidikan_akhir';
    public $id    = 'id_pendidikan_akhir';
    public $order = 'DESC';

    function get_all_combobox()
    {
        $this->db->order_by('id_pendidikan_akhir');
        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            foreach ($data->result_array() as $row) {
                $result[''] = '- Pilih Pendidikan Terakhir -';
                $result[$row['id_pendidikan_akhir']] = $row['pendidikan_akhir_name'];
            }
            return $result;
        }
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
}
