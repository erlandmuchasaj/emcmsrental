<div class="articles view">
<h2><?php echo __('Article'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($article['Article']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($article['User']['name'], array('controller' => 'users', 'action' => 'view', $article['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Article title'); ?></dt>
		<dd>
			<?php echo h($article['Article']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($article['Category']['name'], array('controller' => 'categories', 'action' => 'view', $article['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Article Date'); ?></dt>
		<dd>
			<?php echo h($article['Article']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Article Summary'); ?></dt>
		<dd>
			<?php echo h($article['Article']['summary']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Article Content'); ?></dt>
		<dd>
			<?php echo h($article['Article']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Article Tags'); ?></dt>
		<dd>
			<?php echo h($article['Article']['tags']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Slug'); ?></dt>
		<dd>
			<?php echo h($article['Article']['slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($article['Article']['type']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false, 'class'=>'btn btn-danger')); ?>