<div class="panel panel-em" id="elementToMask">
    <header class="panel-heading">
        <h4><?php echo __('Basic Services element'); ?></h4>
    </header>
    <div class="panel-body">
        <div class="form">
        <?php
            echo $this->Form->create('SiteSetting',array('url'  => array('admin'=>true,'controller' => 'site_settings','action' => 'save'), 'id'=>'SettingSaveForm', 'class'=>'form-horizontal'));
            echo $this->Form->input('key');
            ?>

            <div class="form-group">
            	<label class="col-sm-2 control-label" for="support_title"><?php echo __('Support Time'); ?></label>
            	<div class="col-sm-8">
            		<?php echo $this->Form->input('support_title', array('class'=>'form-control count-char', 'id'=>'support_title', 'label'=>false, 'maxlength'=>'60', 'data-maxlength'=>'60', 'div'=>false)); ?>
            	</div>
            </div>

            <div class="form-group">
            	<label class="col-sm-2 control-label" for="support_description"><?php echo __('Support Description'); ?></label>
            	<div class="col-sm-8">
            		<?php echo $this->Form->input('support_description', array('class'=>'form-control count-char', 'id'=>'support_description', 'label'=>false, 'maxlength'=>'160', 'data-maxlength'=>'160', 'div'=>false)); ?>
            	</div>
            </div>

            <hr class="fee-seperator-line" />

            <div class="form-group">
            	<label class="col-sm-2 control-label" for="guarantee_title"><?php echo __('Gurantee Title'); ?></label>
            	<div class="col-sm-8">
            		<?php echo $this->Form->input('guarantee_title', array('class'=>'form-control count-char', 'id'=>'guarantee_title', 'label'=>false, 'maxlength'=>'60', 'data-maxlength'=>'60', 'div'=>false)); ?>
            	</div>
            </div>

            <div class="form-group">
            	<label class="col-sm-2 control-label" for="guarantee_description"><?php echo __('Gurantee Description'); ?></label>
            	<div class="col-sm-8">
            		<?php echo $this->Form->input('guarantee_description', array('class'=>'form-control count-char', 'id'=>'guarantee_description', 'label'=>false, 'maxlength'=>'160', 'data-maxlength'=>'160', 'div'=>false)); ?>
            	</div>
            </div>


            <hr class="fee-seperator-line" />

            <div class="form-group">
            	<label class="col-sm-2 control-label" for="verify_title"><?php echo __('Verify Title'); ?></label>
            	<div class="col-sm-8">
            		<?php echo $this->Form->input('verify_title', array('class'=>'form-control count-char', 'id'=>'verify_title', 'label'=>false, 'maxlength'=>'60', 'data-maxlength'=>'60', 'div'=>false)); ?>
            	</div>
            </div>

            <div class="form-group">
            	<label class="col-sm-2 control-label" for="verify_description"><?php echo __('Verify Description'); ?></label>
            	<div class="col-sm-8">
            		<?php echo $this->Form->input('verify_description', array('class'=>'form-control count-char', 'id'=>'verify_description', 'label'=>false, 'maxlength'=>'160', 'data-maxlength'=>'160', 'div'=>false)); ?>
            	</div>
            </div>


            <hr class="fee-seperator-line" />

            <!-- 
            <div class="form-group">
                <label class="col-sm-2 control-label" for="travel"><?php // echo __('Travel'); ?></label>
                <div class="col-sm-8">
                    <?php // echo $this->Form->input('travel', array('class'=>'form-control count-char', 'id'=>'travel', 'label'=>false, 'maxlength'=>'120', 'data-maxlength'=>'120', 'div'=>false)); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label" for="host"><?php // echo __('Host'); ?></label>
                <div class="col-sm-8">
                    <?php // echo $this->Form->input('host', array('class'=>'form-control count-char', 'id'=>'host', 'label'=>false, 'maxlength'=>'120', 'data-maxlength'=>'120', 'div'=>false)); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label" for="how_it_works"><?php // echo __('How it works'); ?></label>
                <div class="col-sm-8">
                    <?php // echo $this->Form->input('how_it_works', array('class'=>'form-control count-char', 'id'=>'how_it_works', 'label'=>false, 'maxlength'=>'120', 'data-maxlength'=>'120', 'div'=>false)); ?>
                </div>
            </div>
            -->

            <div class="form-group">
                <div class="col-sm-6 col-md-4 col-md-offset-2">
                    <button type="button" class="btn btn-success btn-sm" onclick="save_setting();"><i class=" fa fa-check"></i>&nbsp;<?php echo __('Save changes'); ?></button>
                    <div class="btn-group">
                        <?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-close')). '&nbsp;' .__('Cancel'),array('controller' => 'properties', 'action' => 'index'),array('escape' => false,'class'=>'btn btn-danger  btn-sm')); ?>
                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

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
                        toastr.success(response.message,'Success!');
                    } else {
                        toastr.error(response.message,'Error!');
                    }
                } else {
                    toastr.warning(textStatus,'Warning!');
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