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

				<?php 
					if (!empty($pages)) :
						foreach ($pages as $key => $value) :
							$this->load->view('backend/'.$value);
						endforeach;
					endif;
				?>

				<!-- / Render Pages -->

				</div>
				
			</section><!-- /.content -->
		</div><!-- /.content-wrapper -->

		<?php $this->load->view('backend/common/footer'); ?>

	</div>

	<?php $this->load->view('backend/common/js'); ?>

</body>
</html>