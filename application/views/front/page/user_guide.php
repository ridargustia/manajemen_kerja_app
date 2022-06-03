<?php $this->load->view('front/template/meta'); ?>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
  <div class="wrapper">

  <?php $this->load->view('front/template/navbar'); ?>

  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>Company Profile</h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#"> Profil</a></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="col">
          <div align="center">
            <h3><b>Panduan Penggunaan Aplikasi</b></h3>
            <div class="callout callout-danger">
              <h4>Panduan Penggunaan</h4>
              <ul>
                <li>Silahkan pilih salah 1 divisi yang tersedia dibawah ini</li>
                <li>Cari arsip berdasarkan keywords, misal: arsip keuangan</li>
                <li>Silahkan tekan tombol enter atau cari arsip untuk mulai mencari arsip</li>
              </ul>
            </div>
            <!-- /.box -->
          </div>

          <br>
          <?php echo $company_data->company_desc ?>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('front/template/footer'); ?>

</body>
</html>
