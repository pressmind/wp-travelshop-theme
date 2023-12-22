<?php
/**
 * This hook will abort all image uploads that have a filesize bigger than the defined value.
 * it's protects the website performance against st*p*d users.
 */
add_filter('wp_handle_upload_prefilter', function ($file) {

    /**
     * This is a workaround for the deprecated function utf8_encode() in the WordPress Core
     * Deprecated Function utf8_encode() is deprecated in /wp-admin/includes/image.php< on line 930
     */
    error_reporting(E_ALL ^ E_DEPRECATED);

    if(TS_WP_IMAGE_MAX_UPLOAD_SIZE == null){
        return $file;
    }
    $is_image = strpos($file['type'], 'image') !== false;
    if ($is_image && ($file['size'] / 1024) > TS_WP_IMAGE_MAX_UPLOAD_SIZE) {
        $file['error'] = 'Das Bild ist zu groß ('.(round($file['size'] / 1024,0)).'kb). 
        Es ist maximal eine Größe von ' . TS_WP_IMAGE_MAX_UPLOAD_SIZE.'kb erlaubt. Wir schützen mit dieser 
        Sperre die Performance, die User-Experience und das Ranking der Website.';
    }
    return $file;
});

/**
 * This hook will reduce the original images after upload to the defined size
 * it's protects the website performance against st*p*d users.
 */
add_filter( 'wp_handle_upload', function($data){
    if(!isset($data['file']) || !isset($data['type']) || TS_WP_IMAGE_ORIGINAL_RESIZE_TO === null){
        return $data;
    }
    if( in_array( $data['type'], [ 'image/jpg', 'image/jpeg' ] ) )
    {
        $image_editor = wp_get_image_editor( $data['file'] );
        $size = $image_editor->get_size();
        if( ! is_wp_error( $image_editor ) ) {
            if ((isset($size['width']) && $size['width'] > TS_WP_IMAGE_ORIGINAL_RESIZE_TO) ||
                (isset($size['height']) && $size['height'] > TS_WP_IMAGE_ORIGINAL_RESIZE_TO)) {
                $image_editor->resize(TS_WP_IMAGE_ORIGINAL_RESIZE_TO, TS_WP_IMAGE_ORIGINAL_RESIZE_TO, false);
                // $image_editor->set_quality(100);
                $image_editor->save($data['file']);
            }
        }
    }
    return $data;
});

/**
 * Create webp images during upload
 */
add_filter( 'wp_generate_attachment_metadata', function ($meta) {
    if(!isset($meta['file'])){
        return $meta;
    }
    $pathinfo = pathinfo($meta['file']);
    if(in_array($pathinfo['extension'], ['jpg', 'jpeg']) !== true && TS_WP_IMAGE_WEBP_ENABLED === true){
        return $meta;
    }
    $upload_dir = wp_get_upload_dir();
    $files = [];
    $files[] = $upload_dir['path'].'/'.$pathinfo['basename'];
    foreach($meta['sizes'] as $size){
        $files[] = $upload_dir['path'].'/'.$size['file'];
    }
    foreach($files as $file){
        $pathinfo = pathinfo($file);
        $new_name = $upload_dir['path'].'/'.$pathinfo['filename'].'.webp';
        $image = imagecreatefromjpeg($file);
        imagewebp($image, $new_name, TS_WP_IMAGE_WEBP_QUALITY);
        imagedestroy($image);
    }
    return $meta;
});