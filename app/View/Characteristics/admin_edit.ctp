<?php
	echo $this->Html->css('common/jasny-bootstrap', null, array('block'=>'cssMiddle'));
	echo $this->Html->css('admin/icon-picker.min', null, array('block'=>'cssMiddle'));
	$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Characteristic'. DS;
?>
<!-- page start-->
<article class="panel panel-em">
    <header class="panel-heading">
    	<?php echo $this->Html->tag('h4', __('Edit Characteristics'), array('class'=>''))?>
    </header>
    <div class="panel-body">
    	<?php 
			echo $this->Form->create('Characteristic',array('type'=>'file', 'class'=>'form-horizontal'));
			echo $this->Form->input('Characteristic.id'); 
    	?>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Icon');?></label>
            <div class="col-md-9">
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
						<?php
							if (file_exists($directory.$this->Form->value('Characteristic.icon')) && is_file($directory.$this->Form->value('Characteristic.icon'))) { 	
								 echo $this->Html->image('uploads/Characteristic/'.$this->Form->value('Characteristic.icon'), array('alt' => 'icon')); 
							} else {	
								echo $this->Html->image('placeholder.png', array('alt' => 'image_path', 'class'=>'img-resposnive'));
							} 
						?>
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
					<div>
						<span class="btn btn-default btn-file">
							<span class="fileinput-new"><i class="fa fa-paperclip"></i>&nbsp;<?php echo __('Select image');?></span>
							<span class="fileinput-exists"><i class="fa fa-undo"></i>&nbsp;<?php echo __('Change');?></span>
							<?php echo $this->Form->input('Characteristic.icon', array('type'=>'file','class'=>'default','label'=>false, 'div'=>false,));?>
						</span>
						<a href="javascript:void(0);" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">
							<i class="fa fa-trash"></i>&nbsp;
							<?php echo __('Remove');?>
						</a>
					</div>
				</div>
				<br />
				<span class="label label-danger"><?php echo __('NOTE!');?></span>
				<span><?php echo __('Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only');?>
				</span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo __('Font Icon');?></label>
            <div class="col-sm-6">
                <div class="icon-picker" data-pickerid="fa" data-iconsets='{"fa":"<?php echo __('Select Icon'); ?>"}'>
					<?php echo $this->Form->input('Characteristic.icon_class', array('type'=>'hidden')); ?>
				</div>                      
            </div>
        </div>

		<div class="form-group">
			<label class="control-label col-sm-3 required">
				<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="<?php echo __('Invalid characters <>;=#{}');?>"> <?php echo __('Characteristic name');?>
				</span>
			</label>
			<div class="col-sm-6">
				<?php if (count($languages) > 1): ?>
					<div class="form-group">
				<?php endif ?>

				<?php foreach ($this->request->data['CharacteristicTranslation'] as $index => $characteristic): ?>
					<?php $id_lang = $characteristic['language_id']; ?>

					<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($characteristic['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
					<?php if (count($languages) > 1): ?>
						<div class="col-lg-9">
					<?php endif ?>
						<?php 
							$options = [
								'class' => 'form-control count-char',
								'label' => false,
								'div' => false,
								// 'value' => h($characteristic['characteristic_name']),
								'required' => 'required', # when edit they are all required.
								'placeholder' => __('Characteristic name'), 
								'data-minlength' => '0', 
								'data-maxlength' => '140',
							];

							echo $this->Form->input('CharacteristicTranslation.' . $index . '.id', ['type' => 'hidden', /*'value' => $characteristic['id']*/]); 

							echo $this->Form->input('CharacteristicTranslation.' . $index . '.language_id', ['type' => 'hidden', /*'value' => $characteristic['language_id']*/]); 

							echo $this->Form->input('CharacteristicTranslation.' . $index . '.characteristic_id', ['type' => 'hidden', /*'value' => $characteristic['characteristic_id']*/]); 

							echo $this->Form->input('CharacteristicTranslation.' . $index . '.characteristic_name', $options); 
						?>
					<?php if (count($languages) > 1): ?>
						</div>
						<div class="col-lg-2 dropdown">
							<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
								<?php echo h($characteristic['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<?php foreach ($languages as $key => $language): ?>
								<li>
									<a href="javascript:hideOtherLanguage(<?php echo $language['Language']['id']; ?>);" tabindex="-1" data-value="<?php echo $language['Language']['language_code']; ?>">
										<?php echo h($language['Language']['name']); ?>
									</a>
								</li>
								<?php endforeach ?>
							</ul>
						</div>
					<?php endif ?>
					</div>
				<?php endforeach ?>

				<?php if (count($languages) > 1): ?>
					</div>
				<?php endif ?>
			</div>
		</div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <?php echo $this->Form->submit(__('Update'), array('class'=>'btn btn-info','label'=>false,'div'=>false)); ?>
                <?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</article>
<!-- page end-->
<div class="fa-set icon-set">
	<ul>
		<li  data-class="fa fa-adjust" class="fa fa-adjust"></li>
		<li  data-class="fa fa-adn" class="fa fa-adn"></li>
		<li  data-class="fa fa-align-center" class="fa fa-align-center"></li>
		<li  data-class="fa fa-align-justify" class="fa fa-align-justify"></li>
		<li  data-class="fa fa-align-left" class="fa fa-align-left"></li>
		<li  data-class="fa fa-align-right" class="fa fa-align-right"></li>
		<li  data-class="fa fa-ambulance" class="fa fa-ambulance"></li>
		<li  data-class="fa fa-anchor" class="fa fa-anchor"></li>
		<li  data-class="fa fa-android" class="fa fa-android"></li>
		<li  data-class="fa fa-angle-double-down" class="fa fa-angle-double-down"></li>
		<li  data-class="fa fa-angle-double-left" class="fa fa-angle-double-left"></li>
		<li  data-class="fa fa-angle-double-right" class="fa fa-angle-double-right"></li>
		<li  data-class="fa fa-angle-double-up" class="fa fa-angle-double-up"></li>
		<li  data-class="fa fa-angle-down" class="fa fa-angle-down"></li>
		<li  data-class="fa fa-angle-left" class="fa fa-angle-left"></li>
		<li  data-class="fa fa-angle-right" class="fa fa-angle-right"></li>
		<li  data-class="fa fa-angle-up" class="fa fa-angle-up"></li>
		<li  data-class="fa fa-apple" class="fa fa-apple"></li>
		<li  data-class="fa fa-archive" class="fa fa-archive"></li>
		<li  data-class="fa fa-arrow-circle-down" class="fa fa-arrow-circle-down"></li>
		<li  data-class="fa fa-arrow-circle-left" class="fa fa-arrow-circle-left"></li>
		<li  data-class="fa fa-arrow-circle-o-down" class="fa fa-arrow-circle-o-down"></li>
		<li  data-class="fa fa-arrow-circle-o-left" class="fa fa-arrow-circle-o-left"></li>
		<li  data-class="fa fa-arrow-circle-o-right" class="fa fa-arrow-circle-o-right"></li>
		<li  data-class="fa fa-arrow-circle-o-up" class="fa fa-arrow-circle-o-up"></li>
		<li  data-class="fa fa-arrow-circle-right" class="fa fa-arrow-circle-right"></li>
		<li  data-class="fa fa-arrow-circle-up" class="fa fa-arrow-circle-up"></li>
		<li  data-class="fa fa-arrow-down" class="fa fa-arrow-down"></li>
		<li  data-class="fa fa-arrow-left" class="fa fa-arrow-left"></li>
		<li  data-class="fa fa-arrow-right" class="fa fa-arrow-right"></li>
		<li  data-class="fa fa-arrow-up" class="fa fa-arrow-up"></li>
		<li  data-class="fa fa-arrows" class="fa fa-arrows"></li>
		<li  data-class="fa fa-arrows-alt" class="fa fa-arrows-alt"></li>
		<li  data-class="fa fa-arrows-h" class="fa fa-arrows-h"></li>
		<li  data-class="fa fa-arrows-v" class="fa fa-arrows-v"></li>
		<li  data-class="fa fa-asterisk" class="fa fa-asterisk"></li>
		<li  data-class="fa fa-automobile" class="fa fa-automobile"></li>
		<li  data-class="fa fa-backward" class="fa fa-backward"></li>
		<li  data-class="fa fa-ban" class="fa fa-ban"></li>
		<li  data-class="fa fa-bank" class="fa fa-bank"></li>
		<li  data-class="fa fa-bar-chart-o" class="fa fa-bar-chart-o"></li>
		<li  data-class="fa fa-barcode" class="fa fa-barcode"></li>
		<li  data-class="fa fa-bars" class="fa fa-bars"></li>
		<li  data-class="fa fa-beer" class="fa fa-beer"></li>
		<li  data-class="fa fa-behance" class="fa fa-behance"></li>
		<li  data-class="fa fa-behance-square" class="fa fa-behance-square"></li>
		<li  data-class="fa fa-bell" class="fa fa-bell"></li>
		<li  data-class="fa fa-bell-o" class="fa fa-bell-o"></li>
		<li  data-class="fa fa-bitbucket" class="fa fa-bitbucket"></li>
		<li  data-class="fa fa-bitbucket-square" class="fa fa-bitbucket-square"></li>
		<li  data-class="fa fa-bitcoin" class="fa fa-bitcoin"></li>
		<li  data-class="fa fa-bold" class="fa fa-bold"></li>
		<li  data-class="fa fa-bolt" class="fa fa-bolt"></li>
		<li  data-class="fa fa-bomb" class="fa fa-bomb"></li>
		<li  data-class="fa fa-book" class="fa fa-book"></li>
		<li  data-class="fa fa-bookmark" class="fa fa-bookmark"></li>
		<li  data-class="fa fa-bookmark-o" class="fa fa-bookmark-o"></li>
		<li  data-class="fa fa-briefcase" class="fa fa-briefcase"></li>
		<li  data-class="fa fa-btc" class="fa fa-btc"></li>
		<li  data-class="fa fa-bug" class="fa fa-bug"></li>
		<li  data-class="fa fa-building" class="fa fa-building"></li>
		<li  data-class="fa fa-building-o" class="fa fa-building-o"></li>
		<li  data-class="fa fa-bullhorn" class="fa fa-bullhorn"></li>
		<li  data-class="fa fa-bullseye" class="fa fa-bullseye"></li>
		<li  data-class="fa fa-cab" class="fa fa-cab"></li>
		<li  data-class="fa fa-calendar" class="fa fa-calendar"></li>
		<li  data-class="fa fa-calendar-o" class="fa fa-calendar-o"></li>
		<li  data-class="fa fa-camera" class="fa fa-camera"></li>
		<li  data-class="fa fa-camera-retro" class="fa fa-camera-retro"></li>
		<li  data-class="fa fa-car" class="fa fa-car"></li>
		<li  data-class="fa fa-caret-down" class="fa fa-caret-down"></li>
		<li  data-class="fa fa-caret-left" class="fa fa-caret-left"></li>
		<li  data-class="fa fa-caret-right" class="fa fa-caret-right"></li>
		<li  data-class="fa fa-caret-square-o-down" class="fa fa-caret-square-o-down"></li>
		<li  data-class="fa fa-caret-square-o-left" class="fa fa-caret-square-o-left"></li>
		<li  data-class="fa fa-caret-square-o-right" class="fa fa-caret-square-o-right"></li>
		<li  data-class="fa fa-caret-square-o-up" class="fa fa-caret-square-o-up"></li>
		<li  data-class="fa fa-caret-up" class="fa fa-caret-up"></li>
		<li  data-class="fa fa-certificate" class="fa fa-certificate"></li>
		<li  data-class="fa fa-chain" class="fa fa-chain"></li>
		<li  data-class="fa fa-chain-broken" class="fa fa-chain-broken"></li>
		<li  data-class="fa fa-check" class="fa fa-check"></li>
		<li  data-class="fa fa-check-circle" class="fa fa-check-circle"></li>
		<li  data-class="fa fa-check-circle-o" class="fa fa-check-circle-o"></li>
		<li  data-class="fa fa-check-square" class="fa fa-check-square"></li>
		<li  data-class="fa fa-check-square-o" class="fa fa-check-square-o"></li>
		<li  data-class="fa fa-chevron-circle-down" class="fa fa-chevron-circle-down"></li>
		<li  data-class="fa fa-chevron-circle-left" class="fa fa-chevron-circle-left"></li>
		<li  data-class="fa fa-chevron-circle-right" class="fa fa-chevron-circle-right"></li>
		<li  data-class="fa fa-chevron-circle-up" class="fa fa-chevron-circle-up"></li>
		<li  data-class="fa fa-chevron-down" class="fa fa-chevron-down"></li>
		<li  data-class="fa fa-chevron-left" class="fa fa-chevron-left"></li>
		<li  data-class="fa fa-chevron-right" class="fa fa-chevron-right"></li>
		<li  data-class="fa fa-chevron-up" class="fa fa-chevron-up"></li>
		<li  data-class="fa fa-child" class="fa fa-child"></li>
		<li  data-class="fa fa-circle" class="fa fa-circle"></li>
		<li  data-class="fa fa-circle-o" class="fa fa-circle-o"></li>
		<li  data-class="fa fa-circle-o-notch" class="fa fa-circle-o-notch"></li>
		<li  data-class="fa fa-circle-thin" class="fa fa-circle-thin"></li>
		<li  data-class="fa fa-clipboard" class="fa fa-clipboard"></li>
		<li  data-class="fa fa-clock-o" class="fa fa-clock-o"></li>
		<li  data-class="fa fa-cloud" class="fa fa-cloud"></li>
		<li  data-class="fa fa-cloud-download" class="fa fa-cloud-download"></li>
		<li  data-class="fa fa-cloud-upload" class="fa fa-cloud-upload"></li>
		<li  data-class="fa fa-cny" class="fa fa-cny"></li>
		<li  data-class="fa fa-code" class="fa fa-code"></li>
		<li  data-class="fa fa-code-fork" class="fa fa-code-fork"></li>
		<li  data-class="fa fa-codepen" class="fa fa-codepen"></li>
		<li  data-class="fa fa-coffee" class="fa fa-coffee"></li>
		<li  data-class="fa fa-cog" class="fa fa-cog"></li>
		<li  data-class="fa fa-cogs" class="fa fa-cogs"></li>
		<li  data-class="fa fa-columns" class="fa fa-columns"></li>
		<li  data-class="fa fa-comment" class="fa fa-comment"></li>
		<li  data-class="fa fa-comment-o" class="fa fa-comment-o"></li>
		<li  data-class="fa fa-comments" class="fa fa-comments"></li>
		<li  data-class="fa fa-comments-o" class="fa fa-comments-o"></li>
		<li  data-class="fa fa-compass" class="fa fa-compass"></li>
		<li  data-class="fa fa-compress" class="fa fa-compress"></li>
		<li  data-class="fa fa-copy" class="fa fa-copy"></li>
		<li  data-class="fa fa-credit-card" class="fa fa-credit-card"></li>
		<li  data-class="fa fa-crop" class="fa fa-crop"></li>
		<li  data-class="fa fa-crosshairs" class="fa fa-crosshairs"></li>
		<li  data-class="fa fa-css3" class="fa fa-css3"></li>
		<li  data-class="fa fa-cube" class="fa fa-cube"></li>
		<li  data-class="fa fa-cubes" class="fa fa-cubes"></li>
		<li  data-class="fa fa-cut" class="fa fa-cut"></li>
		<li  data-class="fa fa-cutlery" class="fa fa-cutlery"></li>
		<li  data-class="fa fa-dashboard" class="fa fa-dashboard"></li>
		<li  data-class="fa fa-database" class="fa fa-database"></li>
		<li  data-class="fa fa-dedent" class="fa fa-dedent"></li>
		<li  data-class="fa fa-delicious" class="fa fa-delicious"></li>
		<li  data-class="fa fa-desktop" class="fa fa-desktop"></li>
		<li  data-class="fa fa-deviantart" class="fa fa-deviantart"></li>
		<li  data-class="fa fa-digg" class="fa fa-digg"></li>
		<li  data-class="fa fa-dollar" class="fa fa-dollar"></li>
		<li  data-class="fa fa-dot-circle-o" class="fa fa-dot-circle-o"></li>
		<li  data-class="fa fa-download" class="fa fa-download"></li>
		<li  data-class="fa fa-dribbble" class="fa fa-dribbble"></li>
		<li  data-class="fa fa-dropbox" class="fa fa-dropbox"></li>
		<li  data-class="fa fa-drupal" class="fa fa-drupal"></li>
		<li  data-class="fa fa-edit" class="fa fa-edit"></li>
		<li  data-class="fa fa-eject" class="fa fa-eject"></li>
		<li  data-class="fa fa-ellipsis-h" class="fa fa-ellipsis-h"></li>
		<li  data-class="fa fa-ellipsis-v" class="fa fa-ellipsis-v"></li>
		<li  data-class="fa fa-empire" class="fa fa-empire"></li>
		<li  data-class="fa fa-envelope" class="fa fa-envelope"></li>
		<li  data-class="fa fa-envelope-o" class="fa fa-envelope-o"></li>
		<li  data-class="fa fa-envelope-square" class="fa fa-envelope-square"></li>
		<li  data-class="fa fa-eraser" class="fa fa-eraser"></li>
		<li  data-class="fa fa-eur" class="fa fa-eur"></li>
		<li  data-class="fa fa-euro" class="fa fa-euro"></li>
		<li  data-class="fa fa-exchange" class="fa fa-exchange"></li>
		<li  data-class="fa fa-exclamation" class="fa fa-exclamation"></li>
		<li  data-class="fa fa-exclamation-circle" class="fa fa-exclamation-circle"></li>
		<li  data-class="fa fa-exclamation-triangle" class="fa fa-exclamation-triangle"></li>
		<li  data-class="fa fa-expand" class="fa fa-expand"></li>
		<li  data-class="fa fa-external-link" class="fa fa-external-link"></li>
		<li  data-class="fa fa-external-link-square" class="fa fa-external-link-square"></li>
		<li  data-class="fa fa-eye" class="fa fa-eye"></li>
		<li  data-class="fa fa-eye-slash" class="fa fa-eye-slash"></li>
		<li  data-class="fa fa-facebook" class="fa fa-facebook"></li>
		<li  data-class="fa fa-facebook-square" class="fa fa-facebook-square"></li>
		<li  data-class="fa fa-fast-backward" class="fa fa-fast-backward"></li>
		<li  data-class="fa fa-fast-forward" class="fa fa-fast-forward"></li>
		<li  data-class="fa fa-fax" class="fa fa-fax"></li>
		<li  data-class="fa fa-female" class="fa fa-female"></li>
		<li  data-class="fa fa-fighter-jet" class="fa fa-fighter-jet"></li>
		<li  data-class="fa fa-file" class="fa fa-file"></li>
		<li  data-class="fa fa-file-archive-o" class="fa fa-file-archive-o"></li>
		<li  data-class="fa fa-file-audio-o" class="fa fa-file-audio-o"></li>
		<li  data-class="fa fa-file-code-o" class="fa fa-file-code-o"></li>
		<li  data-class="fa fa-file-excel-o" class="fa fa-file-excel-o"></li>
		<li  data-class="fa fa-file-image-o" class="fa fa-file-image-o"></li>
		<li  data-class="fa fa-file-movie-o" class="fa fa-file-movie-o"></li>
		<li  data-class="fa fa-file-o" class="fa fa-file-o"></li>
		<li  data-class="fa fa-file-pdf-o" class="fa fa-file-pdf-o"></li>
		<li  data-class="fa fa-file-photo-o" class="fa fa-file-photo-o"></li>
		<li  data-class="fa fa-file-picture-o" class="fa fa-file-picture-o"></li>
		<li  data-class="fa fa-file-powerpoint-o" class="fa fa-file-powerpoint-o"></li>
		<li  data-class="fa fa-file-sound-o" class="fa fa-file-sound-o"></li>
		<li  data-class="fa fa-file-text" class="fa fa-file-text"></li>
		<li  data-class="fa fa-file-text-o" class="fa fa-file-text-o"></li>
		<li  data-class="fa fa-file-video-o" class="fa fa-file-video-o"></li>
		<li  data-class="fa fa-file-word-o" class="fa fa-file-word-o"></li>
		<li  data-class="fa fa-file-zip-o" class="fa fa-file-zip-o"></li>
		<li  data-class="fa fa-files-o" class="fa fa-files-o"></li>
		<li  data-class="fa fa-film" class="fa fa-film"></li>
		<li  data-class="fa fa-filter" class="fa fa-filter"></li>
		<li  data-class="fa fa-fire" class="fa fa-fire"></li>
		<li  data-class="fa fa-fire-extinguisher" class="fa fa-fire-extinguisher"></li>
		<li  data-class="fa fa-flag" class="fa fa-flag"></li>
		<li  data-class="fa fa-flag-checkered" class="fa fa-flag-checkered"></li>
		<li  data-class="fa fa-flag-o" class="fa fa-flag-o"></li>
		<li  data-class="fa fa-flash" class="fa fa-flash"></li>
		<li  data-class="fa fa-flask" class="fa fa-flask"></li>
		<li  data-class="fa fa-flickr" class="fa fa-flickr"></li>
		<li  data-class="fa fa-floppy-o" class="fa fa-floppy-o"></li>
		<li  data-class="fa fa-folder" class="fa fa-folder"></li>
		<li  data-class="fa fa-folder-o" class="fa fa-folder-o"></li>
		<li  data-class="fa fa-folder-open" class="fa fa-folder-open"></li>
		<li  data-class="fa fa-folder-open-o" class="fa fa-folder-open-o"></li>
		<li  data-class="fa fa-font" class="fa fa-font"></li>
		<li  data-class="fa fa-forward" class="fa fa-forward"></li>
		<li  data-class="fa fa-foursquare" class="fa fa-foursquare"></li>
		<li  data-class="fa fa-frown-o" class="fa fa-frown-o"></li>
		<li  data-class="fa fa-gamepad" class="fa fa-gamepad"></li>
		<li  data-class="fa fa-gavel" class="fa fa-gavel"></li>
		<li  data-class="fa fa-gbp" class="fa fa-gbp"></li>
		<li  data-class="fa fa-ge" class="fa fa-ge"></li>
		<li  data-class="fa fa-gear" class="fa fa-gear"></li>
		<li  data-class="fa fa-gears" class="fa fa-gears"></li>
		<li  data-class="fa fa-gift" class="fa fa-gift"></li>
		<li  data-class="fa fa-git" class="fa fa-git"></li>
		<li  data-class="fa fa-git-square" class="fa fa-git-square"></li>
		<li  data-class="fa fa-github" class="fa fa-github"></li>
		<li  data-class="fa fa-github-alt" class="fa fa-github-alt"></li>
		<li  data-class="fa fa-github-square" class="fa fa-github-square"></li>
		<li  data-class="fa fa-gittip" class="fa fa-gittip"></li>
		<li  data-class="fa fa-glass" class="fa fa-glass"></li>
		<li  data-class="fa fa-globe" class="fa fa-globe"></li>
		<li  data-class="fa fa-google" class="fa fa-google"></li>
		<li  data-class="fa fa-google-plus" class="fa fa-google-plus"></li>
		<li  data-class="fa fa-google-plus-square" class="fa fa-google-plus-square"></li>
		<li  data-class="fa fa-graduation-cap" class="fa fa-graduation-cap"></li>
		<li  data-class="fa fa-group" class="fa fa-group"></li>
		<li  data-class="fa fa-h-square" class="fa fa-h-square"></li>
		<li  data-class="fa fa-hacker-news" class="fa fa-hacker-news"></li>
		<li  data-class="fa fa-hand-o-down" class="fa fa-hand-o-down"></li>
		<li  data-class="fa fa-hand-o-left" class="fa fa-hand-o-left"></li>
		<li  data-class="fa fa-hand-o-right" class="fa fa-hand-o-right"></li>
		<li  data-class="fa fa-hand-o-up" class="fa fa-hand-o-up"></li>
		<li  data-class="fa fa-hdd-o" class="fa fa-hdd-o"></li>
		<li  data-class="fa fa-header" class="fa fa-header"></li>
		<li  data-class="fa fa-headphones" class="fa fa-headphones"></li>
		<li  data-class="fa fa-heart" class="fa fa-heart"></li>
		<li  data-class="fa fa-heart-o" class="fa fa-heart-o"></li>
		<li  data-class="fa fa-history" class="fa fa-history"></li>
		<li  data-class="fa fa-home" class="fa fa-home"></li>
		<li  data-class="fa fa-hospital-o" class="fa fa-hospital-o"></li>
		<li  data-class="fa fa-html5" class="fa fa-html5"></li>
		<li  data-class="fa fa-image" class="fa fa-image"></li>
		<li  data-class="fa fa-inbox" class="fa fa-inbox"></li>
		<li  data-class="fa fa-indent" class="fa fa-indent"></li>
		<li  data-class="fa fa-info" class="fa fa-info"></li>
		<li  data-class="fa fa-info-circle" class="fa fa-info-circle"></li>
		<li  data-class="fa fa-inr" class="fa fa-inr"></li>
		<li  data-class="fa fa-instagram" class="fa fa-instagram"></li>
		<li  data-class="fa fa-institution" class="fa fa-institution"></li>
		<li  data-class="fa fa-italic" class="fa fa-italic"></li>
		<li  data-class="fa fa-joomla" class="fa fa-joomla"></li>
		<li  data-class="fa fa-jpy" class="fa fa-jpy"></li>
		<li  data-class="fa fa-jsfiddle" class="fa fa-jsfiddle"></li>
		<li  data-class="fa fa-key" class="fa fa-key"></li>
		<li  data-class="fa fa-keyboard-o" class="fa fa-keyboard-o"></li>
		<li  data-class="fa fa-krw" class="fa fa-krw"></li>
		<li  data-class="fa fa-language" class="fa fa-language"></li>
		<li  data-class="fa fa-laptop" class="fa fa-laptop"></li>
		<li  data-class="fa fa-leaf" class="fa fa-leaf"></li>
		<li  data-class="fa fa-legal" class="fa fa-legal"></li>
		<li  data-class="fa fa-lemon-o" class="fa fa-lemon-o"></li>
		<li  data-class="fa fa-level-down" class="fa fa-level-down"></li>
		<li  data-class="fa fa-level-up" class="fa fa-level-up"></li>
		<li  data-class="fa fa-life-bouy" class="fa fa-life-bouy"></li>
		<li  data-class="fa fa-life-ring" class="fa fa-life-ring"></li>
		<li  data-class="fa fa-life-saver" class="fa fa-life-saver"></li>
		<li  data-class="fa fa-lightbulb-o" class="fa fa-lightbulb-o"></li>
		<li  data-class="fa fa-link" class="fa fa-link"></li>
		<li  data-class="fa fa-linkedin" class="fa fa-linkedin"></li>
		<li  data-class="fa fa-linkedin-square" class="fa fa-linkedin-square"></li>
		<li  data-class="fa fa-linux" class="fa fa-linux"></li>
		<li  data-class="fa fa-list" class="fa fa-list"></li>
		<li  data-class="fa fa-list-alt" class="fa fa-list-alt"></li>
		<li  data-class="fa fa-list-ol" class="fa fa-list-ol"></li>
		<li  data-class="fa fa-list-ul" class="fa fa-list-ul"></li>
		<li  data-class="fa fa-location-arrow" class="fa fa-location-arrow"></li>
		<li  data-class="fa fa-lock" class="fa fa-lock"></li>
		<li  data-class="fa fa-long-arrow-down" class="fa fa-long-arrow-down"></li>
		<li  data-class="fa fa-long-arrow-left" class="fa fa-long-arrow-left"></li>
		<li  data-class="fa fa-long-arrow-right" class="fa fa-long-arrow-right"></li>
		<li  data-class="fa fa-long-arrow-up" class="fa fa-long-arrow-up"></li>
		<li  data-class="fa fa-magic" class="fa fa-magic"></li>
		<li  data-class="fa fa-magnet" class="fa fa-magnet"></li>
		<li  data-class="fa fa-mail-forward" class="fa fa-mail-forward"></li>
		<li  data-class="fa fa-mail-reply" class="fa fa-mail-reply"></li>
		<li  data-class="fa fa-mail-reply-all" class="fa fa-mail-reply-all"></li>
		<li  data-class="fa fa-male" class="fa fa-male"></li>
		<li  data-class="fa fa-map-marker" class="fa fa-map-marker"></li>
		<li  data-class="fa fa-maxcdn" class="fa fa-maxcdn"></li>
		<li  data-class="fa fa-medkit" class="fa fa-medkit"></li>
		<li  data-class="fa fa-meh-o" class="fa fa-meh-o"></li>
		<li  data-class="fa fa-microphone" class="fa fa-microphone"></li>
		<li  data-class="fa fa-microphone-slash" class="fa fa-microphone-slash"></li>
		<li  data-class="fa fa-minus" class="fa fa-minus"></li>
		<li  data-class="fa fa-minus-circle" class="fa fa-minus-circle"></li>
		<li  data-class="fa fa-minus-square" class="fa fa-minus-square"></li>
		<li  data-class="fa fa-minus-square-o" class="fa fa-minus-square-o"></li>
		<li  data-class="fa fa-mobile" class="fa fa-mobile"></li>
		<li  data-class="fa fa-mobile-phone" class="fa fa-mobile-phone"></li>
		<li  data-class="fa fa-money" class="fa fa-money"></li>
		<li  data-class="fa fa-moon-o" class="fa fa-moon-o"></li>
		<li  data-class="fa fa-mortar-board" class="fa fa-mortar-board"></li>
		<li  data-class="fa fa-music" class="fa fa-music"></li>
		<li  data-class="fa fa-navicon" class="fa fa-navicon"></li>
		<li  data-class="fa fa-openid" class="fa fa-openid"></li>
		<li  data-class="fa fa-outdent" class="fa fa-outdent"></li>
		<li  data-class="fa fa-pagelines" class="fa fa-pagelines"></li>
		<li  data-class="fa fa-paper-plane" class="fa fa-paper-plane"></li>
		<li  data-class="fa fa-paper-plane-o" class="fa fa-paper-plane-o"></li>
		<li  data-class="fa fa-paperclip" class="fa fa-paperclip"></li>
		<li  data-class="fa fa-paragraph" class="fa fa-paragraph"></li>
		<li  data-class="fa fa-paste" class="fa fa-paste"></li>
		<li  data-class="fa fa-pause" class="fa fa-pause"></li>
		<li  data-class="fa fa-paw" class="fa fa-paw"></li>
		<li  data-class="fa fa-pencil" class="fa fa-pencil"></li>
		<li  data-class="fa fa-pencil-square" class="fa fa-pencil-square"></li>
		<li  data-class="fa fa-pencil-square-o" class="fa fa-pencil-square-o"></li>
		<li  data-class="fa fa-phone" class="fa fa-phone"></li>
		<li  data-class="fa fa-phone-square" class="fa fa-phone-square"></li>
		<li  data-class="fa fa-photo" class="fa fa-photo"></li>
		<li  data-class="fa fa-picture-o" class="fa fa-picture-o"></li>
		<li  data-class="fa fa-pied-piper" class="fa fa-pied-piper"></li>
		<li  data-class="fa fa-pied-piper-alt" class="fa fa-pied-piper-alt"></li>
		<li  data-class="fa fa-pied-piper-square" class="fa fa-pied-piper-square"></li>
		<li  data-class="fa fa-pinterest" class="fa fa-pinterest"></li>
		<li  data-class="fa fa-pinterest-square" class="fa fa-pinterest-square"></li>
		<li  data-class="fa fa-plane" class="fa fa-plane"></li>
		<li  data-class="fa fa-play" class="fa fa-play"></li>
		<li  data-class="fa fa-play-circle" class="fa fa-play-circle"></li>
		<li  data-class="fa fa-play-circle-o" class="fa fa-play-circle-o"></li>
		<li  data-class="fa fa-plus" class="fa fa-plus"></li>
		<li  data-class="fa fa-plus-circle" class="fa fa-plus-circle"></li>
		<li  data-class="fa fa-plus-square" class="fa fa-plus-square"></li>
		<li  data-class="fa fa-plus-square-o" class="fa fa-plus-square-o"></li>
		<li  data-class="fa fa-power-off" class="fa fa-power-off"></li>
		<li  data-class="fa fa-print" class="fa fa-print"></li>
		<li  data-class="fa fa-puzzle-piece" class="fa fa-puzzle-piece"></li>
		<li  data-class="fa fa-qq" class="fa fa-qq"></li>
		<li  data-class="fa fa-qrcode" class="fa fa-qrcode"></li>
		<li  data-class="fa fa-question" class="fa fa-question"></li>
		<li  data-class="fa fa-question-circle" class="fa fa-question-circle"></li>
		<li  data-class="fa fa-quote-left" class="fa fa-quote-left"></li>
		<li  data-class="fa fa-quote-right" class="fa fa-quote-right"></li>
		<li  data-class="fa fa-ra" class="fa fa-ra"></li>
		<li  data-class="fa fa-random" class="fa fa-random"></li>
		<li  data-class="fa fa-rebel" class="fa fa-rebel"></li>
		<li  data-class="fa fa-recycle" class="fa fa-recycle"></li>
		<li  data-class="fa fa-reddit" class="fa fa-reddit"></li>
		<li  data-class="fa fa-reddit-square" class="fa fa-reddit-square"></li>
		<li  data-class="fa fa-refresh" class="fa fa-refresh"></li>
		<li  data-class="fa fa-renren" class="fa fa-renren"></li>
		<li  data-class="fa fa-reorder" class="fa fa-reorder"></li>
		<li  data-class="fa fa-repeat" class="fa fa-repeat"></li>
		<li  data-class="fa fa-reply" class="fa fa-reply"></li>
		<li  data-class="fa fa-reply-all" class="fa fa-reply-all"></li>
		<li  data-class="fa fa-retweet" class="fa fa-retweet"></li>
		<li  data-class="fa fa-rmb" class="fa fa-rmb"></li>
		<li  data-class="fa fa-road" class="fa fa-road"></li>
		<li  data-class="fa fa-rocket" class="fa fa-rocket"></li>
		<li  data-class="fa fa-rotate-left" class="fa fa-rotate-left"></li>
		<li  data-class="fa fa-rotate-right" class="fa fa-rotate-right"></li>
		<li  data-class="fa fa-rouble" class="fa fa-rouble"></li>
		<li  data-class="fa fa-rss" class="fa fa-rss"></li>
		<li  data-class="fa fa-rss-square" class="fa fa-rss-square"></li>
		<li  data-class="fa fa-rub" class="fa fa-rub"></li>
		<li  data-class="fa fa-ruble" class="fa fa-ruble"></li>
		<li  data-class="fa fa-rupee" class="fa fa-rupee"></li>
		<li  data-class="fa fa-save" class="fa fa-save"></li>
		<li  data-class="fa fa-scissors" class="fa fa-scissors"></li>
		<li  data-class="fa fa-search" class="fa fa-search"></li>
		<li  data-class="fa fa-search-minus" class="fa fa-search-minus"></li>
		<li  data-class="fa fa-search-plus" class="fa fa-search-plus"></li>
		<li  data-class="fa fa-send" class="fa fa-send"></li>
		<li  data-class="fa fa-send-o" class="fa fa-send-o"></li>
		<li  data-class="fa fa-share" class="fa fa-share"></li>
		<li  data-class="fa fa-share-alt" class="fa fa-share-alt"></li>
		<li  data-class="fa fa-share-alt-square" class="fa fa-share-alt-square"></li>
		<li  data-class="fa fa-share-square" class="fa fa-share-square"></li>
		<li  data-class="fa fa-share-square-o" class="fa fa-share-square-o"></li>
		<li  data-class="fa fa-shield" class="fa fa-shield"></li>
		<li  data-class="fa fa-shopping-cart" class="fa fa-shopping-cart"></li>
		<li  data-class="fa fa-sign-in" class="fa fa-sign-in"></li>
		<li  data-class="fa fa-sign-out" class="fa fa-sign-out"></li>
		<li  data-class="fa fa-signal" class="fa fa-signal"></li>
		<li  data-class="fa fa-sitemap" class="fa fa-sitemap"></li>
		<li  data-class="fa fa-skype" class="fa fa-skype"></li>
		<li  data-class="fa fa-slack" class="fa fa-slack"></li>
		<li  data-class="fa fa-sliders" class="fa fa-sliders"></li>
		<li  data-class="fa fa-smile-o" class="fa fa-smile-o"></li>
		<li  data-class="fa fa-sort" class="fa fa-sort"></li>
		<li  data-class="fa fa-sort-alpha-asc" class="fa fa-sort-alpha-asc"></li>
		<li  data-class="fa fa-sort-alpha-desc" class="fa fa-sort-alpha-desc"></li>
		<li  data-class="fa fa-sort-amount-asc" class="fa fa-sort-amount-asc"></li>
		<li  data-class="fa fa-sort-amount-desc" class="fa fa-sort-amount-desc"></li>
		<li  data-class="fa fa-sort-asc" class="fa fa-sort-asc"></li>
		<li  data-class="fa fa-sort-desc" class="fa fa-sort-desc"></li>
		<li  data-class="fa fa-sort-down" class="fa fa-sort-down"></li>
		<li  data-class="fa fa-sort-numeric-asc" class="fa fa-sort-numeric-asc"></li>
		<li  data-class="fa fa-sort-numeric-desc" class="fa fa-sort-numeric-desc"></li>
		<li  data-class="fa fa-sort-up" class="fa fa-sort-up"></li>
		<li  data-class="fa fa-soundcloud" class="fa fa-soundcloud"></li>
		<li  data-class="fa fa-space-shuttle" class="fa fa-space-shuttle"></li>
		<li  data-class="fa fa-spinner" class="fa fa-spinner"></li>
		<li  data-class="fa fa-spoon" class="fa fa-spoon"></li>
		<li  data-class="fa fa-spotify" class="fa fa-spotify"></li>
		<li  data-class="fa fa-square" class="fa fa-square"></li>
		<li  data-class="fa fa-square-o" class="fa fa-square-o"></li>
		<li  data-class="fa fa-stack-exchange" class="fa fa-stack-exchange"></li>
		<li  data-class="fa fa-stack-overflow" class="fa fa-stack-overflow"></li>
		<li  data-class="fa fa-star" class="fa fa-star"></li>
		<li  data-class="fa fa-star-half" class="fa fa-star-half"></li>
		<li  data-class="fa fa-star-half-empty" class="fa fa-star-half-empty"></li>
		<li  data-class="fa fa-star-half-full" class="fa fa-star-half-full"></li>
		<li  data-class="fa fa-star-half-o" class="fa fa-star-half-o"></li>
		<li  data-class="fa fa-star-o" class="fa fa-star-o"></li>
		<li  data-class="fa fa-steam" class="fa fa-steam"></li>
		<li  data-class="fa fa-steam-square" class="fa fa-steam-square"></li>
		<li  data-class="fa fa-step-backward" class="fa fa-step-backward"></li>
		<li  data-class="fa fa-step-forward" class="fa fa-step-forward"></li>
		<li  data-class="fa fa-stethoscope" class="fa fa-stethoscope"></li>
		<li  data-class="fa fa-stop" class="fa fa-stop"></li>
		<li  data-class="fa fa-strikethrough" class="fa fa-strikethrough"></li>
		<li  data-class="fa fa-stumbleupon" class="fa fa-stumbleupon"></li>
		<li  data-class="fa fa-stumbleupon-circle" class="fa fa-stumbleupon-circle"></li>
		<li  data-class="fa fa-subscript" class="fa fa-subscript"></li>
		<li  data-class="fa fa-suitcase" class="fa fa-suitcase"></li>
		<li  data-class="fa fa-sun-o" class="fa fa-sun-o"></li>
		<li  data-class="fa fa-superscript" class="fa fa-superscript"></li>
		<li  data-class="fa fa-support" class="fa fa-support"></li>
		<li  data-class="fa fa-table" class="fa fa-table"></li>
		<li  data-class="fa fa-tablet" class="fa fa-tablet"></li>
		<li  data-class="fa fa-tachometer" class="fa fa-tachometer"></li>
		<li  data-class="fa fa-tag" class="fa fa-tag"></li>
		<li  data-class="fa fa-tags" class="fa fa-tags"></li>
		<li  data-class="fa fa-tasks" class="fa fa-tasks"></li>
		<li  data-class="fa fa-taxi" class="fa fa-taxi"></li>
		<li  data-class="fa fa-tencent-weibo" class="fa fa-tencent-weibo"></li>
		<li  data-class="fa fa-terminal" class="fa fa-terminal"></li>
		<li  data-class="fa fa-text-height" class="fa fa-text-height"></li>
		<li  data-class="fa fa-text-width" class="fa fa-text-width"></li>
		<li  data-class="fa fa-th" class="fa fa-th"></li>
		<li  data-class="fa fa-th-large" class="fa fa-th-large"></li>
		<li  data-class="fa fa-th-list" class="fa fa-th-list"></li>
		<li  data-class="fa fa-thumb-tack" class="fa fa-thumb-tack"></li>
		<li  data-class="fa fa-thumbs-down" class="fa fa-thumbs-down"></li>
		<li  data-class="fa fa-thumbs-o-down" class="fa fa-thumbs-o-down"></li>
		<li  data-class="fa fa-thumbs-o-up" class="fa fa-thumbs-o-up"></li>
		<li  data-class="fa fa-thumbs-up" class="fa fa-thumbs-up"></li>
		<li  data-class="fa fa-ticket" class="fa fa-ticket"></li>
		<li  data-class="fa fa-times" class="fa fa-times"></li>
		<li  data-class="fa fa-times-circle" class="fa fa-times-circle"></li>
		<li  data-class="fa fa-times-circle-o" class="fa fa-times-circle-o"></li>
		<li  data-class="fa fa-tint" class="fa fa-tint"></li>
		<li  data-class="fa fa-toggle-down" class="fa fa-toggle-down"></li>
		<li  data-class="fa fa-toggle-left" class="fa fa-toggle-left"></li>
		<li  data-class="fa fa-toggle-right" class="fa fa-toggle-right"></li>
		<li  data-class="fa fa-toggle-up" class="fa fa-toggle-up"></li>
		<li  data-class="fa fa-trash-o" class="fa fa-trash-o"></li>
		<li  data-class="fa fa-tree" class="fa fa-tree"></li>
		<li  data-class="fa fa-trello" class="fa fa-trello"></li>
		<li  data-class="fa fa-trophy" class="fa fa-trophy"></li>
		<li  data-class="fa fa-truck" class="fa fa-truck"></li>
		<li  data-class="fa fa-try" class="fa fa-try"></li>
		<li  data-class="fa fa-tumblr" class="fa fa-tumblr"></li>
		<li  data-class="fa fa-tumblr-square" class="fa fa-tumblr-square"></li>
		<li  data-class="fa fa-turkish-lira" class="fa fa-turkish-lira"></li>
		<li  data-class="fa fa-twitter" class="fa fa-twitter"></li>
		<li  data-class="fa fa-twitter-square" class="fa fa-twitter-square"></li>
		<li  data-class="fa fa-umbrella" class="fa fa-umbrella"></li>
		<li  data-class="fa fa-underline" class="fa fa-underline"></li>
		<li  data-class="fa fa-undo" class="fa fa-undo"></li>
		<li  data-class="fa fa-university" class="fa fa-university"></li>
		<li  data-class="fa fa-unlink" class="fa fa-unlink"></li>
		<li  data-class="fa fa-unlock" class="fa fa-unlock"></li>
		<li  data-class="fa fa-unlock-alt" class="fa fa-unlock-alt"></li>
		<li  data-class="fa fa-unsorted" class="fa fa-unsorted"></li>
		<li  data-class="fa fa-upload" class="fa fa-upload"></li>
		<li  data-class="fa fa-usd" class="fa fa-usd"></li>
		<li  data-class="fa fa-user" class="fa fa-user"></li>
		<li  data-class="fa fa-user-md" class="fa fa-user-md"></li>
		<li  data-class="fa fa-users" class="fa fa-users"></li>
		<li  data-class="fa fa-video-camera" class="fa fa-video-camera"></li>
		<li  data-class="fa fa-vimeo-square" class="fa fa-vimeo-square"></li>
		<li  data-class="fa fa-vine" class="fa fa-vine"></li>
		<li  data-class="fa fa-vk" class="fa fa-vk"></li>
		<li  data-class="fa fa-volume-down" class="fa fa-volume-down"></li>
		<li  data-class="fa fa-volume-off" class="fa fa-volume-off"></li>
		<li  data-class="fa fa-volume-up" class="fa fa-volume-up"></li>
		<li  data-class="fa fa-warning" class="fa fa-warning"></li>
		<li  data-class="fa fa-wechat" class="fa fa-wechat"></li>
		<li  data-class="fa fa-weibo" class="fa fa-weibo"></li>
		<li  data-class="fa fa-weixin" class="fa fa-weixin"></li>
		<li  data-class="fa fa-wheelchair" class="fa fa-wheelchair"></li>
		<li  data-class="fa fa-windows" class="fa fa-windows"></li>
		<li  data-class="fa fa-won" class="fa fa-won"></li>
		<li  data-class="fa fa-wordpress" class="fa fa-wordpress"></li>
		<li  data-class="fa fa-wrench" class="fa fa-wrench"></li>
		<li  data-class="fa fa-xing" class="fa fa-xing"></li>
		<li  data-class="fa fa-xing-square" class="fa fa-xing-square"></li>
		<li  data-class="fa fa-yahoo" class="fa fa-yahoo"></li>
		<li  data-class="fa fa-yen" class="fa fa-yen"></li>
		<li  data-class="fa fa-youtube" class="fa fa-youtube"></li>
		<li  data-class="fa fa-youtube-play" class="fa fa-youtube-play"></li>
		<li  data-class="fa fa-youtube-square" class="fa fa-youtube-square"></li>
	</ul>
</div> 
<?php
	echo $this->Html->script('common/jasny-bootstrap.min', array('block'=>'scriptBottomMiddle')); 
	echo $this->Html->script('admin/icon-picker.min', array('block'=>'scriptBottomMiddle'));
	echo $this->Html->scriptBlock("
		(function($){
			$(document).ready(function(){
				$('.icon-picker').qlIconPicker({
					'save': 'class'
				});
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>
<script>
	function hideOtherLanguage(id)
	{
		$('.translatable-field').hide();
		$('.lang-' + id).show();
	}
</script>