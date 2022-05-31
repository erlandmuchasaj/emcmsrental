<?php
echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
?>
<div class="em-container make-top-spacing">
    <div class="row">
        <div class="col-lg-3 col-md-4 user-sidebar">
            <div class="user-box">
                <div class="_pm_container">
                    <?php
                        echo $this->Html->link($this->Html->displayUserAvatar(AuthComponent::user('image_path')),array('controller' => 'users', 'action' => 'view', AuthComponent::user('id')), array('escape' => false, 'class'=>'user-box-avatar')); 
                    ?>
                </div>
                <?php echo $this->Html->tag('h2', h(AuthComponent::user('name').' '.AuthComponent::user('surname')),array('class' => 'user-box-name')) ?>
            </div>

            <div class="quick-links">
                <h3 class="quick-links-header"><?php echo __('Quick Links'); ?></h3>
                <ul class="quick-links-list">
                    <li>
                        <a href="<?php echo $this->Html->url(['controller' => 'users', 'action' => 'changepassword', AuthComponent::user('id')], true ); ?>">
                            <?php echo __('Change password'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Html->url(['controller' => 'properties', 'action' => 'listings'], true ); ?>">
                            <?php echo __('View/Manage Listing'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Html->url(['controller' => 'reservations', 'action' => 'my_reservations'], true ); ?>">
                            <?php echo __('Reservations'); ?>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo $this->Html->url(['controller' => 'reviews', 'action' => 'index'], true ); ?>">
                            <?php echo __('Reviews'); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9 col-md-8">
            <section class="panel panel-em no-border">
                <header class="panel-heading"><?php echo $this->Html->tag('h4', __('Change password'))?></header>
                <div class="panel-body">
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
                        <?php echo $this->Html->link(__('Cancel'),array('controller' => 'users', 'action' => 'dashboard'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
                    </div>
                </div> 
                <?php echo $this->Form->end(); ?>
                </div>
            </section>
        </div>
    </div>
</div>
