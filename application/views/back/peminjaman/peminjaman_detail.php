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
      <div class="box box-primary">
        <div class="box-body">
          <div class="form-group"><label>Kode Peminjaman (*)</label>
            <p><?php echo $peminjaman->kode_peminjaman ?></p>
          </div>
          <div class="form-group"><label>Nama Peminjam (*)</label>
            <p><?php echo $peminjaman->name ?></p>
          </div>
          <div class="form-group"><label>Nama Arsip (*)</label>
            <p><?php echo $peminjaman->arsip_name ?></p>
          </div>
          <p><a href="<?php echo base_url('admin/pengembalian') ?>" class="btn btn-lg btn-info"> Kembali Ke Halaman Sebelumnya</a></p>
        </div>
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
