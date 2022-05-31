<article class="panel panel-em">
    <header class="panel-heading">
         <h4><?php echo __('Add Accommodation Type Translation');  ?></h4>
    </header>
    <div class="panel-body">
        <div class="position-center">
            <?php echo $this->Form->create('AccommodationType', array('class'=>'form-inline','role'=>'form'));  ?>
            <div class="form-group">
                <label class="sr-only" for="accommodation_type_id"><?php echo __('Accommodation Type');?></label>
                <?php echo $this->Form->input('accommodation_type_id', array('class'=>'form-control', 'id'=>'accommodation_type_id','label'=>false,'div'=>false)); ?>
            </div>
            <div class="form-group">
                <label class="sr-only" for="translate_language_id"><?php echo __('Language');?></label>
                <?php echo $this->Form->input('language_id', array('class'=>'form-control', 'id'=>'translate_language_id','label'=>false,'div'=>false)); ?>
            </div>
            <div class="form-group">
                <label class="sr-only" for="accommodation_type_name"><?php echo __('Accommodation type name');?></label>
                <?php echo $this->Form->input('accommodation_type_name', array('class'=>'form-control', 'id'=>'accommodation_type_name','label'=>false,'div'=>false)); ?>
            </div>
            <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-success','label'=>false,'div'=>false)); ?>
        <?php echo $this->Form->end(); ?>
        </div>
    </div>
</article>
