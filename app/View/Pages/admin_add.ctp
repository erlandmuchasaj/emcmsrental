<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo __('Add a Page');?></h1>
	</div>
</div>

<div class="panel panel-em">
	<div class="panel-heading">
		<?php echo __('Page Details');?>
	</div>
	<div class="panel-body">
			<?php echo $this->Form->create('Page', array('class'=>'form-horizontal'));?>
				<div class="form-group">
					<div class="col-md-12">
						<?php
							echo $this->Form->input('name', array('label' => __('Page Name *'), 'class' => 'form-control'));
						?>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
					<?php
						echo $this->Form->input('meta_title', array('label' => __('Meta Title *'), 'class' => 'form-control'));
					?>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<?php echo $this->Form->input('sub_title', array('label' => __('Sub-title'), 'class' => 'form-control')); ?>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<?php echo $this->Form->input('parent_id',array('label' => __('Set Parent Page'),'empty' => __('No Parent'),'options' => $pages,'class' => 'form-control')); ?>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<?php
							echo $this->Form->input('content', array('type'=>'textarea', 'div' => false,'label'=>false,'class'=>'form-control froala'));
						?>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-6">
						<?php echo $this->Form->input('meta_description', array('class' => 'form-control'));?>
					</div>
					<div class="col-md-6">
						<?php echo $this->Form->input('meta_keywords', array('class' => 'form-control'));?>
					</div>
				</div>

				<?php //if (Configure::read('Content.topMenu')) : ?>
				<div class="form-group">
					<div class="col-md-12">
						<?php echo $this->Form->input('top_show', array('div' => false, 'label' => __('Show this page in the top menu?'))); ?>
					</div>
				</div>
				<?php //endif; ?>

				<?php //if (Configure::read('Content.bottomMenu')) : ?>
				<div class="form-group">
					<div class="col-md-12">
						<?php echo $this->Form->input('bottom_show', array('div' => false, 'label' => __('Show this page in the bottom menu?'))); ?>
					</div>
				</div>
				<?php //endif; ?>


				<div class="form-group">
					<div class="col-md-12">
						<?php echo $this->Form->input('new_window',array('div' => false, 'label' => __('Make this page open in a new window?'))); ?>
					</div>
				</div>

				<div class="well">
					<h3><?php echo __('Advanced Settings'); ?></h3>
					<p><?php echo __('These settings are optional and should only be edited if you are sure what you are doing.'); ?></p>
					<div class="form-group">
						<div class="col-lg-6">
								<?php
									echo $this->Form->input('slug',
															array('label' => __('Page Slug'),
																  'class' => 'form-control'));
								?>
						</div>
						<div class="col-lg-6">
								<?php
									echo $this->Form->input('view',
															array('label' => __('Page View'),
																  'class' => 'form-control'));
								?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-12">
								<?php echo $this->Form->input('make_homepage', array('div' => false, 'label' => __('Make this page the home page'), 'type' => 'checkbox')); ?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-6">
								<?php
									echo $this->Form->input('route',
															array('label' => __('301 Redirect'),
																  'class' => 'form-control',
																  'after' => __('If set, the page will link to this URL')));
								?>
						</div>
						<div class="col-lg-6">
								<?php
									echo $this->Form->input('post_route',
															array('label' => __('Post Redirect'),
																  'class' => 'form-control',
																  'after' => __('If set, any form will be redirected to this URL.')));
								?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-6">
						<?php
							echo $this->Form->input('class',
								array(
									'label' => __('Page class'),
									'class' => 'form-control',
									'after' => __('If set, any form will be redirected to this URL.')
								));
						?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<?php echo $this->Form->submit(__('Add Page'),array('class' => 'btn btn-primary'));?>
					</div>
				</div>
			<?php echo $this->Form->end();?>
	</div>
	<div class="panel-footer">
		<?php echo $this->Html->link(__('Back to pages'), array('action' => 'index'), array('class' => 'btn btn-default'));?>
	</div>
</div>
<?php
	$this->Froala->editor('.froala', array( 'block' => 'scriptBottom' ));
	$this->Html->scriptBlock("
		(function($){
			$(document).ready(function() {
				'use strict';
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>