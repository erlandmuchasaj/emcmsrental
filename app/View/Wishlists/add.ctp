<?php
echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
?>
<div class="em-container make-top-spacing">
    <div class="row">
        <div class="col-lg-3 col-md-4 user-sidebar">
            <?php echo $this->element('Frontend/user_sidebar'); ?>
        </div>
        <div class="col-lg-9 col-md-8">
            <section class="panel panel-em no-border">
                <header class="panel-heading">
                	<?php echo $this->Html->tag('h4', __('New Wishlist'))?>
                </header>
                <div class="panel-body">
					<?php echo $this->Form->create('Wishlist',array('class'=>'form-horizontal','role'=>'form')); ?>
					<div class="form-group">
					    <label class="col-sm-3 control-label"><?php echo __('Name');?></label>
					    <div class="col-sm-6">
					        <?php echo $this->Form->input('name', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
					    </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo __('Status');?></label>
						<div class="col-sm-6">
							<?php echo $this->Form->input('status', array('label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>
							<span class="help-block"><?php echo __('Set yes if you want this wishlist to be visible. ');?></span>
						</div>
					</div>
					
					<div class="form-group">
					    <div class="col-sm-6 col-sm-offset-3">
					        <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
					        <?php echo $this->Html->link(__('Cancel'),array('controller' => 'wishlists', 'action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
					    </div>
					</div> 
					<?php echo $this->Form->end(); ?>
                </div>
            </section>
        </div>
    </div>
</div>

