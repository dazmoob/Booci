$(function(){

	// Edit action
	$('.edit-media').click(function(){

		// Get all data value
		var id = $(this).data('id');
		var title = $(this).data('title');
		var filename = $(this).data('filename');
		var description = $(this).data('description');
		var type = $(this).data('type');
		var src = $(this).data('src');
		var created_time = $(this).data('created-time');
		var created_by = $(this).data('created-by');
		var updated_time = $(this).data('updated-time');
		var updated_by = $(this).data('updated-by');

		// Set preview
		if (type == 'image') {
            preview = '<div class="img-list-a">' +
                    '<img class="img-part" src="' + src + '"/>' +
                '</div>';
		}
        
        else if (type == 'file') {
        	preview = '<p class="center">' +
	        		'<a href="' + src + '">' + src + '</a>' +
	        	'</p>';
        }

        else if (type == 'audio') {
        	preview = '<audio controls>' +
				  	'<source src="' + src + '">' +
					'Your browser does not support the audio element.' +
				'</audio>';
        }

		else if (type == 'video') {
        	preview = '<video controls>' +
				  	'<source src="' + src + '">' +
					'Your browser does not support the video element.' +
				'</video>';
		}

		$('#edit-preview').html(preview);

		// Set input
		$('#edit-form').attr('action', domain + 'media/update/' + filename);
		$('input[name="title"]').val(title);
		$('input[name="type"]').val(type);
		$('textarea[name="description"]').html(description);

		// Set info
		created_by = '<a href="' + domain + 'profile/' + created_by + '">' + created_by + '</a>';
		updated_by = '<a href="' + domain + 'profile/' + updated_by + '">' + updated_by + '</a>';

		$('#edit-filename').html(filename);
		$('#edit-type').html(type);
		$('#edit-created-by').html(created_by);
		$('#edit-created-time').html(created_time);
		$('#edit-updated-by').html(updated_by);
		$('#edit-updated-time').html(updated_time);

	});

	if (pathname.indexOf('add') > -1) {

		var uploadUrl = project + "/media/uploadFiles";

		$("#upload-files").fileinput({
		    uploadUrl: uploadUrl,
		    uploadAsync: true,
		    maxFileCount: 5
		});

		$('#upload-files').on('fileuploaded', function(event, data, previewId, index) {
		    var form = data.form, files = data.files, extra = data.extra, response = data.response, reader = data.reader;
		});

	}
	
});