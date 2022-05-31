<!-- Load page -->
<div class="animationload">
	<div class="loader"></div>
</div>
<!-- End load page -->
<div class="container">
	<!-- Switcher -->
	<div class="switcher">
		<input id="sw" type="checkbox" class="switcher-value">
		<label for="sw" class="sw_btn"></label>
		<div class="bg"></div>
		<div class="text">Turn <span class="text-l">off</span><span class="text-d">on</span><br />the light</div>
	</div>
	<!-- End Switcher -->

	<!-- Dark version -->
	<div id="dark" class="row text-center">
		<div class="col-md-12">
			<div class="info">
				<?php echo $this->Html->image('general/404/404-dark.png', array('alt' => '404 error', 'class'=>''));?>
			</div>
		</div>
	</div>
	<!-- End Dark version -->

	<!-- Light version -->
	<div id="light" class="row text-center">
		<div class="col-md-12">
			<!-- Info -->
			<div class="info">
				<?php echo $this->Html->image('general/404/404-light.gif', array('alt' => '404 error', 'class'=>''));?>
				<!-- end Rabbit -->
				<?php
				echo (!empty($message)) ? $this->Html->tag('h2', $message) : '';
				echo $this->Html->tag('h3', __('Villains Stole this page :('));
				echo $this->Html->tag('p', __('The page you are looking for was moved, removed, <br>renamed or might never existed.'));
				echo $this->Html->link(__('Go Home'), array('controller'=>'properties', 'action' => 'index'), array('escape' => false, 'class'=>'btn'));
				echo $this->Html->link(__('Turn Back'), 'javascript: void(0);', array('escape' => false, 'class'=>'btn btn-brown', 'onclick'=>"window.history.go(-1); return false;"));
				?>
			</div>
			<!-- end Info -->
		</div>
	</div>
	<!-- End Light version -->
</div>
