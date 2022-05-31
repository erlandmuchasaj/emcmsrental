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
	<meta name="google-site-verification" content="pm66uqOoeGc_IjmX8325oHAW-CYVb7Elfl6TXm5LSiE" />
	<?php echo $this->Html->charset(); ?>
	<meta name="locale" content="<?php echo $this->Html->getActiveLanguageCode(); ?>">
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- Mobile Internet Explorer ClearType Technology -->
	<!--[if IEMobile]>  <meta http-equiv="cleartype" content="on">  <![endif]-->
	<title><?php echo $this->fetch('title'); ?></title>
	<meta name="generator" content="CakePHP Version <?php echo Configure::version(); ?>" />
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- human -->
    <meta name="Copyright" content="Copyright @Erland Muchasaj. All Rights Reserved.">
    <meta name="author" content="Erland Muchashasaj">

    <!-- preload fonts -->
    <link rel="preload" as="font" href="<?php echo rtrim(Router::Url('/', true), '/\\');?>/css/fonts/AzoSans/azosans-light-webfont.woff2" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="<?php echo rtrim(Router::Url('/', true), '/\\');?>/css/fonts/AzoSans/azosans-light-webfont.woff" type="font/woff2" crossorigin="anonymous">
    
    <link rel="preload" as="font" href="<?php echo rtrim(Router::Url('/', true), '/\\');?>/css/fonts/AzoSans/azosans-bold-webfont.woff2" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="<?php echo rtrim(Router::Url('/', true), '/\\');?>/css/fonts/AzoSans/azosans-bold-webfont.woff" type="font/woff2" crossorigin="anonymous">

	<?php
		echo $this->Html->meta('icon');
		//////////	MAIN CSS	//////////
		echo $this->Html->css(['bootstrap/css/bootstrap.min','font-awesome/css/font-awesome.min','jquery-ui/test/jquery-ui-1.10.3.custom','admin/dashboard'], null, array('block'=>'css'));

		// echo $this->Html->css('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', null, array('block'=>'css', 'integrity' => 'sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN', 'crossorigin' => 'anonymous'));
		
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
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|=========================================================|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|=========================================================|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|=========================================================|
-->
<body class="hold-transition fixed skin-black sidebar-mini">
	<!--[if lt IE 7]>
		<p class="chromeframe">
			You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.
		</p>
	<![endif]-->
	<div class="wrapper">
		<!-- Main Header -->
		<?php echo $this->element('Admin/topbar'); ?>
		<!-- Left side column. contains the logo and sidebar -->
		<?php echo $this->element('Admin/sidebar_left'); ?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Main content -->
			<section class="content">
				<?php
					echo $this->Flash->render();
					echo $this->Flash->render('auth');
					echo $this->fetch('content');
				?>
			</section>
		</div>
		<!-- Main Footer -->
		<?php echo $this->element('Admin/footer'); ?>
		<!-- Control Sidebar -->
		<?php // echo $this->element('Admin/sidebar_right'); ?>
		<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- Confirmation Modal For Ajax Delete of Records -->
	<?php echo $this->element('Common/confirm_modal'); ?>
	<?php
		echo $this->Html->script("jquery-2.2.4.min", array('block'=>'scriptBottomTop'));
		echo $this->Html->script('jquery-ui-1.12.min', array('block'=>'scriptBottomTop'));
		echo $this->Html->script('bootstrap/js/bootstrap.min', array('block'=>'scriptBottomTop', 'defer'));
		echo $this->Html->script('admin/init', array('block'=>'scriptBottomTop'));
		echo $this->Html->script('scripts', array('block'=>'scriptBottom'));
		echo $this->fetch('scriptBottomTop');
		echo $this->fetch('scriptBottomMiddle');
		echo $this->fetch('scriptBottom');
	?>
</body>
</html>
