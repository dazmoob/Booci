<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="row">

    	<div class="col-md-2 col-lg-2 col-sm-4 col-xs-12">
    		<a href="<?php echo site_url('article/list'); ?>" class="btn btn-primary btn-block margin-bottom">Article List</a>

            <?php $this->load->view('backend/article/sidebar'); ?>

    	</div><!-- /.col -->

    	<form method="POST" action="<?php echo site_url('article/create'); ?>">

    	<div class="col-md-7 col-lg-7 col-sm-8 col-xs-12">
    		<div class="box box-primary">

    			<div class="box-header with-border">
    				<span class="fa-stack">
						<i class="fa fa-circle fa-stack-2x text-green"></i>
						<i class="fa fa-plus fa-stack-1x fa-inverse"></i>
					</span>
					<h3 class="box-title"> Compose New Article</h3>
    			</div><!-- /.box-header -->

    			
	    		<div class="box-body">
    				<div class="form-group">
                      	<label>Title</label>
                      	<input name="title" type="text" class="form-control" placeholder="Enter title ...">
                    </div>
                    <div class="form-group">
                      	<label>Content</label>
                      	<textarea name="content" class="textarea form-control" placeholder="Enter text ..." style="width: 100%; height: 200px"></textarea>
                    </div>
	    		</div>

    		</div><!-- /. box -->
    	</div><!-- /.col -->

    	<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">

            <?php $this->load->view('backend/article/widget'); ?>

    	</div><!-- /.col -->

    	<div class="col-md-offset-2 col-lg-offset-2 col-sm-offset-4 col-md-10 col-lg-10 col-sm-8 col-xs-12">
    		<div class='box'>
                <div class='box-header'>
                  	<h3 class='box-title'>
                  		SEO and UI Section
                  	</h3>
                  	
                  	<!-- tools box -->
                  	<div class="pull-right box-tools">
                    	<button class="btn btn-default btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
	                </div><!-- /. tools -->
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                	<div class="row">
	                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
	                    	<div class="form-group">
			                    <label>Excerpt</label>
		                    	<textarea name="excerpt" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
		                    </div>
	                    </div>
	                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
	                    	<div class="form-group">
			                    <label>Description</label>
		                    	<textarea name="description" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
		                    </div>
	                    </div>
	                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
	                    	<div class="form-group">
			                    <label>Keyword</label>
		                    	<textarea name="keyword" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
		                    </div>
	                    </div>
	                </div>
                </div>
              </div>
    	</div>

    	</form>
    </div><!-- /.row -->

</div>					