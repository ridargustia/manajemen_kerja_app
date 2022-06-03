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
        <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><?php echo $module ?></li>
        <li class="active"><?php echo $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
      } ?>

      <?php echo form_open_multipart($action, array('id' => 'add_form')) ?>
      <?php echo validation_errors() ?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">PERSONAL</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group"><label>Full Name (*)</label>
                <?php echo form_input($name) ?>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group"><label>Gender</label>
                <?php echo form_dropdown('', $gender_value, '', $gender) ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4">
              <div class="form-group"><label>Birthplace</label>
                <?php echo form_input($birthplace) ?>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group"><label>Birthdate</label>
                <?php echo form_input($birthdate) ?>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group"><label>Phone No.</label>
                <?php echo form_input($phone) ?>
              </div>
            </div>
          </div>
          <div class="form-group"><label>Address</label>
            <?php echo form_textarea($address) ?>
          </div>
          <div class="form-group"><label>Photo</label>
            <input type="file" name="photo" id="photo" onchange="photoPreview(this,'preview')" />
            <p class="help-block">Maximum file size is 2Mb</p>
            <b>Photo Preview</b><br>
            <img id="preview" width="350px" />
          </div>
        </div>
      </div>

      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">AUTH</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group"><label>Username (*)</label>
                <?php echo form_input($username) ?>
                <span id="user-availability-status"></span>
                <img src="<?php echo base_url('assets/images/loading.gif') ?>" id="loaderIcon" style="display:none" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group"><label>Email (*)</label>
                <?php echo form_input($email) ?>
                <span id="email-availability-status"></span>
                <img src="<?php echo base_url('assets/images/loading.gif') ?>" id="loaderIcon" style="display:none" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group"><label>Password (*)</label>
                <?php echo form_password($password) ?>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group"><label>Konfirmasi Password (*)</label>
                <?php echo form_password($password_confirm) ?>
              </div>
            </div>
          </div>

          <?php if (is_grandadmin()) { ?>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group"><label>Instansi (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_instansi, '', $instansi_id) ?>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group"><label>Cabang (*)</label>
                  <?php echo form_dropdown('', array('' => '- Pilih Instansi Dulu -'), '', $cabang_id) ?>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group"><label>Divisi (*)</label>
                  <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $divisi_id) ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group"><label>Usertype (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_usertype, '', $usertype_id) ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group"><label>Akses Data (*)</label>
                  <p>
                    <?php foreach ($get_all_data_access as $dataAccess) { ?>
                      <div class="pretty p-icon p-smooth">
                        <input type="checkbox" name="data_access_id[]" value="<?php echo $dataAccess->id_data_access ?>">
                        <div class="state p-success">
                          <i class="icon fa fa-check"></i>
                          <label><?php echo $dataAccess->data_access_name ?></label>
                        </div>
                      </div>
                    <?php } ?>
                  </p>
                </div>
              </div>
            </div>
          <?php } elseif (is_masteradmin()) { ?>
            <div class="row">
              <div class="col-lg-3">
                <div class="form-group"><label>Cabang (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_cabang, '', $cabang_id) ?>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group"><label>Divisi (*)</label>
                  <?php echo form_dropdown('', array('' => '- Pilih Instansi Dulu -'), '', $divisi_id) ?>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group"><label>Usertype (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_usertype, '', $usertype_id) ?>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group"><label>Akses Data (*)</label>
                  <p>
                    <?php foreach ($get_all_data_access as $dataAccess) { ?>
                      <div class="pretty p-icon p-smooth">
                        <input type="checkbox" name="data_access_id[]" value="<?php echo $dataAccess->id_data_access ?>">
                        <div class="state p-success">
                          <i class="icon fa fa-check"></i>
                          <label><?php echo $dataAccess->data_access_name ?></label>
                        </div>
                      </div>
                    <?php } ?>
                  </p>
                </div>
              </div>
            </div>
          <?php } elseif (is_superadmin()) { ?>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group"><label>Divisi (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_divisi, '', $divisi_id) ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group"><label>Usertype (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_usertype, '', $usertype_id) ?>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group"><label>Akses Data (*)</label>
                  <p>
                    <?php foreach ($get_all_data_access as $dataAccess) { ?>
                      <div class="pretty p-icon p-smooth">
                        <input type="checkbox" name="data_access_id[]" value="<?php echo $dataAccess->id_data_access ?>">
                        <div class="state p-success">
                          <i class="icon fa fa-check"></i>
                          <label><?php echo $dataAccess->data_access_name ?></label>
                        </div>
                      </div>
                    <?php } ?>
                  </p>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="box-footer">
          <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
          <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
        </div>
      </div>
      <?php echo form_close() ?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('back/template/footer'); ?>
  <!-- Jquery Validation -->
  <script src="<?php echo base_url('assets/plugins/') ?>jquery-validation/jquery.validate.min.js"></script>
  <!-- Pretty Checkbox -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>pretty-checkbox/dist/pretty-checkbox.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <script src="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <script type="text/javascript">
    $('#birthdate').datepicker({
      autoclose: true,
      zIndexOffset: 9999
    })

    function checkUsername() {
      $("#loaderIcon").show();
      jQuery.ajax({
        url: "<?php echo base_url('admin/auth/check_username') ?>",
        data: 'username=' + $("#username").val(),
        type: "POST",
        success: function(data) {
          $("#user-availability-status").html(data);
          $("#loaderIcon").hide();
        },
        error: function() {}
      });
    }

    function checkEmail() {
      $("#loaderIcon").show();
      jQuery.ajax({
        url: "<?php echo base_url('admin/auth/check_email') ?>",
        data: 'email=' + $("#email").val(),
        type: "POST",
        success: function(data) {
          $("#email-availability-status").html(data);
          $("#loaderIcon").hide();
        },
        error: function() {}
      });
    }

    function photoPreview(photo, idpreview) {
      var gb = photo.files;
      for (var i = 0; i < gb.length; i++) {
        var gbPreview = gb[i];
        var imageType = /image.*/;
        var preview = document.getElementById(idpreview);
        var reader = new FileReader();
        if (gbPreview.type.match(imageType)) {
          //jika tipe data sesuai
          preview.file = gbPreview;
          reader.onload = (function(element) {
            return function(e) {
              element.src = e.target.result;
            };
          })(preview);
          //membaca data URL gambar
          reader.readAsDataURL(gbPreview);
        } else {
          //jika tipe data tidak sesuai
          alert("Tipe file tidak sesuai. Gambar harus bertipe .png, .gif atau .jpg.");
        }
      }
    }

    function tampilCabang() {
      instansi_id = document.getElementById("instansi_id").value;
      $.ajax({
        url: "<?php echo base_url(); ?>admin/cabang/pilih_cabang/" + instansi_id + "",
        success: function(response) {
          $("#cabang_id").html(response);
        },
        dataType: "html"
      });
      return false;
    }

    function tampilDivisi() {
      cabang_id = document.getElementById("cabang_id").value;
      $.ajax({
        url: "<?php echo base_url(); ?>admin/divisi/pilih_divisi/" + cabang_id + "",
        success: function(response) {
          $("#divisi_id").html(response);
        },
        dataType: "html"
      });
      return false;
    }

    $(document).ready(function() {
      $("#add_form").validate({
        errorElement: "span",
        rules: {
          name: "required",
          username: {
            required: true,
            minlength: 3
          },
          password: {
            required: true,
            minlength: 8
          },
          password_confirm: {
            required: true,
            minlength: 8,
            equalTo: "#password"
          },
          email: {
            required: true,
          },
          instansi_id: {
            required: true,
          },
          cabang_id: {
            required: true,
          },
          divisi_id: {
            required: true,
          },
          usertype_id: {
            required: true,
          },
        },
        messages: {
          name: "<span style='color:red'>Wajib diisi</span>",
          username: {
            required: "<span style='color:red'>Wajib diisi</span>",
            minlength: "<span style='color:red'>Minimal 3 huruf</span>",
          },
          password: {
            required: "<span style='color:red'>Wajib diisi</span>",
            minlength: "<span style='color:red'>Password minimal 8 huruf</span>",
          },
          password_confirm: {
            required: "<span style='color:red'>Wajib diisi</span>",
            minlength: "<span style='color:red'>Password minimal 8 huruf</span>",
            equalTo: "<span style='color:red'>Konfirmasi password harus sama dengan password</span>"
          },
          email: "<span style='color:red'>Wajib diisi</span>",
          instansi_id: "<span style='color:red'>Wajib diisi</span>",
          cabang_id: "<span style='color:red'>Wajib diisi</span>",
          divisi_id: "<span style='color:red'>Wajib diisi</span>",
          usertype_id: "<span style='color:red'>Wajib diisi</span>",
        }
      });
    });
  </script>

</div>
<!-- ./wrapper -->

</body>

</html>