<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang_model extends CI_Model{

  public $table = 'cabang';
  public $id    = 'id_cabang';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->join('instansi', 'cabang.instansi_id = instansi.id_instansi');

    $this->db->where('is_delete_cabang', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_instansi()
  {
    $this->db->join('instansi', 'cabang.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);
    $this->db->where('is_delete_cabang', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_combobox()
  {
    $this->db->where('is_delete_cabang', '0');

    $this->db->order_by('cabang_name');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Cabang -';
        $result[$row['id_cabang']] = $row['cabang_name'];
      }
      return $result;
    }
  }

  function get_cabang_by_instansi_combobox($instansi_id)
  {
    $this->db->where('is_delete_cabang', '0');
  	$this->db->where('instansi_id',$instansi_id);

  	$this->db->order_by('cabang_name');

  	$sql = $this->db->get('cabang');
  	if($sql->num_rows() > 0)
    {
  		foreach ($sql->result_array() as $row)
      {
        $result['']= '- Silahkan Pilih Cabang -';
        $result[$row['id_cabang']]= ucwords(strtolower($row['cabang_name']));
      }
    }
    else
    {
		  $result['-']= '- Belum Ada Cabang -';
		}
    return $result;
	}

  function get_all_combobox_by_instansi($instansi_id)
  {
    $this->db->where('instansi_id', $instansi_id);
    $this->db->where('is_delete_cabang', '0');

    $this->db->order_by('cabang_name');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Cabang -';
        $result[$row['id_cabang']] = $row['cabang_name'];
      }
      return $result;
    }
  }

  function get_all_combobox_update($instansi_id)
  {
    $this->db->where('instansi_id', $instansi_id);
    $this->db->order_by('cabang_name');
    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Cabang -';
        $result[$row['id_cabang']] = $row['cabang_name'];
      }
      return $result;
    }
  }

  function get_all_combobox_update_by_instansi($instansi_id)
  {
    $this->db->where('instansi_id', $instansi_id);
    $this->db->order_by('cabang_name');
    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Cabang -';
        $result[$row['id_cabang']] = $row['cabang_name'];
      }
      return $result;
    }
  }

  function get_all_combobox_update_by_cabang($cabang_id)
  {
    $this->db->where('cabang_id', $cabang_id);
    $this->db->order_by('cabang_name');
    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Cabang -';
        $result[$row['id_cabang']] = $row['cabang_name'];
      }
      return $result;
    }
  }

  function get_all_deleted()
  {
    $this->db->join('instansi', 'cabang.instansi_id = instansi.id_instansi');

    $this->db->where('is_delete_cabang', '1');

    $this->db->order_by('cabang_name', $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_instansi()
  {
    $this->db->join('instansi', 'cabang.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);
    $this->db->where('is_delete_cabang', '1');

    $this->db->order_by('cabang_name', $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_by_id($id)
  {
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }

  function check_by_name_and_instansi($cabang_name, $instansi_id)
  {
    $this->db->where('instansi_id', $instansi_id);
    $this->db->where('cabang_name', $cabang_name);
    
    return $this->db->get($this->table)->row();
  }

  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_instansi()
  {
    $this->db->join('instansi', 'cabang.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);

    return $this->db->get($this->table)->num_rows();
  }

  function insert($data)
  {
    $this->db->insert($this->table, $data);
  }

  function update($id,$data)
  {
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);
  }

  function soft_delete($id,$data)
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
