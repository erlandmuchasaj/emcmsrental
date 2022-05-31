<div class="panel panel-em">
    <header class="panel-heading"> <?php echo __('Add Language'); ?> </header>
    <div class="panel-body">
    <?php echo $this->Form->create('Language', array('class'=>'form-horizontal')); ?>
        <div class="form-group">
            <?php 
            	echo $this->Form->input('language_code', array(
            		'type' => 'select',
            		'options' => $availableLanguages,
            		'empty'=>__('Select Language'),
            		'class'=> 'form-control',
            		'div'=> [
            			'class' => 'col-md-6 col-md-offset-2',
            		],
            		'label' => __('Language')
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
        	<label class="col-md-2 control-label"><?php echo __('is RTL');?></label>
        	<div class="col-md-6 ">
        		<?php echo $this->Form->input('is_rtl', array('label'=>false, 'div'=>false,'class'=>'bootstrap-switch')); ?>
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
