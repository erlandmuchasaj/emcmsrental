<div class="box">
	<div class="box-header with-border">
		<?php echo $this->Html->tag('h4', __('Contact Requests'), array('class'=>'box-title'))?>
		<div class="box-tools pull-right">
			<?php
				echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')).'&nbsp;'.__('Add Contact'),array('admin'=>true, 'controller' => 'contacts', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
			?>
		</div>
	</div>
	<div class="box-body event-table">
		
	</div>
</div>