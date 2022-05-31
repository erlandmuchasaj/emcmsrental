<div class="panel panel-em">
	<header class="panel-heading"> <?php echo __('Currency'); ?> </header>
	<div class="panel-body">
		<dl>
			<dt><?php echo __('Name'); ?></dt>
			<dd><?php echo h($currency['Currency']['name']); ?></dd>
			<dt><?php echo __('Symbol'); ?></dt>
			<dd><?php echo ($currency['Currency']['symbol']); ?></dd>
		</dl>
		 <?php echo $this->Html->link(__('Back'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-default')); ?>
	</div>
</div>
