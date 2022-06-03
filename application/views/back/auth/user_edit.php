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

      <?php echo form_open_multipart($action) ?>
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
                <?php echo form_input($name, $user->name, $user->name) ?>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group"><label>Gender</label>
                <?php echo form_dropdown('', $gender_value, $user->gender, $gender) ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4">
              <div class="form-group"><label>Birthplace</label>
                <?php echo form_input($birthplace, $user->birthplace) ?>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group"><label>Birthdate</label>
                <?php echo form_input($birthdate, $user->birthdate) ?>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group"><label>Phone No.</label>
                <?php echo form_input($phone, $user->phone) ?>
              </div>
            </div>
          </div>
          <div class="form-group"><label>Address</label>
            <?php echo form_textarea($address, $user->address) ?>
          </div>
          <div class="form-group"><label>Current Photo</label>
            <p><img src="<?php echo base_url('assets/images/user/' . $user->photo_thumb) ?>" width="200px" alt="current photo"></p>
          </div>
          <div class="form-group"><label>New Photo</label>
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
                <?php echo form_input($username, $user->username) ?>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group"><label>Email (*)</label>
                <?php echo form_input($email, $user->email) ?>
              </div>
            </div>
          </div>

          <?php if (is_grandadmin()) { ?>
            <div class="row">
              <div class="col-sm-3">
                <div class="form-group"><label>Instansi (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_instansi, $user->instansi_id, $instansi_id) ?>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group"><label>Cabang (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_cabang, $user->cabang_id, $cabang_id) ?>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group"><label>Divisi (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_divisi, $user->divisi_id, $divisi_id) ?>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group"><label>Usertype (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_usertype, $user->usertype_id, $usertype_id) ?>
                </div>
              </div>
            </div>

          <?php } elseif (is_masteradmin()) { ?>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group"><label>Cabang (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_cabang, $user->cabang_id, $cabang_id) ?>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group"><label>Divisi (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_divisi, $user->divisi_id, $divisi_id) ?>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group"><label>Usertype (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_usertype, $user->usertype_id, $usertype_id) ?>
                </div>
              </div>
            </div>

          <?php } elseif (is_superadmin()) { ?>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group"><label>Divisi (*)</label>
                  <?php echo form_dropdown('', $get_all_combobox_divisi, $user->divisi_id, $divisi_id) ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group"><label>Usertype (*)</label>
                  <?php if ($this->session->id_users != $this->uri->segment(4)) { ?>
                    <?php echo form_dropdown('', $get_all_combobox_usertype, $user->usertype_id, $usertype_id) ?>
                  <?php } else { ?>
                    <select class="form-control" name="usertype">
                      <option value="<?php echo $user->usertype_id ?>"><?php echo $user->usertype_id_name ?></option>
                    </select>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>

          <div class="form-group"><label>Akses Data (*)</label>
            <p>
              <?php
              $this->db->where('user_id', $user->id_users);
              $user_access_result = $this->db->get('users_data_access')->result();
              $user_access_ids = array();

              foreach ($user_access_result as $row) {
                $user_access_ids[] = $row->data_access_id;
              }

              foreach ($get_all_data_access as $alldataAccess) {
              ?>
                <div class="pretty p-icon p-smooth">
                  <input type="checkbox" name="data_access_id[]" value="<?php echo $alldataAccess->id_data_access ?>" <?php echo ((in_array($alldataAccess->id_data_access, $user_access_ids)) ? 'checked' : ''); ?>>
                  <div class="state p-primary">
                    <i class="icon fa fa-check"></i>
                    <label><?php echo $alldataAccess->data_access_name ?></label>
                  </div>
                </div>
              <?php } ?>
            </p>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('back/template/footer'); ?>
  <!-- Pretty Checkbox -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>pretty-checkbox/dist/pretty-checkbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>select2/dist/css/select2-flat-theme.min.css">
  <script src="<?php echo base_url('assets/plugins/') ?>select2/dist/js/select2.full.min.js"></script>

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <script src="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <script type="text/javascript">
    $('#birthdate').datepicker({
      autoclose: true,
      zIndexOffset: 9999
    })

    $("#data_access_id").select2({
      placeholder: "- Please Choose Data Access -",
      theme: "flat"
    });

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
            minlength: 8
          },
          email: {
            required: true,
            email: true
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
            minlength: "<span style='color:red'>Minimal 8 huruf</span>",
          },
          email: "<span style='color:red'>Format email belum benar</span>",
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