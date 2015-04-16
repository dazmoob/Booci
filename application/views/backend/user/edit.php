<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">

	<!-- general form elements -->
	<div class="box box-primary">

		<div class="box-header">
			<span class="fa-stack">
				<i class="fa fa-circle fa-stack-2x text-green"></i>
				<i class="fa fa-plus fa-stack-1x fa-inverse"></i>
			</span>
			<h3 class="box-title"> Edit <?php echo $user->username; ?> Data</h3>
		</div><!-- /.box-header -->

		<div class="divide-line"></div>
	
		<!-- form start -->
		<?php
			$attributes = array('id' => 'user-add-form');
			echo form_open('user/update/'.$user->username, $attributes);
		?>
			<div class="row">
				<div class="box-body">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Name <span class="sign-danger">*</span></label>
							<input name="name" type="text" class="form-control" placeholder="Enter name" value="<?php echo $user->name; ?>">
						</div>
						<div class="form-group">
							<label>Website</label>
							<input name="website" type="url" class="form-control" placeholder="Enter URL" value="<?php echo $user->website; ?>">
						</div>
						<div class="form-group">
							<label>Facebook</label>
							<input name="facebook" type="url" class="form-control" placeholder="Enter Facebook profil URL" value="<?php echo $user->facebook; ?>">
						</div>
						
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Twitter</label>
							<input name="twitter" type="url" class="form-control" placeholder="Enter Twitter profile URL" value="<?php echo $user->twitter; ?>">
						</div>
						<div class="form-group">
							<label>Google</label>
							<input name="google" type="url" class="form-control" placeholder="Enter Google profile URL" value="<?php echo $user->google; ?>">
						</div>
					</div>
				</div><!-- /.box-body -->
			</div>
			<div class="box-footer">
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
						<div class="pull-right">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-edit text-white"></i> &nbsp;Update
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div><!-- /.box -->

</div>		