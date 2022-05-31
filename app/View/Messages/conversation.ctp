<?php
    /*This css is applied only to this page*/        
    echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
?>
<?php //debug($this->request->data); ?>
<div class="em-container make-top-spacing">
    <div class="row" id="elementToMask">
        <div class="col-lg-3 col-md-4 user-sidebar">
            <?php echo $this->element('Frontend/user_sidebar'); ?>
        </div>
    	<div class="col-lg-9 col-md-8">
    		<!--chat start-->
    		<div class="panel panel-warning">
    			<header class="panel-heading">
    				<?php echo __('Conversation with %s.', ucfirst($data['User']['name'])); ?> 
    			</header>
				<ul id="conversation" class="conversation-list">
                <?php 
                if(isset($messages) && !empty($messages)){ 
                    foreach ($messages as $message){
                    	if ($message['Message']['user_by'] == AuthComponent::user('id')) { ?>
                    	<li class="clearfix odd">
                    		<div class="chat-avatar">
                                <?php 
                                    echo $this->Html->link(
                                        $this->Html->displayUserAvatar($message['UserBy']['image_path'], 
                                        ["height"=>"50", "width"=>"50", 'size'=>'small', 'class'=>'img-responsive']), 
                                        ['controller' => 'users', 'action' => 'view', $message['UserBy']['id']],
                                        ['escape' => false]
                                    ); 
                                ?>
                    			<i><?php echo $this->Time->niceShort($message['Message']['created']); ?></i>
                                <!-- <p><?php echo __("You"); ?></p> -->
                    		</div>
                    		<div class="conversation-text">                  		
                                <?php if ($message['Message']['message_type'] !== 'message') { ?>
                                    <div class="col-md-12 well">
                                    <?php 
                                    if (!isset($message['Property']['id'])) {
                                        echo __('List Deletion');
                                    } else {
                                        echo Inflector::humanize($message['Message']['message_type']); 
                                    }

                                    if (isset($message['Property']['id'])) {
                                        echo $this->Html->link(
                                            __('About %s.', $message['Property']['PropertyTranslation']['title']), 
                                            ['controller' => 'properties', 'action' => 'view', $message['Property']['id']],
                                            ['escape' => false]
                                        ); 
                                    }
                                    if($message['Message']['message_type'] !== 'inquiry') { ?>
                                        <label>
                                        <?php 
                                        echo $message['Reservation']['checkin'].' - '. $message['Reservation']['checkout'];
                                        ?>
                                        </label>
                                        <br>
                                        <label>
                                        <?php echo $message['Reservation']['guests'].' '. __("guest"); ?>
                                        </label>
                                    <?php } ?>
                                    <span class="clsTypeConver_Arow1"></span>
                                    </div>
                                <?php } ?>

                                <?php if ($message['Message']['message_type'] === 'message') { ?>
                                <div class="ctext-wrap">
                                    <i><?php echo h($message['UserBy']['name']); ?></i>
                                    <p><?php echo h($message['Message']['message']); ?></p>
                                </div>
                                <?php } else { ?>
                                <div class="ctext-wrap">
                                    <p><?php echo h($message['Message']['message']); ?></p>
                                </div>
                                <?php } ?>
                            </div>
                        </li>
                    	<?php } elseif ($message['Message']['user_to'] == AuthComponent::user('id')) { ?>
                    	<li class="clearfix">
                    		<div class="chat-avatar">
                                <?php 
                                    echo $this->Html->link(
                                        $this->Html->displayUserAvatar($message['UserBy']['image_path'], 
                                        ["height"=>"50", "width"=>"50", 'size'=>'small', 'class'=>'img-responsive']), 
                                        ['controller' => 'users', 'action' => 'view', $message['UserBy']['id']],
                                        ['escape' => false]
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
                    	</li>
                    	<?php }
                    }
                }
                ?>
				</ul>
    			
                <div class="panel-footer">
                <?php 
                    //echo $this->Form->create('Message', array('url' => array('controller' => 'messages','action' => 'sendNewMessage', ), 'id'=>'messsage_form'));
                    echo $this->Form->create('Message', array('url' => array('controller' => 'messages', 'action' => 'conversation', $data['conversation_id']), 'id'=>'messsage_form'));
                    echo $this->Form->input('property_id',array('type'=>'hidden', 'value'=>$data['property_id']));
                    echo $this->Form->input('reservation_id',array('type'=>'hidden', 'value'=>$data['reservation_id']));
                    echo $this->Form->input('contact_id',array('type'=>'hidden', 'value'=>$data['contact_id']));
                    echo $this->Form->input('user_to',array('type'=>'hidden', 'value'=>$data['User']['id']));
                    echo $this->Form->input('user_by',array('type'=>'hidden', 'value'=>AuthComponent::user('id')));
                ?> 
                <div class="input-group">
                    <?php
                        echo $this->Form->input('message',array('type'=>'text','class'=>'form-control chat-input', 'label'=>false, 'div'=>false, 'placeholder'=>__('Enter your message here')));
                    ?>
                    <span class="input-group-btn">
                        <?php 
                            echo $this->Form->input(__('Send'),array('type'=>'submit','class'=>'btn btn-default', 'id'=>'sendMessage','label'=>false,'div'=>false));
                        ?>
                    </span>
                </div>
                <?php echo $this->Form->end(); ?>
                </div>
    		</div>
    	</div>
    </div>
</div>
<?php
$this->Html->scriptBlock("
(function ($) {
    'use strict';
    $(document).ready(function () {
        $(function () {
            var objDiv = document.getElementById('conversation');
            objDiv.scrollTop = objDiv.scrollHeight;

            var elementToMask = $('#elementToMask');
            $('#sendMessage').on('click',function (e) {
                e.preventDefault();
                e.stopPropagation();

                var message = $('.chat-input').val();
                if(/\b(\w)+\@(\w)+\.(\w)+\b/g.test(message)) {
                    alert('Sorry! Email or Phone number is not allowed');
                    return false;
                } else if(message.match('@') || message.match('hotmail') || message.match('gmail') || message.match('yahoo')) {
                    alert('Sorry! Email or Phone number is not allowed');
                    return false;
                }
                if(/\+?[0-9() -]{7,18}/.test(message)) {
                    alert('Sorry! Email or Phone number is not allowed');
                    return false;
                }


                $.ajax({
                    url:fullBaseUrl+'/messages/sendNewMessage',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#messsage_form').serialize(),
                    beforeSend: function() {
                        // called before response
                        elementToMask.mask('Waiting...');
                    },
                    success: function(data, textStatus, xhr) {
                        //called when successful
                        if (textStatus =='success') {
                            var response = $.parseJSON(JSON.stringify(data));
                            if (!response.error) {
                                toastr.success(response.message,'Success!');
                                window.location.reload();
                            } else {
                                toastr.error(response.message,'Error!');
                            }
                        } else {
                            toastr.warning(textStatus,'Warning!');
                        }
                    },
                    complete: function(xhr, textStatus) {
                        //called when complete
                        elementToMask.unmask();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        //called when there is an error
                        elementToMask.unmask();
                        toastr.error(errorThrown, 'Error!');
                    }
                });
                return true;
            });
        });
    });
})(jQuery);
", array('block' => 'scriptBottom'));
?>