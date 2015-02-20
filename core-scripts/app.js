(function(window, angular, undefined) {
	'use strict';

	/**
	 * @ngdoc overview
	 * @name mediaAssemblyKitApp
	 * @description
	 * # mediaAssemblyKitApp
	 *
	 * Main module of the application.
	 */

	/* App Module */
	var makApp = angular.module('makApp', [
		'ui.router',
		'ngResource',
		'angular-loading-bar',
		'ngAnimate',
		'makConfig',
		'makFactory',
		'makController',
		'makDirective',
	]);

	makApp.config(['$stateProvider', '$urlRouterProvider', '$locationProvider', '$httpProvider', 'cfpLoadingBarProvider', function($stateProvider, $urlRouterProvider, $locationProvider, $httpProvider, cfpLoadingBarProvider) {
		$httpProvider.defaults.useXDomain = true;
		$httpProvider.defaults.withCredentials = true;
		delete $httpProvider.defaults.headers.common['X-Requested-With'];

		$locationProvider.html5Mode(true);
		$locationProvider.hashPrefix('!');
		$urlRouterProvider.otherwise('/mak');
		$urlRouterProvider.rule(function($injector, $location) {
			var path = $location.url();
			if ('/' === path[path.length - 1]) return path.replace(/\/$/, '')
			if (path.indexOf('/?') > 0) return path.replace('/?', '?')
			return false;
		});
		$stateProvider
			.state('home', {
				url: '/mak',
				views: {
					main: {
						templateUrl: 'template/archive.html',
						controller: 'Archive'
					}
				}
			});

		cfpLoadingBarProvider.includeBar = true;
		cfpLoadingBarProvider.includeSpinner = false;
	}]);

})(window, window.angular);
