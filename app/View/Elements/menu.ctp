<?php
$loadMenu = $emcms_topMenu;
if (!empty($type) && $type == 'bottom') {
	$loadMenu = $emcms_bottomMenu;
}

if (empty($ul['class'])) {
	$ul['class'] = 'dropdown sub-menu collapse';
}

if ($loadMenu) { ?>
	<!-- id="sub_pages" -->
	<ul <?php if (!empty($ul['class'])) : ?> class="<?php echo h($ul['class']); ?>"<?php endif; ?>>
		<!-- static element -->
		<li>
		<?php
			echo $this->Html->link(__('Blog'),array('controller' => 'articles', 'action' => 'index', 'admin'=>false),array('escape' => false, 'class'=>''));
		?>
		</li>
		<?php
			$options = array();
			if (!empty($li)) {
				$options['li'] = $li;
			}
			if (!empty($children)) {
				$options['children'] = $children;
			}
			echo $this->MenuBuilder->load($loadMenu, $options);
		?>
	</ul>
<?php } ?>