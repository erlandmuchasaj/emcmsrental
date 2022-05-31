<?php
    $showDefault = true;
	$thisSiteName = Configure::check('Website.name') ? Configure::read('Website.name') : '[SITENAME]';
    $copyRight = Configure::check('Website.copyright') ? Configure::read('Website.copyright') : '[COPYRIGHT]';
?>
<div class="container-fluid em-container">
    <div class="row">
        <div class="col-md-2">
        	<div class="row">
                <?php if (isset($global_languages) && count($global_languages) > 1): ?>
                <div class="col-sm-6 col-xs-6 col-md-12">
                    <label class="label_hidden" for="language-selector"><?php __('Choose Language')?></label>
                    <div class="selectContainer">
			        	<select id="language-selector" name="language-selector" class="footer-selectbox js-language-switch">
		        		<?php
                            $passedArgs = $this->request->params['named']+$this->request->params['pass'];

                            // $option = [
                            //     'controller' => $this->request->params['controller'],
                            //     'action' => $this->request->params['action'],
                            //     'plugin' => $this->request->params['plugin'],
                            //     'language' => $this->request->params['language'],
                            //     '?' => $this->request->query,
                            // ];
                            // $option += $passedArgs;

    	        			foreach ($global_languages as $language) {
    	        				$retVal = ($language_code == $language['Language']['language_code']) ? 'selected="selected"' : '' ;

                                $option = [
                                    'language' => $language['Language']['language_code'], 
                                    '?' => $this->request->query
                                ] + $passedArgs;

                                $url = $this->Html->url($option,  true);

    	        				echo "<option value='".$language['Language']['language_code']."' data-url='".$url."' ".$retVal.">".h($language['Language']['name']). "</option>";
    	        			}
		        		?>
			        	</select>
                        <span class="footer-arrow">
                        	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" style="fill:#fff;height:16px;width:16px;display:block;"><path fill-rule="evenodd" d="M16.291 4.295a1 1 0 1 1 1.414 1.415l-8 7.995a1 1 0 0 1-1.414 0l-8-7.995a1 1 0 1 1 1.414-1.415l7.293 7.29 7.293-7.29z"></path></svg>
                        </span>
                    </div>
                </div>
                <?php endif ?>

                <?php if (isset($global_currencies) && count($global_currencies) > 1): ?>
                <div class="col-sm-6 col-xs-6 col-md-12">
                    <label class="label_hidden" for="currency-selector"><?php __('Choose Currency')?></label>
                    <div class="selectContainer">
                        <select id="currency-selector" name="currency-selector" class="footer-selectbox  js-currency-switch">
					        <?php
			        			foreach ($global_currencies as $currency) {
			        				$retVal = ($localeCurrency === $currency['Currency']['code']) ? 'selected' : '';
			        				echo "<option value='".$currency['Currency']['code']."' ".$retVal.">".h($currency['Currency']['name']). "</option>";
			        			}
							?>
                        </select>
                        <span class="footer-arrow">
                        	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" style="fill:#fff;height:16px;width:16px;display:block;">
                        		<path fill-rule="evenodd" d="M16.291 4.295a1 1 0 1 1 1.414 1.415l-8 7.995a1 1 0 0 1-1.414 0l-8-7.995a1 1 0 1 1 1.414-1.415l7.293 7.29 7.293-7.29z"></path>
                        	</svg>
                        </span>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>

        <div class="col-md-3 col-md-offset-1 hidden-sm hidden-xs">
            <h3 class="footer-heading-txt"><?php echo __('Rentals') ?></h3>
            <ul class="footer-layout">
                <li>
                    <?php 
                    	echo $this->Html->link(__('About'),
                    		'/about-us',
                    		// ['controller' => 'pages', 'action' => 'display', 'about-us'],
                    		array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                    	);
                    ?>
                </li>

                <li>
                    <?php 
                    	echo $this->Html->link(__('Privacy &amp; Policy'),
                    		'/privacy-policy',
                    		// ['controller' => 'pages', 'action' => 'display', 'privacy-policy'],
                    		array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                    	);
                    ?>
                </li>
                <li>
                    <?php 
                    	echo $this->Html->link(__('Host Guarantee'),
                    		'/host-guarantee',
                    		// ['controller' => 'pages', 'action' => 'display', 'host-guarantee'],
                    		array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                    	);
                    ?>
                </li>
                <li>
                    <?php 
                    	echo $this->Html->link(__('Guest Refund'),
                    		'/guest-refund',
                    		// ['controller' => 'pages', 'action' => 'display', 'guest-refund'],
                    		array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                    	);
                    ?>
                </li>
                <li>
                    <?php 
                    	echo $this->Html->link(__('Copyright Policy'),
                    		'/copyright-policy',
                    		// ['controller' => 'pages', 'action' => 'display', 'copyright-policy'],
                    		array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                    	);
                    ?>
                </li>
                <li>
                    <?php 
                    	echo $this->Html->link(__('Consent Disagree'),
                    		'/consent-disagree',
                    		// ['controller' => 'pages', 'action' => 'display', 'consent-disagree'],
                    		array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                    	);
                    ?>
                </li>
                <!-- 
                <li>
                    <a href="/press/news" class="footer-component">
                    	<span>Press</span>
                    </a>
                </li>
                <li>
                    <a href="/policies" class="footer-component">
                    	<span>Policies</span>
                    </a>
                </li>
                <li>
                    <a href="/help?from=footer" class="footer-component">
                    	<span>Help</span>
                    </a>
                </li>
                <li>
                    <a href="/diversity" class="footer-component">
                    	<span>Diversity &amp; Belonging</span>
                    </a>
                </li>
            	-->
                <li>
                    <?php 
                    	echo $this->Html->link(__('Contact us'),
                    		'/contact-us',
                    		// ['controller' => 'pages', 'action' => 'display', 'why-host'],
                    		array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                    	);
                    ?>
                </li>
                <li>
                    <?php 
                        echo $this->Html->link(__('Faq-s'),
                            ['controller' => 'faqs', 'action' => 'index'],
                            array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                        );
                    ?>
                </li>
            </ul>
        </div>

        <div class="col-md-3 hidden-sm hidden-xs">
            <h3 class="footer-heading-txt"><?php echo __('Discover') ?></h3>
            <ul class="footer-layout">
				<li>
					<?php 
						echo $this->Html->link(__('Trust &amp; Safety'),
							'/trust-and-safety',
							// ['controller' => 'pages', 'action' => 'display', 'why-host'],
							array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
						);
					?>
				</li>
				<li>
					<?php 
						echo $this->Html->link(__('Travel Credit'),
							'/invite',
							// ['controller' => 'pages', 'action' => 'display', 'invite'],
							array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
						);
					?>
				</li>

				<!-- 
				<li>
					<a href="/gift?s=footer" class="footer-component">
						<span>Gift Cards</span>
					</a>
				</li>
				<li>
					<a href="/citizen" target="_blank" class="footer-component">Rentals Citizen
					</a>
				</li>
				<li>
					<a href="/business-travel?s=footer" class="footer-component">
						<span>Business Travel</span>
					</a>
				</li>
				<li>
					<a href="/things-to-do" class="footer-component">
						<span>Guidebooks</span>
					</a>
				</li>
				-->
            </ul>
        </div>

        <div class="col-md-3 hidden-sm hidden-xs">
        	<h3 class="footer-heading-txt"><?php echo __('Hosting') ?></h3>
            <ul class="footer-layout">
                <li>
                    <?php 
                    	echo $this->Html->link(__('Why Host'),
                    		'/why-host',
                    		// ['controller' => 'pages', 'action' => 'display', 'why-host'],
                    		array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                    	);
                    ?>
                </li>
                <li>
                    <?php 
                    	echo $this->Html->link(__('Hospitality'), 
                    		'/hospitality',
                    		// ['controller' => 'pages', 'action' => 'display', 'hospitality'],
                    		array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                    	);
                    ?>
                </li>
            </ul>
        </div>
    </div>

    <hr class="footer-divider hr-footer-space hidden-sm hidden-xs ">
    <hr class="footer-divider visible-sm visible-xs">

    <div class="footerTable">
        <div class="alignment">
            <div class="child">
			<?php if ($showDefault) { ?>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1328.986 1328.987" style="fill:#767676;width:2.5em;display:block;">
					
					<circle fill="none" stroke="#767676" stroke-width="20" stroke-miterlimit="10" cx="664.493" cy="664.493" r="641.497"/>
					
					<g>
						<polygon points="373.428,918.628 339.428,918.628 339.428,388.749 660.986,682.335 955.491,413.192 977.186,436.703
							661.958,725.555 373.428,461.145"/>
					</g>
					<g>
						<polygon points="785.88,839.366 762.213,817.709 964.241,628.155 985.877,651.571"/>
					</g>
					<g>
						<polygon points="896.057,940.237 872.494,918.661 967.742,830.446 989.378,853.86"/>
					</g>
				</svg>
			<?php }  else { ?>
				<div class="footer-logo-holder">
				<?php echo $this->Html->link($this->Html->image($image, array('class'=>'img-responsive','alt'=> h($thisSiteName).'logo')),'javascript:void(0);',array('escape' => false, 'class'=>'footer-logo')); ?>
				</div>
			<?php } ?>
            </div>
            <div class="child">
                <div class="copyright-text">
                    &copy;&nbsp;<?php echo h($copyRight); ?>
                </div>
            </div>
        </div>
        <ul class="footer-terms">
            <li class="footer-inline">
                <?php 
                	echo $this->Html->link(__('Terms &amp; Privacy'),
                		'/terms-and-privacy',
                		// ['controller' => 'pages', 'action' => 'display', 'why-host'],
                		array('escape' => false, 'target'=>'_blank', 'class'=>"footer-component")
                	);
                ?>
            </li>
            <li class="footer-inline">
            	<!-- <a href="<?php // echo $this->Html->url(array("controller" => "properties", "action" => "sitemap")); ?>" class="footer-component">Site Map</a> -->
            	<?php echo $this->Html->link(__('Site Map'), Router::Url('/sitemap.xml', true), array('escape' => false, 'class'=>'footer-component')); ?>
            </li>
        </ul>
    </div>

	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Html->tag('h5',__('Follow us on'), ['class'=>'text-center']);?>
			<ul class="footer-socials text-center">
			<?php
				if (!empty(Configure::read('Website.facebook'))) {
					echo $this->Html->tag('li', $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-facebook', 'aria-hidden'=>'true')), Configure::read('Website.facebook'), array('escape' => false, 'target'=>'_blank')));
				}

				if (!empty(Configure::read('Website.twitter'))) {
					echo $this->Html->tag('li', $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-twitter', 'aria-hidden'=>'true')), Configure::read('Website.twitter'), array('escape' => false, 'target'=>'_blank')));
				}

				if (!empty(Configure::read('Website.pinterest'))) {
					echo $this->Html->tag('li', $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-pinterest', 'aria-hidden'=>'true')), Configure::read('Website.pinterest'), array('escape' => false, 'target'=>'_blank')));
				}

				if (!empty(Configure::read('Website.facebook'))) {
					echo $this->Html->tag('li', $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-linkedin', 'aria-hidden'=>'true')), Configure::read('Website.linkedin'), array('escape' => false, 'target'=>'_blank')));
				}

				if (!empty(Configure::read('Website.googleplus'))) {
					echo $this->Html->tag('li', $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-google-plus', 'aria-hidden'=>'true')), Configure::read('Website.googleplus'), array('escape' => false, 'target'=>'_blank')));
				}

				if (!empty(Configure::read('Website.instagram'))) {
					echo $this->Html->tag('li', $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-instagram', 'aria-hidden'=>'true')), Configure::read('Website.instagram'), array('escape' => false, 'target'=>'_blank')));
				}

				if (!empty(Configure::read('Website.tumblr'))) {
					echo $this->Html->tag('li', $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-tumblr', 'aria-hidden'=>'true')), Configure::read('Website.tumblr'), array('escape' => false, 'target'=>'_blank')));
				}

				if (!empty(Configure::read('Website.youtube'))) {
					echo $this->Html->tag('li', $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-youtube', 'aria-hidden'=>'true')), Configure::read('Website.youtube'), array('escape' => false, 'target'=>'_blank')));
				}

				if (!empty(Configure::read('Website.vimeo'))) {
					echo $this->Html->tag('li', $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-vimeo', 'aria-hidden'=>'true')), Configure::read('Website.vimeo'), array('escape' => false, 'target'=>'_blank')));
				}
			?>
			</ul>
		</div>
	</div>
</div>