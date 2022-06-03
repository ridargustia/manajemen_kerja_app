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
        <li><a href="<?php echo base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><?php echo $module ?></li>
        <li class="active"><?php echo $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
      } ?>
      <?php echo validation_errors() ?>
      <div class="box box-primary">
        <?php echo form_open($action, array('class' => 'form-horizontal')) ?>
        <div class="box-body">
          <div class="form-group">
            <label class="col-lg-2 control-label">Alamat Email</label>
            <div class="col-lg-10">
              <?php echo $tokens->email ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Nama Instansi</label>
            <div class="col-lg-10">
              <?php echo form_dropdown('', $get_all_combobox_instansi, $tokens->instansi_id, $instansi_id) ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Nama Folder Google Drive</label>
            <div class="col-lg-10">
              <?php echo form_input($folder_name, $tokens->folder_name) ?>            
            </div>
          </div>          
        </div>
        <?php echo form_input($id_tokens, $tokens->id_tokens) ?>
        <div class="box-footer">
          <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
          <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
        </div>
        <!-- /.box-body -->
        <?php echo form_close() ?>
      </div>

      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('back/template/footer'); ?>  

</div>
<!-- ./wrapper -->

</body>

</html>