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
            <?php echo validation_errors() ?>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">TAMBAH DATA</h3>
                </div>
                <?php echo form_open($action) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nama*</label>
                                <?php echo form_input($name) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">NIK*</label>
                                <?php echo form_input($nik) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tempat Lahir*</label>
                                <?php echo form_input($birthplace) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tanggal Lahir*</label>
                                <?php echo form_input($birthdate) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Jenis Kelamin*</label>
                                <?php echo form_dropdown('', $gender_value, '', $gender) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Agama*</label>
                                <?php echo form_dropdown('', $get_all_combobox_agama, '', $agama) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Kebangsaan*</label>
                                <?php echo form_dropdown('', $kebangsaan_value, '', $kebangsaan) ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Alamat*</label>
                        <?php echo form_textarea($address) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Kepentingan*</label>
                                <?php echo form_input($kepentingan) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tempat Tujuan*</label>
                                <?php echo form_input($tempat_tujuan) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tanggal Berangkat*</label>
                                <?php echo form_input($tgl_berangkat) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Barang Yang Dibawa</label>
                                <?php echo form_input($barang_dibawa) ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Lama Pergi</label>
                        <?php echo form_input($lama_pergi) ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Pengikut</label>
                        <?php echo form_input($pengikut) ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Lain-lain (Opsional)</label>
                        <?php echo form_input($lain_lain) ?>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
                    <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
                </div>
                <!-- /.box-body -->
                <?php echo form_close() ?>
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
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <script src="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        $('#birthdate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            zIndexOffset: 9999,
            todayHighlight: true,
        });

        $('#tgl_berangkat').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            zIndexOffset: 9999,
            todayHighlight: true,
        });
    </script>

</div>
<!-- ./wrapper -->

</body>

</html>