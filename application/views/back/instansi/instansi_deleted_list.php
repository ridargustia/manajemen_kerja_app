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
      <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('message') ?>"></div>

      <div class="box box-primary">
        <!-- /.box-body -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center">No</th>
                  <th style="text-align: center">Nama Instansi</th>
                  <th style="text-align: center">Alamat</th>
                  <th style="text-align: center">No. Telpon / HP</th>
                  <th style="text-align: center">Aktif Sampai</th>
                  <th style="text-align: center">Status</th>
                  <th style="text-align: center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($get_all_deleted as $data) {
                  //TODO status aktif instansi
                  if ($data->is_active == '1') {
                    $status_active = "<a class='btn btn-success btn-xs'>ACTIVE</a>";
                  }
                  if ($data->is_active == '0') {
                    $status_active = "<a class='btn btn-danger btn-xs'>INACTIVE</a>";
                  }

                  //TODO Action Button
                  $restore = '<a href="' . base_url('admin/instansi/restore/' . $data->id_instansi) . '" class="btn btn-sm btn-warning" title="Restore Instansi"><i class="fa fa-refresh"></i></a>';
                  $delete = '<a href="' . base_url('admin/instansi/delete_permanent/' . $data->id_instansi) . '" id="delete-button-permanent" class="btn btn-sm btn-danger" title="Hapus Permanen"><i class="fa fa-remove"></i></a>';
                ?>
                  <tr>
                    <td style="text-align: center"><?php echo $no++ ?></td>
                    <td style="text-align: left"><?php echo $data->instansi_name ?></td>
                    <td style="text-align: left"><?php echo $data->instansi_address ?></td>
                    <td style="text-align: left"><?php echo $data->instansi_phone ?></td>
                    <td style="text-align: left"><?php echo date_only($data->active_date) ?></td>
                    <td style="text-align: left"><?php echo $status_active ?></td>
                    <td style="text-align: center"><?php echo $restore ?> <?php echo $delete ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('back/template/footer'); ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>datatables-bs/css/dataTables.bootstrap.min.css">
  <script src="<?php echo base_url('assets/plugins/') ?>datatables/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url('assets/plugins/') ?>datatables-bs/js/dataTables.bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable();
    });
  </script>

</div>
<!-- ./wrapper -->

</body>

</html>