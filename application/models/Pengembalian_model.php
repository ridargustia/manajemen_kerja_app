<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian_model extends CI_Model{

  public $table = 'pengembalian';
  public $id    = 'id_pengembalian';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->select('
      id_pengembalian, tgl_kembali, pengembalian.divisi_id, pengembalian.user_id, pengembalian.arsip_id, pengembalian.created_at, pengembalian.created_by,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('users', 'pengembalian.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('is_delete_pengembalian', '0');

    $this->db->order_by('id_pengembalian', 'DESC');

    return $this->db->get($this->table)->result();
  }

  function get_all_by_instansi()
  {
    $this->db->select('
      id_pengembalian, tgl_kembali, pengembalian.divisi_id, pengembalian.user_id, pengembalian.arsip_id, pengembalian.created_at, pengembalian.created_by,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('users', 'pengembalian.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');

    $this->db->where('is_delete_pengembalian', '0');
    $this->db->where('pengembalian.instansi_id', $this->session->instansi_id);

    $this->db->order_by('id_pengembalian', 'DESC');

    return $this->db->get($this->table)->result();
  }

  function get_all_by_cabang()
  {
    $this->db->select('
      id_pengembalian, tgl_kembali, pengembalian.divisi_id, pengembalian.user_id, pengembalian.arsip_id, pengembalian.created_at, pengembalian.created_by,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('users', 'pengembalian.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');

    $this->db->where('is_delete_pengembalian', '0');
    $this->db->where('pengembalian.instansi_id', $this->session->instansi_id);
    $this->db->where('pengembalian.cabang_id', $this->session->cabang_id);

    $this->db->order_by('id_pengembalian', 'DESC');

    return $this->db->get($this->table)->result();
  }

  function get_all_by_divisi()
  {
    $this->db->select('
      id_pengembalian, tgl_kembali, pengembalian.divisi_id, pengembalian.user_id, pengembalian.arsip_id, pengembalian.created_at, pengembalian.created_by,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('users', 'pengembalian.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');

    $this->db->where('is_delete_pengembalian', '0');
    $this->db->where('pengembalian.instansi_id', $this->session->instansi_id);
    $this->db->where('pengembalian.cabang_id', $this->session->cabang_id);
    $this->db->where('pengembalian.divisi_id', $this->session->divisi_id);

    $this->db->order_by('id_pengembalian', 'DESC');

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted()
  {
    $this->db->select('
      id_pengembalian, tgl_kembali, pengembalian.divisi_id, pengembalian.user_id, pengembalian.arsip_id, pengembalian.created_at,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      divisi.divisi_name,
      cabang.cabang_name,
      instansi.instansi_name
    ');

    $this->db->join('users', 'pengembalian.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('is_delete_pengembalian', '1');

    $this->db->order_by('id_pengembalian', 'DESC');

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_instansi()
  {
    $this->db->select('
      id_pengembalian, tgl_kembali, pengembalian.divisi_id, pengembalian.user_id, pengembalian.arsip_id, pengembalian.created_at,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      divisi.divisi_name,
      cabang.cabang_name,
      instansi.instansi_name
    ');

    $this->db->join('users', 'pengembalian.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('is_delete_pengembalian', '1');
    $this->db->where('pengembalian.instansi_id', $this->session->instansi_id);

    $this->db->order_by('id_pengembalian', 'DESC');

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_cabang()
  {
    $this->db->select('
      id_pengembalian, tgl_kembali, pengembalian.instansi_id, pengembalian.divisi_id, pengembalian.user_id, pengembalian.arsip_id, pengembalian.created_at,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      divisi.divisi_name,
      cabang.cabang_name,
      instansi.instansi_name
    ');

    $this->db->join('users', 'pengembalian.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('is_delete_pengembalian', '1');
    $this->db->where('pengembalian.instansi_id', $this->session->instansi_id);
    $this->db->where('pengembalian.cabang_id', $this->session->cabang_id);

    $this->db->order_by('id_pengembalian', 'DESC');

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_divisi()
  {
    $this->db->select('
      id_pengembalian, tgl_kembali, pengembalian.divisi_id, pengembalian.user_id, pengembalian.arsip_id, pengembalian.created_at,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      divisi.divisi_name,
      cabang.cabang_name,
      instansi.instansi_name
    ');

    $this->db->join('users', 'pengembalian.user_id = users.id_users', 'LEFT');
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('is_delete_pengembalian', '1');
    $this->db->where('pengembalian.instansi_id', $this->session->instansi_id);
    $this->db->where('pengembalian.cabang_id', $this->session->cabang_id);
    $this->db->where('pengembalian.divisi_id', $this->session->divisi_id);

    $this->db->order_by('id_pengembalian', 'DESC');

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_user()
  {
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip');
    $this->db->join('users', 'pengembalian.user_id = users.id_users');

    $this->db->where('user_id', $this->session->id_users);
    $this->db->where('is_delete_pengembalian', '1');

    $this->db->order_by('pengembalian.deleted_at', $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_periode($tgl_awal, $tgl_akhir)
  {
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip');
    $this->db->join('users', 'pengembalian.user_id = users.id_users');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('pengembalian.created_at >=', $tgl_awal);
    $this->db->where('pengembalian.created_at <=', $tgl_akhir);

    return $this->db->get($this->table)->result();
  }

  function get_all_periode_by_instansi($tgl_awal, $tgl_akhir)
  {
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip');
    $this->db->join('users', 'pengembalian.user_id = users.id_users');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('pengembalian.created_at >=', $tgl_awal);
    $this->db->where('pengembalian.created_at <=', $tgl_akhir);
    $this->db->where('pengembalian.instansi_id', $this->session->instansi_id);

    return $this->db->get($this->table)->result();
  }

  function get_all_periode_by_cabang($tgl_awal, $tgl_akhir)
  {
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip');
    $this->db->join('users', 'pengembalian.user_id = users.id_users');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('pengembalian.created_at >=', $tgl_awal);
    $this->db->where('pengembalian.created_at <=', $tgl_akhir);
    $this->db->where('pengembalian.instansi_id', $this->session->instansi_id);
    $this->db->where('pengembalian.cabang_id', $this->session->cabang_id);

    return $this->db->get($this->table)->result();
  }

  function get_all_periode_by_divisi($tgl_awal, $tgl_akhir)
  {
    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip');
    $this->db->join('users', 'pengembalian.user_id = users.id_users');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->where('pengembalian.created_at >=', $tgl_awal);
    $this->db->where('pengembalian.created_at <=', $tgl_akhir);
    $this->db->where('pengembalian.instansi_id', $this->session->instansi_id);
    $this->db->where('pengembalian.divisi_id', $this->session->divisi_id);

    return $this->db->get($this->table)->result();
  }

  function get_all_combobox($id)
  {
    $this->db->where('menu_id', $id);
    $this->db->order_by('pengembalian_name');
    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Pengembalian';
        $result[$row['id_pengembalian']] = $row['pengembalian_name'];
      }
      return $result;
    }
  }

  function get_by_id($id)
  {
    $this->db->select('
      id_pengembalian, tgl_kembali, peminjaman_id, pengembalian.divisi_id as divisi, pengembalian.user_id, pengembalian.arsip_id,
      users.id_users, users.name,
      arsip.id_arsip, arsip.arsip_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('arsip', 'pengembalian.arsip_id = arsip.id_arsip', 'LEFT');
    $this->db->join('users', 'pengembalian.user_id = users.id_users', 'LEFT');
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'pengembalian.divisi_id = divisi.id_divisi', 'LEFT');

    $this->db->where($this->id, $id);

    return $this->db->get($this->table)->row();
  }

  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_instansi()
  {
    $this->db->join('instansi', 'pengembalian.instansi_id = instansi.id_instansi');

    $this->db->where('instansi_id', $this->session->instansi_id);

    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_cabang()
  {
    $this->db->join('cabang', 'pengembalian.cabang_id = cabang.id_cabang');

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
