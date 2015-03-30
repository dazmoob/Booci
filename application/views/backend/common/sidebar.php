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
			<li>
				<a href="#">
					<i class="fa fa-file-text-o"></i>
					<span>Link</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class="fa fa-file-text-o"></i>
					<span>Another Link</span>
				</a>
			</li>
			<li class="treeview">
				<a href="#">
					<span>Multilevel</span> 
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="#">Link in level 2</a></li>
					<li><a href="#">Link in level 2</a></li>
				</ul>
			</li>

			<li class="header">MANAGEMENT</li>

			<!-- Optionally, you can add icons to the links -->
			<li class="treeview">
				<a href="<?php echo site_url('user'); ?>">
					<i class="fa fa-users"></i>
					<span>User</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li>
						<a href="<?php echo site_url('user'); ?>">
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

		</ul><!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>	