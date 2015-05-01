<div class="modal fade" id="change-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">
					<span class="fa-stack">
						<i class="fa fa-circle fa-stack-2x text-red"></i>
						<i class="fa fa-lock fa-stack-1x fa-inverse"></i>
					</span>
					Change Password
				</h4>
			</div>
			<form method="post" action="<?php echo site_url('profile/changePassword'); ?>">
			<div class="modal-body">
				<p>Please fill all this form</p>
				<div class="form-group">
					<label>Old Password <span class="sign-danger">*</span></label>
					<input required name="password" type="password" class="form-control" placeholder="Old Password">
				</div>
				<div class="divide-line"></div>
				<div class="form-group">
					<label>New Password <span class="sign-danger">*</span></label>
					<input required name="new_password" type="password" class="form-control" placeholder="New Password">
				</div>
				<div class="form-group">
					<label>Retype New Password <span class="sign-danger">*</span></label>
					<input required name="retype_password" type="password" class="form-control" placeholder="Retype New Password">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">
					<i class="fa fa-remove"></i>&nbsp; Close
				</button>
				<button type="submit" class="btn btn-primary">
					<i class="fa fa-check-circle text-white"></i>&nbsp; Update Password
				</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>