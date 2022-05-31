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
<article class="panel panel-em">
	<header class="panel-heading">
		<?php echo __('Settings: Email (Reset Password)'); ?>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<?php
				echo $this->Form->create('SiteSetting',array('type' => 'post', 'url'  => array('admin'=>true,'controller' => 'site_settings','action' => 'save'), 'id'=>'SettingSaveForm', 'class'=>'form-horizontal'));
				echo $this->Form->input('key');
				?>

				<div class="form-group">
					<h3 class="col-md-12"><?php echo __('Request'); ?></h3>
					<div class="col-md-8">
						<?php echo __('Subject'); ?>
						<?php echo $this->Form->input('request_subject',array('div' => false,'label'=>false,'class' => 'form-control','placeholder'=>__('Subject'))); ?>
						<?php echo $this->Form->input('request_body',array('type'=>'textarea', 'div' => false,'label'=>false,'class' => 'form-control froala','rows' => 10,'placeholder'=>__('Message body'))); ?>
						<p><?php echo __('Message body'); ?></p>
					</div>
					<div class="col-md-4">
						<br>
						<p>
							<strong><?php echo __('Shortcodes:'); ?>
							</strong>
						</p>
						<p>
							<?php echo __('Site address:'); ?>
							<code>{site_address}</code>
						</p>
						<p>
							<?php echo __('Full name:'); ?>
							<code>{user_name}</code>
						</p>
						<p>
							<?php echo __('User email:'); ?>
							<code>{user_email}</code>
						</p>
						<p>
							<?php echo __('Activation link:'); ?>
							<code>{reset_link}</code>
						</p>
					</div>
				</div>
				

				<div class="form-group">
					<h3 class="col-md-12"><?php echo __('Success'); ?></h3>
					<div class="col-md-8">
						<?php echo __('Subject'); ?>
						<?php echo $this->Form->input('success_subject',array('div' => false,'label'=>false,'class' => 'form-control ','placeholder'=>__('Subject'))); ?>
						<?php echo $this->Form->input('success_body',array('type'=>'textarea', 'id'=>'success_body', 'div' => false,'label'=>false,'class' => 'form-control froala','row'=>10)); ?>
						<p><?php echo __('Message body'); ?></p>
					</div>
					<div class="col-md-4">
						<br>
						<p>
							<strong><?php echo __('Shortcodes:'); ?>
							</strong>
						</p>
						<p>
							<?php echo __('Site address:'); ?>
							<code>{site_address}</code>
						</p>
						<p>
							<?php echo __('Full name:'); ?>
							<code>{user_name}</code>
						</p>
						<p>
							<?php echo __('User email:'); ?>
							<code>{user_email}</code>
						</p>
					</div>
				</div>

					<div class="form-actions">
						<button type="button" class="btn btn-info" onclick="save_setting();">
							<?php echo __('Save changes'); ?>
						</button>
					</div>

				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</article>
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