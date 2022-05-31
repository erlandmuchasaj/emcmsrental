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
	<title><?php echo $this->fetch('title', __('EMCMS - Error Page')); ?></title>
	<?php
		echo $this->Html->meta('icon');
		//////////	MAIN CSS	//////////
		echo $this->Html->css(array('bootstrap/css/bootstrap.min','frontend/404/style.min'), null, array('block'=>'css'));
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
<body>
	<?php
		echo $this->Flash->render();
		echo $this->fetch('content');
		echo $this->Html->script("jquery-3.1.0.min", array('block'=>'scriptBottomTop'));
		echo $this->Html->script('jquery.nicescroll', array('block'=>'scriptBottomTop'));
		echo $this->fetch("scriptBottomTop");
		echo $this->fetch("scriptBottomMiddle");
		echo $this->fetch("scriptBottom");
	?>
	<script>
		$(window).on('load', function () {
			"use strict";
			$(".loader").delay(400).fadeOut();
			$(".animationload").delay(400).fadeOut("fast");
		});
		(function($){
		    $(document).ready(function() {
		        "use strict";
		        if ($('.sw_btn').length) {
		        	$('.sw_btn').on("click", function(){
		        		$("body").toggleClass("light");
		        	});
		        }
		        $("html").niceScroll({
		        	cursorcolor: '#fff',
		        	cursoropacitymin: '0',
		        	cursoropacitymax: '1',
		        	cursorwidth: '2px',
		        	zindex: 999999,
		        	horizrailenabled: false,
		        	enablekeyboard: false
		        });
		    });
		})(jQuery);
	</script>
</body>
</html>
