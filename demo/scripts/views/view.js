(function($){
	var $html         = $('html');
	var $body         = $('body');
	var $headerNavBox = $('nav#header-nav-box');
	var $menuButton   = $headerNavBox.children('.header-menu-button');
	var $widgetButton = $headerNavBox.children('.header-widget-button');
	var $sideNav      = $('nav#global-menu');
	var $sideWidget   = $('div#secondary');
	var $overlay      = $('div#overlay');

	$menuButton.on( 'click', function() {
		if ( $sideNav.hasClass('side-nav-open') ) {
			$html.removeClass('no-scroll').removeClass('open-menu');
			$body.removeClass('no-scroll').removeClass('open-menu');
			$overlay.removeClass('open-menu').addClass('close');
			$sideNav.removeClass('side-nav-open').addClass('side-nav-close');
			$(this).attr('aria-expanded', 'false' );
		} else {
			$html.addClass('no-scroll').addClass('open-menu');
			$body.addClass('no-scroll').addClass('open-menu');
			$overlay.addClass('open-menu').removeClass('close');
			$sideNav.removeClass('side-nav-close').addClass('side-nav-open');
			$(this).attr('aria-expanded', 'true' );
		}
	});
	$widgetButton.on( 'click', function() {
		if ( $sideWidget.hasClass('widget-area-open') ) {
			$html.removeClass('no-scroll').removeClass('open-widget');
			$body.removeClass('no-scroll').removeClass('open-widget');
			$overlay.removeClass('open-widget').addClass('close');
			$sideWidget.removeClass('widget-area-open').addClass('widget-area-close');
			$(this).attr('aria-expanded', 'false' );
		} else {
			$html.addClass('no-scroll').addClass('open-widget');
			$body.addClass('no-scroll').addClass('open-widget');
			$overlay.addClass('open-widget').removeClass('close');
			$sideWidget.removeClass('widget-area-close').addClass('widget-area-open');
			$(this).attr('aria-expanded', 'true' );
		}
	});
	$overlay.on( 'click', function() {
		event.preventDefault();
		if ( $(this).hasClass('open-menu') ) {
			$html.removeClass('no-scroll').removeClass('open-menu');
			$body.removeClass('no-scroll').removeClass('open-menu');
			$overlay.removeClass('open-menu').addClass('close');
			$sideNav.removeClass('side-nav-open').addClass('side-nav-close');
			$sideNav.attr('aria-expanded', 'false' );
		}
		if ( $(this).hasClass('open-widget') ) {
			$html.removeClass('no-scroll').removeClass('open-widget');
			$body.removeClass('no-scroll').removeClass('open-widget');
			$overlay.removeClass('open-widget').addClass('close');
			$sideWidget.removeClass('widget-area-open').addClass('widget-area-close');
			$sideWidget.attr('aria-expanded', 'false' );
		}
	});


})(jQuery);
