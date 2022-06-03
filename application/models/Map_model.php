<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Map_model extends CI_Model
{

  public $table = 'map';
  public $id    = 'id_map';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->select('
      map.id_map, map.map_name, cabang.cabang_name, instansi.instansi_name, map.created_by as created_by_map
    ');
    
    $this->db->join('instansi', 'map.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'map.cabang_id = cabang.id_cabang', 'left');

    $this->db->where('is_delete_map', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_instansi()
  {
    $this->db->select('
      map.id_map, map.map_name, cabang.cabang_name, instansi.instansi_name, map.created_by as created_by_map
    ');
    
    $this->db->join('instansi', 'map.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'map.cabang_id = cabang.id_cabang', 'left');

    $this->db->where('map.instansi_id', $this->session->instansi_id);
    $this->db->where('is_delete_map', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_cabang()
  {
    $this->db->select('
      map.id_map, map.map_name, cabang.cabang_name, instansi.instansi_name, map.created_by as created_by_map
    ');
    
    $this->db->join('instansi', 'map.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'map.cabang_id = cabang.id_cabang', 'left');

    $this->db->where('map.instansi_id', $this->session->instansi_id);
    $this->db->where('cabang_id', $this->session->cabang_id);
    $this->db->where('is_delete_map', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_combobox()
  {
    $this->db->where('is_delete_map', '0');

    $this->db->order_by('map_name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Map -';
        $result[$row['id_map']] = $row['map_name'];
      }
      return $result;
    }
  }

  function get_map_by_instansi_combobox($instansi_id)
  {
    $this->db->where('instansi_id', $instansi_id);
    $this->db->where('is_delete_map', '0');

    $this->db->order_by('map_name');

    $sql = $this->db->get('map');

    if ($sql->num_rows() > 0) {
      foreach ($sql->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Map -';
        $result[$row['id_map']] = ucwords(strtolower($row['map_name']));
      }
    } else {
      $result['-'] = '- Belum Ada Map -';
    }
    return $result;
  }

  function get_map_by_cabang_combobox($cabang_id)
  {
    $this->db->where('cabang_id', $cabang_id);
    $this->db->where('is_delete_map', '0');

    $this->db->order_by('map_name');

    $sql = $this->db->get('map');

    if ($sql->num_rows() > 0) {
      foreach ($sql->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Map -';
        $result[$row['id_map']] = ucwords(strtolower($row['map_name']));
      }
    } else {
      $result['-'] = '- Belum Ada Map -';
    }
    return $result;
  }

  function get_all_combobox_by_instansi($instansi_id)
  {
    $this->db->where('instansi_id', $instansi_id);
    $this->db->where('is_delete_map', '0');

    $this->db->order_by('map_name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Map -';
        $result[$row['id_map']] = $row['map_name'];
      }
      return $result;
    }
  }

  function get_all_combobox_by_cabang($cabang_id)
  {
    $this->db->where('is_delete_map', '0');
    $this->db->where('cabang_id', $cabang_id);

    $this->db->order_by('map_name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Map -';
        $result[$row['id_map']] = $row['map_name'];
      }
      return $result;
    }
  }

  function get_all_combobox_update($instansi_id)
  {
    $this->db->where('instansi_id', $instansi_id);
    $this->db->order_by('map_name');
    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Map -';
        $result[$row['id_map']] = $row['map_name'];
      }
      return $result;
    }
  }

  function get_all_deleted()
  {
    $this->db->join('instansi', 'map.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'map.cabang_id = cabang.id_cabang', 'left');

    $this->db->where('is_delete_map', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_instansi()
  {
    $this->db->join('instansi', 'map.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'map.cabang_id = cabang.id_cabang', 'left');

    $this->db->where('map.instansi_id', $this->session->instansi_id);
    $this->db->where('is_delete_map', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_cabang()
  {
    $this->db->join('instansi', 'map.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'map.cabang_id = cabang.id_cabang', 'left');

    $this->db->where('map.instansi_id', $this->session->instansi_id);
    $this->db->where('cabang_id', $this->session->cabang_id);
    $this->db->where('is_delete_map', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_by_id($id)
  {
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }

  function check_by_name_and_instansi($name, $instansi_id)
  {
    $this->db->where('map_name', $name);
    $this->db->where('instansi_id', $instansi_id);
    return $this->db->get($this->table)->row();
  }

  function check_by_name_and_instansi_and_cabang($name, $instansi_id, $cabang_id)
  {
    $this->db->where('map_name', $name);
    $this->db->where('instansi_id', $instansi_id);
    $this->db->where('cabang_id', $cabang_id);

    return $this->db->get($this->table)->row();
  }

  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_instansi()
  {
    $this->db->join('instansi', 'map.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);

    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_cabang()
  {
    $this->db->join('cabang', 'map.cabang_id = cabang.id_cabang');

    $this->db->where('cabang_id', $this->session->cabang_id);

    return $this->db->get($this->table)->num_rows();
  }

  function insert($data)
  {
    $this->db->insert($this->table, $data);
  }

  function update($id, $data)
  {
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);
  }

  function soft_delete($id, $data)
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
