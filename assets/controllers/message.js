$(function(){

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

	// Edit action
	$('.open-message').click(function(){

		// Get all data value
		var id = $(this).data('id');
		var name = $(this).data('name');
		var email = $(this).data('email');
		var url = $(this).data('url');
		var title = $(this).data('title');
		var content = $(this).data('content');
		var state = $(this).data('state');
		var solve = $(this).data('solve');
		var type = $(this).data('type');
		var created_time = $(this).data('created-time');

		var current = $(this).parents('tr').find('.label-state');

		if (state == 'unread') {

			var new_state = 'read';
			var label = '<i class="fa fa-circle"></i> Read';
			$.post(project + '/message/update/' + id + '/ajax', {state: new_state}, function(result){

				if (result.alert == 'success') {
					current.addClass('label-primary');
					current.html(label);
				}
				
			}, 'json');

		}

		// Set input
		$('#show-form').attr('action', domain + 'message/update/' + id);

		// Set info
		sender = '<a href="mailto:' + email + '">' + name + '</a>';

		$('#show-name').html(sender);
		$('#show-email').html(email);
		$('#show-url').html(url);
		$('#show-type').html(type);
		$('#show-title').html(title);
		$('#show-content').html(content);
		$('#show-created-time').html(created_time);
		$('#show-solve').html(solve);
		$('#show-solve').val(solve);

	});

});