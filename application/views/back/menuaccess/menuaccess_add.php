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
      <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>

      <?php echo form_open($action) ?>
      <?php echo validation_errors() ?>
        <div class="box box-primary">
          <div class="box-body">
            <div class="form-group"><label>Usertype</label>
              <?php echo form_dropdown('', $get_all_combobox_usertype, '', $usertype_id) ?>
            </div>
            <div class="form-group"><label>Menu</label>
              <?php echo form_dropdown('', $get_all_combobox_menu, '', $menu_id) ?>
            </div>
            <div class="form-group"><label>SubMenu</label>
              <?php echo form_dropdown('', array(''=>'- Choose Menu First -'), '', $submenu_id) ?>
            </div>
          </div>
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
  <script type="text/javascript">
    function showSubmenu()
    {
      menu_id = document.getElementById("menu_id").value;
      $.ajax({
        url: "<?php echo base_url() ?>admin/submenu/choose_submenu/"+menu_id+"",
        success: function(response){
          $("#submenu_id").html(response);
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
