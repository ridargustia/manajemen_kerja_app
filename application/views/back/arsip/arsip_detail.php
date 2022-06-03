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
      <div class="box box-primary">
        <div class="box-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group"><label>Nomor Arsip</label>
                <p><?php echo $detail_arsip->no_arsip ?></p>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group"><label>Instansi</label>
                <p><?php echo $detail_arsip->instansi_name ?></p>
              </div>
            </div>
          </div>
          <div class="form-group"><label>Nama Arsip</label>
            <p><?php echo $detail_arsip->arsip_name ?></p>
          </div>
          <div class="form-group"><label>Deskripsi Arsip</label>
            <p><?php echo $detail_arsip->deskripsi_arsip ?></p>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group"><label>Rak</label>
                <p><?php echo $detail_arsip->rak_name ?></p>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group"><label>Baris</label>
                <p><?php echo $detail_arsip->baris_name ?></p>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group"><label>Lokasi Arsip</label>
                <p><?php echo $detail_arsip->lokasi_name ?></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group"><label>Box</label>
                <p><?php echo $detail_arsip->box_name ?></p>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group"><label>Map</label>
                <p><?php echo $detail_arsip->map_name ?></p>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group"><label>Masa Retensi</label>
                <?php if ($detail_arsip->masa_retensi != NULL) { ?>
                  <p><?php echo date_only($detail_arsip->masa_retensi) ?></p>
                <?php } else {
                  echo "<p>-</p>";
                } ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group"><label>Dibuat Pada</label>
                <p><?php echo datetime_indo($detail_arsip->waktu_dibuat) ?></p>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group"><label>Dibuat Oleh</label>
                <p><?php echo $detail_arsip->pembuat_arsip ?></p>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group"><label>Pemilik Arsip</label>
                <p><?php echo $detail_arsip->pemilik_arsip ?></p>
              </div>
            </div>
          </div>

          <?php
          // Jika grand/masteradmin, tampilkan semua file
          if (is_grandadmin() or is_masteradmin()) {
          ?>
            <div class="form-group"><label>File</label>
              <br>
              <?php if ($file_upload == NULL) {
                echo "<button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i> Belum ada data</button>";
              } ?>
              <ol>
                <?php foreach ($file_upload as $files) { ?>
                  <li>
                    <b>FileName:</b> <?php echo $files->file_upload ?><br>
                    <a href="<?php echo base_url('assets/file_arsip/' . $instansiName . '/') . $files->file_upload ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-download"></i> Download/Lihat</a>
                  </li><br>
                <?php } ?>
              </ol>
            </div>

            <?php }
          // Jika superadmin dan instansi dia maka tampilkan file
          elseif (is_superadmin()) {
            if ($detail_arsip->instansi_id == $this->session->instansi_id) {
              // Jika status filenya KHUSUS (0) dan punya dia sendiri maka tampilkan
              if ($detail_arsip->status_file == '0' and $detail_arsip->user_id == $this->session->id_users) {
            ?>
                <div class="form-group"><label>File</label>
                  <br>
                  <?php if ($file_upload == NULL) {
                    echo "<button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i> Belum ada data</button>";
                  } ?>
                  <ol>
                    <?php foreach ($file_upload as $files) { ?>
                      <li>
                        <b>FileName:</b> <?php echo $files->file_upload ?><br>
                        <a href="<?php echo base_url('assets/file_arsip/' . $instansiName . '/') . $files->file_upload ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-download"></i> Download/Lihat</a>
                      </li><br>
                    <?php } ?>
                  </ol>
                </div>

              <?php } elseif ($detail_arsip->status_file == '1' and $detail_arsip->instansi_id == $this->session->instansi_id) { ?>
                <div class="form-group"><label>File</label>
                  <br>
                  <?php if ($file_upload == NULL) {
                    echo "<button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i> Belum ada data</button>";
                  } ?>
                  <ol>
                    <?php foreach ($file_upload as $files) { ?>
                      <li>
                        <b>FileName:</b> <?php echo $files->file_upload ?><br>
                        <a href="<?php echo base_url('assets/file_arsip/' . $instansiName . '/') . $files->file_upload ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-download"></i> Download/Lihat</a>
                      </li><br>
                    <?php } ?>
                  </ol>
                </div>
                <?php } elseif ($detail_arsip->status_file == '2' and $detail_arsip->cabang_id == $this->session->cabang_id) { ?>
                <div class="form-group"><label>File</label>
                  <br>
                  <?php if ($file_upload == NULL) {
                    echo "<button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i> Belum ada data</button>";
                  } ?>
                  <ol>
                    <?php foreach ($file_upload as $files) { ?>
                      <li>
                        <b>FileName:</b> <?php echo $files->file_upload ?><br>
                        <a href="<?php echo base_url('assets/file_arsip/' . $instansiName . '/') . $files->file_upload ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-download"></i> Download/Lihat</a>
                      </li><br>
                    <?php } ?>
                  </ol>
                </div>
                <?php } elseif ($detail_arsip->status_file == '3' and $detail_arsip->divisi_id == $this->session->divisi_id) { ?>
                <div class="form-group"><label>File</label>
                  <br>
                  <?php if ($file_upload == NULL) {
                    echo "<button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i> Belum ada data</button>";
                  } ?>
                  <ol>
                    <?php foreach ($file_upload as $files) { ?>
                      <li>
                        <b>FileName:</b> <?php echo $files->file_upload ?><br>
                        <a href="<?php echo base_url('assets/file_arsip/' . $instansiName . '/') . $files->file_upload ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-download"></i> Download/Lihat</a>
                      </li><br>
                    <?php } ?>
                  </ol>
                </div>
              <?php } ?>

            <?php }
          }
          // Jika admin
          elseif (is_admin()) {
            // Jika status filenya KHUSUS (0) dan punya dia sendiri maka tampilkan
            if ($detail_arsip->status_file == '0' and $detail_arsip->user_id == $this->session->id_users) {
            ?>
              <div class="form-group"><label>File</label>
                <br>
                <?php if ($file_upload == NULL) {
                  echo "<button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i> Belum ada data</button>";
                } ?>
                <ol>
                  <?php foreach ($file_upload as $files) { ?>
                    <li>
                      <b>FileName:</b> <?php echo $files->file_upload ?><br>
                      <a href="<?php echo base_url('assets/file_arsip/' . $instansiName . '/') . $files->file_upload ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-download"></i> Download/Lihat</a>
                    </li><br>
                  <?php } ?>
                </ol>
              </div>

            <?php }
            // Jika status filenya UMUM (1) maka tampilkan filenya
            elseif ($detail_arsip->status_file == '1' and $detail_arsip->instansi_id == $this->session->instansi_id) {
            ?>
              <div class="form-group"><label>File</label>
                <br>
                <?php if ($file_upload == NULL) {
                  echo "<button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i> Belum ada data</button>";
                } ?>
                <ol>
                  <?php foreach ($file_upload as $files) { ?>
                    <li>
                      <b>FileName:</b> <?php echo $files->file_upload ?><br>
                      <a href="<?php echo base_url('assets/file_arsip/' . $instansiName . '/') . $files->file_upload ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-download"></i> Download/Lihat</a>
                    </li><br>
                  <?php } ?>
                </ol>
              </div>
              <?php }
            // Jika status filenya UMUM (2) maka tampilkan filenya
            elseif ($detail_arsip->status_file == '2' and $detail_arsip->cabang_id == $this->session->cabang_id) {
            ?>
              <div class="form-group"><label>File</label>
                <br>
                <?php if ($file_upload == NULL) {
                  echo "<button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i> Belum ada data</button>";
                } ?>
                <ol>
                  <?php foreach ($file_upload as $files) { ?>
                    <li>
                      <b>FileName:</b> <?php echo $files->file_upload ?><br>
                      <a href="<?php echo base_url('assets/file_arsip/' . $instansiName . '/') . $files->file_upload ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-download"></i> Download/Lihat</a>
                    </li><br>
                  <?php } ?>
                </ol>
              </div>
              <?php }
            // Jika status filenya UMUM (3) maka tampilkan filenya
            elseif ($detail_arsip->status_file == '3' and $detail_arsip->divisi_id == $this->session->divisi_id) {
            ?>
              <div class="form-group"><label>File</label>
                <br>
                <?php if ($file_upload == NULL) {
                  echo "<button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i> Belum ada data</button>";
                } ?>
                <ol>
                  <?php foreach ($file_upload as $files) { ?>
                    <li>
                      <b>FileName:</b> <?php echo $files->file_upload ?><br>
                      <a href="<?php echo base_url('assets/file_arsip/' . $instansiName . '/') . $files->file_upload ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-download"></i> Download/Lihat</a>
                    </li><br>
                  <?php } ?>
                </ol>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
        <!-- /.box-body -->

      </div>

      <a href="<?php echo base_url('admin/arsip/index') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali ke halaman sebelumnya</a>

      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('back/template/footer'); ?>

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>select2/dist/css/select2-flat-theme.min.css">
  <script src="<?php echo base_url('assets/plugins/') ?>select2/dist/js/select2.full.min.js"></script>
  <!-- multifile -->
  <script src="<?php echo base_url('assets/plugins/multifile/') ?>jquery.MultiFile.js" type="text/javascript" language="javascript"></script>
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <script src="<?php echo base_url('assets/plugins/') ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <script type="text/javascript">
    $('#masa_retensi').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      zIndexOffset: 9999,
      todayHighlight: true,
    });

    $("#jenis_arsip_id").select2({
      placeholder: "- Please Choose Jenis Arsip -",
      theme: "flat"
    });
  </script>

</div>
<!-- ./wrapper -->

</body>

</html>