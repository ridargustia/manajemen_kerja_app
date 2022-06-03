<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-4 col-sm-4 col-xs-12">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo $get_total_peminjaman ?></h3>
        <p>Peminjaman</p>
      </div>
      <div class="icon"><i class="fa fa-edit"></i></div>
      <a href="<?php echo base_url('admin/peminjaman/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-4 col-sm-4 col-xs-12">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $get_total_pengembalian ?></h3>
        <p>Pengembalian</p>
      </div>
      <div class="icon"><i class="fa fa-edit"></i></div>
      <a href="<?php echo base_url('admin/pengembalian/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-4 col-sm-4 col-xs-12">
    <div class="small-box bg-maroon">
      <div class="inner">
        <h3><?php echo $get_total_arsip ?></h3>
        <p>Arsip</p>
      </div>
      <div class="icon"><i class="fa fa-archive"></i></div>
      <a href="<?php echo base_url('admin/arsip/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<?php if(!is_admin()){ ?>
  <div class="row">
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?php echo $get_total_rak ?></h3>
        <p>Rak</p>
      </div>
      <div class="icon"><i class="fa fa-building"></i></div>
      <a href="<?php echo base_url('admin/rak/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?php echo $get_total_baris ?></h3>
        <p>Baris</p>
      </div>
      <div class="icon"><i class="fa fa-book"></i></div>
      <a href="<?php echo base_url('admin/baris/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-teal">
      <div class="inner">
        <h3><?php echo $get_total_box ?></h3>
        <p>Box</p>
      </div>
      <div class="icon"><i class="fa fa-inbox"></i></div>
      <a href="<?php echo base_url('admin/box/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-teal">
      <div class="inner">
        <h3><?php echo $get_total_map ?></h3>
        <p>Map</p>
      </div>
      <div class="icon"><i class="fa fa-bookmark"></i></div>
      <a href="<?php echo base_url('admin/map/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>
<?php } ?>

<?php if(is_grandadmin()){ ?>
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
      <div class="small-box bg-navy">
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

<?php }elseif(is_masteradmin() and is_superadmin()){ ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo $get_total_user ?></h3>
          <p>User</p>
        </div>
        <div class="icon"><i class="fa fa-user"></i></div>
        <a href="<?php echo base_url('admin/auth/index') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
<?php } ?>
<!-- /.row -->
