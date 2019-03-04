( function( $ ) {
    'use strict';

	// init masonry
	$(document).ready(function(){
		
		$('.kenzap-blog-4 .grid').masonry({
			itemSelector: '.blog-item',
			columnWidth: '.grid-sizer',
			percentPosition: true,
			horizontalOrder: true
		});
	});

}( jQuery ) );