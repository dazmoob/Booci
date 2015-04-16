$(function(){

	if (pathname.indexOf('add') > -1 || pathname.indexOf('edit') > -1) {
		
		$('.textarea').wysihtml5({html:true, stylesheets: ["/booci/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5-editor.min.css"]});

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
		$('.box-title').html('List');
		$('#title-icon').addClass('fa-list-alt');

	}

});
