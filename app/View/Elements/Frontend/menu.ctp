<!--
navbar-default can be changed with navbar-ct-blue navbar-ct-azzure navbar-ct-red navbar-ct-green navbar-ct-orange
-->
<nav id="main_menu" class="navbar navbar-ct-blue navbar-fixed-top navbar-transparent emcms-navbar">
	<div class="em-container container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button class="navbar-toggle hamburger hamburger--spin ssm-toggle-nav" name="menu-toggle" value="toggle">
				<span class="sr-only"><?php echo __('Toggle navigation');?></span>
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</button>
			<?php //$this->Html->url(['controller' => 'properties', 'action' => 'index'], true ); ?>
			<a class="navbar-brand navbar-brand-logo" href="<?php echo Router::url(['controller' => 'properties', 'action' => 'index'], true ); ?> ">
				<div class="logo">
					<?php echo $this->Html->image('general/logo.png', array('class'=>'img-responsive','alt'=> 'logo')) ?>
				</div>
				<div class="brand"><?php echo Configure::read('Website.name');?></div>
			</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav pull-right">
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-list"></i>
						<p><?php echo __('Pages'); ?><b class="caret"></b></p>
					</a>
					<?php echo $this->element('menu', array('ul' => array('class' => 'dropdown-menu pull-right'))); ?>
				</li>
				<?php if (AuthComponent::user()): ?>
					<?php $messages = $this->requestAction('/messages/getCount'); ?>
					<li>
						<a href="<?php echo $this->Html->url(array("controller" => "messages","action" => "index", "all"), true); ?>">
							<i class="fa fa-envelope">
								<span class="label em-message-count"><?php echo ($messages > 0) ? $messages : ''; ?></span>
							</i>
							<p><?php echo __('Messages');?></p>
						</a>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user"></i>
                            <p><?php echo h(AuthComponent::user('name'));?>&nbsp;<b class="caret"></b></p>
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
							<?php
								echo $this->Html->link(__('Dashboard'), ['controller' => 'users', 'action' => 'dashboard'],array('escape' => false, 'class'=>''))
							?>
							</li>
							<li>
							<?php
								echo $this->Html->link(__('Your Listings'), ['controller' => 'properties', 'action' => 'listings'],array('escape' => false, 'class'=>''))
							?>
							</li>
							<li>
							<?php
								echo $this->Html->link(__('Your Reservations'), ['controller' => 'reservations', 'action' => 'my_reservations'],array('escape' => false, 'class'=>''))
							?>
							</li>
							<li>
							<?php
								echo $this->Html->link(__('Your Trips'), ['controller' => 'reservations', 'action' => 'my_trips'],array('escape' => false, 'class'=>''))
							?>
							</li>
							<li>
							<?php
								echo $this->Html->link(__('Wish List'), ['controller' => 'wishlists', 'action' => 'index'],array('escape' => false, 'class'=>''))
							?>
							</li>
							<li>
							<?php
								echo $this->Html->link(__('Reviews'), ['controller' => 'reviews', 'action' => 'index'],array('escape' => false, 'class'=>''))
							?>
							</li>
							<li>
							<?php
                                echo $this->Html->link(__('Edit Profile'),array('controller' => 'users', 'action' => 'edit', AuthComponent::user('id')),array('escape' => false, 'class'=>''));
                            ?>
                            </li>
							<li class="divider"></li>
							<?php if (AuthComponent::user('role') === 'admin'): ?>
							<li>
							<?php
								 echo $this->Html->link(__('Admin Panel'),['admin'=>true,'controller' => 'users', 'action' => 'dashboard'],array('escape' => false, 'class'=>''))
							?>
							</li>
							<?php endif ?>
							<li>
							<?php
								echo $this->Html->link(__('Sign Out'),array('controller' => 'users', 'action' => 'logout', 'admin'=>false),array('escape' => false, 'class'=>''));
							?>
							</li>
						</ul>
					</li>
				<?php else: ?>
					<li>
						<?php
						echo $this->Html->link(
								$this->Html->tag('i','', ['class'=>'fa fa-plus', 'aria-hidden'=>'true']).
								$this->Html->tag('p',__('List your space')),
								array('controller' => 'properties', 'action' => 'add'),
								array('escape' => false, 'class'=>'')
							);
						?>
					</li>
					<!-- 
                    <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-life-ring"></i>
							<p>Help <b class="caret"></b></p>
						</a>
						<ul class="dropdown-menu pull-right">
							<li><a href="#0">Need help on this page?</a></li>
							<li><a href="#0">How to become a host?</a></li>
							<li><a href="#0">FAQ-s</a></li>
						</ul>
					</li>
                    -->
					<li>
						<?php
						echo $this->Html->link(
								$this->Html->tag('i','', ['class'=>'fa fa-sign-in', 'aria-hidden'=>'true']).
								$this->Html->tag('p',__('Sign in')),
								array('controller' => 'users', 'action' => 'login', 'admin'=>false, 'user'=>false),
								array('escape' => false, 'class'=>'')
							);
						?>
					</li>
					<li>
						<?php
						echo $this->Html->link(
								$this->Html->tag('i','', ['class'=>'fa fa-user-plus', 'aria-hidden'=>'true']).
								$this->Html->tag('p',__('Sign up')),
								array('controller' => 'users', 'action' => 'signup', 'admin'=>false, 'user'=>false),
								array('escape' => false, 'class'=>'')
							);
						?>
					</li>
				<?php endif ?>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>