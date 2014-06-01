/**
 * @license AngularJS WP-API v0.0.1
 * Author: Jeff Sebring <jeff@jeffsebring.com>
 * License: MIT
 * @ngdoc module
 * @name wp.api
 * @description
 *
 * # wp.api
 *
 * The `wp.api` module provides a convenient wrapper for interacting with WP-API.
 *
 * This module requires ngResource - https://github.com/angular/bower-angular-resource
 *
 */

window.wp = window.wp || {};

wp.api = wp.api || angular.module( 'wp.api', [ 'ngResource' ] )
 
	// Main API resource
	.factory( 'wpAPIResource', [ '$resource', function ( $resource ) {

		return $resource( 
			wpAPIData.base + ':route',
			{
				get: {
					isArray: false
				}
			}
		 );
	}])