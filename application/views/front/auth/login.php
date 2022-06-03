<!DOCTYPE html>
<html>
<head>
  <title><?php echo $page_title.' | '.$company_data->company_name ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/back/') ?>dist/css/AdminLTE.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url('assets/images/company/'.$company_data->company_photo_thumb) ?>" />
  <style>
    .bg {
      /* The image used */
      background-image: url("../assets/images/bg.jpg");      

      /* Center and scale the image nicely */
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
  
  <script src="<?php echo base_url('assets/jquery/') ?>jquery.js"></script>
  <script type="text/javascript">
    var $j = jQuery.noConflict();
    $j(document).ready(function(){
      $j('#checkbox').click(function(){
        if($j(this).is(':checked')) {
          $j('#password').attr('type', 'text');
        } else {
          $j('#password').attr('type', 'password');
        }
      });
    });
  </script>
</head>
<body class="hold-transition login-page bg">
  <div class="login-box">
    <div class="login-logo">
      <img src="<?php echo base_url('assets/images/company/'). $company_data->company_photo ?>" width="200px" class="img-circle" alt="company-logo">      
    </div>
    <div class="login-box-body">
    <p class="login-box-msg">Silahkan Isi Username dan Password Anda untuk Masuk ke Sistem</p>
      <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>
      <?php echo validation_errors() ?>
      <?php echo form_open($action) ?>
        <div class="form-group has-feedback">
          <?php echo form_input($username) ?>
          <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback" style="margin-bottom:10px;">
          <?php echo form_password($password) ?>
          <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="row" style="margin-bottom:10px">
          <div class="col-lg-12">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="checkbox">
              <label class="form-check-label" for="flexCheckDefault" style="font-weight:10">
                Show Password
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <br><a href="<?php echo base_url('auth/forgot_password') ?>">Lupa password? Klik disini</a><br>

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

</body>
</html>
