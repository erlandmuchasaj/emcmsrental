<?php
	$siteLogo = 'general/logo.png';
	$thisName = Configure::check('Website.name') ? Configure::read('Website.name') : '[NAME]';
	$siteTagline = Configure::check('Website.tagline') ? Configure::read('Website.tagline') : '[TAGLINE]';
	$siteSlogan = Configure::check('Website.slogan') ? Configure::read('Website.slogan') : '[SLOGAN]';
	$siteName = Configure::check('Website.sitename') ? Configure::read('Website.sitename') : '[SITENAME]';
	$siteCopyRight = Configure::check('Website.copyright') ? Configure::read('Website.copyright') : '[COPYRIGHT]';
	$sitePowerBy = Configure::check('Website.powered_by') ? Configure::read('Website.powered_by') : '[POWEREDBY]';
	$siteEmail = Configure::check('Website.email') ? Configure::read('Website.email') : '[EMAIL]';
	$sitePhone = Configure::check('Website.contact_number') ? Configure::read('Website.contact_number') : '[PHONE]';
	$siteAddress = Configure::check('Website.address') ? Configure::read('Website.address') : '[ADDRESS]';
	$offlineMessage = Configure::check('Website.offline_message') ? Configure::read('Website.offline_message') : '[OFFLINE_MESSAGE]';
?>
<div id="print_receipt" class="main-content-wrapper payment-info print">
	<div class="row">
	    <div class="col-md-12">
	        <section class="panel">
	       		<?php if (isset($reservation) && !empty($reservation)) { ?>
	            <div class="panel-body invoice">
	                <div class="invoice-header">
	                    <div class="invoice-title col-md-4 col-sm-6">
	                        <h1><?php echo __('invoice'); ?></h1>
	                    </div>
	                    <div class="invoice-info col-md-8 col-sm-6 ">
	                        <div class="row">
	                            <div class="col-md-5 col-sm-6 text-right">
	                                <?php echo h($siteAddress);?>
	                            </div>
	                            <div class="col-md-7 col-sm-6 text-left">
		                           	<?php echo  __('Phone: %s', $sitePhone);?>
			                        <br>
			                        <?php echo  __('Email: %s', $siteEmail);?>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="row invoice-to">
	                    <div class="col-md-6">
	                        <h4><?php echo  __('Invoice From');?>:</h4>
	                        <h2><?php echo h($siteName);?></h2>
	                        <p>
	                            <?php echo h($siteAddress);?>
	                            <br>
	                            <?php echo  __('Phone: %s',$sitePhone);?>
	                            <br>
	                            <?php echo  __('Email: %s', $siteEmail);?>
	                        </p>
	                    </div>
	                    <div class="col-md-6">
	                        <div class="row">
	                            <div class="col-md-12">
		                            <span class="inv-label"><?php echo  __('Invoice #');?></span>	
		                            <?php echo time(); ?>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-md-12">
		                            <span class="inv-label"><?php echo  __('Date #');?></span>	
		                            <?php echo $this->Time->format('D, j F Y ',time()); ?>
	                            </div>
	                        </div>
	                        <?php if(false) { ?>
	                        <div class="row">
	                            <div class="col-md-12">
		                            <span class="inv-label"><?php // echo  __('Confirmation code');?></span>	
		                            <?php // echo $reservation['Reservation']['confirmation_code'];?>
	                            </div>
	                        </div>
	                        <?php } ?>
	                        <div class="row">
	                            <div class="col-md-12 inv-label">
	                                <h3><?php echo  __('TOTAL DUE');?></h3>
	                            </div>
	                            <div class="col-md-12">
	                                <h1 class="amnt-value">
	                                <?php 
										echo $this->Number->currency($reservation['Reservation']['price'], $reservation['Reservation']['currency']); 
									?>
	                                </h1>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <table class="table table-invoice">
	                    <thead>
		                    <tr>
		                        <th>#</th>
		                        <th><?php echo  __('Attribute');?></th>
		                        <th><?php echo  __('Value');?></th>
		                    </tr>
	                    </thead>
	                    <tbody>
	                    	<tr>
		                        <td>1</td>
		                        <td><h4><?php echo __('Host'); ?></h4></td>
		                        <td><p><?php echo $host['User']['name'].'&nbsp;'.$host['User']['surname']; ?></p></td>
		                    </tr>
	                    	<tr>
		                        <td>2</td>
		                        <td><h4><?php echo __('Location'); ?></h4></td>
		                        <td><p><?php echo h($reservation['Property']['country']); ?></p></td>
		                    </tr>
		                    <tr>
		                        <td>3</td>
		                        <td><h4><?php echo __('Address'); ?></h4></td>
		                        <td><p><?php echo h($reservation['Property']['address']); ?></p></td>
		                    </tr>
		                    <tr>
		                        <td>4</td>
		                        <td><h4><?php echo __('Traveler'); ?></h4></td>
		                        <td><p><?php echo $reservation['User']['name'].'&nbsp;'.$reservation['User']['surname']; ?></p></td>
		                    </tr>
		                    <tr>
		                        <td>5</td>
		                        <td><h4><?php echo __('Checkin'); ?></h4></td>
		                        <td><p><?php echo $reservation['Reservation']['checkin']; ?></p></td>
		                    </tr>
		                    <tr>
		                        <td>6</td>
		                        <td><h4><?php echo __('Checkout'); ?></h4></td>
		                        <td><p><?php echo $reservation['Reservation']['checkout']; ?></p></td>
		                    </tr>
		                    <tr>
		                        <td>7</td>
		                        <td><h4><?php echo __('You Stay'); ?></h4></td>
		                        <td><p><?php echo $reservation['Reservation']['nights']; ?></p></td>
		                    </tr>
		                    <tr>
		                        <td>8</td>
		                        <td><h4><?php echo __('Nr. Guests'); ?></h4></td>
		                        <td><p><?php echo $reservation['Reservation']['guests']; ?></p></td>
		                    </tr>
	                    </tbody>
	                </table>
	                <div class="row">
	                    <div class="col-sm-6 col-xs-4 payment-method">
	                        <h4><?php echo  __('Payment Method');?></h4>
	                        <p><?php
	                        	$payment_method = Inflector::camelize(h($reservation['Reservation']['payment_method']));
		                        // $payment_method = h($reservation['Reservation']['payment_method']);
		                        // $payment_method = str_replace('_', ' ', $payment_method);
		                        // $payment_method = ucwords($payment_method); 
		                        echo $payment_method;
	                        ?></p>
	                        <br>
	                        <h3 class="inv-label itatic"><?php echo  __('Thank you for your business');?></h3>
	                    </div>
	                    <?php 
							$timeDifference = strtotime($reservation['Reservation']['checkout']) - strtotime($reservation['Reservation']['checkin']);
							$pozitiveDiff	= abs($timeDifference);
							$nrOfdays 		= ceil($pozitiveDiff/(3600*24));
						?>
	                    <div class="col-sm-6 col-xs-8 invoice-block">
	                        <ul class="unstyled amounts remove-padding-left">
	                            <li>
		                            <?php 
		                            	echo __('Sub: ') . $this->Number->currency($reservation['Reservation']['avarage_price'], $reservation['Reservation']['currency']) .' X '. __('%s Nights',$nrOfdays); 
		                            	echo ' = '.$this->Number->currency($reservation['Reservation']['subtotal_price'], $reservation['Reservation']['currency']); 
		                            ?>
	                            </li>
	                            <li>
	                            	<?php echo __('Service Fee %s', ' = '); ?>
	                            	<?php 
										echo $this->Number->currency($reservation['Reservation']['service_fee'], $reservation['Reservation']['currency']); 
									?>
	                            </li>
	                            <?php
									if ($reservation['Reservation']['refundable']) {
										echo '<li>';
										echo __('Refundable Fee %s', '=');
										echo $this->Number->currency($reservation['Reservation']['refundable_fee'], $reservation['Reservation']['currency']); 
										echo '</li>';
									}
								?>
	                            <li class="grand-total"><?php echo __('Total'); ?> : <?php echo $this->Number->currency($reservation['Reservation']['price'], $reservation['Reservation']['currency']); ?></li>
	                        </ul>
	                    </div>
	                </div>
	                <div class="row">
		                <div class="col-md-12">
		                    <a id="print_invoice" class="avoid-this btn btn-success btn-lg pull-right" href="javascript:void(0);"><i class="fa fa-print"></i>&nbsp;<?php echo __('Print');?></a>
		                </div>
	                </div>
	            </div>
	            <?php } ?>
	        </section>
	    </div>
	</div>
</div>
<?php
	echo $this->Html->script('datepicker/plugins', array('block'=>'scriptBottomMiddle')); 
	echo $this->Html->script('jQuery.print', array('block'=>'scriptBottomMiddle')); 
	$this->Html->scriptBlock("
		(function($) {
			'use strict';
			setTimeout(function() {
				$('body').removeClass('notransition');
			}, 300);
			$('#print_invoice').on('click', function() {
				$('#print_receipt').print({
					globalStyles : true,
					mediaPrint : false,
					iframe : false,
					noPrintSelector : '.avoid-this',
					prepend : '',
					append : ''
				});
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?> 