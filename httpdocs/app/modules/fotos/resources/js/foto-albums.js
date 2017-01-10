jQuery(document).ready(function(){
	$('.grid').masonry({
		// options
		itemSelector: '.grid-item',
		gutter: 15,
		// use outer width of grid-sizer for columnWidth
		columnWidth: '.card-section',
		percentPosition: true
	});
});