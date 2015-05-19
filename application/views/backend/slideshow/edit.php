<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="row">

    	<div class="col-md-4">

    		<a href="<?php echo site_url('slideshow'); ?>" class="btn btn-primary btn-block margin-bottom">
                <i class="fa fa-plus-circle"></i>&nbsp; New Slideshow
            </a>

            <?php $this->load->view('backend/slideshow/sidebar'); ?>
    		
    	</div><!-- /.col -->

    	<div class="col-md-8">

            <!-- Edit Data -->
    		<div class="box box-primary">

    			<div class="box-header with-border">
    				<span class="fa-stack">
						<i id="title-icon-bg" class="fa fa-circle fa-stack-2x text-blue"></i>
						<i id="title-icon" class="fa fa-edit fa-stack-1x fa-inverse"></i>
					</span>
					<h3 class="box-title">Edit Slideshow Data</h3>
    			</div><!-- /.box-header -->

        		<div class="box-body">
                    <form action="<?php echo site_url('slideshow/update/'.set_value('slug')); ?>" method="POST">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" class="form-control" placeholder="Navigation's name" value="<?php echo set_value('name'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>State</label>
                                    <?php
                                        $attr = 'class="form-control"';
                                        $states = array('active' => 'Active', 'inactive' => 'Inactive');
                                        echo form_dropdown('status', $states, set_value('status'), $attr);
                                    ?>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea name="notes" placeholder="Place some text here" style="width: 100%; height: 108px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo set_value('notes'); ?></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="pull-right">
                                    <button type="submit" name="submit" class="btn btn-primary">
                                        <i class="fa fa-check-circle"></i>&nbsp; Update Slideshow
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
        		</div><!-- /.box-body -->

    		</div><!-- /. box -->

            <!-- Slideshow Preview -->
            <div class="box box-primary">

                <div class="box-header with-border">
                    <span class="fa-stack">
                        <i id="title-icon-bg" class="fa fa-circle fa-stack-2x text-blue"></i>
                        <i id="title-icon" class="fa fa-image fa-stack-1x fa-inverse"></i>
                    </span>
                    <h3 class="box-title">Slideshow Pictures</h3>
                </div><!-- /.box-header -->

                <div class="box-body">

                    <?php if (!empty($slideshows)) : ?>

                    <form action="<?php echo site_url('slideshow/changeState'); ?>" method="POST">

                        <div class="mailbox-controls">

                            <span class="btn btn-default btn-sm checkbox-toggle">
                                <i class="fa fa-square-o"></i>
                            </span>

                            <div class="btn-group">
                                <button type="submit" name="state" value="delete" data-text="delete all of this pictures" class="btn btn-danger btn-sm">
                                    <i class="fa fa-remove"></i>
                                </button>
                            </div><!-- /.btn-group -->

                        </div>

                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>

                                <?php foreach ($slideshows as $slideshow) : ?>

                                    <tr>
                                        <td class="center mailbox-check">
                                            <input name="id[]" value="<?php echo $slideshow->id; ?>" type="checkbox"/>
                                        </td>
                                        <td>
                                            <div class="img-list">
                                                <img class="img-part" src="<?php echo site_url($slideshow->src); ?>"/>
                                            </div>
                                        </td>

                                        <td class="mailbox-subject">
                                            <h5 class="bold">
                                                <?php echo $slideshow->title; ?>
                                            </h5>
                                            <h5>
                                                <?php echo $slideshow->subtitle; ?>
                                            </h5>
                                            <p>
                                                <?php echo $slideshow->description; ?>
                                            </p>
                                            <div class="action">

                                                <p class="pull-right">

                                                    <a 
                                                        data-toggle="modal" 
                                                        data-target="#edit-slideshow" 
                                                        data-id="<?php echo $slideshow->id; ?>" 
                                                        data-title="<?php echo $slideshow->title; ?>"
                                                        data-subtitle="<?php echo $slideshow->subtitle; ?>"
                                                        data-description="<?php echo $slideshow->description; ?>"
                                                        data-src="<?php echo site_url($slideshow->src); ?>" 
                                                        data-label="<?php echo site_url($slideshow->label); ?>" 
                                                        data-url="<?php echo site_url($slideshow->url); ?>" 
                                                        data-status="<?php echo site_url($slideshow->status); ?>" 
                                                        class="text-success clicked edit-slideshow" >
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>

                                                    <a class="confirm text-danger" data-text="delete permanently this picture <b>(image can't be restored)</b>" href="<?php echo site_url('slideshow/delete/'.$slideshow->id); ?>">
                                                        <i class="fa fa-remove"></i> Delete
                                                    </a>

                                                </p>

                                            </div>

                                        </td>
                                    </tr>
                                
                                <?php endforeach; ?>

                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->

                    </form>

                    <?php endif; ?>

                </div>

            </div>

    	</div><!-- /.col -->
    </div><!-- /.row -->

</div>			