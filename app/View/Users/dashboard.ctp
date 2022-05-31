<?php echo $this->Html->css('users', null, array('block'=>'cssMiddle'));?>
<div class="em-container make-top-spacing">
	<div class="row">
		<div class="col-lg-3 col-md-4 user-sidebar"> 
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>

		<div class="col-lg-9 col-md-8"> 
			<div class="panel panel-em no-border">
				<div class="panel-heading"><?php echo __('Welcome to %s!', Configure::read('Website.name')); ?></div>
				<div class="panel-body">
					<?php echo $this->Html->tag('p', __('This is your <strong>Dashboard</strong>, the place to manage your rental. Update all your personal information from here.'))?>

					<?php echo $this->Html->tag('p', __('Check your messages, view upcoming trip information, and find travel inspiration all from your dashboard. Before booking your first stay, make sure to:'))?>
					<ul>
						<li>
							<?php echo $this->Html->tag('h4', $this->Html->link(__('Complete Your Profile'), array('controller' => 'users', 'action' => 'edit', AuthComponent::user('id')), array('escape' => false, 'class'=>'user-box-avatar')))?>
							<?php echo $this->Html->tag('p', __('Upload a photo and write a short bio to help hosts get to know you before inviting you into their home.'))?>

						</li>
						<li>
							<?php echo $this->Html->tag('h4', __('Provide ID'))?>
							<?php echo $this->Html->tag('p', __('Some hosts require guests to provide ID before booking. Get a head start by doing it now.'))?>
						</li>
						<li>
							<?php echo $this->Html->tag('h4', __('Learn How to Book a Place'))?>
							<?php echo $this->Html->tag('p', __('Get ready to search for the perfect place, contact hosts, and prepare for a memorable trip.'))?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>