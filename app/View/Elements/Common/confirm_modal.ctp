<!--Moda; start-->
<div id="modalConfirmYesNo" class="modal modal-danger fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="lblTitleConfirmYesNo">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->tag('h4',__('Confirmation!'),array('id' => 'lblTitleConfirmYesNo', 'class'=>'modal-title')) ?>
			</div>
			
			<div class="modal-body">
				<p id="lblMsgConfirmYesNo"></p>
			</div>

			<div class="modal-footer">
				<button id="btnYesConfirmYesNo" type="button" class="btn btn-primary"><?php echo __('Yes');?></button>
				<button id="btnNoConfirmYesNo" type="button" data-dismiss="modal" class="btn btn-default"><?php echo __('No');?></button>
			</div>
		</div>
	</div>
</div>
<!--Modal end-->