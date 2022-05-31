<div class="panel panel-em">
    <header class="panel-heading">
        <?php echo __('Add Currency'); ?>
    </header>
    <div class="panel-body">
        <?php echo $this->Form->create('Currency', array('class'=>'form-horizontal','role'=>'form')); ?>
        <div class="form-group">
            <?php 
                echo $this->Form->input('code', array(
                    'type' => 'select',
                    'options' => $availableCurrencies,
                    'empty'=>__('Select Currency'),
                    'class'=> 'form-control',
                    'div'=> [
                        'class' => 'col-md-6 col-md-offset-2',
                    ],
                    'label' => __('Currency')
                )); 
            ?>
        </div>


        <div class="form-group">
        	<label class="col-md-2 control-label"><?php echo __('Status');?></label>
        	<div class="col-md-6 ">
        		<?php echo $this->Form->input('status', array('label'=>false, 'div'=>false,'class'=>'bootstrap-switch')); ?>
        	</div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-6">
            	<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-default')); ?>

                <?php echo $this->Form->input(__('Submit'),array('type'=>'button','label'=>false,'div'=>false,'class'=>'btn btn-success pull-right')); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>