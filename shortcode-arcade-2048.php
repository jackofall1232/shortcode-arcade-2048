<?php
/**
 * Plugin Name: Shortcode Arcade 2048
 * Description: Provides the 2048 game via a shortcode with conditional asset loading.
 * Version: 0.1.2
 * Author: Shortcode Arcade
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: shortcode-arcade-2048
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue 2048 assets for the shortcode.
 */
function shortcode_arcade_2048_enqueue_assets() {
	$plugin_url = plugin_dir_url( __FILE__ );
	$version    = '0.1.2';

	wp_enqueue_style(
		'sacga_2048_main',
		$plugin_url . 'style/main.css',
		array(),
		$version
	);

	wp_enqueue_script(
		'sacga_2048_animframe',
		$plugin_url . 'js/animframe_polyfill.js',
		array(),
		$version,
		true
	);

	wp_enqueue_script(
		'sacga_2048_bind',
		$plugin_url . 'js/bind_polyfill.js',
		array( 'sacga_2048_animframe' ),
		$version,
		true
	);

	wp_enqueue_script(
		'sacga_2048_classlist',
		$plugin_url . 'js/classlist_polyfill.js',
		array( 'sacga_2048_bind' ),
		$version,
		true
	);

	wp_enqueue_script(
		'sacga_2048_keyboard_input',
		$plugin_url . 'js/keyboard_input_manager.js',
		array( 'sacga_2048_classlist' ),
		$version,
		true
	);

	wp_enqueue_script(
		'sacga_2048_html_actuator',
		$plugin_url . 'js/html_actuator.js',
		array( 'sacga_2048_keyboard_input' ),
		$version,
		true
	);

	wp_enqueue_script(
		'sacga_2048_grid',
		$plugin_url . 'js/grid.js',
		array( 'sacga_2048_html_actuator' ),
		$version,
		true
	);

	wp_enqueue_script(
		'sacga_2048_tile',
		$plugin_url . 'js/tile.js',
		array( 'sacga_2048_grid' ),
		$version,
		true
	);

	wp_enqueue_script(
		'sacga_2048_local_storage',
		$plugin_url . 'js/local_storage_manager.js',
		array( 'sacga_2048_tile' ),
		$version,
		true
	);

	wp_enqueue_script(
		'sacga_2048_game_manager',
		$plugin_url . 'js/game_manager.js',
		array( 'sacga_2048_local_storage' ),
		$version,
		true
	);

	wp_enqueue_script(
		'sacga_2048_application',
		$plugin_url . 'js/application.js',
		array( 'sacga_2048_game_manager' ),
		$version,
		true
	);
}

/**
 * Render the 2048 shortcode.
 *
 * @return string
 */
function shortcode_arcade_2048_render_shortcode() {
	shortcode_arcade_2048_enqueue_assets();
	$instance_id = function_exists( 'wp_unique_id' )
		? wp_unique_id( 'sacga-2048-' )
		: uniqid( 'sacga-2048-', false );

	ob_start();
	?>
	<div id="<?php echo esc_attr( $instance_id ); ?>" class="sacga-2048" data-sacga-instance="<?php echo esc_attr( $instance_id ); ?>" tabindex="0">
		<div class="container">
			<div class="heading">
				<h1 class="title">2048</h1>
				<div class="scores-container">
					<div class="score-container">0</div>
					<div class="best-container">0</div>
				</div>
			</div>

			<div class="above-game">
				<p class="game-intro">Join the numbers and get to the <strong>2048 tile!</strong></p>
				<a class="restart-button">New Game</a>
			</div>

			<div class="game-container">
				<div class="game-message">
					<p></p>
					<div class="lower">
						<a class="keep-playing-button">Keep going</a>
						<a class="retry-button">Try again</a>
					</div>
				</div>

				<div class="grid-container">
					<div class="grid-row">
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
					</div>
					<div class="grid-row">
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
					</div>
					<div class="grid-row">
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
					</div>
					<div class="grid-row">
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
						<div class="grid-cell"></div>
					</div>
				</div>

				<div class="tile-container"></div>
			</div>

			<p class="game-explanation">
				<strong class="important">How to play:</strong> Use your arrow keys or swipe to move the tiles.
				Tiles with the same number merge into one when they touch. Add them up to reach 2048!
			</p>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'sacga_2048', 'shortcode_arcade_2048_render_shortcode' );
