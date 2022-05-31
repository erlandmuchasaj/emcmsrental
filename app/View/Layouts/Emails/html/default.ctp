<!DOCTYPE html>
<?php 
	// we request the action to access global setting
	// $globalSettings = $this->requestAction(['controller'=>'site_settings', 'action' =>'getSettings', 'user'=>false, 'admin'=>false]);

	$settings = $this->requestAction(['controller'=>'site_settings', 'action' =>'loadSettings', 'user'=>false, 'admin'=>false]);

	// deine some constNTS DEFAULT
	$siteLogo = 'general/logo.png';
	if (isset($settings['logo']) && !empty($settings['logo'])){
		if (file_exists(IMAGES.'SiteSetting'.DS.$settings['logo']) && is_file(IMAGES.'SiteSetting'.DS.$settings['logo'])) {
			$siteLogo = 'uploads/SiteSetting/'.$settings['logo'];   
		} 
	}
	$siteName 	   = ($settings['sitename']) ? $settings['sitename'] : '[SITE_NAME]';
	$siteTagline   = ($settings['tagline']) ? $settings['tagline'] : '[SITE_TAGLINE]';
	$siteSlogan    = ($settings['slogan']) ? $settings['slogan'] : '[SITE_SLOGAN]';
	$siteAddress   = ($settings['address']) ? $settings['address'] : '[SITE_ADDRESS]';
	$sitePhone 	   = ($settings['contact_number']) ? $settings['contact_number'] : '[SITE_PHONE]';
	$siteEmail 	   = ($settings['email']) ? $settings['email'] : '[SITE_EMAIL]';
	$sitePowerBy   = ($settings['powered_by']) ? $settings['powered_by'] : '[SITE_POWERBY]';
	$SiteCopyRight = ($settings['copyright']) ? $settings['copyright'] : '[SITE_COPYRIGHT]';

?>
<html lang="en">
<head>
<?php echo $this->Html->charset(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title><?php echo $this->fetch('title'); ?></title>
<link rel="shortcut icon" href="images/favicon.png" type="image/png">
<meta http-Equiv="Cache-Control" Content="cache">
<meta http-Equiv="Pragma" Content="cache">
<meta http-Equiv="Expires" Content="1000">
<style type="text/css">
	@import url(http://fonts.googleapis.com/css?family=Open+Sans);
	body{overflow-x: hidden}
	img{max-width:600px;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic}
	a{text-decoration:none;border:0;outline:none;color:#bbb}
	a img{border:none}
	p{margin-top: 0;margin-bottom: 0;text-align:left;}
	td,h1,h2,h3{font-family:Helvetica,Arial,sans-serif;font-weight:400}
	td{text-align:center}
	body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%;height:100%;color:#37302d;background:#00989a;font-size:16px}
	table{border-collapse:collapse!important}
	.headline{color:#fff;font-size:36px}
	.force-full-width{width:100%!important}
	.force-width-80{width:80%!important}
	.force-width-40{width:50%!important}
	@media screen {
		td,h1,h2,h3{font-family:'Open Sans','Helvetica Neue','Arial','sans-serif'!important}
	}
	@media only screen and (max-width: 600px) {
		table[class="w290"]{width:290px!important}
		table[class="w300"]{width:300px!important}
		table[class="w320"]{width:480px!important}
		table[class*="w100p"]{width:100%!important}
		td[class="w320"]{width:4800px!important}
		td[class="mobile-center"]{text-align:center!important}
		td[class*="mobile-padding"]{padding-left:20px!important;padding-right:20px!important;padding-bottom:20px!important}
		td[class*="mobile-block"]{display:block!important;width:100%!important;text-align:left!important;padding-bottom:20px!important}
		td[class*="mobile-border"]{border:0!important}
		td[class*="reveal"]{display:block!important}
		td[class*="mobile-spacing"]{padding-top:10px!important;padding-bottom:10px!important}
		*[class*="mobile-hide"]{display:none!important}
		*[class*="mobile-br"]{font-size:12px!important}
		td[class*="mobile-w20"]{width:20px!important}
		img[class*="mobile-w20"]{width:20px!important}
		img[class*="w320"]{width:250px!important;height:67px!important}
		.mobile-padding {padding:10px 30px !important}
	}
	@media only screen and (max-width: 480px) {
		table[class="w290"]{width:290px!important}
		table[class="w300"]{width:300px!important}
		table[class="w320"]{width:300px!important}
		table[class*="w100p"]{width:100%!important}
		td[class="w320"]{width:300px!important}
		td[class="mobile-center"]{text-align:center!important}
		td[class*="mobile-padding"]{padding-left:20px!important;padding-right:20px!important;padding-bottom:20px!important}
		td[class*="mobile-block"]{display:block!important;width:100%!important;text-align:left!important;padding-bottom:20px!important}
		td[class*="mobile-border"]{border:0!important}
		td[class*="reveal"]{display:block!important}
		td[class*="mobile-spacing"]{padding-top:10px!important;padding-bottom:10px!important}
		*[class*="mobile-hide"]{display:none!important}
		*[class*="mobile-br"]{font-size:12px!important}
		td[class*="mobile-w20"]{width:20px!important}
		img[class*="mobile-w20"]{width:20px!important}
		img[class*="w320"]{width:250px!important;height:67px!important}
		td[class*="activate-now"]{padding-right:0!important;padding-top:20px!important}
		td[class*="mobile-align"]{text-align:left!important}
		td[class*="mobile-center"]{text-align:center!important}
		.mobile-padding {padding:10px 10px !important}
	}
</style>
</head>
<body  offset="0" class="body" style="padding:0; margin:0; display:block; background:#00989a; -webkit-text-size-adjust:none" bgcolor="#00989a">
	<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%" >
		<tr>
			<td align="center" valign="top" style="background:#00989a; background-size: auto 100%;background-position: top center;background-repeat:no-repeat" width="100%">
				<center>
					<table style="margin:0 auto;" cellspacing="0" height="60" cellpadding="0" width="100%">
						<tr>
							<td style="text-align: center;">
								<?php echo $this->Html->link($this->Html->image($siteLogo, array('fullBase' => true, 'style'=>'width:145px; max-width:none; border:none; margin-right:25px','alt'=>'company logo','width'=>'145','height'=>'auto')), $this->Html->url('/', true), array('escape' => false));?>
							</td>
						</tr>
					</table>

					<table cellspacing="0" cellpadding="0" width="600" class="w320" style="border-radius: 4px;overflow: hidden;">
						<tr>
							<td align="center" valign="top">
								<table cellspacing="0" cellpadding="0" class="force-full-width">
									<tr>
										<td class="bg bg1" style="background-color:#F1F2F5;">
											<table cellspacing="0" cellpadding="0" class="force-full-width">
												<tr>
													<td style="font-size:24px; font-weight: 600; color: #121212; text-align:center;" class="mobile-spacing">
														<div class="mobile-br">&nbsp;</div>
														<?php echo $this->Html->tag('span',__('Welcome to %s', $siteName), array('class'=>''));?>
													</td>
													<br>
												</tr>
												<tr>
													<td style="font-size:17px; text-align:center; padding: 10px 75px 0; color:#6E6E6E;" class="w320 mobile-spacing mobile-padding">
														<?php echo $this->Html->tag('span',__('We are happy to meet you and hope you have an amazing time with us.'), array('class'=>''));?>
														<br><br>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<!-- MAIN EMAIL CONTENT THAT COMES FROM TEMPLATE -->
								<!-- IS PLACED HERE IN THE BELOW SECTION -->
								<table cellspacing="0" cellpadding="0" class="force-full-width">
									<tr>
										<td class="bg bg1" style="background-color:#F1F2F5;">
											<?php echo $this->fetch('content'); ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

					<table cellspacing="0" cellpadding="0" width="600" class="w320" style="border-radius: 4px;overflow: hidden;">
						<tr>
							<td align="center" valign="top">
								<table cellspacing="0" cellpadding="0" class="force-full-80" style="width:80%;margin:auto">
									<tr>
										<td style="text-align:center;">&nbsp;</td>
									</tr>
									<tr>
										<td style="color:#D2D2D2;;color:rgba(255,255,255,0.7); font-size: 14px;padding-bottom:4px;">
											<table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="force-width-50 w100p">
												<tr>
													<td style="text-decoration:underline;height:30px;text-align:left" class="mobile-center">
														<?php echo $this->Html->tag('unsubscribe',__('Update subscription preferences.'), array('class'=>''));?>
													</td>
												</tr>
											</table>
											<table border="0" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="force-width-50 w100p">
												<tr>
													<td style="text-decoration:underline;height:30px;text-align:right" class="mobile-center">
														<?php echo $this->Html->tag('unsubscribe',__('Unsubscribe from this list.'), array('class'=>''));?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>

								<table cellspacing="0" cellpadding="0" class="force-full-80" style="width:80%;margin:auto">
									<tr>
										<td style="text-align:center;">&nbsp;</td>
									</tr>

									<tr>
										<td style="color:#D2D2D2;color:rgba(255,255,255,0.5); font-size: 14px;padding-bottom:4px;">
											<table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="force-width-50">
												<tr>
													<td style="height:21px;text-align:center;font-size:12px;" class="mobile-center">
														<?php 
														$date = date('Y');
														echo $this->Html->tag('span',__('Copyright &copy; %s %s, All Right Reserved.', array($date, $siteName)), array('class'=>''));
														?>
													</td>
												</tr>
												<tr>
													<td style="height:21px;text-align:center;font-size:12px;" class="mobile-center">
														<?php 
															echo $this->Html->tag('span', $siteAddress, array('class'=>''));
														?>
													</td>
												</tr>
												<tr>
													<td style="height:21px;text-align:center;font-size:12px;" class="mobile-center">
														<?php 
															echo $this->Html->tag('span', __('This email was sent using EMCMS Property Managment System.'), array('class'=>''));
														?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="font-size:12px;">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

					<table cellspacing="0" cellpadding="0" class="force-full-width">
						<tr>
							<td style="font-size:12px;">&nbsp;</td>
							<br>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
</body>
</html>