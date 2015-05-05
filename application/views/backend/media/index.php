<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="row">

    	<div class="col-md-2">
    		<a href="<?php echo site_url('media/add'); ?>" class="btn btn-primary btn-block margin-bottom"><i class="fa fa-plus-circle"></i>&nbsp; Upload</a>

            <?php $this->load->view('backend/media/sidebar'); ?>
    		
    	</div><!-- /.col -->

    	<div class="col-md-10">
    		<div class="box box-primary">

    			<div class="box-header with-border">
    				<span class="fa-stack">
						<i id="title-icon-bg" class="fa fa-circle fa-stack-2x text-blue"></i>
						<i id="title-icon" class="fa fa-list fa-stack-1x fa-inverse"></i>
					</span>
					<h3 class="box-title">Media List</h3>
    				<div class="box-tools pull-right">
    					<form class="has-feedback" action="" method="GET">
    						<input name="search" type="text" class="form-control input-sm" placeholder="Search Media" value="<?php echo $this->input->get('search') ?>" />
    						<button type="submit" class="glyphicon glyphicon-search form-control-feedback"></button>
    					</form>
    				</div><!-- /.box-tools -->
    			</div><!-- /.box-header -->

    			<?php if (!empty($media)) : ?>

                <form action="<?php echo site_url('media/changeState'); ?>" method="POST">

    			<div class="box-body no-padding">

					<div class="mailbox-controls">
    					<!-- Check all button -->
    					<span class="btn btn-default btn-sm checkbox-toggle">
    						<i class="fa fa-square-o"></i>
    					</span>

    					<div class="btn-group">
    						<button type="submit" name="state" value="delete" data-text="delete all of this pictures" class="btn btn-danger btn-sm">
    							<i class="fa fa-remove"></i>
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

    						<?php foreach ($media as $media) : ?>

    							<tr>
    								<td class="center mailbox-check">
    									<input name="filename[]" value="<?php echo $media->filename; ?>" type="checkbox"/>
    								</td>
    								<td>

                                        <?php
                                            $show = $media->filename;

                                            if ($media->type == 'image') :
                                                $show = 
                                            		'<div class="img-list">
                                                        <img class="img-part" src="'.site_url($media->src).'"/>
                                                    </div>';
                                            
                                            elseif ($media->type == 'file') :
                                            	$show = 
                                            		'<a href="'.site_url($media->src).'">'.$media->src.'</a>';

                                            elseif ($media->type == 'audio') :
                                            	$show = 
                                            		'<audio controls>
													  	<source src="'.site_url($media->src).'">
														Your browser does not support the audio element.
													</audio>';

											elseif ($media->type == 'video') :
                                            	$show = 
                                            		'<video width="320" height="240" controls>
													  	<source src="'.site_url($media->src).'">
														Your browser does not support the video element.
													</video>';
                                            
                                            endif;

                                        	echo $show; 

                                        ?>
                                    </td>

                                    <td class="mailbox-subject">
                                        <h5 class="bold">
                                            <?php echo $media->title; ?>
                                        </h5>
                                        <h5>
                                            <?php echo $media->filename; ?>
                                        </h5>
                                        <p>
                                            <?php echo $media->description; ?>
                                        </p>
                                        <div class="action">

                                            <p class="pull-left">
                                                <small class="label label-<?php echo get_label('media_type', $media->type); ?>">
                                                    <i class="fa fa-<?php echo get_icon('media_type', $media->type); ?>"></i> 
                                                    <?php echo ucfirst($media->type); ?>
                                                </small> &nbsp;
                                                <small class="label label-info">
                                                    <i class="fa fa-clock-o"></i> 
                                                    <?php echo set_elapsed(array('end' => 'now', 'start' => $media->updated_time)); ?>
                                                </small>
                                            </p>

        									<p class="pull-right">

        										<a 
                                                    data-toggle="modal" 
                                                    data-target="#edit-media" 
                                                    data-id="<?php echo $media->id; ?>" 
                                                    data-title="<?php echo $media->title; ?>"
                                                    data-filename="<?php echo $media->filename; ?>" 
                                                    data-description="<?php echo $media->description; ?>" 
                                                    data-type="<?php echo $media->type; ?>" 
                                                    data-src="<?php echo site_url($media->src); ?>" 
                                                    data-created-time="<?php echo date('d F Y, H:i:s', strtotime($media->created_time)) ?>" 
                                                    data-created-by="<?php echo $media->c_username; ?>" 
                                                    data-updated-time="<?php echo date('d F Y, H:i:s', strtotime($media->updated_time)) ?>" 
                                                    data-updated-by="<?php echo $media->u_username; ?>"
                                                    class="text-success clicked edit-media" >
    	    										<i class="fa fa-edit"></i> Edit
        										</a>

                                                <a class="confirm text-danger" data-text="delete permanently this picture <b>(image can't be restored)</b>" href="<?php echo site_url('media/delete/'.$media->filename); ?>">
                                                    <i class="fa fa-remove"></i> Delete
                                                </a>

        									</p>

                                        </div>

    								</td>

                                    <td class="mailbox-name">
                                        <a href="<?php echo site_url('profile/'.$media->c_username); ?>">
                                            <?php echo $media->name; ?>
                                        </a>
                                        <small class="label label-default">
                                            <i class="fa fa-calendar">&nbsp; </i> <?php echo set_time(array('end' => 'now', 'start' => $media->created_time)); ?>
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
    						<button type="submit" name="state" value="delete" class="btn btn-danger btn-sm">
    							<i class="fa fa-remove"></i>
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