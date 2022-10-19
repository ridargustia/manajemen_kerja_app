<?php $this->load->view('front/template/meta'); ?>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

        <div class="content-wrapper bg">
            <div class="container">
                <!-- Content Header (Page header) -->
                <section class="content-header"></section>

                <!-- Main content -->
                <section class="content">
                    <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('message') ?>"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <?php if (empty($sk_pindah->signature_image)) { ?>
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
                                                        <td class="text-left"><?php echo $sk_pindah->no_surat ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama</td>
                                                        <td style="width:10px">:</td>
                                                        <td class="text-left"><?php echo $sk_pindah->name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NIK</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_pindah->nik ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">Tempat Lahir</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_pindah->birthplace ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Lahir</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo date_indonesian_only($sk_pindah->birthdate) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">No HP/Telepon</td>
                                                        <td>:</td>
                                                        <td class="text-left">+<?php echo $sk_pindah->phone ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Kelamin</td>
                                                        <td>:</td>
                                                        <td class="text-left">
                                                            <?php
                                                            if ($sk_pindah->gender === '1') {
                                                                $gender = 'Laki-laki';
                                                            } elseif ($sk_pindah->gender === '2') {
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
                                                            if ($sk_pindah->kebangsaan === '1') {
                                                                $kebangsaan = 'Warga Negara Indonesia';
                                                            } elseif ($sk_pindah->kebangsaan === '2') {
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
                                                        <td class="text-left"><?php echo $sk_pindah->address ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Tujuan Pindah</strong></td>
                                                        <td></td>
                                                        <td class="text-left"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_pindah->alamat_pindah ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Desa</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_pindah->desa_pindah ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kecamatan</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_pindah->kecamatan_pindah ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kota</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_pindah->kota_pindah ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kabupaten</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_pindah->kabupaten_pindah ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Provinsi</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_pindah->provinsi_pindah ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Pindah</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo date_indonesian_only($sk_pindah->tgl_pindah) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alasan Pindah</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_pindah->alasan_pindah ?></td>
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
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('sk_pindah/preview_document/' . $sk_pindah->id_sk_pindah) ?>" class="btn btn-success" target="_blank"><i class="fa fa-download"></i> Download Surat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
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

        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script>

</body>

</html>