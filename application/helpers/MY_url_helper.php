<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('getCurrentRoute')) {
	/**
	 * getCurrentRoute
	 * @return	array
	 */
	function getCurrentRoute() {
		$d_c = 'welcome';
		$d_a = 'index';
		$cur_url = uri_string();
		$cur_url_arr = explode( '/', $cur_url );
		switch ( count( $cur_url_arr ) ) {
			case 0:
				$route_arr = array( $d_c, $d_a ); 
				break;
			case 1:
				$route_arr = array( $cur_url_arr[0], $d_a );
				break;
			default:
				$route_arr = array( $cur_url_arr[0], $cur_url_arr[1] );
				break;
		}
		return $route_arr;
	}

}