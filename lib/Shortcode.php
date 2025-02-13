<?php
/**
 * Display widget.
 *
 * @package codereview
 */

namespace WideEye\CodeReview;

/**
 * Widget class.
 */
class Shortcode {
	/**
	 * Register the shortcode.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_shortcode' ) );
	}

	/**
	 * Register the shortcode.
	 */
	public function register_shortcode() {
		add_shortcode( 'wideeye_palette', array( $this, 'shortcode' ) );
	}

	/**
	 * The shortcode callback.
	 *
	 * @return string
	 */
	public function shortcode() {
		ob_start();
		require __DIR__ . '/templates/form.php';
		return ob_get_clean();
	}
}
