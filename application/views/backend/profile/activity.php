<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">

	<!-- general form elements -->
	<div class="box box-primary">
		<div class="box-header">
			<span class="fa-stack-lg">
				<i class="fa fa-circle fa-stack-3x text-red"></i>
				<i class="fa fa-clock-o fa-stack-1-5x top-middle fa-inverse"></i>
			</span>
			<div class="box-title">
				<h3>User Activities</h3>
				<h5>Track user's activities!</h5>
			</div>
		</div><!-- /.box-header -->

		<div class="divide-line"></div>

		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
				<ul class="activity-list">
					<li class="header">Last 5 activities</li>
					<li>
						<!-- inner menu: contains the messages -->
						<ul class="menu">
							<li><!-- start message -->
							<?php 
							if (!empty($activities)) : 
								foreach ($activities as $activity) :
							?>
								<a href="<?php echo site_url($activity->url); ?>">
									<div class="pull-left">
										<!-- User Image -->
										<span class="fa-stack fa-lg">
											<i class="fa fa-circle fa-stack-2x text-<?php echo $activity->color; ?>"></i>
											<i class="fa fa-<?php echo $activity->initial; ?> fa-stack-1x fa-inverse"></i>
										</span>
									</div>
									<!-- Message title and timestamp -->
									<h4>                            
										<?php echo $activity->title; ?>
										<small>
											<i class="fa fa-clock-o"></i> 
											<?php
												$time = array('start' => $activity->created_time, 'end' => 'now');
												echo set_elapsed($time);
											?>
										</small>
									</h4>
									<!-- The message -->
									<p><?php echo $activity->description; ?></p>
								</a>
							<?php 
								endforeach;
							else : 
							?>
								<div class="center">
									<h4>No activities found</h4>
								</div>
							<?php endif; ?>
							</li><!-- end message -->                      
						</ul><!-- /.menu -->
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>