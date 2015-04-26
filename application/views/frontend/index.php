<!DOCTYPE html>
<html>
<head>
	<title>Article</title>
</head>
<body>

<?php 
	if (!empty($pages)) :
		foreach ($pages as $key => $value) :
			$this->load->view('frontend/'.$value);
		endforeach;
	endif;
?>

</body>
</html>