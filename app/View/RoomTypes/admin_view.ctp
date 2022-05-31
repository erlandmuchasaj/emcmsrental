<div class="box box-danger">
	<div class="box-header with-border">
		<?php echo $this->Html->tag('h3', __('Room Type'), array('class'=>'box-title'))?>
		<span class="tools pull-right">
		    <?php
		        echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-mail-reply')).'&nbsp;'.__('Return to Room Types list'),array('controller' => 'room_types', 'action' => 'index'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
		    ?>
		</span>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">
		<?php if (!empty($roomTypeList)): ?>
		<table class="table  table-hover general-table">
			<thead>
				<tr>
					<th><?php echo __('Language Id'); ?></th>
					<th><?php echo __('Room Type Name'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>									
				</tr>
			</thead>
			<tbody>
				<?php foreach ($roomTypeList as $roomTypes): ?>
					<tr>
						<td><?php echo $roomTypes['Language']['name'];  ?></td>
						<td><?php echo $roomTypes['RoomType']['room_type_name']; ?></td>
						<td class="actions">
							<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')).'&nbsp;'.__('Edit'),array('admin'=>true,'controller'=>'room_types','action' => 'editLanguage', $roomTypes['RoomType']['id'], $roomTypes['RoomType']['language_id']),array('escape' => false, 'class'=>'label label-info', 'data-toggle'=>'tooltip', 'title'=>__('Edit Room Type'))); ?>
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