


// JavaScript Document

 $(".fancybox").fancybox({
		openEffect : 'elastic',
		openSpeed  : 300,

		closeEffect : 'elastic',
		closeSpeed  : 150,

		closeClick : true,

    });
	 
	 
	 //Video Popup
	 $('.fancybox-media').fancybox({
		openEffect  : 'fade',
		closeEffect : 'none',
		helpers : {
			media : {}
		}
	});
	
	
	
	//Popup with thumbnails
	$(".fancybox-thumb").fancybox({
		prevEffect	: 'none',
		nextEffect	: 'none',
	   arrows    : false,
		helpers	: {
			thumbs	: {
				width	: 50,
				height	: 50,
				type: 'inside'
			}
		}
	});
	
	
	$(".fancybox-effects-a").fancybox({
	   openEffect  : 'none',
		closeEffect : 'none',
 });