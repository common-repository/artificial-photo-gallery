<?php


function artificial_gallery_metaboxes( $meta_boxes ) {
    $meta_boxes['artificial_metabox'] = array(
        'id' => 'artificial_metabox',
        'title' => 'Add Gallery Image',
        'pages' => array('photo-gallery'), // post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => 'Uplod Image',
                'desc' => 'Upload your image',
                'id' => 'upload_gallery_img',
                'type' => 'file'
            ),
        ),
    );
 
    return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'artificial_gallery_metaboxes' );

?>