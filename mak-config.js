(function(window, angular, undefined) {
	'use strict';

	/* App Config */
	var makConfig = angular.module('makConfig', []);
	makConfig.value('makConfig', {
		apiUrl: 'http://managed.nattodaisuki.com/',
		menu_id: 'primary'
	});

})(window, window.angular);
