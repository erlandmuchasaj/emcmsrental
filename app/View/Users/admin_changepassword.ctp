<section class="panel">
    <header class="panel-heading"><?php echo $this->Html->tag('h3', __('Change password'))?></header>
    <div class="panel-body">
        <div class="position-center">
        	<?php 
				echo $this->Form->create('User',array('class'=>'form-horizontal','role'=>'form')); 
				echo $this->Form->input('id');
        	?>

            <div class="form-group">
                <label class="col-sm-12"><?php echo __('Password');?></label>
                <div class="col-sm-12">
                    <?php echo $this->Form->input('current_password', array('type'=>'password','label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Current password'))); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-12"><?php echo __('New password');?></label>
                <div class="col-sm-12">
                    <?php echo $this->Form->input('new_password', array('type'=>'password','label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('New password'), 'data-maxlength'=>'25')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-12"><?php echo __('Confirm password');?></label>
                <div class="col-sm-12">
                    <?php echo $this->Form->input('confirm_new_password', array('type'=>'password','label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Confirm password'), 'data-maxlength'=>'25')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
                </div>
            </div> 
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</section>
