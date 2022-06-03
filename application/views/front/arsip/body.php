<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Hasil Pencarian</title>
  </head>
  <body>
    <?php
    if($hasil_pencarian == NULL)
    {
      echo "Pencarian tidak ditemukan";
    }
    else{
      foreach($hasil_pencarian as $hasil){ ?>
        <?php echo $hasil->arsip_name ?>
    <?php }} ?>

  </body>
</html>
