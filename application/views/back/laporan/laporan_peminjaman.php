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
      <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>

      <div class="box box-primary">
        <?php echo form_open('admin/laporan/peminjaman_print_all') ?>
          <div class="box-header"><label>Cetak Laporan Keseluruhan</label> </div>
          <div class="box-footer">
            <button type="submit" name="submit" class="btn btn-primary">DOWNLOAD</button>
          </div>
        <?php echo form_close() ?>
        <!-- /.box-body -->
      </div>

      <div class="box box-warning">
        <?php echo form_open('admin/laporan/peminjaman_print_periode') ?>
          <div class="box-header"><label>Cetak Laporan Per Periode</label></div>
          <div class="box-body">
            <div class="form-group"><label>Tanggal Awal</label>
              <input type="text" name="tgl_awal" id="tgl_awal" class="form-control" autocomplete="off">
            </div>
            <div class="form-group"><label>Tanggal Akhir</label>
              <input type="text" name="tgl_akhir" id="tgl_akhir" class="form-control" autocomplete="off">
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" name="submit" class="btn btn-warning">DOWNLOAD</button>
          </div>
        <?php echo form_close() ?>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('back/template/footer'); ?>

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <script src="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <script type="text/javascript">
  $('#tgl_awal').datepicker({
    autoclose: true,
    format: 'yyyy/mm/dd',
    zIndexOffset: 9999,
    todayHighlight: true,
  });
  $('#tgl_akhir').datepicker({
    autoclose: true,
    format: 'yyyy/mm/dd',
    zIndexOffset: 9999,
    todayHighlight: true,
  })
  </script>

</div>
<!-- ./wrapper -->

</body>
</html>
