$(function(){

	$('#input-category').on('keypress', function(e) {
		var code = e.keyCode || e.which; 
		if (code == 13) {               
			e.preventDefault();
			createCategory();
			return false;
		}
	});

	$('#submit-category').click(function(e){
		e.preventDefault();
		createCategory();
		return false;
	});

});

function createCategory() {

	var name = $('#input-category').val();
	
	$.post(project + '/category/ajaxCreate', {name: name}, function(result){
		$('#category').append('<option value="'+ result.id +'">'+ result.category +'</option>');
	}, 'json');

}