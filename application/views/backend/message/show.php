<div class="modal fade" id="show-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form id="show-form" action="<?php echo site_url('message/update/'); ?>" method="POST">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title">
						<span class="fa-stack">
							<i class="fa fa-circle fa-stack-2x text-blue"></i>
							<i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
						</span>
						Message Details
					</h4>
				</div>

				<div class="modal-body">

					<div class="row">
					
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

							<div class="form-group">
								<label>Sender</label>
								<div id="show-name" class="form-control readonly"></div>
							</div>

							<div class="form-group">
								<label>Email</label>
								<div id="show-email" class="form-control readonly"></div>
							</div>

							<div class="form-group">
								<label>URL</label>
								<div id="show-url" class="form-control readonly"></div>
							</div>

							<div class="form-group">
								<label>Type</label>
								<div id="show-type" class="form-control readonly"></div>
							</div>

						</div>

						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

							<div class="form-group">
								<label>Title</label>
								<div id="show-title" class="form-control readonly"></div>
							</div>
						
							<div class="form-group">
								<label>Time</label>
								<div id="show-created-time" class="form-control readonly"></div>
							</div>
						
							<div class="form-group">
								<label>Content</label>
								<div id="show-content" class="form-control readonly"></div>
							</div>
							
						</div>

					</div>
				
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">
						<i class="fa fa-remove"></i>&nbsp; Close
					</button>
					<button id="show-solve" type="submit" name="solve" class="btn btn-primary">
						<i class="fa fa-check-circle text-white"></i>&nbsp; Solve
					</button>
				</div>

			</form>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>	