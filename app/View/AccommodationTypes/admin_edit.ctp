<?php 
	echo $this->Form->create('AccommodationType'); 
?>
<article class="panel panel-em">
	<header class="panel-heading">
		<h4><?php echo __('Edit Accommodation Type'); ?></h4>
	</header>
	<div class="panel-body">
		<div class="form-group">
			<label class="control-label col-md-3 required">
				<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="<?php echo __('Invalid characters <>;=#{}');?>"> <?php echo __('Accommodation Name');?>
				</span>
			</label>
			<div class="col-md-9">
				<?php if (count($languages) > 1): ?>
					<div class="form-group">
				<?php endif ?>

				<?php foreach ($translations as $index => $accomodation): ?>
					<?php $id_lang = $accomodation['AccommodationType']['language_id']; ?>

					<div class="translatable-field lang-<?php echo $id_lang; ?>" <?php echo ($accomodation['Language']['is_default'] != 1) ? 'style="display: none;"': ''; ?> >
					<?php if (count($languages) > 1): ?>
						<div class="col-sm-9 col-xs-8">
					<?php endif ?>
						<?php

							$options = [
								'class' => 'form-control count-char',
								'id' => 'accommodation_type_name_'.$id_lang,
								'label' => false,
								'div' => false,
								'value' => h($accomodation['AccommodationType']['accommodation_type_name']),
								'required' => 'required',
								'placeholder' => __('Accommodation type name'), 
								'data-minlength' => '0', 
								'data-maxlength' => '90',
							];

							echo $this->Form->input('AccommodationType.' . $index . '.id', ['type' => 'hidden', 'value' => $accomodation['AccommodationType']['id']]);

							echo $this->Form->input('AccommodationType.' . $index . '.language_id', ['type' => 'hidden', 'value' => $accomodation['AccommodationType']['language_id']]);

							echo $this->Form->input('AccommodationType.' . $index . '.accommodation_type_id', ['type' => 'hidden', 'value' => $accomodation['AccommodationType']['accommodation_type_id']]);

							echo $this->Form->input('AccommodationType.' . $index . '.accommodation_type_name', $options); 
						?>
					<?php if (count($languages) > 1): ?>
						</div>
						<div class="col-sm-3 col-xs-4 dropdown">
							<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?php echo h($accomodation['Language']['language_code']); ?>&nbsp;<i class="caret"></i>
							</button>
							<ul class="dropdown-menu" role="menu">
								<?php foreach ($languages as $key => $language): ?>
									<li role="presentation">
										<a role="menuitem" href="javascript:hideOtherLanguage(<?php echo $language['Language']['id']; ?>);" tabindex="-1">
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
	</div>
	<div class="panel-footer">
		<?php echo $this->Form->submit(__('Update'), array('class'=>'btn btn-success','label'=>false,'div'=>false)); ?>
		<?php echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('escape' => false, 'class'=>'btn btn-danger')); ?>
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