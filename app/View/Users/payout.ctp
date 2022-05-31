<?php echo $this->Html->css('users', null, array('block'=>'cssMiddle'));?>
<div class="em-container make-top-spacing">
	<div class="row">
		<div class="col-lg-3 col-md-4 user-sidebar"> 
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8"> 

			<div class="row">
			    <div class="col-sm-6">
		            <div class="alert alert-danger alert-dismissible fade in">
		              <strong>Warning!</strong>
		              <span class="info-box-number">This Feature is still in development and will be comming soon.</span>
		            </div>
			    </div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<?php if (isset($errors) && count($errors) > 0) { ?>
						<div class="alert alert-danger alert-dismissible fade in" role="alert" style="z-index: 9999;">
							<button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
							<?php foreach($errors as $error){?>
								<?php foreach($error as $er){ ?>
									<?php echo __('<strong>Error!</strong>'); ?>
									<?php echo h($er); ?>
									<br />
								<?php } ?>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="panel panel-em no-border">
				<div class="panel-heading"><?php echo __('Payout preferences'); ?></div>
				<div class="panel-body">
					<?php echo $this->Html->tag('p', __('When you receive a payment for a reservation, we call that payment to you a “payout”. Our secure payment system supports several payout methods, which can be setup and edited here. Your available payout options and currencies differ by country..'))?>

					<table id="payout_methods" class="table table-striped">
						<thead>
							<tr>
								<th><?php echo __('Method'); ?></th>
								<th><?php echo __('Details'); ?></th>
								<th><?php echo __('Status'); ?></th>
								<th><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php if (!empty($preferences)): ?>
							<?php foreach ($preferences as $key => $preference): ?>
								<tr>
									<td><?php echo Inflector::humanize($preference['PayoutPreference']['payout_method']); ?></td>
									<td><?php echo h($preference['PayoutPreference']['paypal_email']); ?></td>
									<td><?php echo h($preference['PayoutPreference']['status']); ?></td>
									<td> Dropdown </td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
						</tbody>
						<tfoot>
							<tr>
								<td>
									<a id="add_payout_method_button" class="btn btn-primary pop-striped" href="javascript:void(0);">
										<?php echo __('Add Payout Method'); ?>
									</a>
									<span class="text-muted"><?php echo __('Stripe, PayPal, etc...'); ?></span>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
				<!-- <div class="panel-footer">Panel Footer</div> -->
			</div>
		</div>
	</div>
</div>

<!-- STRIPE related data -->
<?php  echo $this->Form->input('stripe_publish_key',array('type'=>'hidden','value' => Configure::read('Stripe.Publishable'), 'id' => 'stripe_publish_key')); ?>

<div id="payout_popup1" class="modal modal-danger fade" aria-hidden="true" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo $this->Form->create('Address', array('url' => array('controller' => 'users', 'action' => 'payout'), 'class' =>'form-horizontal', 'id'=>'address')); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->tag('h4', __('Add Payout Method')) ?>
			</div>
			<div class="modal-body">
				<div class="flash-container" id="popup1_flash-container"></div>

				<div class="form-group">
				    <label for="payout_info_payout_country" class="col-sm-3 control-label"><?php echo __('Country');?>*</label>
					<div class="col-sm-9">
				        <?php echo $this->Form->input('Address.country',array('id'=>'payout_info_payout_country', 'label'=>false, 'div'=>false,'class'=>'form-control', 'required' => 'required', 'empty' => __('Select Country'), 'options' => $countries)); ?>
				    </div>
				</div>

				<div class="form-group">
				    <label for="payout_info_payout_address1" class="col-sm-3 control-label"><?php echo __('Address');?>*</label>
					    <div class="col-sm-9">
				        <?php echo $this->Form->input('Address.address1',array('id' => 'payout_info_payout_address1','label'=>false, 'div'=>false,'class'=>'form-control', 'required' => 'required'));?>
				    </div>
				</div>

				<div class="form-group">
				    <label for="payout_info_payout_address2" class="col-sm-3 control-label"><?php echo __('Address (2)');?></label>
					    <div class="col-sm-9">
				        <?php echo $this->Form->input('Address.address2',array('id' => 'payout_info_payout_address2','label'=>false, 'div'=>false,'class'=>'form-control'));?>
				    </div>
				</div>

				<div class="form-group">
				    <label for="payout_info_payout_city" class="col-sm-3 control-label"><?php echo __('City');?>*</label>
					    <div class="col-sm-9">
				        <?php echo $this->Form->input('Address.city',array('id' => 'payout_info_payout_city','label'=>false, 'div'=>false,'class'=>'form-control', 'required' => 'required'));?>
				    </div>
				</div>

				<div class="form-group">
				    <label for="payout_info_payout_state" class="col-sm-3 control-label"><?php echo __('State');?></label>
					<div class="col-sm-9">
				        <?php echo $this->Form->input('Address.state',array('id'=>'payout_info_payout_state', 'label'=>false, 'div'=>false,'class'=>'form-control')); ?>
				    </div>
				</div>

				<div class="form-group">
				    <label for="payout_info_payout_zip" class="col-sm-3 control-label"><?php echo __('ZIP/Postal Code');?>*</label>
					    <div class="col-sm-9">
				        <?php echo $this->Form->input('Address.postal_code',array('id'=>'payout_info_payout_zip', 'label'=>false, 'div'=>false, 'class'=>'form-control', 'required' => 'required'));?>
				    </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary"><?php echo __('Next');?></button>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<div id="payout_popup2" class="modal modal-danger fade" aria-hidden="true" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo $this->Form->create('Address', array('url' => array('controller' => 'users', 'action' => 'payout'), 'class' =>'form-horizontal', 'id'=>'country_options')); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->tag('h4', __('Add Payout Method')) ?>
			</div>
			<div class="modal-body">
				<div class="flash-container" id="popup2_flash-container"></div>
				<?php echo $this->Form->input('address1', array('type'=>'hidden', 'id' => 'payout_info_payout2_address1'));?>
				<?php echo $this->Form->input('address2', array('type'=>'hidden', 'id' => 'payout_info_payout2_address2'));?>
				<?php echo $this->Form->input('city', array('type'=>'hidden', 'id' => 'payout_info_payout2_city'));?>
				<?php echo $this->Form->input('country', array('type'=>'hidden', 'id' => 'payout_info_payout2_country'));?>
				<?php echo $this->Form->input('state', array('type'=>'hidden', 'id' => 'payout_info_payout2_state'));?>
				<?php echo $this->Form->input('postal_code', array('type'=>'hidden', 'id' => 'payout_info_payout2_zip'));?>

				<?php echo $this->Html->tag('p', __('Payouts for reservations are released to you after 14 days from your guest check out, and it takes some additional time for the money to arrive depending on your payout method.'))?>

				<?php echo $this->Html->tag('p', __('We can send money to people with these payout methods. Which do you prefer?'))?>

				<table id="payout_method_descriptions" class="table table-striped">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th><?php echo __('Payout method'); ?></th>
							<th><?php echo __('Processing time'); ?></th>
							<th><?php echo __('Additional fees'); ?></th>
							<th><?php echo __('Currency'); ?></th>
							<th><?php echo __('Details'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if (!empty($payments)): ?>
						<?php foreach ($payments as $key => $payment): ?>
							<tr>
								<td>
									<input type="radio" value="<?php echo $payment['Payment']['slug']; ?>" name="payout_method" class="payout_method" id="payout_method_<?php echo $payment['Payment']['slug']; ?>">
								</td>
								<td class="type">
									<label for="payout_method_<?php echo $payment['Payment']['slug']; ?>">
										<?php echo h($payment['Payment']['name']); ?>
									</label>
								</td>
								<td><?php echo h($payment['Payment']['arrives_on']); ?></td>
								<td><?php echo h($payment['Payment']['fees']); ?></td>
								<td><?php echo h($payment['Payment']['currency']); ?></td>
								<td><?php echo getDescriptionHtml($payment['Payment']['note']); ?></td>
							</tr>
						<?php endforeach ?>
					<?php endif ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="submit" id="select-payout-method-submit" class="btn btn-primary"><?php echo __('Next');?></button>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<div id="payout_popup3" class="modal modal-danger fade" aria-hidden="true" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo $this->Form->create('PayoutPreference', array('url' => array('controller' => 'users', 'action' => 'payout'), 'class' =>'form-horizontal', 'id'=>'payout_paypal')); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->tag('h4', __('Add Payout Method - Paypal!')) ?>
			</div>
			<div class="modal-body">
				<div class="flash-container" id="popup3_flash-container"></div>

				<?php echo $this->Html->tag('p', __('PayPal is an online payment processing service that allows you to receive payments from %1$s.To use PayPal with %1$s, you must have an existing account with PayPal.', h(Configure::read('Website.name'))))?>

				<?php echo $this->Form->input('address1', array('type'=>'hidden', 'id' => 'payout_info_payout3_address1'));?>
				<?php echo $this->Form->input('address2', array('type'=>'hidden', 'id' => 'payout_info_payout3_address2'));?>
				<?php echo $this->Form->input('city', array('type'=>'hidden', 'id' => 'payout_info_payout3_city'));?>
				<?php echo $this->Form->input('country', array('type'=>'hidden', 'id' => 'payout_info_payout3_country'));?>
				<?php echo $this->Form->input('state', array('type'=>'hidden', 'id' => 'payout_info_payout3_state'));?>
				<?php echo $this->Form->input('postal_code', array('type'=>'hidden', 'id' => 'payout_info_payout3_zip'));?>
				<?php echo $this->Form->input('payout_method', array('type'=>'hidden', 'id' => 'payout3_method', 'value' => 'paypal'));?>
		        <div class="form-group book-style">
					<?php
						echo $this->Form->input('paypal_email', [
							'label' => __('Enter the email address associated with your existing PayPal account.'),
							'id' => 'paypal_email',
							'div'=> [
								'class' => 'col-md-12'
							],
							'class'=>'form-control',
							'type'=>'email',
							'required'=>'required',
							'autocomplete'=>'off',
							'placeholder' => __('Paypal Email address'),
							'value'=>'',
						]);
					?>
				</div>
		        <div class="form-group book-style">
					<?php
						echo $this->Form->input('currency', [
							'label' => __('In what currency would you like to be paid?'),
							'id' => 'currency',
							'div'=> [
								'class' => 'col-md-12'
							],
							'class'=>'form-control',
							'type' => 'select',
							'required'=>'required',
							'empty' => __('Choose Currency'),
							'options' => [
								'AUD' => 'AUD',
								'BGN' => 'BGN',
								'BRL' => 'BRL',
								'CAD' => 'CAD',
								'CHF' => 'CHF',
								'CNY' => 'CNY',
								'DKK' => 'DKK',
								'EUR' => 'EUR',
								'GBP' => 'GBP',
								'HKD' => 'HKD',
								'HRK' => 'HRK',
								'HUF' => 'HUF',
								'IDR' => 'IDR',
								'ILS' => 'ILS',
								'INR' => 'INR',
								'JPY' => 'JPY',
								'KRW' => 'KRW',
								'MYR' => 'MYR',
								'NOK' => 'NOK',
								'NZD' => 'NZD',
								'PHP' => 'PHP',
								'PLN' => 'PLN',
								'RON' => 'RON',
								'RUB' => 'RUB',
								'SEK' => 'SEK',
								'SGD' => 'SGD',
								'THB' => 'THB',
								'TRY' => 'TRY',
								'USD' => 'USD',
								'ZAR' => 'ZAR',
							],
							'value'=>'EUR',
						]);
					?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="modal-paypal-submit"><?php echo __('Submit');?></button>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<div id="payout_popup_stripe" class="modal modal-danger fade" aria-hidden="true" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo $this->Form->create('PayoutPreference', array('url' => array('controller' => 'users', 'action' => 'payout'), 'class' =>'form-horizontal', 'id'=>'payout_stripe')); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->tag('h4', __('Add Payout Method - Stripe!')) ?>
			</div>
			<div class="modal-body">
				<div class="flash-container" id="popup4_flash-container"></div>
				<?php echo $this->Form->input('address1', array('type'=>'hidden', 'id' => 'payout_info_payout4_address1'));?>
				<?php echo $this->Form->input('address2', array('type'=>'hidden', 'id' => 'payout_info_payout4_address2'));?>
				<?php echo $this->Form->input('city', array('type'=>'hidden', 'id' => 'payout_info_payout4_city'));?>
				<?php echo $this->Form->input('country', array('type'=>'hidden', 'id' => 'payout_info_payout4_country'));?>
				<?php echo $this->Form->input('state', array('type'=>'hidden', 'id' => 'payout_info_payout4_state'));?>
				<?php echo $this->Form->input('postal_code', array('type'=>'hidden', 'id' => 'payout_info_payout4_zip'));?>
				<?php echo $this->Form->input('payout_method', array('type'=>'hidden', 'id' => 'payout4_method', 'value' => 'stripe'));?>
				<?php echo $this->Form->input('holder_type', array('type'=>'hidden', 'id' => 'holder_type', 'value' => 'individual'));?>
				<?php echo $this->Form->input('stripe_token', array('type'=>'hidden', 'id' => 'stripe_token'));?>

				<div class="form-group book-style">
					<?php
						echo $this->Form->input('country', [
							'label' => __('In what currency would you like to be paid?'),
							'id' => 'payout_info_payout_country1',
							'div'=> [
								'class' => 'col-md-12'
							],
							'class'=>'form-control',
							'type' => 'select',
							'required'=>'required',
							'empty' => __('Choose Country'),
							'options' => [
								'AU' => 'Australia',
								'AT' => 'Austria',
								'BE' => 'Belgium',
								'BR' => 'Brazil',
								'CA' => 'Canada',
								'DK' => 'Denmark',
								'FI' => 'Finland',
								'FR' => 'France',
								'DE' => 'Germany',
								'GI' => 'Gibraltar',
								'HK' => 'Hong Kong',
								'IE' => 'Ireland',
								'IT' => 'Italy',
								'JP' => 'Japan',
								'LU' => 'Luxembourg',
								'MX' => 'Mexico',
								'NL' => 'Netherlands',
								'NZ' => 'New Zealand',
								'NO' => 'Norway',
								'PT' => 'Portugal',
								'SG' => 'Singapore',
								'ES' => 'Spain',
								'SE' => 'Sweden',
								'CH' => 'Switzerland',
								'GB' => 'United Kingdom',
								'US' => 'United States',
							],
							'value'=>'US',
						]);
					?>
				</div>

				<div class="form-group book-style">
					<?php
						echo $this->Form->input('currency', [
							'label' => __('In what currency would you like to be paid?'),
							'id' => 'payout_info_payout_currency',
							'div'=> [
								'class' => 'col-md-12'
							],
							'class'=>'form-control',
							'type' => 'select',
							'required'=>'required',
							'empty' => __('Choose Currency'),
							'options' => [
								'USD' => 'USD',
								'AUD' => 'AUD',
								'BRL' => 'BRL',
								'CAD' => 'CAD',
								'CHF' => 'CHF',
								'DKK' => 'DKK',
								'EUR' => 'EUR',
								'GBP' => 'GBP',
								'HKD' => 'HKD',
								'JPY' => 'JPY',
								'MXN' => 'MXN',
								'NOK' => 'NOK',
								'NZD' => 'NZD',
								'SEK' => 'SEK',
								'SGD' => 'SGD',
							],
							'value'=>'EUR',
						]);
					?>
				</div>

				<div class="form-group book-style">
					<?php
						echo $this->Form->input('routing_number', [
							'label' => __('Routing Number'),
							'id' => 'routing_number',
							'div'=> [
								'class' => 'col-md-12'
							],
							'class'=>'form-control',
							'type' => 'text',
							// 'autocomplete' => 'off',
							'value'=>'',
						]);
					?>
				</div>

				<div class="form-group book-style">
					<?php
						echo $this->Form->input('account_number', [
							'label' => __('Account Number (IBAN Number)'),
							'id' => 'account_number',
							'div'=> [
								'class' => 'col-md-12'
							],
							'class'=>'form-control',
							'type' => 'text',
							// 'autocomplete' => 'off',
							'required'=>'required',
							'value'=>'',
						]);
					?>
				</div>

				<div class="form-group book-style">
					<?php
						echo $this->Form->input('holder_name', [
							'label' => __('Account Holder Name'),
							'id' => 'holder_name',
							'div'=> [
								'class' => 'col-md-12'
							],
							'class'=>'form-control',
							'type' => 'text',
							// 'autocomplete' => 'off',
							'required'=>'required',
							'value'=>'',
						]);
					?>
				</div>

				<div class="form-group book-style">
					<?php
						echo $this->Form->input('ssn_last_4', [
							'label' => __('SSN last 4 digits'),
							'id' => 'ssn_last_4',
							'div'=> [
								'class' => 'col-md-12'
							],
							'class'=>'form-control',
							'type' => 'text',
							// 'autocomplete' => 'off',
							'required'=>'required',
							'value'=>'',
						]);
					?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="modal-stripe-submit"><?php echo __('Submit');?></button>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<?php
$this->Html->script('https://js.stripe.com/v2/', array('block'=>'scriptBottomMiddle'));
$this->Html->script('https://js.stripe.com/v3/', array('block'=>'scriptBottomMiddle'));
$this->Html->scriptBlock("
	var stripe_publish_key = document.getElementById('stripe_publish_key').value;
	var stripe = Stripe.setPublishableKey(stripe_publish_key);

	var country,
		payout_country,
		old_currency,
		payout_currency,
		country_currency,
		country_currency,
		isDisabled = false,
		isValidSelection = true,
		alreadySubmitted = false;

	(function($){
		$(document).ready(function() {
			'use strict';

			var change_currency = function() {
			    var selected_country = [];
			    $.each(country_currency, function(key, value) {
			        if ($('#payout_info_payout_country1').val() == key) {
			            selected_country = value;
			        }
			    });
			    if (selected_country) {
			        var \$el = $('#payout_info_payout_currency');
			        \$el.empty();
			        $.each(selected_country, function(key, value) {
			            \$el.append($('<option></option>').attr('value', value).text(value));
			            if (old_currency != '') {
			                $('#payout_info_payout_currency').val(payout_currency);
			            } else {
			                $('#payout_info_payout_currency').val(selected_country[0]);
			            }
			        });
			    } else {
			        var \$el = $('#payout_info_payout_currency');
			        \$el.empty();
			        \$el.append($('<option></option>').attr('value', '').text('Select'));
			    }
			    if ($('#payout_info_payout_currency').val() == '' || $('#payout_info_payout_currency').val() == null) {
			        $('#payout_info_payout_currency').val($('#payout_info_payout_currency option:first').val());
			    }
			};

			var disablePayoutOption = function(event, target_base_url, payout_id) {
			    if (isDisabled == true) {
			        event.preventDefault();
			        return true;
			    }
			    isDisabled = true;
			    $('.payout_options').addClass('disabled');
			    window.location.href = target_base_url + payout_id;
			};

			$('#address').on('submit', function(e) {

			    e.preventDefault();
				
				$('#popup1_flash-container').html('');

				var isValid = true,
					validationHTML = new Array();

				validationHTML.push('<div class=\"alert alert-danger alert-dismissible\">');
				validationHTML.push('    <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>');
				validationHTML.push('    <strong>Error!</strong>');
				
				
			    if ($('#payout_info_payout_address1').val().trim() == '') {
			    	validationHTML.push('Address cannot be blank.<br>');
			        isValid = false;
			    }

			    if ($('#payout_info_payout_city').val().trim() == '') {
			    	validationHTML.push('City cannot be blank.<br>');
			        isValid = false;
			    }
			    if ($('#payout_info_payout_zip').val().trim() == '') {
			    	validationHTML.push('Postal Code cannot be blank.<br>');
			        isValid = false;
			    }
			    if ($('#payout_info_payout_country').val().trim() == null) {
			    	validationHTML.push('Country cannot be blank.<br>');
			        isValid = false;
			    }

			    validationHTML.push('</div>');

			    if (isValid == false) {
					$('#popup1_flash-container').html(validationHTML.join(''));
					return false;
			    }

			    $('#payout_info_payout2_address1').val($('#payout_info_payout_address1').val());
			    $('#payout_info_payout2_address2').val($('#payout_info_payout_address2').val());
			    $('#payout_info_payout2_city').val($('#payout_info_payout_city').val());
			    $('#payout_info_payout2_state').val($('#payout_info_payout_state').val());
			    $('#payout_info_payout2_zip').val($('#payout_info_payout_zip').val());
			    $('#payout_info_payout2_country').val($('#payout_info_payout_country').val());
				
			    $('#payout_popup1').modal('hide');
			    $('#payout_popup2').modal('show');

			    return false;
			});

			$('#country_options').on('submit', function(e) {
				e.preventDefault();
					
				$('#popup2_flash-container').html('');

				var isValid = true,
					validationHTML = new Array();

				validationHTML.push('<div class=\"alert alert-danger alert-dismissible\">');
				validationHTML.push('    <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>');
				validationHTML.push('    <strong>Error!</strong>');
				
			    if ($('input[name=\"payout_method\"]:checked').val() == undefined) {
			    	validationHTML.push('Choose Payout Method.<br>');
			        isValid = false;
			    }

			    validationHTML.push('</div>');

			    if (isValid == false) {
					$('#popup2_flash-container').html(validationHTML.join(''));
					return false;
			    }

			    $('#payout_info_payout3_address1').val($('#payout_info_payout2_address1').val());
			    $('#payout_info_payout3_address2').val($('#payout_info_payout2_address2').val());
			    $('#payout_info_payout3_city').val($('#payout_info_payout2_city').val());
			    $('#payout_info_payout3_state').val($('#payout_info_payout2_state').val());
			    $('#payout_info_payout3_zip').val($('#payout_info_payout2_zip').val());
			    $('#payout_info_payout3_country').val($('#payout_info_payout2_country').val());
			    $('#payout3_method').val($('input[name=\"payout_method\"]:checked').val());

			    $('#payout_info_payout4_address1').val($('#payout_info_payout2_address1').val());
			    $('#payout_info_payout4_address2').val($('#payout_info_payout2_address2').val());
			    $('#payout_info_payout4_city').val($('#payout_info_payout2_city').val());
			    $('#payout_info_payout4_state').val($('#payout_info_payout2_state').val());
			    $('#payout_info_payout4_zip').val($('#payout_info_payout2_zip').val());
			    $('#payout_info_payout4_country').val($('#payout_info_payout2_country').val());
			    $('#payout4_method').val($('input[name=\"payout_method\"]:checked').val());

			    var payout_method = $('#payout3_method').val();
			    
			    $('#payout_popup2').modal('hide');

			    if (payout_method == 'stripe') {
			    	$('#payout_popup_stripe').modal('show');
			    } else {
			    	$('#payout_popup3').modal('show');
			    }

			    return false;
			});

			$('#payout_paypal').on('submit', function(e) {
				var _thisForm = $(this);

				e.preventDefault();
				
			    var payout_method = $('#payout3_method').val();

			    var validationHTML = new Array();
			    validationHTML.push('<div class=\"alert alert-danger alert-dismissible\">');
			    validationHTML.push('    <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>');
			    validationHTML.push('    <strong>Error!</strong> Enter Valid Email ID.');
			    validationHTML.push('</div>');

			    if (payout_method != 'paypal') {
			        return false;
			    }

			    var emailChar = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			    if (emailChar.test($('#paypal_email').val())) {
					$('#popup3_flash-container').html('');

					var myForm = document.getElementById('payout_paypal');
					myForm.submit();

			        return true;
			    } else {
			        $('#popup3_flash-container').html(validationHTML.join(''));
			        return false;
			    }
			});

			$('#add_payout_method_button').on('click', function(event) {
				event.preventDefault();
				event.stopPropagation();

				$('#payout_popup1').modal('show');

				return false;
			});

			$('#payout_info_payout_country').on('change', function() {
			    country = $(this).val();
			    $('#payout_info_payout_country1').val($(this).val());
			    if ($('#payout_info_payout_country1').val() == '' || $('#payout_info_payout_country1').val() == undefined) {
			        payout_country = '';
			        payout_currency = '';
			    } else {
			        payout_country = $(this).val();
			        $('#payout_info_payout_country1').trigger('change');
			    }
			});

			$('#ssn_last_4').keypress(function(e) {
			    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			        return false;
			    }
			});

			$(document).on('change', '#payout_info_payout_country1', function() {
			    payout_currency = $('#payout_info_payout_currency').val();
			});

			$(document).on('change', '#payout_info_payout_currency', function() {
			    payout_currency = $('#payout_info_payout_currency').val()
			});


			$('#payout_stripe').submit(function() {
			    $('#payout_info_payout4_address1').val($('#payout_info_payout_address1').val());
			    $('#payout_info_payout4_address2').val($('#payout_info_payout_address2').val());
			    $('#payout_info_payout4_city').val($('#payout_info_payout_city').val());
			    $('#payout_info_payout4_state').val($('#payout_info_payout_state').val());
			    $('#payout_info_payout4_zip').val($('#payout_info_payout_zip').val());
			    stripe_token = $('#stripe_token').val();
			    if (stripe_token != '') {
			        return true;
			    }
			    if ($('#payout_info_payout_country1').val() == '') {
			        $('#stripe_errors').html('Please fill all required fields');
			        return false;
			    }
			    if ($('#payout_info_payout_currency').val() == '') {
			        $('#stripe_errors').html('Please fill all required fields');
			        return false;
			    }
			    if ($('#holder_name').val() == '') {
			        $('#stripe_errors').html('Please fill all required fields');
			        return false;
			    }

			    is_iban = $('#is_iban').val();

			    var bankAccountParams = {
			        country: $('#payout_info_payout_country1').val(),
			        currency: $('#payout_info_payout_currency').val(),
			        account_number: $('#account_number').val(),
			        account_holder_name: $('#holder_name').val(),
			        account_holder_type: $('#holder_type').val()
			    };

			    if (is_iban == 'No') {
			        bankAccountParams.routing_number = $('#routing_number').val();
			    }

			    $('#payout_stripe').addClass('loading');
			    country = payout_country;
			    Stripe.bankAccount.createToken(bankAccountParams, stripeResponseHandler);
			    return false;
			});

			function stripeResponseHandler(status, response) {
			    $('#payout_stripe').removeClass('loading');
			    if (response.error) {
			        $('#stripe_errors').html('');
			        if (response.error.message == 'Must have at least one letter') {
			            $('#stripe_errors').html('Please fill all required fields');
			        } else {
			            $('#stripe_errors').html(response.error.message);
			        }
			        return false;
			    } else {
			        $('#stripe_errors').html('');
			        var token = response['id'];
			        $('#stripe_token').val(token);
			        $('#payout_stripe').removeClass('loading');
			        $('#payout_stripe').submit();
			        return true;
			    }
			}

		});
	})(jQuery);
", array('block' => 'scriptBottom'));
?>
