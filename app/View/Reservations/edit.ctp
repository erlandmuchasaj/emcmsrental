<?php echo $this->Form->create('Reservation'); ?>
	<fieldset>
		<legend><?php echo __('Edit Reservation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_by');
		echo $this->Form->input('user_to');
		echo $this->Form->input('property_id');
		echo $this->Form->input('checkin');
		echo $this->Form->input('checkout');
		echo $this->Form->input('guests');
		echo $this->Form->input('nights');
		echo $this->Form->input('currency');
		echo $this->Form->input('confirmation_code');
		echo $this->Form->input('reservation_status');
		echo $this->Form->input('reservation_type');
		echo $this->Form->input('payment_method');
		echo $this->Form->input('payment_country');
		echo $this->Form->input('price');
		echo $this->Form->input('subtotal_price');
		echo $this->Form->input('cleaning_fee');
		echo $this->Form->input('security_fee');
		echo $this->Form->input('service_fee');
		echo $this->Form->input('extra_guest_price');
		echo $this->Form->input('avarage_price');
		echo $this->Form->input('total_price');
		echo $this->Form->input('to_pay');
		echo $this->Form->input('cancellation_policy_id');
		echo $this->Form->input('book_date');
		echo $this->Form->input('payed_date');
		echo $this->Form->input('cancel_date');
		echo $this->Form->input('is_payed');
		echo $this->Form->input('is_payed_host');
		echo $this->Form->input('is_payed_guest');
		echo $this->Form->input('is_canceled');
		echo $this->Form->input('is_refunded');
		echo $this->Form->input('reason_to_cancel');
		echo $this->Form->input('deleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
