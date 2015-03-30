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
						<td>
							<img src="<?php echo site_url($user->picture_path); ?>" class="user-image" alt="<?php echo $user->name; ?>">
						</td>
						<td>Username</td>
						<td>First Last Name</td>
						<td>Email</td>
						<td>

						<?php

						?>
						
						</td>
						<td>
							
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