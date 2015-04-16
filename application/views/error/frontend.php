<!DOCTYPE html>
<html>
<head>

	<!-- Page title -->
	<meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<title><?php echo $title; ?></title>

	<?php $this->load->view('frontend/common/css'); ?>

	<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/controllers/error.css'); ?>">

</head>
<body>

	<div class="col-lg-offset-3 col-lg-6">
		<div class="wrapper">
			<div class="col-lg-offset-2 col-lg-3">
				<h1><i class="fa fa-rocket"></i></h1>
			</div>
			<div class="col-lg-5">
				<h1><span class="text-underline"><?php echo $type; ?></span></h1>
				<h2><?php echo $title; ?></h2>
			</div>
			<div class="col-lg-12">
				<p class="message"><?php echo $message; ?></p>
				<p><?php echo $notes; ?></p>
			</div>
		</div>
	</div>

	<?php $this->load->view('backend/common/js'); ?>

</body>	