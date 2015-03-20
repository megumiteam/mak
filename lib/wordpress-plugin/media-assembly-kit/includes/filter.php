<?php
/**
 * Name: Media Assembly Kit Filter
 */

class MediaAssemblyKitFilter extends MediaAssemblyKitInit {

	public function __construct() {
		parent::__construct();

		add_filter( 'wp_headers', array( &$this, 'wp_headers' ), 10, 2 );
		add_filter( 'home_url', array( &$this, 'home_url' ), 10, 2 );
	}

	public function wp_headers( $headers, $headers_this ) {
		if ( $headers_this->query_vars['json_route'] && ! empty( $this->destination_url ) ) {
			$headers['Access-Control-Allow-Origin']      = $this->destination_url;
			$headers['Access-Control-Allow-Credentials'] = 'true';
			$headers['Access-Control-Expose-Headers']    = 'Origin, X-Requested-With, Content-Type, Accept, X-WP-Total, X-WP-TotalPages, Link';
		}
		return $headers;
	}

	public function home_url( $url, $path ) {
		if ( get_query_var( 'json_route' ) && ! empty( $this->destination_url ) && 'wp-json' != $path ) {
			$home_url = get_option( 'home' );
			$url      = str_replace( $home_url, $this->destination_url, $url );
		}
		return $url;
	}

}
