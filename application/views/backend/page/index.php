<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="row">

    	<div class="col-md-2">
    		<a href="<?php echo site_url('page/add'); ?>" class="btn btn-primary btn-block margin-bottom"><i class="fa fa-plus-circle"></i>&nbsp; Compose</a>

            <?php $this->load->view('backend/page/sidebar'); ?>
    		
    	</div><!-- /.col -->

    	<div class="col-md-10">
    		<div class="box box-primary">

    			<div class="box-header with-border">
    				<span class="fa-stack">
						<i id="title-icon-bg" class="fa fa-circle fa-stack-2x text-blue"></i>
						<i id="title-icon" class="fa fa-list fa-stack-1x fa-inverse"></i>
					</span>
					<h3 class="box-title">Page List</h3>
    				<div class="box-tools pull-right">
    					<form class="has-feedback" action="" method="GET">
    						<input name="search" type="text" class="form-control input-sm" placeholder="Search page" value="<?php echo $this->input->get('search') ?>" />
    						<button type="submit" class="glyphicon glyphicon-search form-control-feedback"></button>
    					</form>
    				</div><!-- /.box-tools -->
    			</div><!-- /.box-header -->

    			<?php if (!empty($pagesData)) : ?>

                <form action="<?php echo site_url('page/changeState'); ?>" method="POST">

    			<div class="box-body no-padding">

					<div class="mailbox-controls">
    					<!-- Check all button -->
    					<span class="btn btn-default btn-sm checkbox-toggle">
    						<i class="fa fa-square-o"></i>
    					</span>

    					<div class="btn-group">
                            <button type="submit" name="state" value="Publish" class="btn btn-success btn-sm">
                                <i class="fa fa-globe"></i> Publish
                            </button>
                            <button type="submit" name="state" value="Draft" class="btn btn-warning btn-sm">
                                <i class="fa fa-file-text-o"></i> Back to Draft
                            </button>
    						<button type="submit" name="state" value="Trash" class="btn btn-danger btn-sm">
    							<i class="fa fa-trash-o"></i>
    						</button>
    					</div><!-- /.btn-group -->

                        <div class="pull-right">
        					<div class="box-tools">
                                <?php echo $this->pagination->create_links(); ?>
        					</div><!-- /.pull-right -->
                        </div>
    				</div>

    				<div class="table-responsive mailbox-messages">
    					<table class="table table-hover table-striped">
    						<tbody>

    						<?php foreach ($pagesData as $page) : ?>

    							<tr>
    								<td class="center mailbox-check">
    									<input name="slug[]" value="<?php echo $page->slug; ?>" type="checkbox"/>
    								</td>
    								<td class="mailbox-subject">

	    								<h5>
                                            <?php
                                                $url = '#';
                                                if ($page->state == 'Publish') :
                                                    $url = site_url('page/'.$page->slug);
                                                elseif ($page->state == 'Draft') :
                                                    $url = site_url('page/'.$page->slug.'/draft');
                                                endif;
                                            ?>
	    									<a href="<?php echo $url; ?>">
	    										<?php echo $page->title; ?>
	    									</a>
	    								</h5>

    									<p>
    										<?php echo excerpt_words($page->content, 30); ?>
    									</p>

                                        <div class="action">

                                            <p class="pull-left">
                                                <small class="label label-<?php echo get_label('page_state', $page->state); ?>">
                                                    <i class="fa fa-<?php echo get_icon('page_state', $page->state); ?>"></i> 
                                                    <?php echo ucfirst($page->state); ?>
                                                </small> &nbsp;
                                                <small class="label label-info">
                                                    <i class="fa fa-clock-o"></i> 
                                                    <?php echo set_elapsed(array('end' => 'now', 'start' => $page->updated_time)); ?>
                                                </small>
                                            </p>

        									<p class="pull-right">

        										<!-- Trash and Edit -->
        										<?php if ($page->state != 'Trash') : ?>

        										<a href="<?php echo site_url('page/'.$page->slug.'/edit'); ?>" class="text-success">
    	    										<i class="fa fa-edit"></i> Edit
        										</a>

        										<a href="<?php echo site_url('page/trash/'.$page->slug); ?>" class="text-danger">
    	    										<i class="fa fa-trash"></i> Trash
        										</a>

    	    									<?php endif; ?>
        										<!-- / Trash and Edit -->

        										<!-- Restore -->
    	    									<?php if ($page->state == 'Trash') : ?>

        										<a class="confirm" data-text="restore this page" href="<?php echo site_url('page/restore/'.$page->slug); ?>" class="text-info">
    	    										<i class="fa fa-refresh"></i> Restore
        										</a>

                                                <a class="confirm text-danger" data-text="delete permanently this page from database" href="<?php echo site_url('page/delete/'.$page->slug); ?>">
                                                    <i class="fa fa-remove"></i> Delete
                                                </a>

    	    									<?php endif; ?>
        										<!-- / Restore -->

        										<!-- Draft -->
    	    									<?php if ($page->state == 'Publish') : ?>

        										<a href="<?php echo site_url('page/draft/'.$page->slug); ?>" class="text-warning">
    	    										<i class="fa fa-file-text-o"></i> Draft
        										</a>

    	    									<?php endif; ?>
        										<!-- / Draft -->

        										<!-- Publish -->
    	    									<?php if ($page->state == 'Draft') : ?>

        										<a href="<?php echo site_url('page/publish/'.$page->slug); ?>" class="text-blue">
    	    										<i class="fa fa-globe"></i> Publish
        										</a>

    	    									<?php endif; ?>
        										<!-- / Publish -->
        										
        									</p>

                                        </div>

    								</td>

                                    <td class="mailbox-name">
                                        <a href="<?php echo site_url('profile/'.$page->c_username); ?>">
                                            <?php echo $page->name; ?>
                                        </a>
                                        <small class="label label-default">
                                            <i class="fa fa-calendar">&nbsp; </i> <?php echo set_time(array('end' => 'now', 'start' => $page->created_time)); ?>
                                        </small>
                                    </td>
    							</tr>
    						
    						<?php endforeach; ?>

    						</tbody>
    					</table><!-- /.table -->
    				</div><!-- /.mail-box-messages -->

    			</div><!-- /.box-body -->

    			<div class="box-footer no-padding">

    				<div class="mailbox-controls">
    					<!-- Check all button -->
    					<span class="btn btn-default btn-sm checkbox-toggle">
    						<i class="fa fa-square-o"></i>
    					</span>                    
    					<div class="btn-group">
    						 <button type="submit" name="state" value="Publish" class="btn btn-success btn-sm">
                                <i class="fa fa-globe"></i> Publish
                            </button>
                            <button type="submit" name="state" value="Draft" class="btn btn-warning btn-sm">
                                <i class="fa fa-file-text-o"></i> Back to Draft
                            </button>
                            <button type="submit" name="state" value="Trash" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash-o"></i>
                            </button>
    					</div><!-- /.btn-group -->
    					<div class="pull-right">
                            <div class="box-tools">
                                <?php echo $this->pagination->create_links(); ?>
                            </div><!-- /.pull-right -->
                        </div>
    				</div>

    			</div>

                </form>

    			<?php else : ?>

		        <h4 align="center">
		        	No data found here
		        </h4> <br>

		        <?php endif; ?>

    		</div><!-- /. box -->
    	</div><!-- /.col -->
    </div><!-- /.row -->

</div>			