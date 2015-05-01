<div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">

	<!-- general form elements -->
	<div class="box box-primary">

		<div class="box-header">
			<span class="fa-stack-lg">
				<i class="fa fa-circle fa-stack-3x text-red"></i>
				<i class="fa fa-user fa-stack-1-5x top-middle fa-inverse"></i>
			</span>
			<div class="box-title"> 
				<h3><?php echo $user->name; ?></h3>
				<h5><a href="<?php echo site_url('profile/'.$user->username); ?>"><?php echo $user->username; ?></a></h5>
			</div>
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
							<label>Email address <span class="sign-danger">*</span></label>
							<div class="form-control readonly">
								<?php echo $user->email; ?>
							</div>
						</div>
						<div class="form-group">
							<label>Name <span class="sign-danger">*</span></label>
							<div class="form-control readonly">
								<?php echo $user->name; ?>
							</div>
						</div>
						<div class="form-group">
							<label>Level</label>
							<div class="form-control readonly">
								<?php 
									$level = $this->level;
									echo ucwords(str_replace('_', ' ', $level[$user->level])); 
								?>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Website</label>
							<div class="form-control readonly">
								<?php echo $user->website; ?>
							</div>
						</div>
						<div class="form-group">
							<label>Facebook</label>
							<div class="form-control readonly">
								<?php echo $user->facebook; ?>
							</div>
						</div>
						<div class="form-group">
							<label>Twitter</label>
							<div class="form-control readonly">
								<?php echo $user->twitter; ?>
							</div>
						</div>
						<div class="form-group">
							<label>Google</label>
							<div class="form-control readonly">
								<?php echo $user->google; ?>
							</div>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div>
		</form>
	</div><!-- /.box -->

</div>		