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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- Mobile Internet Explorer ClearType Technology -->
	<!--[if IEMobile]>  <meta http-equiv="cleartype" content="on">  <![endif]-->
	<title><?php echo $pageTitle; ?></title>
<?php
if (Configure::read('debug') == 0):
	echo sprintf('<meta http-equiv="Refresh" content="%s;url=%s" />', $pause, $url);
endif;
?>
<style><!--
P { text-align:center; font:bold 1.1em sans-serif }
A { color:#444; text-decoration:none }
A:HOVER { text-decoration: underline; color:#44E }
--></style>
</head>
<body>
	<p><?php echo $this->Html->link($message, $url); ?></p>
</body>
</html>
