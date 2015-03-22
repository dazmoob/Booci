<!-- Javascript Settings -->
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/app.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/booci.js') ?>"></script>

<!-- Additional Javascript -->

<!-- Javascript Controller -->
<?php if (!empty($this->uri->segment(1))) : ?>
	<script type="text/javascript" src="<?php echo site_url('assets/controllers/'.$this->uri->segment(1).'.js'); ?>"></script>
<?php endif; ?>