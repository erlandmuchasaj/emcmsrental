<div class="pad margin no-print">
	<div class="callout callout-info">
		<h4><i class="fa fa-info"></i><?php echo __('Note');?></h4>
		<?php echo __('This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.');?>
	</div>
</div>

<?php 
	if (isset($reservation) && !empty($reservation)) {
		echo $this->element('invoice', [
			'reservation'=> $reservation,
		]);
	}
?>
<div class="seperator-xl"></div>
