<?php $this->load->view('front/template/meta'); ?>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
  <div class="wrapper">

  <?php $this->load->view('front/template/navbar'); ?>

  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>Selamat Datang, <?php echo $get_instansi->instansi_name ?>!</h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>

        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">DAFTAR ARSIP</h3>
            <div align="center">
              <img src="<?php echo base_url('assets/images/instansi/'.$this->session->instansi_img_thumb) ?>" alt="<?php echo $this->session->instansi_name ?>" class="img-circle" width="100px">
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="text-align: center">No. Urut</th>
                    <th style="text-align: center">No. Arsip</th>
                    <th style="text-align: center">Nama Arsip</th>
                    <th style="text-align: center">Rak</th>
                    <th style="text-align: center">Baris</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">Box</th>
                    <th style="text-align: center">Map</th>
                    <th style="text-align: center">Divisi</th>
                    <th style="text-align: center">Status Peminjaman</th>
                    <th style="text-align: center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach($get_all as $data){
                    // status peminjaman
                    if($data->is_available == '0'){ $is_available = "<button class='btn btn-xs btn-danger'><i class='fa fa-remove'></i> DIPINJAM</button> ";}
                    else{$is_available = "<button class='btn btn-xs btn-success'><i class='fa fa-check'></i> TERSEDIA</button>";}

                    $detail = '<a href="'.base_url('arsip/detail/'.$data->id_arsip).'" class="btn btn-sm bg-purple"><i class="fa fa-search-plus"></i></a>';
                  ?>
                    <tr>
                      <td style="text-align: center"><?php echo $no++ ?></td>
                      <td style="text-align: center"><?php echo $data->no_arsip ?></td>
                      <td style="text-align: left"><?php echo $data->arsip_name ?></td>
                      <td style="text-align: center"><?php echo $data->rak_name ?></td>
                      <td style="text-align: center"><?php echo $data->baris_name ?></td>
                      <td style="text-align: center"><?php echo $data->lokasi_arsip ?></td>
                      <td style="text-align: center"><?php echo $data->box_name ?></td>
                      <td style="text-align: center"><?php echo $data->map_name ?></td>
                      <td style="text-align: center"><?php echo $data->divisi_name ?></td>
                      <td style="text-align: center"><?php echo $is_available ?></td>
                      <td style="text-align: center"><?php echo $detail ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th style="text-align: center">No. Urut</th>
                    <th style="text-align: center">No. Arsip</th>
                    <th style="text-align: center">Nama Arsip</th>
                    <th style="text-align: center">Rak</th>
                    <th style="text-align: center">Baris</th>
                    <th style="text-align: center">Lokasi</th>
                    <th style="text-align: center">Box</th>
                    <th style="text-align: center">Map</th>
                    <th style="text-align: center">Divisi</th>
                    <th style="text-align: center">Status Peminjaman</th>
                    <th style="text-align: center">Aksi</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('front/template/footer'); ?>

  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>datatables-bs/css/dataTables.bootstrap.min.css">
  <script src="<?php echo base_url('assets/plugins/') ?>datatables/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url('assets/plugins/') ?>datatables-bs/js/dataTables.bootstrap.min.js"></script>
  <script>
  $(document).ready( function () {
    $('#dataTable').DataTable();
  } );
  </script>

</body>
</html>
