<?php echo $this->Form->create('RoomType'); ?>
<article class="panel panel-em">
	<header class="panel-heading">
		<h4><?php echo __('Add Room Type'); ?></h4>
	</header>
	<div class="panel-body">
		<div class="form-group">
			<label class="control-label col-md-3 required">
				<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="<?php echo __('Invalid characters <>;=#{}');?>"> <?php echo __('Room Name');?>
				</span>
			</label>
			<div class="col-md-9">
				<?php if (count($languages) > 1): ?>
					<div class="form-group">
				<?php endif ?>

				<?php foreach ($languages as $index => $language): ?>
					<?php $id_lang = $language['Language']['id']; ?>
					<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($language['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
					<?php if (count($languages) > 1): ?>
						<div class="col-sm-9 col-xs-8">
					<?php endif ?>
						<?php

							$options = [
								'class' => 'form-control count-char', 
								'id' => 'room_type_name_'.$id_lang,
								'label' => false,
								'div' => false,
								'value' => '',
								'placeholder' => __('Room type name'), 
								'data-minlength' => '0', 
								'data-maxlength' => '90',
							];

							if ($language['Language']['is_default'] == 1) {
								$options['required'] = 'required';
							}

							echo $this->Form->input('RoomType.' . $id_lang . '.language_id', ['type' => 'hidden', 'value' => $id_lang]);
							
							echo $this->Form->input('RoomType.' . $id_lang . '.room_type_id', ['type' => 'hidden', 'value' => $room_type_id]);

							echo $this->Form->input('RoomType.'.$id_lang.'.room_type_name', $options); 
						?>
					<?php if (count($languages) > 1): ?>
						</div>
						<div class="col-sm-3 col-xs-4 dropdown">
							<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?php echo h($language['Language']['language_code']); ?>&nbsp;<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<?php foreach ($languages as $key => $language): ?>
									<li role="presentation">
										<a role="menuitem" href="javascript:hideOtherLanguage(<?php echo $language['Language']['id']; ?>);" tabindex="-1">
											<?php echo $language['Language']['name']; ?>
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
	</div>
	<div class="panel-footer">
		<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-success','label'=>false,'div'=>false)); ?>
		<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>
	</div>
</article>
<?php echo $this->Form->end(); ?>

<script>
	function hideOtherLanguage(id)
	{
		$('.translatable-field').hide();
		$('.lang-' + id).show();
	}
</script>
