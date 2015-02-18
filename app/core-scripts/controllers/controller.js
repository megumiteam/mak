(function(window, angular, undefined) {
	'use strict';

	/* App Module */
	var makController = angular.module('makController', []);

	makController.controller('GlobalMenu', function($scope, $sce, makConfig, makQuery, makMenu) {

		var $apiurl = makConfig.apiUrl;
		var $menu_id = makConfig.menu_id;
		var $url = $apiurl + 'wp-json/menus/' + $menu_id + '/content/?'
		+ [
			'callback=JSON_CALLBACK'
		].join('&');
		makQuery.wp_posts($url).get().$promise.then(function(data) {
			$scope.mak_menu = makMenu.mak_menu(data).content;
		});
	});

	makController.controller('SideBar', function($scope, makConfig, makQuery, makMenu) {
		var $apiurl = makConfig.apiUrl;
		var $menu_id = makConfig.menu_id;
		var $url = $apiurl + 'wp-json/taxonomies/category/terms/?'
		+ [
			'callback=JSON_CALLBACK'
		].join('&');
		makQuery.wp_posts($url).query().$promise.then(function(data) {
			$scope.mak_categories = data;
		});
	});

	makController.controller('the_post', function($scope, makPost) {
		var $post = $scope.wp_post;
		var $terms = $post.terms;
		$scope.mak_post_id = function() {
			return makPost.post_id($post);
		};
		$scope.mak_permalink = function() {
			return makPost.permalink($post);
		};
		$scope.mak_title = function() {
			return makPost.title($post);
		};
		$scope.mak_author_id = function() {
			return makPost.author_id($post);
		};
		$scope.mak_author_avatar = function() {
			return makPost.author_avatar($post);
		};
		$scope.mak_author_description = function() {
			return makPost.author_description($post);
		};
		$scope.mak_author_name = function() {
			return makPost.author_name($post);
		};
		$scope.mak_author_slug = function() {
			return makPost.author_slug($post);
		};
		$scope.mak_content = function() {
			return makPost.post_content($post);
		};
		$scope.mak_excerpt = function() {
			return makPost.post_excerpt($post);
		};
		$scope.mak_post_date = function($format) {
			if (angular.isUndefined($format)) {
				var $format = 'yyyy/MM/dd';
			}
			return makPost.post_date($post, $format);
		};
		$scope.mak_post_date_gmt = function($format) {
			if (angular.isUndefined($format)) {
				var $format = 'yyyy/MM/dd';
			}
			return makPost.post_date_gmt($post, $format);
		};
		$scope.mak_post_modified = function($format) {
			if (angular.isUndefined($format)) {
				var $format = 'yyyy/MM/dd';
			}
			return makPost.post_modified($post, $format);
		};
		$scope.mak_post_modified_gmt = function($format) {
			if (angular.isUndefined($format)) {
				var $format = 'yyyy/MM/dd';
			}
			return makPost.post_modified_gmt($post, $format);
		};
		$scope.mak_thumbnail = function($size) {
			if (angular.isUndefined($size)) {
				var $size = 'thumbnail';
			}
			return makPost.thumbnail($post, $size);
		};
		$scope.mak_terms = function($term_name) {
			if (angular.isUndefined($term_name)) {
				var $term_name = 'category';
			}
			return makPost.terms($terms, $term_name);
		};

	});

	makController.controller('Archive', function($scope, $location, $stateParams, makConfig, makQuery) {
		var $apiurl = makConfig.apiUrl;
		var $tax    = angular.isUndefined($stateParams.tax) ? '' : $stateParams.tax;
		var $terms  = angular.isUndefined($stateParams.terms) ? '' : $stateParams.terms;
		var $paged = angular.isUndefined($stateParams.paged) ? 1 : $stateParams.paged;
		$scope.paged = $paged;
		var $search = angular.isUndefined($location.search().s) ? '' : $location.search().s;
		var $params = '';
		if ( $tax && $terms ) {
			$tax    = 'tag' === $tax ? $tax : $tax + '_name';
			$params = 'filter[' + $tax + ']=' + $terms;
		} else if ( $search ) {
			$params = 'filter[s]=' + $search;
		} else {
			$params = '1=1';
		}
		var $url = $apiurl + 'wp-json/posts/?'
		+ [
			$params,
			'page=' + $paged,
			'callback=JSON_CALLBACK'
		].join('&');
		makQuery.wp_posts($url).query( function(data, headers) {
			$scope.totalpages = headers('X-WP-TotalPages');
			$scope.total      = headers('X-WP-Total');
		}).$promise.then(function(data) {
			$scope.wp_posts = data;
		});
	});

	makController.controller('Single', function($scope, $stateParams, makConfig, makQuery) {
		var $apiurl = makConfig.apiUrl;
		var $url = $apiurl + 'wp-json/posts/' + $stateParams.ID + '/?'
		+ [
			'callback=JSON_CALLBACK'
		].join('&');
		var $data = {};
		makQuery.wp_posts($url).get().$promise.then(function(data) {
			$data[0] = data;
			$scope.wp_posts  = $data;
		});
	});

	makController.controller('Pages', function($scope, $stateParams, makConfig, makQuery) {
		var $apiurl = makConfig.apiUrl;
		var $url = $apiurl + 'wp-json/pages/' + $stateParams.pagename + '/?'
		+ [
			'callback=JSON_CALLBACK'
		].join('&');
		var $data = {};
		makQuery.wp_posts($url).get().$promise.then(function(data) {
			$data[0] = data;
			$scope.wp_posts  = $data;
		});
	});

})(window, window.angular);
