<?php echo $this->Html->css('common/jasny-bootstrap', null, array('block'=>'cssMiddle'));?>  
<!-- page start-->
<article class="panel panel-em">
	<header class="panel-heading">
		<?php echo __('Add City'); ?>
	</header>
	<div class="panel-body">
		<?php echo $this->Form->create('City',array('type'=>'file','class'=>'form-horizontal')); ?>
		<div class="form-group">
			<label class="control-label col-md-3"><?php echo __('Image Upload');?></label>
			<div class="col-md-9">
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
						<?php echo $this->Html->image('placeholder.png', array('alt' => 'image_path', 'class'=>'')); ?>
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
					<div>
						<span class="btn btn-default btn-file">
							<span class="fileinput-new"><i class="fa fa-paperclip"></i>&nbsp;<?php echo __('Select image');?></span>
							<span class="fileinput-exists"><i class="fa fa-undo"></i>&nbsp;<?php echo __('Change');?></span>
							<?php echo $this->Form->input('image_path', array('type'=>'file','class'=>'default','label'=>false, 'div'=>false,));?>
						</span>
						<a href="javascript:void(0);" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
							<i class="fa fa-trash"></i>&nbsp;
							<?php echo __('Remove');?>
						</a>
					</div>
				</div>
				<br />
				<span class="label label-danger"><?php echo __('NOTE!');?></span>
				<span class="help-block">
					<?php echo __('Image Size should be less then 5MB and only jpg, jpeg and png format are supported!');?>
				</span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('City Name');?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('name',array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'90')); ?>   
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Description');?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('description',array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>   
			</div>
		</div> 

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Around');?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('around',array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>   
			</div>
		</div> 

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('Known for');?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('known',array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
			</div>
		</div> 

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo __('view on homepage');?></label>
			<div class="col-sm-6">
				<?php echo $this->Form->input('is_home', array('label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>
				<span class="help-block"><?php echo __('Set yes if you want this city to be displayed in homepage. ');?></span>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-md-offset-3 col-md-6">
				<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
				<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
			</div>
		</div> 
		<?php echo $this->Form->end(); ?>
	</div>
</article>
<!-- page end-->
<?php echo $this->Html->script('common/jasny-bootstrap.min', array('block'=>'scriptBottomMiddle')); ?>