<?php
	/*This css is applied only to this page*/
	$propertyId = (int)$reservation['Property']['id'];
	$directoryMdURL = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . 'Property' . DS . $propertyId. DS .'PropertyPicture'. DS . 'large' . DS . $reservation['Property']['thumbnail'];
	$directoryMdPATH = 'uploads/Property/'.$propertyId.'/PropertyPicture/large/' . $reservation['Property']['thumbnail'];

	// debug($reservation);
?>
<!-- Content -->
<div class="em-container book-property-overview make-top-spacing">
	<div class="row">
		<div class="col-sm-6 col-md-7 col-lg-8">
			<h2 class="page-title"><?php echo __('Payment');?></h2>
			<?php echo $this->Form->create('Reservation', array('url'=>array('controller' => 'reservations', 'action' => 'pay_host', $reservation['Reservation']['id']) ,'class'=>'form-horizontal', 'id'=>'checkout-form')); ?>

				<!-- payment method-->
				<div class="payment-section">
					<div class="form-group book-style">
						<div class="col-md-6 col-sm-8">
							<?php
								echo $this->Form->input('payment_country', [
									'div' => false,
									'class' => 'form-control',
									'id' => 'country_select',
									'type' => 'select',
									'empty' => __('Payment Country'),
									'required' => 'required',
									'options' => $countries,
								]);
							?>
						</div>
					</div>

					<div class="row book-style">
					    <div class="col-lg-6">
					        <label for="payment_method_select"><?php echo __('Payment method'); ?></label>
					    </div>
					</div>

				    <div class="form-group book-style">
				        <div class="col-md-6">
				        	<?php
				        		echo $this->Form->input('payment_method', [
				        			'div' => false,
				        			'label' => false,
				        			'class' => 'form-control',
				        			'id' => 'payment_method_select',
				        			'type' => 'select',
				        			'value' => 'paypal', // default
				        			'options' => [
				        				'stripe' => 'Stripe',
				        				'paypal' => 'PayPal',
				        				// 'twocheckout' => '2Checkout',
				        			],
				        		]);
				        	?>
				        </div>
				        <div class="col-md-6">
				            <div class="payment-method stripe" style="display: none;">
				                <div class="payment-logo visa"><?php echo __('Credit Card'); ?></div>
				                <div class="payment-logo master"><?php echo __('Master Card'); ?></div>
				                <div class="payment-logo american_express"><?php echo __('American Express'); ?></div>
				                <div class="payment-logo discover"><?php echo __('Discover Card'); ?></div>
				                <div class="payment-logo jcb hide"><?php echo __('JCB'); ?></div>
				                <div class="payment-logo unionpay hide"><?php echo __('UnionPay'); ?></div>
				                <div class="payment-logo postepay hide"><?php echo __('PostPay'); ?></div>
				            </div>
				            <div class="payment-method paypal active">
				                <div class="payment-logo paypal active"><?php echo __('PayPal'); ?></div>
				            </div>
				        </div>
				    </div>
					
				    <div class="payment-method stripe" id="payment-method-stripe" style="display: none;">
				        <div class="form-group book-style">
				            <div class="col-md-6">
	            	    	<?php
	            	    		echo $this->Form->input('Stripe.card_holder', [
	            	    			// 'label'=>false,
	            	    			'id' => 'card_holder',
	            	    			'div'=>false,
	            	    			'class'=>'form-control stripe-input',
	            	    			'type'=>'text',
	            	    			'autocomplete'=>'off',
	            	    			'placeholder' => __('As shown in the back of card'),
	            	    			'value'=>'',
	            	    		]);
	            	    	?>
				            </div>
				            <div class="col-md-6">
			                <?php
			                	echo $this->Form->input('Stripe.card_number', [
			                		// 'label'=>false,
			                		'id'=>'card_number',
			                		'div'=>false,
			                		'class'=>'form-control  stripe-input',
			                		'type'=>'text',
			                		'autocomplete'=>'off',
			                		'value'=>'',
			                	]);
			                ?>
				            </div>
				        </div>

				        <div class="form-group book-style">
				            <div class="col-md-8">
				                <label aria-hidden="true"><?php echo __('Expires on'); ?></label>
				                <div class="row">
				                    <div class="col-sm-6">
				                        <label for="card_expire_month" class="sr-only"><?php echo __('Month'); ?></label>
				                        <?php 
				                        	echo $this->Form->month('Stripe.expire',[
				                        		'monthNames' => false,
				                        		'autocomplete' => 'off',
				                        		'label' => false,
				                        		'div' => false,
				                        		'id' => 'card_expire_month',
				                        		'class' => 'form-control stripe-input',
				                        		'empty' => __('Month'), 
				                        	]);
				                        ?>
				                    </div>
				                    <div class="col-sm-6">
				                        <label for="card_expire_year" class="sr-only"><?php echo __('Year'); ?></label>
				                        <?php 
				                        	echo $this->Form->year('Stripe.expire', date('Y'), null, [
				                        		'orderYear' => 'asc',
				                        		'autocomplete' => 'off',
				                        		'label' => false,
				                        		'div' => false,
				                        		'id' => 'card_expire_year',
				                        		'class' => 'form-control stripe-input',
				                        		'empty' => __('Year'),
				                        	]);
				                        ?>
				                    </div>
				                </div>
				            </div>
				            <div class="col-md-4">
				                <?php
				                	echo $this->Form->input('Stripe.security_code', [
				                		// 'label'=>false,
				                		'id'=>'security_code',
				                		'div'=>false,
				                		'class'=>'form-control stripe-input',
				                		'type'=>'text',
				                		'autocomplete' => 'off',
				                		'placeholder' => 'CVC',
				                		'value' => '',
				                	]);
				                ?>
				            </div>
				        </div>
				    </div>

				    <div class="payment-method paypal active" id="payment-method-paypal">
				        <?php echo __('* You will be redirected to PayPal. <b>You must complete the process or the transaction will not occur.</b>'); ?>
				    </div>
				</div>

				<div class="form-group book-style">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2><?php echo __('Tell %s About Your Trip', EMCMS_ucwords($reservation['Host']['name']));?></h2>
						<p><?php echo __('Some helpful tips on what to write:');?></p>
						<ul>
						 	<li><?php echo __('What brings you to %s? Who’s joining you', EMCMS_ucwords($reservation['Property']['locality']));?></li>
						 	<li><?php echo __('Coordinate check-in plans and key exchange');?></li>
							<li><?php echo __('Ask for recommendations in their neighborhood');?></li>
						</ul>
					</div>
				</div>
				<hr>
				<div class="media">
					<div class="media-left media-middle">
					<?php 
						echo $this->Html->link(
							$this->Html->displayUserAvatar(AuthComponent::user('image_path'), ['size'=>'small', 'height'=>'115', 'width' => '115']), 
							array('controller' => 'users', 'action' => 'view', $reservation['Host']['id']),
							array('escape' => false, 'class' => 'media-photo media-round media-object')
						);
					?>
					</div>
					<div class="media-body">
						<label for="message-to-host-input" class="sr-only"><?php echo __("Message your host..."); ?></label>
						<?php  echo $this->Form->input('message_to_host',array('type'=>'textarea', 'placeholder' =>'Message your host...', "rows"=>"5", 'class'=>"form-control", 'id' => 'message-to-host-input', 'label' => false, 'div' => false )); ?>
					</div>
				</div>

				<hr>

				<div class="form-group book-style">
					<div class="col-md-12 col-sm-12">
						<h2 class="section-title"><?php echo __('House Rules'); ?></h2>
						<p><?php echo __('By booking this space you’re agreeing to follow %s’s House Rules.', EMCMS_ucwords($reservation['Host']['name']));?></p>
					</div>
				</div>

				<hr>

				<div class="form-group book-style">
					<div class="col-md-12 col-sm-12">
						<div class="media">
							<div class="media-body">
								<p>
								<?php 
								
								$terms = $this->Html->link(__('Terms of Service'), '/terms-and-privacy',['escape' => false, 'class' => 'terms_link', 'target' => '_blank']);

								$refund = $this->Html->link(__('Guest Refund Policy.'), '/guest-refund',['escape' => false, 'class' => 'terms_link', 'target' => '_blank']);

								$trust = $this->Html->link(__('Trust and safety'), '/trust-and-safety',['escape' => false, 'class' => 'terms_link', 'target' => '_blank']);

								echo __('By clicking on "Book Now", you agree to pay the total amount shown, which includes Service Fees, on the right and to the %s, %s and %s. I also agree to pay the total amount shown, which includes Service Fees.', $terms, $refund, $trust);

								?>
								</p>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group book-style">
					<div class="col-md-6 col-sm-8">
					<?php 
						echo $this->Form->input('terms_and_conditions', array('type' => 'checkbox', 'label' => __('I agree to the Terms of Service and Privacy Policy'), 'escape'=>false, 'div'=>false, 'required'=>'required', 'value'=>true, 'style'=>'vertical-align: top;')); 
					?>
					</div>
				</div>

				<div class="form-group book-style">
					<div class="col-md-6 col-sm-8">
					<?php 
						echo $this->Form->submit(__('Book now'), [
							'id' => 'book-now-btn',
							'class' => 'btn btn-lg btn-block book-now-btn',
							'label' => false,
							'div' => false,
							'escape' => true,
						]);
					?>
					</div>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>

		<div class="col-sm-6 col-md-5 col-lg-4 property-overview">
			<div class="row">
				<div class="col-xs-12 remove-padding">
					<div class="property-image-container">
					<?php
						if (file_exists($directoryMdURL) && is_file($directoryMdURL)) {
							echo $this->Html->image($directoryMdPATH, array('alt' => 'property image','class' => 'img-responsive img-full-width','fullBase' => true));
						} else {
							echo $this->Html->image('no-img-available.png', array('alt' => 'property image','class' => 'img-responsive img-full-width','fullBase' => true));
						}

						echo $this->Html->link($this->Html->displayUserAvatar($reservation['Host']['image_path']),array('controller' => 'users', 'action' => 'view', $reservation['Host']['id']),array('escape' => false, 'class' => 'user-thumbnail overview-avatar'));
					?>
					</div>
				</div>
				<br />
				<div class="col-xs-12 ">
					<div class="property-title">
					<?php echo getDescriptionHtml($reservation['Property']['PropertyTranslation']['title']); ?>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="property-description">
					<?php echo getDescriptionHtml($reservation['Property']['PropertyTranslation']['description']); ?>
					</div>
				</div>
				<hr />

			  	<div class="col-xs-12"><hr /></div>

				<div class="col-xs-12 ">
					<div class="property-guests">
						<?php echo  __('Booking For <b>%d guests</b> for <b>%d nights</b>.', $reservation['Reservation']['guests'], $reservation['Reservation']['nights']); ?>
					</div>
				</div>

				<div class="col-xs-12 ">
					<div class="property-checkin-checkout">
						<?php echo  __('<b>%s</b> to <b>%s</b>', $reservation['Reservation']['checkin'], $reservation['Reservation']['checkout']); ?>
					</div>
				</div>
				<div class="col-xs-12"><hr /></div>

				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo  __('Cancellation Policy');?></div>
						<div class="col-xs-6 text-right">
							<span data-toggle="tooltip" title="Cancellation Policy" data-placement="top" data-content="<?php echo h($reservation['CancellationPolicy']['cancellation_title']); ?>" >
							<?php echo h($reservation['CancellationPolicy']['name']); ?>
							</span>
						</div>
				 	</div>
				</div>

				<div class="col-xs-12"><hr /></div>
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo  __('Nights');?></div>
						<div class="col-xs-6 text-right">
						<?php echo __n('%s Night', '%s Night(s)', $reservation['Reservation']['nights'], $reservation['Reservation']['nights']); ?>
						</div>
				 	</div>
				</div>

				<div class="col-xs-12 ">
					<div class="row">
						<div class="col-xs-6"><?php echo  __('Price per night');?></div>
						<div class="col-xs-6  text-right"><?php echo $this->Number->currency($reservation['Reservation']['price'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format'));?>
						</div>
				 	</div>
				</div>

				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo __('Subtotal');?></div>
						<div class="col-xs-6  text-right"><?php echo $this->Number->currency($reservation['Reservation']['subtotal_price'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format')); ?></div>
					</div>
				</div>

				<?php if (!empty($reservation['Reservation']['extra_guest_price'])) { ?>
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo __('Extra guest price per night.');?></div>
						<div class="col-xs-6 text-right"><?php echo $this->Number->currency($reservation['Reservation']['extra_guest_price'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format')); ?></div>
					</div>
				</div>
				<?php } ?>

				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo __('Cleaning fee');?></div>
						<div class="col-xs-6 text-right"><?php echo $this->Number->currency($reservation['Reservation']['cleaning_fee'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format')); ?></div>
					</div>
				</div>

				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo __('Security fee');?></div>
						<div class="col-xs-6 text-right"><?php echo $this->Number->currency($reservation['Reservation']['security_fee'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format')); ?></div>
					</div>
				</div>

				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo  __('Service Fee');?>&nbsp;<i data-toggle="tooltip" data-placement="top" title="<?php echo __('This is the Fee charged by Portal'); ?>"  class="fa fa-question-circle"></i></div>
						<div class="col-xs-6  text-right"><?php echo $this->Number->currency($reservation['Reservation']['service_fee'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format')); ?></div>
					</div>
				</div>
				
				<div class="col-xs-12 "><hr /></div>
				<div class="col-xs-12 bookit-total">
					<div class="row">
						<div class="col-xs-6"><h3 class="bookit-label"><?php echo  __('Total'); ?></h3></div>
						<div class="col-xs-6 text-right">
							<h3 class="bookit-value">
								<?php echo $this->Number->currency($reservation['Reservation']['total_price'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format')); ?>
							</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$this->Html->scriptBlock("
	(function($){
		$(document).ready(function() {
			'use strict';

			$(document).on('change', '#payment_method_select', function() {
			    if ($(this).val() === 'paypal') {
			        $('#payment-method-stripe').hide();
			        $('.stripe-input', '#payment-method-stripe').prop('disabled', true).prop('required', false);
			        $('.stripe').hide();

			        $('.payment-method.paypal').addClass('active').show();
			        $('.paypal > .payment-logo').removeClass('inactive').show();
			    } else if ($(this).val() === 'stripe' || $(this).val() === 'twocheckout') {
			        $('#payment-method-stripe').show();
			        $('.stripe-input', '#payment-method-stripe').prop('disabled', false).prop('required', true);
			        $('.stripe').show();

			        $('.payment-method.paypal').removeClass('active').hide();
			        $('.paypal > .payment-logo').addClass('inactive').hide();
			    }
			});

			$('#country_select').on('change', function() {
			    $('#billing-country').text($(\"#country_select option:selected\").text());
			});

		    setTimeout(function() {
		        if ($('#payment_method_select').val() === 'paypal') {
		            $('#payment-method-stripe').hide();
		            $('.stripe-input', '#payment-method-stripe').prop('disabled', true).prop('required', false);
		            $('.stripe').hide();

		            $('.paypal').addClass('active');
		            $('.paypal > .payment-logo').removeClass('inactive');
		        } else if ($('#payment_method_select').val() === 'stripe' || $(this).val() === 'twocheckout') {
		            $('#payment-method-stripe').show();
		            $('.stripe-input', '#payment-method-stripe').prop('disabled', false).prop('required', true);
		            $('.stripe').show();

		            $('.paypal').removeClass('active');
		            $('.paypal > .payment-logo').addClass('inactive');
		        }
				$('#billing-country').text($(\"#country_select option:selected\").text());
		    }, 30);
		});
	})(jQuery);
", array('block' => 'scriptBottom'));
?>
