<?php
/**
 * @link          http://erlandmuchasaj.com EMCMS(tm) Project
 * @package       app.View.Pages
 * @since         EMCMS(tm) v 1.0.0
 */
?>
<div  class="em-container make-top-spacing">
	<div class="row ">
		<div class="col-md-12">
			<?php 

				if (!empty($page['Page']['meta_title'])) {
					$this->set('title_for_layout', getDescriptionHtml($page['Page']['meta_title']));
				}

				if (!empty($page['Page']['meta_description'])) {
					$this->assign('meta_description', getDescriptionHtml($page['Page']['meta_description']));
				}
			?>

			<?php if (!empty($page['Page']['name'])): ?>
				<h1><?php echo h($page['Page']['name']); ?></h1>
			<?php endif ?>

			<?php if (!empty($page['Page']['sub_title'])): ?>
				<h3><?php echo h($page['Page']['sub_title']); ?></h3>
			<?php endif ?>

			<?php
				if (!empty($page['Page']['content'])) {
					echo getDescriptionHtml($page['Page']['content']);
				}
			?>
		</div>
	</div>
</div>
