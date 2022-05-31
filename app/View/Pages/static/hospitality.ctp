<div class="em-container make-top-spacing">
	<div class="row">
		<div class="col-md-12">
			<?php
				if (!empty($page['Page']['content'])) {
					echo getDescriptionHtml($page['Page']['content']);
				}
			?>
		</div>
	</div>
</div>