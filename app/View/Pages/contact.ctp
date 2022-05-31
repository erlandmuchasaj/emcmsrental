<div class="em-container make-top-spacing">
	<style scoped>
		.wpb_content_element {
		    padding-top: 30px !important;
		    padding-right: 30px !important;
		    padding-bottom: 30px !important;
		    padding-left: 30px !important;
		    background-color: #ffffff !important;
		    margin-bottom: 35px;
		}

		.wpb_content_element .content-title {
			font-family: azo_sansbold;
			text-transform: inherit;
			text-align: inherit;
			font-size: 18px;
		}

		.wpb_content_element .content-info {
			font-family: azo_sanslight;
			text-transform: none;
			letter-spacing: 0;
			font-size: 14px;
			line-height: 24px;
			color: #3b4249
		}

		.form-title {
			font-family: azo_sansbold;
			margin-top: 0;
			margin-bottom: 20px;
		}

		.contact-us label {
			font-family: azo_sanslight;
		}

		.contact-us .form-control {
			border-color: #d8dce1;
			border-radius: 0;
			color: #4f5962;
			font-weight: 500;
			font-size: 14px;
			box-shadow: none;
			padding: 0 12px;
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
		}

		.contact-us .btn {
			border-radius: 0;
		}

		.contact-us .btn:focus, 
		.contact-us .btn:hover {
		    background-color: #fd6f73;
		    border-color: #fd6f73;
		}

	</style>
	<div class="row">
		<div class="col-sm-6 col-xs-12">
			<?php if (!empty($page['Page']['content'])) {
				echo getDescriptionHtml($page['Page']['content']);
			} ?>
		</div>
		<div class="col-sm-6 col-xs-12">
			<h3 class="form-title"><?php echo __('Contact us'); ?></h3>
			<?php 
				echo $this->Form->create('Contact', array('class' => 'form-horizontal contact-us')); 

				echo $this->Form->input('name', array('div' => 'form-group col-md-12', 'class' => 'form-control', 'label' => __('Your Name')));

				echo $this->Form->input('email', array('div' => 'form-group col-md-12', 'class' => 'form-control', 'label' => __('Your Email')));

				echo $this->Form->input('subject', array('div' => 'form-group col-md-12', 'class' => 'form-control', 'label' => __('Subject')));

				echo $this->Form->input('message', array('div' => 'form-group col-md-12', 'class' => 'form-control', 'label' => __('Message'), 'rows' => 6));

				echo $this->Form->submit(__('Submit'), array('div' => 'form-group col-md-12', 'class' => 'btn btn-primary'));

				echo $this->Form->end(); 
			?>
		</div>
	</div>
</div>