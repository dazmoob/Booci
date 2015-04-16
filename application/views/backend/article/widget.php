<div class="box box-primary">

	<div class="box-header with-border">
		<span class="fa-stack">
			<i class="fa fa-circle fa-stack-2x text-green"></i>
			<i class="fa fa-check-circle fa-stack-1x fa-inverse"></i>
		</span>
		<h3 class="box-title"> Submit</h3>
	</div><!-- /.box-header -->

	
	<div class="box-body">
    	<button type="submit" name="state" value="Publish" class="btn btn-primary btn-block bottom-sm">
    		<i class="fa fa-check-circle"></i>&nbsp; Publish
    	</button>
    	<div class="center bottom-sm">
          	<div class="btn-group">
				<button type="reset" class="btn btn-default btn-sm">
					<i class="fa fa-refresh"></i>&nbsp; Refresh
				</button>
				<a href="<?php echo site_url('article/all'); ?>" class="btn btn-default btn-sm">
					<i class="fa fa-remove"></i>&nbsp; Cancel
				</a>
				<button type="submit" name="state" value="Draft" class="btn btn-default btn-sm">
					<i class="fa fa-file-text-o"></i>&nbsp; Draft
				</button>
			</div>
		</div>
	</div>

</div><!-- /. box -->

<div class='box box-default collapsed-box'>

	<div class="box-header with-border">
		<span class="fa-stack">
			<i class="fa fa-circle fa-stack-2x text-green"></i>
			<i class="fa fa-tags fa-stack-1x fa-inverse"></i>
		</span>
		<h3 class="box-title"> Category</h3>
		<div class="pull-right box-tools">
        	<button class="btn btn-default btn-sm btn-white" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
        </div>
	</div>

    <div class='box-body pad'>

		<div class="bootstrap-timepicker">
            <div class="form-group bottom-sm">
            	<div class='input-group'>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-tags"></span>
                    </span>
			        <?php
			        	$attr = 'id="category" multiple="multiple" style="width:100%"';
			        	echo form_dropdown('category[]', $categories, '', $attr);
			        ?>
				</div>
            </div>
            <div class="form-group">
            	<label>Add Category</label>
            	<div class="input-group input-group-sm">
                    <input id="new-category" type="text" class="form-control">
                    <span class="input-group-btn">
                      	<button class="btn btn-info btn-flat" type="button">Add</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

<div class='box box-default collapsed-box'>

	<div class="box-header with-border">
		<span class="fa-stack">
			<i class="fa fa-circle fa-stack-2x text-green"></i>
			<i class="fa fa-calendar fa-stack-1x fa-inverse"></i>
		</span>
		<h3 class="box-title"> Schedule</h3>
		<div class="pull-right box-tools">
        	<button class="btn btn-default btn-sm btn-white" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
        </div>
	</div>

    <div class='box-body pad'>

		<div class="bootstrap-timepicker">
            <div class="form-group">
                <div class='input-group date' id='datetimepicker-article'>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    <input name="created_time" type='text' class="form-control" />
                </div>
            </div>
        </div>
    </div>

</div>

<div class='box box-default collapsed-box'>

	<div class="box-header with-border">
		<span class="fa-stack">
			<i class="fa fa-circle fa-stack-2x text-green"></i>
			<i class="fa fa-link fa-stack-1x fa-inverse"></i>
		</span>
		<h3 class="box-title"> Hyperlink</h3>
		<div class="pull-right box-tools">
        	<button class="btn btn-default btn-sm btn-white" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
        </div>
	</div>

    <div class='box-body pad'>

		<div class="bootstrap-timepicker">
            <div class="form-group">
                <div class='input-group'>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-link"></span>
                    </span>
                    <input name="slug" type='text' class="form-control" />
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class='box box-default collapsed-box'>

	<div class="box-header with-border">
		<span class="fa-stack">
			<i class="fa fa-circle fa-stack-2x text-green"></i>
			<i class="fa fa-picture-o fa-stack-1x fa-inverse"></i>
		</span>
		<h3 class="box-title"> Featured</h3>
		<div class="pull-right box-tools">
        	<button class="btn btn-default btn-sm btn-white" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
        </div>
	</div>

    <div class='box-body pad'>

		<div class="form-group center">

            <div class="featured-show"></div>

            <input id="featured-image" name="featured_image" type="hidden" value="">

            <a id="choose-featured" data-toggle="modal" data-target="#gallery" class="btn btn-sm btn-primary show-gallery">
            	<i class="fa fa-camera"></i>&nbsp; Choose Image
            </a>

            <a id="remove-featured" class="btn btn-sm btn-danger remove-gallery hide">
            	<i class="fa fa-remove"></i>&nbsp; Remove
            </a>

        </div>

    </div>
    
</div>