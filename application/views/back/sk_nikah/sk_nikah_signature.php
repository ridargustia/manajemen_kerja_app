<!DOCTYPE html>
<html>

<head>
    <title><?php echo $page_title . ' | ' . $company_data->company_name ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/template/back/') ?>dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url('assets/template/back/') ?>dist/css/skins/_all-skins.min.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/company/' . $company_data->company_photo_thumb) ?>" />
    <!-- Animate CSS (SweetAlert) -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>sweetalert/animate.min.css">

    <style type="text/css">
        .swal2-popup {
            font-size: 1.6rem !important;
        }

        .m-signature-pad-body {
            border: 1px dashed #ccc;
            border-radius: 5px;
            color: #bbbabb;
            height: 253px;
            width: 100%;
            text-align: center;
            margin: auto;
        }
    </style>

</head>

<body class="<?php echo $skins_template->value ?> sidebar-mini <?php echo $layout_template->value ?>">
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
                <div class="box box-primary" id="signature-pad">
                    <div class="box-header">
                        <h3 class="box-title">TANDA TANGAN DISINI</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="m-signature-pad-body">
                                    <canvas width="450" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_input($id_sk_nikah, $sk_nikah->id_sk_nikah) ?>
                    <div class="box-footer">
                        <button type="button" id="save2" data-action="save" class="btn btn-success"><i class="fa fa-check"></i> Simpan</button>
                        <button type="button" id="clear-button" data-action="clear" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
                    </div>
                    <!-- /.box -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <?php echo $footer->content ?>
        </footer>

        <!-- jQuery 3 -->
        <script src="<?php echo base_url('assets/plugins/') ?>jquery/dist/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo base_url('assets/plugins/') ?>jquery-ui/jquery-ui.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url('assets/plugins/') ?>bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Slimscroll -->
        <script src="<?php echo base_url('assets/plugins/') ?>jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url('assets/plugins/') ?>fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url('assets/template/back/') ?>dist/js/adminlte.min.js"></script>
        <!-- SweetAlert -->
        <script src="<?php echo base_url('assets/plugins/') ?>sweetalert/js/sweetalert2.all.min.js"></script>
        <!-- Signature -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/signature-pad.js"></script>

        <script>
            var wrapper = document.getElementById("signature-pad"),
                clearButton = wrapper.querySelector("[data-action=clear]"),
                saveButton = wrapper.querySelector("[data-action=save]"),
                canvas = wrapper.querySelector("canvas"),
                signaturePad;

            function resizeCanvas() {
                var ratio = window.devicePixelRatio || 1;
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }

            signaturePad = new SignaturePad(canvas);

            clearButton.addEventListener("click", function(event) {
                signaturePad.clear();
            });

            saveButton.addEventListener("click", function(event) {

                if (signaturePad.isEmpty()) {
                    <?php $this->session->set_flashdata('message', 'wajib diisi') ?>
                    window.location = "<?php echo base_url(); ?>admin/sk_nikah/signature/" + $('#id_sk_nikah').val();
                } else {
                    var image = signaturePad.toDataURL();
                    var newImage = image.replace('data:image/png;base64,', '');
                    var newImage2 = newImage.replace(' ', '+');

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>admin/sk_nikah/signature_action",
                        data: {
                            image: newImage2,
                            id_sk_nikah: $('#id_sk_nikah').val()
                        },
                        success: function(datas1) {
                            signaturePad.clear();

                            window.location = "<?php echo base_url(); ?>admin/sk_nikah/numbering/" + $('#id_sk_nikah').val();
                        }
                    });
                }
            });
        </script>

        <script type="text/javascript">
            const flashData = $('.flash-data').data('flashdata');
            if (flashData === 'wajib diisi') {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Tanda tangan ' + flashData + '!',
                    showClass: {
                        popup: 'animate__animated animate__tada'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                });
            }
        </script>

    </div>
    <!-- ./wrapper -->

</body>

</html>