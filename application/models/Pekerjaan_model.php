<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pekerjaan_model extends CI_Model
{
    public $table = 'pekerjaan';
    public $id    = 'id_pekerjaan';
    public $order = 'DESC';

    function get_all_combobox()
    {
        $this->db->order_by('id_pekerjaan');
        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            foreach ($data->result_array() as $row) {
                $result[''] = '- Pilih Pekerjaan -';
                $result[$row['id_pekerjaan']] = $row['pekerjaan_name'];
            }
            return $result;
        }
    }
}
