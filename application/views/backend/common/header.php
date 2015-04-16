<!-- Main Header -->
<header class="main-header">

	<!-- Logo -->
	<a href="<?php echo site_url('dashboard'); ?>" class="logo">
		<strong><?php echo $this->basic['name']; ?></strong>
	</a>

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

				<!-- Messages: style can be found in dropdown.less-->
				<li class="dropdown messages-menu">
					<!-- Menu toggle button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope-o"></i>
						<span class="label label-success">4</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 4 messages</li>
						<li>
							<!-- inner menu: contains the messages -->
							<ul class="menu">
								<li><!-- start message -->
									<a href="#">
										<div class="pull-left">
											<!-- User Image -->
											<img src="#"/>
										</div>
										<!-- Message title and timestamp -->
										<h4>                            
											Support Team
											<small><i class="fa fa-clock-o"></i> 5 mins</small>
										</h4>
										<!-- The message -->
										<p>Why not buy a new awesome theme?</p>
									</a>
								</li><!-- end message -->                      
							</ul><!-- /.menu -->
						</li>
						<li class="footer"><a href="#">See All Messages</a></li>
					</ul>
				</li><!-- /.messages-menu -->

				<!-- User Account Menu -->
				<li class="dropdown user user-menu">
					<!-- Menu Toggle Button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!-- The user image in the navbar-->
						<img src="<?php echo site_url($this->userdata->picture_path); ?>" class="user-image profile-picture" alt="<?php echo $this->userdata->name; ?>"/>
						<!-- hidden-xs hides the username on small devices so only the image appears. -->
						<span class="hidden-xs"><?php echo $this->userdata->name; ?></span>
					</a>
					<ul class="dropdown-menu">
						<!-- The user image in the menu -->
						<li class="user-header">
							<img src="<?php echo site_url($this->userdata->picture_path); ?>" class="img-circle profile-picture" alt="<?php echo $this->userdata->name; ?>" />
							<p>
								<?php echo excerpt_words($this->userdata->name, 4); ?> - 
								<?php
									$level = $this->ci->user_model->level_super;
									echo $level[$this->userdata->level];
								?>
								<small>
									Member since. <?php echo date('d F Y', strtotime($this->userdata->created_time)); ?> 
								</small>
							</p>
						</li>
						<!-- Menu Body -->
						<li class="user-body">
							<div class="col-xs-4 text-center">
								<a href="#">Articles</a>
							</div>
							<div class="col-xs-4 text-center">
								<a href="#">Sales</a>
							</div>
							<div class="col-xs-4 text-center">
								<a href="#">Friends</a>
							</div>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<a href="<?php echo site_url('profile/'.$this->userdata->username.'/edit'); ?>" class="btn btn-default btn-flat">
									Profile
								</a>
							</div>
							<div class="pull-right">
								<a href="<?php echo site_url('login/logout'); ?>" class="btn btn-default btn-flat">
									Sign out
								</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>	