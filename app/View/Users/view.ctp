<?php echo $this->Html->css('users', null, array('block'=>'cssMiddle'));?>
<div class="em-container make-top-spacing">
	<div class="row">
		<div class="col-lg-3 col-md-4 user-sidebar"> 
			<div class="user-box">
				<?php
					echo $this->Html->link($this->Html->displayUserAvatar($user['User']['image_path']),'javascript:void(0);', array('escape' => false, 'class'=>'user-box-avatar'));
				?>
			</div>			
			<div class="quick-links">
				<h3 class="quick-links-header"><?php echo __('Verifications'); ?></h3>
				<div class="col-md-12">
				<?php if (!empty($user['SocialProfile'])): ?>
					<ul class="fa-ul">
					<?php foreach ($user['SocialProfile'] as $key => $socialProfile): ?>
						<?php if ($socialProfile['social_network_name'] === 'Facebook') { ?>
							<li>
								<i class="fa-li fa fa-facebook"></i>
								<b>Facebook</b>&nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i>
								<p class="list1"><?php echo __('Verified');?></p>
							</li>
						<?php } ?>
						
						<?php if ($socialProfile['social_network_name'] === 'Twitter') { ?>
							<li>
								<i class="fa-li fa fa-twitter"></i>
								<b>Twitter</b>&nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i>
								<p class="list1"><?php echo __('Verified');?></p>
							</li>
						<?php } ?>
						<?php if ($socialProfile['social_network_name'] === 'Google') { ?>
							<li>
								<i class="fa-li fa fa-google-plus"></i>
								<b>GooglePlus</b>&nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i>
								<p class="list1"><?php echo __('Verified');?></p>
							</li>
						<?php } ?>
					<?php endforeach ?>
					</ul>
				<?php endif ?>
				</div>
			</div>
		</div>

		<div class="col-lg-9 col-md-8"> 
			<?php 
				echo $this->Html->tag('h2', __("Hey, I'm %s!", h($user['User']['name'].' '.$user['User']['surname'])),array('class' => 'user-box-name'));
				echo $this->Html->tag('small', __('Member since %s', $this->Time->niceShort(h($user['User']['created']))));
				echo $this->Html->tag('p', h($user['UserProfile']['about']),array('class' => 'user-box-name'));
			?>
			<div class="seperator-xs"></div>
			<div class="panel panel-warning">
				<!-- Default panel contents -->
				<div class="panel-heading"><?php echo __('Properties');?></div>
				<!-- Table -->
				<table class="table general-table">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('thumbnail'); ?></th>
							<th><?php echo $this->Paginator->sort('address'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($properties as $property): 
							$elementId = (int)$property['Property']['id'];
							$directorySmURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Property'.DS.$elementId.DS.'PropertyPicture'.DS.'small'.DS;
							$directorySmPATH = 'uploads/Property/'.$elementId.'/PropertyPicture/small/';
						?>
						<tr class="parent-element">
							<td data-th="<?php echo __('Thumbnail');?>" class="image">
								<?php
									$base64 = 'placeholder.png';
									if (file_exists($directorySmURL.$property['Property']['thumbnail']) && is_file($directorySmURL .$property['Property']['thumbnail'])) { 	
										$base64 = $directorySmPATH . $property['Property']['thumbnail'];
									}
									$img = $this->Html->image($base64, array('alt' => 'thumbnail', 'class'=>'img-responsive'));

									$type = EMCMS_ucfirst($property['Property']['contract_type']);

									echo $this->Html->tag('div', $img . $this->Html->tag('span', h($type), array('class' => 'badge label-success payed-badge'))
										, array('style' => 'position: relative; display: inline-block;'));
								?>
							</td>
							<td data-th="<?php echo __('Address');?>"><?php echo h($property['Property']['address']); ?></td>
							<td class="actions">
								<?php 
									echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View'), array('controller'=>'properties','action' => 'view', $elementId),array('escape' => false, 'class'=>'btn btn-info btn-sm')); 
								?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>	
			</div>
			<?php echo $this->element('Pagination/counter'); ?>
			<?php echo $this->element('Pagination/navigation'); ?>	
		</div>
	</div>
</div>
