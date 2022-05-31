<?php echo $this->Html->css('users', null, array('block'=>'cssMiddle')); ?>
<div class="em-container make-top-spacing">
	<div class="row" id="elementToMask">
		<div class="col-lg-3 col-md-4 user-sidebar">
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8">
		<?php 
			if (isset($reservation) && !empty($reservation)) {
				echo $this->element('invoice', [
					'reservation'=> $reservation,
				]);
			}
		?>
		</div>
	</div>
</div>
<div class="seperator-xl"></div>
