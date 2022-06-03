<?php $this->load->view('front/template/meta'); ?>
<a href="javascript:" id="return-to-top"><i class="icon-chevron-up"></i></a>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-blue layout-top-nav">
  <div class="wrapper">

    <?php $this->load->view('front/template/navbar'); ?>

    <div class="content-wrapper">
      <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Hasil Pencarian</h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"> Hasil Pencarian</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <?php $this->load->view('front/template/form_pencarian'); ?>

          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Hasil Pencarian</h3>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body scrollable-content">
              <?php
              $total_data = count($hasil_pencarian);

              // jika datanya TIDAK ADA
              if ($hasil_pencarian == NULL) {
                // jika grandadmin
                if (is_grandadmin()) {
                  // jika instansi DIISI dan form cari DIISI
                  if ($this->input->get('instansi_id') != NULL && $this->input->get('search_form') != NULL) {
                    echo "Tidak ada data yang ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada instansi: <b>" . $instansi->instansi_name . "</b>";
                  }
                  // jika instansi DIISI dan form cari KOSONG
                  elseif ($this->input->get('instansi_id') != NULL && $this->input->get('search_form') == NULL) {
                    echo "
                  <b>Tidak ada data</b> ditemukan dari pencarian arsip pada instansi: <b>" . $instansi->instansi_name . "</b>
                  ";
                  }
                  // jika instansi KOSONG dan form cari DIISI
                  elseif ($this->input->get('instansi_id') == NULL && $this->input->get('search_form') != NULL) {
                    echo "<b>Tidak ada data</b> ditemukan dari pencarian arsip pada <b>semua instansi</b>";
                  }
                  // jika instansi KOSONG dan form cari KOSONG
                  elseif ($this->input->get('instansi_id') == NULL && $this->input->get('search_form') == NULL) {
                    echo "<b>Tidak ada data</b> ditemukan dari pencarian arsip pada <b>semua instansi</b>";
                  }
                }
                // jika masteradmin
                elseif (is_masteradmin()) {
                  // jika cabang DIISI dan form cari DIISI
                  if ($this->input->get('cabang_id') != NULL && $this->input->get('search_form') != NULL) {
                    echo "Tidak ada data yang ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada cabang: <b>" . $cabang->cabang_name . "</b>";
                  }
                  // jika cabang DIISI dan form cari KOSONG
                  elseif ($this->input->get('cabang_id') != NULL && $this->input->get('search_form') == NULL) {
                    echo "
                  <b>Tidak ada data</b> yang ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada cabang: <b>" . $cabang->cabang_name . "</b>
                  ";
                  }
                  // jika cabang KOSONG dan form cari DIISI
                  elseif ($this->input->get('cabang_id') == NULL && $this->input->get('search_form') != NULL) {
                    echo "<b>Tidak ada data</b> yang ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada <b>semua cabang</b>";
                  }
                  // jika cabang KOSONG dan form cari KOSONG
                  elseif ($this->input->get('cabang_id') == NULL && $this->input->get('search_form') == NULL) {
                    echo "<b>Tidak ada data</b> yang ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada <b>semua cabang</b>";
                  }
                }
                // jika superadmin, admin dan pegawai
                else {
                  // jika divisi DIISI dan form cari DIISI
                  if ($this->input->get('divisi_id') != NULL && $this->input->get('search_form') != NULL) {
                    echo "Tidak ada data yang ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada divisi: <b>" . $divisi->divisi_name . "</b>";
                  }
                  // jika divisi DIISI dan form cari KOSONG
                  elseif ($this->input->get('divisi_id') != NULL && $this->input->get('search_form') == NULL) {
                    echo "
                    <b>Tidak ada data</b> yang ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada divisi: <b>" . $divisi->divisi_name . "</b>
                    ";
                  }
                  // jika divisi KOSONG dan form cari DIISI
                  elseif ($this->input->get('divisi_id') == NULL && $this->input->get('search_form') != NULL) {
                    echo "<b>Tidak ada data</b> yang ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada <b>semua divisi</b>";
                  }
                  // jika divisi KOSONG dan form cari KOSONG
                  elseif ($this->input->get('divisi_id') == NULL && $this->input->get('search_form') == NULL) {
                    echo "<b>Tidak ada data</b> yang ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada <b>semua divisi</b>";
                  }
                }
              }
              // jika datanya ADA
              else {
                // jika grandadmin
                if (is_grandadmin()) {
                  // jika instansi DIISI dan form cari DIISI
                  if ($this->input->get('instansi_id') != NULL && $this->input->get('search_form') != NULL) {
                    echo "
                    Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada instansi: <b>" . $instansi->instansi_name . "</b>
                    ";
                  }
                  // jika instansi DIISI dan form cari KOSONG
                  elseif ($this->input->get('instansi_id') != NULL && $this->input->get('search_form') == NULL) {
                    echo "
                    Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip pada instansi: <b>" . $instansi->instansi_name . "</b>
                    ";
                  }
                  // jika instansi KOSONG dan form cari DIISI
                  elseif ($this->input->get('instansi_id') == NULL && $this->input->get('search_form') != NULL) {
                    echo "Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada <b>semua instansi</b>";
                  }
                  // jika instansi KOSONG dan form cari KOSONG
                  elseif ($this->input->get('instansi_id') == NULL && $this->input->get('search_form') == NULL) {
                    echo "Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip pada <b>semua instansi</b>";
                  }
                }
                // jika masteradmin
                elseif (is_masteradmin()) {
                  // jika cabang DIISI dan form cari DIISI
                  if ($this->input->get('cabang_id') != NULL && $this->input->get('search_form') != NULL) {
                    echo "
                    Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada cabang: <b>" . $cabang->cabang_name . "</b>
                    ";
                  }
                  // jika cabang DIISI dan form cari KOSONG
                  elseif ($this->input->get('cabang_id') != NULL && $this->input->get('search_form') == NULL) {
                    echo "
                    Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip pada cabang: <b>" . $cabang->cabang_name . "</b>
                    ";
                  }
                  // jika cabang KOSONG dan form cari DIISI
                  elseif ($this->input->get('cabang_id') == NULL && $this->input->get('search_form') != NULL) {
                    echo "Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada <b>semua cabang</b>";
                  }
                  // jika cabang KOSONG dan form cari KOSONG
                  elseif ($this->input->get('cabang_id') == NULL && $this->input->get('search_form') == NULL) {
                    echo "Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip pada <b>semua cabang</b>";
                  }
                } else {
                  // jika divisi DIISI dan form cari DIISI
                  if ($this->input->get('divisi_id') != NULL && $this->input->get('search_form') != NULL) {
                    echo "
                    Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada divisi: <b>" . $divisi->divisi_name . "</b>
                    ";
                  }
                  // jika divisi DIISI dan form cari KOSONG
                  elseif ($this->input->get('divisi_id') != NULL && $this->input->get('search_form') == NULL) {
                    echo "
                    Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip pada divisi: <b>" . $divisi->divisi_name . "</b>
                    ";
                  }
                  // jika divisi KOSONG dan form cari DIISI
                  elseif ($this->input->get('divisi_id') == NULL && $this->input->get('search_form') != NULL) {
                    echo "Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip dengan keywords: '<b>" . $this->input->get('search_form') . "</b>' pada <b>semua divisi</b>";
                  }
                  // jika divisi KOSONG dan form cari KOSONG
                  elseif ($this->input->get('divisi_id') == NULL && $this->input->get('search_form') == NULL) {
                    echo "Ada <b>" . $total_data . " data </b> ditemukan dari pencarian arsip pada <b>semua divisi</b>";
                  }
                }
              }
              ?>

              <hr>

              <ul class="products-list product-list-in-box">
                <?php
                foreach ($hasil_pencarian as $hasil) {
                  $search_form = $this->input->get('search_form');

                  $arsip_name = !empty($search_form) ? highlightWords($hasil->arsip_name, $search_form) : $hasil->arsip_name;
                  $deskripsi_arsip = !empty($search_form) ? highlightWords($hasil->deskripsi_arsip, $search_form) : $hasil->deskripsi_arsip;
                  
                  // status peminjaman
                  if ($hasil->is_available == '0') {
                    $is_available = "<button type='button' name='button' class='btn btn-xs btn-danger'>DIPINJAM</button> ";
                  } elseif ($hasil->is_available == '1') {
                    $is_available = "<button type='button' name='button' class='btn btn-xs btn-success'>TERSEDIA</button>";
                  }
                ?>
                  <li class="item">
                    <div class="product-img">
                      <img src="<?php echo base_url('assets/images/arsip.jpg') ?>">
                    </div>
                    <div class="product-info">
                      <font style="font-size: 15px; font-weight: bold"><?php echo $hasil->no_arsip ?></font><br>
                      <a class="product-title">
                        <font style="font-size: 18px"><?php echo $arsip_name ?></font>
                      </a>
                      <span class="label label-danger pull-right"><i class="fa fa-tag"></i> <?php echo $hasil->divisi_name ?></span>
                      <p>
                        <?php if ($hasil->deskripsi_arsip != NULL) {
                          echo '<font style="font-size: 15px">' . $deskripsi_arsip . '</font>';
                        } else {
                          echo "Belum ada deskripsi";
                        } ?>
                      </p>
                    </div>
                  </li>
                  <br>
                  <div class="row">
                    <div class="col-sm-8 text-left">
                      Lokasi | <?php echo $hasil->lokasi_name . ' > Rak ' . $hasil->rak_name . ' > Baris ' . $hasil->baris_name . ' > Box ' . $hasil->box_name . ' > Map ' . $hasil->map_name ?>
                      <button type="button" name="button" class="btn btn-xs btn-primary"><?php echo $hasil->jenis_name ?></button>
                      <?php echo $is_available ?>
                    </div>
                    <div class="col-sm-4 text-right">
                      <a href="<?php echo base_url('arsip/detail/' . $hasil->id_arsip) ?>" class="btn btn-sm btn-success"><i class="fa fa-search"></i> PREVIEW</a>
                    </div>
                  </div>
                  <hr>
                <?php } ?>
              </ul>
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

</body>

</html>