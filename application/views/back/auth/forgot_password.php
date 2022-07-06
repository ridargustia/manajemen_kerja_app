<!DOCTYPE html>
<html>

<head>
  <title><?php echo $page_title ?></title>
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
  <link rel="shortcut icon" href="<?php echo base_url('assets/images/company/' . $company_data->company_photo_thumb) ?>" />

  <style>
    .bg {
      /* The image used */
      background-image: url("../assets/images/bg2.jpg");

      /* Center and scale the image nicely */
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    #box-position {
      margin: 15% auto;
    }
  </style>
</head>

<body class="hold-transition login-page bg">
  <div class="login-box" id="box-position">

    <div class="login-box-body">
      <div class="text-center" style="font-size: 25px; margin-bottom:5px;">
        <b>Lupa Password</b>
      </div>
      <p class="login-box-msg">Silahkan isi email Anda untuk mereset password</p>
      <?php if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
      } ?>
      <?php echo validation_errors() ?>
      <?php echo form_open($action) ?>
      <div class="form-group has-feedback">
        <?php echo form_input($email) ?>
        <span class="fa fa-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Kirim Permintaan Reset Password</button>
        </div>
        <!-- /.col -->
      </div>
      </form>

      <br><a href="<?php echo base_url('auth/login') ?>">Kembali ke halaman login</a><br>
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

</body>

</html>