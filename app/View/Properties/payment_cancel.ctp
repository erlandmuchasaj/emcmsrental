<div class='em-container properties make-top-spacing'>
	<div class='row'>
		<div class='col-md-12'>
			<div class='alert alert-warning alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				</button>
			 	<strong><?php echo __('Warning!'); ?></strong>
			 	<span><?php echo __('Payment was canceled'); ?></span>
			</div>
		</div>
		<div class='col-md-12'>
			<div class='panel panel-em no-border'>
			  <div class='panel-heading'><?php echo __('Payment Canceled!'); ?></div>
			  <div class='panel-body'>
				<p><?php echo __('The order was canceled.'); ?></p>
				<?php 
					echo $this->Html->link(
					    __('Click here to return to the home page'), 
					    ['controller' => 'properties', 'action' => 'index']
					); 
				?>
			  </div>
			</div>
		</div>
	</div>
</div>
