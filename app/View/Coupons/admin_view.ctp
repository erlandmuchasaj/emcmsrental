<div class="coupons view">
<h2><?php echo __('Coupon'); ?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php 
				if ($coupon['Coupon']['price_type']==1) {
				 	# we have a percentage coupon
				 	echo round($coupon['Coupon']['price_value'], 0)."% ({$coupon['Coupon']['currency']})";
				} elseif ($coupon['Coupon']['price_type']==2) {
					# we have a fixed value coupon
					echo $this->Number->currency($coupon['Coupon']['price_value'], $coupon['Coupon']['currency'], ['thousands' => ',', 'decimals' => '.']);
				} 									  
			?>
		</dd>
		<dt><?php echo __('Coupon Type'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['coupon_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quantity'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['quantity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date From'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['date_from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date To'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['date_to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Purchase Count'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['purchase_count']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Currency'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['currency']); ?>
			&nbsp;
		</dd>

	</dl>
</div>
