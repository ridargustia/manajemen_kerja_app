<?php $this->load->view('front/template/meta'); ?>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

        <div class="content-wrapper bg">
            <div class="container">
                <!-- Content Header (Page header) -->
                <section class="content-header">

                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('message') ?>"></div>
                    <?php echo form_open_multipart($action, array('id' => 'add_form')) ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Form Pembuatan Surat Keterangan Pindah</h3>
                                </div>
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Jenis Kelamin*</label>
                                                <?php echo form_dropdown('', $gender_value, '', $gender) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Status Pernikahan*</label>
                                                <?php echo form_dropdown('', $get_all_combobox_status, '', $status) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Agama*</label>
                                                <?php echo form_dropdown('', $get_all_combobox_agama, '', $agama) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Kebangsaan*</label>
                                                <?php echo form_dropdown('', $kebangsaan_value, '', $kebangsaan) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Pekerjaan*</label>
                                                <?php echo form_dropdown('', $get_all_combobox_pekerjaan, '', $pekerjaan) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Pendidikan Terakhir*</label>
                                                <?php echo form_dropdown('', $get_all_combobox_pendidikan_akhir, '', $pendidikan_akhir) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Alamat Lengkap Saat Ini*</label>
                                        <?php echo form_textarea($address) ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Alamat Pindah*</label>
                                                <?php echo form_input($alamat_pindah) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Desa (Tempat Pindah)*</label>
                                                <?php echo form_input($desa_pindah) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Kecamatan (Tempat Pindah)*</label>
                                                <?php echo form_input($kecamatan_pindah) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Kota (Tempat Pindah)*</label>
                                                <?php echo form_input($kota_pindah) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Kabupaten (Tempat Pindah)*</label>
                                                <?php echo form_input($kabupaten_pindah) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Provinsi (Tempat Pindah)*</label>
                                                <?php echo form_input($provinsi_pindah) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Tanggal Pindah*</label>
                                                <?php echo form_input($tgl_pindah) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Alasan Pindah*</label>
                                                <?php echo form_input($alasan_pindah) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Data Pengikut</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-success add-more pull-right" type="button">
                                                <i class="glyphicon glyphicon-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row after-add-more">
                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <?php //echo form_input($nik_pengikut)
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php //echo form_input($pengikut_name)
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <?php //echo form_input($keterangan)
                                                ?>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
                                        <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                    <!-- /.box -->

                    <div class="copy hide">
                        <div class="row add-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_input($nik_pengikut) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_input($pengikut_name) ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_input($keterangan) ?>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-sm btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                            </div>
                        </div>
                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->

        <?php $this->load->view('front/template/footer'); ?>

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

                $(".add-more").click(function() {
                    var html = $(".copy").html();
                    $(".after-add-more").after(html);
                });

                //TODO Saat tombol remove dklik control group akan dihapus
                $("body").on("click", ".remove", function() {
                    $(this).parents(".add-row").remove();
                });
            });

            $('#birthdate').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                zIndexOffset: 9999,
                todayHighlight: true,
            });

            $('#tgl_pindah').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                zIndexOffset: 9999,
                todayHighlight: true,
            });
        </script>

</body>

</html>