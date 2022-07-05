<?php $this->load->view('back/template/meta'); ?>
<div class="wrapper">

  <?php $this->load->view('back/template/navbar'); ?>
  <?php $this->load->view('back/template/sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $page_title ?></h1>
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
                  <th style="text-align: center">Nama</th>
                  <th style="text-align: center">Jenis Kelamin</th>
                  <th style="text-align: center">Username</th>
                  <th style="text-align: center">Email</th>
                  <th style="text-align: center">Jabatan</th>
                  <th style="text-align: center">Status</th>
                  <th style="text-align: center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($get_all_deleted as $user) {
                  //TODO Get Gender
                  if ($user->gender == '1') {
                    $gender = 'Laki-laki';
                  } elseif ($user->gender == '2') {
                    $gender = 'Perempuan';
                  }

                  //TODO Get status active
                  if ($user->is_active == '1') {
                    $is_active = '<a href="' . base_url('admin/auth/deactivate/' . $user->id_users) . '" id="deactive-button" class="btn btn-xs btn-success" title="Nonaktifkan User">ACTIVE</a>';
                  } else {
                    $is_active = '<a href="' . base_url('admin/auth/activate/' . $user->id_users) . '" class="btn btn-xs btn-danger" title="Aktifkan User">INACTIVE</a>';
                  }

                  //TODO Action Button
                  if (is_grandadmin() || is_masteradmin()) {
                    $restore = '<a href="' . base_url('admin/auth/restore/' . $user->id_users) . '" class="btn btn-info" title="Restore User"><i class="fa fa-refresh"></i></a>';
                  } else {
                    $restore = "";
                  }

                  $delete = '<a href="' . base_url('admin/auth/delete_permanent/' . $user->id_users) . '" id="delete-button-permanent" class="btn btn-danger" title="Hapus Permanen"><i class="fa fa-remove"></i></a>';
                ?>
                  <tr>
                    <td style="text-align: center"><?php echo $no++ ?></td>
                    <td style="text-align: left"><?php echo $user->name ?></td>
                    <td style="text-align: center"><?php echo $gender ?></td>
                    <td style="text-align: center"><?php echo $user->username ?></td>
                    <td style="text-align: center"><?php echo $user->email ?></td>
                    <td style="text-align: center"><?php echo $user->jabatan_name ?></td>
                    <td style="text-align: center"><?php echo $is_active ?></td>
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