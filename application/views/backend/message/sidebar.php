<div class="box box-solid">
	<div class="box-body no-padding">

		<ul class="nav nav-pills nav-stacked">
			<li id="list">
				<a href="<?php echo site_url('article/all'); ?>">
					<i class="fa fa-list-alt"></i> All 
					<span class="label label-primary pull-right">
						<?php echo (!empty($count['total'])) ? $count['total'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="publish">
				<a href="<?php echo site_url('article/all/publish'); ?>">
					<i class="fa fa-globe"></i> Published
					<span class="label label-success pull-right">
						<?php echo (!empty($count['Publish'])) ? $count['Publish'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="draft">
				<a href="<?php echo site_url('article/all/draft'); ?>">
					<i class="fa fa-file-text-o"></i> Drafts
					<span class="label label-warning pull-right">
						<?php echo (!empty($count['Draft'])) ? $count['Draft'] : 0;	?>
					</span>
				</a>
			</li>
			<li id="trash">
				<a href="<?php echo site_url('article/all/trash'); ?>">
					<i class="fa fa-trash-o"></i> Trash
					<span class="label label-danger pull-right">
						<?php echo (!empty($count['Trash'])) ? $count['Trash'] : 0;	?>
					</span>
				</a>
			</li>
		</ul>
	</div><!-- /.box-body -->
</div><!-- /. box -->	