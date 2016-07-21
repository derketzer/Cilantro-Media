// JavaScript Document

	 jQuery('.fullscreenbanner').revolution({
			delay:15000,
			startwidth:1170,
			startheight:500,
			hideThumbs:10,
			fullWidth:"off",
			fullScreen:"on",
			shadow:0,
			dottedOverlay:"none",
			fullScreenOffsetContainer: ""      
	 });
	 
	 
	 
	 
	 
	 
	 jQuery('.fullscreenslider').revolution({
			delay:15000,
			startwidth:1170,

			hideThumbs:10,
			fullWidth:"off",
			fullScreen:"on",
			shadow:0,
			dottedOverlay:"none",
			navigation: {
							keyboardNavigation:"off",
							keyboard_direction: "horizontal",
							mouseScrollNavigation:"off",
 							mouseScrollReverse:"default",
							onHoverStop:"off",
							touch:{
								touchenabled:"on",
								swipe_threshold: 75,
								swipe_min_touches: 1,
								swipe_direction: "horizontal",
								drag_block_vertical: false
							}
							,
							bullets: {
								enable:true,
								hide_onmobile:true,
								hide_under:960,
								style:"zeus",
								hide_onleave:false,
								direction:"horizontal",
								h_align:"right",
								v_align:"bottom",
								h_offset:80,
								
								space:5,
								
							}
						},
			// "navigation": { 
// "bullets": { 
// "enable": true,
// "style": "","hide_onleave": false,
// "direction": "horizontal","h_align": "center","v_align": "bottom","h_offset": 20,"v_offset": 30,"space": 5 } },
 
         
			fullScreenOffsetContainer: ""      
	 });						




