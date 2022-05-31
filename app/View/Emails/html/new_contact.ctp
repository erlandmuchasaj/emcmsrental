<p><?php echo __('Hi %s,', $siteName);?></p>

<p><?php echo __('The %s form has been submitted at %s.', $contact['Contact']['type'], $siteName);?></p>

<p><?php echo __('The details are:');?></p>

<p><?php echo __('Name: %s', $contact['Contact']['name']); ?></p>

<p><?php echo __('Email Address: %s', $contact['Contact']['email']); ?></p>

<?php if (!empty($contact['Contact']['subject'])) : ?>
    <p><?php echo __('Subject: %s', $contact['Contact']['subject']); ?></p>
<?php endif; ?>

<p>
    <?php echo __('Message:'); ?><br />
    <?php echo nl2br($contact['Contact']['message']); ?>
</p>


