<?php echo __('Reset Password'); ?>
<?php
	if (isset($content) && !empty($content)) {
		$content = explode("\n", $content);
		foreach ($content as $line):
			echo $line . "\n";
		endforeach;
	}
?>
