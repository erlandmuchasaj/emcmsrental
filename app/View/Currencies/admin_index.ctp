<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-em">
            <header class="panel-heading">
            	<?php echo $this->Html->tag('h4',__('Currencies'),array('class' => 'display-inline-block')) ?>
                <span class="tools pull-right">
                    <?php  echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')). ' ' .__('New Currency'),array('action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
                    ?>
                 </span>
            </header>
            <div class="panel-body table-responsive event-table">
				<table class="table general-table">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('code'); ?></th>
							<th><?php echo $this->Paginator->sort('symbol'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($currencies as $currency): ?>
							<tr>
								<td data-th="<?php echo __('Name');?>" >
									<?php 
										echo $this->Html->link(h($currency['Currency']['name']),array('action' => 'view', $currency['Currency']['id']),array('escape' => false));
									?>
								</td>
								<td data-th="<?php echo __('Code');?>" ><?php echo h($currency['Currency']['code']); ?></td>
								<td data-th="<?php echo __('Symbol');?>" ><?php echo $currency['Currency']['symbol']; ?></td>
								<td class="actions">
									<?php 
										if ($currency['Currency']['status']) {
											echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-check-square-o')),array('action' => 'disable', $currency['Currency']['id']) , array('escape' => false, 'class'=>'btn btn-success btn-sm', 'data-toggle'=>'tooltip', 'title'=>__('Disable this currency')), __('Are you sure you want to disable this currency?')).'&nbsp;'; 
										} else {
											echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-minus-square-o')),array('action' => 'enable', $currency['Currency']['id']) , array('escape' => false, 'class'=>'btn btn-danger btn-sm', 'data-toggle'=>'tooltip', 'title'=>__('Enable this currency')), __('Are you sure you want to enable this currency?')).'&nbsp;';
										}

										if ((int)$currency['Currency']['is_default'] == 0) {
											echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-exclamation-circle', 'aria-hidden' => 'true')) . '&nbsp;' .__('Make default'), array('action' => 'makeDefault', $currency['Currency']['id']) , array('escape' => false, 'class'=>'btn btn-warning btn-sm', 'data-toggle'=>'tooltip', 'title'=>__('Set as default')), __('Are you sure you want to make this your default currency?')).'&nbsp;';

											echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa  fa-edit')).'&nbsp;'.__('Edit'),array('action' => 'edit', $currency['Currency']['id']),array('escape' => false, 'class'=>'btn btn-info btn-sm')) . '&nbsp;'; 


											echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-cancel', 'aria-hidden' => 'true')).__('Delete'), array('action' => 'delete', $currency['Currency']['id']) , array('escape' => false, 'class'=>'btn btn-danger btn-sm',), __('Are you sure you want delete this currency? ')) . '&nbsp;';
										}
									?>
								</td> 
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
            </div>
        </div>
    </div>
</div>
<!-- pagination START -->
<div class="row">
	<div class="col-xs-12">
		<?php echo $this->element('Pagination/counter'); ?>
		<?php echo $this->element('Pagination/navigation'); ?>
	</div>
</div>