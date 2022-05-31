<?php // echo $this->Html->css('bootstrap-switch', null, array('block'=>'cssMiddle')); ?>
	<div class="row">
	    <div class="col-md-12">
	        <div class="panel panel-em">
	            <header class="panel-heading">
	               <?php  echo __('Add'); ?>
	            </header>
	            <div class="panel-body">
                	<?php echo $this->Form->create('Faq',array('class'=>'form-horizontal')); ?>
		                <div class="form-group">
		                    <label class="col-md-2 control-label"><?php echo __('Question');?></label>
		                    <div class="col-md-6">
		                        <?php echo $this->Form->input('question', array('label'=>false, 'div'=>false,'hiddenField'=>false ,'class'=>'form-control count-char','placeholder'=>'question', 'data-minlength'=>'0', 'data-maxlength'=>'255')); ?>
		                        <span class="help-block"><?php echo __('Be specific on your question.');?></span>
		                    </div>
		                </div>

						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo __('Status');?></label>
							<div class="col-md-6 ">
								<?php echo $this->Form->input('status', array('label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>
								<span class="help-block"><?php echo __('Status of the question.');?></span>
							</div>
						</div>

		                <div class="form-group">
		                    <label class="col-md-2 control-label"><?php echo __('Answer');?></label>
		                    <div class="col-md-6">
		                        <?php echo $this->Form->input('answer', array('label'=>false, 'div'=>false,'class'=>'form-control froala','escape'=>false)); ?>
		                        <span class="help-block"><?php echo __('Above you can answer the question. ');?></span>
		                    </div>
		                </div>

		                <div class="form-group">
		                    <div class="col-md-offset-2 col-md-6">
		                        <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
		                        <?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
		                    </div>
		                </div>
	                <?php echo $this->Form->end(); ?>
	            </div>
	        </div>
	    </div>
	</div>
<?php
	$this->Froala->editor('.froala', array('block'=>'scriptBottom'));
	$this->Html->scriptBlock("
		(function($){
			$(document).ready(function() {
				'use strict';
				// code goes below here
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>