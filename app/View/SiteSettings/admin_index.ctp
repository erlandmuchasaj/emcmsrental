<?php echo $this->Html->css('common/jasny-bootstrap', null, array('block'=>'cssMiddle')); ?>
<?php $directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS . 'SiteSetting' . DS . 'logo' . DS; ?>
<?php //debug($this->data); ?>
<div class="row" id="elementToMask">
	<?php echo $this->Form->create('SiteSetting',array('url'  => array('admin'=>true,'controller' => 'site_settings','action' => 'save', 'GENERAL'), 'type'=>'POST', 'id'=>'SettingSaveForm', 'class'=>'form-horizontal')); ?>
	<?php echo $this->Form->hidden('key', ['value' => 'GENERAL']); ?>
	<div class="col-sm-3">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo __('General setting'); ?></h3>
				<div class="box-tools">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" aria-hidden="true"></i></button>
				</div>
			</div>

			<div class="box-body no-padding">
				<ul class="nav nav-stacked" role="tablist">
					<li role="presentation" class="active">
						<a href="#tab-1" data-toggle="tab" role="tab" aria-expanded="true">
							<i class="fa fa-gear" aria-hidden="true"></i>&nbsp;<?php echo __('General Info'); ?>
						</a>
					</li>
					<li>
						<a data-toggle="tab" href="#tab-2" role="tab" aria-expanded="false">
							<i class="fa fa-info" aria-hidden="true"></i>&nbsp;<?php echo __('Meta Data'); ?>
						</a>
					</li>
					<li>
						<a data-toggle="tab" href="#tab-3" role="tab" aria-expanded="false">
							<i class="fa fa-share-alt" aria-hidden="true"></i>&nbsp;<?php echo __('Socials'); ?>
						</a>
					</li>
					<!-- 
					<li>
						<a data-toggle="tab" href="#tab-4" role="tab" aria-expanded="false">
							<i class="fa fa-paypal" aria-hidden="true"></i>&nbsp;<?php // echo __('Payment Gateway'); ?>
						</a>
					</li>
					<li>
						<a data-toggle="tab" href="#tab-5" role="tab" aria-expanded="false">
							<i class="fa fa-facebook" aria-hidden="true"></i>&nbsp;<?php // echo __('API Credentials'); ?>
						</a>
					</li>
					-->
					<li>
						<a data-toggle="tab" href="#tab-6" role="tab" aria-expanded="false">
							<i class="fa fa-bars" aria-hidden="true"></i>&nbsp;<?php echo __('Others'); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-sm-9">
		<div class="box box-primary">
			<div class="box-header with-border">
				<?php echo $this->Html->tag('h3',__('Site Settings'),array('class' => 'gen-case')) ?>
			</div>

			<div class="box-body no-padding tab-content tasi-tab">
				<div class="mailbox-controls">
					<!-- Check all button -->

					<button type="submit" class="btn btn-success btn-sm save-site-setting"><i class=" fa fa-check"></i>&nbsp;<?php echo __('Save');?></button>

					<!-- <button type="button" class="btn btn-success btn-sm" onclick="save_setting();"><i class=" fa fa-check"></i>&nbsp;<?php // echo __('Save changes'); ?></button> -->

					<div class="btn-group">
						<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-close')). '&nbsp;' .__('Cancel'),array('controller' => 'properties', 'action' => 'index'),array('escape' => false,'class'=>'btn btn-danger  btn-sm')); ?>
					</div>
				</div>

				<div id="tab-1" role="tabpanel" class="mailbox-messages tab-pane fade in general active">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('App Name');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('name', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'placeholder'=>__('Application name'), 'data-maxlength'=>'50')); ?>
								<span class="help-block"><?php echo __('Website.');?></span>
							</div>
						</div>

						<?php if (false): ?>
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Logo');?></label>
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
						</div>
						<?php endif ?>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Site Name');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('sitename', array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Sitename'), 'data-maxlength'=>'50')); ?>
								<span class="help-block"><?php echo __('Website name.');?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Tagline');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('tagline',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Tagline'), 'data-maxlength'=>'120')); ?>
								<span class="help-block"><?php echo __('A short and intuitive description of the website. ');?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Slogan');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('slogan',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Slogan'), 'data-maxlength'=>'60')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Home Version');?></label>
							<div class="col-sm-6">
								<?php //echo $this->Form->input('homepage_version', array('type'=>'checkbox','label'=>false, 'div'=>false, 'class'=>'bootstrap-switch', 'data-on-text'=>"V1", 'data-off-text'=>"V2")); ?>
								<?php
								echo $this->Form->input('homepage_version', [
									'type' => 'select',
									'options' => [
										'v1' => __('Version 1 - Slider'),
										'v2' => __('Version 2 - Airbnb'),
										'v3' => __('Version 3 - Banner'),
									],
									'label'=>false,
									'div'=>false,
									'class'=>'form-control'
								]);
								?>
								<span class="help-block"><?php echo __('Select one of predifined versions of the homepage. Slider os Static Text.');?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Disable Registration');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('disable_registration', array('type'=>'checkbox', 'label'=>false, 'div'=>false, 'class'=>'bootstrap-switch')); ?>
								<span class="help-block"><?php echo __('Disable User registration on the portal.');?></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Footer Copyright Text');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('copyright', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'placeholder'=>__('Copyright Text') ,'data-maxlength'=>'160')); ?>
								<span class="help-block"><?php echo __('Write a copyright introduction text. ');?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Site Powered By');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('powered_by', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'placeholder'=>__('Powered by text') ,'data-maxlength'=>'50')); ?>
								<span class="help-block"><?php echo __('This site is powered By. ');?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Max records per page');?></label>
							<div class="col-sm-6">
								<?php
								$record = [
									'5' => '5',
									'10' => '10',
									'15' => '15',
									'20' => '20',
									'25' => '25',
									'30' => '30',
									'50' => '50',
									'100' => '100',
								];
								echo $this->Form->input('per_page_count', array('type' => 'select', 'options' => $record, 'label'=>false, 'div'=>false,'class'=>'form-control'));
								?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Max property images.');?></label>
							<div class="col-sm-6">
								<?php
								$recordImg = [
									'5' => '5',
									'10' => '10',
									'15' => '15',
									'20' => '20',
									'25' => '25',
									'30' => '30',
									'35' => '35',
									'40' => '40',
									'45' => '45',
									'50' => '50',
								];
									echo $this->Form->input('max_img_pic_property', array('type' => 'select', 'options' => $recordImg, 'label'=>false, 'div'=>false,'class'=>'form-control'));
								?>
								<span class="help-block"><?php echo __('The maximum number of images per single property that the user is allowed to upload');?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Property limit.');?></label>
							<div class="col-sm-6">
								<?php
								echo $this->Form->input('property_limit', array('type' => 'select', 'options' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 'label'=>false, 'div'=>false,'class'=>'form-control'));
								?>
								<span class="help-block"><?php echo __('The maximum number of properties a normal host can add. If host is upgraded to agent or agency he can add unlemited proeprties.');?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Site default language');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('language', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Site default currency.');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('currency', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Time zone.');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('timezone', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
							</div>
						</div>

						<!-- 
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php // echo __('Sticky Header');?></label>
							<div class="col-sm-6">
								<?php // echo $this->Form->input('is_sticky_header', array('type'=>'checkbox','label'=>false, 'div'=>false, 'class'=>'bootstrap-switch')); ?>
								<span class="help-block"><?php // echo __('Set to YES if you want sticky header. ');?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php // echo __('Minium Price*');?></label>
							<div class="col-sm-6">
								<?php
									// echo $this->Form->input('minimum_price', array('type' => 'number', 'label'=>false, 'div'=>false,'class'=>'form-control', 'min' => 8));
								?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php // echo __('Maximum Price*');?></label>
							<div class="col-sm-6">
								<?php
									// echo $this->Form->input('maximum_price', array('type' => 'number', 'label'=>false, 'div'=>false,'class'=>'form-control', 'max' => 800));
								?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php // echo __('Add code to the < head >(for tracking codes such as google analytics).');?></label>
							<div class="col-sm-6">
								<?php // echo $this->Form->input('head_code', array('type'=>'textarea','label'=>false, 'div'=>false,'class'=>'form-control', 'placeholder'=>__('Here you can paste script or code code.'))); ?>

								<span class="help-block"><?php // echo __('Above you can paste CSS, Javascript code.');?></span>
							</div>
						</div>
						-->

						<div class="form-group ">
							<label for="address" class="control-label col-sm-3"><?php echo __('Address'); ?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('address',array('class'=>'form-control count-char','placeholder'=>__('Address'), 'data-maxlength'=>'255','id'=>'address','label'=>false,'div'=>false)); ?>
							</div>
						</div>

						<div class="form-group ">
							<label for="contact_number" class="control-label col-sm-3"><?php echo __('Contact number'); ?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('contact_number',array('class'=>'form-control count-char','placeholder'=>__('Contact number'), 'data-maxlength'=>'30','id'=>'contact_number','label'=>false,'div'=>false)); ?>
							</div>
						</div>

						<div class="form-group ">
							<label for="email" class="control-label col-sm-3"><?php echo __('Email'); ?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('email',array('type'=>'email','class'=>'form-control count-char','placeholder'=>__('Site Email'), 'data-maxlength'=>'120','id'=>'email','label'=>false,'div'=>false,'type'=>'email')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Google Analytics');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('google_analytics', array('type'=>'textarea','label'=>false, 'div'=>false,'class'=>'form-control', 'placeholder'=>__('Here you can paste google analytics code.'))); ?>
								<span class="help-block"><?php echo __('Above you can paste google analytics to track user usage. ');?></span>

								<?php echo $this->Form->input('google_analytics_active', array('type'=>'checkbox','label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch', 'before' => '', 'between' => '<br>', 'after'=> __('Is Google analytics active'))); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Script Version.');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('version', array('label'=>false, 'div'=>false,'class'=>'form-control', 'placeholder' => __('Version'))); ?>
							</div>
						</div>
					</div>
				</div>

				<div  id="tab-2" role="tabpanel" class="mailbox-messages tab-pane fade meta">
					<div class="col-md-12">

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Meta title');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('meta_title', array('label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'50')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Meta keywords');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('meta_keywords', array('label'=>false, 'div'=>false,'class'=>'form-control count-char tagsinput', 'data-maxlength'=>'50')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Meta Description');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('meta_description', array('type'=>'textarea', 'label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'160')); ?>
							</div>
						</div>

					</div>
				</div>

				<div id="tab-3" role="tabpanel" class="mailbox-messages tab-pane fade socials">
					<div class="col-md-12">

						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<span class="input-group-addon facebook"><i class="fa fa-facebook" aria-hidden="true"></i></span>
									<?php echo $this->Form->input('facebook', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'facebook')); ?>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<span class="input-group-addon twitter"><i class="fa  fa-twitter" aria-hidden="true"></i></span>
									<?php echo $this->Form->input('twitter', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'twitter')); ?>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<span class="input-group-addon pinterest"><i class="fa  fa-pinterest" aria-hidden="true"></i></span>
									<?php echo $this->Form->input('pinterest', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'pinterest')); ?>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<span class="input-group-addon linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></span>
									<?php echo $this->Form->input('linkedin', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'linkedin')); ?>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<span class="input-group-addon googleplus"><i class="fa fa-google-plus" aria-hidden="true"></i></span>
									<?php echo $this->Form->input('googleplus', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'googleplus')); ?>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<span class="input-group-addon instagram"><i class="fa fa-instagram" aria-hidden="true"></i></span>
									<?php echo $this->Form->input('instagram', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'instagram')); ?>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<span class="input-group-addon tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i></span>
									<?php echo $this->Form->input('tumblr', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'tumblr')); ?>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<span class="input-group-addon youtube"><i class="fa fa-youtube" aria-hidden="true"></i></span>
									<?php echo $this->Form->input('youtube', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'youtube')); ?>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<div class="input-group">
									<span class="input-group-addon vimeo"><i class="fa fa-vimeo-square" aria-hidden="true"></i></span>
									<?php echo $this->Form->input('vimeo', array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>'vimeo')); ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php if (false): ?>
				<div id="tab-4" role="tabpanel" class="mailbox-messages tab-pane fade payments-gateway">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Paypal Username');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('paypal_username', array('label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Paypal Password');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('paypal_password', array('type'=>'password', 'label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Paypal Signature');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('paypal_signature', array('label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Sandbox Mode');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('sandbox_mode', array('type'=>'checkbox', 'label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Paypal Client');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('paypal_client', array('label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Paypal Secret');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('paypal_secret', array('label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
							</div>
						</div>
					</div>
				</div>

				<div id="tab-5" role="tabpanel" class="mailbox-messages tab-pane fade api-credentials">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Google API id');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('google_api_id', array('type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Google client id');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('google_client_id', array('type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Facebook Client ID');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('facebook_client_id', array('type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Facebook Client Secret');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('facebook_client_secret', array('type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
							</div>
						</div>
					</div>
				</div>
				<?php endif ?>

				<div id="tab-6" role="tabpanel"  class="mailbox-messages tab-pane fade others">
					<div class="col-md-12">

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Maintenance status');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('site_status', array('type'=>'checkbox', 'label'=>false, 'div'=>false,'class'=>'form-control bootstrap-switch')); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo __('Offline Message');?></label>
							<div class="col-sm-6">
								<?php echo $this->Form->input('offline_message', array('type'=>'textarea','label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'256')); ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="box-footer no-padding">
				<div class="mailbox-controls">
					<button type="submit" class="btn btn-success btn-sm save-site-setting"><i class=" fa fa-check"></i>&nbsp;<?php echo __('Save');?></button>

					<!-- <button type="button" class="btn btn-success btn-sm" onclick="save_setting();"><i class=" fa fa-check"></i>&nbsp;<?php // echo __('Save changes'); ?></button> -->

					<div class="btn-group">
						<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-close')). '&nbsp;' .__('Cancel'),array('controller' => 'properties', 'action' => 'index'),array('escape' => false,'class'=>'btn btn-danger  btn-sm')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->Html->script('common/jasny-bootstrap.min', array('block'=>'scriptBottomMiddle')); ?>
<?php
$this->Html->scriptBlock("
	(function($){
		$(document).ready(function(e) {
			var elementToMask = $('#elementToMask');
			$('#SettingSaveForm').on('submit', function(e){
				e.preventDefault();
				$.ajax({
					url: $('#SettingSaveForm').attr('action'),
					type: 'POST',
					dataType: 'json',
					data: $('#SettingSaveForm').serialize(),
					beforeSend: function() {
						elementToMask.mask('Waiting...');
					},
					success: function(data, textStatus, xhr) {
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
			});
		});
	})(jQuery);
", array('block' => 'scriptBottom'));
?>
