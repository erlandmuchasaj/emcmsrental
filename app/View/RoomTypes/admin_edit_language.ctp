<article class="panel panel-em">
    <header class="panel-heading">
        <h4><?php echo __('Edit Room Type - %s', h($language['Language']['name'])); ?></h4>
    </header>
    <div class="panel-body">
        <div class="position-center">
            <?php 
            	echo $this->Form->create('RoomType', array('class'=>'form-inline','role'=>'form')); 
            	echo $this->Form->input('id');
                echo $this->Form->input('language_id', ['type' => 'hidden']);
                echo $this->Form->input('room_type_id', ['type' => 'hidden']);
            ?>
                <div class="form-group">
                    <label class="sr-only" for="room_type_name"><?php echo __('Room Name');?></label>
                    <?php 
                        echo $this->Form->input('room_type_name', array(
                            'class' => 'form-control count-char', 
                            'id' => 'room_type_name',
                            'label' => false,
                            'div' => false,
                            'placeholder' => __('Room type name'),
                            'data-minlength' => '0',
                            'data-maxlength' => '90'
                        )); 
                    ?>
                </div>
                <?php echo $this->Form->submit(__('Update'), array('class'=>'btn btn-success','label'=>false,'div'=>false)); ?>
                <?php echo $this->Html->link(__('Cancel'),array('action' => 'view', $this->Form->value('id')),array('escape' => false, 'class'=>'btn btn-danger')); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</article>