<?php
	if (isset($booking['Message']['data']) && !empty($booking['Message']['data'])) {
		$booking_data = json_decode($booking['Message']['data'], true);
	} else {
		die('Booking data is not set.');
	}
	$directorySmURL = IMAGES.'Property'.DS.$booking['Property']['id'].DS.'PropertyPicture'.DS .'small'.DS;
	$directorySmPATH = 'uploads/Property/'.$booking['Property']['id'].'/PropertyPicture/small/';
	$directoryUser = IMAGES . 'User' . DS . 'small' . DS;
	// host data
	$host_id 	= '';
	$host_name  = '';
	$host_image = '';
	$host_email = '';
	// traveler data
	$traveler_id 	= '';
	$traveler_name  = '';
	$traveler_image = '';
	$traveler_email = '';

	if ($booking['Property']['user_id'] == $booking['UserBy']['id']) {
		$host_id 	= $booking['UserBy']['id'];
		$host_name  = $booking['UserBy']['name'].' '.$booking['UserBy']['surname'];
		$host_image = $booking['UserBy']['image_path'];
		$host_email = $booking['UserBy']['email'];

		$traveler_id 	= $booking['UserTo']['id'];
		$traveler_name  = $booking['UserTo']['name'].' '.$booking['UserTo']['surname'];
		$traveler_image = $booking['UserTo']['image_path'];
		$traveler_email = $booking['UserTo']['email'];
	} else {
		$host_id 	= $booking['UserTo']['id'];
		$host_name  = $booking['UserTo']['name'].' '.$booking['UserTo']['surname'];
		$host_image = $booking['UserTo']['image_path'];
		$host_email = $booking['UserTo']['email'];

		$traveler_id 	= $booking['UserBy']['id'];
		$traveler_name  = $booking['UserBy']['name'].' '.$booking['UserBy']['surname'];
		$traveler_image = $booking['UserBy']['image_path'];
		$traveler_email = $booking['UserBy']['email'];
	}

	if (file_exists($directoryUser.$traveler_image) && is_file($directoryUser.$traveler_image)) {
		$base64 = 'uploads/User/small/'.$traveler_image;
		$traveler_image = $this->Html->image($base64, array('alt' => 'User Avatar', 'class'=>'traveler-img'));
	} else {
		$base64 = 'avatars/avatar.png';
		$traveler_image = $this->Html->image($base64, array('alt' => 'User Avatar', 'class'=>'traveler-img'));
	}

	$host_accept_url = Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'HostAccept',$booking['Message']['id']), true);
	$host_deny_url 	 = Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'HostDeny', $booking['Message']['id']), true);
	$host_offer_url  = Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'HostOffer',$booking['Message']['id']), true);
	$traveler_accept_url = Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'TravelerAccept',$booking['Message']['id']), true);
	$traveler_deny_url 	 = Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'HTravelerDeny', $booking['Message']['id']), true);

	// REVIEW CALCULATIONS
	$totalReviews	= 0;
	$averageRateAll	= '';
	$starRate		= '';
	/*===============*/
	$traveler_behavior		= 0;
	$traveler_responsibility= 0;
	$traveler_seriosity		= 0;
	$traveler_correctness	= 0;

	if (isset($userReviews) && !empty($userReviews)) {
		$totalReviews = count($userReviews);
		foreach ($userReviews as $userReview){
			$traveler_behavior		+= $userReview['Review']['traveler_behavior'];
			$traveler_responsibility+= $userReview['Review']['traveler_responsibility'];
			$traveler_seriosity		+= $userReview['Review']['traveler_seriosity'];
			$traveler_correctness	+= $userReview['Review']['traveler_correctness'];
		}
		$travelerBehaviorRate 		= ($traveler_behavior / $totalReviews);
		$travelerResponsibilityRate = ($traveler_responsibility / $totalReviews);
		$travelerSeriosityRate		= ($traveler_seriosity / $totalReviews);
		$travelerCorrectnessRate	= ($traveler_correctness / $totalReviews);

		$averageRateAll = ($travelerBehaviorRate + $travelerResponsibilityRate + $travelerSeriosityRate + $travelerCorrectnessRate) / 4;
		/* GENERAL RATE  Convert from (10) TO (4) */
		$starRate = round(($averageRateAll * 4) / 4, 2);
	}
?>
<div class="row">
	<div class="col-md-8">
		<section class="panel">
			<?php echo $this->Form->create('Message',array('url'=>array('user'=>true, 'controller' => 'messages', 'action' => 'auction', $booking['Message']['id']) ,'class'=>'form-horizontal', 'id'=>'auction_form'));
				echo $this->Form->input('id');
			?>
			<div class="twt-feed blue-bg row remove-margin">
				<div class="corner-ribon black-ribon">
					<i class="fa fa-info"></i>
				</div>
				<div class="fa fa-info wtt-mark"></div>
				<div class="col-md-2">
				<a href="javascript:void(0);">
					<?php
						if (file_exists($directorySmURL.$booking['Property']['thumbnail']) && is_file($directorySmURL .$booking['Property']['thumbnail'])){
							$base64 = $directorySmPATH. $booking['Property']['thumbnail'];
							echo $this->Html->image($base64, array('alt' => 'thumbnail','class'=>'img-responsive'));
						} else {
							echo $this->Html->image('no-img-available.png', array('alt' => __('property thumbnail'), 'class'=>"img-responsive"));
						}
					?>
				</a>
				</div>
				<div class="col-md-10">
					<?php
						echo $this->Html->tag('h1', __('Host: %s', h($host_name)));
						echo $this->Html->tag('p', __('Title: %s', h($booking['PropertyTranslation']['title'])));
						echo $this->Html->tag('p', __('Location: %s', h($booking['Property']['country'])));
						echo $this->Html->tag('p', __('Address: %s', h($booking['Property']['address'])));
					?>
				</div>
			</div>
			<div class="weather-category twt-category">
				<ul>
					<li>
						<div class="mini-stat clearfix">
							<span class="mini-stat-icon pink"><i class="fa fa-money"></i></span>
							<div class="mini-stat-info">
								<span><?php echo $booking_data['Booking']['total_price'].' '.$booking_data['Booking']['currency'];  ?></span>
								<?php echo __('Total price of booking'); ?>
							</div>
						</div>
					</li>
					<li>
						<div class="mini-stat clearfix">
							<span class="mini-stat-icon orange">
							<i class="fa fa-reply"></i>
							</span>
							<div class="mini-stat-info">
								<span><?php echo $booking_data['Booking']['offer'].' '.$booking_data['Booking']['currency'];  ?></span>
								<?php echo __('Traveler Offer'); ?>
							</div>
						</div>
					</li>
					<li>
						<div class="mini-stat clearfix">
							<span class="mini-stat-icon green">
								<i class="fa fa-reply-all"></i>
							</span>
							<div class="mini-stat-info">
								<span>
								<?php
									if (isset($booking_data['Booking']['host_offer']) && !empty($booking_data['Booking']['host_offer'])) {
										echo $booking_data['Booking']['host_offer'].' '.$booking_data['Booking']['currency'];
									} else {
										echo __('===');
									}
								?>
								</span>
								<?php
									if (isset($booking_data['Booking']['host_offer']) && !empty($booking_data['Booking']['host_offer'])) {
										echo __('Host Counter offer');
									} else {
										echo __('Host counter offer is not set.');
									}
								?>
							</div>
						</div>
					</li>
				</ul>
				<div class="overview-details">
					<ul class="checkin-details">
						<li>
							<label><?php echo __('Checkin'); ?>:</label>
							<span><?php echo $booking_data['Booking']['checkin'];?></span>
						</li>

						<li>
							<label><?php echo __('Checkout'); ?>:</label>
							<span><?php echo $booking_data['Booking']['checkout'];?></span>
						</li>

						<li>
							<label><?php echo __('You stay'); ?>:</label>
							<span><?php echo __('%s Nights', $booking_data['Booking']['nights']);?></span>
						</li>

						<li>
							<label><?php echo __('Guests'); ?>:</label>
							<span><?php echo __('%s Guests', $booking_data['Booking']['guests']);?></span>
						</li>

						<li>
							<label><?php echo __('Price per night'); ?>:</label>
							<span><?php echo $this->Number->currency($booking_data['Booking']['avarage_price_per_night'], $booking_data['Booking']['currency']);?></span>
						</li>

						<li>
							<label><?php echo __('Service fees'); ?>:</label>
							<span><?php echo $this->Number->currency($booking_data['Booking']['service_fee'], $booking_data['Booking']['currency']);?></span>
						</li>

						<li>
							<label><?php echo __('Refundable fees'); ?>:</label>
							<span><?php echo $this->Number->currency($booking_data['Booking']['refundable_fee'], $booking_data['Booking']['currency']);?></span>
						</li>

						<li>
							<label class="total-price"><?php echo __('Total'); ?>:</label>
							<span class="total-price"><?php echo $this->Number->currency($booking_data['Booking']['total_price'], $booking_data['Booking']['currency']);?></span>
						</li>
					</ul>
				</div>
			</div>
			<div id="new_offer_input" class="new-offer-input col-sm-12">
				<div class="input-group">
					<?php echo $this->Form->input('Message.new_offer',array('label'=>false, 'div'=>false,'class'=>'offer form-control t-text-area allow-only-numbers','type'=>'number', 'data-action-url'=>$host_offer_url, 'placeholder'=>__('Write your offer.'), 'autocomplete'=>'off', "disabled"=>"disabled", 'readonly'=>"readonly")); ?>
					<span class="input-group-btn">
						<button id="submit_offer" class="btn btn-default" type="button"><?php echo __('Submit Offer!');?></button>
					</span>
				</div>
			</div>
			<footer class="twt-footer footer-el">
				<!-- traveler_offer -->
				<?php
				if ((int)$booking['Message']['status']==1 && $booking['Property']['user_id'] == AuthComponent::user('id')) {
					echo $this->Form->input($this->Html->tag('i','', array('class'=>'fa fa-thumbs-o-up')) .'&nbsp;'.__('Accept'), array('id'=>'accept','type'=>'button', 'data-action-url'=>$host_accept_url, 'class'=>'btn btn-default btn-success accept','label'=>false,'div'=>false, 'escape' => false));
					echo "&nbsp;";
					echo $this->Form->input($this->Html->tag('i','', array('class'=>'fa fa-thumbs-o-down')) .'&nbsp;'.__('Deny'), array('id'=>'deny','type'=>'button', 'data-action-url'=>$host_deny_url, 'class'=>'btn btn-default btn-danger deny','label'=>false,'div'=>false, 'escape' => false));
					echo "&nbsp;";
					echo $this->Form->input($this->Html->tag('i','', array('class'=>'fa fa-mail-reply')) .'&nbsp;'.__('Conter-Offer'), array('id'=>'new_offer','type'=>'button', 'class'=>'btn btn-default btn-info new_offer','label'=>false,'div'=>false, 'escape' => false));
				} else if((int)$booking['Message']['status']==1 && (int)$booking['Property']['user_id'] != AuthComponent::user('id')) { ?>
					<div class="alert alert-info ">
						<span class="alert-icon"><i class="fa fa-info "></i></span>
						<div class="notification-info">
							<ul class="clearfix notification-meta">
								<li class="pull-left notification-sender"><?php echo __('Auction Offer'); ?></li>
								<li class="pull-right notification-time"><?php echo $this->Time->niceShort($booking['Message']['created']); ?></li>
							</ul>
							<p><a href="javascript:void(0);"><?php echo __('Your offer is waiting for host response'); ?></a></p>
						</div>
					</div>
				<?php } ?>

				<!-- host_offer -->
				<?php
				if ((int)$booking['Message']['status']==2 && $booking['Property']['user_id'] != AuthComponent::user('id')) {
					echo $this->Form->input($this->Html->tag('i','', array('class'=>'fa fa-thumbs-o-up')) .'&nbsp;'.__('Accept New Offer'), array('id'=>'accept_new_offer','type'=>'button', 'data-action-url'=>$traveler_accept_url,'class'=>'btn btn-default btn-success accept_new_offer','label'=>false,'div'=>false, 'escape' => false));
					echo "&nbsp;";
					echo $this->Form->input($this->Html->tag('i','', array('class'=>'fa fa-thumbs-o-down')) .'&nbsp;'.__('Deny New Offer'), array('id'=>'deny_new_offer','type'=>'button', 'data-action-url'=>$traveler_deny_url,'class'=>'btn btn-default btn-danger deny_new_offer','label'=>false,'div'=>false, 'escape' => false));
				} else if((int)$booking['Message']['status']==2 && $booking['Property']['user_id'] == AuthComponent::user('id')) { ?>
					<div class="alert alert-info ">
						<span class="alert-icon"><i class="fa fa-info "></i></span>
						<div class="notification-info">
							<ul class="clearfix notification-meta">
								<li class="pull-left notification-sender"><?php echo __('Auction Offer'); ?></li>
								<li class="pull-right notification-time"><?php echo $this->Time->niceShort($booking['Message']['created']); ?></li>
							</ul>
							<p><a href="javascript:void(0);"><?php echo __('Your offer is waiting traveler response'); ?></a></p>
						</div>
					</div>
				<?php } ?>

				<!-- accepted_by_traveler -->
				<?php if ((int)$booking['Message']['status']==3) { ?>
					<div class="alert alert-success ">
						<span class="alert-icon"><i class="fa fa-check"></i></span>
						<div class="notification-info">
							<ul class="clearfix notification-meta">
								<li class="pull-left notification-sender"><?php echo __("Auction Offer: Accepted by Traveler");?></li>
								<li class="pull-right notification-time"><?php echo $this->Time->niceShort($booking['Message']['created']); ?></li>
							</ul>
							<p>
								<a href="javascript:void(0);">
									<?php echo __("This Conter offer was <strong>Accepted</strong> by %s", h($traveler_name));?>
								</a>
							</p>
						</div>
					</div>
				<?php } ?>

				<!-- denied_by_traveler -->
				<?php if((int)$booking['Message']['status']==4) { ?>
					<div class="alert alert-danger ">
						<span class="alert-icon"><i class="fa fa-ban"></i></span>
						<div class="notification-info">
							<ul class="clearfix notification-meta">
								<li class="pull-left notification-sender"><?php echo __("Auction Offer: Denied by Traveler");?></li>
								<li class="pull-right notification-time"><?php echo $this->Time->niceShort($booking['Message']['created']); ?></li>
							</ul>
							<p>
								<a href="javascript:void(0);">
									<?php echo __("This Conter offer was <strong>Denied</strong> by %s", h($traveler_name));?>
								</a>
							</p>
							<?php echo $this->Html->tag('p', __("Proceed with booking your space")); ?>
						</div>
					</div>
				<?php } ?>

				<!-- accepted_by_host -->
				<?php if((int)$booking['Message']['status']==5) { ?>
					<div class="alert alert-success ">
						<span class="alert-icon"><i class="fa fa-check"></i></span>
						<div class="notification-info">
							<ul class="clearfix notification-meta">
								<li class="pull-left notification-sender"><?php echo __("Offer: Accepted by Host");?></li>
								<li class="pull-right notification-time"><?php echo $this->Time->niceShort($booking['Message']['created']); ?></li>
							</ul>
							<p><a href="javascript:void(0);"><?php echo __("This offer was <strong>Accepted</strong> by %s", h($host_name));?></a></p>
							<?php echo $this->Html->tag('p', __("Proceed with booking your space")); ?>
						</div>
					</div>
				<?php } ?>

				<!-- denied_by_host -->
				<?php if((int)$booking['Message']['status']==6) { ?>
					<div class="alert alert-danger ">
						<span class="alert-icon"><i class="fa fa-ban"></i></span>
						<div class="notification-info">
							<ul class="clearfix notification-meta">
								<li class="pull-left notification-sender"><?php echo __("Auction Offer: Denied by Host");?></li>
								<li class="pull-right notification-time"><?php echo $this->Time->niceShort($booking['Message']['created']); ?></li>
							</ul>
							<p>
								<a href="javascript:void(0);">
									<?php echo __("Sorry to say that this offer was <strong>denied</strong> by %s ", h($host_name));?>
								</a>
							</p>
							<p><?php echo __("But don't stop now, try <strong>searching</strong> again and message a few more hosts!"); ?></p>
						</div>
					</div>
				<?php } ?>

				<!-- expired -->
				<?php if((int)$booking['Message']['status']==7) { ?>
					<div class="alert alert-success ">
						<span class="alert-icon"><i class="fa fa-check"></i></span>
						<div class="notification-info">
							<ul class="clearfix notification-meta">
								<li class="pull-left notification-sender"><?php echo __("Auction Completed");?></li>
							</ul>
							<p><a href="javascript:void(0);"><?php echo __("This auction has been completed Successfully.");?></a></p>
						</div>
					</div>
				<?php } ?>

				<!-- expired -->
				<?php if((int)$booking['Message']['status']==8) { ?>
					<div class="alert alert-danger ">
						<span class="alert-icon"><i class="fa fa-ban"></i></span>
						<div class="notification-info">
							<ul class="clearfix notification-meta">
								<li class="pull-left notification-sender"><?php echo __("Auction Expired");?></li>
							</ul>
							<p>
								<a href="javascript:void(0);">
									<?php echo __("Sorry to inform you that this auction has <strong>Expired</strong>.");?>
								</a>
							</p>
							<?php echo $this->Html->tag('p', __("But don't stop now, try <strong>searching</strong> again and message a few more hosts!")); ?>
						</div>
					</div>
				<?php } ?>

				<!-- traveler_offer -->
				<?php
					if (((int)$booking['Message']['status']==3 || (int)$booking['Message']['status']==5) && (int)$booking['Property']['user_id'] != AuthComponent::user('id')) {
						echo $this->Form->input($this->Html->tag('i','', array('class'=>'fa fa-money')) .'&nbsp;'.__('Proceed with reservation.'), array('id'=>'payment','type'=>'button', 'class'=>'btn btn-default btn-success payment','label'=>false,'div'=>false, 'escape' => false));
					}
				?>
			</footer>
			<?php
				echo $this->Form->input('Message.property_id',array('type'=>'hidden'));
				echo $this->Form->input('Message.reservation_id',array('type'=>'hidden'));
				echo $this->Form->input('Message.conversation_id',array('type'=>'hidden'));
				echo $this->Form->input('Message.contact_id',array('type'=>'hidden'));
				echo $this->Form->input('Message.user_by',array('type'=>'hidden'));
				echo $this->Form->input('Message.user_to',array('type'=>'hidden'));
				echo $this->Form->input('Message.subject',array('type'=>'hidden'));
				echo $this->Form->input('Message.message',array('type'=>'hidden'));
				echo $this->Form->input('Message.message_type',array('type'=>'hidden'));
				echo $this->Form->input('Message.status',array('type'=>'hidden'));
				echo $this->Form->input('Message.data',array('type'=>'hidden'));
				echo $this->Form->input('Message.traveler_email',array('type'=>'hidden','value'=>$traveler_email));
				echo $this->Form->input('Message.host_email',array('type'=>'hidden', 'value'=>$host_email));
			?>
			<?php echo $this->Form->end();?>
		</section>
	</div>
	<div class="col-md-4">
		<div class="feed-box text-center">
			<section class="panel">
				<div class="panel-body">
					<?php
						echo $this->Html->link($traveler_image, array('user'=>false, 'admin'=>false, 'controller' => 'users', 'action' => 'view', $traveler_id),array('escape' => false, 'class'=>'traveler-img-wrapper', 'target'=>'_blank'));
						echo $this->Html->tag('h1',__('Traveler: %s', $traveler_name));
					?>
					<?php if (((int)$booking['Message']['status']==3 || (int)$booking['Message']['status']==5) || (int)$booking['Message']['status'] == 7) { ?>
						<p>email: <a href="mailto:<?php echo $traveler_email;?>"><?php echo $traveler_email;?></a></p>
					<?php } ?>
					<?php if (isset($userReviews) && !empty($userReviews)) { ?>
						<div class="text-left" style="display: inline-block;">
							<span class="stars"><?php echo $starRate;?></span>
							<span class="total-reviews"><?php echo '('.$totalReviews.')';?></span>
						</div>
					<?php } ?>
				</div>
			</section>
		</div>
	</div>
</div>
<?php
// echo $this->Html->script("calendar/jquery.dop.FrontendBookingCalendarPRO", array('block' => 'scriptBottomMiddle'));
$this->Html->scriptBlock("
$.fn.stars = (function() {
	return $(this).each(function() {
		var val = parseFloat($(this).html());
		var size = Math.max(0, (Math.min(5, val))) * 20;
		// val = Math.round(val * 4) / 4; /* To round to nearest quarter */
		// val = Math.round(val * 2) / 2; /* To round to nearest half */
		var span = $('<span />').width(size);
		$(this).html(span);
	});
});
(function ($) {
	'use strict';
	$(document).ready(function () {
		$(function () {
			$('.stars').stars();

			/*HOST ACTIONS*/
			$('#accept').on('click', function(e){
				$('#auction_form').attr('action', '".Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'HostAccept', $booking['Message']['id']), true)."');
				if (confirm('".addslashes(__('Are you sure that you want to accept this offer?'))."')){
					$('#auction_form').submit();
				}
				return false;
				e.epreventDefault();
				e.stopPropagation();
			});

			$('#deny').on('click', function(e){
				$('#auction_form').attr('action', '".Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'HostDeny', $booking['Message']['id']), true)."');
				if (confirm('".addslashes(__('Are you sure that you want to deny this offer?'))."')){
					$('#auction_form').submit();
				}
				return false;
				e.epreventDefault();
				e.stopPropagation();
			});

			$('#new_offer').on('click', function (e) {
				$('#new_offer_input').slideToggle();
				$('.offer', '#new_offer_input').prop('disabled', (_, val) => !val);
				$('.offer', '#new_offer_input').prop('readonly', (_, val) => !val);
				return false;
				e.epreventDefault();
				e.stopPropagation();
			});

			$('#submit_offer').on('click', function(e){
				if($.trim($('.offer', '#new_offer_input').val()) != '' ){
					$('#auction_form').attr('action', '".Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'HostOffer', $booking['Message']['id']), true)."');
					if (confirm('".addslashes(__('Are you sure that you want to continue?'))."')){
						$('#auction_form').submit();
					}
				} else {
					toastr.error('You must enter an offer in order to procees','Error!');
				};
				return false;
				e.epreventDefault();
				e.stopPropagation();
			});

			/*TRAVELER ACTIONS*/
			$('#accept_new_offer').on('click', function(e){
				$('#auction_form').attr('action', '".Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'TravelerAccept', $booking['Message']['id']), true)."');
				if (confirm('".addslashes(__('Are you sure that you want to accept this offer?'))."')){
					$('#auction_form').submit();
				}
				return false;
				e.epreventDefault();
				e.stopPropagation();
			});

			$('#deny_new_offer').on('click', function(e){
				$('#auction_form').attr('action', '".Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'TravelerDeny', $booking['Message']['id']), true)."');
				if (confirm('".addslashes(__('Are you sure that you want to deny this offer?'))."')){
					$('#auction_form').submit();
				}
				return false;
				e.epreventDefault();
				e.stopPropagation();
			});

			/*PROCEED WITH PAYMETN*/
			$('#payment').on('click', function(e){
				$('#auction_form').attr('action', '".Router::Url(array('user' => true, 'controller' =>'messages', 'action' => 'proceedPayment', $booking['Message']['id']), true)."');
				if (confirm('".addslashes(__('Are you sure that you want to proceed with reservation?'))."')){
					$('#auction_form').submit();
				}
				return false;
				e.epreventDefault();
				e.stopPropagation();
			});

			// ALLOW ONLY NUMBERS TO BE TYPED
			$('.allow-only-numbers').on('keyup keydown',function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				// Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				// Allow: home, end, left, right, down, up
				(e.keyCode >= 35 && e.keyCode <= 40)) {
					// let it happen, don't do anything
					return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
				return;
			});
		});
	});
})(jQuery);
", array('block' => 'scriptBottom'));
?>