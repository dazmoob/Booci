<div class="box box-solid">
	<div class="box-body no-padding">

		<ul class="nav nav-pills nav-stacked">
			<li id="image">
				<a href="<?php echo site_url('media/image'); ?>">
					<i class="fa fa-photo"></i> Images
					<span class="label label-success pull-right">
						<?php echo (!empty($count['image'])) ? $count['image'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="file">
				<a href="<?php echo site_url('media/file'); ?>">
					<i class="fa fa-file"></i> Files
					<span class="label label-warning pull-right">
						<?php echo (!empty($count['file'])) ? $count['file'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="audio">
				<a href="<?php echo site_url('media/audio'); ?>">
					<i class="fa fa-music"></i> Audio
					<span class="label label-warning pull-right">
						<?php echo (!empty($count['audio'])) ? $count['audio'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="video">
				<a href="<?php echo site_url('media/video'); ?>">
					<i class="fa fa-video-camera"></i> Video
					<span class="label label-warning pull-right">
						<?php echo (!empty($count['video'])) ? $count['video'] : 0;	?>
					</span>
				</a>
			</li>
		</ul>
	</div><!-- /.box-body -->
</div><!-- /. box -->		