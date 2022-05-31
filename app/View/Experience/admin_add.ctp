<?php // debug($timezones); ?>
<div class="row" id="elementToMask">
	<?php echo $this->Form->create('Experience', array('type'=>'post', 'url' => array('admin' => true, 'controller' => 'experience', 'action' => 'add'), 'class'=>'form-horizontal')); ?>
	<div class="col-sm-8 col-sm-offset-2">
		<div class="box box-primary">
			<div class="tab-content tasi-tab">
				<div class="box-header with-border">
					<?php echo $this->Html->tag('h3',__('Add Experience'), array('class' => 'gen-case')) ?>
				</div>

				<div id="basics" role="tabpanel" class="box-body tab-pane fade in active">
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('user_id', array('label'=>__('Host'), 'div'=>false,'class'=>'form-control')); ?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('city_id', array('div'=>false,'class'=>'form-control', 'id'=>'experience_city_id')); ?>
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
						<div class="col-sm-8 col-sm-offset-2 js-select-container">
							<?php echo $this->Form->input('language_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'language_id')); ?>
						</div>
					</div>

					<!--
					<?php // echo $this->Form->input('inc', ['type' => 'hidden', 'value' => 1, 'id' => 'inc']); ?>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<div id="multi_lang_add"></div>
							<button id="lang_other" type="button" class="btn btn-primary lang_option_show" aria-disabled="false" aria-busy="false">+ Add another language (optional)</button>
						</div>
					</div>
					-->


												
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
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo $this->Form->input('add_subcategory', array('type'=>'checkbox', 'between' => '<br>', 'label'=>__(' + Add a secondary category (optional)'), 'div'=>false, 'class'=>'bootstrap-switch', 'id'=>'js_toggle_event')); ?>
						</div>
					</div>
					<div class="form-group js-subcategory" style="display: none;">
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

					<div class="box-footer">
						<div class="mailbox-controls">
							<a class="btn btn-warning sr-only" href="#basics" data-toggle="tab" role="tab" aria-expanded="true">
								<i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;<?php echo __('Basic'); ?>
							</a>

							<div class="btn-group pull-right">
								<a class="btn btn-info" href="#experience_page" data-toggle="tab" role="tab" aria-expanded="false">
									<?php echo __('Experience Page'); ?>&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
								</a>
							</div>
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
					<div class="js-notes" style="display: none;">
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

					<div class="box-footer">
						<div class="mailbox-controls">
							<a class="btn btn-warning" href="#basics" data-toggle="tab" role="tab" aria-expanded="false">
								<i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;<?php echo __('Basic'); ?>
							</a>

							<div class="btn-group pull-right">
								<a class="btn btn-info" href="#tab_location" data-toggle="tab" role="tab" aria-expanded="false">
									<?php echo __('Location'); ?>&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div id="tab_location" role="tabpanel" class="box-body tab-pane fade">
					<?php echo $this->Form->input('Address.model', array('type'=>'hidden', 'value'=> 'Experience'));?>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<h3><?php echo __('Add a meeting location');?></h3>
							<span class="help-block"><?php echo __('Let guests know exactly where you’ll be meeting. The exact address won’t be shared with guests until they book.');?></span>
						</div>
					</div>

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
				            <?php echo $this->Form->input('Address.city',array('div'=>false,'class'=>'form-control', 'required' => 'required', 'type' =>'text', 'id'=>'address_city'));?>
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

					<div class="box-footer">
						<div class="mailbox-controls">
							<a class="btn btn-warning" href="#experience_page" data-toggle="tab" role="tab" aria-expanded="false">
								<i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;<?php echo __('Experience'); ?>
							</a>

							<div class="btn-group pull-right">
								<a class="btn btn-info" href="#finishing_thoughts" data-toggle="tab" role="tab" aria-expanded="false">
									<?php echo __('Finishing Thoughts'); ?>&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
								</a>
							</div>
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
							<span class="help-block"><?php echo __('Price per person.');?></span>
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
					
					<div class="js-packing-list" style="display: none;">
						<?php echo $this->Form->input('pack_list_nr', ['type' => 'hidden', 'value' => 1, 'id' => 'pack_list_nr']); ?>
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<h3><?php echo __('Write something simple and short');?></h3>
								<p class="help-block"><?php echo __('What should your guests bring?');?></p>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-2">
								<?php echo $this->Form->input('packing_list.', array('type'=>'text', 'placeholder'=>__('Enter Item Here'), 'class'=>'form-control switch-input', 'div'=>false, 'label' => false, 'id' => false, 'required' => false)); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<button type="button" class="btn btn-primary add_items_pack" aria-disabled="false" aria-busy="false"><?php echo __('+ Add another item');?></button>
						</div>
					</div>

					<div class="box-footer">
						<div class="mailbox-controls">
							<a class="btn btn-warning" href="#tab_location" data-toggle="tab" role="tab" aria-expanded="false">
								<i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;<?php echo __('Location'); ?>
							</a>
							<div class="btn-group pull-right">
								<button type="submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo __('Save');?></button>
								<?php // echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-close')). '&nbsp;' . __('Cancel'), array('controller' => 'experience', 'action' => 'index'), array('escape' => false,'class'=>'btn btn-danger  btn-sm')); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		echo $this->Form->input('hosting_standards_reviewed', ['type' => 'hidden', 'value' => 1]);
		echo $this->Form->input('experience_standards_reviewed', ['type' => 'hidden', 'value' => 1]);
		echo $this->Form->input('quality_standards_reviewed', ['type' => 'hidden', 'value' => 1]);
		echo $this->Form->input('local_laws_reviewed', ['type' => 'hidden', 'value' => 1]);
		echo $this->Form->input('terms_service_reviewed', ['type' => 'hidden', 'value' => 1]);
	?>
	<?php echo $this->Form->end(); ?>
</div>

<?php
$this->Html->script('//maps.googleapis.com/maps/api/js?key='.Configure::read('Google.key'), array('block'=>'scriptBottomMiddle'));
$this->Html->script('common/addresspicker/jquery.ui.addresspicker', array('block'=>'scriptBottomMiddle'));
$this->Html->script('frontend/experience', array('block'=>'scriptBottomMiddle'));
?>
