<div class="box box-danger" id="elementToMask">
	<div class="box-header with-border">
		<?php echo $this->Html->tag('h4', __('Related Characteristic Translations'), array('class'=>'box-title'))?>
		<span class="tools pull-right">
		    <?php
		        echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-mail-reply')).'&nbsp;'.__('Return to Characteristic List'),array('admin'=>true, 'controller' => 'characteristics', 'action' => 'index'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
		    ?>
		</span>
	</div>
	<div class="box-body">
		<?php if (!empty($characteristic['CharacteristicTranslation'])): ?>
		<table class="table">
			<tr>
				<th><?php echo __('ID'); ?></th>
				<th><?php echo __('Language'); ?></th>
				<th><?php echo __('Characteristic name'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($characteristic['CharacteristicTranslation'] as $characteristicTranslation): ?>
				<tr>
					<td><?php echo $characteristicTranslation['id']; ?></td>
					<td><?php echo getDescriptionHtml($characteristicTranslation['Language']['name']); ?></td>
					<td><?php echo getDescriptionHtml($characteristicTranslation['characteristic_name']); ?></td>
					<td class="actions">
					<?php
						echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')).'&nbsp;'.__('Edit'),array('admin'=>true,'controller'=>'characteristics','action' => 'editLanguage', $characteristicTranslation['id'], $characteristicTranslation['language_id']),array('escape' => false, 'class'=>'btn btn-info btn-sm'));
					?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>			
		<?php else: ?>
			<?php echo __('No language Translation related to this characteristic'); ?>
		<?php endif ?>
	</div>
</div>
