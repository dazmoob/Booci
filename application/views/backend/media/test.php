<?php echo form_open_multipart(site_url('media/uploadFiles'));?>

<input name="userfile[]" id="userfile" type="file" multiple/>
<input type="submit" value="upload" />

<?php echo form_close() ?>