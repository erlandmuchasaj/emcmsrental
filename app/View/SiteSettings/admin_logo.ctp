<?php echo $this->Html->css('common/jasny-bootstrap', null, array('block'=>'cssMiddle')); ?>
<?php $directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS . 'SiteSetting' . DS . 'logo' . DS; ?>
<?php //debug($this->request->data); ?>
<div class="panel panel-em" id="elementToMask">
    <header class="panel-heading">
        <h4><?php echo __('Site Logo'); ?></h4>
    </header>
    <div class="panel-body">
	<?php
	    echo $this->Form->create('SiteSetting', array('type' => 'file', 'id'=>'site_settings', 'class'=>'form-horizontal'));
	    echo $this->Form->input('key', array('type'=>'hidden'));
	?>
	<div class="form-group">
		<div class="col-md-4">
			<h4 class="margin-top-none"><?php echo __('Upload Logo'); ?></h4>
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
					<?php
						$image_path = (isset($this->request->data['SiteSetting']['logo'])) ? $this->request->data['SiteSetting']['logo'] : '' ;
						if (file_exists($directory.$image_path) && is_file($directory.$image_path)) {
							echo $this->Html->image('uploads/SiteSetting/logo/'.$image_path, array('alt' => 'image_path')); 
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
						<?php echo $this->Form->input('logo', array('type'=>'file', 'div'=>false, 'label'=>false, 'class'=>'default file','accept'=>"image/jpeg,image/png"));?>
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

		<?php if (false): ?>
		<div class="col-md-4">
			<h4 class="margin-top-none"><?php echo __('Upload Logo Light'); ?></h4>
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
					<?php echo $this->Html->image('placeholder.png', array('alt' => 'image_path', 'class'=>'')); ?>
				</div>
				<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
				<div>
					<span class="btn btn-default btn-file">
						<span class="fileinput-new"><i class="fa fa-paperclip"></i>&nbsp;<?php echo __('Select image');?></span>
						<span class="fileinput-exists"><i class="fa fa-undo"></i>&nbsp;<?php echo __('Change');?></span>
						<?php echo $this->Form->input('logo_light', array('type'=>'file', 'div'=>false, 'label'=>false, 'class'=>'default file','accept'=>"image/jpeg,image/png"));?>
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
		<div class="col-md-4">
			<h4 class="margin-top-none"><?php echo __('Upload Favicon'); ?></h4>
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
					<?php echo $this->Html->image('placeholder.png', array('alt' => 'image_path', 'class'=>'')); ?>
				</div>
				<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
				<div>
					<span class="btn btn-default btn-file">
						<span class="fileinput-new"><i class="fa fa-paperclip"></i>&nbsp;<?php echo __('Select image');?></span>
						<span class="fileinput-exists"><i class="fa fa-undo"></i>&nbsp;<?php echo __('Change');?></span>
						<?php echo $this->Form->input('favicon', array('type'=>'file', 'div'=>false, 'label'=>false, 'class'=>'default file','accept'=>"image/jpeg,image/png"));?>
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
		<?php endif ?>
	</div>
	<div class="form-group">
	    <div class="col-md-4">
	        <button type="submit" class="btn btn-success btn-sm" >
	        	<i class=" fa fa-check"></i>&nbsp;<?php echo __('Save changes'); ?>
	        </button>
	        <div class="btn-group">
	            <?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-close')). '&nbsp;' .__('Cancel'),array('controller' => 'properties', 'action' => 'index'),array('escape' => false,'class'=>'btn btn-danger  btn-sm')); ?>
	        </div>
	    </div>
	</div>
	<?php echo $this->Form->end(); ?>
    </div>
</div>
<?php echo $this->Html->script('common/jasny-bootstrap.min', array('block'=>'scriptBottomMiddle')); ?>
<?php
$this->Html->scriptBlock("
	(function($){
		$(document).ready(function(e) {
			var elementToMask = $('#elementToMask');
			$('#site_settings').on('submit',(function(e){
				e.preventDefault();
				$.ajax({
					url:  $('#site_settings').attr('action'),
					type: 'POST',
					contentType: false,
					dataType: 'json',
					cache: false,
					processData:false,
					data:  new FormData(this),
					beforeSend: function() {
						elementToMask.mask('Waiting...');
					},
					success: function(data, textStatus, xhr) {
					//called when successful
						if (textStatus =='success') {
						    var response = $.parseJSON(JSON.stringify(data));
						    if (!response.error) {
						        toastr.success(response.message,'Success!');
						    } else {
						        toastr.error(response.message,'Error!');
						    }
						} else {
						    toastr.warning(textStatus,'Warning!');
						}
						elementToMask.unmask();					
					},
					error: function(xhr, textStatus, errorThrown) {
						elementToMask.unmask();
						toastr.error(errorThrown, 'Error!');
					},
					complete: function(xhr, textStatus) {
						elementToMask.unmask();
					}
				});
				return false;
			}));
		});
	})(jQuery);
", array('block' => 'scriptBottom'));
?>
