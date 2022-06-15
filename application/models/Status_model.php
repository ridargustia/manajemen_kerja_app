<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Status_model extends CI_Model
{
    public $table = 'status';
    public $id    = 'id_status';
    public $order = 'DESC';

    function get_all_combobox()
    {
        $this->db->order_by('id_status');
        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            foreach ($data->result_array() as $row) {
                $result[''] = '- Pilih Status Pernikahan -';
                $result[$row['id_status']] = $row['status_name'];
            }
            return $result;
        }
    }
}
