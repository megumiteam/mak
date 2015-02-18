<?php
/**
 * Name: Query Endpoint
 */

class WPRestAPIKitEndpointQuery extends WPRestAPIKitEndpointInit {

	public function __construct() {
		parent::__construct();
		add_action( 'wp_json_server_before_serve', array( &$this, 'wp_json_server_before_serve' ) );
	}

	public function wp_json_server_before_serve() {
		add_filter( 'json_endpoints', array( &$this, 'register_routes' ) );
	}

	public function register_routes( $routes ) {
		$routes['/query'] = array(
			array( array( $this, 'get_query'), WP_JSON_Server::READABLE ),
		);
		return $routes;
	}

	public function get_query() {
		global $wp_query;
		$test = get_page_by_path('category/aciform/', 'category');
		echo '<pre>';
		var_dump($test);
		echo '</pre>';
		$i = 0;
		$json_url = get_json_url() . '/menus/';
		$json_menus = array();
		foreach ( $wp_query as $menu ) {
			$menu = (array) $menu;
			$json_menus[$i]                                = $menu;
		}
		return $json_menus;
	}

}
