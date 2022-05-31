<!--Moda; start-->
<div id="login_modal_element" class="modal fade login-modal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabelLogin">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->tag('h4',__('Confirmation!'),array('id' => 'myModalLabelLogin', 'class'=>'modal-title')) ?>
			</div>

			<div class="modal-body">
			</div>
			
			<div class="modal-footer">
				<button id="btnConfirmLoginModal" type="button" class="btn btn-primary"><?php echo __('Login');?></button>
				<button id="btnCancelLoginModal" type="button" data-dismiss="modal" class="btn btn-default"><?php echo __('Cancel');?></button>
			</div>
		</div>
	</div>
</div>
<!--Modal end-->