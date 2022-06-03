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
        <li><a href="<?php echo base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
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
        <div class="box-header"><a href="<?php echo $add_action ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo $btn_add ?></a> </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center">No. Urut</th>
                  <th style="text-align: center">No. Arsip</th>
                  <th style="text-align: center">Nama Arsip</th>
                                   
                  <th style="text-align: center">Status Peminjaman</th>
                  <th style="text-align: center">Status Akses</th>
                  <th style="text-align: center">Status Retensi</th>                  
                  <th style="text-align: center">Keterangan</th>
                  
                  <th style="text-align: center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($get_all as $data) {
                  // status akses
                  if ($data->status_file == '0') {
                    $status_file = "<button class='btn btn-xs bg-maroon'><i class='fa fa-remove'></i> PRIVAT</button> ";
                  } elseif ($data->status_file == '1') {
                    $status_file = "<button class='btn btn-xs bg-navy'><i class='fa fa-check'></i> Level Instansi</button>";
                  } elseif ($data->status_file == '2') {
                    $status_file = "<button class='btn btn-xs bg-navy'><i class='fa fa-check'></i> Level Cabang</button>";
                  } elseif ($data->status_file == '3') {
                    $status_file = "<button class='btn btn-xs bg-navy'><i class='fa fa-check'></i> Level Divisi</button>";
                  }

                  // status peminjaman
                  if ($data->is_available == '0') {
                    $is_available = "<button class='btn btn-xs btn-danger'><i class='fa fa-remove'></i> DIPINJAM</button> ";
                  } elseif ($data->is_available == '1') {
                    $is_available = "<button class='btn btn-xs btn-success'><i class='fa fa-check'></i> TERSEDIA</button>";
                  }

                  // status retensi
                  if ($data->status_retensi == '0') {
                    $status_retensi = "<button class='btn btn-xs btn-primary'><i class='fa fa-remove'></i> INACTIVE</button> ";
                  } elseif ($data->status_retensi == '1') {
                    $status_retensi = "<button class='btn btn-xs btn-info'><i class='fa fa-check'></i> ACTIVE</button>";
                  }

                  // keterangan
                  if ($data->keterangan == '0') {
                    $keterangan = "Permanen";
                  } elseif ($data->keterangan == '1') {
                    $keterangan = "Musnah";
                  } else{
                    $keterangan = "-";
                  }

                  // jika punya dia sendiri (admin) maka tampilkan semua tombol
                  if($data->user_id == $this->session->id_users){
                    $edit   = '<a href="' . base_url('admin/arsip/update/' . $data->id_arsip) . '" class="btn btn-sm btn-warning" title="Ubah Arsip"><i class="fa fa-pencil"></i></a>';
                    $delete = '<a href="' . base_url('admin/arsip/delete/' . $data->id_arsip) . '" onClick="return confirm(\'Are you sure?\');" class="btn btn-sm btn-danger" title="Hapus Arsip"><i class="fa fa-trash"></i></a>';                    
                    $detail = '<a href="' . base_url('admin/arsip/detail/' . $data->id_arsip) . '" class="btn btn-sm bg-purple" title="Tampilkan Arsip"><i class="fa fa-search-plus"></i></a>';
                  }
                  else{
                    $edit = '';
                    $delete = '';
                    $detail = '<a href="' . base_url('admin/arsip/detail/' . $data->id_arsip) . '" class="btn btn-sm bg-purple" title="Tampilkan Arsip"><i class="fa fa-search-plus"></i></a>';
                  }
                ?>
                  <tr>
                    <td style="text-align: center"><?php echo $no++ ?></td>
                    <td style="text-align: center"><?php echo $data->no_arsip ?></td>
                    <td style="text-align: left"><?php echo $data->arsip_name ?></td>
                                       
                    <td style="text-align: center"><?php echo $is_available ?></td>
                    <td style="text-align: center"><?php echo $status_file ?></td>
                    <td style="text-align: center"><?php echo $status_retensi ?></td>
                    <td style="text-align: center"><?php echo $keterangan ?></td>
                    
                    <td style="text-align: center"><?php echo $detail . ' ';
                                                    echo $edit . ' ';
                                                    echo $delete; ?></td>
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