<div class="box">
	<div class="box-header with-border">
		<?php echo $this->Html->tag('h4', __('Contacts'), array('class'=>'box-title'))?>
		<div class="box-tools pull-right">
			<?php
				echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')).'&nbsp;'.__('Add Contact'),array('admin'=>true, 'controller' => 'contacts', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
			?>
		</div>
	</div>

	<div class="well">
		<?php $base_url = array('admin'=>true,'controller' => 'contacts', 'action' => 'index');?>
		<?php echo $this->Form->create('Contact', array('url' => $base_url,'class' => 'form'));?>
			<fieldset class="form-group">
				<div class="input-group custom-search-form">
					<?php if (!empty($search)) : ?>
						<?php echo $this->Form->input('search', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Search...', 'div' => false, 'value' => $search));?>
					<?php else :
						echo $this->Form->input('search',
								array('type' => 'text',
									'class' => 'form-control',
									'placeholder' => 'Search...',
									'label' => false,
									'div' => false
								)
							);
					endif; ?>
					<span class="input-group-btn">
						<?php 
							echo $this->Form->button('<i class="fa fa-search"></i>',
								array('class' => 'btn btn-default',
									'escape' => false,
									'type' => 'submit',
									'div' => false,
									'label' => false
								)
							);
						?>
					</span>
				</div>
			</fieldset>
			<?php if (!empty($search)) : 
					echo $this->Html->link(__('Reset'), $base_url, array('class' => 'btn btn-sm btn-warnign','escape' => false)); 
				endif; 
			echo $this->Form->end();
		?>
		<div class="btn-group">
			<?php 
				echo $this->Html->link('Export CSV',array('admin'=>true,'controller'=>'contacts','action'=>'csv'), array('target'=>'_blank', 'class'=>'btn bg-olive btn-flat margin')); 

				echo $this->Html->link('Export XLS',array('admin'=>true,'controller'=>'contacts','action'=>'xls'), array('target'=>'_blank','class'=>'btn bg-navy btn-flat margin'));
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3 pull-left">
			<?php
				$default_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
				if($this->Session->check('per_page_count')) { 
					$default_count = $this->Session->read('per_page_count');
				}
			?>
			<select id="per_page_count" class="form-control selectboxit">
				<option value="5"  <?php echo ($default_count == '5') ? 'selected' : '' ; ?>>5</option>
				<option value="10" <?php echo ($default_count == '10') ? 'selected' : '' ; ?>>10</option>
				<option value="15" <?php echo ($default_count == '15') ? 'selected' : '' ; ?>>15</option>
				<option value="20" <?php echo ($default_count == '20') ? 'selected' : '' ; ?>>20</option>
				<option value="25" <?php echo ($default_count == '25') ? 'selected' : '' ; ?>>25</option>
				<option value="30" <?php echo ($default_count == '30') ? 'selected' : '' ; ?>>30</option>
				<option value="50" <?php echo ($default_count == '50') ? 'selected' : '' ; ?>>50</option>
				<option value="100" <?php echo ($default_count == '100') ? 'selected' : '' ; ?>>100</option>
			</select>
		</div>
	</div>
	<br />

	<div class="box-body event-table">
		<table class="table table-general">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('email'); ?></th>
					<th><?php echo $this->Paginator->sort('subject'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($contacts as $contact): ?>
					<?php $notRead = ($contact['Contact']['is_read']) ? '' : 'style="background:#FFFFD0;color:#00B0FF;"'; ?>
					<tr class="parent-element" <?php echo $notRead;?>>
						<td data-th="<?php echo __('Email');?>"><?php echo h($contact['Contact']['email']); ?>&nbsp;</td>
						<td data-th="<?php echo __('Subject');?>"><?php echo h($contact['Contact']['subject']); ?>&nbsp;</td>
						<td data-th="<?php echo __('Created');?>"><?php echo h($contact['Contact']['created']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('Edit').'&nbsp;'.$this->Html->tag('i', '', array('class' => 'fa fa-edit')), array('action' => 'edit', $contact['Contact']['id']),array('escape' => false, 'class'=>'btn btn-success btn-sm')); ?>
							
							<div data-toggle="tooltip" title="<?php echo __('View contact');?>">
							<?php
								echo $this->Html->link(__('View').'&nbsp;'.$this->Html->tag('i', '', array('class' => 'fa fa-info')),array('controller'=>'contacts','action' => 'view', $contact['Contact']['id']),array('escape' => false, 'class'=>'btn btn-info btn-sm', 'onclick'=>"javascript:changeStatus({$contact['Contact']['id']});")); 
							?>
							</div>

							<div data-toggle="tooltip" title="<?php echo __('Delete contact');?>">
								<?php
									$var = $var = h(addslashes($contact['Contact']['subject']));
									$elementId = (int)h($contact['Contact']['id']);
									echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-times')), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId},'{$var}', this); return false;", 'class'=>'btn btn-danger btn-sm', 'id'=>'element_'.$elementId));
								?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="box-footer clearfix">
		<?php echo $this->element('Pagination/counter'); ?>
		<?php echo $this->element('Pagination/navigation'); ?>
	</div>
</div>

<script>
/**
 * [ShowConfirmDelete Opem Confirmation box for when delating a row, Ajax]
 * @param {INT} id   [primary key of record]
 * @param {string} name [description]
 */
	function ShowConfirmDelete(id, name) {
		var $confirmModal = $('#modalConfirmYesNo'),
		 	$elementToMask = $('#elementToMask'),
			$rowToRemove = $('#element_'+id).closest('.parent-element');

		$confirmModal.modal('show');
		$('#lblMsgConfirmYesNo').html('<?php echo __('Are you sure you want to delete'); ?>: <b>' + name + '</b>?');
		$('#btnYesConfirmYesNo').off('click').on('click',function () {
			$confirmModal.modal('hide');
			$.ajax({
				url:'<?php echo Router::url(array('admin' => true,'controller' => 'contacts','action' => 'delete')); ?>/'+ id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Contact:{id:id,subject:name}}},
				beforeSend: function() {
					// called before response
					$elementToMask.mask('Waiting...');
				},
				success: function(data, textStatus, xhr) {
					//called when successful
					if (textStatus =='success') {
						var response = $.parseJSON(JSON.stringify(data));
						if (!response.error) {
							$rowToRemove.fadeOut(350,function() { this.remove() });
							toastr.success(response.message,'<?php echo __('Success!'); ?>');
						} else {
							toastr.error(response.message,'<?php echo __('Error!'); ?>');
						}
					} else {
						toastr.warning(textStatus,'<?php echo __('Warning!'); ?>');
					}
				},
				complete: function(xhr, textStatus) {
					//called when complete
					$confirmModal.modal('hide');
					$elementToMask.unmask();
				},
				error: function(xhr, textStatus, errorThrown) {
					//called when there is an error
					$elementToMask.unmask();
					toastr.error(errorThrown, 'Error!');
				}
			});
			return true;
		});

		$('#btnNoConfirmYesNo').off('click').on('click', function () {
			$confirmModal.modal('hide');
			return true;
		});
		return true;
	}

/**
 * [changeStatus this function changes the status of an email sent to administrator]
 * @param  {INT} id Primary key of the email read.
 * @return void
 */
	function changeStatus(id){
		$.ajax({
			type: 'POST',
			url:'<?php echo Router::url(array('admin'=>true,'controller' => 'contacts','action' => 'isRead')); ?>/'+ id,
			async: true,
			data:{data:{Contact:{id:id,is_read:1}}},
		});
	}
</script>