<?php
    /*This css is applied only to this page*/
    echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
    // min later or merge
    // echo $this->Html->css('frontend/countdown/jquery.countdown', null, array('block'=>'cssMiddle'));
    /*This css is applied only to this page*/
    $localeCurrency = $this->Html->getLocalCurrency();
    if (isset($reservation['Reservation']['currency']) && !empty($reservation['Reservation']['currency']) && trim($reservation['Reservation']['currency'])!='') {
        $localeCurrency = trim($reservation['Reservation']['currency']);
    }

    $reservation_id = (int) $reservation['Reservation']['id'];

    // debug($conversation);
    // die();
?>
<?php //debug($reservation); ?>
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
                <span class="help-block"><?php echo __('Protect your payments. Never pay for a reservation outside the platform.');?><i data-toggle="tooltip" data-placement="top" title="<?php echo __('Never pay for a reservation outside the %s website.', Configure::read('Website.name')); ?>"  class="fa fa-question-circle"></i></span>

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
            
            <?php if ('pending_approval' === $reservation['Reservation']['reservation_status']) { ?>
                <div class="panel no-border panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php echo __("Requested Reservation"); ?>
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
                        <?php echo $this->Html->tag('p', __('You will be penalized if you do not accept or decline this request before it expires.')); ?>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn book-now-btn" data-toggle="modal" data-target="#allowReservationModal">
                                <?php echo __("Pre-Accept"); ?>
                                </button>

                                <button type="button" class="btn simple-btn" data-toggle="modal" data-target="#declineReservationModal">
                                <?php echo __("Decline"); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } elseif ('payment_pending' === $reservation['Reservation']['reservation_status']) { ?>
                <div class="panel no-border panel-default">
                    <div class="panel-heading">
                        <?php echo __("Status: %s", h(Inflector::humanize($reservation['Reservation']['reservation_status']))); ?>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->Html->tag('p', __('You pre-approved this trip. Wait for the payment to be completed.')); ?>
                    </div>
                </div>
            <?php } elseif ('payment_completed' === $reservation['Reservation']['reservation_status']) { ?>
                <div class="panel no-border panel-default">
                    <div class="panel-heading">
                        <?php echo __("Status: %s", h(Inflector::humanize($reservation['Reservation']['reservation_status']))); ?>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->Html->tag('p', __('You have an accepted reservation. We recommend keeping communication in the %1$s message thread for easy reference. For urgent situations, contact %1$s Team by email', Configure::read('Website.name'))); ?>
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
                    <?php echo __('You have allredy declined this reservation.');?>
                </div>
            <?php } elseif ('expired' === $reservation['Reservation']['reservation_status']) { ?>
                <div class="alert alert-danger" role="alert">
                    <strong><?php echo __('Expired');?></strong>
                    <?php echo __('Sorry but this reservation has expired.');?>
                </div>
            <?php  } else { ?>
                <div class="alert alert-info" role="alert">
                    <strong><?php echo h(Inflector::humanize($reservation['Reservation']['reservation_status']));?></strong>
                </div>
            <?php  } ?>

            <?php $date = gmdate('D, d M Y H:i:s \G\M\T', time()); ?>
            <?php if ($reservation['Reservation']['reservation_status'] === 'pending_approval') { ?>
                <?php
                    $hourdiff = round((time() - strtotime($reservation['Reservation']['book_date']))/3600, 0);
                    $timestamp = strtotime($reservation['Reservation']['book_date']);
                    $book_date = date('m/d/Y', $timestamp);
                    $gmtTime   = get_gmt_time(strtotime('+24 hours',$timestamp));
                    $date      = gmdate('D, d M Y H:i:s \G\M\T', $gmtTime);
                ?>
            <?php } ?>

    		<!--chat start-->
    		<div class="panel panel-warning">
    			<header class="panel-heading clearfix">
    			<?php echo __('Conversation with %s %s.', [h($reservation['Traveler']['name']), h($reservation['Traveler']['surname'])]); ?>
                <div class="seperator"></div>
                <?php
                    echo $this->Form->create('Reservation',array('url'=>array('controller' => 'reservations', 'action' => 'reservation_request', $reservation['Reservation']['id']), 'id'=>'reservation_request_form', 'class' => 'form-horizontal'));

                    echo $this->Form->input('property_id',array('type'=>'hidden', 'value'=>$reservation['Reservation']['property_id']));
                    echo $this->Form->input('reservation_id',array('type'=>'hidden', 'value'=>$reservation['Reservation']['id']));
                    echo $this->Form->input('contact_id',array('type'=>'hidden', 'value'=>0));
                    echo $this->Form->input('user_to',array('type'=>'hidden', 'value' => $reservation['Traveler']['id']));
                    echo $this->Form->input('user_by',array('type'=>'hidden', 'value' => AuthComponent::user('id')));
                ?>
                <div class="input-group">
                    <?php
                        echo $this->Form->input('message',array('type'=>'text','class'=>'form-control chat-input', 'label'=>false, 'div'=>false, 'placeholder'=>__('Enter your message here'), 'id'=> 'message_element'));
                    ?>
                    <span class="input-group-btn">
                        <?php
                            echo $this->Form->input(__('Send'), array('type'=>'submit','class'=>'btn btn-dark', 'id'=>'sendMessage','label'=>false,'div'=>false));
                        ?>
                    </span>
                </div>
                <?php echo $this->Form->end(); ?>
    		</div>

            <div class="conversation-list panel-body">
            <?php
            if (isset($conversation) && !empty($conversation)) {
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
                                    <i><?php echo h($message['UserBy']['name']); ?></i>
                                    <p><?php echo h($message['Message']['message']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } else {  ?>
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
                            <br>
                            <?php echo __('You will earn: %s.', $this->Number->currency($query['Reservation']['to_pay'], $query['Reservation']['currency'])); ?>
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
<!-- Button trigger modal -->

<?php if ($reservation['Reservation']['reservation_status'] === 'pending_approval'): ?>
    
<div id="allowReservationModal" class="modal fade" tabindex="-1" role="dialog"  aria-labelledby="allowReservationModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="ico-info"></i>&nbsp;<?php echo __("Pre-Accept this request"); ?></h4>
            </div>
            <div class="modal-body">
            <?php echo $this->Form->create('Reservation',array('url'=>array('controller' => 'reservations', 'action' => 'accept', $reservation['Reservation']['id']), 'class'=>'form-horizontal text-left', 'onsubmit'=>"javascript:event.preventDefault(), req_action('accept', this, event);")); ?>

                <p class="customTitle">
                    <?php echo __('Allow %s to book.', h($reservation['Traveler']['name'])); ?>
                </p>

                <p>
                <?php

                echo $this->Form->textarea('message', array('rows'=>5, 'id' => 'comment', 'class' => 'col-md-12 col-sm-12 col-xs-12' ,'placeholder' => __('Type optional message to guest...')));
                ?>
                </p>


                <div class="form-group book-style">
                    <div class="col-md-6 col-sm-8">
                    <?php echo $this->Form->input('terms_and_conditions',
                        array('type'=>'checkbox',
                            // 'between' => '<i class="fa fa-file-text-o"></i>',
                            // 'hiddenField' => false,
                            'label' => __("By checking this box, I agree to the Guest Refund Policy Terms and Terms of Service"),
                            'escape'=>false, 
                            'div'=>false, 
                            'required'=>'required', 
                            'message'  => __('You  must agree to terms and conditions in order to proceed.'), 
                            'value'=>true
                        )
                    ); 
                    ?>
                    </div>
                </div>

                <?php

                echo $this->Form->input('reservation_id', array('type'=>'hidden', 'value' => $reservation_id));

                echo $this->Form->input('checkin', array('type'=>'hidden', 'value' => $reservation['Reservation']['checkin']));

                echo $this->Form->input('checkout', array('type'=>'hidden', 'value' => $reservation['Reservation']['checkout']));

                ?>

                <button type="submit" style="margin-top:10px;" class="accept_button btn btn-success">
                    <?php echo __("Accept"); ?>
                </button>
            <?php echo $this->Form->end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="declineReservationModal" class="modal fade" tabindex="-1" role="dialog"  aria-labelledby="declineReservationModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="ico-info"></i>&nbsp;<?php echo __("Decline this request"); ?></h4>
            </div>
            <div class="modal-body">
            <?php echo $this->Form->create('Reservation', array('url' => array('controller' => 'reservations', 'action' => 'decline', $reservation['Reservation']['id']), 'class'=>'form-horizontal text-left', 'onsubmit'=>"javascript:event.preventDefault(), req_action('accept', this, event);")); ?>
            
            <?php echo $this->Html->tag('p', __('Help us improve your experience. What\'s the main reason for declining this inquiry?')); ?>

                <?php
                    $options = [
                        [
                            'name' => __('These dates are not available. Block this dates on my calendar.'),
                            'value' => 'These dates are not available. Block this dates on my calendar.'
                        ],
                        [
                            'name' => __('I did not feel comfortable with this client.'),
                            'value' => 'I did not feel comfortable with this client.'
                        ],
                        [
                            'name'=>__('My listing is not a good fit for the guest\'s needs'),
                            'value'=>'My listing is not a good fit for the guest\'s needs'
                        ],
                        [
                            'name'=>__('I am waiting for more attractive reservation'),
                            'value'=>'I am waiting for more attractive reservation'
                        ],
                        [
                            'name'=>__('The guests is asking for different dates than the ones selected in this request'),
                            'value'=>'The guests is asking for different dates than the ones selected in this request'
                        ],
                        [
                            'name'=>__('This message is spam'),
                            'value'=>'This message is spam'
                        ],
                        [
                            'name'=>__('Other'),
                            'value'=>'Other'
                        ]
                    ];
                    echo $this->Form->radio('message', $options, [
                        'legend' => '',
                        'fieldset' => 'fieldset',
                        'separator' => '<br>',
                        'between' => '&nbsp;==&nbsp;',
                        // 'hiddenField' => false,
                        'label' => '-------',
                        'class' => 'decline_comment',
                    ]);


                echo $this->Form->input('reservation_id', array('type'=>'hidden', 'value' => $reservation_id));
                echo $this->Form->input('checkin', array('type'=>'hidden', 'value' => $reservation['Reservation']['checkin']));
                echo $this->Form->input('checkout', array('type'=>'hidden', 'value' => $reservation['Reservation']['checkout']));

                ?>
                <p>
                <?php

                echo $this->Form->textarea('message', array('rows'=>5, 'id' => 'optional_comment', 'class' => 'col-md-12 col-sm-12 col-xs-12' ,'placeholder' => __('Type an optional message to guest...')));
                ?>
                </p>

                <br>
                <button type="submit" style="margin-top:10px;" class="decline_button btn btn-danger">
                    <?php echo __("Decline"); ?>
                </button>
            <?php echo $this->Form->end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo __('Close'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php endif ?>

<script>
    function print_confirmation() {
        var myElement = document.getElementById("reservation_form").innerHTML;
        var myWindow;
        myWindow=window.open('','_blank','width=800,height=500');
        myWindow.document.write(myElement);
        myWindow.print();
    }

    function req_action(action, obj, event) {

        var $form = $(obj);
        if (action == "accept") {
            var comment  = $("#comment").val();
            var $modal = $('#allowReservationModal');

            if(/\b(\w)+\@(\w)+\.(\w)+\b/g.test(comment)) {
                alert('Sorry! Email or Phone number is not allowed');
                return false;
            } else if(comment.match('@') || comment.match('hotmail') || comment.match('gmail') || comment.match('yahoo')) {
                alert('Sorry! Email or Phone number is not allowed');
                return false;
            }

            if(/\+?[0-9() -]{7,18}/.test(comment)) {
                alert('Sorry! Email or Phone number is not allowed');
                return false;
            }
        } else {
            var $modal = $('#declineReservationModal');
        }

        var reservation_id = $("#reservation_id").val();

        var ok = confirm("Are you sure to " + action + " this reservation?");
        if(!ok) {
            return false;
        }

        $form.find('[type="submit"]').prop("disabled", true);
        if ($form.data('submitted') === true) {
            // Previously submitted - don't submit again
            event.preventDefault();
        } else {
            // Mark it so that the next submit can be ignored
            $form.data('submitted', true);
        }

        $.ajax({
            type: "POST",
            url: fullBaseUrl + '/reservations/' + action + '/' + reservation_id,
            async: true,
            data: $form.serialize(),
            success: function(data, textStatus, xhr) {
                $modal.modal('hide');
                if (textStatus == 'success') {
                    // window.location.href = fullBaseUrl + '/reservations/view/'+reservation_id;
                    location.reload(true);
                } else {
                    toastr.warning(textStatus,'Warning!');
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                //called when there is an error
                toastr.error(errorThrown, 'Error!');
            }
        });
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
                    // return false;
                });
            });
        })(jQuery);
    ", array('block' => 'scriptBottom'));
?>