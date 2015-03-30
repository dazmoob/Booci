<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">

	<!-- general form elements -->
	<div class="box box-primary">

		<div class="box-header">
			<span class="fa-stack">
				<i class="fa fa-circle fa-stack-2x text-green"></i>
				<i class="fa fa-plus fa-stack-1x fa-inverse"></i>
			</span>
			<h3 class="box-title"> Create New User</h3>
		</div><!-- /.box-header -->

		<div class="divide-line"></div>
	
		<!-- form start -->
		<?php
			$attributes = array('id' => 'user-add-form');
			echo form_open('user/create', $attributes);
		?>
			<div class="row">
				<div class="box-body">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Username <span class="sign-danger">*</span></label>
							<input name="username" type="text" class="form-control" placeholder="Enter username">
						</div>
						<div class="form-group">
							<label>Email address <span class="sign-danger">*</span></label>
							<input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
						</div>
						<div class="form-group">
							<label>Name <span class="sign-danger">*</span></label>
							<input name="name" type="text" class="form-control" placeholder="Enter name">
						</div>
						<div class="form-group">
							<label>Level <span class="sign-danger">*</span></label>
							<?php
								$attr = 'id="choose-level" class="form-control"';
								$options = $this->ci->user_model->level;
								echo form_dropdown('level', $options, set_value('level'), $attr);
							?>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Website</label>
							<input name="website" type="url" class="form-control" placeholder="Enter URL">
						</div>
						<div class="form-group">
							<label>Facebook</label>
							<input name="facebook" type="url" class="form-control" placeholder="Enter Facebook profil URL">
						</div>
						<div class="form-group">
							<label>Twitter</label>
							<input name="twitter" type="url" class="form-control" placeholder="Enter Twitter profile URL">
						</div>
						<div class="form-group">
							<label>Google</label>
							<input name="google" type="url" class="form-control" placeholder="Enter Google profile URL">
						</div>
					</div>
				</div><!-- /.box-body -->
			</div>
			<div class="box-footer">
				<div class="row">
					<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Password <span class="sign-danger">*</span></label>
							<input name="password" type="password" class="form-control" placeholder="Password">
						</div>
					</div>
					<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Retype Password <span class="sign-danger">*</span></label>
							<input name="retype_password" type="password" class="form-control"placeholder="Retype Password">
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div><!-- /.box -->

</div>	