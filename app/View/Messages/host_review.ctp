<?php
	/*This css is applied only to this page*/		 
	echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
?>
<div class="em-container make-top-spacing">
	<div class="row" id="elementToMask">
		<div class="col-lg-3 col-md-4 user-sidebar">
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8">
			<div class="panel panel-warning panel-table">
				<header class="panel-heading clearfix">
					<?php echo __('Host Review'); ?>
				</header>
				<?php if (isset($review) && !empty($review)){ ?>
					<table class="table table-th-block">
						<tbody>
							<tr>
								<td class="active"><i class="fa fa-user-plus"></i>&nbsp;<?php echo __('Title'); ?>:</td>
								<td><?php echo h($review['Review']['title']);?></td>
							</tr>
							<tr>
								<td class="active"><i class="fa fa-home"></i>&nbsp;<?php echo __('review'); ?>:</td>
								<td><?php echo h($review['Review']['review']);?></td>
							</tr>
							<tr>
								<td class="active"><i class="fa fa-bed"></i>&nbsp;<?php echo __('Cleanliness'); ?>:</td>
								<td><?php echo h($review['Review']['cleanliness']);?></td>
							</tr>
							<tr>
								<td class="active"><i class="fa fa-smile-o"></i>&nbsp;<?php echo __('Communication'); ?>:</td>
								<td><?php echo h($review['Review']['communication']);?></td>
							</tr>
							<tr>
								<td class="active"><i class="fa fa-bar-chart"></i>&nbsp;<?php echo __('Observations of house rules'); ?>:</td>
								<td><?php echo h($review['Review']['house_rules']);?></td>
							</tr>
						</tbody>
					</table>
				<?php } else { ?>
					<h3><?php echo __("Nothing to show you."); ?></h3>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
