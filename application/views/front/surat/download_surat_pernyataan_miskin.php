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
                                            <?php if (empty($surat_pernyataan_miskin->signature_image)) { ?>
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
                                                        <td class="text-left"><?php echo $surat_pernyataan_miskin->no_surat ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama</td>
                                                        <td style="width:10px">:</td>
                                                        <td class="text-left"><?php echo $surat_pernyataan_miskin->name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NIK</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $surat_pernyataan_miskin->nik ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">Tempat Lahir</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $surat_pernyataan_miskin->birthplace ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Lahir</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $surat_pernyataan_miskin->birthdate ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:120px">No HP/Telepon</td>
                                                        <td>:</td>
                                                        <td class="text-left">+<?php echo $surat_pernyataan_miskin->phone ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Kelamin</td>
                                                        <td>:</td>
                                                        <td class="text-left">
                                                            <?php
                                                            if ($surat_pernyataan_miskin->gender === '1') {
                                                                $gender = 'Laki-laki';
                                                            } elseif ($surat_pernyataan_miskin->gender === '2') {
                                                                $gender = 'Perempuan';
                                                            }
                                                            echo $gender;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kewarganegaraan</td>
                                                        <td>:</td>
                                                        <td class="text-left">
                                                            <?php
                                                            if ($surat_pernyataan_miskin->kebangsaan === '1') {
                                                                $kebangsaan = 'Warga Negara Indonesia';
                                                            } elseif ($surat_pernyataan_miskin->kebangsaan === '2') {
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
                                                        <td>Alamat</td>
                                                        <td>:</td>
                                                        <td class="text-left"><?php echo $surat_pernyataan_miskin->address ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('surat_pernyataan_miskin/preview_document/' . $surat_pernyataan_miskin->id_surat_pernyataan_miskin) ?>" class="btn btn-success" target="_blank"><i class="fa fa-download"></i> Download Surat</a>
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