<?php
    /*This css is applied only to this page*/
    echo $this->Html->css('users', null, array('block'=>'cssMiddle'));

    $localeCurrency = $this->Html->getLocalCurrency();
    if (isset($reservation['Reservation']['currency']) && !empty($reservation['Reservation']['currency']) && trim($reservation['Reservation']['currency'])!='') {
        $localeCurrency = trim($reservation['Reservation']['currency']);
    }

    $reservation_id = (int) $reservation['Reservation']['id'];

    // debug($conversation);
    // die();
?>
<?php //debug($this->request->data); ?>
<div class="em-container book-property-overview make-top-spacing">
    <div class="row" id="elementToMask">
        <div class="col-md-4 user-sidebar">
            <?php echo $this->Form->create('Reservation',array('url'=>array('controller' => 'reservation', 'action' => 'reservation_request', $reservation['Reservation']['id']), 'class'=>'form-horizontal', 'id' => 'reservation_form')); ?>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <div class="media">
                        <div class="panel-image">
                            <?php
                                echo $this->Html->link($this->Html->displayUserAvatar($reservation['Traveler']['image_path'], ["alt"=>$reservation['Traveler']['name'], "height"=>"130", "width"=>"130"]),array('controller' => 'users', 'action' => 'view', $reservation['Traveler']['id']),array('escape' => false, 'class' => 'media-photo media-round'));
                            ?>
                        </div>
                        <div class="h4 text-center">
                            <?php
                                echo $this->Html->link($reservation['Traveler']['name'] . '&nbsp;' . $reservation['Traveler']['surname'], array('controller' => 'users', 'action' => 'view', $reservation['Traveler']['id']), array('escape' => false, 'class' => 'text-normal'));
                            ?>
                        </div>
                    </div>
                </div>
                <br />
                <div class="col-xs-12 ">
                    <?php
                        echo $this->Html->link(getDescriptionHtml($reservation['Property']['PropertyTranslation']['title']), array('controller' => 'properties', 'action' => 'view', $reservation['Property']['id']), array('escape' => false, 'class' => 'h4'));
                    ?>
                </div>

                <div class="col-xs-12"><hr /></div>

                <div class="col-xs-12 ">
                    <div class="property-guests">
                        <?php echo  __('Booking For %d guests for %d nights. ', $reservation['Reservation']['guests'], $reservation['Reservation']['nights']); ?>
                    </div>
                </div>

                <div class="col-xs-12 ">
                    <div class="property-checkin-checkout">
                        <?php echo  __('<b>%s</b> to <b>%s</b>',[$reservation['Reservation']['checkin'], $reservation['Reservation']['checkout']]); ?>
                    </div>
                </div>

                <div class="col-xs-12"> <hr /> </div>

                <div class="h4 col-xs-12"><?php echo __('Payments'); ?></div>
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6"><?php echo  __('Nights');?></div>
                        <div class="col-xs-6 text-right">
                        <?php echo __n('%s Night', '%s Night(s)', $reservation['Reservation']['nights'], $reservation['Reservation']['nights']);?>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 ">
                    <div class="row">
                        <div class="col-xs-6"><?php echo  __('Price per night');?></div>
                        <div class="col-xs-6 text-right"><?php echo  $this->Number->currency($reservation['Reservation']['price'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']);?>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6"><?php echo __('Subtotal');?></div>
                        <div class="col-xs-6 text-right"><?php echo $this->Number->currency($reservation['Reservation']['subtotal_price'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></div>
                    </div>
                </div>

                <?php if ($reservation['Reservation']['extra_guest_price']) { ?>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-6"><?php echo __('Extra guest price per night.');?></div>
                            <div class="col-xs-6 text-right"><?php echo $this->Number->currency($reservation['Reservation']['extra_guest_price'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></div>
                        </div>
                    </div>
                <?php } ?>

                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6"><?php echo __('Cleaning fee');?></div>
                        <div class="col-xs-6 text-right"><?php echo $this->Number->currency($reservation['Reservation']['cleaning_fee'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6"><?php echo __('Security fee');?></div>
                        <div class="col-xs-6 text-right"><?php echo $this->Number->currency($reservation['Reservation']['security_fee'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6"><?php echo  __('Service Fee');?>&nbsp;<i data-toggle="tooltip" data-placement="top" title="<?php echo __('This is the Fee charged by Portal'); ?>"  class="fa fa-question-circle"></i></div>
                        <div class="col-xs-6 text-right"><?php echo $this->Number->currency($reservation['Reservation']['service_fee'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6"><?php echo  __('Cancelation');?></div>
                        <div class="col-xs-6 text-right"><?php echo $reservation['CancellationPolicy']['name']; ?></div>
                    </div>
                </div>

                <div class="col-xs-12 "><hr /></div>

                <div class="col-xs-12 bookit-total">
                    <div class="row">
                        <div class="col-xs-6"><h3 class="bookit-label"><?php echo  __('Total'); ?></h3></div>
                        <div class="col-xs-6"><h3 class="bookit-value text-right"><?php echo $this->Number->currency($reservation['Reservation']['total_price'], $localeCurrency, ['thousands' => ',', 'decimals' => '.']); ?></h3></div>
                    </div>
                </div>
                <span class="help-block"><?php echo __('Protect your payments. Never pay for a reservation outside the platform.');?><i data-toggle="tooltip" data-placement="top" title="<?php echo __('Never pay for a reservation outside the %s rental website.', Configure::read('Website.name')); ?>"  class="fa fa-question-circle"></i></span>

                <div class="col-xs-12">
                    <a href="javascript:void(0);" class="btn btn-dark pull-right" onclick="javascript:print_confirmation();">
                        <?php echo __("Print Confirmation");  ?>
                    </a>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>

    	<div class="col-md-8">
            <?php
                echo $this->Form->create('Reservation',array('url'=> '/'));
                echo $this->Form->input('reservation_id', array('type'=>'hidden', 'id' => 'reservation_id', 'value' => $reservation_id));
                echo $this->Form->end();
            ?>

            <?php $date = gmdate('D, d M Y H:i:s \G\M\T', time()); ?>
            <?php if ('pending_approval' === $reservation['Reservation']['reservation_status']) { ?>
                <?php
                    $timestamp = strtotime($reservation['Reservation']['book_date']);
                    $gmtTime   = get_gmt_time(strtotime('+24 hours',$timestamp));
                    $gmtTime   = get_gmt_time(strtotime('-18 minutes',$gmtTime));
                    $date      = gmdate('D, d M Y H:i:s \G\M\T', $gmtTime);
                ?>
                <div class="panel no-border panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-6">
                                <strong><?php echo __("Request sent"); ?></strong>
                            </div>
                            <div class="col-lg-6">
                                <span style="font-size: 15px;" class="pull-right label label-info">
                                    <i class="fa fa-clock-o"></i>&nbsp;
                                    <strong class="expires_in"><?php echo __("Expires in"); ?></strong>&nbsp;
                                    <span class="expire-countdown"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-danger" role="alert" id="expired_alert" style="display: none">
                            <strong><?php echo __('Expired');?></strong>
                            <?php echo __('Sorry but this reservation has expired.');?>
                        </div>
                        <?php echo $this->Html->tag('p', __('Your reservation isn’t confirmed yet. You’ll hear back within 24 hours.')); ?>
                    </div>
                </div>
            <?php } elseif ('payment_pending' === $reservation['Reservation']['reservation_status']) { ?>
                <div class="panel no-border panel-default">
                    <div class="panel-heading">
                        <?php echo __("Waiting Payment"); ?>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->Html->tag('p', __('%s pre-approved your trip. Please proceed with the payment and enjoy your staying.', $reservation['Host']['name'])); ?>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <?php echo $this->Form->postLink(
                                    $this->Html->tag('i', '', array('class' => 'fa fa-money', 'aria-hidden'=>'true')).'&nbsp;'.__('Proceed with Payment'),
                                    array('controller' => 'reservations', 'action' => 'pay_host', $reservation['Reservation']['id']),
                                    array('escape' => false, 'class'=> 'btn book-now-btn'),
                                    __("Are you sure you want to proceed with payment for this reservation?")
                                    );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } elseif ('payment_completed' === $reservation['Reservation']['reservation_status']) { ?>
                <div class="panel no-border panel-default">
                    <div class="panel-heading">
                        <?php echo __("Status: %s", h(Inflector::humanize($reservation['Reservation']['reservation_status']))); ?>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->Html->tag('p', __('Reservation confirmed. You’ve got a place to call home in %s. Enjoy your staying.', h($reservation['Property']['address']))); ?>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn simple-btn" data-toggle="modal" data-target="#declineReservationModal">
                                <?php echo __("View Itinerary"); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } elseif ('declined' === $reservation['Reservation']['reservation_status']) { ?>
                <div class="alert alert-danger" role="alert">
                    <strong><?php echo __('Declined');?></strong>
                    <?php echo __('Sorry but this reservation has been declined by Host.');?>
                </div>
            <?php } elseif ('expired' === $reservation['Reservation']['reservation_status']) { ?>
                <div class="alert alert-danger" role="alert">
                    <strong><?php echo __('Expired');?></strong>
                    <?php echo __('Sorry but this reservation has expired.');?>
                </div>
            <?php  } else { ?>
                <div class="alert alert-info" role="alert">
                    <strong><?php echo __('Reservation Status: %s', h(Inflector::humanize($reservation['Reservation']['reservation_status'])));?></strong>
                </div>
            <?php  } ?>


    		<!--chat start-->
    		<div class="panel panel-warning">
    			<header class="panel-heading clearfix">
    			<?php echo __('Conversation with %s %s.', [$reservation['Host']['name'], $reservation['Host']['surname']]); ?>
                <div class="seperator"></div>
                <?php
                    echo $this->Form->create('Reservation',array('url'=>array('controller' => 'reservations', 'action' => 'request_sent', $reservation['Reservation']['id']), 'id'=>'reservation_request_form', 'class' => 'form-horizontal'));

                    echo $this->Form->input('property_id',array('type'=>'hidden', 'value'=>$reservation['Reservation']['property_id']));
                    echo $this->Form->input('reservation_id',array('type'=>'hidden', 'value'=>$reservation['Reservation']['id']));
                    echo $this->Form->input('contact_id',array('type'=>'hidden', 'value'=>0));
                    echo $this->Form->input('user_to',array('type'=>'hidden', 'value'=>$reservation['Host']['id']));
                    echo $this->Form->input('user_by',array('type'=>'hidden', 'value'=>AuthComponent::user('id'))); 
                    ?>
                    <div class="input-group">
                        <?php
                            echo $this->Form->input('message',array('type'=>'text','class'=>'form-control chat-input', 'label'=>false, 'div'=>false, 'placeholder'=>__('Enter your message here'), 'id'=> 'message_element'));
                        ?>
                        <span class="input-group-btn">
                            <?php
                                echo $this->Form->input(__('Send'), array('type'=>'submit', 'class'=>'btn btn-dark', 'id'=>'sendMessage','label'=>false,'div'=>false));
                            ?>
                        </span>
                    </div>
                <?php echo $this->Form->end(); ?>
    		</div>

            <div class="conversation-list panel-body">
            <?php
            if (isset($conversation) && !empty($conversation)) {
                // debug($conversation);
                foreach ($conversation as $message){
                    if ($message['Message']['conversation_id'] != 0) {
                        if ($message['Message']['user_by'] == AuthComponent::user('id')) { ?>
                        <div class="clearfix odd">
                            <div class="chat-avatar">
                                <?php
                                    echo $this->Html->link(
                                        $this->Html->displayUserAvatar($message['UserBy']['image_path'],
                                        ["height"=>"50", "width"=>"50", 'size'=>'small']),
                                        ['controller' => 'users', 'action' => 'view', $message['UserBy']['id']],
                                        ['escape' => false, 'class' => 'media-photo media-round']
                                    );
                                ?>
                                <i><?php echo $this->Time->niceShort($message['Message']['created']); ?></i>
                                <p><?php echo __("You"); ?></p>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <p><?php echo h($message['Message']['message']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="clearfix even">
                            <div class="chat-avatar">
                                <?php
                                    echo $this->Html->link(
                                        $this->Html->displayUserAvatar($message['UserBy']['image_path'],
                                        ["height"=>"50", "width"=>"50", 'size'=>'small']),
                                        ['controller' => 'users', 'action' => 'view', $message['UserBy']['id']],
                                        ['escape' => false, 'class' => 'media-photo media-round']
                                    );
                                ?>
                                <i><?php echo $this->Time->niceShort($message['Message']['created']); ?></i>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <i><?php echo h($message['UserBy']['name']); ?></i>
                                    <p><?php echo h($message['Message']['message']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php }
                    }
                }
            }
            ?>
            </div>
            <hr>
            <?php if (isset($query) && !empty($query)) { ?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <h5 class="h5"><?php echo h($query['Message']['message']); ?></h5>
                            <p class="text-muted">
                            <?php echo h($query['Reservation']['checkin']) . ' / ' . h($query['Reservation']['checkout']) . ', ' . h($query['Reservation']['guests']) . '&nbsp;' . __('Guests'); ?>
                            </p>
                            <i class="pull-right"><?php echo $this->Time->niceShort($query['Message']['created']); ?></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
    	</div>
    </div>
</div>

<script>
    function print_confirmation() {
        var myElement = document.getElementById("reservation_form").innerHTML;
        var myWindow;
        myWindow=window.open('','_blank','width=800,height=500');
        myWindow.document.write(myElement);
        myWindow.print();
    }

    function liftOff() {
        // hide timer
        $('.expires_in').hide();
        $('#expired_alert').show();
        var reservation_id = $("#reservation_id").val();
        $.ajax({
            type: "POST",
            url: fullBaseUrl + '/reservations/expire/' + reservation_id,
            async: true,
            data: "reservation_id="+reservation_id,
            success: function(data) {
                location.reload(true);
            }
        });
    }
</script>
<?php
    echo $this->Html->script("frontend/countdown/jquery.plugin.min", array('block' => 'scriptBottomMiddle'));
    echo $this->Html->script("frontend/countdown/jquery.countdown.min", array('block' => 'scriptBottomMiddle'));

    $reservation_status = trim($reservation['Reservation']['reservation_status']);

    $this->Html->scriptBlock("
        (function($){
            $(document).ready(function() {
                'use strict';

                var reservationStatus = '".$reservation_status."';

                if (reservationStatus === 'pending_approval') {
                    $('.expire-countdown').countdown({
                        until: new Date(\"".$date."\"),
                        format: 'dHMS',
                        layout:'{hn}:'+'{mn}:'+'{sn}',
                        onExpiry: liftOff,
                        expiryText: 'Expired'
                    });
                }

                $('#elementToMask').on('click', '#sendMessage', function(event) {
                    event.preventDefault();
                    var str = $('#message_element').val();
                    if (str.trim() === '') {
                        alert('enter the comment');
                        return false;
                    }
                    $(this).prop('disabled',true);

                    var \$form = $('#reservation_request_form');
                    \$form.submit();
                    if (\$form.data('submitted') === true) {
                        // Previously submitted - don't submit again
                        e.preventDefault();
                    } else {
                        // Mark it so that the next submit can be ignored
                        \$form.data('submitted', true);
                    }
                });
            });
        })(jQuery);
    ", array('block' => 'scriptBottom'));
?>