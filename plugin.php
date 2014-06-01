<?php
/**
 * Plugin Name: AngularJS WordPress API
 * Plugin URI: https://github.com/jeffsebring/angular-wp-api
 * Description: Provides a module for easy access to WP-API within AngularJS applications.
 * Author: Jeff Sebring
 * Version: 0.0.1
 * Author URI: https://jeffsebring.com
 */

defined( 'ABSPATH' ) || die;

if ( ! function_exists( 'angular_wp_api_scripts' ) ) :

/**
 * Enqueue script & localize data
 */
function angular_wp_api_scripts() {

	// Leave if WP-API is not activated
	if ( ! defined( 'JSON_API_VERSION' ) )
		return;

	// Leave if not specifically requested from the theme or a plugin
	if ( ! $config = get_theme_support( 'angular-wp-api' ) )
		return;

	// Array of dependencies
	$script_dependencies = null;

	// Data for localization
	$script_data = null;

	// Script dependency from theme support
	if ( isset( $config[ 0 ] ) )
		$script_dependencies = $config[ 0 ];

	// Script data from theme support
	if ( isset( $config[ 1 ] ) )
		$script_data = $config[ 1 ];

	// Data for localization
	$script_data[ 'base' ] = json_url();
	$script_data[ 'nonce' ] = wp_create_nonce( 'wp_json' );

	// Provide user id if logged in
	if ( is_user_logged_in() )
		$script_data[ 'user_id' ] = get_current_user_id();

	else
		$script_data[ 'user_id' ] = 0;

	// Enqueue the script after dependency, in the footer
	wp_enqueue_script( 'angular-wp-api',
		plugins_url( 'angular-wp-api.min.js', __FILE__ ),
		apply_filters( 'angular_wp_api_script_dependencies', $script_dependencies ),
		'',
		true
	);

	// Localize filterable data for script
	wp_localize_script(
		'angular-wp-api',
		'wpAPIData',
		apply_filters( 'angular_wp_api_local_data', $script_data )
	);

}

// Hook `angular_wp_api_scripts` to the `wp_enqueue_scripts` action
add_action( 'wp_enqueue_scripts', 'angular_wp_api_scripts' );

endif;