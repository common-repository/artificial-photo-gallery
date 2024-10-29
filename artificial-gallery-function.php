<?php
/*
	Plugin Name: Artificial Photo Gallery
	Plugin URI: http://rapiditsolution.ciki.me/rapid/artificial-photo-gallery/
	Author: Reyad H
	Author URI: http://www.rapiditsolution.ciki.me/rapid
	Description: This plugin will enable photo gallery slider in your WordPress theme. In this plugin you can find some awesome features. 
	Version: 1.0
*/

function artificial_photo_gallery_wp_jquery(){
	wp_enqueue_script ( 'jquery' );
}
add_action ( 'wp_head', 'artificial_photo_gallery_wp_jquery' );

define('ARTIFICIAL_PHOTO_GALLERY_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

wp_enqueue_script ( 'artificial-photo-gallery-easing-js' , ARTIFICIAL_PHOTO_GALLERY_PLUGIN_PATH.'js/jquery.easing.1.3.js', array( 'jquery' ));

wp_enqueue_script ( 'artificial-photo-gallery-galleryview-js' , ARTIFICIAL_PHOTO_GALLERY_PLUGIN_PATH.'js/jquery.galleryview-3.0-dev.js', array( 'jquery' ));

wp_enqueue_script ( 'artificial-photo-gallery-timers-js' , ARTIFICIAL_PHOTO_GALLERY_PLUGIN_PATH.'js/jquery.timers-1.2.js', array( 'jquery' ));


wp_enqueue_style ( 'artificial-photo-gallery-galleryview-css' , ARTIFICIAL_PHOTO_GALLERY_PLUGIN_PATH.'css/jquery.galleryview-3.0-dev.css');



// Photo Gallery Custom Post
function artificial_photo_gallery_post() {

	$labels = array(
		'name' => ( 'Photo Gallery'),
		'singular_name' => ( 'Photo gallery'),
		'add_new' => ( 'Add New Photo'),
		'add_new_item' => ( 'Add New Photo'),
		'edit_item' => ( 'Edit Photo'),
		'new_item' => ( 'New Photo'),
		'view_item' => ( 'View Photo'),
		'search_items' => ( 'Search Gallery Photo'),
		'not_found' => ( 'No Gallery Photo Found'),
		'not_found_in_trash' => ( 'No photo found in Trash'),
		'parent_item_colon' => ( 'Parent photo:'),
		'menu_name' => ( 'Artificial Gallery'),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'Add your gallery photo!',
		'supports' => array( 'title', 'custom-fields'),

		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'photo-gallery', $args );
}

add_action( 'init', 'artificial_photo_gallery_post' );


// Photo Gallery Taxonomy
function artificial_photo_gallery_taxonomy() {
	register_taxonomy(
		'gallery_cat', 'photo-gallery',             
		array(
			'hierarchical'          => true,
			'label'                         => 'Gallery Category',
			'query_var'             => true,
			'rewrite'                       => array(
				'slug'                  => 'gallery-cat', 
				'with_front'    => true 
				)
			)
	);
}
add_action( 'init', 'artificial_photo_gallery_taxonomy');  



function artificial_gallery_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'cmb/init.php';

}
add_action( 'init', 'artificial_gallery_meta_boxes', 9999 );

function photo_gallery_metaboxes( $meta_boxes ) {
    $meta_boxes['gallery_metabox'] = array(
        'id' => 'gallery_metabox',
        'title' => 'Add Gallery Image ',
        'pages' => array('photo-gallery'),
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, 
        'fields' => array(
            array(
                'name' => 'Add Image ',
                'desc' => 'Upload your gallery image',
                'id' => 'gallery_image',
                'type' => 'file'
            ),
            array(
                'name' => 'Add Image Description',
                'desc' => 'Write something about your image',
                'id' => 'image_des',
                'type' => 'textarea'
            ),
        ),
    );
 
    return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'photo_gallery_metaboxes' );


// Loop

function artificial_photo_gallery_shortcode(){

    $q = new WP_Query(
        array('posts_per_page' => '-1', 'post_type' => 'photo-gallery', 'gallery_cat' => '')
        );		
		
	$list = '	
	<ul id="myGallery">';
	while($q->have_posts()) : $q->the_post();
		$gallery_thumb = get_post_meta(get_the_ID(), 'gallery_image', true);
		$photo_des = get_post_meta(get_the_ID(), 'image_des', true);
		$list .= '
		
				<li>
					<img data-frame="'.$gallery_thumb.'" src="'.$gallery_thumb.'" title="'.get_the_title().'" data-description="'.$photo_des.'" />
				</li>
		
		';        
	endwhile;
	$list.= '</ul>';
	wp_reset_query();
	return $list;
}
add_shortcode('artificial-gallery', 'artificial_photo_gallery_shortcode');


/* Theme options  START*/

function artificial_photo_gallery_options_framwrork()  
{  
	add_options_page('Artificial Photo Gallery', 'Artificial Photo Gallery Options', 'manage_options', 'artificialphotogallery-settings','artificial_photogallery_options_framwrork');  
}  
add_action('admin_menu', 'artificial_photo_gallery_options_framwrork');

// Default options values
$artificialphotogallery_options = array(
		'width' => 800,
		'height' => 500,
		'panel_smoothness' => 15,
		'position' => 'bottom'

);


if ( is_admin() ) : // Load only if we are viewing an admin page

function artificialphotogallery_register_settings() {
	// Register settings and call sanitation functions
	register_setting( 'artificial_photo_gallery_p_options', 'artificialphotogallery_options', 'artificialphotogallery_validate_options' );
}

add_action( 'admin_init', 'artificialphotogallery_register_settings' );


// Function to generate options page
function artificial_photogallery_options_framwrork() {
	global $artificialphotogallery_options;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap" id="kanicon">

	<h2 style="border-bottom:4px solid #1E8CBE; padding-bottom:5px;">Artificial Photo Gallery</h2>
	<div style="margin: 10px auto; width: 728px;">
		<a href="http://codecanyon.net/?ref=reyad_n" target="_blank"><img src="http://rapiditsolution.ciki.me/rapid/wp-content/uploads/2014/05/728x90_V2-1.jpg" alt="Premium WordPress Plugin" /></a>
	</div>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<form method="post" action="options.php">

	<?php $settings = get_option( 'artificialphotogallery_options', $artificialphotogallery_options ); ?>
	
	<?php settings_fields( 'artificial_photo_gallery_p_options' ); ?>

	
	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
	
		
		<tr valign="top">
			<th scope="row"><label for="width">Gallery Panel Width</label></th>
			<td>
				<input id="width" type="text" name="artificialphotogallery_options[width]" value="<?php echo stripslashes($settings['width']); ?>" /><p class="description">Put width of gallery panel here(example: 800). Default value is 800.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="height">Gallery Panel Height</label></th>
			<td>
				<input id="height" type="text" name="artificialphotogallery_options[height]" value="<?php echo stripslashes($settings['height']); ?>" /><p class="description">Put height of gallery panel here(example: 500). Default value is 500.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="panel_smoothness">Panel Smoothness</label></th>
			<td>
				<input id="panel_smoothness" type="text" name="artificialphotogallery_options[panel_smoothness]" value="<?php echo stripslashes($settings['panel_smoothness']); ?>" /><p class="description">Determines smoothness of tracking pan animation (higher number = smoother).</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="position">Thumbnail Position</label></th>
			<td>
				<input id="position" type="text" name="artificialphotogallery_options[position]" value="<?php echo stripslashes($settings['position']); ?>" /><p class="description">Put gallery thumbnail position here(example: bottom). Default value is bottom. You can move thumbnail in left, top, right, bottom.</p>
			</td>
		</tr>

		
	</table>

	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

	</form>

	</div>

	<?php
}

function artificialphotogallery_validate_options( $input ) {
	global $artificialphotogallery_options;

	$settings = get_option( 'artificialphotogallery_options', $artificialphotogallery_options );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS

	$input['width'] = wp_filter_post_kses( $input['width'] );
	$input['height'] = wp_filter_post_kses( $input['height'] );
	$input['panel_smoothness'] = wp_filter_post_kses( $input['panel_smoothness'] );
	$input['position'] = wp_filter_post_kses( $input['position'] );


		
		
	
	return $input;
}

endif;  // EndIf is_admin()

include_once('gallery-functions.php');

/* Theme options  END*/

function artificial_hide_meta_boxes() {
     remove_meta_box('postcustom','photo-gallery','normal');
}

add_action('admin_init','artificial_hide_meta_boxes');

?>