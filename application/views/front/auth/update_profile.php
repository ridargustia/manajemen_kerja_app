<?php $this->load->view('front/template/meta'); ?>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
  <div class="wrapper">

  <?php $this->load->view('front/template/navbar'); ?>

  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>Edit Profile</h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Auth</a></li>
          <li><a href="#">Edit Profile</a></li>
        </ol>
      </section>

      <section class="content">
        <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>

        <?php echo form_open_multipart($action) ?>
        <?php echo validation_errors() ?>
          <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">PERSONAL</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group"><label>Nama Lengkap (*)</label>
                    <?php echo form_input($name, $user->name, $user->name) ?>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group"><label>Jenis Kelamin</label>
                    <?php echo form_dropdown('', $gender_value, $user->gender, $gender) ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group"><label>Tempat Lahir</label>
                    <?php echo form_input($birthplace, $user->birthplace) ?>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group"><label>Tanggal Lahir</label>
                    <?php echo form_input($birthdate, $user->birthdate) ?>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group"><label>No. Telpon</label>
                    <?php echo form_input($phone, $user->phone) ?>
                  </div>
                </div>
              </div>
              <div class="form-group"><label>Alamat</label>
                <?php echo form_textarea($address, $user->address) ?>
              </div>
              <div class="form-group"><label>Foto Saat Ini</label>
                <p><img src="<?php echo base_url('assets/images/user/'.$user->photo_thumb) ?>" width="200px" alt="current photo"></p>
              </div>
              <div class="form-group"><label>Foto Baru</label>
                <input type="file" name="photo" id="photo" onchange="photoPreview(this,'preview')"/>
                <p class="help-block">Maximum file size is 2Mb</p>
                <b>Preview</b><br>
                <img id="preview" width="350px"/>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
              <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
            </div>
          </div>

          <div class="box box-success">
            <div class="box-header with-border"><h3 class="box-title">AUTH</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group"><label>Username (*)</label>
                    <?php echo form_input($username, $user->username) ?>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group"><label>Email (*)</label>
                    <?php echo form_input($email, $user->email) ?>
                  </div>
                </div>
              </div>
            </div>
            <?php echo form_input($id_users, $user->id_users) ?>
            <div class="box-footer">
              <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
              <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
            </div>
          </div>
        <?php echo form_close() ?>

      </section>
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('front/template/footer'); ?>

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <script src="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <script type="text/javascript">
    $('#birthdate').datepicker({
      autoclose: true,
      zIndexOffset: 9999
    });

    function photoPreview(photo,idpreview)
    {
      var gb = photo.files;
      for (var i = 0; i < gb.length; i++)
      {
        var gbPreview = gb[i];
        var imageType = /image.*/;
        var preview=document.getElementById(idpreview);
        var reader = new FileReader();
        if (gbPreview.type.match(imageType))
        {
          //jika tipe data sesuai
          preview.file = gbPreview;
          reader.onload = (function(element)
          {
            return function(e)
            {
              element.src = e.target.result;
            };
          })(preview);
          //membaca data URL gambar
          reader.readAsDataURL(gbPreview);
        }
          else
          {
            //jika tipe data tidak sesuai
            alert("Tipe file tidak sesuai. Gambar harus bertipe .png, .gif atau .jpg.");
          }
      }
    }
  </script>

</body>
</html>
