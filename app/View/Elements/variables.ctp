<?php
	$configuration = $this->requestAction('/users/getConfiguration');
	// Set the model and controller
	$current_controller = $this->params['controller'];
	$current_action 	= $this->params['action'];

	if ('properties' ===  $current_controller && 'index' === $current_action) {
		$class = 'homepage';
	} else {
		$class = $current_controller . '_' . $current_action;
	}
	// debug($configuration);
?>
<script>
	var languages = new Array(),
		php_self = "<?php echo rtrim(Router::Url(null, true), '/\\'); ?>",
		fullBaseUrl = "<?php echo rtrim(Router::Url('/', true), '/\\'); ?>",
		google_map_key = "<?php echo Configure::read('Google.key'); ?>",
		currency = "<?php echo addslashes($configuration['currency']); ?>",
		language_code = "<?php echo addslashes($configuration['language_code']); ?>",
		current_controller = "<?php echo $current_controller; ?>",
		current_action = "<?php echo $current_action; ?>",
		page_class = "<?php echo $class; ?>",
		USER_ID = "<?php echo AuthComponent::user('id'); ?>",
		id_currency = "<?php echo $configuration['default_currency']; ?>",
		id_language = "<?php echo $configuration['default_language']; ?>";
</script>

<?php if (Configure::check('Website.google_analytics_active') && (int)Configure::read('Website.google_analytics_active') === 1): ?>
	<?php echo Configure::read('Website.google_analytics'); ?>
<?php endif ?>