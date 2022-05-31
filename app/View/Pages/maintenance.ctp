<?php
	$siteLogo = 'general/logo.png';
	$siteName = Configure::check('Website.name') ? Configure::read('Website.name') : '[NAME]';
	// $siteName = Configure::check('Website.sitename') ? Configure::read('Website.sitename') : '[SITENAME]';
	$siteTagline = Configure::check('Website.tagline') ? Configure::read('Website.tagline') : '[TAGLINE]';
	$siteSlogan = Configure::check('Website.slogan') ? Configure::read('Website.slogan') : '[SLOGAN]';
	$siteCopyRight = Configure::check('Website.copyright') ? Configure::read('Website.copyright') : '[COPYRIGHT]';
	$sitePowerBy = Configure::check('Website.powered_by') ? Configure::read('Website.powered_by') : '[POWEREDBY]';
	$siteEmail = Configure::check('Website.email') ? Configure::read('Website.email') : '[EMAIL]';
	$sitePhone = Configure::check('Website.contact_number') ? Configure::read('Website.contact_number') : '[PHONE]';
	$siteAddress = Configure::check('Website.address') ? Configure::read('Website.address') : '[ADDRESS]';
	$offlineMessage = Configure::check('Website.offline_message') ? Configure::read('Website.offline_message') : '[OFFLINE_MESSAGE]';
?>
<div id ="home" class="impala-wrap-home animated impala-page page-current">
	<div class="impala-scroll-overlay">
		<div class="container-home">
			<div class="container">
				<div class="logo-wrap">
					<?php echo $this->Html->link($this->Html->image($siteLogo, array('alt'=>'logo', 'class'=>'img-responsive logo')),'javascript: void(0);',array('escape' => false, 'class'=>'')); ?>
				</div>
				<div class="impala-home">
					<div class="impala">
						<div class="row">
							<div class="col-sm-12">
								<!-- <canvas class="timer" width="260" height="105" data-color="255,255,255" data-startDate="3/2/2015 0:00" data-finishDate="6/14/2016 16:25"></canvas> -->
								<h1 class="site-name"><?php echo h($siteName);?></h1>
								<p class="maintenance-text"><?php echo h($offlineMessage); ?></p>
								<?php echo $this->Form->create('Contact', array('class'=>'form notify-me','name'=>'notify-me', 'autocomplete'=>'off', 'url'=>array('user'=>false, 'admin'=>false, 'controller'=>'contacts', 'action'=>'ajaxAddContact')));  ?>
									<div class="form-group email">
										<span class="form-message" style="display: none;"></span>
										<?php echo $this->Form->input('Contact.email', array('class'=>'form-control email', 'label'=>false,'div'=>false,'placeholder'=>'Enter your email here', 'required'=>'required')); ?>
										<button type="submit" class="btn btn-info">
											<?php echo $this->Html->image('socials/ent.svg', array('width'=>'13', 'height'=>'13', 'class'=>"svg", 'alt'=>'ent')); ?>
										</button>
									</div>
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>

				<div class="social-block">
					<div class="soc-link">
						<?php echo $this->Html->image('socials/share.svg', array('alt'=>'share', 'class'=>'soc-link-img')) ?>
					</div>
					<div class="social-links-wrap">
						<div class="social-links animated">
							<?php
								if (!empty(Configure::read('Website.facebook'))) {
									echo $this->Html->link($this->Html->image('socials/facebook.svg', array('width'=>'25','height'=>'25','alt'=>'facebook')), Configure::read('Website.facebook'), array('escape' => false, 'target'=>'_blank', 'class'=>'social-btn'));
								}

								if (!empty(Configure::read('Website.twitter'))) {
									echo $this->Html->link($this->Html->image('socials/twitter.svg', array('width'=>'25','height'=>'25','alt'=>'twitter')), Configure::read('Website.twitter'),array('escape' => false, 'target'=>'_blank', 'class'=>'social-btn'));

								}

								if (!empty(Configure::read('Website.pinterest'))) {
									echo $this->Html->link($this->Html->image('socials/pinterest.svg', array('width'=>'25','height'=>'25','alt'=>'pinterest')),Configure::read('Website.pinterest'),array('escape' => false, 'target'=>'_blank', 'class'=>'social-btn'));
								}

								if (!empty(Configure::read('Website.linkedin'))) {
									echo $this->Html->link($this->Html->image('socials/linkedin.svg', array('width'=>'25','height'=>'25','alt'=>'linkedin')), Configure::read('Website.linkedin'),array('escape' => false, 'target'=>'_blank', 'class'=>'social-btn'));
								}

								if (!empty(Configure::read('Website.googleplus'))) {
									echo $this->Html->link($this->Html->image('socials/googleplus.svg', array('width'=>'25','height'=>'25','alt'=>'googleplus')), Configure::read('Website.googleplus'),array('escape' => false, 'target'=>'_blank', 'class'=>'social-btn'));
								}

								if (!empty(Configure::read('Website.instagram'))) {
									echo $this->Html->link($this->Html->image('socials/instagram.svg', array('width'=>'25','height'=>'25','alt'=>'instagram')), Configure::read('Website.instagram'),array('escape' => false, 'target'=>'_blank', 'class'=>'social-btn'));
								}

								if (!empty(Configure::read('Website.tumblr'))) {
									echo $this->Html->link($this->Html->image('socials/tumblr.svg', array('width'=>'25','height'=>'25','alt'=>'tumblr')), Configure::read('Website.tumblr'),array('escape' => false, 'target'=>'_blank', 'class'=>'social-btn'));
								}

								if (!empty(Configure::read('Website.youtube'))) {
									echo $this->Html->link($this->Html->image('socials/youtube.svg', array('width'=>'25','height'=>'25','alt'=>'youtube')), Configure::read('Website.youtube'), array('escape' => false, 'target'=>'_blank', 'class'=>'social-btn'));
								}

								if (!empty(Configure::read('Website.vimeo'))) {
									echo $this->Html->link($this->Html->image('socials/vimeo.svg', array('width'=>'25','height'=>'25','alt'=>'vimeo')), Configure::read('Website.vimeo'),array('escape' => false, 'target'=>'_blank', 'class'=>'social-btn'));
								}
							?>
						</div>
					</div>
				</div>
				<div class="copyright-block">
					<div class="copyright">&copy;&nbsp;<?php echo date('Y') . ' ' . '<span>' . $siteCopyRight . '</span>'; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>