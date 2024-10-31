jQuery(document).ready(function()
{
	// TopList reviews
	jQuery("a.review").fancybox({
		'padding':		'10',
		'width':		510,
		'height':		'75%',
		'autoScale':	false,
		'type':			'iframe',
		'overlayOpacity': 0.8,
		'overlayColor':		'#000',
		'centerOnScroll': true,
		'hideOnContentClick': true
	});
});