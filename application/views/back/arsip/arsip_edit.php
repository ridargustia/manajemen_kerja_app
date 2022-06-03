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
        <li><a href="<?php echo base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
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
        <?php echo form_open_multipart($action, array('class' => 'form-horizontal')) ?>
        <div class="box-body">
          <?php if (is_grandadmin()) { ?>
            <div class="form-group">
              <label class="col-lg-2 control-label">Instansi</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_instansi, $arsip->instansi_id, $instansi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Cabang</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_cabang, $arsip->cabang_id, $cabang_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Divisi</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_divisi, $arsip->divisi_id, $divisi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Kepemilikan Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_user, $arsip->user_id, $user_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Lokasi Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_lokasi, $arsip->lokasi_id, $lokasi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Rak</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_rak, $arsip->rak_id, $rak_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Box</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_box, $arsip->box_id, $box_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Map</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_map, $arsip->map_id, $map_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Baris</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_baris, $arsip->baris_id, $baris_id) ?>
              </div>
            </div>

          <?php } elseif (is_masteradmin()) { ?>
            <div class="form-group">
              <label class="col-lg-2 control-label">Cabang</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_cabang, $arsip->cabang_id, $cabang_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Divisi</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_divisi, $arsip->divisi_id, $divisi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Kepemilikan Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_user, $arsip->user_id, $user_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Lokasi Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_lokasi, $arsip->lokasi_id, $lokasi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Rak</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_rak, $arsip->rak_id, $rak_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Box</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_box, $arsip->box_id, $box_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Map</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_map, $arsip->map_id, $map_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Baris</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_baris, $arsip->baris_id, $baris_id) ?>
              </div>
            </div>

          <?php } elseif (is_superadmin()) { ?>
            <div class="form-group">
              <label class="col-lg-2 control-label">Divisi</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_divisi, $arsip->divisi_id, $divisi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Kepemilikan Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_user, $arsip->user_id, $user_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Lokasi Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_lokasi, $arsip->lokasi_id, $lokasi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Rak</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_rak, $arsip->rak_id, $rak_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Box</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_box, $arsip->box_id, $box_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Map</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_map, $arsip->map_id, $map_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Baris</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_baris, $arsip->baris_id, $baris_id) ?>
              </div>
            </div>

          <?php } elseif (is_admin()) { ?>
            <div class="form-group">
              <label class="col-lg-2 control-label">Kepemilikan Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_user, $arsip->user_id, $user_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Lokasi Arsip</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_lokasi, $arsip->lokasi_id, $lokasi_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Rak</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_rak, $arsip->rak_id, $rak_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Box</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_box, $arsip->box_id, $box_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Map</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_map, $arsip->map_id, $map_id) ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Baris</label>
              <div class="col-lg-10">
                <?php echo form_dropdown('', $get_all_combobox_baris, $arsip->baris_id, $baris_id) ?>
              </div>
            </div>
          <?php } ?>

          <div class="form-group">
            <label class="col-lg-2 control-label">Nomor Arsip</label>
            <div class="col-lg-10">
              <?php echo form_input($no_arsip, $arsip->no_arsip) ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label">Nama Arsip</label>
            <div class="col-lg-10">
              <?php echo form_input($arsip_name, $arsip->arsip_name) ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label">Deskripsi</label>
            <div class="col-lg-10">
              <?php echo form_textarea($deskripsi_arsip, $arsip->deskripsi_arsip) ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Jenis Arsip Saat Ini</label>
            <div class="col-lg-10">
              <p>
                <?php 
                  $this->db->where('arsip_id', $arsip->id_arsip);
                  $jenis_arsip_result = $this->db->get('arsip_jenis')->result();
                  $jenis_arsip_id     = array();

                  foreach ($jenis_arsip_result as $row) {
                    $jenis_arsip_id[] = $row->jenis_arsip_id;
                  }

                  foreach ($get_all_jenis_arsip as $alljenisArsip) {
                  ?>
                    <div class="pretty p-icon p-smooth">
                      <input type="checkbox" name="jenis_arsip_id[]" value="<?php echo $alljenisArsip->id_jenis ?>" <?php echo ((in_array($alljenisArsip->id_jenis, $jenis_arsip_id)) ? 'checked' : ''); ?>>
                      <div class="state p-primary">
                        <i class="icon fa fa-check"></i>
                        <label><?php echo $alljenisArsip->jenis_name ?></label>
                      </div>
                    </div>
                <?php } ?>
              </p>    
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Masa Retensi</label>
            <div class="col-lg-10">
              <?php echo form_input($masa_retensi, $arsip->masa_retensi) ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">File Saat Ini</label>
            <div class="col-lg-10">
              <?php if ($file_upload == NULL) {
                echo "<button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i> Belum ada data</button>";
              } ?>
              <ol>
                <?php foreach ($file_upload as $files) { ?>
                  <li>
                    <b>FileName:</b> <?php echo $files->file_upload ?><br>                    
                    <a href="<?php echo base_url('assets/file_arsip/'.$instansiName.'/').$files->file_upload ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-download"></i> Download/Lihat</a>
                    <a href="<?php echo base_url('admin/arsip/delete_files_by_id/' . $files->id) ?>" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i> Hapus</a>
                  </li><br>
                <?php } ?>
              </ol>
            </div>
          </div>          

          <div class="form-group">
            <label class="col-lg-2 control-label">Upload File Baru</label>
            <div class="col-lg-10">
              <input type="file" name="file_upload[]" class="multi" multiple>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Status Akses File</label>
            <div class="col-lg-10">
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="status_file" value="3" <?php if ($arsip->status_file == '3') {echo "checked";} ?> />
                <div class="state p-success">
                  <i class="icon fa fa-check"></i>
                  <label>Level Divisi</label>
                </div>
              </div>
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="status_file" value="2" <?php if ($arsip->status_file == '2') {echo "checked";} ?> />
                <div class="state p-success">
                  <i class="icon fa fa-check"></i>
                  <label>Level Cabang</label>
                </div>
              </div>
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="status_file" value="1" <?php if ($arsip->status_file == '1') {echo "checked";} ?> required />
                <div class="state p-success">
                  <i class="icon fa fa-check"></i>
                  <label>Level Instansi</label>
                </div>
              </div>
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="status_file" value="0" <?php if ($arsip->status_file == '0') {echo "checked";} ?> />
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
                <input type="radio" name="keterangan" value="0" <?php if ($arsip->keterangan == '0') {echo "checked";} ?> required />
                <div class="state p-success">
                  <i class="icon fa fa-check"></i>
                  <label>Permanen</label>
                </div>
              </div>
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="keterangan" value="1" <?php if ($arsip->keterangan == '1') {echo "checked";} ?> />
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
        <?php echo form_input($id_arsip, $arsip->id_arsip) ?>
        <input type="hidden" name="arsip_id" value="<?php echo $arsip->id_arsip; ?>">
        <div class="box-footer">
          <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $btn_submit ?></button>
          <button type="reset" name="button" class="btn btn-danger"><i class="fa fa-refresh"></i> <?php echo $btn_reset ?></button>
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

  <!-- dropzone -->
  <!-- multifile -->
  <script src="<?php echo base_url('assets/plugins/multifile/') ?>jquery.MultiFile.js" type="text/javascript" language="javascript"></script>  
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
  </script>

  <script type="text/javascript">
    $('#masa_retensi').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      zIndexOffset: 9999,
      todayHighlight: true,
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
  </script>

</div>
<!-- ./wrapper -->

</body>

</html>