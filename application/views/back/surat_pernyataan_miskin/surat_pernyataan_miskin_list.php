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
                                    <th style="text-align: center">NIK</th>
                                    <th style="text-align: center">Dibuat pada</th>
                                    <th class="hidden" style="text-align: center">Is Readed</th>
                                    <th style="text-align: center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($get_all as $data) {
                                    //TODO Create Action Button
                                    $detail = '<a href="' . base_url('admin/surat_pernyataan_miskin/update/' . $data->id_surat_pernyataan_miskin) . '" class="btn btn-primary" title="Detail Data"><i class="fa fa-eye"></i></a>';
                                    $delete = '<a href="' . base_url('admin/surat_pernyataan_miskin/delete/' . $data->id_surat_pernyataan_miskin) . '" onClick="return confirm(\'Are you sure?\');" class="btn btn-danger" title="Hapus Data"><i class="fa fa-trash"></i></a>';
                                ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $no++ ?></td>
                                        <td style="text-align: center"><?php echo $data->name ?></td>
                                        <td style="text-align: center"><?php echo $data->nik ?></td>
                                        <td style="text-align: center"><?php echo datetime_indo3($data->created_at) ?></td>
                                        <td class="hidden" style="text-align: center"><?php echo $data->is_readed ?></td>
                                        <td style="text-align: center"><?php echo $detail ?> <?php echo $delete ?></td>
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
                    if (data[4] == "0") {
                        $('td', row).css('background-color', '#DCDCDC');
                    }
                }
            });
        });
    </script>

</div>
<!-- ./wrapper -->

</body>

</html>