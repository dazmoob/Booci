<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div class="box box-primary">

		<div class="box-header">
			<span class="fa-stack">
				<i class="fa fa-circle fa-stack-2x text-blue"></i>
				<i class="fa fa-list fa-stack-1x fa-inverse"></i>
			</span>
			<h3 class="box-title"> User List</h3>
		</div><!-- /.box-header -->

		<div class="divide-line"></div>
	
		<div class="box-body">

			<?php if (!empty($user)) : ?>

			<table id="user-data" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Image</th>
						<th>Username</th>
						<th>Name</th>
						<th>Email</th>
						<th>Level</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>

				<?php foreach ($user as $user) : ?>
					
					<tr>
						<td class="center">
							<img src="<?php echo site_url($user->picture_path); ?>" class="user-image" alt="<?php echo $user->name; ?>">
						</td>
						<td>
							<a href="<?php echo site_url('profile/'.$user->username); ?>">
								<?php echo $user->username; ?>
							</a>
						</td>
						<td><?php echo $user->name; ?></td>
						<td><?php echo $user->email; ?></td>
						<td><?php echo $level[$user->level]; ?></td>
						<td>
							<a href="<?php echo site_url('user/'.$user->username.'/edit'); ?>">
								<span class="fa-stack">
								  	<i class="fa fa-square fa-stack-2x text-blue"></i>
								  	<i class="fa fa-edit fa-stack-1x fa-inverse"></i>
								</span>
							</a>

							<?php if ($user->state == 'Active') : ?>
								<a class="confirm" data-text="block this user" data-icon="fa-ban" href="<?php echo site_url('user/'.$user->username.'/blocked'); ?>">
									<span class="fa-stack">
									  	<i class="fa fa-square fa-stack-2x text-red"></i>
									  	<i class="fa fa-ban fa-stack-1x fa-inverse"></i>
									</span>
								</a>
							<?php else : ?>
								<a class="confirm" data-text="active this user" data-icon="fa-check-square-o" href="<?php echo site_url('user/'.$user->username.'/activation'); ?>">
									<span class="fa-stack">
									  	<i class="fa fa-square fa-stack-2x text-green"></i>
									  	<i class="fa fa-check-square-o fa-stack-1x fa-inverse"></i>
									</span>
								</a>
							<?php endif; ?>

							<a class="confirm" data-text="reset this user password" data-icon="fa-refresh" href="<?php echo site_url('user/'.$user->username.'/reset'); ?>">
								<span class="fa-stack">
								  	<i class="fa fa-square fa-stack-2x text-yellow"></i>
								  	<i class="fa fa-refresh fa-stack-1x fa-inverse"></i>
								</span>
							</a>

							<?php if (in_array('vm_super', $this->useraccess)) : ?>

							<a class="confirm" data-text="delete this user" href="<?php echo site_url('user/'.$user->username.'/delete'); ?>">
								<span class="fa-stack">
								  	<i class="fa fa-square fa-stack-2x text-red"></i>
								  	<i class="fa fa-trash fa-stack-1x fa-inverse"></i>
								</span>
							</a>

							<?php endif; ?>

						</td>
					</tr>

				<?php endforeach; ?>

				</tbody>
                
                <tfoot>
                    <tr>
                        <th>Image</th>
						<th>Username</th>
						<th>Name</th>
						<th>Email</th>
						<th>Level</th>
						<th>Action</th>
                    </tr>
                </tfoot>
            </table>

	        <?php else : ?>

	        <h4 align="center">
	        	No data found here
	        </h4>

	        <?php endif; ?>

        </div><!-- /.box-body -->

</div>		