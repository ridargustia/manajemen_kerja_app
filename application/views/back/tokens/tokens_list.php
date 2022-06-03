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
      <?php if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
      } ?>

      <div class="box box-primary">
        <div class="box-header">
          <button class="btn btn-success" onclick="add_tokens()"><i class="fa fa-plus"></i> Tambah</button>
          <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Reload</button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center">No.</th>
                  <th style="text-align: center">Email</th>
                  <th style="text-align: center">Instansi</th>
                  <th style="text-align: center">Nama Folder</th>
                  <th style="text-align: center">Aksi</th>
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
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
      //datatables
      table = $('#dataTable').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo base_url('admin/token/ajax_list') ?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [{
          "targets": [-1], //last column
          "orderable": false, //set not orderable
        }, ],
      });
    });

    function add_token() {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }

    function reload_table() {
      table.ajax.reload(null, false); //reload datatable ajax
    }

    function delete_token(id) {
      if (confirm('Are you sure delete this data?')) {
        // ajax delete data to database
        $.ajax({
          url: "<?php echo base_url('admin/token/ajax_delete') ?>/" + id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            //if success reload ajax table
            $('#modal_form').modal('hide');
            reload_table();
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error deleting data');
          }
        });

      }
    }

    function add_tokens() {
      $.ajax({
        url: "<?php echo base_url('admin/token/postAuthUrlRequest'); ?>",
        type: "POST",
        dataType: "JSON",
        success: function(response) {
          window.open(response.auth_url);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error get data from ajax');
        }
      });
    }
  </script>

</div>
<!-- ./wrapper -->

</body>

</html>