<?php
	
	if (!empty($this->header)) :
		$header = $this->header;
	else :
		$header['title'] = 'Booci';
		$header['description'] = 'Welcome to Booci';
	endif;

	if (!empty($this->breadcrumb)) :
		$breadcrumb = $this->breadcrumb;
	else :
		$breadcrumb['one_link'] = site_url('dashboard');
		$breadcrumb['icon'] = 'dashboard';
		$breadcrumb['one'] = 'Dashboard';
	endif;

?>

<h1>
	<?php echo $header['title']; ?>
	<small><?php echo $header['description']; ?></small>
</h1>

<?php if (!empty($breadcrumb)) : ?>
	<ol class="breadcrumb">

		<!-- First breadcrumb -->
		<li>
			<a href="<?php echo $breadcrumb['one_link']; ?>">
				<i class="fa fa-<?php echo $breadcrumb['icon']; ?>"></i> 
				 <?php echo $breadcrumb['one']; ?>
			</a>
		</li>

		<!-- Second breadcrumb -->
		<?php if (!empty($breadcrumb['three'])) : ?>
			<li>
				<a href="<?php echo $breadcrumb['two_link']; ?>">
					<?php echo $breadcrumb['two']; ?>
				</a>
			</li>
		<?php elseif (!empty($breadcrumb['two'])) : ?>
			<li class="active"><?php echo $breadcrumb['two']; ?></li>
		<?php endif; ?>

		<!-- Third breadcrumb -->
		<?php if (!empty($breadcrumb['three'])) : ?>
			<li class="active"><?php echo $breadcrumb['three']; ?></li>
		<?php endif; ?>

	</ol>
<?php endif; ?>