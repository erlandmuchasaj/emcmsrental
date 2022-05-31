<!--header start-->
<header class="main-header">
	<!-- Logo -->
	<?php
		echo $this->Html->link(
			$this->Html->tag('span', 
				$this->Html->image('general/logo_mini.png', 
					array('alt' => 'logo', 'class'=>'img-circle')
				), 
				array('class' => 'logo-mini')
			).
			$this->Html->tag('span', 
				'<b>EM</b>CMS', 
				array('class' => 'logo-lg')
			),
			array('controller' => 'users', 'action' => 'dashboard', 'admin'=>true),
			array('escape' => false, 'class'=>'logo')
		);
	?>
	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="javascript:;" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<?php if (false): ?>			
				<!-- Messages: style can be found in dropdown.less-->
				<li class="dropdown messages-menu">
					<!-- Menu toggle button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope-o"></i>
						<span class="label label-success">4</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 4 messages</li>
						<li>
							<!-- inner menu: contains the messages -->
							<ul class="menu">
								<li><!-- start message -->
									<a href="#">
										<div class="pull-left">
											<!-- User Image -->
											<?php echo $this->Html->image('avatars/avatar.jpg', array('alt' => 'User image', 'class'=>'img-circle')); ?>
										</div>
										<!-- Message title and timestamp -->
										<h4>Support Team<small><i class="fa fa-clock-o"></i> 5 mins</small></h4>
										<!-- The message -->
										<p>Why not buy a new awesome theme?</p>
									</a>
								</li>
								<!-- end message -->
							</ul>
							<!-- /.menu -->
						</li>
						<li class="footer"><a href="#">See All Messages</a></li>
					</ul>
				</li>
				<!-- /.messages-menu -->

				<!-- Notifications Menu -->
				<li class="dropdown notifications-menu">
					<!-- Menu toggle button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i>
						<span class="label label-warning">10</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 10 notifications</li>
						<li>
							<!-- Inner Menu: contains the notifications -->
							<ul class="menu">
								<li><!-- start notification -->
									<a href="#">
										<i class="fa fa-users text-aqua"></i> 5 new members joined today
									</a>
								</li>
								<!-- end notification -->
							</ul>
						</li>
						<li class="footer"><a href="#">View all</a></li>
					</ul>
				</li>

				<!-- Tasks Menu -->
				<li class="dropdown tasks-menu">
					<!-- Menu Toggle Button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-flag-o"></i>
						<span class="label label-danger">9</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 9 tasks</li>
						<li>
							<!-- Inner menu: contains the tasks -->
							<ul class="menu">
								<li><!-- Task item -->
									<a href="#">
										<!-- Task title and progress text -->
										<h3>
										Design some buttons
										<small class="pull-right">20%</small>
										</h3>
										<!-- The progress bar -->
										<div class="progress xs">
											<!-- Change the css width attribute to simulate progress -->
											<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
												<span class="sr-only">20% Complete</span>
											</div>
										</div>
									</a>
								</li>
							<!-- end task item -->
							</ul>
						</li>
						<li class="footer">
							<a href="#">View all tasks</a>
						</li>
					</ul>
				</li>
				<?php endif; ?>

				<!-- User Account Menu -->
				<?php 
				$userAvatar = 'avatars/avatar.jpg';
				if (AuthComponent::user()) {
					$directorySM = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS.'small'.DS;
					if (file_exists($directorySM.AuthComponent::user('image_path')) && is_file($directorySM.AuthComponent::user('image_path'))) {
						$userAvatar = 'uploads/User/small/'.h(AuthComponent::user('image_path'));
					}
				?> 
				<li class="dropdown user user-menu">
					<!-- Menu Toggle Button -->
					<a href="javascript: void(0);" class="dropdown-toggle" data-toggle="dropdown">
						<!-- The user image in the navbar-->
						<?php echo $this->Html->image($userAvatar, array('alt' => 'User image', 'class'=>'user-image')); ?>
						<!-- hidden-xs hides the username on small devices so only the image appears. -->
						<?php echo $this->Html->tag('span',h(AuthComponent::user('name').' '.AuthComponent::user('surname')),array('class' => 'hidden-xs')) ?>
					</a>
					<ul class="dropdown-menu">
						<!-- The user image in the menu -->
						<li class="user-header">
							<?php echo $this->Html->image($userAvatar, array('alt' => 'User image', 'class'=>'img-circle')); ?>
							<p>
								<?php echo h(AuthComponent::user('name').' '.AuthComponent::user('surname')); ?>
								<small><?php echo $this->Time->niceShort(AuthComponent::user('created')); ?></small>
							</p>
						</li>
						<!-- Menu Body -->
						<li class="user-body">
							<div class="row">
								<div class="col-sm-5">
									<?php
										echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-users')) . __('All users'),array('admin'=>true, 'controller' => 'users', 'action' => 'index'),array('escape' => false));
									?>
								</div>
								
								<div class="col-sm-7">
									<?php echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-edit')) . __('Change password'),array( 'admin'=>true, 'controller' => 'users', 'action' => 'changepassword', AuthComponent::user('id')),array('escape' => false, 'class'=>'')); ?>
								</div>
							</div>
							<!-- /.row -->
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<?php  
									echo $this->Html->link(__('Profile'),array('admin'=>true, 'controller' => 'users', 'action' => 'profile', AuthComponent::user('id')),array('escape' => false, 'class'=>'btn btn-default btn-flat'));
								?>
							</div>
							<div class="pull-right">
								<?php  
									echo $this->Html->link(__('Sign out'),array('admin'=>false, 'controller' => 'users', 'action' => 'logout'),array('escape' => false, 'class'=>'btn btn-default btn-flat'));
								?>
							</div>
						</li>
					</ul>
				</li>
				<?php } ?>
				<li>
					<a href="javascript:;"></a>
				</li>

				<!-- Control Sidebar Toggle Button -->
				<!--
				<li>
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
				</li>
				-->
			</ul>
		</div>
	</nav>
</header>
<!--header end-->