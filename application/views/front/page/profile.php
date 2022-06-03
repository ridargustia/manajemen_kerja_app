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
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $company_data->company_name ?></h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div align="center">
              <img src="<?php echo base_url('assets/images/company/'.$company_data->company_photo) ?>" width="200px" class="img-circle">
            </div>
            <br>
            <p><?php echo $company_data->company_desc ?></p>

            <label>Alamat</label>
            <p><?php echo $company_data->company_address ?></p>

            <label>Kontak</label>
            <p>
              No. Telpon: <?php echo $company_data->company_phone ?>
              <br>
              Email: <?php echo $company_data->company_email ?> / <?php echo $company_data->company_gmail ?>
              <br>
              <?php if($company_data->company_fax != NULL){ ?>
                Fax: <?php echo $company_data->company_fax ?>
              <?php } ?>
            </p>

            <label>Peta Lokasi</label>
            <p><?php echo $company_data->company_maps ?></p>
          </div>
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
