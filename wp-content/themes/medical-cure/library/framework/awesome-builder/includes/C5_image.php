<?php
if (!function_exists('c5ab_generate_image_size')) {

    function c5ab_generate_image_size($width = 960 , $height = 960 , $crop = true ) {
        if($crop){
            $array = array(
                'slug' => 'custom_image_size_crop_' . $width . 'x' . $height ,
                'width' => $width,
                'height' => $height,
                'crop' => true,
            );
        }else {
            $array = array(
                'slug' => 'custom_image_size_' . $width . 'x' . $height ,
                'width' => $width,
                'height' => $height,
                'crop' => false,
            );

        }


        add_image_size($array['slug'] , $array['width'] , $array['height'], $array['crop']);

        return $array['slug'];

    }

}
if (!function_exists('c5ab_get_attachment_id_from_src')) {

    function c5ab_get_attachment_id_from_src ($attachment_src) {
        global $wpdb;

        $id = '';
        if ( false === ( $id = get_transient( 'c5_image_src' . $attachment_src ) ) ) {

            $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$attachment_src'";
            $id = $wpdb->get_var($query);
            if (isset($id)) {
                set_transient( 'c5_image_src' . $attachment_src  , $id, 12 * HOUR_IN_SECONDS );
            }
        }


        if ($id == '' && is_ssl()) {
            $attachment_src = str_replace('https://', 'http://' , $attachment_src);
            $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$attachment_src'";
            $id = $wpdb->get_var($query);
            if (isset($id)) {
                set_transient( 'c5_image_src' . $attachment_src  , $id, 12 * HOUR_IN_SECONDS );
            }
        }

        return $id;
    }

}

if (!function_exists('c5ab_get_attachment_id_from_file_name')) {
    function c5ab_get_attachment_id_from_file_name($file_name)
    {
        
        $id = false;
        $args = array(
            'post_type'   => 'attachment',
            'post_status' => 'inherit',
            'meta_query'  => array(
                array(
                    'key'     => '_wp_attachment_metadata',
                    'value'   => $file_name,
                    'compare' => 'LIKE'
                )
            )
        );
        $attachment_query = new WP_Query( $args );

        // The Loop
        if ( $attachment_query->have_posts() ) {
            while ( $attachment_query->have_posts() ) {
                $attachment_query->the_post();
                $id = get_the_ID();
            }
            /* Restore original Post Data */
            wp_reset_postdata();
        } else {
            // no posts found
        }
        $attachment_query->reset_postdata();


        return $id;
    }

}
if (!function_exists('c5_generate_image')) {

    function c5_generate_image($width,$height,$link,$crop) {
        $img_id = c5ab_get_attachment_id_from_src($link);

        if($img_id!=''){
            $image_data = c5_resize($img_id, $width, $height, $crop);
        }else {
            $image_data = array(
                'src' => $link,
                'src_2x' => '',
                'width' => '',
                'height' => ''
            );
        }
        return $image_data;
    }
}
if (!function_exists('c5_get_the_post_thumbnail')) {

    function c5_get_the_post_thumbnail($post_id , $image_size) {
        $post_thumbnail_id = get_post_thumbnail_id($post_id);

        $img = '';
        global $_wp_additional_image_sizes;

        if (isset($_wp_additional_image_sizes[$image_size])) {
            $size =  $_wp_additional_image_sizes[$image_size] ;

            $img_data = c5_resize($post_thumbnail_id, $size['width'], $size['height'], $size['crop']);
            // print_r($img_data);
            $image_url = array(
                $img_data['src'],
                $img_data['width'],
                $img_data['height'],
                $img_data['src_2x']
            );


        }
    }
}
if (!function_exists('c5_wp_get_attachment_image_src')) {

    function c5_wp_get_attachment_image_src($attachment_id , $image_size) {
        if ($attachment_id == '') {
            return false;
        }
        global $_wp_additional_image_sizes;
        if (isset($_wp_additional_image_sizes[$image_size])) {

            $size =  $_wp_additional_image_sizes[$image_size] ;

            $img_data = c5_resize($attachment_id, $size['width'], $size['height'], $size['crop']);

            $image_data = array(
                $img_data['src'],
                $img_data['width'],
                $img_data['height'],
                $img_data['src_2x']
            );


            return $image_data;
        }
        return false;
    }
}
if (!function_exists('c5_resize')) {

    function c5_resize( $attachment_id, $width, $height, $crop = true )
    {

        $meta = wp_get_attachment_metadata($attachment_id);
        if(!$meta){
            return false;
        }
        $new_image_dimen = image_resize_dimensions( $meta['width'], $meta['height'], $width, $height, $crop );

        if (!$new_image_dimen) {
            $height = $meta['height'];
            $width = $meta['width'];
        }else{
            $height = $new_image_dimen[5];
            $width = $new_image_dimen[4];
        }

        // Get upload directory info
        $upload_info = wp_upload_dir();
        $upload_dir  = $upload_info['basedir'];
        $upload_url  = set_url_scheme( $upload_info['baseurl'] );

        // Get file path info
        $path      = get_attached_file( $attachment_id );
        $path_info = pathinfo( $path );
        $ext       = $path_info['extension'];
        $rel_path  = str_replace( array( $upload_dir, ".$ext" ), '', $path );
        $suffix    = "{$width}x{$height}";
        $dest_path = "{$upload_dir}{$rel_path}-{$suffix}.{$ext}";
        $url       = "{$upload_url}{$rel_path}-{$suffix}.{$ext}";

        $height_2x = 2*$height;
        $width_2x = 2*$width;

        $suffix_2x    = "{$width_2x}x{$height_2x}";
        $dest_path_2x = "{$upload_dir}{$rel_path}-{$suffix_2x}.{$ext}";
        $url_2x       = "{$upload_url}{$rel_path}-{$suffix_2x}.{$ext}";

        $return_array = array( );
        $return_array['width'] = $width;
        $return_array['height'] = $height;

        // If file exists: do nothing
        if ( file_exists( $dest_path ) ){

            $return_array['src'] = $url;
        }elseif (image_make_intermediate_size( $path, $width, $height, $crop )) {
            $sample_data =  image_make_intermediate_size( $path, $width, $height, $crop );
            $x2_width = $sample_data['width'];
            $x2_height = $sample_data['height'];

            $suffix_2x    = "{$x2_width}x{$x2_height}";
            $url       = "{$upload_url}{$rel_path}-{$suffix_2x}.{$ext}";
            $return_array['src'] = $url;
        }else{
            $return_array['src'] = $upload_url . '/' . $meta['file'];
        }

        if ( file_exists( $dest_path_2x ) ){

            $return_array['src_2x'] = $url_2x;
        }elseif (image_make_intermediate_size( $path, $width_2x, $height_2x, $crop )) {

            $sample_data =  image_make_intermediate_size( $path, $width_2x, $height_2x, $crop );
            $x2_width = $sample_data['width'];
            $x2_height = $sample_data['height'];

            $suffix_2x    = "{$x2_width}x{$x2_height}";
            $url_2x       = "{$upload_url}{$rel_path}-{$suffix_2x}.{$ext}";
            $return_array['src_2x'] = $url_2x;
        }else{
            $return_array['src_2x'] = $upload_url . '/' . $meta['file'];
        }

        if (is_ssl()) {
            $return_array['src'] = str_replace('http://', 'https://', $return_array['src'] );
            $return_array['src_2x'] = str_replace('http://', 'https://', $return_array['src_2x'] );
        }

        return $return_array;

    }
}



?>
