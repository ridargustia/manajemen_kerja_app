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
                                <?php echo form_input($name, $sk_pindah->name) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">NIK*</label>
                                <?php echo form_input($nik, $sk_pindah->nik) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">No HP/Telepon*</label>
                                <?php echo form_input($phone, $sk_pindah->phone) ?>
                                <span id="phone-availability-status"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tempat Lahir*</label>
                                <?php echo form_input($birthplace, $sk_pindah->birthplace) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tanggal Lahir*</label>
                                <?php echo form_input($birthdate, $sk_pindah->birthdate) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Jenis Kelamin*</label>
                                <?php echo form_dropdown('', $gender_value, $sk_pindah->gender, $gender) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Status Pernikahan*</label>
                                <?php echo form_dropdown('', $get_all_combobox_status, $sk_pindah->status_id, $status) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Agama*</label>
                                <?php echo form_dropdown('', $get_all_combobox_agama, $sk_pindah->agama_id, $agama) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Kebangsaan*</label>
                                <?php echo form_dropdown('', $kebangsaan_value, $sk_pindah->kebangsaan, $kebangsaan) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Pekerjaan*</label>
                                <?php echo form_dropdown('', $get_all_combobox_pekerjaan, $sk_pindah->pekerjaan_id, $pekerjaan) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Pendidikan Terakhir*</label>
                                <?php echo form_dropdown('', $get_all_combobox_pendidikan_akhir, $sk_pindah->pendidikan_akhir_id, $pendidikan_akhir) ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Alamat*</label>
                        <?php echo form_input($address, $sk_pindah->address) ?>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">TUJUAN PINDAH</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Alamat*</label>
                                <?php echo form_input($alamat_pindah, $sk_pindah->alamat_pindah) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Desa*</label>
                                <?php echo form_input($desa_pindah, $sk_pindah->desa_pindah) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Kecamatan*</label>
                                <?php echo form_input($kecamatan_pindah, $sk_pindah->kecamatan_pindah) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Kota*</label>
                                <?php echo form_input($kota_pindah, $sk_pindah->kota_pindah) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Kabupaten*</label>
                                <?php echo form_input($kabupaten_pindah, $sk_pindah->kabupaten_pindah) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Provinsi*</label>
                                <?php echo form_input($provinsi_pindah, $sk_pindah->provinsi_pindah) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tanggal Pindah*</label>
                                <?php echo form_input($tgl_pindah, $sk_pindah->tgl_pindah) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Alasan Pindah*</label>
                                <?php echo form_input($alasan_pindah, $sk_pindah->alasan_pindah) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="box box-primary">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="box-title">TAMBAH DATA PENGIKUT</h3>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-sm btn-success add-more pull-right" type="button">
                                <i class="glyphicon glyphicon-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <?php
                    if ($pengikut) {
                        foreach ($pengikut as $data) {
                    ?>
                            <div class="row add-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php echo form_input($nik_pengikut, $data->nik_pengikut) ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php echo form_input($pengikut_name, $data->pengikut_name) ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_input($keterangan, $data->keterangan) ?>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-sm btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <div class="row after-add-more"></div>
                </div>
                <?php echo form_input($id_sk_pindah, $sk_pindah->id_sk_pindah) ?>
                <div class="box-footer">
                    <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
                    <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
                </div>
                <!-- /.box-body -->
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

</div>
<!-- ./wrapper -->

</body>

</html>