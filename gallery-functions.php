<?php
function artificial_photo_gallery_active_option() { ?>
<?php global $artificialphotogallery_options; $artificialphotogallery_settings = get_option( 'artificialphotogallery_options', $artificialphotogallery_options ); ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		  jQuery('#myGallery').galleryView({
		transition_speed: 2000, 		
		transition_interval: 4000, 
		easing: 'swing', // linear
		show_panels: true, 				//BOOLEAN - flag to show or hide panel portion of gallery
		show_panel_nav: true, 			//BOOLEAN - flag to show or hide panel navigation buttons
		enable_overlays: true, 			//BOOLEAN - flag to show or hide panel overlays
		
		panel_width: <?php echo $artificialphotogallery_settings['width']; ?>, 				//INT - width of gallery panel (in pixels)
		panel_height: <?php echo $artificialphotogallery_settings['height']; ?>, //INT - height of gallery panel (in pixels)
		panel_animation: 'crossfade', 		//STRING - animation method for panel transitions (crossfade,fade,slide,none)
		panel_scale: 'crop', 			//STRING - cropping option for panel images (crop = scale image and fit to aspect ratio determined by panel_width and panel_height, fit = scale image and preserve original aspect ratio)
		overlay_position: 'bottom', 	//STRING - position of panel overlay (bottom, top)
		pan_images: true,				//BOOLEAN - flag to allow user to grab/drag oversized images within gallery
		pan_style: 'drag',				//STRING - panning method (drag = user clicks and drags image to pan, track = image automatically pans based on mouse position
		pan_smoothness: <?php echo $artificialphotogallery_settings['panel_smoothness']; ?>,				//INT - determines smoothness of tracking pan animation (higher number = smoother)
		start_frame: 1, 				//INT - index of panel/frame to show first when gallery loads
		show_filmstrip: true, 			//BOOLEAN - flag to show or hide filmstrip portion of gallery
		show_filmstrip_nav: true, 		//BOOLEAN - flag indicating whether to display navigation buttons
		enable_slideshow: true,			//BOOLEAN - flag indicating whether to display slideshow play/pause button
		autoplay: true,				//BOOLEAN - flag to start slideshow on gallery load
		show_captions: true, 			//BOOLEAN - flag to show or hide frame captions	
		filmstrip_size: 3, 				//INT - number of frames to show in filmstrip-only gallery
		filmstrip_style: 'scroll', 		//STRING - type of filmstrip to use (scroll = display one line of frames, scroll filmstrip if necessary, showall = display multiple rows of frames if necessary)
		filmstrip_position: '<?php echo $artificialphotogallery_settings['position']; ?>', 	//STRING - position of filmstrip within gallery (bottom, top, left, right)
		frame_width: 164, 				//INT - width of filmstrip frames (in pixels)
		frame_height: 80, 				//INT - width of filmstrip frames (in pixels)
		frame_opacity: 0.5, 			//FLOAT - transparency of non-active frames (1.0 = opaque, 0.0 = transparent)
		frame_scale: 'crop', 			//STRING - cropping option for filmstrip images (same as above)
		frame_gap: 5, 					//INT - spacing between frames within filmstrip (in pixels)
		show_infobar: true,				//BOOLEAN - flag to show or hide infobar
		infobar_opacity: 1				//FLOAT - transparency for info bar
		});
		});
</script>
<?php
}
add_action('wp_head', 'artificial_photo_gallery_active_option');

?>