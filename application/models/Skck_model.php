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
}
