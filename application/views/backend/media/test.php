<?php echo form_open_multipart('media/uploadFiles');?>
	
	<input name="userfile[]" type="file" multiple> <br>
	<button type="submit">Submit</button>

</form>