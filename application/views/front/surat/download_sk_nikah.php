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
                                            <?php if (empty($sk_nikah->signature_image)) { ?>
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
                                                        <td class="text-left"><?php echo $sk_nikah->no_surat ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>DATA SUAMI</b></td>
                                                        <td style="width:10px"></td>
                                                        <td class="text-left"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Suami</td>
                                                        <td style="width:10px">:</td>
                                                        <td class="text-left"><?php echo $sk_nikah->suami_name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">Tempat Lahir Suami</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_nikah->suami_birthplace ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Lahir Suami</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_nikah->suami_birthdate ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">No HP/Telepon</td>
                                                        <td>:</td>
                                                        <td class="text-left">+<?php echo $sk_nikah->phone ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Kelamin</td>
                                                        <td>:</td>
                                                        <td class="text-left">
                                                            <?php
                                                            if ($sk_nikah->suami_gender === '1') {
                                                                echo 'Laki-laki';
                                                            } elseif ($sk_nikah->suami_gender === '2') {
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
                                                            if ($sk_nikah->kebangsaan_suami === '1') {
                                                                echo 'Warga Negara Indonesia';
                                                            } elseif ($sk_nikah->kebangsaan_suami === '2') {
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
                                                        <td class="text-left"><?php echo $sk_nikah->istri_name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">Tempat Lahir Istri</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_nikah->istri_birthplace ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Lahir Istri</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $sk_nikah->istri_birthdate ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Kelamin</td>
                                                        <td>:</td>
                                                        <td class="text-left">
                                                            <?php
                                                            if ($sk_nikah->istri_gender === '1') {
                                                                echo 'Laki-laki';
                                                            } elseif ($sk_nikah->istri_gender === '2') {
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
                                                            if ($sk_nikah->kebangsaan_istri === '1') {
                                                                echo 'Warga Negara Indonesia';
                                                            } elseif ($sk_nikah->kebangsaan_istri === '2') {
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
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('sk_nikah/preview_document/' . $sk_nikah->id_sk_nikah) ?>" class="btn btn-success" target="_blank"><i class="fa fa-download"></i> Download Surat</a>
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