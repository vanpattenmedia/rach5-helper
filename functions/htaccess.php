<?php

/**
 * Rach5 Helper
 * .htaccess rewrites
 *
 * @version 0.4
 * @package rach5-helper
 */


/**
 * function rach5_add_rewrites
 * Ditch /wp-content/themes/themename/ and /wp-content/plugins/
 * @since 0.1
 */

function rach5_add_rewrites($content) {
	global $wp_rewrite;
	$rach5_new_non_wp_rules = array(
		'css/(.*)'      => THEME_PATH . '/css/$1',
		'js/(.*)'       => THEME_PATH . '/js/$1',
		'img/(.*)'      => THEME_PATH . '/img/$1',
		'fonts/(.*)'    => THEME_PATH . '/fonts/$1',
		'plugins/(.*)'  => RELATIVE_PLUGIN_PATH . '/$1'
	);
	$wp_rewrite->non_wp_rules = $rach5_new_non_wp_rules;
	return $content;
}


/**
 * function rach5_clean_urls
 * Clean up URLs
 * @since 0.1
 */

function rach5_clean_urls($content) {
	if (strpos($content, FULL_RELATIVE_PLUGIN_PATH) === 0) {
		return str_replace(FULL_RELATIVE_PLUGIN_PATH, WP_BASE . '/plugins', $content);
	} else {
		return str_replace('/' . THEME_PATH, '', $content);
	}
}

// Only use clean URLs if the theme isn't a multisite install
// Originally this also checks for child themes as well, but that breaks in the plugin
if (!is_multisite()) {
	add_action('generate_rewrite_rules', 'rach5_add_rewrites');
	if (!is_admin()) {
		$tags = array(
			'plugins_url',
			'bloginfo',
			'stylesheet_directory_uri',
			'template_directory_uri',
			'script_loader_src',
			'style_loader_src'
		);
		add_filters($tags, 'rach5_clean_urls');
	}
}
