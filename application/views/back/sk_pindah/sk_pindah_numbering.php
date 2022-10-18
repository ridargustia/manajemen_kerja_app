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
                            <?php if (empty($data_sk_pindah->signature_image)) { ?>
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
                                            if ($data_sk_pindah->no_surat === NULL) {
                                                $attributes = array('class' => 'form-inline');
                                                echo form_open($action, $attributes);
                                            ?>
                                                <div class="form-group">
                                                    <?php echo form_input($no_surat) ?>
                                                </div>
                                                <?php echo form_input($id_sk_pindah, $data_sk_pindah->id_sk_pindah) ?>
                                                <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Kirim</button>
                                            <?php
                                                echo form_close();
                                            } else {
                                                echo $data_sk_pindah->no_surat;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td style="width:10px">:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->name ?></td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->nik ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:120px">Tempat Lahir</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->birthplace ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo date_indonesian_only($data_sk_pindah->birthdate) ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:120px">No HP/Telepon</td>
                                        <td>:</td>
                                        <td class="text-left">+<?php echo $data_sk_pindah->phone ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <td>:</td>
                                        <td class="text-left">
                                            <?php
                                            if ($data_sk_pindah->gender === '1') {
                                                $gender = 'Laki-laki';
                                            } elseif ($data_sk_pindah->gender === '2') {
                                                $gender = 'Perempuan';
                                            }
                                            echo $gender;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Pernikahan</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $status->status_name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Agama</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $agama->agama_name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kebangsaan</td>
                                        <td>:</td>
                                        <td class="text-left">
                                            <?php
                                            if ($data_sk_pindah->kebangsaan === '1') {
                                                $kebangsaan = 'Warga Negara Indonesia';
                                            } elseif ($data_sk_pindah->kebangsaan === '2') {
                                                $kebangsaan = 'Warga Negara Asing';
                                            }
                                            echo $kebangsaan;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $pekerjaan->pekerjaan_name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pendidikan Akhir</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $pendidikan_akhir->pendidikan_akhir_name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Saat Ini</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->address ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tujuan Pindah</strong></td>
                                        <td></td>
                                        <td class="text-left"></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->alamat_pindah ?></td>
                                    </tr>
                                    <tr>
                                        <td>Desa</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->desa_pindah ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->kecamatan_pindah ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kota</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->kota_pindah ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kabupaten</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->kabupaten_pindah ?></td>
                                    </tr>
                                    <tr>
                                        <td>Provinsi</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->provinsi_pindah ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pindah</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo date_indonesian_only($data_sk_pindah->tgl_pindah) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alasan Pindah</td>
                                        <td>:</td>
                                        <td class="text-left"><?php echo $data_sk_pindah->alasan_pindah ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pengikut</strong></td>
                                        <td></td>
                                        <td class="text-left"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 200px;">NIK</th>
                                        <th>Nama</th>
                                        <th style="width: 150px;">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($pengikut as $data) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $data->nik_pengikut ?></td>
                                            <td><?php echo $data->pengikut_name ?></td>
                                            <td><?php echo $data->keterangan ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if ($data_sk_pindah->no_surat != NULL) { ?>
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="<?php echo base_url('admin/sk_pindah/preview_document/' . $data_sk_pindah->id_sk_pindah) ?>" class="btn btn-primary" title="Preview Document" target="_blank"><i class="fa fa-file-text-o"></i> Pratinjau Dokumen</a>
                            <?php if (is_masteradmin() and $data_sk_pindah->signature_image === NULL) { ?>
                                <a href="<?php echo base_url('admin/sk_pindah/signature/' . $data_sk_pindah->id_sk_pindah) ?>" class="btn btn-success" title="ACC Dokumen"><i class="fa fa-pencil-square-o"></i> ACC Dokumen</a>
                            <?php } elseif (is_superadmin() and $data_sk_pindah->token != NULL) { ?>
                                <a href="https://web.whatsapp.com/send?phone=<?php echo $data_sk_pindah->phone ?>&text=Assalamu'alaikum,%0aKami dari Kantor Desa Saobi, menyampaikan informasi bahwa surat permohonan anda sudah selesai diproses, silahkan klik link berikut <?php echo base_url('sk_pindah/auth_download') ?> untuk download surat tersebut. Dengan memasukkan token berikut *<?php echo $data_sk_pindah->token ?>*, jangan memberikan token ini ke orang lain. Terima kasih" class="btn btn-success" title="Teruskan Pemohon" target="_blank"><i class="fa fa-share"></i> Teruskan Pemohon</a>
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