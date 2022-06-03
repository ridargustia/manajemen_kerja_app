<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <a href="<?php echo base_url('home') ?>" class="navbar-brand"><b>ARSIP</b></a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="<?php echo base_url('home') ?>"><i class="fa fa-home"></i> <span>Home</span></a></li>
          <?php if(is_grandadmin()) { ?>
          <li><a href="<?php echo base_url('profile') ?>"><i class="fa fa-info-circle"></i> <span>Profil</span></a></li>
          <?php } ?>
        </ul>
      </div>
      <!-- /.navbar-collapse -->

      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <?php if($this->session->photo_thumb == NULL){ ?>
                <img src="<?php echo base_url('assets/images/noimage.jpg') ?>" class="user-image" alt="No Image Found">
              <?php } else{ ?>
                <img src="<?php echo base_url('assets/images/user/'.$this->session->photo_thumb) ?>" class="user-image" alt="<?php echo $this->session->name ?>">
              <?php } ?>
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $this->session->name ?></span>
            </a>

            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
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
                  <small><b><?php echo $this->session->instansi_name ?> | <?php echo $this->session->cabang_name ?> | <?php echo $this->session->divisi_name ?></b></small>
                </p>
              </li>

              <li class="user-body">
                <div class="row" bis_skin_checked="1">
                  <div class="col-xs-6 text-center" bis_skin_checked="1">
                    <a href="<?php echo base_url('auth/update_profile/'.$this->session->id_users) ?>">Edit Profil</a>
                  </div>
                  <div class="col-xs-6 text-right" bis_skin_checked="1">
                    <a href="<?php echo base_url('auth/change_password') ?>">Ganti Password</a>
                  </div>                  
                </div>
                <!-- /.row -->
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">                
                <div class="pull-right">
                  <a href="<?php echo base_url('auth/logout') ?>" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- /.navbar-custom-menu -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</header>
