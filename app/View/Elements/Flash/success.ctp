<div class="flash-success flash-message animated fadeInDown">
	<button type="button" class="close">X</button>
	<?php if (isset($message) && trim($message)!="") {echo h($message) . "&nbsp;";}?>
</div>
<?php echo $this->Html->script('flashMessages/custom', array('block'=>'scriptBottom'));?>