<div class="modal fade" id="edit-slideshow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form id="edit-form" action="<?php echo site_url('slideshow/updateSlideshow/'); ?>" method="POST">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title">
						<span class="fa-stack">
							<i class="fa fa-circle fa-stack-2x text-blue"></i>
							<i class="fa fa-picture-o fa-stack-1x fa-inverse"></i>
						</span>
						Edit Slideshow Details
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
							<label>Subtitle <span class="sign-danger">*</span></label>
							<input name="subtitle" type="text" class="form-control" placeholder="Enter subtitle">
						</div>
					
						<div class="form-group">
							<label>Label <span class="sign-danger">*</span></label>
							<input name="label" type="text" class="form-control" placeholder="Enter label">
						</div>

						<div class="form-group">
							<label>URL <span class="sign-danger">*</span></label>
							<input name="url" type="url" class="form-control" placeholder="Enter url">
						</div>
					
						<div class="form-group">
							<label>Description</label>
							<textarea name="description" class="form-control"></textarea>
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