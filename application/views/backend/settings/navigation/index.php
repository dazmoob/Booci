<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="row">

    	<div class="col-md-2">
    		<a href="<?php echo site_url('setting/navigation'); ?>" class="btn btn-primary btn-block margin-bottom"><i class="fa fa-plus-circle"></i>&nbsp; New Menu</a>

            <?php $this->load->view('backend/settings/navigation/sidebar'); ?>
    		
    	</div><!-- /.col -->

    	<div class="col-md-10">
    		<div class="box box-primary">

    			<div class="box-header with-border">
    				<span class="fa-stack">
						<i id="title-icon-bg" class="fa fa-circle fa-stack-2x text-blue"></i>
						<i id="title-icon" class="fa fa-plus-circle fa-stack-1x fa-inverse"></i>
					</span>
					<h3 class="box-title">Create New List</h3>
    			</div><!-- /.box-header -->

                <form action="<?php echo site_url('article/changeState'); ?>" method="POST">

        			<div class="box-body no-padding">

                    sdfsdfdsf

        			</div><!-- /.box-body -->

                </form>

    		</div><!-- /. box -->
    	</div><!-- /.col -->
    </div><!-- /.row -->

</div>			