<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">

	<!-- general form elements -->
	<div class="box box-primary">

		<div class="box-header">
			<span class="fa-stack-lg">
				<i class="fa fa-circle fa-stack-3x text-red"></i>
				<i class="fa fa-user fa-stack-1-5x top-middle fa-inverse"></i>
			</span>
			<div class="box-title"> 
				<h3><?php echo set_value('name'); ?></h3>
				<h5><a href="<?php echo site_url('profile/'.set_value('username')); ?>"><?php echo set_value('username'); ?></a></h5>
			</div>
		</div><!-- /.box-header -->

		<div class="divide-line"></div>
	
		<!-- form start -->
		<?php
			$attributes = array('id' => 'user-add-form');
			echo form_open('profile/update/'.$this->userdata->username, $attributes);
		?>
			<div class="row">
				<div class="box-body">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Email address <span class="sign-danger">*</span></label>
							<div class="form-control readonly">
								<?php echo set_value('email'); ?>
							</div>
						</div>
						<div class="form-group">
							<label>Name <span class="sign-danger">*</span></label>
							<input name="name" type="text" class="form-control" placeholder="Enter name" value="<?php echo set_value('name'); ?>">
						</div>
						<div class="form-group">
							<label>Website</label>
							<input name="website" type="url" class="form-control" placeholder="Enter URL" value="<?php echo set_value('website'); ?>">
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Facebook</label>
							<input name="facebook" type="url" class="form-control" placeholder="Enter Facebook profil URL" value="<?php echo set_value('facebook'); ?>">
						</div>
						<div class="form-group">
							<label>Twitter</label>
							<input name="twitter" type="url" class="form-control" placeholder="Enter Twitter profile URL" value="<?php echo set_value('twitter'); ?>">
						</div>
						<div class="form-group">
							<label>Google</label>
							<input name="google" type="url" class="form-control" placeholder="Enter Google profile URL" value="<?php echo set_value('google'); ?>">
						</div>
					</div>
				</div><!-- /.box-body -->
			</div>
			<div class="box-footer">
				<div class="row">
					<div class="col-md-offset-6 col-lg-offset-6 col-sm-offset-6 col-md-4 col-lg-4 col-sm-4 col-xs-12">
						<div class="form-group">
							<label>Type Password before update <span class="sign-danger">*</span></label>
							<input required name="password" type="password" class="form-control" placeholder="Password">
						</div>
					</div>
					<div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
						<div class="form-group">
							<button type="submit" class="btn btn-success btn-label">
								<i class="fa fa-check-circle text-white"></i> &nbsp;Update
							</button>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<a data-toggle="modal" data-target="#change-password" class="clicked">Want to change password?</a>
					</div>
				</div>
			</div>
		</form>
	</div><!-- /.box -->

</div>	