<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Token_model extends CI_Model
{

  var $table  = 'tokens';
  var $id     = 'id_tokens';
  var $column_order = array('email', 'token', null); //set column field database for datatable orderable
  var $column_search = array('email', 'token'); //set column field database for datatable searchable just firstname , lastname , address are searchable
  var $order = array('id_tokens' => 'desc'); // default order

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function get_all()
  {
    $this->db->order_by($this->id);

    return $this->db->get($this->table)->result();
  }

  function get_all_combobox()
  {
    $this->db->order_by('email');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Akun Google -';
        $result[$row['id_tokens']] = $row['email'];
      }
    } else {
      $result['-'] = '- Belum Ada Akun Google -';
    }
    return $result;
  }

  function get_all_combobox_by_id_user()
  {
    $this->db->where('user_id', $this->session->id_users);

    $this->db->order_by('email');

    $data = $this->db->get($this->table);

    if ($data->num_rows() > 0) {
      foreach ($data->result_array() as $row) {
        $result[''] = '- Silahkan Pilih Akun Google Anda -';
        $result[$row['email']] = $row['email'];
      }
    } else {
      $result['-'] = '- Belum Ada Akun Google -';
    }
    return $result;
  }

  private function _get_datatables_query()
  {
    // $this->db->where('user_id', $this->session->id_users);

    $this->db->join('instansi', 'tokens.instansi_id = instansi.id_instansi', 'LEFT');

    $this->db->from($this->table);

    $i = 0;

    foreach ($this->column_search as $item) // loop column
    {
      if ($_POST['search']['value']) // if datatable send POST for search
      {

        if ($i === 0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if (count($this->column_search) - 1 == $i) //last loop
        {
          $this->db->group_end();
        }
        //close bracket
      }
      $i++;
    }

    if (isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  function get_datatables()
  {
    $this->_get_datatables_query();
    if ($_POST['length'] != -1) {
      $this->db->limit($_POST['length'], $_POST['start']);
    }

    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where($this->id, $id);
    $query = $this->db->get();

    return $query->row();
  }

  public function get_by_id_instansi($id_instansi = '')
  {
    $this->db->where('instansi_id', $id_instansi);

    return $this->db->get($this->table)->row();
  }

  function get_folder_name_by_email($email)
  {
    $this->db->where('email', $email);

    return $this->db->get($this->table)->row();
  }

  public function save($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function update($id, $data)
  {
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);
  }

  public function delete_by_id($id)
  {
    $this->db->where($this->id, $id);
    $this->db->delete($this->table);
  }
}
