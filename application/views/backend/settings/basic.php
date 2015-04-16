<?php
	$attributes = array('id' => 'basic-settings-form');
	echo form_open('settings/updateBasic', $attributes);
?>

<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-primary">

				<div class="box-header">
					<span class="fa-stack">
						<i class="fa fa-circle fa-stack-2x text-blue"></i>
						<i class="fa fa-globe fa-stack-1x fa-inverse"></i>
					</span>
					<h3 class="box-title"> Basic Info</h3>
				</div><!-- /.box-header -->

				<div class="divide-line"></div>
			
				<div class="box-body">

					<div class="form-group">
						<label>Website Name <span class="sign-danger">*</span></label>
						<input required name="name" type="text" class="form-control" placeholder="Enter name" value="<?php echo set_value('name'); ?>">
					</div>

					<div class="form-group">
						<label>Website Title <span class="sign-danger">*</span></label>
						<input required name="title" type="text" class="form-control" placeholder="Enter title" value="<?php echo set_value('title'); ?>">
					</div>

					<div class="form-group">
						<label>Domain <span class="sign-danger">*</span></label>
						<input required name="domain" type="url" class="form-control" placeholder="Enter domain" value="<?php echo set_value('domain'); ?>">
					</div>

		        </div><!-- /.box-body -->

		    </div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-primary">

				<div class="box-header">
					<span class="fa-stack">
						<i class="fa fa-circle fa-stack-2x text-blue"></i>
						<i class="fa fa-globe fa-stack-1x fa-inverse"></i>
					</span>
					<h3 class="box-title"> Profile Info</h3>
				</div><!-- /.box-header -->

				<div class="divide-line"></div>
			
				<div class="box-body">

					<div class="form-group">
						<label>Creator <span class="sign-danger">*</span></label>
						<input required name="creator" type="text" class="form-control" placeholder="Enter creator name" value="<?php echo set_value('creator'); ?>">
					</div>

					<div class="bootstrap-timepicker">
			            <div class="form-group">
							<label>Created Time <span class="sign-danger">*</span></label>
			                <div class='input-group date' id='datetimepicker-basic'>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                    <input name="created" type='text' class="form-control" value="<?php echo set_value('created'); ?>" />
			                </div>
			            </div>
			        </div>

			        <div class="divide-line"></div>

			        <?php if (in_array('vm_admlog', $this->useraccess)) : ?>
						<div class="form-group">
							<label>Admin Log <span class="sign-danger">*</span></label>
							<input required name="adm_log" type="url" class="form-control" placeholder="Enter administrator log" value="<?php echo set_value('adm_log'); ?>">
						</div>
					<?php endif; ?>

		        </div><!-- /.box-body -->

		    </div>
		</div>
	</div>

</div>

<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

	<div class="box box-primary">

		<div class="box-header">
			<span class="fa-stack">
				<i class="fa fa-circle fa-stack-2x text-blue"></i>
				<i class="fa fa-globe fa-stack-1x fa-inverse"></i>
			</span>
			<h3 class="box-title"> Metadata Info</h3>
		</div><!-- /.box-header -->

		<div class="divide-line"></div>
	
		<div class="box-body">

			<div class="form-group">
              	<label>Description</label>
              	<textarea name="description" class="textarea form-control" placeholder="Enter description ..." style="width: 100%; height: 100px"><?php echo set_value('description') ?></textarea>
            </div>

            <div class="form-group">
              	<label>Keyword</label>
              	<textarea name="keyword" class="textarea form-control" placeholder="Enter text ..." style="width: 100%; height: 100px"><?php echo set_value('keyword') ?></textarea>
            </div>

        </div><!-- /.box-body -->

    </div>

    <button type="submit" class="col-lg-12 btn btn-primary">
    	<i class="fa fa-check-circle"></i>&nbsp; Update
    </button>

</div>

<?php
	echo form_close();
?>