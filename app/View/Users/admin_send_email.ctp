<?php
	echo $this->Html->css('common/jasny-bootstrap', null, array('block'=>'cssMiddle'));
	$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS.'small'.DS;
?>  
<?php 
	// debug($this->request->data);
?>

<div class="row">
	<?php 
		echo $this->Form->create('User',array('class'=>'form', 'url' => array('admin'=>true,'controller' => 'users','action' => 'sendEmail')));
		echo $this->Form->input('User.id');
	?>
	<div class="col-lg-4 col-md-5">
		<!-- Profile Image -->
		<div class="box box-primary">
			<div class="box-body box-profile">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
								<?php
									if (file_exists($directory.$this->Form->value('User.image_path')) && is_file($directory.$this->Form->value('User.image_path'))) { 
										echo $this->Html->image('uploads/User/small/'. $this->Form->value('User.image_path'), array('alt' => 'image_path','class'=>'')); 
									} else {
										echo $this->Html->image('placeholder.png', array('alt' => 'image_path', 'class'=>'')); 
									} 
								?>
							</div>
						</div>
					</div>
				</div>
				<?php
					echo $this->Html->tag('h3', $this->Form->value('User.name').' '.$this->Form->value('User.surname'), array('class'=>'profile-username text-center'));

				?>
			</div>
		</div>
	</div>

	<div class="col-lg-8 col-md-7">
		<div class="card">
			<div class="header">
				<div class="col-md-12">
					<?php echo $this->Html->tag('h3', __('Email'), array('class'=>'title'))?>
				</div>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label"><?php echo __('Email');?></label>
							<?php echo $this->Form->input('User.email',array('label'=>false, 'div'=>false,'class'=>'form-control  border-input','placeholder'=>__('Email'), 'readonly'=>'readonly')); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label"><?php echo __('Subject');?></label>
							<?php echo $this->Form->input('User.subject',array('label'=>false, 'div'=>false,'class'=>'form-control border-input','placeholder'=>__('Subject'))); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label"><?php echo __('Message');?></label>
							<?php echo $this->Form->input('User.message',array('type'=>'textarea','label'=>false, 'div'=>false,'class'=>'form-control count-char border-input','placeholder'=>__('Here can add the message'), 'data-maxlength'=>'512')); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<?php echo $this->Form->submit(__('Send Email'), array('class'=>'btn btn-info btn-fill btn-wd','label'=>false,'div'=>false)); ?>
							<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<?php
	echo $this->Html->script('common/jasny-bootstrap.min', array('block'=>'scriptBottomMiddle')); 
	$this->Html->scriptBlock("", array('block' => 'scriptBottom'));
?>  