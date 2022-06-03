<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arsip_model extends CI_Model
{

  public $table = 'arsip';
  public $id    = 'id_arsip';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.is_delete', '0');

    // $this->db->group_by('id_arsip');
    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }
  
  function get_all_laporan()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.is_delete', '0');

    // $this->db->group_by('id_arsip');
    //$this->db->group_by('arsip.arsip_name');

    $this->db->order_by('no_arsip', 'ASC');

    return $this->db->get($this->table)->result();
  }

  function get_all_front()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      jenis_arsip.jenis_name,
    ');

    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');
    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.is_delete', '0');

    // $this->db->group_by('id_arsip');
    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_periode($tgl_awal, $tgl_akhir)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->where('arsip.is_delete', '0');
    $this->db->where('arsip.created_at >=', $tgl_awal);
    $this->db->where('arsip.created_at <=', $tgl_akhir);

    // $this->db->group_by('id_arsip');
    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_instansi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      jenis_arsip.jenis_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');
    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }
  
  function get_all_by_instansi_laporan()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      jenis_arsip.jenis_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');
    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.is_delete', '0');

    //$this->db->group_by('id_arsip');

    $this->db->order_by('no_arsip', 'ASC');

    return $this->db->get($this->table)->result();
  }

  function get_all_periode_by_instansi($tgl_awal, $tgl_akhir)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.is_delete', '0');
    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.created_at >=', $tgl_awal);
    $this->db->where('arsip.created_at <=', $tgl_akhir);

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_cabang()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }
  
  function get_all_by_cabang_laporan()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.is_delete', '0');

    //$this->db->group_by('id_arsip');

    $this->db->order_by('no_arsip', 'ASC');

    return $this->db->get($this->table)->result();
  }

  function get_all_periode_by_cabang($tgl_awal, $tgl_akhir)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.is_delete', '0');
    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.created_at >=', $tgl_awal);
    $this->db->where('arsip.created_at <=', $tgl_akhir);

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_by_divisi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.divisi_id', $this->session->userdata('divisi_id'));
    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }
  
  function get_all_by_divisi_laporan()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.divisi_id', $this->session->userdata('divisi_id'));
    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by('no_arsip', 'ASC');

    return $this->db->get($this->table)->result();
  }

  function get_all_periode_by_divisi($tgl_awal, $tgl_akhir)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.divisi_id', $this->session->userdata('divisi_id'));
    $this->db->where('arsip.is_delete', '0');
    $this->db->where('arsip.created_at >=', $tgl_awal);
    $this->db->where('arsip.created_at <=', $tgl_akhir);

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  // arsip aktif by status_retensi
  function get_all_aktif()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.status_retensi', '1');
    $this->db->where('arsip.is_delete', '0');

    // $this->db->group_by('id_arsip');
    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_aktif_by_instansi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.status_retensi', '1');
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_aktif_by_cabang()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.status_retensi', '1');
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_aktif_by_divisi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.divisi_id', $this->session->userdata('divisi_id'));
    $this->db->where('arsip.status_retensi', '1');
    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  // arsip inaktif by status_retensi
  function get_all_inaktif()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.status_retensi', '0');
    $this->db->where('arsip.is_delete', '0');

    // $this->db->group_by('id_arsip');
    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_inaktif_by_instansi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.status_retensi', '0');
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_inaktif_by_cabang()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.status_retensi', '0');
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_inaktif_by_divisi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.divisi_id', $this->session->userdata('divisi_id'));
    $this->db->where('arsip.status_retensi', '0');
    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  // arsip permanen by keterangan
  function get_all_permanen()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      lokasi.lokasi_name,
      instansi.instansi_name
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');    
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->where('arsip.keterangan', '0');
    $this->db->where('arsip.is_delete', '0');

    // $this->db->group_by('id_arsip');
    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_permanen_by_instansi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.keterangan', '0');
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_permanen_by_cabang()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.keterangan', '0');
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_permanen_by_divisi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.divisi_id', $this->session->userdata('divisi_id'));
    $this->db->where('arsip.keterangan', '0');
    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  // arsip musnah by keterangan
  function get_all_musnah()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.keterangan', '1');
    $this->db->where('arsip.is_delete', '0');

    // $this->db->group_by('id_arsip');
    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_musnah_by_instansi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.keterangan', '1');
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_musnah_by_cabang()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.keterangan', '1');
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_musnah_by_divisi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.divisi_id', $this->session->userdata('divisi_id'));
    $this->db->where('arsip.keterangan', '1');
    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_combobox()
  {
    $this->db->order_by('arsip_name');
    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Arsip -';
        $result[$row['id_arsip']] = $row['arsip_name'];
      }
      return $result;
    } else {
      $result[''] = '- Semua Arsip Telah Dipinjam -';
      return $result;
    }
  }

  function get_all_combobox_by_divisi($divisi_id)
  {
    $this->db->where('arsip.divisi_id', $divisi_id);
    $this->db->where('arsip.is_delete', 0);

    $this->db->order_by('arsip_name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Arsip -';
        $result[$row['id_arsip']] = $row['arsip_name'];
      }
    } else {
      $result[''] = '- Semua Arsip Telah Dipinjam/Tidak Ada -';
    }
    return $result;
  }

  function get_all_combobox_arsip_available()
  {
    $this->db->where('is_available', '1');
    $this->db->order_by('arsip_name');
    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Arsip -';
        $result[$row['id_arsip']] = $row['arsip_name'];
      }
      return $result;
    } else {
      $result[''] = '- Semua Arsip Telah Dipinjam -';
      return $result;
    }
  }

  function get_all_combobox_arsip_available_by_instansi()
  {
    $this->db->where('is_available', '1');
    $this->db->where('instansi_id', $this->session->userdata('instansi_id'));

    $this->db->order_by('arsip_name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Arsip -';
        $result[$row['id_arsip']] = $row['arsip_name'];
      }
      return $result;
    } else {
      $result[''] = '- Semua Arsip Telah Dipinjam -';
      return $result;
    }
  }

  function get_all_combobox_arsip_available_by_cabang()
  {
    $this->db->where('is_available', '1');
    $this->db->where('cabang_id', $this->session->userdata('cabang_id'));

    $this->db->order_by('arsip_name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Arsip -';
        $result[$row['id_arsip']] = $row['arsip_name'];
      }
      return $result;
    } else {
      $result[''] = '- Semua Arsip Telah Dipinjam -';
      return $result;
    }
  }

  function get_all_combobox_arsip_available_by_divisi($divisi_id)
  {
    $this->db->where('divisi_id', $divisi_id);
    $this->db->where('is_available', '1');

    $this->db->order_by('arsip_name');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Arsip -';
        $result[$row['id_arsip']] = $row['arsip_name'];
      }
      return $result;
    } else {
      $result[''] = '- Semua Arsip Telah Dipinjam -';
      return $result;
    }
  }

  function get_all_combobox_pengembalian($id)
  {
    $this->db->join('peminjaman', 'arsip.id_arsip = peminjaman.arsip_id');
    $this->db->where('id_peminjaman', $id);
    $this->db->order_by('arsip_name');
    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        // $result[''] = '- Silahkan Pilih Kode Peminjaman';
        $result[$row['id_arsip']] = $row['arsip_name'];
      }
      return $result;
    }
  }

  function get_all_deleted()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.is_delete', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_instansi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.is_delete', '1');

    $this->db->group_by('id_arsip');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_cabang()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.is_delete', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_divisi()
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete, arsip.keterangan,
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,      
      lokasi.lokasi_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name, arsip.created_by as created_by_arsip
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.cabang_id', $this->session->userdata('cabang_id'));
    $this->db->where('arsip.divisi_id', $this->session->userdata('divisi_id'));
    $this->db->where('arsip.is_delete', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_all_deleted_by_user()
  {
    $this->db->select('
      users.username,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      divisi.divisi_name,
      map.map_name,
      arsip.id_arsip, arsip.arsip_name, arsip.no_arsip, arsip.lokasi_id, arsip.status_retensi, arsip.status_file, arsip.is_available, arsip.masa_retensi, arsip.is_delete
    ');
    $this->db->join('users', 'arsip.user_id = users.id_users');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris');
    $this->db->join('box', 'arsip.box_id = box.id_box');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi');
    $this->db->join('map', 'arsip.map_id = map.id_map');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak');

    $this->db->where('arsip.user_id', $this->session->userdata('id_users'));
    $this->db->where('arsip.is_delete', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_by_id($id)
  {
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris');
    $this->db->join('box', 'arsip.box_id = box.id_box');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi');
    $this->db->join('map', 'arsip.map_id = map.id_map');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak');

    $this->db->where($this->id, $id);

    return $this->db->get($this->table)->row();
  }

  function get_by_id_front($id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.no_arsip, arsip.deskripsi_arsip, arsip.instansi_id, arsip.cabang_id, arsip.divisi_id, arsip.lokasi_id,
      arsip.status_file, arsip.user_id, arsip.created_at as waktu_dibuat, arsip.masa_retensi, arsip.link_gdrive,
      baris.baris_name,
      box.box_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      lokasi.lokasi_name,
      map.map_name,
      rak.rak_name,
      users.name
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');

    $this->db->where($this->id, $id);

    return $this->db->get($this->table)->row();
  }

  function get_no_arsip_by_instansi($id)
  {
    $this->db->select('arsip.no_arsip, instansi.id_instansi');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi');
    
    $this->db->where('arsip.instansi_id', $this->session->instansi_id);
    if(is_superadmin() or is_admin()) {
        $this->db->where('arsip.cabang_id', $this->session->cabang_id);
    }
    $this->db->where('no_arsip', $id);

    return $this->db->get($this->table)->row();
  }
  
  function get_no_arsip_by_cabang($id, $cabang_id, $instansi_id)
  {
    $this->db->select('arsip.no_arsip, instansi.id_instansi');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi');

    $this->db->where('arsip.instansi_id', $instansi_id);
    $this->db->where('arsip.cabang_id', $cabang_id);
    $this->db->where('arsip.no_arsip', $id);

    return $this->db->get($this->table)->row();
  }

  function get_arsip_name_by_instansi($arsip_name)
  {
    $this->db->select('arsip.arsip_name, instansi.id_instansi');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi');

    $this->db->where('arsip.instansi_id', $this->session->instansi_id);
    $this->db->where('arsip_name', $arsip_name);

    return $this->db->get($this->table)->row();
  }
  
  function get_arsip_name_by_instansi_and_cabang($arsip_name, $cabang_id, $instansi_id)
  {
    $this->db->select('arsip.arsip_name, instansi.id_instansi');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi');

    $this->db->where('arsip.instansi_id', $instansi_id);
    $this->db->where('arsip.cabang_id', $cabang_id);
    $this->db->where('arsip.arsip_name', $arsip_name);

    return $this->db->get($this->table)->row();
  }
  
  function get_arsip_name_by_cabang($arsip_name)
  {
    $this->db->select('arsip.arsip_name, cabang.id_cabang');

    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang');

    $this->db->where('arsip.cabang_id', $this->session->cabang_id);
    $this->db->where('arsip_name', $arsip_name);

    return $this->db->get($this->table)->row();
  }

  function get_detail($id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.no_arsip, arsip.deskripsi_arsip, arsip.lokasi_id, arsip.status_retensi,
      arsip.status_file, arsip.is_available, arsip.user_id, arsip.created_by as pembuat_arsip, arsip.created_at as waktu_dibuat, arsip.instansi_id, arsip.cabang_id, arsip.divisi_id,
      arsip.link_gdrive, arsip.masa_retensi, arsip.is_delete,
      users.name as pemilik_arsip,
      baris.baris_name,
      box.box_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      map.map_name,
      rak.rak_name,
      lokasi.lokasi_name
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');

    $this->db->where($this->id, $id);

    return $this->db->get($this->table)->row();
  }

  function get_files_id_result($id)
  {
    $this->db->from('arsip_files');
    $this->db->where('arsip_id', $id);
    $query = $this->db->get();
    return $query->result();
  }

  function get_files_id_row($id)
  {
    $this->db->from('arsip_files');
    $this->db->where('id_files', $id);
    $query = $this->db->get();
    return $query->row();
  }

  function cari_arsip($data)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.no_arsip, arsip.lokasi_id, arsip.deskripsi_arsip,
      baris.baris_name,
      box.box_name,
      divisi.divisi_name,
      map.map_name,
      rak.rak_name
    ');

    $this->db->join('baris', 'arsip.baris_id = baris.id_baris');
    $this->db->join('box', 'arsip.box_id = box.id_box');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi');
    $this->db->join('map', 'arsip.map_id = map.id_map');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak');

    $this->db->like('arsip_name', $data);
    $this->db->like('divisi_id', $this->input->post('divisi_id'));
    $this->db->or_like('deskripsi_arsip', $data);

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);
    return $query->result();
  }

  function cari_all_arsip_by_instansi_with_searchFormNull_and_instansiIdNotNull($instansi_id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      lokasi.lokasi_name, arsip.is_available
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    // $this->db->like('arsip_name', $search_form);
    $this->db->like('arsip.instansi_id', $instansi_id);
    // $this->db->or_like('deskripsi_arsip', $search_form);

    $this->db->where('arsip.instansi_id', $instansi_id);
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  function cari_all_arsip_by_instansi_with_searchFormNotNull_and_instansiIdNull($search_form)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      lokasi.lokasi_name, arsip.is_available
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->like('arsip_name', $search_form);
    $this->db->or_like('deskripsi_arsip', $search_form);

    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  function cari_all_arsip_by_instansi_with_searchFormNotNull($search_form, $instansi_id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      lokasi.lokasi_name, arsip.is_available
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->like('arsip_name', $search_form);
    // $this->db->or_like('deskripsi_arsip', $search_form);
    // $this->db->like('arsip.instansi_id', $instansi_id);

    $this->db->where('arsip.instansi_id', $instansi_id);
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  ///////////////////////////////////////

  function get_all_by_instansi_with_searchFormNull_and_cabangNotNull($cabang_id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      lokasi.lokasi_name, arsip.is_available
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->where('arsip.cabang_id', $cabang_id);
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  function get_all_by_instansi_with_searchFormNotNull_and_cabangNull($search_form)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      lokasi.lokasi_name, arsip.is_available
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->like('arsip_name', $search_form);
    // $this->db->or_like('deskripsi_arsip', $search_form);

    $this->db->where('arsip.instansi_id', $this->session->instansi_id);
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  function get_all_by_instansi_with_searchFormNotNull_and_cabangNotNull($search_form, $cabang_id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      lokasi.lokasi_name, arsip.is_available
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->like('arsip_name', $search_form);
    // $this->db->or_like('deskripsi_arsip', $search_form);    

    $this->db->where('arsip.instansi_id', $this->session->instansi_id);
    $this->db->where('arsip.cabang_id', $cabang_id);
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  /////////////////////////////////////////////////

  function get_all_by_instansi_with_searchFormNull_and_divisiNotNull($divisi_id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      lokasi.lokasi_name, arsip.is_available
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');    

    $this->db->where('arsip.divisi_id', $divisi_id);
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  function get_all_by_instansi_with_searchFormNotNull_and_divisiNull($search_form)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      lokasi.lokasi_name, arsip.is_available
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->like('arsip_name', $search_form);
    // $this->db->or_like('deskripsi_arsip', $search_form);

    $this->db->where('arsip.instansi_id', $this->session->instansi_id);    
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  function get_all_by_instansi_with_searchFormNotNull_and_divisiNotNull($search_form, $divisi_id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name,
      lokasi.lokasi_name, arsip.is_available
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('lokasi', 'arsip.lokasi_id = lokasi.id_lokasi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->like('arsip_name', $search_form);
    // $this->db->or_like('deskripsi_arsip', $search_form);    

    $this->db->where('arsip.instansi_id', $this->session->instansi_id);
    $this->db->where('arsip.divisi_id', $divisi_id);
    $this->db->where('arsip.is_delete', '0');

    $this->db->group_by('arsip.arsip_name');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  // function cari_all_arsip_by_instansi_and_divisi_with_searchFormNotNull_and_instansiIdNotNull($search_form, $divisi_id)
  // {
  //   $this->db->select('
  //   arsip.id_arsip, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
  //   baris.baris_name,
  //   rak.rak_name,
  //   box.box_name,
  //   divisi.divisi_name,
  //   map.map_name,
  //   jenis_arsip.jenis_name
  //   ');

  //   $this->db->join('users', 'arsip.user_id = users.id_users');
  //   $this->db->join('baris', 'arsip.baris_id = baris.id_baris');
  //   $this->db->join('box', 'arsip.box_id = box.id_box');
  //   $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi');
  //   $this->db->join('map', 'arsip.map_id = map.id_map');
  //   $this->db->join('rak', 'arsip.rak_id = rak.id_rak');
  //   $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
  //   $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

  //   $this->db->like('arsip_name', $search_form);
  //   $this->db->like('instansi_id', $instansi_id);
  //   $this->db->or_like('deskripsi_arsip', $search_form);

  //   $this->db->where('arsip.instansi_id', $instansi_id);
  //   $this->db->where('arsip.is_delete', '0');

  //   $this->db->order_by($this->id, 'DESC');

  //   $query = $this->db->get($this->table);

  //   return $query->result();
  // }

  function cari_all_arsip_by_instansi_and_divisi_with_searchFormNotNull_and_divisiIdNull($search_form, $divisi_id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->like('arsip_name', $search_form);
    $this->db->or_like('deskripsi_arsip', $search_form);

    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }


  function cari_all_arsip_by_instansi_and_divisi_with_searchFormNotNull_and_divisiIdNotNull($search_form, $divisi_id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->like('arsip_name', $search_form);
    $this->db->like('divisi_id', $divisi_id);
    $this->db->or_like('deskripsi_arsip', $search_form);

    $this->db->where('arsip.divisi_id', $divisi_id);
    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  function cari_arsip_by_instansi_and_divisi_with_searchFormNotNull_and_divisiIdNull($search_form)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
      cabang.cabang_name,
      divisi.divisi_name
    ');

    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi', 'LEFT');
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi', 'LEFT');
    $this->db->join('users', 'arsip.user_id = users.id_users', 'LEFT');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris', 'LEFT');
    $this->db->join('box', 'arsip.box_id = box.id_box', 'LEFT');
    $this->db->join('map', 'arsip.map_id = map.id_map', 'LEFT');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak', 'LEFT');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->like('arsip_name', $search_form);
    $this->db->like('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->or_like('deskripsi_arsip', $search_form); // per 14 mei 2020
    // $this->db->like('deskripsi_arsip', $search_form);

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    // $this->db->where('arsip.divisi_id', $this->session->userdata('divisi_id'));
    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  function cari_arsip_by_instansi_and_divisi_with_searchFormNull_and_divisiIdNotNull($divisi_id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      divisi.divisi_name,
      map.map_name,
      jenis_arsip.jenis_name
    ');

    $this->db->join('users', 'arsip.user_id = users.id_users');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris');
    $this->db->join('box', 'arsip.box_id = box.id_box');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi');
    $this->db->join('map', 'arsip.map_id = map.id_map');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    // $this->db->like('arsip_name', $search_form);
    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.divisi_id', $divisi_id);

    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  function cari_arsip_by_instansi_and_divisi_with_searchFormNotNull_and_divisiIdNotNull($search_form, $divisi_id)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.deskripsi_arsip, arsip.no_arsip, arsip.lokasi_id,
      baris.baris_name,
      rak.rak_name,
      box.box_name,
      divisi.divisi_name,
      map.map_name,
      jenis_arsip.jenis_name,
      instansi.instansi_name,
    ');

    $this->db->join('users', 'arsip.user_id = users.id_users');
    $this->db->join('baris', 'arsip.baris_id = baris.id_baris');
    $this->db->join('box', 'arsip.box_id = box.id_box');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi');
    $this->db->join('instansi', 'arsip.instansi_id = instansi.id_instansi');
    $this->db->join('map', 'arsip.map_id = map.id_map');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak');
    $this->db->join('arsip_jenis', 'arsip.id_arsip = arsip_jenis.arsip_id', 'LEFT');
    $this->db->join('jenis_arsip', 'arsip_jenis.jenis_arsip_id = jenis_arsip.id_jenis', 'LEFT');

    $this->db->like('divisi_id', $divisi_id);
    $this->db->like('arsip_name', $search_form);
    $this->db->or_like('deskripsi_arsip', $search_form);

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.divisi_id', $divisi_id);
    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);

    return $query->result();
  }

  function cari_arsip_by_divisi($data)
  {
    $this->db->select('
      arsip.id_arsip, arsip.user_id, arsip.arsip_name, arsip.no_arsip, arsip.lokasi_id, arsip.deskripsi_arsip,
      baris.baris_name,
      box.box_name,
      divisi.divisi_name,
      map.map_name,
      rak.rak_name
    ');

    $this->db->join('baris', 'arsip.baris_id = baris.id_baris');
    $this->db->join('box', 'arsip.box_id = box.id_box');
    $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi');
    $this->db->join('map', 'arsip.map_id = map.id_map');
    $this->db->join('rak', 'arsip.rak_id = rak.id_rak');

    $this->db->like('arsip_name', $data);
    // $this->db->like('divisi_id', $this->input->post('divisi_id'));
    $this->db->or_like('deskripsi_arsip', $data);

    $this->db->where('arsip.instansi_id', $this->session->userdata('instansi_id'));
    $this->db->where('arsip.divisi_id', $this->session->userdata('divisi_id'));
    $this->db->where('arsip.is_delete', '0');

    $this->db->order_by($this->id, 'DESC');

    $query = $this->db->get($this->table);
    return $query->result();
  }

  // function cari_arsip_by_admin($data)
  // {
  //   $this->db->select('
  //     arsip.id_arsip, arsip.arsip_name, arsip.no_arsip, arsip.lokasi_id, arsip.deskripsi_arsip,
  //     baris.baris_name,
  //     box.box_name,
  //     divisi.divisi_name,
  //     map.map_name,
  //     rak.rak_name
  //   ');
  //
  //   $this->db->join('baris', 'arsip.baris_id = baris.id_baris');
  //   $this->db->join('box', 'arsip.box_id = box.id_box');
  //   $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi');
  //   $this->db->join('map', 'arsip.map_id = map.id_map');
  //   $this->db->join('rak', 'arsip.rak_id = rak.id_rak');
  //
  //   $this->db->like('arsip_name', $data);
  //   // $this->db->like('divisi_id', $this->session->divisi_id);
  //   $this->db->or_like('deskripsi_arsip', $data);
  //
  //   $this->db->where('arsip.instansi_id', $this->session->instansi_id);
  //
  //   $this->db->order_by($this->id, 'DESC');
  //
  //   $query = $this->db->get($this->table);
  //   return $query->result();
  // }


  // function cari_arsip_umum($data)
  // {
  //   $this->db->join('baris', 'arsip.baris_id = baris.id_baris');
  //   $this->db->join('box', 'arsip.box_id = box.id_box');
  //   $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi');
  //   $this->db->join('map', 'arsip.map_id = map.id_map');
  //   $this->db->join('rak', 'arsip.rak_id = rak.id_rak');
  //
  //   $this->db->where('status_file', '1');
  //
  //   $this->db->like('arsip_name', $data);
  //   $this->db->like('divisi_id', $this->input->post('divisi_id'));
  //   $this->db->or_like('deskripsi_arsip', $data);
  //
  //   $this->db->order_by($this->id, 'DESC');
  //
  //   $query = $this->db->get($this->table);
  //   return $query->result();
  // }
  //
  // function cari_arsip_khusus($data)
  // {
  //   $this->db->join('baris', 'arsip.baris_id = baris.id_baris');
  //   $this->db->join('box', 'arsip.box_id = box.id_box');
  //   $this->db->join('divisi', 'arsip.divisi_id = divisi.id_divisi');
  //   $this->db->join('map', 'arsip.map_id = map.id_map');
  //   $this->db->join('rak', 'arsip.rak_id = rak.id_rak');
  //
  //   $this->db->where('status_file', '0');
  //
  //   $this->db->like('arsip_name', $data);
  //   $this->db->like('divisi_id', $this->input->post('divisi_id'));
  //   $this->db->or_like('deskripsi_arsip', $data);
  //
  //   $this->db->order_by($this->id, 'DESC');
  //
  //   $query = $this->db->get($this->table);
  //   return $query->result();
  // }

  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_instansi()
  {
    $this->db->where('instansi_id', $this->session->instansi_id);

    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_cabang()
  {
    $this->db->join('cabang', 'arsip.cabang_id = cabang.id_cabang', 'LEFT');

    $this->db->where('cabang_id', $this->session->cabang_id);

    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_divisi()
  {
    $this->db->where('instansi_id', $this->session->instansi_id);
    $this->db->where('divisi_id', $this->session->divisi_id);

    return $this->db->get($this->table)->num_rows();
  }

  function total_rows_by_user()
  {
    $this->db->where('user_id', $this->session->id_users);
    return $this->db->get($this->table)->num_rows();
  }

  function insert($data)
  {
    $this->db->insert($this->table, $data);
  }

  function insert_files($data)
  {
    $this->db->insert('arsip_files', $data);
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

  public function delete_by_id($id)
	{
		$this->db->where($this->id, $id);
		$this->db->delete($this->table);
	}

  function del_files_by_id_files($id)
  {
    $this->db->where('id_files', $id);
    $this->db->delete('arsip_files');
  }

  function change_archive_status($id, $data)
  {
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);
  }

  function set_available($id, $data)
  {
    $this->db->where('is_available', $id);
    $this->db->update($this->table, $data);
  }

  function set_unavailable($id, $data)
  {
    $this->db->where($this->id . 'z', $id);
    $this->db->update($this->table, $data);
  }
}
