jQuery(document).ready(function( $ ) {

	// Slicknav init
	$('#main-menu').slicknav({
		prependTo: '#site-navigation .container',
		label: ''
	});

	// Instagram Widget in the footer - calculate width based on number of images
	function instaWidth() {
		var pics = $('.footer-instagram .instagram-pics li'),
			count =  pics.length,
			width = 100 / count;

		pics.each(function() {
			$(this).css('width', width + '%');
		});
	}

	instaWidth();


	// Back to top button 
	var btnTop = $('.btn-back-top a');

	$(window).scroll( function(){
		var y = $(window).scrollTop();
		if( y > 400  ) {
			btnTop.fadeIn();
		} else {
			btnTop.fadeOut();
		}
	});

	btnTop.click(function(el) {
		$('html, body').finish().animate({
			scrollTop:0
		}, 700);
		el.preventDefault();
	});

	// FitVids init
	$('article').fitVids();

});