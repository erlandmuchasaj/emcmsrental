<?php
	echo $this->Html->css('common/jasny-bootstrap', null, array('block'=>'cssMiddle'));
	$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS.'small'.DS;
?>  
<div class="row">
	<?php 
		echo $this->Form->create('User',array('type'=>'file','class'=>'form', 'url' => array('admin'=>true,'controller' => 'users','action' => 'add'))); 
	?>
	<div class="col-lg-4 col-md-5">
		<!-- Profile Image -->
		<div class="box box-primary">
			<div class="box-body box-profile">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
								<?php echo $this->Html->image('placeholder.png', array('alt' => 'image_path', 'class'=>'img-resposnive')); ?>
							</div>
							<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
							<div>
								<span class="btn btn-default btn-file">
									<span class="fileinput-new"><i class="fa fa-paperclip" aria-hidden="true"></i>&nbsp;<?php echo __('Select image');?></span>
									<span class="fileinput-exists"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;<?php echo __('Change');?></span>
									<?php echo $this->Form->input('User.image_path', array('type'=>'file','class'=>'default','label'=>false, 'div'=>false,));?>
								</span>
								<a href="javascript:void(0);" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
									<i class="fa fa-trash" aria-hidden="true"></i>&nbsp;
									<?php echo __('Remove');?>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<?php
						echo $this->Form->input('role', [
							'type' => 'select',
							'label'=>false,
							'div'=>false,
							'class'=>'form-control dropdown-select',
							'empty'=>__('Please Select Role'),
							'options' => [
								'user'   => __('User (default)'),
								'agency' => __('Agency'),
								'admin'  => __('Admin'),
							],
							'value' => 'user',
						]); 
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-8 col-md-7">
		<div class="card">
			<div class="header">
				<div class="col-md-12">
					<?php echo $this->Html->tag('h3', __('Add User Profile Information'), array('class'=>'title'))?>
				</div>
			</div>

			<div class="content">

				<div class="row">
					<div class="col-md-12">
						<?php echo $this->Html->tag('h4', __('Personal Information'), array('class'=>'title text-center'))?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
							<label class="control-label"><?php echo __('Name');?></label>
							<?php echo $this->Form->input('User.name', array('label'=>false, 'div'=>false,'class'=>'form-control count-char border-input','placeholder'=>__('Name'), 'data-maxlength'=>'50')); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label"><?php echo __('Surname');?></label>
							<?php echo $this->Form->input('User.surname',array('label'=>false, 'div'=>false,'class'=>'form-control count-char border-input','placeholder'=>__('Surname'), 'data-maxlength'=>'50')); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label"><?php echo __('Email');?></label>
							<?php echo $this->Form->input('User.email',array('label'=>false, 'div'=>false,'class'=>'form-control  border-input','placeholder'=>__('Email'))); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label"><?php echo __('Birth Date');?></label>
							<?php echo $this->Form->input('User.birthday',array('label'=>false, 'div'=>false,'id'=>'birthday', 'class'=>'form-control border-input','placeholder'=>'dd/mm/yyy')); ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label"><?php echo __('Username');?></label>
							<?php echo $this->Form->input('User.username',array('label'=>false, 'div'=>false,'class'=>'form-control count-char  border-input','placeholder'=>__('Username'), 'data-maxlength'=>'50')); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label"><?php echo __('Password');?></label>
							<?php echo $this->Form->input('User.password',array('type'=>'password','placeholder'=>__('Password'), 'class'=>'form-control border-input','label'=>false,'div'=>false)); ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label"><?php echo __('Confirm password');?></label>
							<?php echo $this->Form->input('User.confirm_password',array('type'=>'password','placeholder'=>__('Confirm password'), 'class'=>'form-control border-input','label'=>false,'div'=>false)); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<?php echo $this->Html->tag('h4', __('General Information'), array('class'=>'title text-center'))?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label"><?php echo __('Company');?></label>
							<?php echo $this->Form->input('UserProfile.company',array('label'=>false, 'div'=>false,'class'=>'form-control border-input','placeholder'=>__('Company'))); ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label"><?php echo __('Phone Number');?></label>
							<?php echo $this->Form->input('UserProfile.phone',array('label'=>false, 'div'=>false,'class'=>'form-control border-input','placeholder'=>__('Phone number'))); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label"><?php echo __('URL');?></label>
							<?php echo $this->Form->input('UserProfile.url',array('label'=>false, 'div'=>false,'class'=>'form-control border-input','placeholder'=>__('Your Website url'))); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<?php echo $this->Html->tag('h4', __('Location info'), array('class'=>'title text-center'))?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label><?php echo __('Address');?></label>
							<?php echo $this->Form->input('UserProfile.address',array('label'=>false, 'div'=>false,'class'=>'form-control count-char border-input','placeholder'=>__('Address'), 'data-maxlength'=>'255')); ?>  
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label><?php echo __('City');?></label>
							<?php echo $this->Form->input('UserProfile.city',array('label'=>false, 'div'=>false,'class'=>'form-control count-char  border-input','placeholder'=>__('City'), 'data-maxlength'=>'64')); ?>  
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label><?php echo __('Country');?></label>
							<?php echo $this->Form->input('UserProfile.country',array('label'=>false, 'div'=>false,'class'=>'form-control count-char border-input','placeholder'=>__('Country'), 'data-maxlength'=>'64')); ?> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label><?php echo __('Zip Code');?></label>
							<?php echo $this->Form->input('UserProfile.zip',array('type'=>'text','label'=>false, 'div'=>false,'class'=>'form-control count-char border-input', 'placeholder'=>__('Zip code'), 'data-maxlength'=>'10')); ?>  
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<?php echo $this->Html->tag('h4', __('Socials'), array('class'=>'title text-center'))?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label"><?php echo __('Facebook');?></label>
							<?php echo $this->Form->input('UserProfile.facebook',array('label'=>false, 'div'=>false,'class'=>'form-control border-input','placeholder'=>__('Facebook'))); ?> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label"><?php echo __('Google plus');?></label>
							<?php echo $this->Form->input('UserProfile.googleplus',array('label'=>false, 'div'=>false,'class'=>'form-control border-input','placeholder'=>__('Google plus'))); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label"><?php echo __('Instagram');?></label>
							<?php echo $this->Form->input('UserProfile.instagram',array('label'=>false, 'div'=>false,'class'=>'form-control border-input','placeholder'=>__('Instagram'))); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label"><?php echo __('Pinterest');?></label>
							<?php echo $this->Form->input('UserProfile.pinterest',array('label'=>false, 'div'=>false,'class'=>'form-control border-input','placeholder'=>__('Pinterest'))); ?>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label"><?php echo __('Youtube');?></label>
							<?php echo $this->Form->input('UserProfile.youtube',array('label'=>false, 'div'=>false,'class'=>'form-control border-input','placeholder'=>__('Youtube'))); ?>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label"><?php echo __('Vimeo');?></label>
							<?php echo $this->Form->input('UserProfile.vimeo',array('label'=>false, 'div'=>false,'class'=>'form-control border-input','placeholder'=>__('Vimeo'))); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label"><?php echo __('About Me');?></label>
							<?php echo $this->Form->input('UserProfile.about',array('label'=>false, 'div'=>false,'class'=>'form-control count-char border-input','placeholder'=>__('Here can be your description'), 'data-maxlength'=>'512')); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<?php echo $this->Form->submit(__('Add User'), array('class'=>'btn btn-info btn-fill btn-wd','label'=>false,'div'=>false)); ?>
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