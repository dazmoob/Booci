<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="row">

    	<div class="col-md-4">
    		<a href="<?php echo site_url('settings/navigation'); ?>" class="btn btn-primary btn-block margin-bottom"><i class="fa fa-plus-circle"></i>&nbsp; New Menu</a>

            <?php $this->load->view('backend/settings/navigation/sidebar'); ?>
    		
    	</div><!-- /.col -->

    	<div class="col-md-8">
    		<div class="box box-primary">

    			<div class="box-header with-border">
    				<span class="fa-stack">
						<i id="title-icon-bg" class="fa fa-circle fa-stack-2x text-blue"></i>
						<i id="title-icon" class="fa fa-plus-circle fa-stack-1x fa-inverse"></i>
					</span>
					<h3 class="box-title">Create New List</h3>
    			</div><!-- /.box-header -->

        		<div class="box-body">
                    <form action="<?php echo site_url('settings/createNavigation'); ?>" method="POST">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" class="form-control" placeholder="Navigation's name">
                                </div>
                                <div class="form-group">
                                    <label>State</label>
                                    <?php
                                        $attr = 'class="form-control"';
                                        $states = array('active' => 'Active', 'inactive' => 'Inactive');
                                        echo form_dropdown('status', $states, 'active', $attr);
                                    ?>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea name="notes" placeholder="Place some text here" style="width: 100%; height: 108px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="pull-right">
                                    <button type="submit" name="submit" class="btn btn-primary">
                                        <i class="fa fa-check-circle"></i>&nbsp; Create Menu
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
        		</div><!-- /.box-body -->

    		</div><!-- /. box -->
    	</div><!-- /.col -->
    </div><!-- /.row -->

</div>			