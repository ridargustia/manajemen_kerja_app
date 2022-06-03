<?php defined('BASEPATH') or exit('No direct script access allowed');

// End load library phpspreadsheet
class Backups extends CI_Controller
{

  public function backup_db()
  {
    $this->load->dbutil();

    $prefs = array(
      'format'      => 'zip',
      'filename'    => 'backup-db-' . 'eduarsip' . '-on' . date("Y-m-d-H-i-s") . '.sql',
      'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
      'foreign_key_checks' => FALSE,
    );

    $backup = $this->dbutil->backup($prefs);

    $db_name = 'backup-db-' . 'eduarsip' . '-on-' . date("Y-m-d-H-i-s") . '.zip';
    $save = 'pathtobkfolder/' . $db_name;

    $this->load->helper('file');
    write_file($save, $backup);


    $this->load->helper('download');
    force_download($db_name, $backup);
  }

  // public function db_list()
  // {
  //   $this->load->dbutil();
  //   $dbs = $this->dbutil->list_databases();

  //   foreach ($dbs as $db) {
  //     echo $db . '<br>';
  //   }
  // }

  // public function table_list()
  // {
  //   $this->load->dbutil();

  //   $tables = $this->db->list_tables();

  //   foreach ($tables as $table) {
  //     echo $table . '<br>';
  //   }
  // }

  // public function field_list()
  // {
  //   if ($this->db->table_exists('usersa')) {

  //     $fields = $this->db->list_fields('users');

  //     foreach ($fields as $field) {
  //       echo $field . '<br>';
  //     }
  //   } else {
  //     echo "No data";
  //   }
  // }
}
