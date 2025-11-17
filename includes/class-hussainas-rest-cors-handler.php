<?php
/**
 * Core class for handling REST API CORS headers.
 *
 * @package HeadlessCORSManager
 * @subpackage Includes
 * @version 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Hussainas_REST_CORS_Handler.
 *
 * Manages the Cross-Origin Resource Sharing (CORS) headers
 * for the WordPress REST API, enabling headless applications
 * to communicate with WordPress securely.
 */
final class Hussainas_REST_CORS_Handler {

	/**
	 * Constructor.
	 *
	 * Sets up the necessary action hooks for the module.
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Registers all necessary WordPress hooks.
	 *
	 * Binds the 'add_cors_headers' method to the 'rest_api_init' action.
	 */
	private function setup_hooks() {
		// Add CORS headers on REST API initialization.
		// We use a priority of 15 to run after default WP setup
		// but before most custom endpoints.
		add_action( 'rest_api_init', [ $this, 'add_cors_headers' ], 15 );
	}

	/**
	 * Adds the necessary CORS headers to the REST API response.
	 *
	 * This method checks the request origin against a filterable allow-list
	 * and adds the appropriate 'Access-Control-Allow-*' headers.
	 * It also handles pre-flight (OPTIONS) requests.
	 */
	public function add_cors_headers() {

		// 1. Define the default allowed origins.
		// These are common frontend development server ports.
		$default_origins = [
			'http://localhost:3000', // Common for React
			'http://localhost:8080', // Common for Vue
			'http://localhost:5173', // Common for Vite
		];

		/**
		 * Filter the list of allowed origins for REST API CORS.
		 *
		 * @since 1.0.0
		 *
		 * @param array $allowed_origins An array of allowed origin URLs.
		 */
		$allowed_origins = apply_filters( 'hussainas_rest_allowed_origins', $default_origins );

		// 2. Check if the request origin is set.
		if ( ! isset( $_SERVER['HTTP_ORIGIN'] ) ) {
			return; // Not a CORS request.
		}

		$origin = esc_url_raw( $_SERVER['HTTP_ORIGIN'] );

		// 3. If the origin is in our allow-list, send headers.
		if ( in_array( $origin, $allowed_origins, true ) ) {

			// Send the specific origin back. This is more secure than '*'.
			header( 'Access-Control-Allow-Origin: ' . $origin );
			header( 'Access-Control-Allow-Credentials: true' );
			header( 'Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS' );
			header( 'Access-Control-Allow-Headers: Authorization, Content-Type, X-WP-Nonce, X-Requested-With' );

			// 4. Handle pre-flight (OPTIONS) requests.
			// These requests are sent by the browser to check permissions.
			if ( 'OPTIONS' === $_SERVER['REQUEST_METHOD'] ) {
				status_header( 200 );
				exit; // Exit immediately for pre-flight requests.
			}
		}
	}
}
