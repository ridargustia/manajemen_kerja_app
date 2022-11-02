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
                                            <?php if (empty($surat_rekomendasi->signature_image)) { ?>
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
                                                        <td class="text-left"><?php echo $surat_rekomendasi->no_surat ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama</td>
                                                        <td style="width:10px">:</td>
                                                        <td class="text-left"><?php echo $surat_rekomendasi->name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NIK</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $surat_rekomendasi->nik ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">Tempat Lahir</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $surat_rekomendasi->birthplace ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Lahir</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $surat_rekomendasi->birthdate ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">No HP/Telepon</td>
                                                        <td>:</td>
                                                        <td class="text-left">+<?php echo $surat_rekomendasi->phone ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Kelamin</td>
                                                        <td>:</td>
                                                        <td class="text-left">
                                                            <?php
                                                            if ($surat_rekomendasi->gender === '1') {
                                                                $gender = 'Laki-laki';
                                                            } elseif ($surat_rekomendasi->gender === '2') {
                                                                $gender = 'Perempuan';
                                                            }
                                                            echo $gender;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $pekerjaan->pekerjaan_name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kewarganegaraan</td>
                                                        <td>:</td>
                                                        <td class="text-left">
                                                            <?php
                                                            if ($surat_rekomendasi->kebangsaan === '1') {
                                                                $kebangsaan = 'Warga Negara Indonesia';
                                                            } elseif ($surat_rekomendasi->kebangsaan === '2') {
                                                                $kebangsaan = 'Warga Negara Asing';
                                                            }
                                                            echo $kebangsaan;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Agama</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $agama->agama_name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pekerjaan</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $pekerjaan->pekerjaan_name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $surat_rekomendasi->address ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>TUJUAN PERGURUAN TINGGI</b></td>
                                                        <td style="width:10px"></td>
                                                        <td class="text-left"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Perguruan Tinggi</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $surat_rekomendasi->perguruan_tinggi ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat Perguruan Tinggi</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $surat_rekomendasi->address_pt ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('surat_rekomendasi/preview_document/' . $surat_rekomendasi->id_surat_rekomendasi) ?>" class="btn btn-success" target="_blank"><i class="fa fa-download"></i> Download Surat</a>
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