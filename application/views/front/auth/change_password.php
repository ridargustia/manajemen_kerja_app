<?php $this->load->view('front/template/meta'); ?>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
  <div class="wrapper">

  <?php $this->load->view('front/template/navbar'); ?>

  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>Ganti Password</h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Auth</a></li>
          <li><a href="#">Ganti Password</a></li>
        </ol>
      </section>

      <section class="content">
        <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>

        <?php echo validation_errors() ?>
        <?php echo form_open($action) ?>
          <div class="box box-primary">
            <div class="box-body">              
              <div class="form-group"><label>Password Baru (*)</label>
                <?php echo form_password($new_password) ?>
              </div>
              <div class="form-group"><label>Isikan Kembali Password Baru</label>
                <?php echo form_password($confirm_new_password) ?>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
              <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
            </div>
          </div>
        <?php echo form_close() ?>

      </section>
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('front/template/footer'); ?>

</body>
</html>