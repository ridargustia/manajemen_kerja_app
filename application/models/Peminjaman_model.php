<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_model extends CI_Model{

  public $table = 'peminjaman';
  public $id    = 'id_peminjaman';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.created_at, peminjaman.created_by,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      divisi.divisi_name,
      cabang.cabang_name,
      instansi.instansi_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users','LEFT');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip','LEFT');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi','LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang','LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi','LEFT');

    $this->db->where('is_delete_peminjaman', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_instansi()
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.created_at, peminjaman.created_by,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');

    $this->db->where('is_delete_peminjaman', '0');
    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_cabang()
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.created_at, peminjaman.created_by,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');

    $this->db->where('is_delete_peminjaman', '0');
    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('peminjaman.cabang_id', $this->session->cabang_id);
    // $this->db->where('peminjaman.divisi_id', $this->session->divisi_id);

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_divisi()
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.created_at, peminjaman.created_by,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');

    $this->db->where('is_delete_peminjaman', '0');
    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('peminjaman.divisi_id', $this->session->divisi_id);

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_sadmin()
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.created_at,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');

    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('is_delete_peminjaman', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_admin()
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.created_at,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');

    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('peminjaman.divisi_id', $this->session->divisi_id);
    $this->db->where('is_delete_peminjaman', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted()
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.created_at,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      divisi.divisi_name,
      cabang.cabang_name,
      instansi.instansi_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('is_delete_peminjaman', '1');

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_instansi()
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.created_at,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      divisi.divisi_name,
      cabang.cabang_name,
      instansi.instansi_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('is_delete_peminjaman', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_cabang()
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.created_at,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      divisi.divisi_name,
      cabang.cabang_name,
      instansi.instansi_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('peminjaman.cabang_id', $this->session->cabang_id);    
    $this->db->where('is_delete_peminjaman', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_divisi()
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.created_at,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      divisi.divisi_name,
      cabang.cabang_name,
      instansi.instansi_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('peminjaman.cabang_id', $this->session->cabang_id);
    $this->db->where('peminjaman.divisi_id', $this->session->divisi_id);
    $this->db->where('is_delete_peminjaman', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_periode($tgl_awal, $tgl_akhir)
  {
    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('peminjaman.created_at >=', $tgl_awal);
    $this->db->where('peminjaman.created_at <=', $tgl_akhir);
    $this->db->where('is_delete_peminjaman', '0');

    return $this->db->get($this->table)->result();
  }

  function get_all_periode_by_instansi($tgl_awal, $tgl_akhir)
  {
    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('peminjaman.created_at >=', $tgl_awal);
    $this->db->where('peminjaman.created_at <=', $tgl_akhir);
    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('is_delete_peminjaman', '0');

    return $this->db->get($this->table)->result();
  }

  function get_all_periode_by_cabang($tgl_awal, $tgl_akhir)
  {
    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('peminjaman.created_at >=', $tgl_awal);
    $this->db->where('peminjaman.created_at <=', $tgl_akhir);
    $this->db->where('peminjaman.cabang_id', $this->session->cabang_id);
    $this->db->where('is_delete_peminjaman', '0');

    return $this->db->get($this->table)->result();
  }

  function get_all_periode_by_divisi($tgl_awal, $tgl_akhir)
  {
    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('peminjaman.created_at >=', $tgl_awal);
    $this->db->where('peminjaman.created_at <=', $tgl_akhir);
    $this->db->where('peminjaman.divisi_id', $this->session->divisi_id);
    $this->db->where('is_delete_peminjaman', '0');

    return $this->db->get($this->table)->result();
  }

  function get_all_combobox_arsip_peminjaman()
  {
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');
    $this->db->where('is_kembali', '0');
    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Arsip';
        $result[$row['id_peminjaman']] = $row['arsip_name'];
      }
      return $result;
    }
    else
    {
      $result[''] = '- Belum Ada Data Peminjaman Arsip -';
      return $result;
    }
  }

  function get_all_combobox_arsip_peminjaman_update()
  {
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');
    $this->db->where('is_kembali', '0');
    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Arsip';
        $result[$row['arsip_id']] = $row['arsip_name'];
      }
      return $result;
    }
    else
    {
      $result[''] = '- Belum Ada Data Peminjaman Arsip -';
      return $result;
    }
  }

  function get_all_combobox_arsip_peminjaman_by_instansi()
  {
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');

    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('is_kembali', '0');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Arsip';
        $result[$row['id_peminjaman']] = $row['arsip_name'];
      }
      return $result;
    }
    else
    {
      $result[''] = '- Belum Ada Data Peminjaman Arsip -';
      return $result;
    }
  }

  function get_all_combobox_arsip_peminjaman_by_cabang()
  {
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');

    $this->db->where('peminjaman.cabang_id', $this->session->cabang_id);
    $this->db->where('is_kembali', '0');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Arsip';
        $result[$row['id_peminjaman']] = $row['arsip_name'];
      }
      return $result;
    }
    else
    {
      $result[''] = '- Belum Ada Data Peminjaman Arsip -';
      return $result;
    }
  }

  function get_all_combobox_arsip_peminjaman_by_instansi_update()
  {
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');

    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('is_kembali', '0');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Arsip';
        $result[$row['arsip_id']] = $row['arsip_name'];
      }
      return $result;
    }
    else
    {
      $result[''] = '- Belum Ada Data Peminjaman Arsip -';
      return $result;
    }
  }

  function get_all_combobox_arsip_peminjaman_by_divisi()
  {
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');

    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('peminjaman.divisi_id', $this->session->divisi_id);
    $this->db->where('is_kembali', '0');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Arsip';
        $result[$row['id_peminjaman']] = $row['arsip_name'];
      }
      return $result;
    }
    else
    {
      $result[''] = '- Belum Ada Data Peminjaman Arsip -';
      return $result;
    }
  }

  function get_all_combobox_arsip_peminjaman_by_divisi_update()
  {
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');

    $this->db->where('peminjaman.instansi_id', $this->session->instansi_id);
    $this->db->where('peminjaman.divisi_id', $this->session->divisi_id);
    $this->db->where('is_kembali', '0');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Arsip';
        $result[$row['arsip_id']] = $row['arsip_name'];
      }
      return $result;
    }
    else
    {
      $result[''] = '- Belum Ada Data Peminjaman Arsip -';
      return $result;
    }
  }

  function get_all_combobox_peminjaman($id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.arsip_name, arsip.user_id,
      users.id_users, users.name,
      peminjaman.arsip_id, peminjaman.user_id, peminjaman.is_kembali
    ');

    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');
    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->where('peminjaman.arsip_id', $id);
    $this->db->where('peminjaman.is_kembali', '0');
    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        // $result[''] = '- Silahkan Pilih Kode Peminjaman';
        $result[$row['user_id']] = $row['name'];
      }
      return $result;
    }
  }

  function get_by_id($id)
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali, peminjaman.instansi_id, peminjaman.cabang_id, peminjaman.divisi_id, peminjaman.user_id, peminjaman.arsip_id,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      divisi.divisi_name,
      cabang.cabang_name,
      instansi.instansi_name,
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi', 'LEFT');

    $this->db->where($this->id, $id);

    return $this->db->get($this->table)->row();
  }

  function get_id_peminjaman($id)
  {
    $this->db->select('
      id_peminjaman, tgl_peminjaman, tgl_kembali, peminjaman.divisi_id as divisi, peminjaman.user_id, peminjaman.arsip_id, peminjaman.is_kembali,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      instansi.instansi_name,
      divisi.divisi_name
    ');

    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi');
    $this->db->join('divisi', 'peminjaman.divisi_id = divisi.id_divisi');

    $this->db->where('is_delete_peminjaman', '0');

    return $this->db->get($this->table)->result();
  }

  function get_current_arsip_by_id_peminjaman($id)
  {
    $this->db->join('arsip', 'peminjaman.arsip_id = arsip.id_arsip');
    $this->db->join('users', 'peminjaman.user_id = users.id_users');
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }

  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_instansi()
  {
    $this->db->join('instansi', 'peminjaman.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);

    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_cabang()
  {
    $this->db->join('cabang', 'peminjaman.cabang_id = cabang.id_cabang');

    $this->db->where('cabang_id', $this->session->cabang_id);

    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_user()
  {
    $this->db->where('user_id', $this->session->id_users);
    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_divisi()
  {
    $this->db->where('divisi_id', $this->session->divisi_id);
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
