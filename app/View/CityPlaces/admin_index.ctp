<?php
	$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'CityPlace'. DS;
?>
<div class="row" id="elementToMask">
	<div class="col-sm-12">
		<div class="panel panel-em">
			<header class="panel-heading">
				<?php echo $this->Html->tag('h4',__('City Places'),array('class' => 'display-inline-block')) ?>
				<span class="tools pull-right panel-heading-actions">
					<?php
						echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')).'&nbsp;'.__('New Place'),array('admin'=>true, 'controller' => 'city_places', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
					?>
				</span>
			</header>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('image_path'); ?></th>
							<th><?php echo $this->Paginator->sort('city_id'); ?></th>
							<th><?php echo $this->Paginator->sort('place_name'); ?></th>
							<th><?php echo $this->Paginator->sort('short_description'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($cityPlaces as $cityPlace): ?>
						<tr>
							<td class="image">
								<?php 
									if (file_exists($directory.$cityPlace['CityPlace']['image_path']) && is_file($directory .$cityPlace['CityPlace']['image_path'])) { 	
										echo $this->Html->image('uploads/CityPlace/' . $cityPlace['CityPlace']['image_path'], array('alt' => 'image','fullBase' => true)); 
									} else {
										echo $this->Html->image('placeholder.png', array('alt' => 'no image available','fullBase' => true));
									}
								?>	
							</td>
							<td>
								<?php echo $this->Html->link($cityPlace['City']['name'], array('controller' => 'cities', 'action' => 'view', $cityPlace['City']['id'])); ?>
							</td>
							<td><?php echo h($cityPlace['CityPlace']['place_name']); ?>&nbsp;</td>
							<td><?php echo h($cityPlace['CityPlace']['short_description']); ?>&nbsp;</td>
							<td class="actions">
								<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cityPlace['CityPlace']['id']), array('escape' => false, 'class'=>'btn btn-info btn-sm')); ?>
								<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cityPlace['CityPlace']['id']), array('class'=>'btn btn-danger btn-sm' ,'confirm' => __('Are you sure you want to delete # %s?', $cityPlace['CityPlace']['id']))); ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>