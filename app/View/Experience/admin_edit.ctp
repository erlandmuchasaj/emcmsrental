<?php
	/*This css is applied only to this page*/
	echo $this->Html->css('common/dropzone/dropzone', null, array('block'=>'cssMiddle'));

	$experienceID = null;
	if (isset($this->request->data['Experience']['id'])) {
		$experienceID = (int) $this->request->data['Experience']['id'];
	}
	// debug($this->request->data);
?>

<div class="row" id="elementToMask">
	<?php echo $this->Form->create('Experience', array('type'=>'file', 'url' => array('admin'=>true,'controller' => 'experience', 'action' => 'edit'), 'class'=>'form-horizontal')); ?>
	<?php echo $this->Form->input('id'); ?>
	<div class="col-sm-3">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo __('Edit Experience'); ?></h3>
				<div class="box-tools">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" aria-hidden="true"></i></button>
				</div>
			</div>

			<div class="box-body no-padding">
				<ul class="nav nav-stacked" role="tablist">
					<li role="presentation" class="active">
						<a href="#basics" data-toggle="tab" role="tab" aria-expanded="true">
							<i class="fa fa-gear" aria-hidden="true"></i>&nbsp;<?php echo __('Basic'); ?>
						</a>
					</li>

					<li role="presentation">
						<a href="#experience_page" data-toggle="tab" role="tab" aria-expanded="false">
							<i class="fa fa-paperclip" aria-hidden="true"></i>&nbsp;<?php echo __('Experience Page'); ?>
						</a>
					</li>
					<li role="presentation">
						<a href="#tab_location" data-toggle="tab" role="tab" aria-expanded="false">
							<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;<?php echo __('Where we will meet?'); ?>
						</a>
					</li>

					<li role="presentation">
						<a href="#calendar" data-toggle="tab" role="tab" aria-expanded="false">
							<i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<?php echo __('Calendar'); ?>
						</a>
					</li>

					<li role="presentation">
						<a href="#tab_phottos" data-toggle="tab" role="tab" aria-expanded="false">
							<i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp;<?php echo __('Let images speek'); ?>
						</a>
					</li>

					<li role="presentation">
						<a href="#finishing_thoughts" data-toggle="tab" role="tab" aria-expanded="false">
							<i class="fa fa-bars" aria-hidden="true"></i>&nbsp;<?php echo __('Finishing Touches'); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-sm-9">
		<div class="box box-primary">
			<div class="tab-content tasi-tab">
				<div class="box-header with-border">
					<?php echo $this->Html->tag('h4',__('Edit Experience - %s', $this->request->data['Experience']['title']), array('class' => 'gen-case')) ?>
				</div>

				<div id="basics" role="tabpanel" class="box-body tab-pane fade in active">

					<?php if (false): ?>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('user_id', array('label'=>__('Host'), 'div'=>false,'class'=>'form-control')); ?>
						</div>
					</div>
					<?php endif ?>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('city_id', array('div'=>false,'class'=>'form-control', 'id' => 'experience_city_id')); ?>
						</div>
					</div> 
					
					<!-- LANGUAGE -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Which language will you host in?');?></h3>
							<span class="help-block"><?php echo __('You’ll write your descriptions in this language and guests will expect you to speak it during experiences.');?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8  col-sm-offset-2">
							<?php echo $this->Form->input('language_id', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
							<span class="help-block"><?php echo __('Submission language');?></span>
						</div>
					</div>
												
					<!-- PRIMARY CATEGORY -->
					<div class="form-group">
						<div class="col-sm-8  col-sm-offset-2">
							<h3><?php echo __('What type of experience will you host?');?></h3>
							<span class="help-block"><?php echo __('Choose the category that best describes your experience. Add a second, if you think it fits into another category.');?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8  col-sm-offset-2">
							<?php echo $this->Form->input('category_id', array('label'=>false, 'div'=>false,'class'=>'form-control')); ?>
						</div>
					</div>
					
					<!-- SECONDARY CATEGORY -->
					<?php 
						$checkedSubCat = [];
						if (!empty($this->request->data['Experience']['subcategory_id'])) {
							$checkedSubCat['checked'] = 'checked';
						}
					?>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('add_subcategory', array('type'=>'checkbox', 'between' => '<br>', 'label'=>__(' + Add a secondary category (optional)'), 'div'=>false, 'class'=>'bootstrap-switch', 'id'=>'js_toggle_event') + $checkedSubCat); ?>
						</div>
					</div>
					<div class="form-group js-subcategory" <?php if (!$checkedSubCat) { ?> style="display: none;" <?php } ?> >
						<div class="col-sm-8  col-sm-offset-2">
							<?php echo $this->Form->input('subcategory_id', array('div'=>false, 'class'=>'form-control', 'id' => 'subcategory_id', 'empty' => __('Select subcategory'))); ?>
							<span class="help-block"><?php echo __('optional');?></span>
						</div>
					</div>

					<!-- SOCIAL IMPACT -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><i class="fa fa-info"></i>&nbsp;<?php echo __('Is this a social impact experience?');?></h3>
							<span class="help-block"><?php echo __('If you’re partnering with a nonprofit or a charitable organization, you can host a social impact experience. To host, you’ll have to validate your organization with our partner, TechSoup.');?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('social_impact', array('type'=>'checkbox', 'between' => '&nbsp;', 'label'=>__('Yes, this is a social impact experience'), 'div'=>false, 'class'=>'bootstrap-switch')); ?>
						</div>
					</div>
				</div>

				<div id="experience_page" role="tabpanel" class="box-body tab-pane fade">
					
					<!-- TITLE -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Title your experience');?></h3>
							<span class="help-block"><?php echo __('Write something simple and short. Mention the location if it’s relevant.');?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('title', array('label'=>false, 'div'=>false, 'class'=>'form-control count-char','placeholder'=>__('Enter Experience name'), 'data-minlength'=>'10', 'data-maxlength'=>'40')); ?>
						</div>
					</div>
					
					<!-- TAGLINE -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Write a tagline');?></h3>
							<span class="help-block"><?php echo __('Clearly describe your experience in one short, catchy sentence. Start with a verb that tells guests what they will do.');?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('tagline',array('label'=>false, 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Write your tagline here'), 'data-maxlength'=>'64')); ?>
						</div>
					</div>
					
					<!-- TIME -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Set your default time');?></h3>
							<span class="help-block"><?php echo __('You can adjust this time later depending on the dates you’re scheduled to host. Each experience must be at least 1 hour.');?></span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('timezone_id', array('div'=>false,'class'=>'form-control')); ?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-2">
							<label class="control-label"><?php echo __('Start Time');?></label>
							<?php echo $this->Form->time('start_time',array('div'=>false,'class'=>'form-control')); ?>
						</div>
						<div class="col-sm-4">
							<label class="control-label"><?php echo __('End Time');?></label>
							<?php echo $this->Form->time('end_time', array('div'=>false,'class'=>'form-control')); ?>
						</div>
					</div>
					
					<!-- WHAT WE WILL DO -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Mention what you’ll do');?></h3>
							<span class="help-block"><?php echo __('Describe in detail what you’ll be doing with your guests. The more information you can give, the better.');?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('what_will_do', array('type'=>'textarea', 'label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-minlength'=>'200', 'data-maxlength'=>'1200', 'placeholder' => __("What we'll do"))); ?>
						</div>
					</div>
					
					<!-- WHERE WE WIL BE -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Mention where you’ll be');?></h3>
							<span class="help-block"><?php echo __('Name all the locations you’ll visit. Give guests a glimpse of why they’re meaningful.');?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('where_will_be', array('type'=>'textarea', 'label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-minlength'=>'100', 'data-maxlength'=>'450', 'placeholder' => __("Where we'll be"))); ?>
						</div>
					</div>


					<!-- WHAT I WILL PROVIDE -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Confirm what you’ll provide');?></h3>
							<p class="help-block"><?php echo __('On this page, you can add additional details about what you are providing. For example, you can let your guests know that you accommodate vegetarians.');?></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('need_provides', array('type'=>'checkbox', 'between' => '<br>', 'label'=>__('Need to provide...?'), 'div'=>false, 'class'=>'bootstrap-switch', 'id'=>'js_toggle_provides')); ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">

						</div>
					</div>


					<!-- NOTES -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('need_notes', array('type'=>'checkbox', 'between' => '<br>', 'label'=>__('Need additional notes'), 'div'=>false, 'class'=>'bootstrap-switch', 'id'=>'js_toggle_notes')); ?>
						</div>
					</div>
					<div class="js-notes" <?php if ($this->request->data['Experience']['need_notes'] != 1) { ?> style="display: none;" <?php } ?> >
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-2">
								<h3><?php echo __('What else should guests know?');?></h3>
								<span class="help-block"><?php echo __('Mention anything that guests will have to bring with them or arrange on their own, like transportation.');?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-2">
								<?php echo $this->Form->input('notes', array('type'=>'textarea', 'label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'200', 'placeholder' => __('Bring your own camera, sunscreen, or snacks...'), 'id' => 'extra_notes')); ?>
							</div>
						</div>
					</div>
				</div>

				<div id="tab_location" role="tabpanel" class="box-body tab-pane fade">
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Add a meeting location');?></h3>
							<span class="help-block"><?php echo __('Let guests know exactly where you’ll be meeting. The exact address won’t be shared with guests until they book.');?></span>
						</div>
					</div>

					<?php echo $this->Form->input('Address.id'); ?>
					<?php echo $this->Form->input('Address.model', array('type'=>'hidden'));?>
					<?php echo $this->Form->input('Address.model_id', array('type'=>'hidden')); ?>

					<div class="form-group">
					    <div class="col-sm-8 col-sm-offset-2">
					        <?php echo $this->Form->input('Address.alias',array('label'=>__('Location name'), 'div'=>false, 'class'=>'form-control count-char', 'data-maxlength'=>'32')); ?>
					    </div>
					</div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
					        <?php echo $this->Form->input('Address.country_id',array('id'=>'id_country', 'div'=>false,'class'=>'form-control', 'escape' => false, 'empty' => __('Select Country'))); ?>
					    </div>
					</div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
					        <?php echo $this->Form->input('Address.address1',array('label'=>__('Street address'), 'div'=>false,'class'=>'form-control count-char','placeholder'=>__('Address line 1'), 'id'=>'addresspicker_map', 'data-maxlength'=>'128', 'required' => 'required'));?>
					    </div>
					</div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
					        <?php echo $this->Form->input('Address.address2',array('label'=>__('Apt, Suite, Bldg. (optional)'), 'div'=>false,'class'=>'form-control','placeholder'=>__('Address line 2')));?>
					    </div>
					</div>

					<div class="form-group">
				    	<div class="col-sm-4 col-sm-offset-2">
				            <?php echo $this->Form->input('Address.city',array('div'=>false,'class'=>'form-control', 'required' => 'required', 'type' =>'text', 'id' => 'address_city'));?>
				        </div>
						<div class="col-sm-4" id="contains_states">
					        <?php echo $this->Form->input('Address.state_id',array('id'=>'id_state', 'div'=>false,'class'=>'form-control','type'=>'select', 'options' =>[], 'escape' => false)); ?>
					    </div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-2">
					        <?php echo $this->Form->input('Address.postal_code',array('label'=>__('ZIP/Postal Code'), 'div'=>false, 'id'=>'postal_code', 'class'=>'form-control'));?>
					    </div>
					</div>

					<?php echo $this->Form->input('Address.latitude', array('type'=>'hidden','id'=>'latitude'));?>
					<?php echo $this->Form->input('Address.longitude', array('type'=>'hidden','id'=>'longitude'));?>

					<div class="form-group ">
						<div class="col-lg-12">
							<div class="map-clearfix">
								<div id="map"></div>
								<div class="help-block"><?php echo __('You can drag and drop the marker to the correct location. This won’t be shared with guests until after they book your experience.'); ?></div>
							</div>
						</div>
					</div>


					<div class="form-group ">
					    <label class="col-sm-3 control-label"><?php echo __('Directions (optional)');?></label>
					    <div class="col-sm-6">
					        <?php echo $this->Form->input('Address.other',array('label'=>false, 'div'=>false,'class'=>'form-control', 'placeholder' => __('For example, meet at the bus station across from the cafe.'))); ?>
					    </div>
					</div>
				</div>
				
				<div id="calendar" role="tabpanel" class="box-body tab-pane fade">
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<?php echo __('Add your availability.');?></h3>
							<span class="help-block"><?php echo __('Choose when are you available to be booked.');?></span>
						</div>
					</div>
				</div>

				<div id="tab_phottos" role="tabpanel" class="box-body tab-pane fade">
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2 text-center">
							<?php echo $this->Html->image('general/inbox.png', array('alt' => 'add photo', 'class'=>'')); ?>
							<h3><?php echo __('Add photos for your experience.');?></h3>
							<span class="help-block"><?php echo __('Choose photos that showcase the location and what guests will be doing.');?></span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12">
							<div id="my-dropzone" class="dropzone clickable-dropzone">
								<div class="fallback">
									<?php echo __('Update your brouser in order to support Drag&Drop features.'); ?>
									<input name="file" type="file" multiple />
								</div>
								<div class="dz-message">
									<?php echo __('Drop files here or, <span class="info-upload-txt"> click to upload images.</span>'); ?>
									<br />
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12" id="image_container">
						</div>
					</div>
				</div>

				<div id="finishing_thoughts" role="tabpanel" class="box-body tab-pane fade">

					<!-- ABOUT YOU -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Write your bio');?></h3>
							<p class="help-block"><?php echo __('Describe yourself and tell guests how you came to be passionate about hosting this experience.');?></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('about_you', array('type'=>'textarea', 'label'=>false, 'div'=>false,'class'=>'form-control count-char', 'data-minlength'=>'150', 'data-maxlength'=>'500', 'placeholder' => __('Teaching about Arts and Design with my drawing skills. It will be useful to make the guest feel free and live with peaceful environment. Interested can get the job with My partners organization and get money from them at My Home in London'))); ?>
						</div>
					</div>

					<!-- GUEST REQUIREMENTS -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Who can attend your experience?');?></h3>
							<p class="help-block"><?php echo __('Someone booking your experience might also reserve spots for other guests. Add information about age requirements, skill levels, or certifications required to attend your experience.');?></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('includes_alcohol', array(
								'before' => __('Alcohol %s', '<br>'),
								'between' => '&nbsp;&nbsp;',
								'label'=>__('My experience includes alcohol. Only guests that meet the legal drinking age will be served.'),
								'after' => '',
								'type'=>'checkbox',
								'div'=>false,
								'class'=>'bootstrap-switch'
							)); ?>
						</div>
					</div>
					
					<br />
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('minimum_age', array(
								'between' => '<br>',
								'label'=>__('Minimum age'),
								'after' => __('Set age limits for guests. Minors can only attend with their legal guardian.'),
								'type' => 'select',
								'options' => [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
								'div'=>false,
								'class'=>'form-control',
							)); ?>
						</div>
					</div>

					<br />
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('is_free_under_2', array(
								'between' => '&nbsp;&nbsp;&nbsp;',
								'label'=>__('Parents can bring kids under 2 years'),
								'type'=>'checkbox',
								'div'=>false,
								'class'=>'bootstrap-switch'
							)); ?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('special_certifications', array('type'=>'textarea', 'label'=>__('Special certifications'), 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'500', 'placeholder' => __('Guests must have a scuba diving certificate'))); ?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('additional_requirements', array('type'=>'textarea', 'label'=>__('Additional requirements'), 'div'=>false,'class'=>'form-control count-char', 'data-maxlength'=>'500', 'placeholder' => __('For example, let guests know if they need to be a certain age to get into a venue, need scuba certification, or be able to run 6 miles.'))); ?>
						</div>
					</div>

					<!-- GROUP SIZE -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Maximum number of guests');?></h3>
							<p class="help-block"><?php echo __('What’s the number of guests you can accommodate?');?></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('guests', array(
								'type'=>'select',
								'options' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
								'label'=>false,
								'div'=>false,
								'class'=>'form-control'
							)); ?>
						</div>
					</div>
					
					<!-- PRICE -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Set a price per guest');?></h3>
							<p class="help-block"><?php echo __('The price of your experience is entirely up to you. Play with the calculator to see how much you’d earn depending on the number of guests.');?></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('currency_id', array('div'=>false,'class'=>'form-control')); ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('price', array(
								'type'=>'text',
								'label'=>false,
								'div'=>false,
								'placeholder'=> 'EUR or smth elese...',
								'class'=>'form-control'
							)); ?>
						</div>
					</div>

					<!-- PREPARATION TIME -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('How much time do you need to prepare?');?></h3>
							<p class="help-block"><?php echo __('We recommend giving yourself a day or two to prepare.');?></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('preparation_hours', array(
								'type'=>'select',
								'options' => [
									24 => '1 day',
									48 => '2 days',
									72 => '3 days',
									96 => '4 days',
									120 => '5 days',
									144 => '6 days',
									168 => '1 week',
									336 => '2 weeks',
									504 => '3 weeks',
									672 => '4 weeks',
								],
								'label'=>false,
								'div'=>false,
								'after' => 'If no one books 1 day before your experience, it will be unscheduled.',
								'empty'=> __('Choose number of days'),
								'class'=>'form-control'
							)); ?>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Can you accommodate last minute guests?');?></h3>
							<p><?php echo __('We want you to get as many guests as possible. For an experience that already has one guest, you can set a cutoff time for when remaining guests can book.');?></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('last_minute_guest', [
								'type' => 'checkbox',
								'between' => '&nbsp;&nbsp;',
								'label' => __('Toggle'),
								'div' => false, 
								'class' => 'bootstrap-switch',
								'data-on-text' => __("Yes, I’m flexible"),
								'data-off-text' => __("No thanks")
							]); ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('cutoff_time', [
								'type' => 'select',
								'options' => [
									1 =>'1 hour', 
									2 =>'2 hours', 
									3 =>'3 hours', 
									4 =>'4 hours', 
									8 =>'8 hours', 
									12 =>'12 hours', 
									24 =>'24 hours', 
									48 =>'48 hours', 
								],
								'label' => __('Cutoff time'),
								'div' => false, 
								'class' => 'form-control'
							]); ?>
						</div>
					</div>

					<!-- BACKGROUND INFO -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Give your guests context');?></h3>
							<p class="help-block"><?php echo __('What information can help guests better understand and appreciate your experience? You can include books, films, documentaries, articles, songs, or artists. We’ll send this to your guests after they book.');?></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('background_info', array('type'=>'textarea', 'label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
						</div>
					</div>
					
					<!-- PACKING LIST -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Create a packing list');?></h3>
							<p class="help-block"><?php echo __('Let your guests know what to bring so they’re prepared.');?></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('need_packing_lists', array('type'=>'checkbox', 'between' => '<br>', 'label'=>__('Need packing list?'), 'div'=>false, 'class'=>'bootstrap-switch toggle-switch', 'id'=>'js_toggle_packaging', 'data-container-class'=>'.js-packing-list')); ?>
						</div>
					</div>
					
					<div class="js-packing-list" <?php if ($this->request->data['Experience']['need_packing_lists'] != 1) { ?> style="display: none;" <?php } ?>>
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<h3><?php echo __('Write something simple and short');?></h3>
								<p class="help-block"><?php echo __('What should your guests bring?');?></p>
							</div>
						</div>
						<?php if (!empty($this->data['Experience']['packing_list'])): ?>
							<?php echo $this->Form->input('pack_list_nr', ['type' => 'hidden', 'value' => count($this->data['Experience']['packing_list']), 'id' => 'pack_list_nr']); ?>
							<?php foreach ($this->data['Experience']['packing_list'] as $key => $package_list): ?>
								<?php $packNr = $key +1; ?>
								<?php if ($key == 0): ?>
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<?php echo $this->Form->input('packing_list.', array('type'=>'text', 'placeholder'=>__('Enter Item Here'), 'div'=>false, 'label'=>false, 'class'=>'form-control switch-input', 'value' => $package_list, 'id' => false, 'required' => false)); ?>
									</div>
								</div>
								<?php else: ?>
								<div class="form-group" id="con_<?php echo $packNr; ?>">
									<div class="col-sm-8 col-sm-offset-2 input-group" style="padding-left: 15px; padding-right: 15px;">
										<?php echo $this->Form->input('packing_list.', array('type'=>'text', 'placeholder'=>__('Enter Item Here'), 'div'=>false, 'label'=>false, 'class'=>'form-control switch-input', 'value' => $package_list, 'id' => false, 'required' => false)); ?>

										<div class="input-group-btn">
											<button type="button"  class="btn btn-danger del_pack_list" data-val="<?php echo $packNr; ?>" type="submit" aria-disabled="false" aria-busy="false">
												<i class="glyphicon glyphicon-remove"></i>
											</button>
										</div>
									</div>
								</div>
								<?php endif ?>
							<?php endforeach ?>
						<?php endif ?>
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-2">
								<button type="button" class="btn btn-primary add_items_pack" aria-disabled="false" aria-busy="false"><?php echo __('+ Add another item');?></button>
							</div>
						</div>
					</div>
				</div>

				<div class="box-footer">
					<div class="mailbox-controls">
						<!-- Check all button -->
						<button type="submit" class="btn btn-success btn-sm save-site-setting"><i class=" fa fa-check"></i>&nbsp;<?php echo __('Save');?></button>

						<div class="btn-group pull-right">
							<?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-close')). '&nbsp;' .__('Cancel'),array('controller' => 'experience', 'action' => 'index'),array('escape' => false,'class'=>'btn btn-danger  btn-sm')); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		// echo $this->Form->input('hosting_standards_reviewed');
		// echo $this->Form->input('experience_standards_reviewed');
		// echo $this->Form->input('quality_standards_reviewed');
		// echo $this->Form->input('local_laws_reviewed');
		// echo $this->Form->input('terms_service_reviewed');
		// echo $this->Form->input('is_approved');
		// echo $this->Form->input('is_featured');
		// echo $this->Form->input('status');
	?>
	<?php echo $this->Form->end(); ?>
</div>

<?php
$this->Html->script('//maps.googleapis.com/maps/api/js?key='.Configure::read('Google.key'), array('block'=>'scriptBottomMiddle'));
$this->Html->script('common/addresspicker/jquery.ui.addresspicker', array('block'=>'scriptBottomMiddle'));
$this->Html->script('common/typewatch/jquery.typewatch', array('block' => 'scriptBottomMiddle'));
$this->Html->script('common/dropzone/dropzone', array('block' => 'scriptBottomMiddle'));
$this->Html->scriptBlock("
	var selectedState = '".(isset($this->request->data['Address']['state_id']) ? $this->request->data['Property']['price'] : null)."',
		experienceID = '".$experienceID."',
		myDropzone = null,
		map = null;
	(function($){
		$(document).ready(function() {
			'use strict';

			setTimeout(function() {
				getExperienceImages(experienceID);
			}, 30);

			$('#js_toggle_event').on('switchChange.bootstrapSwitch', function (event, state) {
				var element = $('.js-subcategory');
				if (state == true) {
					element.fadeIn().find('#subcategory_id').prop('disabled', false);
				} else {
					element.fadeOut().find('#subcategory_id').prop('disabled', true);
				}
			}); 

			$('#js_toggle_notes').on('switchChange.bootstrapSwitch', function (event, state) {
				var element = $('.js-notes');
				if (state == true) {
					element.show().find('#extra_notes').prop('disabled', false);
				} else {
					element.hide().find('#extra_notes').prop('disabled', true);
				}
			});

			$('.toggle-switch').on('switchChange.bootstrapSwitch', function (event, state) {
				var container = $(this).attr('data-container-class');
				if (typeof container !== typeof undefined && container !== false) {
					var element = $(container);
					if (state == true) {
						element.fadeIn().find('.switch-input').prop('disabled', false);
					} else {
						element.fadeOut().find('.switch-input').prop('disabled', true);
					}
				}
			});

			$(document).on('click', '.add_items_pack', function(){
				var packNr = $('#pack_list_nr').val();
					packNr++;

				var itempPackHTML = Array();

				itempPackHTML.push('<div class=\"form-group\" id=\"con_'+packNr+'\">');
				itempPackHTML.push('	<div class=\"col-sm-8 col-sm-offset-2 input-group\" style=\"padding-left: 15px; padding-right: 15px;\">');
				itempPackHTML.push('		<input name=\"data[Experience][packing_list][]\" placeholder=\"Enter Item Here\" class=\"form-control\" type=\"text\">');
				itempPackHTML.push('		<div class=\"input-group-btn\">');
				itempPackHTML.push('		  <button type=\"button\"  class=\"btn btn-danger del_pack_list\" data-val=\"'+packNr+'\" type=\"submit\" aria-disabled=\"false\" aria-busy=\"false\">');
				itempPackHTML.push('		  	<i class=\"glyphicon glyphicon-remove\"></i>');
				itempPackHTML.push('		  </button>');
				itempPackHTML.push('		</div>');
				itempPackHTML.push('	</div>');
				itempPackHTML.push('</div>');

				$('.js-packing-list').append(itempPackHTML.join(''));
				$('#pack_list_nr').val(packNr);
			})

			$(document).on('click', '.del_pack_list',function() {
				var packNr = $('#pack_list_nr').val();
				packNr--;

				var value = $(this).data('val');
				$('#con_'+value).remove();

				$('#pack_list_nr').val(packNr);
			});



			$('#experience_city_id').on('change', function () {
				var city = $(this).find('option[value=' + $(this).val() + ']').text();
				$('#address_city').val(city);
				return true;
			});

			if ($('#id_country') && $('#id_state')) {
				if(selectedState) {
					ajaxStates(selectedState);
				}
				
				$('#id_country').on('change', function() {
					ajaxStates();
				});
			};

			// GOOGLE MAP INICIALISATION
			var addresspickerMap = $('#addresspicker_map').addresspicker({
				regionBias: '',
				key: google_map_key,
				language: '',
				componentsFilter: '',
				updateCallback: showCallback,
				mapOptions: {
					zoom: 4,
					center: new google.maps.LatLng(46, 2),
					scrollwheel: true,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				},
				elements: {
					map:      '#map',
					lat:      '#latitude',
					lng:      '#longitude',
					administrative_area_level_1: '#state_province',
					postal_code: '#postal_code'
				}
			});

			var gmarker = addresspickerMap.addresspicker('marker');
			gmarker.setVisible(true);
			addresspickerMap.addresspicker('updatePosition');

			var image = new google.maps.MarkerImage(fullBaseUrl+'/img/map/marker1.png');
			gmarker.setIcon(image);

			function showCallback(geocodeResult, parsedGeocodeResult){
				var idCountry = $('#id_country option').filter(function() { return $(this).html() == parsedGeocodeResult.country; }).val();
				if (idCountry === undefined) {
					$('#id_country').val(0).trigger('change');
				} else {
					$('#id_country').val(idCountry).trigger('change');
				}
				// $('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
			}

			// Update zoom field
			map = $('#addresspicker_map').addresspicker('map');
			google.maps.event.addListener(map, 'idle', function(){
				$('#zoom').val(map.getZoom());
			});

			// Add Marker on click
			google.maps.event.addListener(map, 'click', function(position) {
				gmarker.setPosition(position.latLng);
				google.maps.event.trigger(gmarker, 'dragend');
			});

			// Open map on full container on triger zoom
			google.maps.event.addListener(map, 'zoom_changed', function() {
				var center = map.getCenter();
				google.maps.event.trigger(map, 'resize');
				map.setCenter(center);
			});

			// INICIALISE DROPZONE
			myDropzone = new Dropzone('#my-dropzone', {
				url: fullBaseUrl+'/admin/experience/image/'+experienceID,
				params: {
					experience_id: experienceID
				},
				addRemoveLinks: false,
				autoProcessQueue: true,
				clickable: '.clickable-dropzone'
			});

			// Maximum file is => x <=
			myDropzone.on('maxfilesexceeded', function(file) {
				var _this = this;
				_this.removeFile(file);
			});

			// AUTOPROCESS QUEUE
			myDropzone.on('processing', function() {
				this.options.autoProcessQueue = true;
			});

			// SHOW NOTIFICATION IF MAX FILES EXEEDED
			myDropzone.on('success', function(file, response) {
				// console.log(response);
				var data = $.parseJSON(JSON.stringify(response));
				if (data.error == 1) {
					toastr.warning(data.message, 'Warning');
					var _this = this;
					_this.removeFile(file);
				}
			});

			// SHOW NOTIFICATION IF ANYTHING GOES WRONG
			myDropzone.on('error', function(file, response) {
				toastr.error(response, 'Error!');
				var _this = this;
				_this.removeFile(file);
			});

			myDropzone.on('addedfile', function() {
				// console.log(this.getQueuedFiles().length);
				// console.log(this.getUploadingFiles().length);
				// console.log(this.getAcceptedFiles());
			});

			// LOAD ALL IMAGES AFTER UPLOAD HAS FINISHED
			myDropzone.on('queuecomplete', function() {
				getExperienceImages(experienceID);
			});

		});
	})(jQuery);

	function ajaxStates(id_state_selected) {
		$.ajax({
			url: fullBaseUrl+'/countries/getStatesByCountry/'+$('#id_country').val(),
			cache: false,
			data: 'no_empty=0&id_country='+$('#id_country').val() + '&id_state=' + $('#id_state').val(),
			success: function(html) {
				if (html == 'false') {
					$('#contains_states').fadeOut();
					$('#id_state option[value=0]').attr('selected', 'selected');
				} else {
					$('#id_state').html(html);
					$('#contains_states').fadeIn();
					$('#id_state option[value=' + id_state_selected + ']').attr('selected', 'selected');
				}
			}
		});
	}

	function getExperienceImages(paramID) {
		$.ajax({
			url: fullBaseUrl+'/admin/experience/loadImages/'+paramID,
			type: 'POST',
			dataType: 'html',
			data:'action=get_images',
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus == 'success') {
					$('#image_container').html(data);
				} else {
					toastr.warning(textStatus, 'Warning!');
				}
			},
			complete: function(xhr, textStatus) {
				//called when complete
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				$('#image_container').html('We couldnt fetch the data please try again!');
				toastr.error(errorThrown, textStatus);
			}
		});
		return false;
	}
", array('block' => 'scriptBottom'));
?>