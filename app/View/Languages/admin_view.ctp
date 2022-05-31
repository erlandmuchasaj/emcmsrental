<div class="panel panel-em">
	<header class="panel-heading"> <?php echo __('Language'); ?> </header>
	<div class="panel-body">
		<dl>
			<dt><?php echo __('Name'); ?></dt>
			<dd><?php echo h($language['Language']['name']); ?></dd>
			<dt><?php echo __('Language Code'); ?></dt>
			<dd><?php echo h($language['Language']['language_code']); ?></dd>
		</dl>
		 <?php echo $this->Html->link(__('Back'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-default')); ?>
	</div>
</div>
