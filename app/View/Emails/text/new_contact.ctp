<?php echo __('Hi %s,', $siteName);?>


<?php echo __('The %s form has been submitted at %s.', $contact['Contact']['type'], $siteName);?>


<?php echo __('The details are:');?>


<?php echo __('Name: %s', h($contact['Contact']['name'])); ?>


<?php echo __('Email Address: %s', $contact['Contact']['email']); ?>


<?php if (!empty($contact['Contact']['subject'])) : ?>
<?php echo __('Subject: %s', h($contact['Contact']['subject'])); ?>


<?php endif; ?>
<?php echo __('Message:'); ?>

<?php echo h($contact['Contact']['message']); ?>