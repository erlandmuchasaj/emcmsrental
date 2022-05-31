<?php ob_start();
if (isset($images) && !empty($images)) {
	echo '<ul id="sortable_images" class="photo_img">';
	foreach ($images as $image) {
		$elementId = (int) $image['Image']['id'];
		$img_path = $image['Image']['src'];
		$model = $image['Image']['model'];
		$model_id = (int)$image['Image']['model_id'];
	?>
	<li id="arrayorder_<?php echo $elementId; ?>" class="photo_img_sub parent-element OrderingField">
		<div id="pannel_photo_item_id_<?php echo $elementId; ?>" class="panel_container pannel_photo_item">
			<div class="first-photo-ribbon"></div>
			<div class="photo-drag-target sort-handle"></div>
			<?php $thumbnail = Router::url("/img/uploads/{$model}/{$model_id}/medium/{$img_path}", true); ?>
			<a href="javascript:void(0);" style="background-image: url('<?php echo $thumbnail; ?>');" class="media-link background_preview">
				<?php
					echo $this->Html->image('general/noimg/empty.png', array('alt' => 'thumbnail', 'class'=>'img-responsive invisible', 'style'=>'visibility:hidden;'));
				?>
			</a>
			<button class="delete-photo-btn remove-image-button" onclick="ShowConfirmDeleteImage(<?php echo $elementId ?>); return false;" data-image-id="<?php echo $elementId;?>" data-image-path="<?php echo $img_path ?>" data-model-id="<?php echo $model_id ?>" id="image_id_<?php echo $elementId?>"><i class="fa fa-trash"></i></button>

			<div class="panel-body">
				<textarea class="form-control add_img_caption input-large" data-image-id="<?php echo $elementId;?>" id="image_caption_<?php echo $elementId;?>" placeholder="<?php echo __('Enter image caption');?>"><?php if (isset($image['Image']['caption']) && !empty($image['Image']['caption']) && trim($image['Image']['caption']) !=''){echo safeOutput($image['Image']['caption']);} ?></textarea>
			</div>
		</div>
	</li>
	<?php
	}
	echo '</ul>';
}
?>
<script>
	(function($) {
		$(document).ready(function() {
			'use strict';
			// ADD CAPTION TO IMAGES USING TYPEWATCH
			/*Check if plugin is loaded otherwize use on blur event*/
			if ($.isFunction($.fn.typeWatch)) {
				$('.add_img_caption').typeWatch({
					wait: 600,
					captureLength: 2,
					callback: function(value) {
						var img_id = $(this).attr('data-image-id');
						addCaptionToImage(img_id, value);
					}
				});
			} else {
				$('.add_img_caption').on('blur', function(e) {
					var image_id = $(this).attr('data-image-id'),
						image_caption = $(this).val();
					addCaptionToImage(image_id, image_caption);
				});
			}


			if ($.isFunction($.fn.sortable)) {
				$('#sortable_images').sortable({
					opacity: 0.8,
					cursor: 'move',
					revert: true,
					handle : '.sort-handle',
					zIndex: 999,
					distance: 10,
					items: '.OrderingField',
					start: function(e,ui){
						ui.placeholder.height(ui.item.height());
					},
					helper: function(e, tr){
						var originals = tr.children();
						var helper = tr.clone();
						helper.children().each(function(index)	{
							$(this).width(originals.eq(index).width());
						});
						helper.css('background-color', 'rgba(223, 240, 249,0.6)');
						return helper;
					},
					update: function() {
						var order = $(this).sortable('serialize');
						$.post(fullBaseUrl+'/images/sort', order, function(data, textStatus, xhr) {
							if (textStatus =='success') {
								/*
								* // this verison is used when we specify the returned data type
								* var response = $.parseJSON(JSON.stringify(data));
								*/
								var response = $.parseJSON(data);
								if (!response.error) {
									toastr.success(response.message, 'Success');
								}
							} else {
								toastr.info(textStatus, 'Info');
							}
						});
					}
				});
			}

		});
	})(jQuery);

/**
 * [addCaptionToImage description]
 * @param INT id      [image id ]
 * @param string caption [caption for image]
 */
	function addCaptionToImage(id, caption) {
		// ADD CAPTION TO IMAGE
		var $elementToMask = $('#image_caption_'+id).closest('.parent-element');
		$.ajax({
			url: fullBaseUrl+'/images/caption/'+id,
			type: 'POST',
			dataType: 'json',
			data:{data:{Image:{id:id, caption:caption}}},
			beforeSend: function() {
				// called before response
				$elementToMask.mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='success') {
					var response = $.parseJSON(JSON.stringify(data));
					if (!response.error) {
						toastr.success(response.message, 'Success!');
					} else {
						toastr.error(response.message, 'Error!');
					}
				} else {
					toastr.warning(textStatus, 'Warning!');
				}
			},
			complete: function(xhr, textStatus) {
				//called when complete
				$elementToMask.unmask();
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				$elementToMask.unmask();
				toastr.error(xhr.responseJSON.message, ucfirst(textStatus));
			}
		});
		return true;
	}

/**
 * [ShowConfirmDeleteImage Opem Confirmation box for when delating a row, Ajax]
 * @param {INT} id   [primary key of record]
 * @param {string} name [description]
 */
	function ShowConfirmDeleteImage(id) {
		var $confirmModal = $('#modalConfirmYesNo'),
			$rowToRemove = $('#image_id_'+id).closest('.parent-element');
		$confirmModal.modal('show');
		$('#lblMsgConfirmYesNo').html('Are you sure you want to delete this image?');
		$('#btnYesConfirmYesNo').off('click').on('click',function () {
			$confirmModal.modal('hide');
			$.ajax({
				url: fullBaseUrl+'/images/delete/'+id,
				type: 'POST',
				dataType: 'json',
				data:{data:{Image:{id:id}}},
				beforeSend: function() {
					// called before response
					$rowToRemove.mask('Waiting...');
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
					$rowToRemove.unmask();
				},
				error: function(xhr, textStatus, errorThrown) {
					//called when there is an error
					$rowToRemove.unmask();
					toastr.error(xhr.responseJSON.message, ucfirst(textStatus));
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
<?php ob_end_flush(); ?>