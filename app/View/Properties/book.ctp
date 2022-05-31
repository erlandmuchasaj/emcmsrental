<?php
	/*This css is applied only to this page*/
	$propertyId = (int)$property['Property']['id'];
	$directoryMdURL = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . 'Property' . DS . $propertyId. DS .'PropertyPicture'. DS . 'large' . DS . $property['Property']['thumbnail'];
	$directoryMdPATH = 'uploads/Property/'.$propertyId.'/PropertyPicture/large/' . $property['Property']['thumbnail'];

// debug($property);

?>
<!-- Content -->
<div class="em-container book-property-overview make-top-spacing">
	<div class="row">
		<div class="col-sm-6 col-md-7 col-lg-8">
			<?php if ($property['Property']['allow_instant_booking'] == true): ?>
			<h2 class="page-title"><?php echo __('Payment');?></h2>
			<?php endif ?>

			<?php echo $this->Form->create('Booking', array('url'=>array('controller' => 'properties', 'action' => 'create_booking', $property['Property']['id']) ,'class'=>'form-horizontal', 'id'=>'checkout-form')); ?>
				<!-- payment_token -->
				<?php echo $this->Form->input('token',array('type'=>'hidden', 'id' => 'payment_token'));?>

				<!-- property_id -->
				<?php echo $this->Form->input('property_id',array('type'=>'hidden', 'value' => $this->request->query['property_id']));?>

				<!-- checkin -->
				<?php echo $this->Form->input('checkin',array('type'=>'hidden','value' => $this->request->query['checkin']));?>

				<!-- checkout -->
				<?php echo $this->Form->input('checkout',array('type'=>'hidden','value' => $this->request->query['checkout']));?>

				<!-- guests -->
				<?php echo $this->Form->input('guests',array('type'=>'hidden','value' => $this->request->query['guests']));?>

				<!-- days -->
				<?php echo $this->Form->input('days',array('type'=>'hidden', 'value' => $this->request->query['days']));?>

				<!-- price_per_night -->
				<?php echo $this->Form->input('price_per_night',array('type'=>'hidden','value' => $this->request->query['price_per_night']));?>

				<!-- subtotal_price -->
				<?php echo $this->Form->input('subtotal_price',array('type'=>'hidden','value' => $this->request->query['subtotal_price']));?>

				<!-- cleaning fee price -->
				<?php echo $this->Form->input('cleaning_fee',array('type'=>'hidden','value' => $this->request->query['cleaning_fee']));?>

				<!-- Security fee price -->
				<?php echo $this->Form->input('security_fee',array('type'=>'hidden','value' => $this->request->query['security_fee']));?>

				<!-- service fee price -->
				<?php echo $this->Form->input('service_fee',array('type'=>'hidden','value' => $this->request->query['service_fee']));?>

				<!-- extra guest -->
				<?php echo $this->Form->input('extra_guest',array('type'=>'hidden','value' => $this->request->query['extra_guest']));?>

				<!-- extra_guest_price -->
				<?php echo $this->Form->input('extra_guest_price',array('type'=>'hidden','value' => $this->request->query['extra_guest_price']));?>

				<!-- total_price -->
				<?php echo $this->Form->input('total_price',array('type'=>'hidden','value' => $this->request->query['total_price']));?>

				<!-- Currency -->
				<?php  echo $this->Form->input('currency',array('type'=>'hidden','value' => $this->request->query['currency']));?>
				
				<!-- STRIPE related data -->
				<?php  // echo $this->Form->input('stripe_publishable',array('type'=>'hidden','value' => $stripePublishableKey, 'id' => 'stripePublishableKey'));?>

				<!-- user_id-->
				<?php
					if (AuthComponent::user('id')) {
						echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => AuthComponent::user('id')));
					}
				?>

				<?php if ($property['Property']['allow_instant_booking'] == true): ?>
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
						
						<?php if (false): ?>
				        <hr>

				        <div class="form-group book-style">
				            <div class="col-sm-12">
				                <h2><?php echo __('Billing Information'); ?></h2>
				            </div>
				        </div>

				        <div class="form-group book-style">
				            <div class="col-md-6">
				                <?php
				                	echo $this->Form->input('first_name', [
				                		// 'label'=>false,
				                		'div'=>false,
				                		'class'=>'form-control',
				                		'type'=>'text',
				                		'value'=>'',
				                	]);
				                ?>
				            </div>
				            <div class="col-md-6">
				            	<?php
				                	echo $this->Form->input('last_name', [
				                		// 'label'=>false,
				                		'div'=>false,
				                		'class'=>'form-control',
				                		'type'=>'text',
				                		'value'=>'',
				                	]);
				                ?>
				            </div>
				        </div>
						
						<div class="form-group book-style">
				            <div class="col-md-6">
				                <label class="control-label" for="credit-card-address1"> Street address </label>
				                <input type="text" class="form-control" name="address1" id="credit-card-address1" disabled="">
				            </div>
				            <div class="col-md-6">
				                <label for="credit-card-address2"> Apt # </label>
				                <input type="text" class="cc-short form-control" name="address2" id="credit-card-address2" disabled="">
				            </div>
				        </div>
				        
				        <div class="form-group book-style">
				            <div class="col-md-6 col-lg-5 hide ">
				                <label for="credit-card-city"> City </label>
				                <input type="text" class="form-control" name="city" id="credit-card-city" disabled="">
				            </div>
				            <div class="col-md-2 hide">
				                <label for="credit-card-state"> State </label>
				                <input type="text" class="cc-short form-control" name="state" id="credit-card-state" disabled="">
				            </div>

				            <div class="col-md-6 col-lg-3">
				            	<?php
				                	echo $this->Form->input('Stripe.zip_code', [
				                		'div'=>false,
				                		'class'=>'form-control',
				                		'type'=>'text',
				                		'value'=>'',
				                	]);
				                ?>
				            </div>
				            <div class="col-md-6 col-lg-3">
				            	<label aria-hidden="true"><span class="sr-only"></span>&nbsp;</label>
				            	<span class="help-block">
				                    <strong id="billing-country"></strong>
				            	</span>
				            </div>
				        </div>
				        <?php endif ?>
						
			            <!-- 
			            <div class="form-group book-style">
			                <div class="col-md-6 col-lg-6">
			    				<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
			    		            data-label="<?php // echo __('Pay With Stripe'); ?>"
			    		            data-key="<?php // echo Configure::read('Stripe.Publishable'); ?>"
			    		            data-name="<?php // echo Configure::read('Website.name'); ?>"
			    		            data-description="<?php // echo stripAllHtmlTags($property['PropertyTranslation']['title']); ?>"
			    		            data-amount="<?php // echo ($this->request->query['total_price'] * 100); ?>"
			    		            data-image="<?php // echo $this->Html->url('/img/'.$directoryMdPATH) ?>"
			    		            data-currency="<?php // echo $this->request->query['currency']; ?>"
			    		            data-locale="<?php // echo $this->Html->getActiveLanguageCode(); ?>"
			    		        >
			    		        </script>
			                </div>
			            </div> 
			        	-->
				    </div>

				    <div class="payment-method paypal active" id="payment-method-paypal">
				        <?php echo __('* You will be redirected to PayPal. <b>You must complete the process or the transaction will not occur.</b>'); ?>
				    </div>
				</div>
				<?php endif ?>

				<div class="form-group book-style">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2><?php echo __('Tell %s About Your Trip', EMCMS_ucwords($property['User']['name']));?></h2>
						<p><?php echo __('Some helpful tips on what to write:');?></p>
						<ul>
						 	<li><?php echo __('What brings you to %s? Who’s joining you', EMCMS_ucwords($property['Property']['locality']));?></li>
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
							array('controller' => 'users', 'action' => 'view', $property['User']['id']),
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
						<p><?php echo __('By booking this space you’re agreeing to follow %s’s House Rules.', EMCMS_ucwords($property['User']['name']));?></p>
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
						if ($property['Property']['allow_instant_booking'] == true) {
							echo $this->Form->submit(__('Book now'), [
								'id' => 'book-now-btn',
								'class' => 'btn btn-lg btn-block book-now-btn',
								'label' => false,
								'div' => false,
								'escape' => true,
								'data-name' => Configure::read('Website.name'),
								'data-description' => stripAllHtmlTags($property['PropertyTranslation']['title']),
								'data-total' => $this->request->query['total_price'],
								'data-amount' => ($this->request->query['total_price'] * 100),
								'data-currency' => $this->request->query['currency'],
								'data-image' => $this->Html->url('/img/'.$directoryMdPATH),
								'data-locale' => $this->Html->getActiveLanguageCode(),
							]);
						} else {
							echo $this->Form->submit(__('Pre Book'), [
								'id' => 'book-now-btn',
								'class' => 'btn btn-lg btn-block book-now-btn',
								'label' => false,
								'div' => false,
								'escape' => true,
							]);
						}
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

						echo $this->Html->link($this->Html->displayUserAvatar($property['User']['image_path']),array('controller' => 'users', 'action' => 'view', $property['User']['id']),array('escape' => false, 'class' => 'user-thumbnail overview-avatar'));
					?>
					</div>
				</div>
				<br />
				<div class="col-xs-12 ">
					<div class="property-title">
					<?php echo getDescriptionHtml($property['PropertyTranslation']['title']); ?>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="property-description">
					<?php echo getDescriptionHtml($property['PropertyTranslation']['description']); ?>
					</div>
				</div>
				<hr />

			  	<div class="col-xs-12"><hr /></div>

				<div class="col-xs-12 ">
					<div class="property-guests">
						<?php echo  __('Booking For <b>%d guests</b> for <b>%d nights</b>.', $this->request->query['guests'], $this->request->query['days']); ?>
					</div>
				</div>

				<div class="col-xs-12 ">
					<div class="property-checkin-checkout">
						<?php echo  __('<b>%s</b> to <b>%s</b>', $this->request->query['checkin'], $this->request->query['checkout']); ?>
					</div>
				</div>
				<div class="col-xs-12"><hr /></div>

				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo  __('Cancellation Policy');?></div>
						<div class="col-xs-6 text-right">
							<span data-toggle="tooltip" title="Cancellation Policy" data-placement="top" data-content="<?php echo h($property['CancellationPolicy']['cancellation_title']); ?>" >
							<?php echo h($property['CancellationPolicy']['name']); ?>
							</span>
						</div>
				 	</div>
				</div>

				<div class="col-xs-12"><hr /></div>
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo  __('Nights');?></div>
						<div class="col-xs-6 text-right">
						<?php echo __n('%s Night', '%s Night(s)', $this->request->query['days'], $this->request->query['days']); ?>
						</div>
				 	</div>
				</div>

				<div class="col-xs-12 ">
					<div class="row">
						<div class="col-xs-6"><?php echo  __('Price per night');?></div>
						<div class="col-xs-6  text-right"><?php echo $this->Number->currency($this->request->query['price_per_night'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']);?>
						</div>
				 	</div>
				</div>

				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo __('Subtotal');?></div>
						<div class="col-xs-6  text-right"><?php echo $this->Number->currency($this->request->query['subtotal_price'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></div>
					</div>
				</div>

				<?php if ($this->request->query['extra_guest']) { ?>
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo __('Extra guest price per night.');?></div>
						<div class="col-xs-6 text-right"><?php echo $this->Number->currency($this->request->query['extra_guest_price'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></div>
					</div>
				</div>
				<?php } ?>

				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo __('Cleaning fee');?></div>
						<div class="col-xs-6 text-right"><?php echo $this->Number->currency($this->request->query['cleaning_fee'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></div>
					</div>
				</div>

				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo __('Security fee');?></div>
						<div class="col-xs-6 text-right"><?php echo $this->Number->currency($this->request->query['security_fee'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></div>
					</div>
				</div>

				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6"><?php echo  __('Service Fee');?>&nbsp;<i data-toggle="tooltip" data-placement="top" title="<?php echo __('This is the Fee charged by Portal'); ?>"  class="fa fa-question-circle"></i></div>
						<div class="col-xs-6  text-right"><?php echo $this->Number->currency($this->request->query['service_fee'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></div>
					</div>
				</div>
				
				<div class="col-xs-12 "><hr /></div>
				<div class="col-xs-12 bookit-total">
					<div class="row">
						<div class="col-xs-6"><h3 class="bookit-label"><?php echo  __('Total'); ?></h3></div>
						<div class="col-xs-6 text-right"><h3 class="bookit-value"><?php echo $this->Number->currency($this->request->query['total_price'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></h3></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
// echo $this->Html->script('https://www.2checkout.com/checkout/api/2co.min.js', array('block' => 'scriptBottomMiddle'));
// echo $this->Html->script('https://checkout.stripe.com/checkout.js', array('block'=>'scriptBottomMiddle'));
$this->Html->scriptBlock("
	// var stripe_publish_key = document.getElementById('stripePublishableKey').value;
	
	// // Called when token created successfully.
	// var successCallback = function(data) {
	// 	var myForm = document.getElementById('checkout-form');

	// 	// Set the token as the value for the token input for stripe
	// 	document.getElementById('payment_token').value = data;
		
	// 	// For 2Checkout
	// 	document.getElementById('payment_token').value = data.response.token.token;

	// 	// IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
	// 	myForm.submit();
	// };
	// // Called when token creation fails.
	// var errorCallback = function(data) {
	// 	if (data.errorCode === 200) {
	// 		toastr.error('This error code indicates that the ajax call failed. We recommend that you retry the token request', data.errorMsg);
	// 		// This error code indicates that the ajax call failed. We recommend that you retry the token request.
	// 	} else {
	// 		toastr.error(data.errorMsg, 'Error!');
	// 	}
	// };
	// // Stripe handeler
	// var stripeHandler = StripeCheckout.configure({
	// 	key: $('#stripePublishableKey').val(), // geathered from api keys
	// 	token: function(token) {
	// 		// You can access the token ID with `token.id`.
	// 		// Get the token ID to your server-side code for use.
	// 		console.log(token);
	// 		// successCallback(token.id);
	// 	}
	// });
	// var tokenRequest = function() {
	// 	// Setup token request arguments
	// 	var args = {
	// 	    sellerId: '901403601',
	// 	    publishableKey: 'C1F8FD30-3A20-498B-B9D9-E595E59E2B99',
	// 		ccNo: $('#card_number').val(),
	// 		cvv: $('#security_code').val(),
	// 		expMonth: $('#card_expire_month').val(),
	// 		expYear: $('#card_expire_year').val()
	// 	};

	// 	// Make the token request
	// 	TCO.requestToken(successCallback, errorCallback, args);
	// };

	(function($){
		$(document).ready(function() {
			'use strict';
			
			// // Pull in the public encryption key for our environment
			// TCO.loadPubKey('production');
			// TCO.loadPubKey('sandbox');
			// $('#checkout-form').on('submit', function(e) {
			//     e.preventDefault();
			// 	var __that = $(this);
			// 	var payment_type = $('#payment_method_select').val();
			// 	if (payment_type === 'paypal') {
			// 	} else if (payment_type === 'stripe') {
			// 		var \$bookBtn = $('#book-now-btn');
			// 		// Open Checkout with further options:
			// 		stripeHandler.open({
			// 			name: \$bookBtn.data('name'),
			// 			description: \$bookBtn.data('description'),
			// 			amount: parseInt(\$bookBtn.data('amount')),
			// 			image: \$bookBtn.data('image'),
			// 			currency: \$bookBtn.data('currency'),
			// 			locale: \$bookBtn.data('locale'),
			// 			zipCode: true,
			// 			billingAddress: false,
			// 			opened: function() {
			// 				// The callback to invoke when Checkout is opened.
			// 				console.log('The callback to invoke when Checkout is opened.');
			// 			},
			// 			closed: function() {
			// 				// The callback to invoke when Checkout is closed.
			// 				// Called after the token or source callback.
			// 				console.log('The callback to invoke when Checkout is closed.');
			// 			}
			// 		});
			// 		// Close Checkout on page navigation:
			// 		window.addEventListener('popstate', function() {
			// 			stripeHandler.close();
			// 		});
			// 	} else if (payment_type === 'twocheckout') {
			// 		tokenRequest();
			// 	} else {
			// 		// something went wrong.
			// 	}
			// 	// Prevent form from submitting
			// 	return false;
			// });

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
