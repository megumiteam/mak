(function(window, angular, undefined) {
	'use strict';

	/* App Module */
	var makDirective = angular.module('makDirective', []);

	makDirective.directive('makPageNation', function( $compile ) {
		return {
			restrict: 'A',
			templateUrl: function( elem, attr ) {
				var $type = attr.makPageNation === '' ? 'list' : attr.makPageNation;
				return '/core-template/mak-pagenation-' + $type + '.html';
			},controller: function($scope, $location) {
				var $page_url   = $location.$$url;
				var $paged      = $scope.paged;
				var $totalpages = $scope.totalpages;
				var $total      = $scope.total;
				if ( 1 === $paged ) {
					$page_url = $page_url + '/page/';
				} else {
					$page_url = $page_url.replace(/(page\/)([0-9]+)/g, '$1');
				}
				$page_url = $page_url.replace( /\/\//, '/' );
				$scope.prevpage   = $page_url + ( $paged - 1 );
				$scope.nextpage   = $page_url + ( $paged + 1 );
				if ( 2 === $paged ) {
					$scope.prevpage   = $scope.prevpage.replace(/(\/page\/)([0-9]+)/g, '/');
				}
			}
		}
	});

})(window, window.angular);
