<?php 
    $options = array(
        'flat'=>__('Flat'), 
        'percentage'=>__('Percentage')
    );
?>
<div class="panel panel-em" id="elementToMask">
    <header class="panel-heading">
        <h4><?php echo __('Site Fees'); ?></h4>
    </header>
    <div class="panel-body">
        <div class="form">
        <?php
            echo $this->Form->create('SiteSetting',array('type' => 'post', 'url'  => array('admin'=>true,'controller' => 'site_settings','action' => 'save'), 'id'=>'SettingSaveForm', 'class'=>'form-horizontal'));
            echo $this->Form->input('key');
            ?>

            <div class="form-group ">
                <div class="col-sm-6 col-md-4 col-md-offset-2">
                     <label class="control-label"><?php echo __('General Fee amount'); ?></label>
                    <?php echo $this->Form->input('general_fee',array('class'=>'form-control','label'=>false,'div'=>false)); ?>
                </div>
               
                <div class="col-sm-6 col-md-4">
                     <label class="control-label"><?php echo __('General Fee Type'); ?></label>
                     <?php echo $this->Form->input('general_fee_type',array('label'=>false, 'div'=>false,'class'=>'form-control property-select','type'=>'select','options' =>$options)); ?>
                </div>
            </div>

            <?php if (false): ?>
            <hr class="fee-seperator-line" />
            <div class="form-group ">
                <div class="col-sm-6 col-md-4 col-md-offset-2">
                    <label class="control-label"><?php echo __('Reservation fee amount'); ?></label>
                    <?php echo $this->Form->input('reservation_fee',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
                </div>
                <div class="col-sm-6 col-md-4">
                    <label class="control-label"><?php echo __('Reservation Fee Type'); ?></label>
                    <?php echo $this->Form->input('reservation_fee_type',array('label'=>false, 'div'=>false,'class'=>'form-control property-select','type'=>'select','options' =>$options)); ?>
                </div>
            </div>

            <hr class="fee-seperator-line" />
            <div class="form-group">
                <div class="col-sm-6 col-md-4 col-md-offset-2">
                    <label  class="control-label"><?php echo __('Sale fee amount'); ?></label>
                    <?php echo $this->Form->input('sale_fee',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
                </div>

                <div class="col-sm-6 col-md-4">
                    <label  class="control-label"><?php echo __('Sale Fee Type'); ?></label>
                    <?php echo $this->Form->input('sale_fee_type',array('label'=>false, 'div'=>false,'class'=>'form-control property-select','type'=>'select','options' =>$options)); ?>
                </div>                        
            </div>  

            <hr class="fee-seperator-line" />
            <div class="form-group ">
                <div class="col-sm-6 col-md-4 col-md-offset-2">
                    <label  class="control-label"><?php echo __('Refundable fee amount'); ?></label>
                    <?php echo $this->Form->input('refundable_fee',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
               </div>
                <div class="col-sm-6 col-md-4">
                    <label  class="control-label"><?php echo __('Refundable Fee Type'); ?></label>
                    <?php echo $this->Form->input('refundable_fee_type',array('label'=>false, 'div'=>false,'class'=>'form-control property-select','type'=>'select','options' =>$options)); ?>
                </div>
            </div> 

            <hr class="fee-seperator-line" />
            <div class="form-group ">
                <div class="col-sm-6 col-md-4 col-md-offset-2">
                    <label  class="control-label"><?php echo __('The maximum limit of days'); ?></label>
                    <?php echo $this->Form->input('nr_of_days_max',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
               </div>

                <div class="col-sm-6 col-md-4">
                    <label  class="control-label"><?php echo __('The minimum limit of days '); ?></label>
                    <?php echo $this->Form->input('nr_of_days_min',array('label'=>false, 'div'=>false,'class'=>'form-control allow-only-numbers')); ?>
                </div>
            </div> 
            <?php endif ?>

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