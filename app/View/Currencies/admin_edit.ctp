<div class="panel panel-em">
	<header class="panel-heading">
	    <?php echo __('Edit Currency'); ?>
	</header>
	<div class="panel-body">
	    <?php echo $this->Form->create('Currency', array('class'=>'form-horizontal','role'=>'form')); ?>
	    <?php echo $this->Form->input('id'); ?>

        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo __('Code'); ?></label>
            <div class="col-md-6">
                <?php echo $this->Form->input('code', array('placeholder'=>__('Code'),'class'=>'form-control','div'=>false,'label'=>false, 'disabled' => true)); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo __('Name'); ?></label>
            <div class="col-md-6">
                <?php echo $this->Form->input('name', array('placeholder'=>__('Name'),'class'=>'form-control','div'=>false,'label'=>false)); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo __('Symbol'); ?></label>
            <div class="col-md-6">
                <?php echo $this->Form->input('symbol',array('placeholder'=>__('Symbol'),'class'=>'form-control limit-characters-1','div'=>false,'label'=>false)); ?>
                <span class="help-block counter pull-right character-counter-1"></span>
            </div>
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