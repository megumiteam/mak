<?php
/**
 * Name: Menus Endpoint
 */

class WPRestAPIKitEndpointMenus extends WPRestAPIKitEndpointInit {

	public function __construct() {
		parent::__construct();
		add_action( 'wp_json_server_before_serve', array( &$this, 'wp_json_server_before_serve' ) );
	}

	public function wp_json_server_before_serve() {
		add_filter( 'json_endpoints', array( &$this, 'register_routes' ) );
	}

	public function register_routes( $routes ) {
		// menus
		$routes['/menus'] = array(
			array( array( $this, 'get_menus'), WP_JSON_Server::READABLE ),
		);

		$routes['/menus/(?P<menu_id>[\w]+[^\/]+)'] = array(
			array( array( $this, 'get_menu'), WP_JSON_Server::READABLE ),
		);

		$routes['/menus/(?P<menu_id>[\w.]+[^\/]+)/content'] = array(
			array( array( $this, 'get_menu_content'), WP_JSON_Server::READABLE ),
		);
		return $routes;
	}

	public function get_menus() {
		$menus = wp_get_nav_menus();
		$i = 0;
		$json_url = get_json_url() . '/menus/';
		$json_menus = array();
		foreach ( $menus as $menu ) {
			$menu = (array) $menu;
			$json_menus[$i]                                = $menu;
			$json_menus[$i]['ID']                          = $menu['term_id'];
			$json_menus[$i]['title']                       = $menu['name'];
			$json_menus[$i]['type']                        = $menu['taxonomy'];
			$json_menus[$i]['slug']                        = $menu['slug'];
			$json_menus[$i]['meta']['links']['self']       = $json_url . $menu['term_id'];
			$json_menus[$i]['meta']['links']['slug']       = $json_url . $menu['slug'];
			$json_menus[$i]['meta']['links']['collection'] = $json_url;
			$i ++;
		}
		return $json_menus;
	}

	public function get_menu( $menu_id, $_headers ) {
		$menu = wp_get_nav_menu_object( $menu_id );
		$menu_items = array();
		if ( $menu && ! is_wp_error( $menu ) ) {
			$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
		} else {
			$locations = get_nav_menu_locations();
			$menu_id   = $locations[$menu_id];
			$menu      = wp_get_nav_menu_object( $menu_id );
			$menu_items = ( $menu && ! is_wp_error( $menu ) )
			? wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) )
			: array();
		}
		return $menu_items;
	}
	public function get_menu_content( $menu_id, $_headers ) {
		$json_url = get_json_url() . '/menus/';
		if ( ! is_numeric( $menu_id ) ) {
			$menu = get_term_by( 'slug', $menu_id, 'nav_menu' );
			if ( ! empty( $menu ) ) {
				$menu_id = $menu->term_id;
			} else {
				$locations = get_nav_menu_locations();
				$menu_id   = $locations[$menu_id];
			}
		}
		$term = get_term( $menu_id, 'nav_menu' );
		$name = $term->name;
		$slug = $term->slug;
		$meta = array(
			'links' => array(
				'self'       => $json_url . $menu_id . '/content',
				'slug'       => $json_url . $slug . '/content',
				'collection' => $json_url,
			)
		);
		$menu_items = wp_nav_menu(array(
			'menu'        => $menu_id,
			'echo'        => false,
			'fallback_cb' => '',
			'container'   => '',
		));
		return array( 'name' => $name, 'content' => $menu_items, 'meta' => $meta );
	}

}
