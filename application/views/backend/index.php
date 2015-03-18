<!DOCTYPE html>
<html>
<head>

	<!-- Page title -->
	<title><?php echo $this->basic['title']; ?></title>

	<!-- CSS Style -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/booci.css'); ?>">

	<!-- Additional CSS -->

	<!-- CSS Controller -->
	<?php if (!empty($this->uri->segment(1))) : ?>
		<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/controllers/'.$this->uri->segment(1).'.css'); ?>">
	<?php endif; ?>

</head>
<body>

	

	<!-- Javascript Settings -->
	<script type="text/javascript" src="<?php echo site_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo site_url('assets/js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo site_url('assets/js/booci.js') ?>"></script>
	
	<!-- Additional Javascript -->

	<!-- Javascript Controller -->
	<?php if (!empty($this->uri->segment(1))) : ?>
		<script type="text/javascript" src="<?php echo site_url('assets/controllers/'.$this->uri->segment(1).'.js'); ?>"></script>
	<?php endif; ?>

</body>
</html>