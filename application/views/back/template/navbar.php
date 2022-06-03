<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo base_url('admin/dashboard') ?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">
      <img src="<?php echo base_url('assets/images/company/'.$company_data->company_photo_thumb) ?>" alt="Company Logo" class="img-circle">
    </span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">
      <img src="<?php echo base_url('assets/images/company/'.$company_data->company_photo_thumb) ?>" alt="Company Logo" class="img-circle">
      <?php echo $company_data->company_name ?>
    </span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <?php if($this->session->photo_thumb == NULL){ ?>
              <img src="<?php echo base_url('assets/images/noimage.jpg') ?>" class="user-image" alt="User Image">
            <?php } else{ ?>
              <img src="<?php echo base_url('assets/images/user/'.$this->session->photo_thumb) ?>" class="user-image" alt="User Image">
            <?php } ?>
            <span class="hidden-xs"><?php echo $this->session->name ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <?php if($this->session->photo_thumb == NULL){ ?>
                <img src="<?php echo base_url('assets/images/noimage.jpg') ?>" class="img-circle" alt="User Image" style="height:60px; width:60px;">
              <?php } else{ ?>
                <img src="<?php echo base_url('assets/images/user/'.$this->session->photo_thumb) ?>" class="img-circle" alt="User Image" style="height:60px; width:60px;">
              <?php } ?>
              <p>
                <?php echo $this->session->username ?> - <?php echo $this->session->usertype_name ?>
                <br>
                <small><b>Bergabung:</b> <?php echo date_only($this->session->created_at) ?></small>
                <small><b><?php echo $this->session->instansi_name ?> | <?php echo $this->session->divisi_name ?></b></small>
              </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
              <div class="row">
                <div class="col-xs-6 text-center">
                  <a href="<?php echo base_url('admin/auth/update_profile/'.$this->session->id_users) ?>">Update Profile</a>
                </div>
                <div class="col-xs-6 text-center">
                  <a href="<?php echo base_url('admin/auth/change_password') ?>">Ubah Password</a>
                </div>
              </div>
              <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right">
                <a href="<?php echo base_url('admin/auth/logout') ?>" class="btn btn-default btn-flat">Logout</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
