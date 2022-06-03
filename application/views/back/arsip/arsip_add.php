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
      <?php echo validation_errors() ?>
      <div class="box box-primary">
        <?php echo form_open_multipart($action, array('class' => 'form-horizontal', 'id' => 'add_form')) ?>
        <div class="box-body">
          <?php if (is_grandadmin()) { ?>
            <div class="form-group">
              <label class="col-lg-2 control-label">Instansi</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_instansi, '', $instansi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Cabang</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Instansi Dulu -'), '', $cabang_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Divisi</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $divisi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Lokasi Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $lokasi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Kepemilikan Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Divisi Dulu -'), '', $user_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Rak</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $rak_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Box</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $box_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Map</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $map_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Baris</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $baris_id) ?>
              </div>
            </div>

          <?php } elseif (is_masteradmin()) { ?>
            <div class="form-group">
              <label class="col-lg-2 control-label">Cabang</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_cabang, '', $cabang_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Divisi</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $divisi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Lokasi Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $lokasi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Kepemilikan Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Divisi Dulu -'), '', $user_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Rak</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Divisi Dulu -'), '', $rak_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Box</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Divisi Dulu -'), '', $box_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Map</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Divisi Dulu -'), '', $map_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Baris</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Divisi Dulu -'), '', $baris_id) ?>
              </div>
            </div>

          <?php } elseif (is_superadmin()) { ?>
            <div class="form-group">
              <label class="col-lg-2 control-label">Divisi</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_divisi, '', $divisi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Lokasi Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_lokasi, '', $lokasi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Kepemilikan Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', array('' => '- Pilih Divisi Dulu -'), '', $user_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Rak</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_rak, '', $rak_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Box</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_box, '', $box_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Map</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_map, '', $map_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Baris</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_baris, '', $baris_id) ?>
              </div>
            </div>

          <?php } elseif (is_admin()) { ?>
            <div class="form-group">
              <label class="col-lg-2 control-label">Lokasi Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_lokasi, '', $lokasi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Rak</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_rak, '', $rak_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Box</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_box, '', $box_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Map</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_map, '', $map_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Baris</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_baris, '', $baris_id) ?>
              </div>
            </div>
          <?php } ?>

          <div class="form-group">
            <label class="col-lg-2 control-label">Nomor Arsip</label>
            <div class="col-lg-10">
              <?php echo form_input($no_arsip) ?>
              <span id="no_arsip-availability-status"></span>
              <img src="<?php echo base_url('assets/images/loading.gif') ?>" id="loaderNoArsip" style="display:none" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Nama Arsip</label>
            <div class="col-lg-10">
              <?php echo form_input($arsip_name) ?>
              <span id="arsip_name-availability-status"></span>
              <img src="<?php echo base_url('assets/images/loading.gif') ?>" id="loaderArsipName" style="display:none" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Deskripsi</label>
            <div class="col-lg-10">
              <?php echo form_textarea($deskripsi_arsip) ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Jenis Arsip</label>
            <div class="col-lg-10">
              <p>
                <?php foreach ($get_all_jenis_arsip as $jenisArsipId) { ?>
                  <div class="pretty p-icon p-smooth">
                    <input type="checkbox" name="jenis_arsip_id[]" value="<?php echo $jenisArsipId->id_jenis ?>">
                    <div class="state p-success">
                      <i class="icon fa fa-check"></i>
                      <label><?php echo $jenisArsipId->jenis_name ?></label>
                    </div>
                  </div>
                <?php } ?>
              </p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Masa Retensi</label>
            <div class="col-lg-10">
              <?php echo form_input($masa_retensi) ?>
            </div>
          </div>          

          <div class="form-group">
            <label class="col-lg-2 control-label">Upload File</label>
            <div class="col-lg-10">
              <input type="file" name="file_upload[]" class="multi file-upload" multiple>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Status Akses File</label>
            <div class="col-lg-10">
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="status_file" value="3" />
                <div class="state p-success">
                  <i class="icon fa fa-check"></i>
                  <label>Level Divisi</label>
                </div>
              </div>
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="status_file" value="2" />
                <div class="state p-success">
                  <i class="icon fa fa-check"></i>
                  <label>Level Cabang</label>
                </div>
              </div>
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="status_file" value="1" required />
                <div class="state p-success">
                  <i class="icon fa fa-check"></i>
                  <label>Level Instansi</label>
                </div>
              </div>
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="status_file" value="0" />
                <div class="state p-success">
                  <i class="icon fa fa-check"></i>
                  <label>Privat</label>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Keterangan</label>
            <div class="col-lg-10">
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="keterangan" value="0" required />
                <div class="state p-success">
                  <i class="icon fa fa-check"></i>
                  <label>Permanen</label>
                </div>
              </div>
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="keterangan" value="1" />
                <div class="state p-danger">
                  <i class="icon fa fa-check"></i>
                  <label>Musnah</label>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <h3><b>CATATAN:</b></h3>
          <ul>
            <li>Jenis File yang boleh diupload:
              <br><b>TEXT</b>: txt, pdf, ppt, pptx, xls, xlsx, doc, docx.
              <br><b>AUDIO</b>: mp3, flac, wav, m4a.
              <br><b>VIDEO</b>: mp4, flv.
              <br><b>FOTO</b>: jpg, jpeg, png.
              <br><b>COMPRESSION</b>: zip, rar.
            </li>
            <li>Disarankan kalau filenya banyak, lebih baik buat dalam format <b>zip</b> atau <b>rar</b></li>
          </ul>
        </div>
        <div class="box-footer">
          <div class="row">
            <div class="col-md-2">
              <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
              <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
            </div>
            <div class="col-md-10" style="margin-top:7px; padding-right:35px">
              <div class="progress" style="display:none">
                <div id="file-progress-bar" class="progress-bar"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <?php echo form_close() ?>
      </div>

      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('back/template/footer'); ?>  
  <!-- multifile -->
  <script src="<?php echo base_url('assets/plugins/multifile/') ?>jquery.MultiFile.js" type="text/javascript" language="javascript"></script>
  <!-- Jquery Validation -->
  <script src="<?php echo base_url('assets/plugins/') ?>jquery-validation/jquery.validate.min.js"></script>
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
    $(document).ready(function() {
      $("#map_id").select2({
        // placeholder: "Silahkan Pilih Peminjam",
      });
      
      $("#box_id").select2({
        // placeholder: "Silahkan Pilih Peminjam",
      });
    });
    
    //Progress Bar-----------------------------------------------
    jQuery(document).on('submit', '#add_form', function(e){
        //jQuery("#chk-error").html('');
        var checkValue = $(".file-upload").val();
        // console.log(checkValue);
        if(checkValue) {
            
            jQuery('.progress').show();
            e.preventDefault();
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();         
                    xhr.upload.addEventListener("progress", function(element) {
                        if (element.lengthComputable) {
                            var percentComplete = ((element.loaded / element.total) * 100);
                            $("#file-progress-bar").width(percentComplete + '%');
                            $("#file-progress-bar").html(Math.round(percentComplete)+'% Uploaded...Please wait.');
                        
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url:"<?php echo base_url(); ?>admin/arsip/create_action",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                dataType:'json',
                beforeSend: function(){
                    $("#file-progress-bar").width('0%');
                },

                success: function(json){
                    console.log(json);
                    if (json == 'success') {
                        window.location = 'https://arsip.eduarsip.id/admin/arsip';
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }else{
          
          e.preventDefault();
          $.ajax({
              
              type: 'POST',
              url:"<?php echo base_url(); ?>admin/arsip/create_action",
              data: new FormData(this),
              contentType: false,
              cache: false,
              processData:false,
              // dataType:'json',

              success: function(){
                window.location = 'https://arsip.eduarsip.id/admin/arsip';
              },
              error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              }
          });
        }
    });
    //End Progress Bar------------------------------------------
  </script>

  <script type="text/javascript">
    $('#masa_retensi').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      zIndexOffset: 9999,
      todayHighlight: true,
    });

    $("#jenis_arsip_id").select2({
      placeholder: "- Silahkan Pilih Jenis Arsip -",
      theme: "flat"
    });

    $('#email').on('change', function() {
      var email = $(this).val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('admin/token/pilih_folder') ?>",
        dataType: "JSON",
        data: {
          email: email
        },
        cache: false,
        success: function(data) {
          $.each(data, function() {
            $('[id="folder_name"]').val(data.folder_name);
          });
        }
      });
      return false;
    });

    function tampilLokasi() {
      cabang_id = document.getElementById("cabang_id").value;
      $.ajax({
        url: "<?php echo base_url(); ?>admin/lokasi/pilih_lokasi/" + cabang_id + "",
        success: function(response) {
          $("#lokasi_id").html(response);
        },
        dataType: "html"
      });
      return false;
    }

    function tampilRak() {
      cabang_id = document.getElementById("cabang_id").value;
      $.ajax({
        url: "<?php echo base_url(); ?>admin/rak/pilih_rak/" + cabang_id + "",
        success: function(response) {
          $("#rak_id").html(response);
        },
        dataType: "html"
      });
      return false;
    }

    function tampilBox() {
      cabang_id = document.getElementById("cabang_id").value;
      $.ajax({
        url: "<?php echo base_url(); ?>admin/box/pilih_box/" + cabang_id + "",
        success: function(response) {
          $("#box_id").html(response);
        },
        dataType: "html"
      });
      return false;
    }

    function tampilMap() {
      cabang_id = document.getElementById("cabang_id").value;
      $.ajax({
        url: "<?php echo base_url(); ?>admin/map/pilih_map/" + cabang_id + "",
        success: function(response) {
          $("#map_id").html(response);
        },
        dataType: "html"
      });
      return false;
    }

    function tampilBaris() {
      cabang_id = document.getElementById("cabang_id").value;
      $.ajax({
        url: "<?php echo base_url(); ?>admin/baris/pilih_baris/" + cabang_id + "",
        success: function(response) {
          $("#baris_id").html(response);
        },
        dataType: "html"
      });
      return false;
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

    function tampilKepemilikanArsip() {
      divisi_id = document.getElementById("divisi_id").value;
      $.ajax({
        url: "<?php echo base_url(); ?>admin/auth/pilih_user/" + divisi_id + "",
        success: function(response) {
          $("#user_id").html(response);
        },
        dataType: "html"
      });
      return false;
    }

    function checkNoArsip() {
      $("#loaderNoArsip").show();
      jQuery.ajax({
        url: "<?php echo base_url('admin/arsip/check_no_arsip') ?>",
        data: 'no_arsip=' + $("#no_arsip").val(),
        type: "POST",
        success: function(data) {
          $("#no_arsip-availability-status").html(data);
          $("#loaderNoArsip").hide();
        },
        error: function() {}
      });
    }

    function checkArsipName() {
      $("#loaderArsipName").show();
      jQuery.ajax({
        url: "<?php echo base_url('admin/arsip/check_arsip_name') ?>",
        data: 'arsip_name=' + $("#arsip_name").val(),
        type: "POST",
        success: function(data) {
          $("#arsip_name-availability-status").html(data);
          $("#loaderArsipName").hide();
        },
        error: function() {}
      });
    }

    $(document).ready(function() {
      $("#add_form").validate({
        errorElement: "span",
        rules: {
          name: "required",
          instansi_id: {
            required: true,
          },
          cabang_id: {
            required: true,
          },
          divisi_id: {
            required: true,
          },
          lokasi_id: {
            required: true,
          },
          user_id: {
            required: true,
          },
          rak_id: {
            required: true,
          },
          map_id: {
            required: true,
          },
          box_id: {
            required: true,
          },
          baris_id: {
            required: true,
          },
          no_arsip: {
            required: true,
          },
          arsip_name: {
            required: true,
          },
          deskripsi_arsip: {
            required: true,
          },
          masa_retensi: {
            required: true,
          },
          status_file: {
            required: true,
          },
          keterangan: {
            required: true,
          },
        },
        messages: {
          instansi_id: "<span style='color:red'>Wajib diisi</span>",
          cabang_id: "<span style='color:red'>Wajib diisi</span>",
          divisi_id: "<span style='color:red'>Wajib diisi</span>",
          lokasi_id: "<span style='color:red'>Wajib diisi</span>",
          user_id: "<span style='color:red'>Wajib diisi</span>",
          rak_id: "<span style='color:red'>Wajib diisi</span>",
          map_id: "<span style='color:red'>Wajib diisi</span>",
          box_id: "<span style='color:red'>Wajib diisi</span>",
          baris_id: "<span style='color:red'>Wajib diisi</span>",
          no_arsip: "<span style='color:red'>Wajib diisi</span>",
          arsip_name: "<span style='color:red'>Wajib diisi</span>",
          deskripsi_arsip: "<span style='color:red'>Wajib diisi</span>",
          masa_retensi: "<span style='color:red'>Wajib diisi</span>",
          status_file: "<span style='color:red'>Wajib diisi</span>",
          keterangan: "<span style='color:red'>Wajib diisi</span>",
        }
      });
    });
  </script>

</div>
<!-- ./wrapper -->

</body>

</html>