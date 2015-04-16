$(document).ready(function() {
	// $('.thumbnails').jMosaic({items_type: "li", min_row_height: 200, is_first_big: true});

	$('#choose-featured').click(function(){

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
		        		var img = '<img data-src="' + image.src + '" class="item '+ last +'" src="' + project + '/' + image.src + '"/>';
			            $(".pictures").append(img);
		        	};

		        	if (result.remaining > 0) {
		        		var more = '<div id="more-featured" data-url="' + project + '/article/getImage/' + result.start + '" class="col-lg-12 more-center"><button class="btn btn-info btn-sm">Load More</button></div>';
			            $(".pictures").append(more);
		        	}

			        $('.pictures').jMosaic({min_row_height: 200});
			        $('img.last').removeAttr('style');
			        $('img.last').css({"margin": "5px 2px", "height": "200px"});
					$('.jMosaic-item').css({"margin": "5px 2px"});

		        }
		    });
		}

		$('.pictures').removeClass('unloaded');

	});

	$(document).delegate('img.item', 'click', function(){
		var value = $(this).data('src');
		$('#choosen').val(value);
		$('img.item').each(function(){
			$(this).removeClass('selected');
		});

		$(this).css('margin', '5px 2px');
		$(this).addClass('selected');
	});

	$('#choose-picture').click(function(){
		var value = $('#choosen').val();
		$('.featured-show').html('<img class="img-responsive bottom-sm" src="' + project + '/' + value + '">');
		$('#featured-image').val(value);
		$('#choose-featured').html('<i class="fa fa-camera"></i>&nbsp; Replace');
		$('#remove-featured').removeClass('hide');
	});

	$('#remove-featured').click(function(){
		$('.featured-show').html('');
		$('#featured-image').val();
		$('#remove-featured').addClass('hide');
		$('#choose-featured').html('<i class="fa fa-camera"></i>&nbsp; Choose Image');
	});

	$(document).delegate('#more-featured', 'click', function(){
		var url = $(this).data('url');
		$.getJSON(url, function(result) {

	        if (result.status == true) {

	        	$('#more-featured').remove();

	        	// console.log(result.data[]);

	        	for (var i = 0; i < result.data.length; i++) {
	        		var image = result.data[i];
	        		var last = '';
	        		if (i == 4) {
	        			last = 'last';
	        		}
	        		var img = '<img class="item '+ last +'" src="' + project + '/' + image.src + '"/>';
		            $(".pictures").append(img);
	        	};

		        $('.pictures').jMosaic({min_row_height: 200});
		        $('img.last').removeAttr('style');
		        $('img.last').css({"margin": "5px 2px", "height": "200px"});
				$('.jMosaic-item').css({"margin": "5px 2px"});

	        }

	        if (result.remaining > 0) {
        		var more = '<div id="more-featured" data-url="' + project + '/article/getImage/' + result.start + '" class="col-lg-12 more-center"><button class="btn btn-info btn-sm">Load More</button></div>';
	            $(".pictures").append(more);
        	}

	        $('.pictures').jMosaic({min_row_height: 200});
	        $('img.last').removeAttr('style');
	        $('img.last').css({"margin": "5px 2px", "height": "200px"});
			$('.jMosaic-item').css({"margin": "5px 2px"});

	    });
	});

});		