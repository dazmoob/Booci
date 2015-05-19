<div class="box box-solid">
	<div class="box-body no-padding">

		<ul class="nav nav-pills nav-stacked">

		<?php

		if (!empty($slideshow_types)) :

			foreach ($slideshow_types as $slideshow) :

		?>

			<li>
				<a href="<?php echo site_url('slideshow/'.$slideshow->slug.'/edit'); ?>">
					<?php echo $slideshow->name; ?>
				</a>
			</li>

		<?php

			endforeach;

		endif;

		?>

		</ul>

	</div>
</div>	