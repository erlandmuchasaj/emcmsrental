<?php
/**
 * This Software is the property of Erland Muchasaj and is protected
 * by copyright law - it is NOT Freeware.
 * Any unauthorized use of this software without a valid license
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @copyright (C) Erland Muchasaj
 * @author Erland Muchasaj <erland.muchasaj@rgmail.com>
 * @link http://erlandmuchasaj.com/
 */
?>
<?php echo $this->Html->docType(); ?>
<!--[if lt IE 7]><html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>   <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>   <html lang="en" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>   <html lang="en" class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--><html dir="<?php echo $this->Html->getActiveLanguageDirection(); ?>" lang="<?php echo $this->Html->getActiveLanguageCode(); ?>"><!--<![endif]-->
<head>
	<meta name="google-site-verification" content="pm66uqOoeGc_IjmX8325oHAW-CYVb7Elfl6TXm5LSiE">
	<?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- Mobile Internet Explorer ClearType Technology -->
	<!--[if IEMobile]>  <meta http-equiv="cleartype" content="on">  <![endif]-->
	<title><?php echo $this->fetch('title', Configure::read('Website.meta_title')); ?></title>
	<meta name="title" content="<?php echo $this->fetch('meta_title', (isset($meta_title)) ? $meta_title : Configure::read('Website.meta_title')); ?>">
	<meta name="description" content="<?php echo $this->fetch('meta_description', (isset($meta_description)) ? $meta_description : Configure::read('Website.meta_description')); ?>">
	<link rel="canonical" href="<?php echo $this->fetch('canonical', Router::Url(null, true)); ?>">


	<link rel="alternate" href="<?php echo Router::Url('/', true); ?>" hreflang="x-default">
	<?php $languageList = $this->Html->getLanguageList('all'); ?>
	<?php foreach ($languageList as $key => $lang): ?>
	<link rel="alternate" href="<?php echo Router::Url(['controller'=>'properties', 'action' => 'index', 'language'=>$lang['Language']['language_code']], true);?>" hreflang="<?php echo $lang['Language']['language_code']; ?>">
	<?php endforeach ?>


	<!--[if lte IE 9]>
	<meta http-equiv="refresh" content="0; url=https://www.uretoupgradepage.com/browser-upgrade.htx">
	<style>body { display: none!important; }</style>
	<![endif]-->

	<!-- human -->
	<meta name="author" content="<?php echo $this->fetch('author', Configure::read('Website.powered_by')); ?>">
	<meta name="keyword" content="<?php echo $this->fetch('meta_keywords', Configure::read('Website.meta_keywords')); ?>">
	<meta name="copyright" content="<?php echo $this->fetch('copyright', Configure::read('Website.copyright')); ?>">
	<meta name="locale" content="<?php echo $this->Html->getActiveLanguageCode(); ?>">
	<meta name="generator" content="CakePHP Version <?php echo Configure::version(); ?>">
	<meta name="base_url" content="<?php echo rtrim(Router::Url('/', true), '/\\');?>">
	<!-- <base href="<?php // echo Router::Url('/', true); ?>"> -->
	<meta name="robots" content="index,follow">
	
	<!-- Twitter Card data -->
	<meta name="twitter:widgets:csp" content="on">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="<?php echo $this->fetch('meta_title', (isset($meta_title)) ? $meta_title : Configure::read('Website.meta_title')); ?>">
	<meta name="twitter:description" content="<?php echo $this->fetch('meta_description', (isset($meta_description)) ? $meta_description : Configure::read('Website.meta_description')); ?>">
	<meta name="twitter:url" content="<?php echo $this->fetch('meta_url', (isset($meta_url)) ? $meta_url : Router::Url('/', true)); ?>">
	<meta name="twitter:image" content="<?php echo $this->fetch('meta_image', (isset($meta_image)) ? $meta_image : Router::Url('/img/emcmsrental.png', true)); ?>">

	<!-- Open Graph data -->
	<meta property="og:site_name" content="<?php echo Configure::read('Website.name'); ?>">
	<meta property="og:locale" content="<?php echo $this->Html->getActiveLanguageCode(); ?>">
	<meta property="og:title" content="<?php echo $this->fetch('meta_title', (isset($meta_title)) ? $meta_title : Configure::read('Website.meta_title')); ?>">
	<meta property="og:description" content="<?php echo $this->fetch('meta_description', (isset($meta_description)) ? $meta_description : Configure::read('Website.meta_description')); ?>">
	<meta property="og:url" content="<?php echo $this->fetch('meta_url', (isset($meta_url)) ? $meta_url : Router::Url('/', true)); ?>">
	<meta property="og:image" content="<?php echo $this->fetch('meta_image', (isset($meta_image)) ? $meta_image : Router::Url('/img/emcmsrental.png', true)); ?>">
	<meta property="og:type" content="<?php echo $this->fetch('og_type', 'website'); ?>">

	<meta name="apple-mobile-web-app-title" content="<?php echo Configure::read('Website.name'); ?>">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="application-name" content="<?php echo Configure::read('Website.name'); ?>">
	<meta name="theme-color" content="#ffffff">
	<meta name="msapplication-navbutton-color" content="#ffffff">
	<meta name="msapplication-tooltip" content="<?php echo Configure::read('Website.name'); ?>" />
	<meta name="msapplication-starturl" content="/?utm_source=homescreen">

	<!-- Direct search spiders to your sitemap.
		Learn to make a sitemap here: http://www.sitemaps.org/protocol.php -->
	<link rel="sitemap" type="application/xml" title="Sitemap" href="<?php echo Router::Url('/sitemap.xml', true); ?>">

	<!-- preload fonts -->
	<link rel="preload" as="font" href="<?php echo rtrim(Router::Url('/', true), '/\\');?>/css/fonts/AzoSans/azosans-light-webfont.woff2" type="font/woff2" crossorigin="anonymous">
	<link rel="preload" as="font" href="<?php echo rtrim(Router::Url('/', true), '/\\');?>/css/fonts/AzoSans/azosans-light-webfont.woff" type="font/woff2" crossorigin="anonymous">
	
	<link rel="preload" as="font" href="<?php echo rtrim(Router::Url('/', true), '/\\');?>/css/fonts/AzoSans/azosans-bold-webfont.woff2" type="font/woff2" crossorigin="anonymous">
	<link rel="preload" as="font" href="<?php echo rtrim(Router::Url('/', true), '/\\');?>/css/fonts/AzoSans/azosans-bold-webfont.woff" type="font/woff2" crossorigin="anonymous">

	<?php

		echo $this->Html->meta('icon');
		//////////	MAIN CSS	//////////
		///
		echo $this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', null, array('block'=>'css', 'integrity' => 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u', 'crossorigin' => 'anonymous'));

		echo $this->Html->css('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', null, array('block'=>'css', 'integrity' => 'sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN', 'crossorigin' => 'anonymous'));

		/*Costum style for the template*/
		echo $this->Html->css('custom', null, array('block'=>'cssBottom'));
		//////////////////////////////////
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('cssMiddle');
		echo $this->fetch('cssBottom');
		echo $this->fetch('script');
		echo $this->fetch('scriptTop');

		// Set the model and controller
		$current_model 		= $this->name;
		$current_controller = $this->params['controller'];
		$current_action 	= $this->params['action'];

		if ($current_controller === 'properties' && $current_action === 'index') {
			$class = 'homepage';
			if (Configure::check('Website.homepage_version') && Configure::read('Website.homepage_version') === 'v2') {
				$class = 'homepage-v2';
			}
		} else {
			$class = $current_controller . '_' . $current_action;
		}
	?>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php echo $this->element('variables'); ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<!-- 	
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110948975-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-110948975-1');
	</script>
	-->
</head>
<body class="<?php echo $class; ?>">
	<!--[if lt IE 7]>
		<p class="chromeframe">
			You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.
		</p>
	<![endif]-->
	<?php echo $this->element('Frontend/offcanvas_menu'); ?>
	<?php echo $this->element('Frontend/menu'); ?>
	<main>
		<?php
			if ($this->Session->check('Message.auth')) {
				echo $this->Flash->render('auth');
			} else {
				echo $this->Flash->render();
			}
			echo $this->fetch('content');
		?>
	</main>
	<footer id="footer" class="site-footer">
		<?php echo $this->element('Frontend/footer'); ?>
	</footer>
	<a id="back-to-top"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
	<?php
		// $this->Html->script("jquery-3.1.0.min", array("block"=>"scriptBottomTop"));
		// $this->Html->script("jquery-ui-1.12.min", array("block"=>"scriptBottomTop"));
		// $this->Html->script("bootstrap/js/bootstrap.min", array("block"=>"scriptBottomTop", "defer"));
		
		$this->Html->script('https://code.jquery.com/jquery-3.3.1.min.js', array('block'=>'scriptBottomTop', 'crossorigin' => 'anonymous', 'integrity' => 'sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='));


		$this->Html->script('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array('block'=>'scriptBottomTop' , 'crossorigin' => 'anonymous', 'integrity' => 'sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU='));


		$this->Html->script('https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('block'=>'scriptBottomTop', 'integrity' => 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa', 'crossorigin' => 'anonymous'));


		$this->Html->script(
			[
				'frontend/TouchSwipe/jquery.touchSwipe.min',
				'frontend/slide-and-swipe-menu/jquery.slideandswipe.min',
				// 'jquery.ui.touch-punch.min',
				'scripts'
			], 
			['block'=>'scriptBottomTop']
		);

		echo $this->fetch('scriptBottomTop');
		echo $this->fetch('scriptBottomMiddle');
		echo $this->fetch('scriptBottom');
	?>
</body>
</html>