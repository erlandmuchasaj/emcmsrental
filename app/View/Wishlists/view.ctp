<?php
	echo $this->Html->css('users', null, array('block'=>'cssMiddle'));
?>
<div class="em-container make-top-spacing">
	<div class="row" id="elementToMask">
		<div class="col-lg-3 col-md-4 user-sidebar">
			<?php echo $this->element('Frontend/user_sidebar'); ?>
		</div>
		<div class="col-lg-9 col-md-8">
			<div class="panel panel-em no-border">
				<header class="panel-heading clearfix">
					<?php echo $this->Html->tag('h4', __('Wishlist: %s', $wishlist['Wishlist']['name']), ['class'=>'pull-left'])?>
					<div class="pull-right">
						<?php
							echo $this->Html->link($this->Html->tag('i','',array('class' => 'fa fa-plus')).'&nbsp;'.__('Go back to Wishlist'),array('controller' => 'wishlists', 'action' => 'index'),array('escape' => false, 'class'=>'btn btn-default btn-sm')); 
						?>
					</div> 
				</header>
				<div class="event-table">
					<table class="table general-table">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('address'); ?></th>
								<th><?php echo $this->Paginator->sort('note'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($userWishlist as $wishlistElement): 

								$elementId = (int)$wishlistElement['UserWishlist']['id'];
								$directorySmURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Property'.DS.$wishlistElement['Property']['id'].DS.'PropertyPicture'.DS.'small'.DS;
								$directorySmPATH = 'uploads/Property/'.$wishlistElement['Property']['id'].'/PropertyPicture/small/';
							?>
							<tr class="parent-element">
								<td data-th="<?php echo __('Property');?>" class="image">
									<?php 
									$base64 = 'placeholder.png';
									if (file_exists($directorySmURL.$wishlistElement['Property']['thumbnail']) && is_file($directorySmURL .$wishlistElement['Property']['thumbnail'])) { 	
										$base64 = $directorySmPATH.$wishlistElement['Property']['thumbnail'];
									}
									echo $this->Html->link($this->Html->image($base64, array('alt' => 'thumbnail', 'class'=>'img-responsive')), array('controller' => 'properties', 'action' => 'view', $wishlistElement['Property']['id']), array('escape'=>false, 'target' => '_blank', 'rel' => 'noopener noreferrer')); 
									?>
									<br>
									<span class="help">
										<?php echo h($wishlistElement['Property']['country']); ?>
									</span>
								</td>
								<td data-th="<?php echo __('Note');?>">
									<?php echo h($wishlistElement['UserWishlist']['note']);?>
								</td>
								<td class="actions">
									<div class="btn-group">
										<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo __('Actions');?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right" role="menu">
											<li>
												<?php 
													echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')).'&nbsp;'.__('View property'), array('controller'=>'properties','action' => 'view', $wishlistElement['Property']['id']),array('escape' => false, 'target' => '_blank', 'rel' => 'noopener noreferrer')); 
												?>
											</li>
											<li class="divider"></li>
											<li>
												<?php 
													//echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-times')).'&nbsp;'.__('Remove from wishlist'),array('controller'=>'wishlists','action' => 'deleteElement', $elementId, $wishlistElement['UserWishlist']['note']) , array('escape' => false), __("Are you sure you want to remove this property from your wishlist?")); 
												?>
												<?php
													$var = h(addslashes($wishlistElement['UserWishlist']['note']));
													echo $this->Html->link($this->Html->tag('i','', array('class' => 'fa fa-times')).'&nbsp;'.__('Remove from wishlist'), 'javascript:void(0);',array('escape'=>false, 'onclick' =>"ShowConfirmDelete({$elementId}, {$wishlistElement['UserWishlist']['wishlist_id']}, '{$var}', this); return false;",'id'=>'element_'.$elementId));
												?>
											</li> 
										</ul>
									</div> 
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- pagination START -->
			<?php echo $this->element('Pagination/counter'); ?>
			<?php echo $this->element('Pagination/navigation'); ?>
		</div>
	</div>	
</div>
<?php echo $this->element('Common/confirm_modal'); ?>
<script>
/**
 * [ShowConfirmDelete Opem Confirmation box for when delating a row, Ajax]
 * @param {INT} id   [primary key of record]
 * @param {string} name [description]
 */
	function ShowConfirmDelete(id, wishlist_id, name, that) {
		var $confirmModal = $('#modalConfirmYesNo'),
		 	$elementToMask = $('#elementToMask'),
			$rowToRemove = $(that).closest('.parent-element');
		$confirmModal.modal('show');
		$('#lblMsgConfirmYesNo').html('Are you sure you want to remove this property from wishlist: <b>' + name + '</b>?');
		$('#btnYesConfirmYesNo').off('click').on('click', function() {
			$.ajax({
				url: fullBaseUrl+'/wishlists/deleteElement/'+id +'/'+ wishlist_id,
				type: 'POST',
				dataType: 'json',
				data:{data:{UserWishlist:{id:id}}},
				beforeSend: function() {
					// called before response
					$elementToMask.mask('Waiting...');
				},
				success: function(data, textStatus, xhr) {
					//called when successful
					if (textStatus =='success') {
						var response = $.parseJSON(JSON.stringify(data));
						if (!response.error) {
							$rowToRemove.fadeOut(350,function() { this.remove(); });
							toastr.success(response.message,'Success!');
						} else {
							toastr.error(response.message,'Error!');
						}
					} else {
						toastr.warning(textStatus,'Warning!');
					}
				},
				complete: function(xhr, textStatus) {
					//called when complete
					$confirmModal.modal('hide');
					$elementToMask.unmask();
				},
				error: function(xhr, textStatus, errorThrown) {
					//called when there is an error
					$confirmModal.modal('hide');
					var message = '';
					if(xhr.responseJSON.hasOwnProperty('message')){
						//do struff		
						message = xhr.responseJSON.message;
					}
					$elementToMask.unmask();
					toastr.error(errorThrown+":&nbsp;"+message, textStatus);
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
</script>
