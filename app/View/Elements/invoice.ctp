<section id="print_receipt" class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header invoice-title">
				<?php
					echo $this->Html->tag('div', $this->Html->image('general/logo_mini.png', ['alt'=>'company logo', 'class'=>'portal-logo img-responsive']), ['escape' => false, 'class'=>'side-logo']);

					if (Configure::check('Website.name') && !empty( Configure::read('Website.name'))) {
						echo h(Configure::read('Website.name'));
					} else {
						echo __('Sitename');
					}
				?>
				<small class="pull-right"><?php echo $this->Time->format('D, j F Y ', time()); ?></small>
			</h3>
			<!-- <small><?php //echo Configure::check('Website.tagline') ? h(Configure::read('Website.tagline')) : '[NAME]';?></small> -->
			<?php
				if (Configure::check('Website.address') && !empty( Configure::read('Website.address'))) {
					echo h(Configure::read('Website.address'));
				}
			?>
		</div>
	</div>

	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			<?php echo __('Traveler'); ?>
			<address>
				<strong><?php echo $reservation['Traveler']['name'] . ' ' . $reservation['Traveler']['surname']; ?></strong><br>
				<?php echo __('Email: %s', $reservation['Traveler']['email']); ?>
			</address>
		</div>

		<div class="col-sm-4 invoice-col">
			<?php echo __('Host'); ?>
			<address>
				<strong><?php echo $reservation['Host']['name'] . ' ' . $reservation['Host']['surname']; ?></strong><br>
				<?php echo __('Email: %s', $reservation['Host']['email']); ?>
			</address>
		</div>

		<div class="col-sm-4 invoice-col">
			<!-- <b><?php //echo __('Invoice  #%s', $reservation['Reservation']['confirmation_code']);?></b><br> -->
			<b><?php echo __('Order ID'); ?>:</b>&nbsp;<?php echo $reservation['Reservation']['id'];?><br>
			<b><?php echo __('Order status');?>:</b>&nbsp;<?php echo Inflector::humanize($reservation['Reservation']['reservation_status']);?><br>
			<b><?php echo __('Payment date');?>:</b>&nbsp;<?php echo $this->Time->format('D, j F Y ', $reservation['Reservation']['payed_date']);?><br>
			<b><?php echo __('Confirmation code');?>:</b>&nbsp;<?php echo $reservation['Reservation']['confirmation_code'];?><br>
			<b><?php echo __('Cancellation policy');?>:</b>&nbsp;<?php echo $reservation['CancellationPolicy']['name'];?>
		</div>
	</div>
	<div class="seperator"></div>

	<!-- Table row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<!-- table-condensed -->
				<table class="table table-striped">
					<tbody>
						<tr>
							<th><?php echo __('Destination of the journey'); ?></th>
							<td><?php echo $reservation['Property']['country']; ?></td>
						</tr>
						<tr>
							<th><?php echo __('Title'); ?></th>
							<td><?php echo $reservation['Property']['PropertyTranslation']['title']; ?></td>
						</tr>
						<tr>
							<th><?php echo __('Address'); ?></th>
							<td><?php echo $reservation['Property']['address']; ?></td>
						</tr>
						<tr>
							<th><?php echo __('Checkin'); ?></th>
							<td><?php echo $reservation['Reservation']['checkin']; ?></td>
						</tr>
						<tr>
							<th><?php echo __('Checkout'); ?></th>
							<td><?php echo $reservation['Reservation']['checkout']; ?></td>
						</tr>
						<tr>
							<th><?php echo __('Duration'); ?></th>
							<td>
							<?php
								echo __n('%s Night', '%s Nights', $reservation['Reservation']['nights'], $reservation['Reservation']['nights']);
							?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('Price per night'); ?></th>
							<td>
							<?php
								echo $this->Number->currency($reservation['Reservation']['price'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format'));
							?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('Number of guests'); ?></th>
							<td><?php echo $reservation['Reservation']['guests']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- accepted payments column -->
	<div class="row">
		<div class="col-sm-6">
			<div class="invoice-col-info">
				<p class="lead no-print avoid-this">
					<?php echo __('Payment Method: %s.', Inflector::humanize($reservation['Reservation']['payment_method'])); ?>
				</p>
				<?php 
					if ('paypal' === $reservation['Reservation']['payment_method']) { 
						echo $this->Html->image('general/paypal.jpg', array('alt'=>'Paypal', 'class'=>'img-responsive'));
					} elseif ('stripe' === $reservation['Reservation']['payment_method']) { 
						echo $this->Html->image('general/stripe.png', array('alt'=>'Stripe', 'class'=>'img-responsive')); 
					} elseif ('credit_card' === $reservation['Reservation']['payment_method']) {
						echo $this->Html->image('general/credit_card.png', array('alt'=>'Credit Card', 'class'=>'img-responsive')); 
					} elseif ('twocheckout' === $reservation['Reservation']['payment_method']) {
						echo $this->Html->image('general/twocheckout.png', array('alt'=>'2Checkout', 'class'=>'img-responsive')); 
					} else {
					}
				?>
			</div>
			<?php echo $this->Html->tag('p', __('%1$s is authorized to accept Accommodation Fees on behalf of the Host as its limited agent. This means that your payment obligation to the Host is satisfied by your payment to %1$s. Any disagreements by the Host regarding that payment must be settled between the Host and %1$s.', Configure::read('Website.name')), ['class' => 'text-muted well well-sm no-shadow invoice-col-info', 'style' => 'margin-top: 10px']); ?>
		</div>
		<!-- /.col -->
		<div class="col-sm-6">
			<p class="lead"><?php echo __('Reservation costs'); ?>:</p>
			<div class="table-responsive">
				<table class="table">
					<!--
					<tr>
						<th style="width:50%"><?php // echo __('Price'); ?>:</th>
						<td>
						<?php // echo $this->Number->currency($reservation['Reservation']['price'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format')) .' X '. __('%s Nights', $reservation['Reservation']['nights']); ?>
						</td>
					</tr>
					-->
					<tr>
						<th style="width:50%"><?php echo __('Subtotal'); ?>:</th>
						<td>
						<?php
							echo $this->Number->currency($reservation['Reservation']['subtotal_price'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format'));
						?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Cleaning fee'); ?>:</th>
						<td>
						<?php
							echo $this->Number->currency($reservation['Reservation']['cleaning_fee'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format'));
						?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Security fee'); ?>:</th>
						<td>
						<?php
							echo $this->Number->currency($reservation['Reservation']['security_fee'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format'));
						?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Additional Guest fee'); ?>:</th>
						<td>
						<?php
							echo $this->Number->currency($reservation['Reservation']['extra_guest_price'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format'));
						?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Service fee'); ?>:</th>
						<td>
						<?php
							echo $this->Number->currency($reservation['Reservation']['service_fee'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format'));
						?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Total'); ?>:</th>
						<td>
						<?php
							echo $this->Number->currency($reservation['Reservation']['total_price'], $reservation['Reservation']['currency'], Configure::read('Website.currency_format'));
						?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- /.col -->
	</div>

	<!-- this row will not appear when printing -->
	<div class="row no-print avoid-this">
		<div class="col-xs-12">
			<button id="print_invoice" type="button" class="btn btn-default" onclick="print_confirmation();">
				<i class="fa fa-print"></i>&nbsp;<?php echo __('Print'); ?>
			</button>
			<!-- 
			<button id="generate_pdf" type="button" class="btn btn-primary pull-right">
				<i class="fa fa-download"></i>&nbsp;<?php // echo __('Generate PDF');?>
			</button>
			-->
		</div>
	</div>
</section>
<?php echo $this->Html->script('frontend/print/jQuery.print', array('block'=>'scriptBottomMiddle')); ?>

<script>
	function print_confirmation() {
	    $('#print_receipt').print({
	        deferred: $.Deferred().done(function(){ console.log('Printing done', arguments);})
	    });
	}
</script>

