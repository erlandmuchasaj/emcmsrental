<?php echo __('Activate Acount'); ?>

<?php
	if (isset($content) && !empty($content)) {
		$content = explode("\n", $content);
		foreach ($content as $line):
			echo  $line . "\n";
		endforeach;
	}
?>

<?php if (isset($user_activation_link) && isset($user_activation_link)) { ?>
	<?php echo $this->Html->link(__('Active Account'), $user_activation_link, array('escape' => false)); ?>
<?php } ?>