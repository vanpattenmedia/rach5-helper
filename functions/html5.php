<?php

// ------------------------------------------------------------ //
//
//    Rach5
//    http://www.vanpattenmedia.com/projects/rach5/
//
//    Functions: HTML5 support
//
// ------------------------------------------------------------ //

/**
 * function rach5_remove_self_closing_tags
 * Remove self-closing <img> and <input> tags
 * @since 0.1
 */

function rach5_remove_self_closing_tags($input) {
	return str_replace(' />', '>', $input);
}
add_filter('get_avatar', 'rach5_remove_self_closing_tags');
add_filter('comment_id_fields', 'rach5_remove_self_closing_tags');
add_filter('post_thumbnail_html', 'rach5_remove_self_closing_tags');


/**
 * function rach5_remove_self_closing_tags_2
 * Remove self-closing <img> and <input> tags in content
 * @since 0.1
 */

function rach5_remove_self_closing_tags_2( $content ) {
    return str_replace( ' />', '>', $content );
}
add_filter( 'the_content', 'rach5_remove_self_closing_tags_2', 25 );


/**
 * function rach5_img_caption_shortcode
 * HTML5 compatible image caption
 * @since 0.1
 */

function rach5_img_caption_shortcode($val, $attr, $content = null) {
	extract(shortcode_atts(array(
		'id'		=> '',
		'align'		=> '',
		'width'		=> '',
		'caption' 	=> ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $val;

	$capid = '';
	if ( $id ) {
		$id = esc_attr($id);
		$capid = 'id="figcaption_'. $id . '" ';
		$id = 'id="' . $id . '" ';
	}

	if ( $width ) {
		$width = esc_attr($width);
		$width = 'style="width: ' . $width . 'px" ';
	}

	return '<figure ' . $id . $width . 'class="wp-caption ' . esc_attr($align) . '">' . do_shortcode( $content ) . '<figcaption ' . $capid
	. 'class="wp-caption-text">' . $caption . '</figcaption></figure>';
}
add_filter('img_caption_shortcode', 'rach5_img_caption_shortcode',10,3);