<!DOCTYPE html>
<html>
<head>

	<!-- Page title -->
	<meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<title><?php echo $this->basic['title']; ?></title>

	<?php $this->load->view('backend/common/css'); ?>

</head>
<body class="skin-blue">

	<div class="wrapper">

		<?php echo $this->load->view('backend/common/header'); ?>

		<?php echo $this->load->view('backend/common/sidebar'); ?>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<?php echo $this->load->view('backend/common/content-header'); ?>
			</section>

			<!-- Main content -->
			<section class="content">

				<div class="row">

				<!-- Render Pages -->
					Error
				<!-- / Render Pages -->

				</div>
				
			</section><!-- /.content -->
		</div><!-- /.content-wrapper -->

		<!-- Main Footer -->
		<footer class="main-footer">
			<!-- To the right -->
			<div class="pull-right hidden-xs">
				Anything you want
			</div>
			<!-- Default to the left --> 
			<strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.
		</footer>

	</div>

	<?php $this->load->view('backend/common/js'); ?>

</body>
</html>