<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<?php
			$userAvatar = 'avatars/avatar.png';
			$directorySM = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS.'small'.DS;
			if (file_exists($directorySM.AuthComponent::user('image_path')) && is_file($directorySM.AuthComponent::user('image_path'))) {
				$userAvatar = 'uploads/User/small/' . AuthComponent::user('image_path');
			}
		?>
		<div class="user-panel">
			<div class="pull-left image">
				<?php echo $this->Html->image($userAvatar, array('alt' => 'User image', 'class'=>'img-circle')); ?>
			</div>
			<div class="pull-left info">
				<?php echo $this->Html->tag('p',h(AuthComponent::user('name').' '.AuthComponent::user('surname')),array('class' => '')) ?>
				<!-- Status -->
				<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-circle text-success"></i><?php echo __('Online.');?> </a>
			</div>
		</div>
		
		<?php if (false): ?>
		<!-- search form (Optional) -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i aria-hidden="true" class="fa fa-search"></i>
					</button>
				</span>
			</div>
		</form>
		<?php endif ?>

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<?php echo $this->Html->tag('li',__('MAIN NAVIGATION'),array('class' => 'header')) ?>
			<!-- Optionally, you can add icons to the links  class="active"-->
			<li class="">
				<?php
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-dashboard', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Dashboard'), array('class' => '')),array('controller' => 'users', 'action' => 'dashboard', 'admin'=>true),array('escape' => false));
				?>
			</li>
			<li class="">
				<?php
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-television', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Frontend'), array('class' => '')),array('controller' => 'properties', 'action' => 'index', 'admin'=>false),array('escape' => false,'target'=>'_blank'));
				?>
			</li>
			<li class="treeview">
				<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-laptop"></i> <span><?php echo __('Site Settings'); ?></span>
					<span class="pull-right-container">
						<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li>
						<?php
							echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-globe', 'aria-hidden'=>'true')).$this->Html->tag('span', __('General')),array('admin'=>true, 'controller' => 'site_settings', 'action' => 'index'),array('escape' => false));
						?>
					</li>
					<li>
						<?php
							echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-money', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Fees')),array('admin'=>true, 'controller' => 'site_settings', 'action' => 'siteFee'),array('escape' => false));
						?>
					</li>
					<li>
						<?php
							echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-tasks', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Banners')),array('admin'=>true, 'controller' => 'site_settings', 'action' => 'banner'),array('escape' => false));
						?>
					</li>
					<li>
						<?php
							echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-support', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Homepage Settings')),array('admin'=>true, 'controller' => 'site_settings', 'action' => 'home_settings'),array('escape' => false));
						?>
					</li>

					<li class="treeview">
						<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-exclamation-triangle"></i><span><?php echo __('Cancellation Policies'); ?></span>
							<span class="pull-right-container">
								<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
							<?php
								echo $this->Html->link($this->Html->tag('span', __('Cancellation Policies')),array('admin'=>true, 'controller' => 'cancellation_policies', 'action' => 'index'),array('escape' => false));
							?>
							</li>
							<li>
								<?php
									echo $this->Html->link($this->Html->tag('span', __('Host Cancellation Policy')),array('admin'=>true,'controller' => 'cancellation_policies', 'action' => 'hostCancellation', 'policy'),array('escape' => false));
								?>
							</li>
						</ul>
					</li>

					<!-- 
					<li>
						<?php
							// echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-credit-card', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Credit Card')),array('admin'=>true, 'controller' => 'site_settings', 'action' => 'credit_card'),array('escape' => false));
						?>
					</li> 
					<li>
						<?php
							// echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-book', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Policy')),array('admin'=>true, 'controller' => 'site_settings', 'action' => 'policy'),array('escape' => false));
						?>
					</li>
					<li>
						<?php
							// echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-file-text-o', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Terms & Conditions')),array('admin'=>true, 'controller' => 'site_settings', 'action' => 'terms_conditions'),array('escape' => false));
						?>
					</li>
					<li>
						<?php
							// echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-exchange', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Redirects')),array('admin'=>true, 'controller' => 'redirects', 'action' => 'index'),array('escape' => false));
						?>
					</li>
					
					<li class="treeview">
						<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-envelope-o"></i><span><?php // echo __('Email Templates'); ?></span>
							<span class="pull-right-container">
								<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
							<?php
								// echo $this->Html->link($this->Html->tag('span', __('New User'), array('class' => '')),array('admin'=>true, 'controller' => 'site_settings', 'action' => 'email', 'new_user'),array('escape' => false));
							?>
							</li>
							<li>
								<?php
									// echo $this->Html->link($this->Html->tag('span', __('Reset Password'), array('class' => '')),array('admin'=>true,'controller' => 'site_settings', 'action' => 'email', 'reset_password'),array('escape' => false));
								?>
							</li>
						</ul>
					</li>
					-->
				</ul>
			</li>
			
			<!-- 
			<li>
				<?php // echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Reviews')),array('controller' => 'reviews', 'action' => 'index', 'admin'=>true),array('escape' => false));?>
			</li> 
			<li class="treeview">
				<a href="javascript:void(0);">
					<i aria-hidden="true" class="fa fa-tags"></i>
					<span class="title"><?php // echo __('Coupon Control System'); ?></span>
					<span class="pull-right-container">
						<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li>
						<?php
						// echo $this->Html->link($this->Html->tag('span',__('All Coupons')), array('controller' => 'coupons','action' => 'index'),array('escape'=>false));
						?>
					</li>
					<li>
						<?php
						// echo $this->Html->link($this->Html->tag('span',__('New Coupon')), array('controller' => 'coupons','action' => 'add'),array('escape'=>false));
						?>
					</li>
				</ul>
			</li>
			-->

			<li class="treeview">
				<a href="javascript:void(0);">
					<i aria-hidden="true" class="fa fa-folder-open"></i>
					<span class="title"><?php echo __('Category manager'); ?></span>
					<span class="pull-right-container">
						<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-list', 'aria-hidden'=>'true')).__('All Categories'),array('controller' => 'categories', 'action' => 'index', 'admin'=>true),array('escape' => false));?></li>

					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit', 'aria-hidden'=>'true')).__('New category'),array('controller' => 'categories', 'action' => 'add', 'admin'=>true),array('escape' => false));?></li>
				</ul>
			</li>
			<li  class="treeview">
				<a href="javascript:void(0);">
					<i aria-hidden="true" class="fa fa-files-o"></i>
					<span><?php echo __('Article manager'); ?></span>
					<span class="pull-right-container">
						<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-list', 'aria-hidden'=>'true')).__('All Articles'),array('controller' => 'articles', 'action' => 'index', 'admin'=>true),array('escape' => false));?></li>

					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit', 'aria-hidden'=>'true')).__('New article'),array('controller' => 'articles', 'action' => 'add', 'admin'=>true),array('escape' => false));?></li>
					<!-- 
					<li class="treeview">
						<a href="javascript:void(0);">
							<i aria-hidden="true" class="fa fa-share-alt fa-fw"></i>
							<span class="title"><?php // echo __('Blocks'); ?></span>
							<span class="pull-right-container">
								<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<?php
								// echo $this->Html->link($this->Html->tag('span',__('All Blocks')), array('controller' => 'blocks','action' => 'index'),array('escape'=>false));
								?>
							</li>
							<li>
								<?php
								// echo $this->Html->link($this->Html->tag('span',__('New Block')), array('controller' => 'blocks','action' => 'add'),array('escape'=>false));
								?>
							</li>
						</ul>
					</li>
					 -->
				</ul>
			</li>

			<li class="treeview">
				<a href="javascript:;">
					<i aria-hidden="true" class="fa fa-users"></i>
					<span><?php echo __('Users');?></span>
					<span class="pull-right-container">
						<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-list', 'aria-hidden'=>'true')).__('All users'),array('controller' => 'users', 'action' => 'index', 'admin'=>true),array('escape' => false));?></li>

					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-ban', 'aria-hidden'=>'true')).__('Banned users'),array('controller' => 'users', 'action' => 'bannedUsers', 'admin'=>true),array('escape' => false));?></li>

					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus', 'aria-hidden'=>'true')).__('New user'),array('controller' => 'users', 'action' => 'add', 'admin'=>true),array('escape' => false));?></li>
				</ul>
			</li>

			<li class="treeview">
				<a href="javascript:;">
					<i aria-hidden="true" class="fa fa-star-o"></i>
					<span><?php echo __('Experiences');?></span>
					<span class="pull-right-container">
						<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li>
						<?php
							echo $this->Html->link(
								$this->Html->tag('i', '', array('class' => 'fa fa-circle-o', 'aria-hidden'=>'true')).__('Host Experiences'),
								['controller' => 'experience', 'action' => 'index', 'admin' => true],
								['escape' => false]
							);
						?>
					</li>
					<li>
						<?php
							echo $this->Html->link(
								$this->Html->tag('i', '', array('class' => 'fa fa-folder-open', 'aria-hidden'=>'true')).__('Experience Categories'),
								['controller' => 'experience', 'action' => 'categories', 'admin' => true],
								['escape' => false]
							);
						?>
					</li>
				</ul>
			</li>

			<li class="treeview">
				<a href="javascript:;">
					<i aria-hidden="true" class="fa fa-list"></i>
					<span><?php echo __('Properties');?></span>
					<span class="pull-right-container">
						<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-list', 'aria-hidden'=>'true')).__('All Properties'),array('controller' => 'properties', 'action' => 'index', 'admin'=>true),array('escape' => false));?></li>

					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit', 'aria-hidden'=>'true')).__('Reviews'),array('controller' => 'reviews', 'action' => 'index', 'admin'=>true),array('escape' => false));?></li>

					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-money', 'aria-hidden'=>'true')).__('Reservations'),array('controller' => 'reservations', 'action' => 'index', 'admin'=>true),array('escape' => false));?></li>

					<li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa fa-dot-circle-o', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Waiting Approvement')). $this->Html->tag('span','',array('id' => 'message_count')),array('controller' => 'properties', 'action' => 'waiting_approval', 'admin'=>true ),array('escape' => false));?></li>

					 <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-minus', 'aria-hidden'=>'true')).__('Deleted Properties'),array('controller' => 'properties', 'action' => 'deleted', 'admin'=>true),array('escape' => false));?></li>
				</ul>
			</li>

			<li class="treeview">
				<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-cubes"></i> <span><?php echo __('Site Specification'); ?></span>
					<span class="pull-right-container">
						<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li>
						<?php
							echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-usd', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Currencies'), array('class' => '')),array('controller' => 'currencies', 'action' => 'index', 'admin'=>true),array('escape' => false));
						?>
					</li>
					<li>
						<?php
							echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-language', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Languages'), array('class' => '')),array('controller' => 'languages', 'action' => 'index', 'admin'=>true),array('escape' => false));
						?>
					</li>
					<li>
						<?php
							echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-globe', 'aria-hidden'=>'true')).$this->Html->tag('span', __('Countries'), array('class' => '')),array('controller' => 'countries', 'action' => 'index', 'admin'=>true),array('escape' => false));
						?>
					</li>
					<li class="treeview">
						<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-flag-o"></i><span><?php echo __('Neighborhoods'); ?></span>
							<span class="pull-right-container">
								<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview">
								<?php
								echo $this->Html->link($this->Html->tag('span', __('All Cities'), array('class' => '')),array('controller' => 'cities', 'action' => 'index', 'admin'=>true),array('escape' => false));
								?>
							</li>
							<li>
								<?php
									echo $this->Html->link($this->Html->tag('span', __('Add City'), array('class' => '')),array('controller' => 'cities', 'action' => 'add', 'admin'=>true),array('escape' => false));
								?>
							</li>
							<li class="treeview">
								<?php
								echo $this->Html->link($this->Html->tag('span', __('All Placess'), array('class' => '')),array('controller' => 'city_places', 'action' => 'index', 'admin'=>true),array('escape' => false));
								?>
							</li>
							<li>
								<?php
									echo $this->Html->link($this->Html->tag('span', __('Add new place'), array('class' => '')),array('controller' => 'city_places', 'action' => 'add', 'admin'=>true),array('escape' => false));
								?>
							</li>
						</ul>
					</li>

					<li class="treeview">
						<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-comments-o"></i><span><?php echo __('FAQ-s'); ?></span>
							<span class="pull-right-container">
								<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview">
								<?php
								echo $this->Html->link($this->Html->tag('span', __('All'), array('class' => '')),array('controller' => 'faqs', 'action' => 'index', 'admin'=>true),array('escape' => false));
								?>
							</li>
							<li>
								<?php
									echo $this->Html->link($this->Html->tag('span', __('New'), array('class' => '')),array('controller' => 'faqs', 'action' => 'add', 'admin'=>true),array('escape' => false));
								?>
							</li>
						</ul>
					</li>
					<li class="treeview">
						<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-image"></i><span><?php echo __('Home Slider'); ?></span>
							<span class="pull-right-container">
								<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview">
								<?php
								echo $this->Html->link($this->Html->tag('span', __('All'), array('class' => '')),array('controller' => 'home_sliders', 'action' => 'index', 'admin'=>true),array('escape' => false));
								?>
							</li>
							<li>
								<?php
									echo $this->Html->link($this->Html->tag('span', __('New'), array('class' => '')),array('controller' => 'home_sliders', 'action' => 'add', 'admin'=>true),array('escape' => false));
								?>
							</li>
						</ul>
					</li>
				</ul>
			</li>

			<li class="treeview">
				<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-home"></i> <span><?php echo __('Property Specification'); ?></span>
					<span class="pull-right-container">
						<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="treeview">
						<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-bed"></i><span><?php echo __('Accommodation Types'); ?></span>
							<span class="pull-right-container">
								<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview">
								<?php
								echo $this->Html->link($this->Html->tag('span', __('All'), array('class' => '')),array('controller' => 'accommodation_types', 'action' => 'index', 'admin'=>true),array('escape' => false));
								?>
							</li>
							<li>
								<?php
									echo $this->Html->link($this->Html->tag('span', __('New'), array('class' => '')),array('controller' => 'accommodation_types', 'action' => 'add', 'admin'=>true),array('escape' => false));
								?>
							</li>
						</ul>
					</li>

					<li class="treeview">
						<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-home"></i><span><?php echo __('Room Types'); ?></span>
							<span class="pull-right-container">
								<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview">
								<?php
								echo $this->Html->link($this->Html->tag('span', __('All'), array('class' => '')),array('controller' => 'room_types', 'action' => 'index', 'admin'=>true),array('escape' => false));
								?>
							</li>
							<li>
								<?php
									echo $this->Html->link($this->Html->tag('span', __('New'), array('class' => '')),array('controller' => 'room_types', 'action' => 'add', 'admin'=>true),array('escape' => false));
								?>
							</li>
						</ul>
					</li>

					<li class="treeview">
						<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-cogs"></i><span><?php echo __('Characteristics'); ?></span>
							<span class="pull-right-container">
								<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview">
								<?php
								echo $this->Html->link($this->Html->tag('span', __('All'), array('class' => '')),array('controller' => 'characteristics', 'action' => 'index', 'admin'=>true),array('escape' => false));
								?>
							</li>
							<li>
								<?php
									echo $this->Html->link($this->Html->tag('span', __('New'), array('class' => '')),array('controller' => 'characteristics', 'action' => 'add', 'admin'=>true),array('escape' => false));
								?>
							</li>
						</ul>
					</li>

					<li class="treeview">
						<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-lock" ></i><span><?php echo __('Safeties'); ?></span>
							<span class="pull-right-container">
								<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview">
								<?php
								echo $this->Html->link($this->Html->tag('span', __('All'), array('class' => '')),array('controller' => 'safeties', 'action' => 'index', 'admin'=>true),array('escape' => false));
								?>
							</li>
							<li>
								<?php
									echo $this->Html->link($this->Html->tag('span', __('New'), array('class' => '')),array('controller' => 'safeties', 'action' => 'add', 'admin'=>true),array('escape' => false));
								?>
							</li>
						</ul>
					</li>


				</ul>
			</li>

			<li class="">
				<?php 
					echo $this->Html->link(
						$this->Html->tag('i', '', array('class' => 'fa fa-newspaper-o', 'aria-hidden'=>'true')) . 
						$this->Html->tag('span', __('Manage Static Pages')),
						array('controller' => 'pages', 'action' => 'index', 'admin'=>true), 
						array('escape' => false)
					); 
				?>
			</li>

			<li>
				<?php 
					echo $this->Html->link(
						$this->Html->tag('i', '', array('class' => 'fa fa-envelope', 'aria-hidden'=>'true')).$this->Html->tag('span', __('All Contacts')),
						array('controller' => 'contacts', 'action' => 'index', 'admin'=>true),
						array('escape' => false)
					);
				?>
			</li>
			
			<!--
			<li class="treeview">
				<a href="javascript: void(0);"><i aria-hidden="true" class="fa fa-link"></i> <span>Multilevel</span>
					<span class="pull-right-container">
						<i aria-hidden="true" class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="#">Link in level 2</a></li>
					<li><a href="#">Link in level 2</a></li>
				</ul>
			</li>
			-->
		</ul>
	</div>
</aside>