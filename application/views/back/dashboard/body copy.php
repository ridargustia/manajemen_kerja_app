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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
      } ?>

      <div class="callout callout-warning">
        <h4><i class="fa fa-bullhorn"></i> Halo, <?php echo $this->session->name ?>!</h4>

        <p>
          Selamat Datang di Halaman Dashboard Sistem <b><?php echo $company_data->company_name ?></b>!
          <br>
          Saat ini Anda sedang login dan dapat mengelola data yang ada pada <b><?php echo $this->session->instansi_name ?></b>.
          <hr>
          <b><?php echo strtoupper('Harap menggunakan aplikasi ini sebijak mungkin karena setiap tindakan yang Anda lakukan akan tercatat oleh sistem.') ?></b>
        </p>
      </div>

      <?php $this->load->view('back/dashboard/record'); ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('back/template/footer'); ?>

</div>
<!-- ./wrapper -->

</body>

</html>