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
                    <div class="row">
                        <div class="col-md-3">
                            <?php if (empty($data_sk_nikah->signature_image)) { ?>
                                <img src="<?php echo base_url('assets/images/file_icon.png') ?>" width="100%" style="opacity: 0.5;">
                            <?php } else { ?>
                                <img src="<?php echo base_url('assets/images/file_icon_approved.png') ?>" width="100%">
                            <?php } ?>
                        </div>
                        <div class="col-md-9">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>No Surat</td>
                                        <td style="width:10px">:</td>
                                        <td class="text-left">
                                            <?php
                                            if ($data_sk_nikah->no_surat === NULL) {
                                                $attributes = array('class' => 'form-inline');
                                                echo form_open($action, $attributes);
                                            ?>
                                                <div class="form-group">
                                                    <?php echo form_input($no_surat) ?>
                                                </div>
                                                <?php echo form_input($id_sk_nikah, $data_sk_nikah->id_sk_nikah) ?>
                                                <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Kirim</button>
                                            <?php
                                                echo form_close();
                                            } else {
                                                echo $data_sk_nikah->no_surat;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>DATA SUAMI</b></td>
                                        <td style="width:10px"></td>
                                        <td class="text-left"></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Suami</td>
                                        <td style="width:10px">:</td>
                                        <td class="text-left"><?php echo $data_sk_nikah->suami_name ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:120px">Tempat Lahir Suami</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_nikah->suami_birthplace ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir Suami</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_nikah->suami_birthdate ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:120px">No HP/Telepon</td>
                                        <td>:</td>
                                        <td class="text-left">+<?php echo $data_sk_nikah->phone ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin Suami</td>
                                        <td>:</td>
                                        <td class="text-left">
                                            <?php
                                            if ($data_sk_nikah->suami_gender === '1') {
                                                echo 'Laki-laki';
                                            } elseif ($data_sk_nikah->suami_gender === '2') {
                                                echo 'Perempuan';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Pernikahan Suami</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $suami_status->status_name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Agama Suami</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $suami_agama->agama_name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kebangsaan Suami</td>
                                        <td>:</td>
                                        <td class="text-left">
                                            <?php
                                            if ($data_sk_nikah->kebangsaan_suami === '1') {
                                                echo 'Warga Negara Indonesia';
                                            } elseif ($data_sk_nikah->kebangsaan_suami === '2') {
                                                echo 'Warga Negara Asing';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>DATA ISTRI</b></td>
                                        <td style="width:10px"></td>
                                        <td class="text-left"></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Istri</td>
                                        <td style="width:10px">:</td>
                                        <td class="text-left"><?php echo $data_sk_nikah->istri_name ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:120px">Tempat Lahir Istri</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_nikah->istri_birthplace ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir Istri</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_nikah->istri_birthdate ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin Istri</td>
                                        <td>:</td>
                                        <td class="text-left">
                                            <?php
                                            if ($data_sk_nikah->istri_gender === '1') {
                                                echo 'Laki-laki';
                                            } elseif ($data_sk_nikah->istri_gender === '2') {
                                                echo 'Perempuan';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Pernikahan Istri</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $istri_status->status_name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Agama Istri</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $istri_agama->agama_name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kebangsaan Istri</td>
                                        <td>:</td>
                                        <td class="text-left">
                                            <?php
                                            if ($data_sk_nikah->kebangsaan_istri === '1') {
                                                echo 'Warga Negara Indonesia';
                                            } elseif ($data_sk_nikah->kebangsaan_istri === '2') {
                                                echo 'Warga Negara Asing';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if ($data_sk_nikah->no_surat != NULL) { ?>
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="<?php echo base_url('admin/sk_nikah/preview_document/' . $data_sk_nikah->id_sk_nikah) ?>" class="btn btn-primary" title="Preview Document" target="_blank"><i class="fa fa-file-text-o"></i> Pratinjau Dokumen</a>
                            <?php if (is_masteradmin() and $data_sk_nikah->signature_image === NULL) { ?>
                                <a href="<?php echo base_url('admin/sk_nikah/signature/' . $data_sk_nikah->id_sk_nikah) ?>" class="btn btn-success" title="ACC Dokumen"><i class="fa fa-pencil-square-o"></i> ACC Dokumen</a>
                            <?php } elseif (is_superadmin() and $data_sk_nikah->token != NULL) { ?>
                                <a href="https://web.whatsapp.com/send?phone=<?php echo $data_sk_nikah->phone ?>&text=Assalamu'alaikum,%0aKami dari Kantor Desa Saobi, menyampaikan informasi bahwa surat permohonan anda sudah selesai diproses, silahkan klik link berikut <?php echo base_url('sk_nikah/auth_download') ?> untuk download surat tersebut. Dengan memasukkan token berikut *<?php echo $data_sk_nikah->token ?>*, jangan memberikan token ini ke orang lain. Terima kasih" class="btn btn-success" title="Teruskan Pemohon" target="_blank"><i class="fa fa-share"></i> Teruskan Pemohon</a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
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

</div>
<!-- ./wrapper -->

</body>

</html>