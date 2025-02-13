<?php
/**
 * Rest API to connect to our "private service" colormind.io
 * Allows users to request a color palette.
 *
 * /wp-json/wideeye/v1/palette
 *
 * @package codereview
 */

namespace WideEye\CodeReview;

use WP_REST_Controller;
use WP_REST_Request;

/**
 * API class.
 */
class API extends WP_REST_Controller {
	/**
	 * The service endpoint.
	 *
	 * @var string
	 */
	private $service_endpoint = 'http://colormind.io/api/';

	/**
	 * Namspace.
	 *
	 * @var string
	 */
	protected $namespace = 'wideeye/v1';

	/**
	 * Rest base.
	 *
	 * @var string
	 */
	protected $rest_base = 'palette';

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
			register_rest_route(
				$this->namespace,
				'/' . $this->rest_base,
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'get_item_permissions_check' ),
				)
			);
	}

	/**
	 * Get a single color palette.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 */
	public function get_item( $request ) {
			$body = wp_json_encode(
				array(
					'model' => 'kaguya_film',
				)
			);

			$options = array(
				'body'        => $body,
				'sslverify'   => false,
				'data_format' => 'body',
				'headers'     => array(
					'Content-Type' => 'application/json',
				),
			);

			$response = wp_remote_post(
				$this->service_endpoint,
				$options
			);

			$response_body = wp_remote_retrieve_body( $response );
			$data          = json_decode( $response_body );

			return rest_ensure_response( $data );
	}

	/**
	 * Check if a given request has access to get item.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return bool
	 */
	public function get_item_permissions_check( $request ) {
		return true;
	}
}
