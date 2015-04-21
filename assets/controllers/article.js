$(function(){

	if (pathname.indexOf('add') > -1 || pathname.indexOf('edit') > -1) {
		
		$('.textarea').wysihtml5({
			html:true, 
			stylesheets: ["/booci/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5-editor.min.css"],
			'events': {
				'load' : function() { 
		             wysihtml5ImagePicker();
		        }
			}
		});

		$('#datetimepicker-article').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});

		$('#category').select2();

	}

	// Get and split pathname
	var splitPathname = pathname.split('/');
	var icon = { publish : "fa-globe", draft : "fa-file-text-o", trash : "fa-trash" };

	if (splitPathname[i_check]) {

		$('#'+splitPathname[i_check]).addClass('active');
		$('.box-title').html(splitPathname[i_check]);
		$('#title-icon').addClass(icon[splitPathname[i_check]]);

	} else {

		$('#list').addClass('active');
		// $('.box-title').html('List');
		$('#title-icon').addClass('fa-list-alt');

	}

	if (pathname.indexOf('all') > -1) {
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

function wysihtml5ImagePicker() {

	// Insert Image
	$('.bootstrap-wysihtml5-insert-image-modal .modal-title').prepend('<i class="fa fa-photo"></i>&nbsp; ');
	$('.bootstrap-wysihtml5-insert-image-modal > .modal-dialog').addClass('modal-lg margin-md');
	$('.bootstrap-wysihtml5-insert-image-modal .modal-footer .btn-primary').addClass('set-image');

	var layout = '<div class="nav-tabs-custom">' +
			'<ul class="nav nav-tabs">' +
				'<li class="active"><a href="#upload" data-toggle="tab">Upload Picture</a></li>' +
				'<li id="gallery-image"><a href="#gallery-box" data-toggle="tab">Gallery</a></li>' +
				'<li><a href="#url" data-toggle="tab">From URL</a></li>' +
			'</ul>' +
			'<div class="tab-content">' +
				'<div class="tab-pane active" id="upload">' +
					'<div class="profile-picture">' +
						'<div class="">' +
							'<p class="upload-notes">' +
								'Max. image size <b>100 kB</b> (160x160)' +
							'</p>' +
			                '<input name="userfile" id="profile-picture" type="file" class="file">' +
			            '</div>' +
		            '</div>' +
				'</div>' +
				'<div class="tab-pane" id="gallery-box">' +
					'<div class="pictures unloaded"></div>' +
				'</div>' +
				'<div class="tab-pane" id="url">' +
					'<div class="form-group">' +
						'<input name="url" class="form-control url-image" type="text" placeholder="Paste the picture source URL">' +
					'</div>' +
				'</div>' +
			'</div>' +
		'</div>' +
		'<input name="fix-image" id="fix-image" type="hidden"/>' +
		'<div class="image-style">' +
			'<div class="form-inline">' +
			  	'<div class="form-group">' +
			    	'<label class="form-label-inline">Width</label>' +
			    	'<input type="text" class="form-control width" placeholder="px">' +
			  	'</div>' +
			  	'<div class="form-group">' +
			    	'<label class="form-label-inline">Height</label>' +
			    	'<input type="text" class="form-control height" placeholder="px">' +
			  	'</div>' +
			  	'<div class="form-group">' +
			    	'<label class="form-label-inline">Position</label>' +
			    	'<input type="text" class="form-control position" placeholder="center, left, right">' +
			  	'</div>' +
			'</form>' +
		'</div>';

	$('.bootstrap-wysihtml5-insert-image-modal .modal-body').html(layout);

	// 1. Upload
	var uploadUrl = project + "/article/uploadPicture";

	$("#profile-picture").fileinput({
	    uploadUrl: uploadUrl,
	    uploadAsync: true,
	    maxFileCount: 5
	});

	$('#profile-picture').on('fileuploaded', function(event, data, previewId, index) {
	    var form = data.form, files = data.files, extra = data.extra, response = data.response, reader = data.reader;
	    $('#fix-image').val(domain + response.file);
	});

	// 2. Gallery
	$('#gallery-image').click(function(){

		var open = $('.pictures').hasClass('unloaded');

		if (open == true) {

			$.getJSON(project + '/article/getImage', function(result) {

		        if (result.status == true) {

		        	// console.log(result.data[]);

		        	for (var i = 0; i < result.data.length; i++) {
		        		var image = result.data[i];
		        		var last = '';
		        		if (i == 4) {
		        			last = 'last';
		        		}
		        		var img = '<img data-src="' + domain + image.src + '" class="item '+ last +'" src="' + project + '/' + image.src + '"/>';
			            $(".pictures").append(img);
		        	};

		        	if (result.remaining > 0) {
		        		var more = '<div id="more-featured-gallery" data-url="' + project + '/article/getImage/' + result.start + '" class="col-lg-12 more-center"><button class="btn btn-info btn-sm">Load More</button></div>';
			            $(".pictures").append(more);
		        	}

			        $('.pictures').jMosaic({min_row_height: 200});
			        $('img.last').removeAttr('style');
			        $('img.last').css({"margin": "5px 2px", "height": "200px"});
					$('.jMosaic-item').css({"margin": "5px 2px"});

		        }

		        $('.pictures').jMosaic({min_row_height: 200});
		        $('img.last').removeAttr('style');
		        $('img.last').css({"margin": "5px 2px", "height": "200px"});
				$('.jMosaic-item').css({"margin": "5px 2px"});

		    });
		}

		$('.pictures').removeClass('unloaded');

	});

	$(document).delegate('img.item', 'click', function(){
		var value = $(this).data('src');
		$('#fix-image').val(value);
		$('img.item').each(function(){
			$(this).removeClass('selected');
		});

		$(this).css('margin', '5px 2px');
		$(this).addClass('selected');
	});

	$(document).delegate('#more-featured-gallery', 'click', function(){
		var url = $(this).data('url');
		$.getJSON(url, function(result) {

	        if (result.status == true) {
	        	// console.log(result.data[]);

	        	for (var i = 0; i < result.data.length; i++) {
	        		var image = result.data[i];
	        		var last = '';
	        		if (i == 4) {
	        			last = 'last';
	        		}
	        		var img = '<img data-src="' + domain + image.src + '" class="item '+ last +'" src="' + project + '/' + image.src + '"/>';
		            $(".pictures").append(img);
	        	};

		        $('.pictures').jMosaic({min_row_height: 200});
		        $('img.last').removeAttr('style');
		        $('img.last').css({"margin": "5px 2px", "height": "200px"});
				$('.jMosaic-item').css({"margin": "5px 2px"});

	        }

	        if (result.remaining > 0) {
        		var more = '<div id="more-featured-gallery" data-url="' + project + '/article/getImage/' + result.start + '" class="col-lg-12 more-center"><button class="btn btn-info btn-sm">Load More</button></div>';
	            $(".pictures").append(more);
        	}

	        $('.pictures').jMosaic({min_row_height: 200});
	        $('img.last').removeAttr('style');
	        $('img.last').css({"margin": "5px 2px", "height": "200px"});
			$('.jMosaic-item').css({"margin": "5px 2px"});

	    });

		$(this).remove();

		return false;
	});

	// 3. URL
	// Get image URL by paste
	$('.url-image').on('paste', function() {
	    setTimeout(function () { 
	    	$('#fix-image').val($('.url-image').val());
	    }, 100);
	});

	// Get image URL by paste
	$('.url-image').on('keyup', function() {
	    setTimeout(function () { 
	    	$('#fix-image').val($('.url-image').val());
	    }, 100);
	});


	// Set image to editor
	$('.set-image').click(function(){
		
		var fix = $('#fix-image').val();

		var width = '100%';

		if ($('.width').val() != '') {
			width = $('.width').val();
		}

		if (fix != '') {

			var image = '<p class="wysiwyg-text-align-center">' +
					'<img width='+width+' src="' + fix + '" title="Image: ' + fix + '">' +
					'<span class="caption-image">Image ...</span>' + 
				'</p>';
			var editorObj = $(".textarea").data('wysihtml5');
			var editor = editorObj.editor;
			var current = editor.getValue();

			editor.setValue(image+current);
		}
	});
}
