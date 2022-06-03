<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CronRunner{
   private $CI;
   
   public function __construct()
   {
      $this->CI =& get_instance();
   }

   private function calculateNextRun($obj)
   {
      return (time() + $obj->interval_sec);
   }

   public function run()
   {
      $now = date('Y-m-d');

      $this->CI->db->select("id_arsip, masa_retensi, status_retensi");
      $this->CI->db->where('masa_retensi <=', $now);
      $query = $this->CI->db->get('arsip');
      $row = $query->num_rows();

      if($row)
      {
         // echo $query->num_rows();
         for($i=1;$i<=$row;$i++){
         $this->CI->db->set('status_retensi', '0');
         $this->CI->db->where('masa_retensi <=', $now);
         $this->CI->db->update('arsip');
         }
      // echo "Success";
      }
   }
}