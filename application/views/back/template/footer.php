  <footer class="main-footer">
    <?php echo $footer->content ?>
  </footer>

  <!-- jQuery 3 -->
  <script src="<?php echo base_url('assets/plugins/') ?>jquery/dist/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url('assets/plugins/') ?>jquery-ui/jquery-ui.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url('assets/plugins/') ?>bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Slimscroll -->
  <script src="<?php echo base_url('assets/plugins/') ?>jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url('assets/plugins/') ?>fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url('assets/template/back/') ?>dist/js/adminlte.min.js"></script>
  <!-- SweetAlert -->
  <script src="<?php echo base_url('assets/plugins/') ?>sweetalert/js/sweetalert2.all.min.js"></script>

  <script type="text/javascript">
    const flashData = $('.flash-data').data('flashdata');
    if (flashData === 'Sukses') {
      Swal.fire({
        title: flashData,
        text: 'Data berhasil disimpan',
        icon: 'success',
        showClass: {
          popup: 'animate__animated animate__bounce'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
      });
    } else if (flashData === 'dihapus') {
      Swal.fire({
        title: 'Sukses',
        text: 'Data berhasil ' + flashData,
        icon: 'success',
        showClass: {
          popup: 'animate__animated animate__tada'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
      });
    } else if (flashData === 'tidak ditemukan') {
      Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        text: 'Data ' + flashData + '!',
        showClass: {
          popup: 'animate__animated animate__tada'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
      });
    } else if (flashData === 'tidak memiliki akses') {
      Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        text: 'Anda ' + flashData + ' ke halaman tersebut!',
        showClass: {
          popup: 'animate__animated animate__tada'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
      });
    } else if (flashData === 'dikembalikan') {
      Swal.fire({
        title: 'Sukses',
        text: 'Data berhasil ' + flashData,
        icon: 'success',
        showClass: {
          popup: 'animate__animated animate__bounce'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
      });
    } else if (flashData === 'diaktifkan') {
      Swal.fire({
        title: 'Sukses',
        text: 'Akun berhasil ' + flashData,
        icon: 'success',
        showClass: {
          popup: 'animate__animated animate__bounce'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
      });
    } else if (flashData === 'dinonaktifkan') {
      Swal.fire({
        title: 'Sukses',
        text: 'Akun berhasil ' + flashData,
        icon: 'success',
        showClass: {
          popup: 'animate__animated animate__bounce'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
      });
    } else if (flashData === 'no HP/Telephone salah') {
      Swal.fire({
        title: 'Terjadi Kesalahan',
        text: 'Format penulisan ' + flashData,
        icon: 'error',
        showClass: {
          popup: 'animate__animated animate__tada'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
      });
    }

    $(document).on('click', '#delete-button', function(e) {
      e.preventDefault();
      const link = $(this).attr('href');

      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00a65a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location = link;
        }
      })
    });

    $(document).on('click', '#delete-button-permanent', function(e) {
      e.preventDefault();
      const link = $(this).attr('href');

      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00a65a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location = link;
        }
      })
    });

    $(document).on('click', '#deactive-button', function(e) {
      e.preventDefault();
      const link = $(this).attr('href');

      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Akun akan dinonaktifkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00a65a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, nonaktifkan!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location = link;
        }
      })
    });
  </script>