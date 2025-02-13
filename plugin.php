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

add_action(
	'rest_api_init',
	function () {
		$controller = new API();
		$controller->register_routes();
	}
);
