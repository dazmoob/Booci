<?php if (!empty($this->session->flashdata('notification'))) : ?>	
	
	<div class="col-lg-12">
		<div class="alert alert-<?php echo $this->session->flashdata('alert'); ?> alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	        
	        <?php 
	        	$header = '<h4><i class="icon fa fa-ban"></i> Ooopss</h4>';
	        	if ($this->session->flashdata('alert') == 'danger')
	        		$header = '<h4><i class="icon fa fa-ban"></i>Something wrong happens !</h4>';
	        	elseif ($this->session->flashdata('alert') == 'success')
	        		$header = '<h4><i class="icon fa fa-thumbs-up"></i>Hoorraayy !</h4>';

	        	echo $header;
	        ?>
	     
	        <?php echo $this->session->flashdata('notification'); ?>
	    </div>
	</div>	

<?php endif; ?>