<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Divisi_model extends CI_Model
{

  public $table = 'divisi';
  public $id    = 'id_divisi';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->select('id_instansi, instansi_name, cabang.id_cabang, cabang.cabang_name, divisi.id_divisi, divisi.divisi_name, divisi.instansi_id');

    $this->db->join('instansi', 'divisi.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'divisi.cabang_id = cabang.id_cabang', 'left');

    $this->db->where('is_delete_divisi', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_instansi()
  {
    $this->db->select('id_instansi, instansi_name, cabang.id_cabang, cabang.cabang_name, divisi.id_divisi, divisi.divisi_name, divisi.instansi_id');

    $this->db->join('instansi', 'divisi.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'divisi.cabang_id = cabang.id_cabang', 'left');

    $this->db->where('divisi.instansi_id', $this->session->instansi_id);
    $this->db->where('is_delete_divisi', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_cabang()
  {
    $this->db->select('id_instansi, instansi_name, cabang.id_cabang, cabang.cabang_name, divisi.id_divisi, divisi.divisi_name, divisi.instansi_id');

    $this->db->join('instansi', 'divisi.instansi_id = instansi.id_instansi', 'left');
    $this->db->join('cabang', 'divisi.cabang_id = cabang.id_cabang', 'left');

    $this->db->where('divisi.instansi_id', $this->session->instansi_id);
    $this->db->where('cabang_id', $this->session->cabang_id);
    $this->db->where('is_delete_divisi', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_home()
  {
    $this->db->where('id_divisi >', '1');

    $this->db->where('is_delete_divisi', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_combobox()
  {
    $this->db->order_by('divisi_name');
    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Divisi -';
        $result[$row['id_divisi']] = $row['divisi_name'];
      }
      return $result;
    }
  }

  function get_all_combobox_update($cabang_id)
  {
    $this->db->where('cabang_id', $cabang_id);
    $this->db->order_by('divisi_name');
    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Divisi -';
        $result[$row['id_divisi']] = $row['divisi_name'];
      }
      return $result;
    }
  }

  function get_all_combobox_by_instansi($instansi_id)
  {
    $this->db->join('instansi', 'divisi.instansi_id = instansi.id_instansi');

    $this->db->where('divisi.instansi_id', $instansi_id);

    $this->db->order_by('divisi_name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Divisi -';
        $result[$row['id_divisi']] = $row['divisi_name'];
      }
    } else {
      $result[''] = 'Belum ada data';
    }
    return $result;
  }

  function get_all_combobox_by_cabang($cabang_id)
  {
    $this->db->select('
      id_divisi, divisi.divisi_name, divisi.instansi_id,
      instansi.instansi_name, 
      cabang.cabang_name
    ');

    $this->db->join('instansi', 'divisi.instansi_id = instansi.id_instansi');
    $this->db->join('cabang', 'divisi.cabang_id = cabang.id_cabang');
    
    $this->db->where('cabang_id', $cabang_id);

    $this->db->order_by('divisi_name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Divisi -';
        $result[$row['id_divisi']] = $row['divisi_name'];
      }
    } else {
      $result[''] = 'Belum ada data';
    }
    return $result;
  }

  function get_all_combobox_by_instansi_update($instansi_id)
  {
    $this->db->join('instansi', 'divisi.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $instansi_id);

    $this->db->order_by('divisi_name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Divisi -';
        $result[$row['id_divisi']] = $row['divisi_name'];
      }
    } else {
      $result[''] = 'Belum ada data';
    }
    return $result;
  }

  function get_all_combobox_sadmin()
  {
    $this->db->order_by('divisi_name');
    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Divisi -';
        $result[$row['id_divisi']] = $row['divisi_name'];
      }
      return $result;
    }
  }

  function get_all_deleted()
  {
    $this->db->where('is_delete_divisi', '1');

    $this->db->order_by('divisi_name', $this->order);
    
    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_instansi()
  {
    $this->db->join('instansi', 'divisi.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);
    $this->db->where('is_delete_divisi', '1');

    $this->db->order_by('divisi_name', $this->order);

    return $this->db->get($this->table)->result();
  }
  
  function get_all_deleted_by_cabang()
  {
    $this->db->join('instansi', 'divisi.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);
    $this->db->where('cabang_id', $this->session->cabang_id);
    $this->db->where('is_delete_divisi', '1');

    $this->db->order_by('divisi_name', $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_by_id($id)
  {
    $this->db->where($this->id, $id);

    return $this->db->get($this->table)->row();
  }

  function get_divisi_by_user($id)
  {
    $this->db->join('users', 'divisi.id_divisi = users.divisi');

    $this->db->where($this->id, $id);

    return $this->db->get($this->table)->row();
  }

  function get_divisi_by_instansi_combobox($instansi_id)
  {
    $this->db->where('instansi_id', $instansi_id);
    $this->db->order_by('divisi_name');
    $sql = $this->db->get('divisi');
    if ($sql->num_rows() > 0) {
      foreach ($sql->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Divisi -';
        $result[$row['id_divisi']] = ucwords(strtolower($row['divisi_name']));
      }
    } else {
      $result['-'] = '- Belum Ada Divisi -';
    }
    return $result;
  }

  function get_divisi_by_cabang_combobox($cabang_id)
  {
    $this->db->where('cabang_id', $cabang_id);

    $this->db->order_by('divisi_name');

    $sql = $this->db->get('divisi');

    if ($sql->num_rows() > 0) {
      foreach ($sql->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Divisi -';
        $result[$row['id_divisi']] = ucwords(strtolower($row['divisi_name']));
      }
    } else {
      $result['-'] = '- Belum Ada Divisi -';
    }
    return $result;
  }

  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_instansi()
  {
    $this->db->join('instansi', 'divisi.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);

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
