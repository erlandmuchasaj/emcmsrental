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
		<h3><?php echo __('Settings: Email (New User)'); ?></h3>
	</header>
	<div class="panel-body">
		<div class="row" id="elementToMask">
			<div class="col-md-12">
				<?php
				echo $this->Form->create('SiteSetting',array('type' => 'post', 'url'  => array('admin'=>true,'controller' => 'site_settings','action' => 'save'), 'id'=>'SettingSaveForm', 'class'=>'form-horizontal'));
				echo $this->Form->input('key');
				?>
				<div class="form-group">
					<h3 class="col-md-12"><?php echo __('Send link'); ?></h3>
					<div class="col-md-8">
						<label  class="control-label"> <?php echo __('Subject'); ?></label>
						<?php echo $this->Form->input('send_link_subject',array('div' => false,'label'=>false,'class' => 'form-control','placeholder'=>__('Email Subject'))); ?>

						<?php echo $this->Form->input('send_link_body',array('type'=>'textarea','class' => 'form-control froala','placeholder'=>__('Email Message body'))); ?>
						<div class="help-inline">
							<?php echo  $this->Html->tag('p', __('Email message body')); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="help-inline">
							<p><strong><?php echo __('Shortcodes:'); ?></strong></p>
							<p>
								<?php echo __('Site address:'); ?>
								<br>
								{site_name}
							</p>
							<p>
								<?php echo __('Full name:'); ?>
								<br>
								{user_name}
							</p>
							<p>
								<?php echo __('User email:'); ?>
								<br>
								{user_email}
							</p>
							<p>
								<?php echo __('User password:'); ?>
								<br>
								{user_password}
							</p>
							<p>
								<?php echo __('Activation link:'); ?>
								<br>
								{user_activation_link}
							</p>
						</div>
					</div>
				</div>
				<hr />
				<div class="form-group">
					<h3 class="col-md-12"><?php echo __('Activated'); ?></h3>
					<div class="col-md-8">
						<label class="control-label"> <?php echo __('Subject'); ?></label>
						<?php echo $this->Form->input('activated_subject',array('div' => false,'label'=>false,'class' => 'form-control','placeholder'=>__('Email Subject'))); ?>
						<?php echo $this->Form->input('activated_body',array('type'=>'textarea','class' => 'form-control froala','rows' => 11,'placeholder'=>__('Email Message body'))); ?>
						<div class="help-inline">
							<?php echo  $this->Html->tag('p', __('Email Message body')); ?>
						</div>
					</div>
					<div class="col-md-4">
						<p>
							<strong><?php echo __('Shortcodes:'); ?></strong>
						</p>
						<p>
							<?php echo __('Site address:'); ?>
							<br>
							{site_address}
						</p>
						<p>
							<?php echo __('Full name:'); ?>
							<br>
							{user_name}
						</p>
						<p>
							<?php echo __('User email:'); ?>
							<br>
							{user_email}
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
