<?php
	echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
	// debug($wishlists);
?>
<div class="em-container make-top-spacing">
	<div class="row" id="elementToMask">
		<div class="col-lg-3 col-md-4 user-sidebar">
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8">
			<header class="panel-heading clearfix">
				<?php echo $this->Html->tag('h3', __('My Wishlist'), ['class'=>'pull-left'])?>
				<div class="pull-right">
					<?php
						echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus')).'&nbsp;'.__('New Wishlist'),array('controller' => 'wishlists', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-primary no-border btn-sm')); 
					?>
				</div> 
			</header>
			<div class="row wishlists-body">
			<?php foreach ($wishlists as $wishlist): 
				$elementId = (int)$wishlist['Wishlist']['id'];
			?>
			<div class="property col-md-4 col-sm-4 col-xs-12 parent-element wishlist">
				<figure class="effect-oscar">
					<div style="background-image:url('<?php echo $wishlist['Wishlist']['thumbnail']; ?>');" class="background_preview">
						<?php 
							echo $this->Html->image('general/noimg/empty.png', array('alt' => 'image', 'class'=>'img-responsive invisible', 'style'=>'visibility:hidden'));
						?>
					</div>
					<figcaption>
						<?php 
							echo $this->Html->tag('h2', EMCMS_strtoupper($wishlist['Wishlist']['name'])); 
							$count = __n('%s Listing', '%s Listings', $wishlist['Wishlist']['count'], $wishlist['Wishlist']['count']);
							echo $this->Html->tag('p', $count); 

							echo $this->Html->link(__('View more'), array('controller' =>'wishlists','action' => 'view', $wishlist['Wishlist']['id']), array('escape' => false, 'class'=>''));
						?>
					</figcaption>
				</figure>
				<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash-o')),array('controller'=>'wishlists','action' => 'delete', $elementId), array('escape' => false, 'class'=>'btn btn-danger btn-sm wishlist-btn'), __("Are you sure you want to delete %s?", [h($wishlist['Wishlist']['name'])])); 
				?>
			</div>
			<?php endforeach; ?>
			</div>

			<!-- pagination START -->
			<?php echo $this->element('Pagination/counter'); ?>
			<?php echo $this->element('Pagination/navigation'); ?>
		</div>
	</div>	
</div>