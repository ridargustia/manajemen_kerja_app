<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_skck ?></h3>
        <p>SKCK</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/skck/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_sk_domisili ?></h3>
        <p>Surat Keterangan Domisili</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/sk_domisili/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_sk_jalan ?></h3>
        <p>Surat Keterangan Jalan</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/sk_jalan/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_sk_hilang_ktp ?></h3>
        <p>SK Kehilangan KTP</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/skck/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_sk_meninggal_dunia ?></h3>
        <p>SK Meninggal Dunia</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/sk_domisili/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_sk_nikah ?></h3>
        <p>Surat Keterangan Nikah</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/sk_jalan/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_sk_pindah ?></h3>
        <p>Surat Keterangan Pindah</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/skck/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_sk_usaha ?></h3>
        <p>Surat Keterangan Usaha</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/sk_domisili/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-4 col-sm-4 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_surat_pengantar_nikah ?></h3>
        <p>Surat Pengantar Nikah</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/sk_jalan/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-4 col-sm-4 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_surat_pernyataan_miskin ?></h3>
        <p>Surat Pernyataan Miskin</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/sk_jalan/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-4 col-sm-4 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_surat_rekomendasi ?></h3>
        <p>Surat Rekomendasi</p>
      </div>
      <div class="icon"><i class="fa fa-file-text-o"></i></div>
      <a href="<?php echo base_url('admin/sk_jalan/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<?php if (is_grandadmin()) { ?>
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-orange">
        <div class="inner">
          <h3><?php echo $get_total_menu ?></h3>
          <p>Menu</p>
        </div>
        <div class="icon"><i class="fa fa-list"></i></div>
        <a href="<?php echo base_url('admin/menu/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3><?php echo $get_total_submenu ?></h3>
          <p>SubMenu</p>
        </div>
        <div class="icon"><i class="fa fa-list"></i></div>
        <a href="<?php echo base_url('admin/submenu/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo $get_total_user ?></h3>
          <p>User</p>
        </div>
        <div class="icon"><i class="fa fa-user"></i></div>
        <a href="<?php echo base_url('admin/auth/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php echo $get_total_usertype ?></h3>
          <p>Usertype</p>
        </div>
        <div class="icon"><i class="fa fa-legal"></i></div>
        <a href="<?php echo base_url('admin/usertype/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
<?php } ?>
<!-- /.row -->