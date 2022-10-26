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
            <?php echo form_open($action) ?>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">EDIT DATA</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Nama*</label>
                                <?php echo form_input($name, $surat_pengantar_nikah->name) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">NIK*</label>
                                <?php echo form_input($nik, $surat_pengantar_nikah->nik) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">No HP/Telepon*</label>
                                <?php echo form_input($phone, $surat_pengantar_nikah->phone) ?>
                                <span id="phone-availability-status"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Bin/Binti*</label>
                                <?php echo form_input($bin_binti, $surat_pengantar_nikah->bin_binti) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Jenis Kelamin*</label>
                                <?php echo form_dropdown('', $gender_value, $surat_pengantar_nikah->gender, $gender) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tempat Lahir*</label>
                                <?php echo form_input($birthplace, $surat_pengantar_nikah->birthplace) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tanggal Lahir*</label>
                                <?php echo form_input($birthdate, $surat_pengantar_nikah->birthdate) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Kebangsaan*</label>
                                <?php echo form_dropdown('', $kebangsaan_value, $surat_pengantar_nikah->kebangsaan, $kebangsaan) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Agama*</label>
                                <?php echo form_dropdown('', $get_all_combobox_agama, $surat_pengantar_nikah->agama_id, $agama) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Status Pernikahan*</label>
                                <?php echo form_dropdown('', $get_all_combobox_status, $surat_pengantar_nikah->status_id, $status) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Pekerjaan*</label>
                                <?php echo form_dropdown('', $get_all_combobox_pekerjaan, $surat_pengantar_nikah->pekerjaan_id, $pekerjaan) ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Alamat *</label>
                        <?php echo form_input($address, $surat_pengantar_nikah->address) ?>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">DATA PELAKSANAAN PERKAWINAN/PERNIKAHAN</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Dusun *</label>
                                <?php echo form_input($dusun_tujuan, $surat_pengantar_nikah->dusun) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">RW *</label>
                                <?php echo form_input($rw_tujuan, $surat_pengantar_nikah->rw) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">RT *</label>
                                <?php echo form_input($rt_tujuan, $surat_pengantar_nikah->rt) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Desa *</label>
                                <?php echo form_input($desa_tujuan, $surat_pengantar_nikah->desa) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Kecamatan *</label>
                                <?php echo form_input($kecamatan_tujuan, $surat_pengantar_nikah->kecamatan) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Kabupaten *</label>
                                <?php echo form_input($kabupaten_tujuan, $surat_pengantar_nikah->kabupaten) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Provinsi *</label>
                                <?php echo form_input($provinsi_tujuan, $surat_pengantar_nikah->provinsi) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_input($id_surat_pengantar_nikah, $surat_pengantar_nikah->id_surat_pengantar_nikah) ?>
                <div class="box-footer">
                    <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
                    <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
                </div>
            </div>
            <?php echo form_close() ?>
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
    </script>

</div>
<!-- ./wrapper -->

</body>

</html>