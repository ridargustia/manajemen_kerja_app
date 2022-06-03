<div class="row">

  <div class="col-lg-12">
    <?php echo form_open('arsip/cari_arsip', array("method" => "get")) ?>
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">
          <?php if (is_grandadmin()) {
            echo "Instansi";
          } elseif (is_masteradmin()) {
            echo "Cabang";
          } else {
            echo "Divisi";
          } ?>
        </h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <?php
        if (is_grandadmin()) {
          foreach ($get_all_instansi as $instansi) {
        ?>
            <div class="pretty p-icon p-smooth">
              <input type="radio" name="instansi_id" value="<?php echo $instansi->id_instansi ?>" />
              <div class="state p-success">
                <i class="icon fa fa-check"></i>
                <label><?php echo $instansi->instansi_name ?></label>
              </div>
            </div>
          <?php }
        } elseif (is_masteradmin()) {
          foreach ($get_all_cabang as $cabang) {
          ?>
            <div class="pretty p-icon p-smooth">
              <input type="radio" name="cabang_id" value="<?php echo $cabang->id_cabang ?>" />
              <div class="state p-success">
                <i class="icon fa fa-check"></i>
                <label><?php echo $cabang->cabang_name ?></label>
              </div>
            </div>
            <?php }
        } else {
          if ($get_all_divisi == NULL) {
            echo "Silahkan input divisi terlebih dahulu melalui SUPERADMIN";
          } else {
            foreach ($get_all_divisi as $divisi) {
            ?>
              <div class="pretty p-icon p-smooth">
                <input type="radio" name="divisi_id" value="<?php echo $divisi->id_divisi ?>" />
                <div class="state p-success">
                  <i class="icon fa fa-check"></i>
                  <label><?php echo $divisi->divisi_name ?></label>
                </div>
              </div>
        <?php }
          }
        } ?>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>

  <div class="col-lg-12">
    <div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Cari Arsip</h3>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="input-group">
          <input type="text" name="search_form" placeholder="Isikan Keywords ..." class="form-control">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Cari Arsip</button>
          </span>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <?php echo form_close() ?>
  </div>
</div>