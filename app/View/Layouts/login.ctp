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
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>   <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>   <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>--><html dir="<?php echo $this->Html->getActiveLanguageDirection(); ?>" lang="<?php echo $this->Html->getActiveLanguageCode(); ?>"><!--<![endif]-->
<head>
	<meta name="google-site-verification" content="pm66uqOoeGc_IjmX8325oHAW-CYVb7Elfl6TXm5LSiE" />
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- Mobile Internet Explorer ClearType Technology -->
	<!--[if IEMobile]>  <meta http-equiv="cleartype" content="on">  <![endif]-->
	<title><?php echo $this->fetch('title', __('%s - Login', Configure::read('Website.name'))); ?></title>
	<meta name="description" content="<?php echo $this->fetch('meta_description', Configure::read('Website.meta_description')); ?>">
	<meta name="generator" content="CakePHP Version <?php echo Configure::version(); ?>" />
	<meta name="base_url" content="<?php echo rtrim(Router::Url('/', true), '/\\');?>">
	
	<link rel="alternate" href="<?php echo rtrim(Router::Url('/', true), '/\\');?>" hreflang="x-default" />
	<?php $languageList = $this->Html->getLanguageList('all'); ?>
	<?php foreach ($languageList as $key => $lang): ?>
	<link rel="alternate" href="<?php echo Router::Url(['controller'=>'properties', 'action'=>'index', 'language'=>$lang['Language']['language_code']], true);?>" hreflang="<?php echo $lang['Language']['language_code']; ?>" />
	<?php endforeach ?>

	<!--[if lte IE 9]>
	<meta http-equiv="refresh" content="0; url=https://www.uretoupgradepage.com/browser-upgrade.htx" />
	<style>body { display: none!important; }</style>
	<![endif]-->

	<!-- human -->
	<meta name="Copyright" content="<?php echo $this->fetch('copyright', Configure::read('Website.copyright')); ?>">
	<meta name="author" content="<?php echo $this->fetch('author', Configure::read('Website.powered_by')); ?>">
	<meta name="robots" content="index, follow">
	
	<!-- Twitter Card data -->
	<meta name="twitter:widgets:csp" content="on">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="<?php echo $this->fetch('title', Configure::read('Website.meta_title')); ?>">
	<meta name="twitter:description" content="<?php echo $this->fetch('meta_description', Configure::read('Website.meta_description')); ?>">
	<meta name="twitter:image" content="<?php echo $this->fetch('og_image', Router::Url('/img/emcmsrental.png', true)); ?>">
	<meta name="twitter:url" content="<?php echo Router::Url('/', true);?>">

	<!-- Open Graph data -->
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="<?php echo Configure::read('Website.name'); ?>" />
	<meta property="og:title" content="<?php echo $this->fetch('title', Configure::read('Website.meta_title')); ?>" />
	<meta property="og:description" content="<?php echo $this->fetch('meta_description', Configure::read('Website.meta_description')); ?>" />
	<meta property="og:image" content="<?php echo $this->fetch('og_image', Router::Url('/img/emcmsrental.png', true)); ?>" />
	<meta property="og:url" content="<?php echo Router::Url('/', true);?>" />
	<meta property="og:locale" content="<?php echo $this->Html->getActiveLanguageCode(); ?>" />

	<?php
		echo $this->Html->meta('icon');
		//////////	MAIN CSS	//////////
		echo $this->Html->css(array('bootstrap/css/bootstrap.min','font-awesome/css/font-awesome.min','admin/dashboard'), null, array('block'=>'css'));
		/*Costum style for the template*/
		echo $this->Html->css(array('custom'), null, array('block'=>'cssBottom'));
		//////////////////////////////////
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('cssMiddle');
		echo $this->fetch('cssBottom');
		echo $this->fetch('script');
		echo $this->fetch('scriptTop');
	?>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
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
<body class="login-page">
	<!--[if lt IE 7]>
		<p class="chromeframe">
			You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.
		</p>
	<![endif]-->
	<?php
		echo $this->Flash->render();
		echo $this->Flash->render('auth');
		echo $this->fetch('content');
		echo $this->Html->script('jquery-2.2.4.min', array('block'=>'scriptBottomTop'));
		echo $this->Html->script('bootstrap/js/bootstrap.min', array('block'=>'scriptBottomTop'));
		echo $this->Html->script('admin/init', array('block'=>'scriptBottomTop'));
		echo $this->Html->script('scripts', array('block'=>'scriptBottom'));
		echo $this->fetch('scriptBottomTop');
		echo $this->fetch('scriptBottomMiddle');
		echo $this->fetch('scriptBottom');
	?>
</body>
</html>