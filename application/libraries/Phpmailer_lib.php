<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use phpmailer\phpmailer\PHPMailer;
use phpmailer\phpmailer\Exception;

class PHPMailer_Lib
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
      // Include PHPMailer library files
      require_once 'vendor/phpmailer/phpmailer/src/Exception.php';
      require_once 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
      require_once 'vendor/phpmailer/phpmailer/src/SMTP.php';

      $mail = new PHPMailer;
      return $mail;
    }
}
