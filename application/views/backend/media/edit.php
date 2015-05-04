<div class="modal fade" id="edit-media" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form id="edit-form" action="<?php echo site_url('media/update/'); ?>" method="POST">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title">
						<span class="fa-stack">
							<i class="fa fa-circle fa-stack-2x text-blue"></i>
							<i class="fa fa-picture-o fa-stack-1x fa-inverse"></i>
						</span>
						Edit Media Details
					</h4>
				</div>

				<div class="modal-body">
					
					<div id="edit-preview" class="col-lg-5 col-md-5 col-sm-12"></div>

					<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">

						<div class="form-group">
							<label>Title <span class="sign-danger">*</span></label>
							<input name="title" type="text" class="form-control" placeholder="Enter title">
						</div>
					
						<div class="form-group">
							<label>Filename <span class="sign-danger">*</span></label>
							<div id="edit-filename" class="form-control readonly"></div>
						</div>
					
						<div class="form-group">
							<label>Description</label>
							<textarea name="description" class="form-control"></textarea>
						</div>
						
						<div class="row">

							<div class="col-lg-2">
								<div class="form-group">
									<label>Type <span class="sign-danger">*</span></label>
									<div id="edit-type" class="form-control readonly"></div>
									<input type="hidden" name="type">
								</div>
							</div>

							<div class="col-lg-5">
								<div class="form-group">
									<label>Updated <span class="sign-danger">*</span></label>
									<div id="edit-updated-by" class="form-control readonly"></div>
									<div id="edit-updated-time" class="form-control readonly"></div>
								</div>
							</div>

							<div class="col-lg-5">
								<div class="form-group">
									<label>Uploaded <span class="sign-danger">*</span></label>
									<div id="edit-created-by" class="form-control readonly"></div>
									<div id="edit-created-time" class="form-control readonly"></div>
								</div>
							</div>

						</div>
						
					</div>
				
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">
						<i class="fa fa-remove"></i>&nbsp; Close
					</button>
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-check-circle text-white"></i>&nbsp; Update
					</button>
				</div>

			</form>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>	