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
        <div class="box-header">
          <a href="<?php echo $add_action ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo $btn_add ?></a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center">No</th>
                  <th style="text-align: center">Nama</th>
                  <th style="text-align: center">Username</th>
                  <th style="text-align: center">Email</th>
                  <th style="text-align: center">Divisi</th>
                  <?php if (is_grandadmin()) { ?>
                    <th style="text-align: center">Instansi</th>
                  <?php } ?>
                  <th style="text-align: center">Jabatan</th>
                  <th style="text-align: center">Status</th>
                  <th style="text-align: center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($get_all as $user) {
                  //TODO status active
                  if ($user->is_active == '1') {
                    $is_active = '<a href="' . base_url('admin/auth/deactivate/' . $user->id_users) . '" id="deactive-button" class="btn btn-xs btn-success" title="Nonaktifkan User">ACTIVE</a>';
                  } else {
                    $is_active = '<a href="' . base_url('admin/auth/activate/' . $user->id_users) . '" class="btn btn-xs btn-danger" title="Aktifkan User">INACTIVE</a>';
                  }

                  //TODO action
                  $edit = '<a href="' . base_url('admin/auth/update/' . $user->id_users) . '" class="btn btn-warning" title="Ubah User"><i class="fa fa-pencil"></i></a>';
                  $delete = '<a href="' . base_url('admin/auth/delete/' . $user->id_users) . '" id="delete-button" class="btn btn-danger" title="Hapus User"><i class="fa fa-trash"></i></a>';
                ?>
                  <tr>
                    <td style="text-align: center"><?php echo $no++ ?></td>
                    <td style="text-align: left"><?php echo $user->name ?></td>
                    <td style="text-align: center"><?php echo $user->username ?></td>
                    <td style="text-align: center"><?php echo $user->email ?></td>
                    <td style="text-align: center"><?php echo $user->divisi_name ?></td>
                    <?php if (is_grandadmin()) { ?>
                      <td style="text-align: center"><?php echo $user->instansi_name ?></td>
                    <?php } ?>
                    <td style="text-align: center"><?php echo $user->jabatan_name ?></td>
                    <td style="text-align: center"><?php echo $is_active ?></td>
                    <td style="text-align: center"><?php echo $edit ?> <?php echo $delete ?></td>
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