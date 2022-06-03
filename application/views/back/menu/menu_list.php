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
      <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>

      <div class="box box-primary">
        <div class="box-header"><a href="<?php echo $add_action ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo $btn_add ?></a> </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="datatable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center">No</th>
                  <th style="text-align: center">Menu Name</th>
                  <th style="text-align: center">Controller</th>
                  <th style="text-align: center">Function</th>
                  <th style="text-align: center">Icon</th>
                  <th style="text-align: center">Order No</th>
                  <th style="text-align: center">Status</th>
                  <th style="text-align: center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach($get_all as $data){
                  if($data->is_active == '1'){ $is_active = "<a href='".base_url('admin/menu/deactivate/'.$data->id_menu)."'><button class='btn btn-xs btn-success'><i class='fa fa-check'></i> ACTIVE</button></a> ";}
                  else{ $is_active = "<a href='".base_url('admin/menu/activate/'.$data->id_menu)."'><button class='btn btn-xs btn-danger'><i class='fa fa-remove'></i> INACTIVE</button></a>";}
                  // action
                  $edit = '<a href="'.base_url('admin/menu/update/'.$data->id_menu).'" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>';
                  $delete = '<a href="'.base_url('admin/menu/delete/'.$data->id_menu).'" onClick="return confirm(\'Are you sure?\');" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                ?>
                  <tr>
                    <td style="text-align: center"><?php echo $no++ ?></td>
                    <td style="text-align: left"><?php echo $data->menu_name ?></td>
                    <td style="text-align: center"><?php echo $data->menu_controller ?></td>
                    <td style="text-align: center"><?php echo $data->menu_function ?></td>
                    <td style="text-align: center"><i class="fa fa-2x <?php echo $data->menu_icon ?>"></i> </td>
                    <td style="text-align: center"><?php echo $data->order_no ?></td>
                    <td style="text-align: center"><?php echo $is_active ?></td>
                    <td style="text-align: center"><?php echo $edit ?> <?php echo $delete ?></td>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th style="text-align: center">No</th>
                  <th style="text-align: center">Menu Name</th>
                  <th style="text-align: center">Controller</th>
                  <th style="text-align: center">Function</th>
                  <th style="text-align: center">Icon</th>
                  <th style="text-align: center">Order No</th>
                  <th style="text-align: center">Status</th>
                  <th style="text-align: center">Action</th>
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
  <!-- /.content-wrapper -->

  <?php $this->load->view('back/template/footer'); ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>datatables-bs/css/dataTables.bootstrap.min.css">
  <script src="<?php echo base_url('assets/plugins/') ?>datatables/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url('assets/plugins/') ?>datatables-bs/js/dataTables.bootstrap.min.js"></script>
  <script>
  $(document).ready( function () {
    $('#datatable').DataTable();
  } );
  </script>

</div>
<!-- ./wrapper -->

</body>
</html>
