<div class="row">
    <div class="col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-red">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Warning!</span>
              <span class="info-box-number">This Feature is still in development and will be comming soon.</span>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default" id="elementToMask">
    <header class="panel-heading">
        <?php echo __('Credit Card Data');?>
    </header>
    <div class="panel-body">
        <?php 
            echo $this->Form->create('SiteSetting',array('type' => 'post', 'url' => array('admin'=>true,'controller' => 'site_settings','action' => 'save'), 'id'=>'SettingSaveForm', 'class'=>'form-horizontal'));
            echo $this->Form->input('key');
        ?>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-8">
                    <div class="input-group input-group m-bot15">
                        <span class="input-group-addon"><?php echo __('CC Type');?></span>
                        <?php echo $this->Form->input('credit_card_type', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'CC Type')); ?>
                    </div>

                    <div class="input-group input-group m-bot15">
                        <span class="input-group-addon"><?php echo __('CC Number');?></span>
                        <?php echo $this->Form->input('credit_card_number',array('id'=>'cc_number', 'label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'CC Number')); ?>
                    </div>

                    <div class="input-group input-group m-bot15">
                        <span class="input-group-addon"><?php echo __('CC Expire');?></span>
                        <?php echo $this->Form->input('credit_card_expire', array('type'=>'text' , 'id'=>'cc_expire' ,'label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'CC Expire')); ?>
                    </div>

                    <div class="input-group input-group m-bot15">
                        <span class="input-group-addon"><?php echo __('CC Security Code');?></span>
                        <?php echo $this->Form->input('credit_card_security_code', array('type'=>'text','id'=>'cc_security' ,'label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'CC Security Code')); ?>
                    </div>

                    <div class="input-group input-group m-bot15">
                        <span class="input-group-addon"><?php echo __('CC Holder');?></span>
                        <?php echo $this->Form->input('credit_card_holder', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'CC Holder')); ?>
                    </div>     
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="button" class="btn btn-success btn-sm" onclick="save_setting();"><i class=" fa fa-check"></i>&nbsp;<?php echo __('Save changes'); ?></button>
                </div>
            </div> 
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<?php
$this->Html->scriptBlock("
    (function($){
        $(document).ready(function() {
            'use strict';
        });
    })(jQuery);
", array('block' => 'scriptBottom'));
?>


<script>
    function save_setting(){
        var $elementToMask = $("#elementToMask");
        $.ajax({
            url: $('#SettingSaveForm').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $('#SettingSaveForm').serialize(),
            beforeSend: function() {
                // called before response
                $elementToMask.mask('Waiting...');
            },
            success: function(data, textStatus, xhr) {
                //called when successful
                if (textStatus =='success') {
                    var response = $.parseJSON(JSON.stringify(data));
                    if (!response.error) {
                        toastr.success(response.message,'<?php echo __('Success!'); ?>');
                    } else {
                        toastr.error(response.message,'<?php echo __('Error!'); ?>');
                    }
                } else {
                    toastr.warning(textStatus,'<?php echo __('Warning!'); ?>');
                }
                $elementToMask.unmask();
            },
            complete: function(xhr, textStatus) {
                //called when complete
                $elementToMask.unmask();
            },
            error: function(xhr, textStatus, errorThrown) {
                //called when there is an error
                $elementToMask.unmask();
                toastr.error(errorThrown, 'Error!');
            }
        });
        return true;
    }
</script>