<?php 
    $options = array(
        'fixed' => __('Fixed'), 
        'percentage' => __('Percentage'),
    );
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                <?php echo __('Edit Site Fees'); ?>
            </header>
            <div class="panel-body">
                <div class="form">
                    <?php
                        echo $this->Form->create('SiteSetting',array('type' => 'post', 'id'=>'siteFees','class'=>'cmxform form-horizontal'));  
                        echo $this->Form->input('id');
                    ?>

                    <div class="form-group ">
                        <div class="col-sm-6 col-md-4 col-lg-4 col-md-offset-2">
                             <label class="control-label"><?php echo __('General fee'); ?></label>
                            <?php echo $this->Form->input('general_fee',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
                            <span class="help-block onlyNumberErrorMessage" style="color: red; display: none; margin: -2px 0 -14px 0;"><?php echo __('* input digits (0 - 9)');?></span>
                        </div>
                       
                        <div class="col-sm-6 col-md-4 col-lg-4">
                             <label class="control-label"><?php echo __('General fee type'); ?></label>
                             <?php echo $this->Form->input('general_fee_type',array('label'=>false, 'div'=>false,'class'=>'form-control property-select','type'=>'select','options' =>$options)); ?>
                        </div>
                    </div>
                    <hr class="fee-seperator-line" />
                    
                    <div class="form-group ">
                        <div class="col-sm-6 col-md-4 col-lg-4 col-md-offset-2">
                            <label class="control-label"><?php echo __('Reservation fee'); ?></label>
                            <?php echo $this->Form->input('reservation_fee',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <label class="control-label"><?php echo __('Reservation fee type'); ?></label>
                            <?php echo $this->Form->input('reservation_fee_type',array('label'=>false, 'div'=>false,'class'=>'form-control property-select','type'=>'select','options' =>$options)); ?>
                            
                        </div>
                    </div>
                    <hr class="fee-seperator-line" />
                    <div class="form-group ">
                        <div class="col-sm-6 col-md-4 col-lg-4 col-md-offset-2">
                            <label  class="control-label"><?php echo __('Checkin fee'); ?></label>
                            <?php echo $this->Form->input('reservation_checkin_fee',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <label  class="control-label"><?php echo __('Checkin fee type'); ?></label>
                            <?php echo $this->Form->input('reservation_checkin_fee_type',array('label'=>false, 'div'=>false,'class'=>'form-control property-select','type'=>'select','options' =>$options)); ?>
                        </div>
                    </div>
                    <hr class="fee-seperator-line" />
                    <div class="form-group ">
                        <div class="col-sm-6 col-md-4 col-lg-4 col-md-offset-2">
                            <label  class="control-label"><?php echo __('Cleaning fee'); ?></label>
                            <?php echo $this->Form->input('reservation_checkin_cleaning_fee',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <label  class="control-label"><?php echo __('Cleaning fee type'); ?></label>
                            <?php echo $this->Form->input('reservation_checkin_cleaning_fee_type',array('label'=>false, 'div'=>false,'class'=>'form-control property-select','type'=>'select','options' =>$options)); ?>
                        </div>
                    </div>  
                    <hr class="fee-seperator-line" />
                    <div class="form-group">
                        <div class="col-sm-6 col-md-4 col-lg-4 col-md-offset-2">
                            <label  class="control-label"><?php echo __('Sale fee'); ?></label>
                            <?php echo $this->Form->input('sale_fee',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <label  class="control-label"><?php echo __('Sale fee type'); ?></label>
                            <?php echo $this->Form->input('sale_fee_type',array('label'=>false, 'div'=>false,'class'=>'form-control property-select','type'=>'select','options' =>$options)); ?>
                        </div>                        
                    </div>  
                    <hr class="fee-seperator-line" />
                    <div class="form-group ">
                        <div class="col-sm-6 col-md-4 col-lg-4 col-md-offset-2">
                            <label  class="control-label"><?php echo __('Refundable fee'); ?></label>
                            <?php echo $this->Form->input('refundable_fee',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
                       </div>

                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <label  class="control-label"><?php echo __('Refundable fee type'); ?></label>
                            <?php echo $this->Form->input('refundable_fee_type',array('label'=>false, 'div'=>false,'class'=>'form-control property-select','type'=>'select','options' =>$options)); ?>
                        </div>
                    </div> 


                    <hr class="fee-seperator-line" />
                    <div class="form-group ">
                        <div class="col-sm-6 col-md-4 col-lg-4 col-md-offset-2">
                            <label  class="control-label"><?php echo __('The maximum limit of days'); ?></label>
                            <?php echo $this->Form->input('nr_of_days_max',array('class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
                       </div>

                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <label  class="control-label"><?php echo __('The minimum limit of days'); ?></label>
                            <?php echo $this->Form->input('nr_of_days_min',array('label'=>false, 'div'=>false,'class'=>'form-control allow-only-numbers')); ?>
                        </div>
                    </div> 

                    <hr class="fee-seperator-line" />
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="row">
                                <div class="col-sm-4 ">
                                    <label  class="control-label"><?php echo __('Cancelation Fee (when is grater then the max limit)'); ?></label>
                                    <?php echo $this->Form->input('cancelation_fee_val_gt_max',array('type'=>'number', 'min'=>1, 'max'=>100,'class'=>'form-control allow-only-numbers','label'=>false,'div'=>false)); ?>
                               </div>

                                <div class="col-sm-4">
                                    <label  class="control-label"><?php echo __('Cancelation Fee (when is between the limits)'); ?></label>
                                    <?php echo $this->Form->input('cancelation_fee_val_bt',array('type'=>'number', 'min'=>1, 'max'=>100,'label'=>false, 'div'=>false,'class'=>'form-control allow-only-numbers')); ?>
                                </div>

                                <div class="col-sm-4 ">
                                    <label  class="control-label"><?php echo __('Cancelation Fee (when is less then the min limit)'); ?></label>
                                    <?php echo $this->Form->input('cancelation_fee_val_lt_min',array('type'=>'number', 'min'=>1, 'max'=>100,'label'=>false, 'div'=>false,'class'=>'form-control allow-only-numbers')); ?>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <span class="help-block"><?php //echo __('Values are taken in percentage (%).');?></span>

                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-6">
                            <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary','label'=>false,'div'=>false)); ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
