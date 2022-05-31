<div class="hero-page" style="margin-top: 80px;">
	<div style="background-image: url(<?php echo $this->webroot.'img/uploads/Static/why-host.jpg'; ?>);" class="hero-page__image">
	</div>
	<div class="hero-txt">
		<h1 class="hero-txt__main"><?php echo __("It's simple to become a %s host", Configure::read('Website.name')); ?></h1>
		<div>
		<?php 
			echo $this->Html->link(__('Become a host'),
				['controller' => 'properties', 'action' => 'add'],
				['escape' => false, 'target'=>'_blank', 'class'=>'hero-txt__primary-btn btn']
			);

			echo $this->Html->link(__('Learn More'),
				'#why_host_learn_more',
				['escape' => false, 'target' => '_blank', 'class' => 'hero-txt__second-btn js-scroll-to', 'data-offset-top' => '85']
			);
		?>
		</div>
	</div>
</div>
<div class="em-container make-top-spacing" id="why_host_learn_more">
	<div class="row">
		<div class="col-md-12 overflow-hidden">
			<div class="card-element">
				<div class="card-element__number">1</div>
				<div class="card-element__text">
					<div class="card-element__text--main"><?php echo __("Create your listing"); ?></div>
					<div class="card-element__text--desc">Simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s.
					</div>
					<div class="card-element__text--desc">Maecenas non scelerisque purus, congue cursus arcu. Donec vel dapibus mi. Mauris maximus posuere placerat. Sed et libero eu nibh tristique mollis a eget lectus</div>
				</div>
				<div class="card-element__image">
				<?php 
					echo $this->Html->image('uploads/Static/step_1.jpeg', array('alt' => 'image','fullBase' => true, 'class' => 'img-responsive'));  
				?>
				</div>
			</div>

			<div class="card-element">
				<div class="card-element__image visible-md visible-lg card-element__image--left">
					<?php 
						echo $this->Html->image('uploads/Static/step_2.jpeg', array('alt' => 'image','fullBase' => true, 'class' => 'img-responsive'));  
					?>
					<!-- <img class="_2y3jn" src="/assets/00558672.jpeg"> -->
				</div>
				<div class="card-element__number">2</div>
				<div class="card-element__text">
					<div class="card-element__text--main"><?php echo __("Welcome your guests"); ?></div>
					<div class="card-element__text--desc">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</div>
					<div class="card-element__text--desc">Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy.</div>
					<div class="card-element__text--desc">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
				</div>
				<div class="card-element__image hidden-md hidden-lg">
					<?php 
						echo $this->Html->image('uploads/Static/step_2.jpeg', array('alt' => 'image','fullBase' => true, 'class' => 'img-responsive'));  
					?>
				</div>
			</div>

			<div class="card-element">
				<div class="card-element__number">3</div>
				<div class="card-element__text">
					<div class="card-element__text--main"><?php echo __("Getting paid safely"); ?></div>
					<div class="card-element__text--desc">Simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s.
					</div>
					<div class="card-element__text--desc">Maecenas non scelerisque purus, congue cursus arcu. Donec vel dapibus mi. Mauris maximus posuere placerat. Sed et libero eu nibh tristique mollis a eget lectus</div>
				</div>
				<div class="card-element__image">
				<?php 
					echo $this->Html->image('uploads/Static/step_3.jpeg', array('alt' => 'image','fullBase' => true, 'class' => 'img-responsive'));  
				?>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<?php
				if (!empty($page['Page']['content'])) {
					echo getDescriptionHtml($page['Page']['content']);
				}
			?>
		</div>
	</div>
</div>