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
			'/' . $this->rest_base . '/(?P<model>[\a-z_-]+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_item' ),
				'permission_callback' => array( $this, 'get_item_permissions_check' ),
				'schema'              => array( $this, 'get_item_schema' ),
				'args'                => array(
					'model' => array(
						'description' => 'The model to use.',
						'type'        => 'string',
						'default'     => 'default',
						'required'    => true,
					),
				),
			),
		);
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_item' ),
				'permission_callback' => array( $this, 'get_item_permissions_check' ),
				'schema'              => array( $this, 'get_item_schema' ),
			),
		);
	}

	/**
	 * Get a single color palette.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 */
	public function get_item( $request ) {
		$args = array(
			'model' => 'default',
		);

		$model = $request->get_param( 'model' );
		if ( $model ) {
			$args['model'] = $model;
		}

		$body = wp_json_encode( $args );

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

		if ( is_wp_error( $response ) ) {
			return rest_ensure_response( array( 'error' => $response->get_error_message() ) );
		}

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

	/**
	 * Item schema.
	 *
	 * @return array Item schema.
	 */
	public function get_item_schema() {
		// Schema cache.
		if ( $this->schema ) {
			return $this->schema;
		}

		$this->schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'palette',
			'type'       => 'object',
			'properties' => array(
				'result' => array(
					'type'  => 'array',
					'items' => array(
						'type'     => 'array',
						'minItems' => 5,
						'items'    => array(
							'type'     => 'integer',
							'minItems' => 3,
						),
					),
				),
			),
		);

		return $this->schema;
	}
}
