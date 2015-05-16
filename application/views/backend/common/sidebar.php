<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo site_url($this->userdata->picture_path); ?>" class="img-circle profile-picture" alt="<?php echo $this->userdata->name; ?>" />
			</div>
			<div class="pull-left info">
				<p>
					<?php 
						echo excerpt_words($this->userdata->name, 4); 
					?>
				</p>
				<!-- Status -->
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<!-- search form (Optional) -->
		<form action="<?php echo site_url('article/find'); ?>" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="s" class="form-control" placeholder="Search article ..."/>
				<span class="input-group-btn">
					<button type='submit' name='search' id='search-btn' class="btn btn-flat">
						<i class="fa fa-search"></i>
					</button>
				</span>
			</div>
		</form>
		<!-- /.search form -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">

			<li class="header">BLOG / INFO</li>

			<!-- Optionally, you can add icons to the links -->
			<?php if (in_array('vm_article', $this->useraccess)) : ?>
				<li class="treeview">
					<a href="<?php echo site_url('article/all'); ?>">
						<i class="fa fa-file-text-o"></i>
						<span>Article</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="<?php echo site_url('article/all'); ?>">
								<i class="fa fa-list-alt"></i>
								List
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('article/add'); ?>">
								<i class="fa fa-plus-circle"></i>
								Add New
							</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>

			<!-- Optionally, you can add icons to the links -->
			<?php if (in_array('vm_page', $this->useraccess)) : ?>
				<li class="treeview">
					<a href="<?php echo site_url('page/all'); ?>">
						<i class="fa fa-file-text-o"></i>
						<span>Pages</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="<?php echo site_url('page/all'); ?>">
								<i class="fa fa-list-alt"></i>
								List
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('page/add'); ?>">
								<i class="fa fa-plus-circle"></i>
								Add New
							</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>

			<?php if (in_array('c_media', $this->useraccess)) : ?>
				<li class="treeview">
					<a href="<?php echo site_url('media'); ?>">
						<i class="fa fa-film"></i>
						<span>Media</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="<?php echo site_url('media/image'); ?>">
								<i class="fa fa-photo"></i>
								Gallery
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('media/file'); ?>">
								<i class="fa fa-file"></i>
								Files
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('media/add'); ?>">
								<i class="fa fa-plus-circle"></i>
								Add
							</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>

			<li class="header">MANAGEMENTS</li>

			<!-- Optionally, you can add icons to the links -->
			<?php if (in_array('c_message', $this->useraccess)) : ?>
				<li class="treeview">
					<a href="<?php echo site_url('message/all'); ?>">
						<i class="fa fa-envelope"></i>
						<span>Message</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="<?php echo site_url('message/all'); ?>">
								<i class="fa fa-list-alt"></i>
								List
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('message/unread'); ?>">
								<i class="fa fa-plus-circle"></i>
								Unread
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('message/unsolve'); ?>">
								<i class="fa fa-plus-circle"></i>
								Unsolve
							</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>

			<!-- Optionally, you can add icons to the links -->
			<?php if (in_array('c_user', $this->useraccess)) : ?>
				<li class="treeview">
					<a href="<?php echo site_url('user/all'); ?>">
						<i class="fa fa-users"></i>
						<span>User</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="<?php echo site_url('user/all'); ?>">
								<i class="fa fa-list-alt"></i>
								List
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('user/add'); ?>">
								<i class="fa fa-plus-circle"></i>
								Add New
							</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>

			<li class="header">SETTINGS</li>

			<?php if (in_array('c_settings', $this->useraccess)) : ?>
			<li class="treeview">
				<a href="<?php echo site_url('settings/basic'); ?>">
					<i class="fa fa-wrench"></i>
					<span>Settings</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li>
						<a href="<?php echo site_url('settings/basic'); ?>">
							<i class="fa fa-globe"></i>
							Basic
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('settings/navigation'); ?>">
							<i class="fa fa-list"></i>
							Navigations
						</a>
					</li>
				</ul>
			</li>
			<?php endif; ?>

		</ul><!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>	