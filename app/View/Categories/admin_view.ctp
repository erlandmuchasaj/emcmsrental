<h3><?php echo __('Categories (View)'); ?></h3>
<div class="row">
	<div class="col-md-12">
		<form class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Id'); ?></label>
				<div class="col-sm-5"><?php echo h($category['Category']['id']); ?></div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Category Name'); ?></label>
				<div class="col-sm-5"><?php echo h($category['Category']['name']); ?></div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Category slug'); ?></label>
				<div class="col-sm-5"><?php echo h($category['Category']['slug']); ?></div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Category model'); ?></label>
				<div class="col-sm-5"><?php echo h($category['Category']['model']); ?></div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Category Description'); ?></label>
				<div class="col-sm-5"><?php echo h($category['Category']['description']); ?></div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Status'); ?></label>
				<div class="col-sm-5"><?php echo ($category['Category']['status']) ? 'Active' : 'Not Active'; ?></div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Created'); ?></label>
				<div class="col-sm-5"><?php echo h($category['Category']['created']); ?></div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo __('Last Modified'); ?></label>
				<div class="col-sm-5"><?php echo h($category['Category']['modified']); ?></div>
			</div>

			<div class="form-actions">
				<?php echo $this->Html->link(__('New'), array('action' => 'add', $category['Category']['model']), array('class'=>'btn btn-success')); ?>
				
				<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $category['Category']['id']),array('class'=>'btn  btn-info')); ?>

				<?php echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('class'=>'btn btn-primary')); ?>

				<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $category['Category']['id']), array('class'=>'btn btn-danger'), __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?>
			</div>
		</form>
	</div>
</div>
