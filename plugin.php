<?php
/**
 * Plugin Name: AngularJS WordPress API
 * Plugin URI: https://github.com/jeffsebring/angular-wp-api
 * Description: Provides a module for easy access to WP-API within AngularJS applications.
 * Author: Jeff Sebring
 * Version: 0.0.1
 * Author URI: https://jeffsebring.com
 */

if ( ! function_exists( 'angular_wp_api_scripts' ) ) :

/**
 * Enqueue script & localize data
 */
function angular_wp_api_scripts() {

	// Minified or debug mode

	// Data for localization
	$data[ 'base' ] = json_url();
	$data[ 'nonce' ] = wp_create_nonce( 'wp_json' );

	// Provide user id if logged in
	if ( is_user_logged_in() )
		$data[ 'user_id' ] = get_current_user_id();

	else
		$data[ 'user_id' ] = 0;

	// Enqueue the script
	wp_enqueue_script( 'angular-wp-api',
		plugins_url( 'angular-wp-api.min.js', __FILE__ ),
		apply_filters( 'angular_wp_api_script_dependencies', null ),
		'',
		true
	);

	// Localize filterable data for script
	wp_localize_script(
		'angular-wp-api',
		'wpAPIData',
		apply_filters( 'angular_wp_api_local_data', $data )
	);

}
add_action( 'wp_enqueue_scripts', 'angular_wp_api_scripts' );


endif;

