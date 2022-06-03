<?php $this->load->view('back/template/meta'); ?>
<div class="wrapper">

  <?php $this->load->view('back/template/navbar'); ?>
  <?php $this->load->view('back/template/sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $page_title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><?php echo $module ?></li>
        <li class="active"><?php echo $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>

      <?php echo form_open($action) ?>
      <?php echo validation_errors() ?>
        <div class="box box-primary">
          <div class="box-body">
            <?php if(!is_admin()){ ?>
              <div class="form-group"><label>User (*)</label>
                <?php echo form_dropdown('', $get_all_users, '', $user_id) ?>
              </div>
            <?php } ?>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('back/template/footer'); ?>

  <!-- select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/dist/css/select2.min.css">
  <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/select2/dist/js/select2.full.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#user_id").select2({
        // placeholder: "Silahkan Pilih Peminjam",
      });
    });
  </script>

</div>
<!-- ./wrapper -->

</body>
</html>
