<html>
  <head>
    <title>Hasil Pencarian | ARSIP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="<?php echo base_url('assets/template/front/') ?>css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url('assets/template/front/') ?>css/custom.css" rel="stylesheet" />
    <script src="<?php echo base_url('assets/plugins/') ?>jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/template/front/') ?>js/bootstrap.min.js"></script>
  </head>
  <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light static-top mb-5 shadow">
      <div class="container">
        <a class="navbar-brand" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home
                    <span class="sr-only">(current)</span>
                  </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
      <div class="card">
        <div class="card-body">
          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
              <input type="radio" name="options" id="option1" checked> Semua
            </label>
            <?php foreach($get_all_kategori as $kategori){ ?>
              <label class="btn btn-secondary">
                <input type="radio" name="kategori_arsip"> <?php echo $kategori->kategori_name ?>
              </label>
            <?php } ?>
          </div>
          <hr>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
            </div>
          </div>
        </div>
      </div>

      <div class="card my-3">
        <div class="card-body">
          <div class="card">
            <div class="row no-gutters">
              <div class="col-md-2">
                <img src="..." class="card-img" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </body>
</html>
