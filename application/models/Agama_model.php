<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agama_model extends CI_Model
{
    public $table = 'agama';
    public $id    = 'id_agama';
    public $order = 'DESC';

    function get_all_combobox()
    {
        $this->db->order_by('id_agama');
        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            foreach ($data->result_array() as $row) {
                $result[''] = '- Pilih Agama -';
                $result[$row['id_agama']] = $row['agama_name'];
            }
            return $result;
        }
    }
}
