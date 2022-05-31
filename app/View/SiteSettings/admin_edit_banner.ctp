<?php
	echo $this->Html->css('common/jasny-bootstrap', null, array('block'=>'cssMiddle'));
	$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Banner'. DS;
?>  
<!-- page start-->
<article class="panel panel-em">
	<header class="panel-heading">
		<?php  echo __('Edit Banner'); ?>
	</header>
	<div class="panel-body">
		<?php 
			echo $this->Form->create('Banner', array('type'=>'file', 'class'=>'form-horizontal', 'url'=>array('admin'=>true,'controller' => 'site_settings', 'action' => 'editBanner'))); 
			echo $this->Form->input('id');
		?>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Title');?></label>
				<div class="col-sm-6">
					<?php echo $this->Form->input('Banner.title', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-minlength'=>'0', 'data-maxlength'=>'75', 'autocomplete'=>"off")); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Description');?></label>
				<div class="col-sm-6">
					<?php echo $this->Form->input('Banner.description', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-minlength'=>'0', 'data-maxlength'=>'160', 'autocomplete'=>"off")); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Button text');?></label>
				<div class="col-sm-6">
					<?php echo $this->Form->input('Banner.button_text',array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'60')); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Button URL');?></label>
				<div class="col-sm-6">
					<?php echo $this->Form->input('Banner.url',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>'http://www.example.com/', 'data-maxlength'=>'250')); ?>   
					<span class="help-block"><?php echo __('Here you can paste absolute URL of a page or another site. ');?></span>
				</div>
			</div>  

			<div class="form-group">
				<label class="control-label col-md-3"><?php echo __('Image Upload');?></label>
				<div class="col-md-9">
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
							<?php
								$image_path = (isset($this->request->data['Banner']['image_path'])) ? $this->request->data['Banner']['image_path'] : '' ;
								if (file_exists($directory.$image_path) && is_file($directory.$image_path)) {
									 echo $this->Html->image('uploads/Banner/'.$image_path, array('alt' => 'image_path')); 
								} else {
									echo $this->Html->image('placeholder.png', array('alt' => 'image_path', 'class'=>''));
								} 
							?>
						</div>
						<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
						<div>
							<span class="btn btn-default btn-file">
								<span class="fileinput-new"><i class="fa fa-paperclip"></i>&nbsp;<?php echo __('Select image');?></span>
								<span class="fileinput-exists"><i class="fa fa-undo"></i>&nbsp;<?php echo __('Change');?></span>
								<?php echo $this->Form->input('Banner.image_path', array('type'=>'file','class'=>'default','label'=>false, 'div'=>false,));?>
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
				<label class="col-sm-3 control-label"><?php echo __('Publish Status');?></label>
				<div class="col-sm-6">
					<?php echo $this->Form->input('Banner.status', array('type'=>'checkbox', 'label'=>false, 'div'=>false,'class'=>'bootstrap-switch')); ?>
					<span class="help-block"><?php echo __('Set yes if you want the slider to be visible to audience. ');?></span>
				</div>
			</div>                    	                     	                    					            
			<div class="form-group">
				<div class="col-md-offset-3 col-md-6">
					<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
					<?php echo $this->Html->link(__('Cancel'),array('action' => 'banner'), array('escape' => false, 'class'=>'btn btn-danger')); ?>
				</div>
			</div> 
		<?php echo $this->Form->end(); ?>
	</div>
</article>

<!-- page end-->
<?php echo $this->Html->script('common/jasny-bootstrap.min', array('block'=>'scriptBottomMiddle')); ?>