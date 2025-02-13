<?php
/**
 * Plugin Name:     Code Review
 * Plugin URI:      https://wideeye.co
 * Description:     Wide Eye Code Review
 * Author:          Wide Eye
 * Author URI:      https://wideeye.co
 * Text Domain:     wideeye
 * Version:         0.0.1
 *
 * @package         codereview
 */

require_once __DIR__ . '/vendor/autoload.php';

use WideEye\CodeReview\API;
use WideEye\CodeReview\Shortcode;

// Register the API.
add_action(
	'rest_api_init',
	function () {
		$controller = new API();
		$controller->register_routes();
	}
);

// Register the shortcode [wideeye_palette].
new Shortcode();

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_script(
			'wideeye-palette',
			plugin_dir_url( __FILE__ ) . 'src/index.js',
			array(),
			'0.0.1',
			true
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'wideeye-palette',
			plugin_dir_url( __FILE__ ) . 'src/index.css',
			array(),
			'0.0.1'
		);
	}
);
