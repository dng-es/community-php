// JavaScript Document
jQuery(document).ready(function(){

	$('#myCarouselA').carousel({
		interval: false
	});

	$('#myCarouselB').carousel({
		interval: false
	});

	$('#myCarousel0').carousel({
		interval: false
	});

	$('#myCarousel1').carousel({
		interval: false
	});

	$('.carousel .item').each(function(){
		var next = $(this);
		var limit = parseInt($(this).data("limit"));
		var last;
		limit = (limit > 6 ? 6 : limit);
		for (var i = 0;i<(limit - 1);i++) {
			next = next.next();
			if (!next.length) {
				next = $(this).siblings(':first');
			}

			last = next.children(':first-child').clone().appendTo($(this));
		}
		if (limit > 1) last.addClass('rightest');
	});

});