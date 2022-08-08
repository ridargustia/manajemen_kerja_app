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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <?php if (empty($sk_jalan->signature_image)) { ?>
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
                                                        <td class="text-left"><?php echo $sk_jalan->no_surat ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama</td>
                                                        <td style="width:10px">:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NIK</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->nik ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">Tempat Lahir</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->birthplace ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Lahir</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->birthdate ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">No HP/Telepon</td>
                                                        <td>:</td>
                                                        <td class="text-left">+<?php echo $sk_jalan->phone ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Kelamin</td>
                                                        <td>:</td>
                                                        <td class="text-left">
                                                            <?php
                                                            if ($sk_jalan->gender === '1') {
                                                                $gender = 'Laki-laki';
                                                            } elseif ($sk_jalan->gender === '2') {
                                                                $gender = 'Perempuan';
                                                            }
                                                            echo $gender;
                                                            ?>
                                                        </td>
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
                                                            if ($sk_jalan->kebangsaan === '1') {
                                                                $kebangsaan = 'Warga Negara Indonesia';
                                                            } elseif ($sk_jalan->kebangsaan === '2') {
                                                                $kebangsaan = 'Warga Negara Asing';
                                                            }
                                                            echo $kebangsaan
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat</td>
                                                        <td>:</td>
                                                        <td class="text-left">Dsn. <?php echo $sk_jalan->address ?> Desa Saobi Kangayan Sumenep</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kepentingan</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->kepentingan ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tempat Tujuan</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->tempat_tujuan ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Berangkat</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->tgl_berangkat ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Barang Yang Dibawa</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->barang_dibawa ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Lama Pergi</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->lama_pergi ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pengikut</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->pengikut ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Lain-lain</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_jalan->lain_lain ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('sk_jalan/preview_document/' . $sk_jalan->id_sk_jalan) ?>" class="btn btn-success" target="_blank"><i class="fa fa-download"></i> Download Surat</a>
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