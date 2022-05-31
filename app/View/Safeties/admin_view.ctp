<div class="box box-danger" id="elementToMask">
	<div class="box-header with-border">
		<?php echo $this->Html->tag('h4', __('Related Safety Translations'), array('class'=>'box-title'))?>
		<span class="tools pull-right">
		    <?php
		        echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-mail-reply')).'&nbsp;'.__('Return to safeties list'),array('admin'=>true, 'controller' => 'safeties', 'action' => 'index'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
		    ?>
		</span>
	</div>
	<div class="box-body">
		<?php if (!empty($safety['SafetyTranslation'])) { ?>
		<table class="table">
			<tr>
				<th><?php echo __('ID'); ?></th>
				<th><?php echo __('Language'); ?></th>
				<th><?php echo __('Safety Name'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($safety['SafetyTranslation'] as $safetyTranslation): ?>
				<tr>
					<td><?php echo $safetyTranslation['id']; ?></td>
					<td><?php echo getDescriptionHtml($safetyTranslation['Language']['name']); ?></td>
					<td><?php echo getDescriptionHtml($safetyTranslation['safety_name']); ?></td>
					<td class="actions">
					<?php
						echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')).'&nbsp;'.__('Edit'),array('admin'=>true, 'controller'=>'safeties','action' => 'editLanguage', $safetyTranslation['id'], $safetyTranslation['language_id']),array('escape' => false, 'class'=>'btn btn-info btn-sm'));
					?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php } else {
			echo __('No language Translation related to this safety');
		} ?>
	</div>
</div>