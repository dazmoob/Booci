<!DOCTYPE html>
<html>
<head>

	<!-- Page title -->
	<meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<title><?php echo $this->basic['title']; ?></title>

	<?php $this->load->view('backend/common/css'); ?>

</head>
<body class="login-page">

	<!-- Render Pages -->

	<?php 
		if (!empty($pages)) :
			foreach ($pages as $key => $value) :
				$this->load->view('userpage/'.$value);
			endforeach;
		endif;
	?>

	<!-- / Render Pages -->

	<?php $this->load->view('backend/common/js'); ?>

</body>
</html>