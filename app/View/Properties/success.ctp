<!-- Content -->
<div id="print_receipt" class="em-container make-top-spacing">
	<?php 
		if (isset($reservation) && !empty($reservation)) {
			echo $this->element('invoice', [
				'reservation'=> $reservation,
			]);
		}
	?>
</div>
	