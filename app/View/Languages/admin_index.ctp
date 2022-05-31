	<?php
		$directory = Configure::read('App.www_root'). 'img' .DS. 'flags' .DS;
	?>
	<div class='row'>
	    <div class='col-sm-12'>
	        <div class='panel panel-em'>
	            <header class='panel-heading'>
	            	<?php echo $this->Html->tag('h4',__('Languages'),array('class' => 'display-inline-block')) ?>
	                <span class='tools pull-right'>
	                    <?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus-square')). ' ' .__('New Language'),array('admin'=>true, 'controller' => 'languages', 'action' => 'add'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
	                    ?>
	                 </span>
	            </header>
	            <div class='panel-body table-responsive event-table'>
					<table class='table'>
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('name'); ?></th>
								<th><?php echo $this->Paginator->sort('language_code', __('Code')); ?></th>
								<th><?php echo $this->Paginator->sort('icon'); ?></th>
								<th class='actions text-left'><?php echo __('Actions'); ?></th> 
							</tr>
						</thead>
						<tbody>
							<?php foreach ($languages as $language): ?>
								<tr>
									<td data-th="<?php echo __('Name');?>" >
										<?php 
											echo $this->Html->link(h($language['Language']['name']),array('action' => 'view', $language['Language']['id']),array('escape' => false));
										?>	
									</td>
									<td data-th="<?php echo __('Code');?>" ><?php echo h($language['Language']['language_code']); ?>&nbsp;</td>
									<td data-th="<?php echo __('Icon');?>" >
										<?php 
											$base64 = 'flags/no-flag.png';
											$name = $language['Language']['language_code'].'.png';
											if (file_exists($directory.$name) && is_file($directory.$name)) { 
												$base64 =	'flags/'. $name;
											} 
											echo $this->Html->image($base64, array('alt' => 'image', 'class'=>'img-thumbnail img-responsive'));
										?>
									</td>
									
									<!-- 
									<td class='text-right'>
										<div class='btn-group text-right'>
											<button type='button' class='btn btn-danger btn-xs dropdown-toggle' data-toggle='dropdown' aria-expanded='false'> Canceled
												<span class='caret ml5'></span>
											</button>
											<ul class='dropdown-menu' role='menu'>
												<li>
													<a href='#'>Edit</a>
												</li>
												<li>
													<a href='#'>Delete</a>
												</li>
												<li>
													<a href='#'>Archive</a>
												</li>
												<li class='divider'></li>
												<li>
													<a href='#'>Complete</a>
												</li>
												<li class='active'>
													<a href='#'>Pending</a>
												</li>
												<li>
													<a href='#'>Canceled</a>
												</li>
											</ul>
										</div>
									</td> 
									-->										

									<td class='text-left actions'>
										<?php 
											if ($language['Language']['status']) {
												echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-check-square-o')),array('admin'=>true,'controller'=>'languages','action' => 'disable', $language['Language']['id']) , array('escape' => false, 'class'=>'btn btn-success btn-sm', 'data-toggle'=>'tooltip', 'title'=>__('Disable this language')), __('Are you sure you want to disable this language?')) . '&nbsp;'; 
											} else {
												echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-minus-square-o')),array('admin'=>true,'controller'=>'languages','action' => 'enable', $language['Language']['id']) , array('escape' => false, 'class'=>'btn btn-danger btn-sm', 'data-toggle'=>'tooltip', 'title'=>__('Enable this language')), __('Are you sure you want to enable this language?')) . '&nbsp;'; 
											}

											if ((int)$language['Language']['is_default'] == 0) {
												echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-exclamation-circle', 'aria-hidden' => 'true')).'&nbsp;'.__('Make default'), array('admin'=>true,'controller'=>'languages','action' => 'makeDefault', $language['Language']['id']) , array('escape' => false, 'class'=>'btn btn-warning btn-sm', 'data-toggle'=>'tooltip', 'title'=>__('Set as default')), __('Are you sure you want to make this your default language?')) . '&nbsp;';


												echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa  fa-edit')).'&nbsp;'.__('Edit'),array('action' => 'edit', $language['Language']['id']),array('escape' => false, 'class'=>'btn btn-info btn-sm')) . '&nbsp;'; 


												echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-cancel', 'aria-hidden' => 'true')).__('Delete'), array('admin'=>true,'controller'=>'languages','action' => 'delete', $language['Language']['id']) , array('escape' => false, 'class'=>'btn btn-danger btn-sm',), __('Are you sure you want delete this language? Every translation related to this language wil be deleted permanently.')) . '&nbsp;';
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
	<div class='row'>
		<div class='col-xs-12'>
			<?php echo $this->element('Pagination/counter'); ?>
			<?php echo $this->element('Pagination/navigation'); ?>
		</div>
	</div>
