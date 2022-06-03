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
      <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <button class="btn btn-info" onclick="reload_table()"><i class="fa fa-refresh"></i> Refresh </button>
          <hr>
          <div class="table-responsive">
            <table id="datatable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center">Time</th>
                  <th style="text-align: center">Content</th>
                  <th style="text-align: center">User</th>
                  <th style="text-align: center">IP Address</th>
                  <th style="text-align: center">User Agent</th>
                </tr>
              </thead>
              <tbody>
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
  <script type="text/javascript">
    $(document).ready(function() {
      table = $('#datatable').DataTable({
        processing: true,
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        bPaginate: true,
        bLengthChange: true,
        bFilter: true,
        bSort: true,
        bInfo: true,
        aaSorting: [
          [0, 'desc']
        ],
        lengthMenu: [
          [10, 25, 50, 100, 500, 1000, -1],
          [10, 25, 50, 100, 500, 1000, "Semua"]
        ],
        ajax: {
          "url": "<?php echo site_url('admin/log/ajax_list') ?>",
          "type": "POST"
        },
        dom: 'lBfrtip',
      });
    });

    function reload_table() {
      table.ajax.reload(null, false); //reload datatable ajax
    }
  </script>

</div>
<!-- ./wrapper -->

</body>

</html>