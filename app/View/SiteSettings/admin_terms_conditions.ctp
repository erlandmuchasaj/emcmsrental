	<!-- page start-->
	<div class="row">
	    <div class="col-sm-6">
	        <div class="info-box">
	            <span class="info-box-icon bg-red">
	                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
	            </span>
	            <div class="info-box-content">
	              <span class="info-box-text">Warning!</span>
	              <span class="info-box-number">This Feature is still in development and will be comming soon.</span>
	            </div>
	        </div>
	    </div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel pane-em">
				<header class="panel-heading">
					<?php   echo __('Edit Site Setting'); ?>
				</header>
				<div class="panel-body">
					<div class="position-center">
						<?php
						echo $this->Form->create('SiteSetting',array('type' => 'post', 'url'  => array('admin'=>true,'controller' => 'site_settings','action' => 'save'), 'id'=>'SettingSaveForm', 'class'=>'form-horizontal'));
						echo $this->Form->input('key');
						?>
						<div class="form-group">
							<label class="col-lg-12"><?php echo __('Terms & Conditions');?></label>
							<div class="col-lg-12">
								<?php echo $this->Form->input('terms_and_conditions', array('type'=>'textarea','label'=>false, 'div'=>false,'class'=>'form-control froala')); ?>
								<span class="help-block"><?php echo __('Here you can edit Terms & Condition of the Site. ');?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<button type="button" class="btn btn-success btn-sm" onclick="save_setting();"><i class=" fa fa-check"></i>&nbsp;<?php echo __('Save changes'); ?></button>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- page end-->
<?php $this->Froala->editor('.froala', array('block'=>'scriptBottom')); ?>
<script>
	function save_setting(){
		var $elementToMask = $("#elementToMask");
		$.ajax({
			url: $('#SettingSaveForm').attr('action'),
			type: 'POST',
			dataType: 'json',
			data: $('#SettingSaveForm').serialize(),
			beforeSend: function() {
				// called before response
				$elementToMask.mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='success') {
					var response = $.parseJSON(JSON.stringify(data));
					if (!response.error) {
						toastr.success(response.message,'<?php echo __('Success!'); ?>');
					} else {
						toastr.error(response.message,'<?php echo __('Error!'); ?>');
					}
				} else {
					toastr.warning(textStatus,'<?php echo __('Warning!'); ?>');
				}
				$elementToMask.unmask();
			},
			complete: function(xhr, textStatus) {
				//called when complete
				$elementToMask.unmask();
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				$elementToMask.unmask();
				toastr.error(errorThrown, 'Error!');
			}
		});
		return true;
	}
</script>