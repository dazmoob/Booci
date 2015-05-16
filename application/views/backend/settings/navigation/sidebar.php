<div class="box box-solid">
	<div class="box-body no-padding">

		<ul class="nav nav-pills nav-stacked">

		<?php

		if (!empty($navigations)) :

			foreach ($navigations as $navigation) :

		?>

			<li>
				<a href="<?php echo site_url('settings/editNavigation/'.$navigation->slug); ?>">
					<?php echo $navigation->name; ?>
				</a>
			</li>

		<?php

			endforeach;

		endif;

		?>

		</ul>

	</div>
</div>	