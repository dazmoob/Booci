$(function(){

	$('.delete-link').hide();

	$('.grid-stack').on('dragstart', function (event, ui) {
	    
		// Disable button submit
		$('#submit-links-location').attr('disabled', 'disabled');

	});

	$('.grid-stack').on('dragstop', function (event, ui) {

		var value = '';

		$('.grid-stack-item').each(function () {
		    var node = $(this).data('_gridstack_node');
		    if (typeof node == 'undefined') {
		        return;
		    } else {
			    
		    	if (value == '') {

		    		value = node.y;

		    	} else {

		    		value = value + ',' + node.y;

		    	}

		    }
		});

		$('#set-new-location').val(value);

		updateNavigationLocation();

		// Disable button submit
		$('#submit-links-location').removeAttr('disabled');

	});

	$('.get-link-data').click(function(){

		// Get all data
		var id = $(this).data('id');
		var label = $(this).data('label');
		var url = $(this).data('url');
		var clas = $(this).data('class');
		var rel = $(this).data('rel');
		var target = $(this).data('target');

		// Set value
		$('.link-id').val(id);
		$('.links[name=label]').val(label);
		$('.links[name=url]').val(url);
		$('.links[name=class]').val(clas);
		$('.links[name=rel]').val(rel);
		$('.links[name=target]').val(target);

		// Set label
		var title = 'Edit Links';
		var button = '<i class="fa fa-check-circle"></i>&nbsp; Update Link';
		var sequence = 'Change it on location links';
		$('.link-title').html(title);
		$('.link-button').html(button);
		$('.last-sequence').html(sequence);
		$('.delete-link').show();
		$('.delete-link').attr('href', project + '/settings/deleteNavigationLink/' + id);

	});

	$('#new-link').click(function(){

		// Set label
		var title = 'New Link';
		var button = '<i class="fa fa-check-circle"></i>&nbsp; Create Link';
		var sequence = $('.sequence').data('sequence');
		$('.link-id').val('true');
		$('.link-title').html(title);
		$('.link-button').html(button);
		$('.last-sequence').html(sequence);
		$('.delete-link').hide();

		// Set value to null
		$('.links').val('');

	});

});

function updateNavigationLocation() {

	var new_links = $('#set-new-location').val();
	var slug = $('#set-new-location').data('slug');

	$.post(project + '/settings/updateNavigationLocation/' + slug, {new_links: new_links}, function(result){
	
	});

}