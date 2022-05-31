<?php echo $this->Html->css('frontend/faq/style', null, array('block'=>'cssMiddle'));?>
<div class="em-container make-top-spacing">
	<div class="row">
		<div class="col-sm-12">
			<div class="cd-faq-categories">
				<h2><a class="selected" href="#basics"><?php echo __('Frequently Asked Questions'); ?></a></h2>
			</div> <!-- cd-faq-categories -->
			<div class="cd-faq-items">
				<ul id="basics" class="cd-faq-group">
					<?php foreach ($faqs as $faq): ?>
						<li class="faq_<?php echo h($faq['Faq']['id']);?>">
							<a class="cd-faq-trigger" href="javascript:void(0);"><?php echo h($faq['Faq']['question']); ?></a>
							<div class="cd-faq-content"><?php echo getDescriptionHtml($faq['Faq']['answer']); ?></div>
							<!-- cd-faq-content -->
						</li>
					<?php endforeach; ?>
				</ul> <!-- cd-faq-group -->
			</div> <!-- cd-faq-items -->
			<a href="javascript:void(0);" class="cd-close-panel"><?php echo __("Close");?></a>
		</div>
	</div>
	<!-- 
	<div class="row">
		<div class="col-xs-12">
			<?php // echo $this->element('Pagination/counter'); ?>
			<?php // echo $this->element('Pagination/navigation'); ?>
		</div>
	</div>
	-->
</div>
<?php
	echo $this->Html->script('frontend/faq/jquery.mobile.custom.min', array('block'=>'scriptBottomMiddle'));
	echo $this->Html->script('frontend/faq/main', array('block'=>'scriptBottomMiddle'));
?>