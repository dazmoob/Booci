<!-- CSS Style -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/AdminLTE.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/skins/skin-blue.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/booci.css'); ?>">

<!-- Additional CSS -->

<!-- CSS Controller -->
<?php if (!empty($this->uri->segment(1))) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/controllers/'.$this->uri->segment(1).'.css'); ?>">
<?php endif; ?>