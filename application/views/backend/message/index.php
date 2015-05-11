<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="row">

    	<div class="col-md-2">
    		<?php $this->load->view('backend/message/sidebar'); ?>
    	</div><!-- /.col -->

    	<div class="col-md-10">
    		<div class="box box-primary">

    			<div class="box-header with-border">
    				<span class="fa-stack">
						<i id="title-icon-bg" class="fa fa-circle fa-stack-2x text-blue"></i>
						<i id="title-icon" class="fa fa-envelope fa-stack-1x fa-inverse"></i>
					</span>
					<h3 class="box-title">Inbox</h3>
    				<div class="box-tools pull-right">
    					<form class="has-feedback" action="" method="GET">
                            
                            <input name="search" type="text" class="form-control input-sm" placeholder="Search message" value="<?php echo $this->input->get('search') ?>" />

                            <?php if (!empty($this->input->get('category'))) : ?>

        						<input name="category" type="hidden" class="form-control input-sm" placeholder="Search category" value="<?php echo $this->input->get('category') ?>" />

                            <?php endif; ?>
    						
                            <button type="submit" class="glyphicon glyphicon-search form-control-feedback"></button>

    					</form>
    				</div><!-- /.box-tools -->
    			</div><!-- /.box-header -->

    			<?php if (!empty($messages)) : ?>

                <form action="<?php echo site_url('message/changeState'); ?>" method="POST">

    			<div class="box-body no-padding">

					<div class="mailbox-controls">
    					<!-- Check all button -->
    					<span class="btn btn-default btn-sm checkbox-toggle">
    						<i class="fa fa-square-o"></i>
    					</span>

    					<div class="btn-group">
                            <button type="submit" name="type" value="read" class="btn btn-primary btn-sm">
                                <i class="fa fa-circle"></i> Read
                            </button>
                            <button type="submit" name="type" value="unread" class="btn btn-warning btn-sm">
                                <i class="fa fa-circle-o"></i> Unread
                            </button>
                            <button type="submit" name="type" value="solved" class="btn btn-success btn-sm">
                                <i class="fa fa-check-square-o"></i> Solved
                            </button>
                            <button type="submit" name="type" value="unsolved" class="btn btn-danger btn-sm">
                                <i class="fa fa-remove"></i> Unsolved
                            </button>
    					</div><!-- /.btn-group -->

                        <button type="submit" name="type" value="trash" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-o"></i>
                        </button>

                        <div class="pull-right">
        					<div class="box-tools">
                                <?php echo $this->pagination->create_links(); ?>
        					</div><!-- /.pull-right -->
                        </div>
    				</div>

    				<div class="table-responsive mailbox-messages">
    					<table class="table table-hover table-striped">
    						<tbody>

    						<?php foreach ($messages as $message) : ?>

    							<tr>
    								<td class="center mailbox-check">
    									<input name="id[]" value="<?php echo $message->id; ?>" type="checkbox"/>
    								</td>
    								<td class="mailbox-subject">

	    								<h5>
                                            <a class="clicked open-message"
                                                data-toggle="modal" 
                                                data-target="#show-message"
                                                data-id="<?php echo $message->id; ?>" 
                                                data-name="<?php echo $message->name; ?>" 
                                                data-email="<?php echo $message->email; ?>" 
                                                data-url="<?php echo $message->url; ?>" 
                                                data-title="<?php echo $message->title; ?>" 
                                                data-content="<?php echo $message->content; ?>" 
                                                data-state="<?php echo $message->state; ?>" 
                                                data-solve="<?php echo $message->solve; ?>" 
                                                data-type="<?php echo $message->type; ?>" 
                                                data-created-time="<?php echo $message->created_time; ?>" 
                                            >
	    										<?php echo $message->title; ?>
	    									</a>
	    								</h5>

    									<p>
    										<?php echo excerpt_words($message->content, 30); ?>
                                            &nbsp; 
                                            <a class="clicked open-message"
                                                data-toggle="modal" 
                                                data-target="#show-message"
                                                data-id="<?php echo $message->id; ?>" 
                                                data-name="<?php echo $message->name; ?>" 
                                                data-email="<?php echo $message->email; ?>" 
                                                data-url="<?php echo $message->url; ?>" 
                                                data-title="<?php echo $message->title; ?>" 
                                                data-content="<?php echo $message->content; ?>" 
                                                data-state="<?php echo $message->state; ?>" 
                                                data-solve="<?php echo $message->solve; ?>" 
                                                data-type="<?php echo $message->type; ?>" 
                                                data-created-time="<?php echo $message->created_time; ?>" 
                                            >
                                                Details
                                            </a>
    									</p>

                                        <div class="action">

                                            <p class="pull-left">
                                                <small class="label-state label label-<?php echo get_label('message_state', $message->state); ?>">
                                                    <i class="fa fa-<?php echo get_icon('message_state', $message->state); ?>"></i> 
                                                    <?php echo ucfirst($message->state); ?>
                                                </small> &nbsp;
                                                <small class="label label-<?php echo get_label('message_solved', $message->solve); ?>">
                                                    <i class="fa fa-<?php echo get_icon('message_solved', $message->solve); ?>"></i> 
                                                    <?php echo ucfirst($message->solve); ?>
                                                </small>
                                            </p>

        									<p class="pull-right">

        										<!-- Read Unread -->
        										<?php if ($message->state == 'read') : ?>

        										<a href="<?php echo site_url('message/state/'.$message->id.'/unread'); ?>" class="text-warning confirm" data-text="unread this message" data-icon="fa-circle-o">
    	    										<i class="fa fa-circle-o"></i> Unread
        										</a>

                                                <?php elseif ($message->state == 'unread') : ?>

                                                <a href="<?php echo site_url('message/state/'.$message->id.'/read'); ?>" class="text-primary confirm" data-text="set has been read this message" data-icon="fa-circle">
                                                    <i class="fa fa-circle"></i> Read
                                                </a>

                                                <?php elseif ($message->state == 'trash') : ?>

                                                <a href="<?php echo site_url('message/state/'.$message->id.'/unread'); ?>" class="text-info confirm" data-text="set has been restore this message" data-icon="fa-refresh">
                                                    <i class="fa fa-refresh"></i> Restore
                                                </a>                                              

    	    									<?php endif; ?>
        										<!-- / Read Unread -->

                                                <!-- solved Unsolved -->
                                                <?php if ($message->solve == 'solved') : ?>

                                                <a href="<?php echo site_url('message/state/'.$message->id.'/unsolved'); ?>" class="text-danger confirm" data-text="unsolved this message" data-icon="fa-remove">
                                                    <i class="fa fa-remove"></i> Unsolved
                                                </a>

                                                <?php elseif ($message->solve == 'unsolved') : ?>

                                                <a href="<?php echo site_url('message/state/'.$message->id.'/solved'); ?>" class="text-success confirm" data-text="solved this message" data-icon="fa-check-circle">
                                                    <i class="fa fa-check-circle"></i> Solved
                                                </a>                                                    

                                                <?php endif; ?>
                                                <!-- / solved Unsolved -->
        										
        									</p>

                                        </div>

    								</td>

                                    <td class="mailbox-name">

                                        <span class="message-type text-<?php echo get_label('message_type', $message->type); ?>">
                                            <?php echo ucfirst($message->type); ?>    
                                        </span>
                                    
                                        <a href="<?php echo 'mailto:'.$message->email.'?Subject=Hello" target="_top"' ?>">
                                            <?php echo excerpt_words($message->name, 2); ?>
                                        </a>
                                    
                                        <small class="label label-default">
                                            <i class="fa fa-calendar">&nbsp; </i> <?php echo set_time(array('end' => 'now', 'start' => $message->created_time)); ?>
                                        </small>

                                    </td>
    							</tr>
    						
    						<?php endforeach; ?>

    						</tbody>
    					</table><!-- /.table -->
    				</div><!-- /.mail-box-messages -->

    			</div><!-- /.box-body -->

    			<div class="mailbox-controls">
                    <!-- Check all button -->
                    <span class="btn btn-default btn-sm checkbox-toggle">
                        <i class="fa fa-square-o"></i>
                    </span>

                    <div class="btn-group">
                        <button type="submit" name="state" value="read" class="btn btn-primary btn-sm">
                            <i class="fa fa-circle"></i> Read
                        </button>
                        <button type="submit" name="state" value="unread" class="btn btn-warning btn-sm">
                            <i class="fa fa-circle-o"></i> Unread
                        </button>
                        <button type="submit" name="solved" value="solved" class="btn btn-success btn-sm">
                            <i class="fa fa-check-square-o"></i> Solved
                        </button>
                        <button type="submit" name="solved" value="unsolved" class="btn btn-danger btn-sm">
                            <i class="fa fa-remove"></i> Unsolved
                        </button>
                    </div><!-- /.btn-group -->

                    <button type="submit" name="state" value="trash" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash-o"></i>
                    </button>

                    <div class="pull-right">
                        <div class="box-tools">
                            <?php echo $this->pagination->create_links(); ?>
                        </div><!-- /.pull-right -->
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