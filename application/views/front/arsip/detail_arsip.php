<?php $this->load->view('front/template/meta'); ?>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-blue layout-top-nav">
  <div class="wrapper">

    <?php $this->load->view('front/template/navbar'); ?>

    <div class="content-wrapper">
      <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Detail Arsip</h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"> Detail Arsip</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-sm-3">
                  <div class="form-group"><label>Nomor Arsip</label>
                    <p><?php echo $detail_arsip->no_arsip ?></p>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group"><label>Instansi</label>
                    <p><?php echo $detail_arsip->instansi_name ?></p>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group"><label>Cabang</label>
                    <p><?php echo $detail_arsip->cabang_name ?></p>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group"><label>Divisi</label>
                    <p><?php echo $detail_arsip->divisi_name ?></p>
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
                  <div class="form-group"><label>Nomor Rak</label>
                    <p><?php echo $detail_arsip->rak_name ?></p>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group"><label>Nomor Baris</label>
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
                  <div class="form-group"><label>Nomor Box</label>
                    <p><?php echo $detail_arsip->box_name ?></p>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group"><label>Nomor Map</label>
                    <p><?php echo $detail_arsip->map_name ?></p>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group"><label>Masa Retensi</label>
                    <p><?php echo date_only($detail_arsip->masa_retensi) ?></p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group"><label>Dibuat Pada</label>
                    <p><?php echo datetime_indo($detail_arsip->waktu_dibuat) ?></p>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group"><label>Dibuat Oleh</label>
                    <p><?php echo $detail_arsip->name ?></p>
                  </div>
                </div>
              </div>
            </div>

            <?php
            // Jika grand/masteradmin, tampilkan semua file
            if (is_grandadmin() or is_masteradmin()) {
            ?>
              <div class="box-footer">
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
              </div>

              <?php }
            // Jika superadmin dan instansi dia maka tampilkan file
            elseif (is_superadmin()) {
              if ($detail_arsip->instansi_id == $this->session->instansi_id) {
                // Jika status filenya KHUSUS (0) dan punya dia sendiri maka tampilkan
                if ($detail_arsip->status_file == '0' and $detail_arsip->user_id == $this->session->id_users) {
              ?>
                  <div class="box-footer">
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
                  </div>

                <?php } elseif ($detail_arsip->status_file == '1' and $detail_arsip->instansi_id == $this->session->instansi_id) { ?>
                  <div class="box-footer">
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
                  </div>
                  <?php } elseif ($detail_arsip->status_file == '2' and $detail_arsip->cabang_id == $this->session->cabang_id) { ?>
                  <div class="box-footer">
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
                  </div>
                  <?php } elseif ($detail_arsip->status_file == '3' and $detail_arsip->divisi_id == $this->session->divisi_id) { ?>
                  <div class="box-footer">
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
                  </div>
                <?php } ?>

              <?php }
            }
            // Jika admin
            elseif (is_admin()) {
              // Jika status filenya KHUSUS (0) dan punya dia sendiri maka tampilkan
              if ($detail_arsip->status_file == '0' and $detail_arsip->user_id == $this->session->id_users) {
              ?>
                <div class="box-footer">
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
                </div>

              <?php }
              // Jika status filenya UMUM (1) maka tampilkan filenya
              elseif ($detail_arsip->status_file == '1' and $detail_arsip->instansi_id == $this->session->instansi_id) {
              ?>
                <div class="box-footer">
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
                </div>
                <?php }
              // Jika status filenya UMUM (1) maka tampilkan filenya
              elseif ($detail_arsip->status_file == '2' and $detail_arsip->cabang_id == $this->session->cabang_id) {
              ?>
                <div class="box-footer">
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
                </div>
                <?php }
              // Jika status filenya UMUM (1) maka tampilkan filenya
              elseif ($detail_arsip->status_file == '3' and $detail_arsip->divisi_id == $this->session->divisi_id) {
              ?>
                <div class="box-footer">
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
                </div>
              <?php } ?>
            <?php } ?>
          </div>

          <a href="<?php echo base_url('home') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali ke halaman sebelumnya</a>

        </section>
        <!-- /.content -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->

    <?php $this->load->view('front/template/footer'); ?>

</body>

</html>