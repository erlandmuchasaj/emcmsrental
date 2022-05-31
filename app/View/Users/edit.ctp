<?php
	echo $this->Html->css('common/jasny-bootstrap', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
	$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS;
?>
<div class="em-container make-top-spacing">
	<div class="row">
		<div class="col-lg-3 col-md-4 user-sidebar">
			<div class="user-box">
				<div class="_pm_container">
					<?php
						echo $this->Html->link(
							$this->Html->displayUserAvatar($this->request->data['User']['image_path']),
							array('controller' => 'users', 'action' => 'view', AuthComponent::user('id')),
							array('escape' => false, 'class'=>'user-box-avatar')
						);
					?>
				</div>
				<?php echo $this->Html->tag('h2', h($this->request->data['User']['name'].' '.$this->request->data['User']['surname']),array('class' => 'user-box-name')) ?>
			</div>

			<div class="quick-links">
				<h3 class="quick-links-header"><?php echo __('Quick Links'); ?></h3>
				<ul class="quick-links-list">
					<li>
						<a href="<?php echo $this->Html->url(['controller' => 'users', 'action' => 'changepassword', $this->request->data['User']['id']], true ); ?>">
							<?php echo __('Change password'); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo $this->Html->url(['controller' => 'properties', 'action' => 'listings'], true ); ?>">
							<?php echo __('View/Manage Listing'); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo $this->Html->url(['controller' => 'reservations', 'action' => 'my_reservations'], true ); ?>">
							<?php echo __('Reservations'); ?>
						</a>
					</li>

					<li>
						<a href="<?php echo $this->Html->url(['controller' => 'reviews', 'action' => 'index'], true ); ?>">
							<?php echo __('Reviews'); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	    <div class="col-lg-9 col-md-8">
	        <section class="panel panel-em no-border">
	            <header class="panel-heading"><?php echo $this->Html->tag('h4', __('Edit User Profile'))?></header>
	            <div class="panel-body">
                	<?php
						echo $this->Form->create('User',array('type'=>'file', 'class'=>'form-horizontal'));
						echo $this->Form->input('User.id');
						echo $this->Form->input('UserProfile.id');
						echo $this->Form->input('UserProfile.prefix', ['type' => 'hidden', 'value' => '', 'id' => 'prefix']);
                	?>
	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('First name');?>&nbsp;<i class="fa fa-lock"></i></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('User.name', array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Name'), 'data-maxlength'=>'50')); ?>

	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Last name');?>&nbsp;<i class="fa fa-lock"></i></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('User.surname',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Surname'), 'data-maxlength'=>'50')); ?>
	                        <span class="help-block"><?php echo __('This is only shared once you have a confirmed booking with another user.');?></span>
	                    </div>
	                </div>

					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo __('I am');?></label>
						<div class="col-sm-6">
							<?php
								$options = [
									'male' => __('Male'),
									'female' => __('Female'),
									'other' => __('Other'),
								];
								$attributes = array('legend' => false, 'div'=>false, 'hiddenField'=>false, 'label'=> array('class' => 'label_radio_register'));
								echo $this->Form->radio('User.gender', $options, $attributes);
							?>
							<span class="help-block"><?php echo __('We use this data for analysis and never share it with other users.');?></span>
						</div>
					</div>

					<div class="form-group">
					    <label for="birthday" class="col-sm-3 control-label"><?php echo __('Birth Date');?></label>
					    <div class="col-sm-6">
					        <?php echo $this->Form->input('User.birthday',array('label'=>false, 'div'=>false,'id'=>'birthday', 'class'=>'form-control','placeholder'=>'dd/mm/yyy')); ?>
					        <span class="help-block"><?php echo __('The magical day you were dropped from the sky by a stork. We use this data for analysis and never share it with other users.');?></span>
					    </div>
					</div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Email address');?>&nbsp;<i class="fa fa-lock"></i></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('User.email',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Email'))); ?>
	                        <span class="help-block"><?php echo __('We won’t share your private email address with other users.');?></span>
	                    </div>
	                </div>

	                <hr />
					<?php if (false): ?>
	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Preferred language');?></label>
	                    <div class="col-sm-6">
	                		<?php echo $this->Form->input('UserProfile.language_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'language_id')); ?>
	                        <span class="help-block"><?php echo __('We’ll send you messages in this language');?></span>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Preferred currency');?></label>
	                    <div class="col-sm-6">
	                		<?php echo $this->Form->input('UserProfile.currency_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'currency_id')); ?>
	                        <span class="help-block"><?php echo __('We’ll show you prices in this currency');?></span>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Time zone');?></label>
	                    <div class="col-sm-6">
	                		<?php echo $this->Form->input('UserProfile.timezone_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'timezone_id')); ?>
	                        <span class="help-block"><?php echo __('Your home time zone');?></span>
	                    </div>
	                </div>
	            	<?php endif ?>

					<div class="form-group">
						<label class="control-label col-sm-3"><?php echo __('Avatar');?></label>
						<div class="col-sm-6">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
									<?php
										if (file_exists($directory . $this->Form->value('User.image_path')) && is_file($directory .$this->Form->value('User.image_path'))) {
											echo $this->Html->image('uploads/User/small/'. $this->Form->value('User.image_path'), array('alt' => 'image_path'));
										} else {
											echo $this->Html->image('placeholder.png', array('alt' => 'image_path'));
										}
									?>
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>

								<div>
									<span class="btn btn-default btn-file">
										<span class="fileinput-new"><i class="fa fa-paper-clip" aria-hidden="true"></i><?php echo __('Select image');?></span>
										<span class="fileinput-exists"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;<?php echo __('Change');?></span>
										<?php echo $this->Form->input('User.image_path', array('type'=>'file','class'=>'default','label'=>false, 'div'=>false,));?>
									</span>
									<a href="javascript:void(0);" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
										<i class="fa fa-trash" aria-hidden="true"></i>&nbsp;
										<?php echo __('Remove');?>
									</a>
								</div>
							</div>
							<br />
							<span class="help-block"><?php echo __('Clear frontal face photos are an important way for hosts and guests to learn about each other. It’s not much fun to host a landscape! Please upload a photo that clearly shows your face.');?></span>
							<span class="help-block"><span class="label label-danger"><?php echo __('NOTE!');?></span>&nbsp;<?php echo __('Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only');?>
							</span>
						</div>
					</div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Describe Yourself');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.about',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('About you...'), 'data-maxlength'=>'512')); ?>
	                        <div class="help-block">
	                        	<p><?php echo __('%s is built on relationships. Help other people get to know you.', Configure::read('Website.name'));?></p>

	                        	<p><?php echo __('Tell them about the things you like: What are 5 things you can’t live without? Share your favorite travel destinations, books, movies, shows, music, food.');?></p>

	                        	<p><?php echo __('Tell them what it’s like to have you as a guest or host: What’s your style of traveling?');?></p>

	                        	<p><?php echo __('Tell them about you: Do you have a life motto?');?></p>
	                        </div>
	                    </div>
	                </div>

                    <div class="text-left col-sm-9 col-sm-offset-3">
                        <h3><?php echo __('General Information');?></h3>
                    </div>
					
    				<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('School');?></label>
                        <div class="col-sm-6">
                            <?php echo $this->Form->input('UserProfile.school',array('label'=>false, 'div'=>false,'class'=>'form-control', 'placeholder'=>__('School'))); ?>
                        </div>
                    </div>

					<div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Work');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.company',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Company name or Job title'))); ?>
	                    </div>
	                </div>
					
					<?php if (Configure::check('Twilio.enabled') && Configure::read('Twilio.enabled') === true): ?>
	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Phone Number');?>&nbsp;<i class="fa fa-lock"></i></label>
	                    <div class="col-sm-6">
	                    	<?php 
	                    		if (!empty($this->data['UserProfile']['phone'])) {
	                    			if ((int)$this->data['UserProfile']['verified'] == 1) {
	                    				# hone number verified               		
	                    				echo $this->Html->tag('p', __('Your mobile has been verified %s', $this->data['UserProfile']['phone']));
	                    				$message = __('Change');
	                    			} else {
	                    				# Verify phone number
	                    				echo $this->Html->tag('p', __('Verify your phone number %s', $this->data['UserProfile']['phone']));
	                    				$message = __('Verify');
	                    			}
	                    		} else {
	                    			# add phone number
	                    			echo $this->Html->tag('p', __("You haven't supplied yet your phone number."));
	                    			$message = __('Add a phone number');
	                    		}
	                    	?>
	                    	<a class="btn btn-default" rel="change" href="javascript:void(0);" id="change_number" onclick="change_number(this);">
	                    		<?php echo $message;?>
	                    	</a>

		                	<div class="overlay-loader verification_number" style="display: none" id="add_new_phone">
        						<select id="phone_country" class="form-control" onchange="get_mobile_code(this, this.value)">
        							<option><?php echo __('Select Country');?></option>
        							<?php foreach ($countries as $id => $country): ?>
        							<option value="<?php echo $id ?>"><?php echo $country ?></option>
        							<?php endforeach ?>
        						</select>
        						<div class="pniw-number-container clearfix">
        							<label for="phone_number" class="control-label"><?php echo __('Add a phone number');?>:</label>
			                    	<div class="input-group">
				                    	<span class="input-group-btn"><span class="btn btn-primary pniw-number-prefix">+1</span></span>
				                    	<input type="text" class="form-control pniw-number"  maxlength="10" onkeypress="return isNumber(event)" placeholder="Phone number" id="phone_number" autocomplete="off" />
			                    	</div>
        						</div>
								<br />
            					<a class="btn btn-primary" rel="sms" href="javascript:void(0);" id="verify_sms" onclick="verify_sms(this);">
            						<?php echo __('Verify via SMS');?>
            					</a>
		                	</div>

		                	<div class="overlay-loader verification_div" style="display: none;" id="verify_new_phone">
		                		<hr />
		                		<div class="form-group">
		                			<div class="col-sm-12">
			                			<label class="control-label" for="phone_number_verification"><?php echo __('Please enter the 6-digit code');?>:</label>
			                			<input type="text" id="mobile_verification_code" class="form-control" maxlength="10" placeholder="ex: 785462">
			                		</div>
		                		</div>
		                		<a class="btn btn-primary" href="javascript:void(0);" onclick="check_phpone_verification(this)" rel="verify">
		                			<?php echo __('Verify');?>
		                		</a>
		                		<a class="btn btn-default pull-right" href="javascript:void(0);" onclick="cancel_verification();" rel="calncel_verify">
		                			<?php echo __('Cancel');?>
		                		</a>
		                	</div>
		                	<hr />
		                	<span class="help-block"><?php echo __('This is only shared once you have a confirmed booking with another %s user. This is how we can all get in touch', Configure::read('Website.name'));?></span>
	                    </div>
	                </div>
					<?php else: ?>
					<div class="form-group">
					    <label class="col-sm-3 control-label"><?php echo __('Phone Number');?>&nbsp;<i class="fa fa-lock"></i></label>
					    <div class="col-sm-6">
					        <?php echo $this->Form->input('UserProfile.phone',array('id' => "phone_number", 'label'=>false, 'div'=>false,'class'=>'form-control pniw-number','placeholder'=>__('Phone Number'), "onkeypress" => "return isNumber(event)", 'autocomplete'=>'off')); ?>
					        <span class="help-block"><?php echo __('Your mobile has not been verified.');?></span>
					    </div>
					</div>	                
	                <?php endif ?>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('URL');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.url',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Your Website url'))); ?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Where You Live');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.address',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Address'), 'data-maxlength'=>'255')); ?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Country');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.country',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Country'), 'data-maxlength'=>'64')); ?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('City');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.city',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('City'), 'data-maxlength'=>'64')); ?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Zip Code');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.zip',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Zip code'), 'data-maxlength'=>'10')); ?>
	                    </div>
	                </div>

                    <div class="text-left col-sm-9 col-sm-offset-3">
                        <h3><?php echo __('Socials');?></h3>
                    </div>

                    <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Facebook');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.facebook',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Facebook'))); ?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Google plus');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.googleplus',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Google plus'))); ?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Instagram');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.instagram',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Instagram'))); ?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Pinterest');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.pinterest',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Pinterest'))); ?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Youtube');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.youtube',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Youtube'))); ?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo __('Vimeo');?></label>
	                    <div class="col-sm-6">
	                        <?php echo $this->Form->input('UserProfile.vimeo',array('label'=>false, 'div'=>false,'class'=>'form-control','placeholder'=>__('Vimeo'))); ?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <div class="col-lg-offset-2 col-lg-10">
	                        <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
	                        <?php echo $this->Html->link(__('Cancel'),array('controller' => 'users', 'action' => 'dashboard'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
	                    </div>
	                </div>
	                <?php echo $this->Form->end(); ?>
	            </div>
	        </section>
	    </div>
	</div>
</div>
<?php echo $this->Html->script('common/jasny-bootstrap.min', array('block'=>'scriptBottomMiddle'));?>
<?php
	$this->Html->scriptBlock("
		(function($){
			$(document).ready(function() {
				'use strict';
				$('#phone_number') .bind('keydown', function (event) {
					console.log(event);
				    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				         // Allow: Ctrl+A
				        (event.keyCode == 65 && event.ctrlKey === true) || 
				         
				        // Allow: Ctrl+C
				        (event.keyCode == 67 && event.ctrlKey === true) || 
				         
				        // Allow: Ctrl+V
				        (event.keyCode == 86 && event.ctrlKey === true) || 
				         
				        // Allow: home, end, left, right
				        (event.keyCode >= 35 && event.keyCode <= 39)) {
				          // let it happen, don't do anything
				          return;
				    } else {
				        // Ensure that it is a number and stop the keypress
				        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
				            event.preventDefault(); 
				        }   
				    }
				});
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>
<script>
	/**
	 * get_mobile_code Change 
	 * @param  {$this} obj      
	 * @param  {INT} country_id    
	 * @return VOID
	 */
	function get_mobile_code(obj, country_id){
		var __this = $(obj);
		var $elementToMask = __this.closest('.overlay-loader');
		$.ajax({
			url: fullBaseUrl + '/users/getCountryPhoneCode/' + country_id,
			type: 'POST',
			dataType: 'json',
			data:{country_id:country_id},
			beforeSend: function() {
				// called before response
				$elementToMask.mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus == "success") {
					var response = $.parseJSON(JSON.stringify(data));
					console.log(response);
					if (response.error == 0) {
						$('.pniw-number-prefix').text("+"+response.data.country_mobile_code);
						$('#prefix').val("+"+response.data.country_mobile_code);
					} else {
						toastr.error(response.message, 'Error!');
					}
				} else {
					toastr.warning(textStatus,'Warning!');
				}
			},
			complete: function(xhr, textStatus) {
				//called when complete
				$elementToMask.unmask();
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				var message = '';
				if(xhr.responseJSON.hasOwnProperty('message')){
					//do struff
					message = xhr.responseJSON.message;
				}
				$elementToMask.unmask();
				toastr.error(errorThrown+":&nbsp;"+message, textStatus);
			}
		});
	}

	function check_phpone_verification(obj) {
		var __this = $(obj);
		var $elementToMask = __this.closest('.overlay-loader');
		var mobile_verification_code = $('#mobile_verification_code').val();
		$.ajax({
			url: fullBaseUrl + '/users/matchVerify',
			type: 'POST',
			dataType: 'json',
			data:{code:mobile_verification_code},
			beforeSend: function() {
				// called before response
				$elementToMask.mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus == "success") {
					var response = $.parseJSON(JSON.stringify(data));
					if (response.error == 0) {
						toastr.success(response.message, 'Success');
						window.location.reload(true);
					} else {
						toastr.error(response.message, 'Error!');
					}
				} else {
					toastr.warning(textStatus,'Warning!');
				}
			},
			complete: function(xhr, textStatus) {
				//called when complete
				$elementToMask.unmask();
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				var message = '';
				if(xhr.responseJSON.hasOwnProperty('message')){
					//do struff
					message = xhr.responseJSON.message;
				}
				$elementToMask.unmask();
				toastr.error(errorThrown+":&nbsp;"+message, textStatus);
			}
		});
	}

	function cancel_verification() {
		$('.verification_div').css('display','none');
		$('.verification_number').css('display', 'block');
	}

	window.onload = function(){
		var country_id = $('#phone_country').val();
		console.log(country_id);
		if (country_id !='' && country_id != null && variable != undefined) {
			get_mobile_code(country_id)
		}
	}

	function isNumber(evt) {
	    evt = (evt) ? evt : window.event;
	    var charCode = (evt.which) ? evt.which : evt.keyCode;
	    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    return true;
	}

	function verify_sms(obj) {
		var __this = $(obj);
		// var __this = $(this);
		var $elementToMask = __this.closest('.overlay-loader');

		var mobile_code = $('#prefix').val();
		var phone_number = $('#phone_number').val();
		var phone_country = $('#phone_country').val();

		__this.hide();
		$elementToMask.mask('Waiting...');

		if (phone_country =='') {
			toastr.error("Please select a country", 'Oops..');
			$elementToMask.unmask();
			__this.show();
		} else if (phone_number =='') {
			toastr.error("Add a phone number", 'Oops..');
			$elementToMask.unmask();
			__this.show();
		} else if (isNaN(phone_number) || phone_number.length < 9) {
			toastr.error("Phone Number Should be 10 Digit Number. Start with (0)695847850", 'Oops..');
			$elementToMask.unmask();
			__this.show();
		} else {
			$.ajax({
				url: fullBaseUrl + '/users/verifyNumber',
				type: 'POST',
				dataType: 'json',
				data:{phone_number:phone_number, mobile_code:mobile_code, phone_country:phone_country},
				beforeSend: function() {
					// called before response
					$elementToMask.mask('Waiting...');
				},
				success: function(data, textStatus, xhr) {
					//called when successful
					if (textStatus == "success") {
						var response = $.parseJSON(JSON.stringify(data));
						if (response.error == 0) {
							toastr.success(response.message, 'Success!');
							$('.verification_div').css('display', 'block');
							$('.verification_number').css('display', 'none');
							// If is a sandbox we display the message by default
							if (response.data) {
								$('#mobile_verification_code').val(response.data);
							}
						} else {
						    toastr.error(response.message, 'Error!');
						}

						$elementToMask.unmask();
						__this.show();
						
					} else {
						toastr.warning(textStatus, 'Warning!');
					}
				},
				complete: function(xhr, textStatus) {
					//called when complete
					$elementToMask.unmask();
				},
				error: function(xhr, textStatus, errorThrown) {
					//called when there is an error
					var message = '';
					if (xhr.responseJSON.hasOwnProperty('message')){
						//do struff
						message = xhr.responseJSON.message;
					}

					toastr.error(errorThrown+":&nbsp;"+message, textStatus);
					$elementToMask.unmask();
					__this.show();
				}
			});
		}
	}

	function change_number(obj) {
		var __this = $(obj);
		var $formGroup = __this.closest('.form-group');
		__this.hide(function() {
			$('#add_new_phone').show();
		});
	}
</script>