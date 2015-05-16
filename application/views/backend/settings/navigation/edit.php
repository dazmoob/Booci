<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="row">

    	<div class="col-md-4">
    		<a href="<?php echo site_url('settings/navigation'); ?>" class="btn btn-primary btn-block margin-bottom"><i class="fa fa-plus-circle"></i>&nbsp; New Menu</a>

            <?php $this->load->view('backend/settings/navigation/sidebar'); ?>
    		
    	</div><!-- /.col -->

    	<div class="col-md-8">

    		<!-- Navigation Details -->
    		<div class="box box-primary">

    			<div class="box-header with-border">
    				<span class="fa-stack">
						<i id="title-icon-bg" class="fa fa-circle fa-stack-2x text-blue"></i>
						<i id="title-icon" class="fa fa-list fa-stack-1x fa-inverse"></i>
					</span>
					<h3 class="box-title">Edit Navigation</h3>
    			</div><!-- /.box-header -->

        		<div class="box-body">

                    <form action="<?php echo site_url('settings/updateNavigation/'.set_value('slug')); ?>" method="POST">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" class="form-control" placeholder="Navigation's name" value="<?php echo set_value('name'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>State</label>
                                    <?php
                                        $attr = 'class="form-control"';
                                        $states = array('active' => 'Active', 'inactive' => 'Inactive');
                                        echo form_dropdown('status', $states, set_value('status'), $attr);
                                    ?>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea name="notes" placeholder="Place some text here" style="width: 100%; height: 108px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo set_value('notes'); ?></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                            	<div class="col-lg-6 col-md-6">
	                            	<a href="<?php echo site_url('settings/deleteNavigation/'.set_value('slug')); ?>" class="btn btn-danger confirm" data-text="delete this navigation menu"
	                            	>
		                            	<i class="fa fa-remove"></i>
	                            	</a>
                            	</div>
                            	<div class="col-lg-6 col-md-6">
	                                <div class="pull-right">
	                                    <button type="submit" name="submit" class="btn btn-primary">
	                                        <i class="fa fa-check-circle"></i>&nbsp; Update Menu
	                                    </button>
	                                </div>
	                            </div>
                            </div>

                        </div>
                    </form>

        		</div><!-- /.box-body -->

    		</div>
    		<!-- / Navigation Details -->

    		<div class="row">

	    		<!-- Navigation Details Location -->
    			<div class="col-lg-6 col-md-6">
		    		<div class="box box-primary">

		    			<div class="box-header with-border">
		    				<span class="fa-stack">
								<i id="title-icon-bg" class="fa fa-circle fa-stack-2x text-blue"></i>
								<i id="title-icon" class="fa fa-list-ol fa-stack-1x fa-inverse"></i>
							</span>
							<h3 class="box-title">Navigation Links Position</h3>

							<div class="pull-right">
								<span id="submit-links-location" class="btn btn-primary btn-xs">
									<i class="fa fa-check"></i>
								</span>
							</div>
		    			</div><!-- /.box-header -->

		        		<div class="box-body">

	                        <div class="grid-stack">

	                        <?php

	                       		$i = 1;
	                        	if (!empty($navigation_link)) :

	                        		foreach ($navigation_link as $link) :

	                        ?>
							    <div class="grid-stack-item grid-part" 
							        data-gs-x="0" data-gs-y="0" data-gs-width="12">
						            <div class="grid-stack-item-content">
						            	<div class="get-link-data clicked"
						            		data-id="<?php echo $link->link_id; ?>"
						            		data-label="<?php echo $link->label; ?>"
						            		data-url="<?php echo $link->url; ?>"
						            		data-class="<?php echo $link->class; ?>"
						            		data-rel="<?php echo $link->rel; ?>"
						            		data-target="<?php echo $link->target; ?>"
						            		data-sequence="<?php echo $link->sequence; ?>"
						            	>
						            		<?php echo $link->label; ?>
						            	</div>
						            </div>
							    </div>

							<?php

										$i++;
									endforeach;

								endif;

							?>

								<input id="set-new-location" type="hidden" name="new_links" value="" data-slug="<?php echo set_value('slug'); ?>">

							</div>

		        		</div><!-- /.box-body -->
		                
		    		</div><!-- /. box -->
		    	</div>
	    		<!-- / Navigation Details Location -->

	    		<!-- Navigation Details Link -->
		    	<div class="col-lg-6 col-md-6">
		    		<div class="box box-primary">

		    			<div class="box-header with-border">
		    				<span class="fa-stack">
								<i id="title-icon-bg" class="fa fa-circle fa-stack-2x text-blue"></i>
								<i id="title-icon" class="fa fa-link fa-stack-1x fa-inverse"></i>
							</span>
							<h3 class="box-title link-title">New Link</h3>
							<div class="pull-right">
								<span id="new-link" class="btn btn-primary btn-xs">
									<i class="fa fa-plus"></i>
								</span>
							</div>
		    			</div><!-- /.box-header -->

		        		<div class="box-body">

		                    <form id="form-submit-link" action="<?php echo site_url('settings/updateNavigationLink/'.set_value('id')); ?>" method="POST">
		                        <div class="row">

		                        	<input class="link-id" type="hidden" name="new" value="true">

		                        	<div class="col-lg-12 col-md-12 col-sm-12">
		                                <div class="form-group">
		                                    <label>URL</label>
		                                    <input name="url" type="text" class="form-control links" placeholder="Link's URL" value="">
		                                </div>
		                            </div>

		                            <div class="col-lg-12 col-md-12 col-sm-12">
		                                <div class="form-group">
		                                    <label>Label</label>
		                                    <input name="label" type="text" class="form-control links" placeholder="Link's Label" value="">
		                                </div>
		                            </div>

		                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		                                <div class="form-group">
		                                    <label>Class</label>
		                                    <input name="class" class="form-control links" placeholder="Additional class" value="">
		                                </div>
		                                <div class="form-group">
		                                    <label>Rel</label>
		                                    <input name="rel" class="form-control links" placeholder="HTML Rel (advance)" value="">
		                                </div>
		                            </div>

		                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		                                <div class="form-group">
		                                    <label>Target</label>
		                                    <input name="target" class="form-control links" placeholder="Additional class" value="">
		                                </div>
		                                <div class="form-group">
		                                    <label>Sequence</label>
		                                    <input class="sequence" name="sequence" type="hidden" data-sequence="<?php echo $i; ?>" value="<?php echo $i; ?>">
		                                    <div class="form-control readonly last-sequence">
												<?php echo $i; ?>
											</div>
		                                </div>
		                            </div>

		                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		                            	<div class="col-lg-6 col-md-6">
			                            	<a href="<?php echo site_url('settings/deleteNavigationLink/'); ?>" class="delete-link btn btn-danger"
			                            	>
			                            		<i class="fa fa-remove"></i>
			                            	</a>
		                            	</div>
		                            	<div class="col-lg-6 col-md-6">
			                                <div class="pull-right">
			                                    <button type="submit" name="submit" class="btn btn-primary link-button">
			                                        <i class="fa fa-check-circle"></i>&nbsp; Create Link
			                                    </button>
			                                </div>
			                            </div>
		                            </div>

		                        </div>
		                    </form>

		                    <div class="row">

		                    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				                    
								</div>

							</div>

		        		</div><!-- /.box-body -->

		    		</div><!-- /. box -->
		    	</div>
	    		<!-- Navigation Details Link -->

		    </div>

    	</div><!-- /.col -->
    </div><!-- /.row -->

</div>				