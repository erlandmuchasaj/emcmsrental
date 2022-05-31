<?php 
	echo $this->Form->create('SafetyTranslation', array('class'=>'form-inline')); 
	echo $this->Form->input('id');
?>
<article class="panel panel-em">
    <header class="panel-heading">
       <?php echo $this->Html->tag('h4', __('Edit Translation - %s', h($language['Language']['name'])), array('class'=>'box-title', 'style'=>'display: inline-block;'))?>
        <span class="tools pull-right">
            <?php
                echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-mail-reply')).'&nbsp;'.__('Return to Translation List'),array('admin'=>true, 'controller' => 'safeties', 'action' => 'view', $this->Form->value('safety_id')),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
            ?>
        </span>
    </header>
    <div class="panel-body">
        <div class="form-group">
            <label class="sr-only" for="safety_name"><?php echo __('Translation string');?></label>
            <?php 
                echo $this->Form->input('safety_name', array(
                    'class'=>'form-control count-char',
                    'id'=>'safety_name',
                    'label'=>false,
                    'div'=>false,
                    'placeholder'=>__('Name'),
                    'data-minlength'=>'0',
                    'data-maxlength'=>'80'
                ));
            ?>
        </div>
        <?php echo $this->Form->input('safety_id', array('type'=>'hidden')); ?>
        <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-success','label'=>false,'div'=>false)); ?>
        <?php echo $this->Html->link(__('Cancel'),array('admin'=>true, 'controller' => 'safeties','action' => 'view', $this->Form->value('safety_id')),array('escape' => false, 'class'=>'btn btn-danger')); ?>
    </div>
</article>
<?php echo $this->Form->end(); ?>