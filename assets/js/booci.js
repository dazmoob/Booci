$('.confirm').click(function(e){
		
	e.preventDefault();
	button = $(this);
	text = "Are you sure want to delete ?";
	icon = '<span class="fa-stack">' +
				'<i class="fa fa-circle fa-stack-2x text-red"></i>' + 
				'<i class="fa fa-trash fa-stack-1x fa-inverse"></i>' +
			'</span>';

	if (button.data('icon'))
		icon = '<span class="fa-stack">' +
					'<i class="fa fa-circle fa-stack-2x text-red"></i>' + 
					'<i class="fa ' + button.data('icon') + ' fa-stack-1x fa-inverse"></i>' +
				'</span>';

	if (button.data('text'))
		text = "Are you sure want to " + button.data('text') + " ?";

	bootbox.dialog({
		title: icon + " Confirmation",
		message: text,
		buttons: {
			cancel: {
				label: "Cancel",
				className: "btn-default",
				callback: function() {}
			},
			success: {
				label: "OK",
				className: "btn-danger",
				callback: function(result) {
					if (button.attr('href'))
						window.location = button.attr('href');
				}
			}
		}
	});

})