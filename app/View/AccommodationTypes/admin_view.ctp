<div class="box box-danger">
	<div class="box-header with-border">
		<?php echo $this->Html->tag('h3', __('Accommodation Types'), array('class'=>'box-title')); ?>
		<span class="tools pull-right">
		    <?php
		        echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-mail-reply')).'&nbsp;'.__('Return to Accomodation Types list'),array('controller' => 'accommodation_types', 'action' => 'index'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
		    ?>
		</span>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">
		<?php if (!empty($accommodationTypeList)): ?>
		<table class="table  table-hover general-table">
			<thead>
				<tr>
					<th><?php echo __('Language Id'); ?></th>
					<th><?php echo __('Accommodation type name'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($accommodationTypeList as $accommodationTypes): ?>
					<tr>
						<td><?php echo h($accommodationTypes['Language']['name']);  ?></td>
						<td><?php echo getDescriptionHtml($accommodationTypes['AccommodationType']['accommodation_type_name']); ?></td>
						<td class="actions">
							<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa  fa-edit')).'&nbsp;'.__('Edit'),array('admin'=>true,'controller'=>'accommodation_types','action' => 'editLanguage', $accommodationTypes['AccommodationType']['id'], $accommodationTypes['AccommodationType']['language_id']),array('escape' => false, 'class'=>'label label-info', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>__('Edit accommodation type'))); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
	</div>
	<!-- /.box-body -->
	<div class="box-footer text-center">
	</div>
</div>


