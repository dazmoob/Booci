$(function(){

	// Edit action
	$('.edit-slideshow').click(function(){

		// Get all data value
		var id = $(this).data('id');
		var title = $(this).data('title');
		var subtitle = $(this).data('subtitle');
		var src = $(this).data('src');
		var description = $(this).data('description');
		var label = $(this).data('label');
		var url = $(this).data('url');
		var status = $(this).data('status');

		preview = '<div class="img-list-a">' +
            '<img class="img-part" src="' + src + '"/>' +
        '</div>';

		$('#edit-preview').html(preview);

		// Set input
		$('#edit-form').attr('action', domain + 'slideshow/updateSlideshow/' + id);
		$('#edit-form input[name="title"]').val(title);
		$('#edit-form input[name="subtitle"]').val(subtitle);
		$('#edit-form input[name="label"]').val(label);
		$('#edit-form input[name="url"]').val(url);
		$('#edit-form textarea[name="description"]').html(description);

	});

	// if (pathname.indexOf('add') > -1) {

	// 	var uploadUrl = project + "/slideshow/uploadFiles";

	// 	$("#upload-files").fileinput({
	// 	    uploadUrl: uploadUrl,
	// 	    uploadAsync: true,
	// 	    maxFileCount: 5
	// 	});

	// 	$('#upload-files').on('fileuploaded', function(event, data, previewId, index) {
	// 	    var form = data.form, files = data.files, extra = data.extra, response = data.response, reader = data.reader;
	// 	});

	// }

	if (pathname.indexOf('add') == -1) {
		// Enable iCheck plugin for checkboxes
	    // iCheck for checkbox and radio inputs
	    $('input[type="checkbox"]').iCheck({
	    	checkboxClass: 'icheckbox_flat-blue',
	    	radioClass: 'iradio_flat-blue'
	    });

	    // Enable check and uncheck all functionality
	    $(".checkbox-toggle").click(function () {
	    	var clicks = $(this).data('clicks');
	    	if (clicks) {
	            //Uncheck all checkboxes
	            $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
	        } else {
	            //Check all checkboxes
	            $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
	        }
	        $(this).data("clicks", !clicks);
	    });
	}
	
});