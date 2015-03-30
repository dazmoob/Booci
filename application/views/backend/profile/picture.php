<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">

	<!-- general form elements -->
	<div class="box box-primary">
		<div class="box-header">
			<span class="fa-stack-lg">
				<i class="fa fa-circle fa-stack-3x text-red"></i>
				<i class="fa fa-photo fa-stack-1-5x top-middle fa-inverse"></i>
			</span>
			<div class="box-title">

				<?php if (!empty($this->uri->segment(3)) && $this->uri->segment(3) == 'edit') : ?>
					<h3>Change Profile Picture</h3>
					<h5>This is showtime !</h5>
				<?php else : ?>
					<h3>Profile Picture</h3>
					<h5>This is showtime !</h5>
				<?php endif; ?>

			</div>
		</div><!-- /.box-header -->

		<div class="divide-line"></div>
	
		<!-- form start -->

		<?php if (!empty($this->uri->segment(3)) && $this->uri->segment(3) == 'edit') : ?>

			<div class="row">
				<div id="show-picture" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile-picture">
					<img id="picture" src="<?php echo site_url(set_value('picture_path')); ?>" class="img-circle img-border profile-picture" alt="User Image">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile-picture">
						<button id="change-picture" class="btn btn-success btn-sm">
							<i class="fa fa-camera"></i>&nbsp; Change Picture
						</button>
					</div>
				</div>

				<div id="upload-picture" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile-picture">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<p class="upload-notes">
							Max. image size <b>100 kB</b> (160x160)
						</p>
		                <input name="userfile" id="profile-picture" type="file" class="file">
		            </div>
		            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile-picture">
						<button id="cancel-upload" class="btn btn-default btn-sm">
							<i class="fa fa-remove"></i>&nbsp; Cancel
						</button>
					</div>
	            </div>
			</div>

		<?php else : ?>

			<div class="row">
				<div id="show-picture" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile-picture user-description">
					<img id="picture" src="<?php echo site_url(set_value('picture_path')); ?>" class="img-circle img-border profile-picture" alt="User Image">

					<p>
						<?php echo set_value('name'); ?> - 
						<?php
							$level = $this->level;
							echo $level[set_value('level')];
						?>
						<small>
							Member since. <?php echo date('d F Y', strtotime(set_value('created_time'))); ?> 
						</small>
					</p>

					<div class="row user-submenu">
						<div class="col-xs-4 text-center">
							<a href="#">Articles</a>
						</div>
						<div class="col-xs-4 text-center">
							<a href="#">Sales</a>
						</div>
						<div class="col-xs-4 text-center">
							<a href="#">Friends</a>
						</div>
					</div>
				</div>
			</div>

		<?php endif; ?>
	</div><!-- /.box -->

</div>	