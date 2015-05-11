<div class="box box-solid">
	<div class="box-body no-padding">

		<ul class="nav nav-pills nav-stacked">
			<li id="list">
				<a href="<?php echo site_url('message/all'); ?>">
					<i class="fa fa-list-alt"></i> All 
					<span class="label label-primary pull-right">
						<?php echo (!empty($count['total'])) ? $count['total'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="unread">
				<a href="<?php echo site_url('message/all/unread'); ?>">
					<i class="fa fa-circle-o"></i> Unread
					<span class="label label-warning pull-right">
						<?php echo (!empty($count['unread'])) ? $count['unread'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="read">
				<a href="<?php echo site_url('message/all/read'); ?>">
					<i class="fa fa-circle"></i> Read
					<span class="label label-info pull-right">
						<?php echo (!empty($count['read'])) ? $count['read'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="unsolved">
				<a href="<?php echo site_url('message/all/unsolved'); ?>">
					<i class="fa fa-remove"></i> Unsolved
					<span class="label label-danger pull-right">
						<?php echo (!empty($count['unsolved'])) ? $count['unsolved'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="solved">
				<a href="<?php echo site_url('message/all/solved'); ?>">
					<i class="fa fa-check-circle"></i> Solved
					<span class="label label-success pull-right">
						<?php echo (!empty($count['solved'])) ? $count['solved'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="trash">
				<a href="<?php echo site_url('message/all/trash'); ?>">
					<i class="fa fa-trash"></i> Trash
					<span class="label label-default pull-right">
						<?php echo (!empty($count['trash'])) ? $count['trash'] : 0;	?>
					</span>
				</a>
			</li>
		</ul>
	</div><!-- /.box-body -->
</div><!-- /. box -->	

<div class="box box-solid">
	<div class="box-body no-padding">

		<ul class="nav nav-pills nav-stacked">
			<li id="criticism">
				<a href="<?php echo site_url('message/all?category=criticism'); ?>">
					<i class="fa fa-exclamation-circle"></i> Criticism
					<span class="label label-warning pull-right">
						<?php echo (!empty($count['criticism'])) ? $count['criticism'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="suggestion">
				<a href="<?php echo site_url('message/all?category=suggestion'); ?>">
					<i class="fa fa-info-circle"></i> Suggestion
					<span class="label label-info pull-right">
						<?php echo (!empty($count['suggestion'])) ? $count['suggestion'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="question">
				<a href="<?php echo site_url('message/all?category=question'); ?>">
					<i class="fa fa-question-circle"></i> Question
					<span class="label label-danger pull-right">
						<?php echo (!empty($count['question'])) ? $count['question'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="others">
				<a href="<?php echo site_url('message/all?category=others'); ?>">
					<i class="fa fa-plus-circle"></i> Others
					<span class="label label-success pull-right">
						<?php echo (!empty($count['others'])) ? $count['others'] : 0;	?>
					</span>
				</a>
			</li>
		</ul>
	</div><!-- /.box-body -->
</div><!-- /. box -->	