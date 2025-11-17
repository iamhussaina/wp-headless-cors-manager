<?php
/**
 * Main loader for the Headless CORS Manager module.
 *
 * This file should be included in your theme's functions.php to activate
 * the CORS handling logic for the WordPress REST API.
 *
 * @package HeadlessCORSManager
 * @version     1.0.0
 * @author      Hussain Ahmed Shrabon
 * @license     MIT
 * @link        https://github.com/iamhussaina
 * @textdomain  hussainas
 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define a constant for the module path for easier inclusion.
define( 'HUSSAINAS_CORS_MODULE_PATH', __DIR__ . '/' );

// Ensure the core class file is loaded.
require_once HUSSAINAS_CORS_MODULE_PATH . 'includes/class-hussainas-rest-cors-handler.php';

/**
 * Ensures the module is only initialized once.
 *
 * This function acts as the main entry point for the module,
 * creating an instance of the core handler class.
 */
if ( ! function_exists( 'hussainas_initialize_cors_handler' ) ) {
	/**
	 * The main function responsible for initializing the module.
	 */
	function hussainas_initialize_cors_handler() {
		// Check if the class exists to prevent fatal errors
		// in case of duplicate inclusion.
		if ( class_exists( 'Hussainas_REST_CORS_Handler' ) ) {
			new Hussainas_REST_CORS_Handler();
		}
	}
}

// Run the initialization function.
hussainas_initialize_cors_handler();
