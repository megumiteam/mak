<?php
/**
 * Name: Menus Endpoint
 */

class WPRestAPIKitFilter extends WPRestAPIKitEndpointInit {

	public function __construct() {
		parent::__construct();

		add_filter( 'wp_headers', array( &$this, 'wp_headers' ), 10, 2 );
		add_filter( 'home_url', array( &$this, 'home_url' ), 10, 2 );
		add_filter( 'json_prepare_post', array( &$this, 'json_prepare_post' ), 10, 2 );
	}

	public function wp_headers( $headers, $headers_this ) {
		if ( $headers_this->query_vars['json_route'] && ! empty( $this->destination_url ) ) {
			$headers['Access-Control-Allow-Origin']      = $this->destination_url;
			$headers['Access-Control-Allow-Credentials'] = 'true';
			$headers['Access-Control-Expose-Headers']    = 'Origin, X-Requested-With, Content-Type, Accept, X-WP-Total, X-WP-TotalPages, Link';
			$headers['P3P: CP']                          = 'THIS IS NOT A P3P';
			//$headers['Access-Control-Allow-Headers']     = 'Origin, X-Requested-With, Content-Type, Accept, X-WP-Total, X-WP-TotalPages, Link';
			//$headers['Access-Control-Allow-Methods']     = 'POST, GET, PUT, DELETE, OPTIONS';
			$headers['Access-Control-Allow-Methods']     = 'GET';
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

	public function json_prepare_post( $_post, $post ) {
		$post_id = $post['ID'];

		// Category
		/*
		$categories = get_the_category( $post_id );
		foreach ( $categories as $category ) {
			$cat_id   = $category->term_id;
			$cat_name = $category->name;
			$cat_slug = $category->slug;
			$cat_link = esc_url( get_category_link( $cat_id ) );
			$_post['category'][$cat_id]['name'] = $cat_name;
			$_post['category'][$cat_id]['slug'] = $cat_slug;
			$_post['category'][$cat_id]['link'] = $cat_link;
		}
		*/

		// Attachment
		$src           = '';
		$width         = '';
		$height        = '';
		$attachment_id = get_post_thumbnail_id( $post_id );
		$image         = wp_get_attachment_image_src( $attachment_id, 'post-thumbnail' );
		if ( $image )
			list( $src, $width, $height ) = $image;

		$_post['meta']['attachment']['src']    = $src;
		$_post['meta']['attachment']['width']  = $width;
		$_post['meta']['attachment']['height'] = $height;

		return $_post;
	}

}
