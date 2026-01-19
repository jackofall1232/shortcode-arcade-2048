<?php
/**
 * Plugin Name: Shortcode Arcade 2048
 * Description: Registers assets for the 2048 game for future shortcode integration.
 * Version: 0.1.1
 * Author: Shortcode Arcade
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: shortcode-arcade-2048
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register 2048 assets for later use.
 */
function shortcode_arcade_2048_register_assets() {
	$plugin_url = plugin_dir_url( __FILE__ );

	wp_register_style(
		'shortcode-arcade-2048',
		$plugin_url . 'style/main.css',
		array(),
		'0.1.1'
	);

	wp_register_script(
		'shortcode-arcade-2048',
		$plugin_url . 'js/application.js',
		array(),
		'0.1.1',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'shortcode_arcade_2048_register_assets' );
