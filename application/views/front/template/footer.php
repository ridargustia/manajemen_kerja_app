  <footer class="main-footer">
    <div class="container">
			<?php echo $footer->content ?>
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<a id="back-to-top" href="#" class="btn btn-lg bg-purple back-to-top" role="button"><i class="fa fa-arrow-up"></i></a>

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

<script type="text/javascript">
$(document).ready(function(){
	$(window).scroll(function () {
			if ($(this).scrollTop() > 50) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		// scroll body to 0px on click
		$('#back-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
});
</script>
