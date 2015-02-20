(function(window, angular, undefined) {
	'use strict';

	/* App Module */
	var makFactory = angular.module('makFactory', []);

	makFactory.factory('makQuery', function($resource) {
		return {
			wp_posts: function($url) {
				return $resource(
					$url, {},
					{
						'query': {
							method: 'GET',
							withCredentials: true,
							isArray: true
						},
						'get': {
							method: 'GET'
						}
					}
				);
			}
		}
	});

	makFactory.factory('makMenu', function($sce) {
		return {
			mak_menu: function($menu) {
				var $query = {
					content: $sce.trustAsHtml($menu.content)
				}
				return $query;
			}
		};
	});

	makFactory.factory('makPost', function($sce, $filter) {
		return {
			post_id: function($post) {
				return $post.ID;
			},
			permalink: function($post) {
				return $post.link;
			},
			title: function($post) {
				return $post.title;
			},
			author_id: function($post) {
				return $post.author.ID;
			},
			author_avatar: function($post) {
				return $post.author.avatar;
			},
			author_description: function($post) {
				return $sce.trustAsHtml($post.author.description);
			},
			author_name: function($post) {
				return $sce.trustAsHtml($post.author.name);
			},
			author_slug: function($post) {
				return $post.author.slug;
			},
			post_date: function($post, $format) {
				return $filter('date')( $post.date, $format);
			},
			post_date_gmt: function($post, $format) {
				return $filter('date')( $post.date_gmt, $format);
			},
			post_modified: function($post, $format) {
				return $filter('date')( $post.modified, $format);
			},
			post_modified_gmt: function($post, $format) {
				return $filter('date')( $post.modified_gmt, $format);
			},
			post_content: function($post) {
				return $sce.trustAsHtml($post.content);
			},
			post_excerpt: function($post) {
				return $sce.trustAsHtml($post.excerpt);
			},
			thumbnail: function($post, $size) {
				var $view   = angular.isObject($post.featured_image) ? true : false;
				var $data   = '';
				var $id     = '';
				var $sizes  = '';
				var $height = '';
				var $url    = '';
				var $width  = '';
				var $title  = '';
				var $image  = '';
				if ( true === $view && 'full' === $size ) {
					$data   = $post.featured_image;
					$id     = $data.ID;
					$height = $data.attachment_meta.height;
					$url    = $data.source;
					$width  = $data.attachment_meta.width;
					$title  = $data.title;
				} else if ( true === $view ) {
					$data   = $post.featured_image;
					$id     = $data.ID;
					$sizes  = $data.attachment_meta.sizes[$size] ? $data.attachment_meta.sizes[$size] : $data.attachment_meta.sizes.thumbnail;
					$height = $sizes.height;
					$url    = $sizes.url;
					$width  = $sizes.width;
					$title  = $data.title;
				}
				var $query  = {
					view   : $view,
					id     : $id,
					height : $height,
					url    : $url,
					width  : $width,
					title  : $title
				}
				return $query;
			},
			terms: function($terms, $term_name) {
				return $terms[$term_name];
			}
		};
	});

})(window, window.angular);
