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
                <li><a href="<?php echo base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><?php echo $module ?></li>
                <li class="active"><?php echo $page_title ?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('message') ?>"></div>

            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">Nama</th>
                                    <th style="text-align: center">NIK</th>
                                    <th style="text-align: center">Status</th>
                                    <th style="text-align: center">Dibuat pada</th>
                                    <th class="hidden" style="text-align: center">Is Readed</th>
                                    <th class="hidden" style="text-align: center">Is Readed Master</th>
                                    <th style="text-align: center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($get_all as $data) {
                                    //TODO Status dokumen
                                    if ($data->signature_image === NULL) {
                                        $status = "<button class='btn btn-xs btn-danger'><i class='fa fa-close'></i> BELUM ACC</button> ";
                                    } else {
                                        $status = "<button class='btn btn-xs btn-success'><i class='fa fa-check'></i> SUDAH ACC</button> ";
                                    }

                                    //TODO Create Action Button
                                    $restore = '<a href="' . base_url('admin/sk_jalan/restore/' . $data->id_sk_jalan) . '" class="btn btn-primary" title="Restore Data"><i class="fa fa-refresh"></i></a>';
                                    $delete = '<a href="' . base_url('admin/sk_jalan/delete_permanent/' . $data->id_sk_jalan) . '" id="delete-button-permanent" class="btn btn-danger" title="Hapus Permanen"><i class="fa fa-trash"></i></a>';
                                ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $no++ ?></td>
                                        <td style="text-align: center"><?php echo $data->name ?></td>
                                        <td style="text-align: center"><?php echo $data->nik ?></td>
                                        <td style="text-align: center"><?php echo $status ?></td>
                                        <td style="text-align: center"><?php echo datetime_indo3($data->created_at) ?></td>
                                        <td class="hidden" style="text-align: center"><?php echo $data->is_readed ?></td>
                                        <td class="hidden" style="text-align: center"><?php echo $data->is_readed_masteradmin ?></td>
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
            $('#dataTable').DataTable({
                "rowCallback": function(row, data, index) {
                    if (data[6] == "0") {
                        $('td', row).css('background-color', '#9FE2BF');
                    }

                    if (data[5] == "0") {
                        $('td', row).css('background-color', '#9FE2BF');
                    }
                }
            });
        });
    </script>

</div>
<!-- ./wrapper -->

</body>

</html>