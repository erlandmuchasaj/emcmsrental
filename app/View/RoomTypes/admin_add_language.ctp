<div class="row">
    <div class="col-lg-12">
        <section class="panel panel-em">
            <header class="panel-heading">
               <?php echo __('Add Room Type Translation');  ?>
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <?php echo $this->Form->create('RoomType', array('class'=>'form-inline','role'=>'form'));  ?>
                    <div class="form-group">
                        <label class="sr-only" for="room_type_id"><?php echo __('Room Type');?></label>
                        <?php echo $this->Form->input('room_type_id', array('class'=>'form-control', 'id'=>'room_type_id','label'=>false,'div'=>false)); ?>
                    </div>                    
                    <div class="form-group">
                        <label class="sr-only" for="translate_language_id"><?php echo __('Language');?></label>
                        <?php echo $this->Form->input('language_id', array('class'=>'form-control', 'id'=>'translate_language_id','label'=>false,'div'=>false)); ?>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="room_type_name"><?php echo __('Room Type Name Name');?></label>
                        <?php echo $this->Form->input('room_type_name', array('class'=>'form-control', 'id'=>'room_type_name','label'=>false,'div'=>false)); ?>
                    </div>
                    <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-success','label'=>false,'div'=>false)); ?>
                <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </section>
    </div>
</div>
