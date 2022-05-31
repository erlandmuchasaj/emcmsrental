<?php ob_start();
	if (isset($propertyImages) && !empty($propertyImages)) {
		foreach ($propertyImages as $image){
		$elementId = (int) $image['PropertyPicture']['id'];
		$img_path = h(addslashes($image['PropertyPicture']['image_path']));
		$property_id = (int)$image['PropertyPicture']['property_id'];
		$thumbnail =  Router::url('/img/placeholder.png', true);
	?>
	<li id="arrayorder_<?php echo $elementId; ?>" class="photo_img_sub parent-element OrderingField">
		<div id="pannel_photo_item_id_<?php echo $elementId; ?>" class="panel_container pannel_photo_item">
			<div class="first-photo-ribbon"></div>
			<div class="photo-drag-target sort-handle"></div>
			<?php
				$directoryMdURL = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$property_id.DS.'PropertyPicture'. DS .'medium' .DS .$img_path;
				$directoryMdPATH = "/img/uploads/Property/{$property_id}/PropertyPicture/medium/".$img_path;

				if (file_exists($directoryMdURL) && is_file($directoryMdURL)) {
					$thumbnail = Router::url($directoryMdPATH, true);
				}
			?>
			<a href="javascript:void(0);" style="background-image: url('<?php echo $thumbnail; ?>');" class="media-link background_preview">
				<?php
					echo $this->Html->image('general/noimg/no-img970x790.png', array('alt' => 'thumbnail','class'=>'img-responsive invisible', 'style'=>'visibility:hidden;'));
				?>
			</a>
			<button class="delete-photo-btn remove-image-button" onclick="ShowConfirmDeleteImage(<?php echo $elementId ?>); return false;" data-image-id="<?php echo $elementId;?>" data-image-path="<?php echo $img_path ?>" data-property-id="<?php echo $property_id ?>" id="element_<?php echo $elementId?>"><i class="fa fa-trash"></i></button>

			<div class="panel-body">
				<textarea name="data[Property][image_caption]" class="form-control add_caption input-large" data-image-id="<?php echo $elementId;?>" id="property_image_ca_<?php echo $elementId;?>" placeholder="<?php echo __('Enter image caption');?>"><?php if (isset($image['PropertyPicture']['image_caption']) && !empty($image['PropertyPicture']['image_caption']) && trim($image['PropertyPicture']['image_caption']) !=''){echo safeOutput($image['PropertyPicture']['image_caption']);} ?></textarea>
			</div>
		</div>
	</li>
	<?php
		unset($directoryMdURL);
		unset($directoryMdPATH);
	}
}
?>
<script>
	(function($){
		$(document).ready(function() {
			'use strict';
			// ADD CAPTION TO IMAGES USING TYPEWATCH
			/*Check if plugin is loaded otherwize use on blur event*/
			if ($.isFunction($.fn.typeWatch)) {
				$('.add_caption').typeWatch({
					wait: 600,
					captureLength: 2,
					callback: function(value) {
						var img_id = $(this).attr('data-image-id');
						addCaptionToImage(img_id, value);
					}
				});
			} else {
				$('.add_caption').on('blur', function(e){
					e.preventDefault();
					e.stopPropagation();
					var image_id = $(this).attr('data-image-id'),
						image_caption = $(this).val();
					addCaptionToImage(image_id, image_caption);
				});
			}

		});
	})(jQuery);

/**
 * [addCaptionToImage description]
 * @param INT id      [image id ]
 * @param string caption [caption for image]
 */
	function addCaptionToImage(id, caption){
		// ADD CAPTION TO IMAGE
		var $elementToMask = $('#property_image_ca_'+id).closest('.parent-element');
		$.ajax({
			url: fullBaseUrl+'/property_pictures/addCaption/'+id,
			type: 'POST',
			dataType: 'json',
			data:{data:{PropertyPicture:{id:id, image_caption:caption}}},
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
			$rowToRemove = $('#element_'+id).closest('.parent-element');
		$confirmModal.modal('show');
		$('#lblMsgConfirmYesNo').html('Are you sure you want to delete this image');
		$('#btnYesConfirmYesNo').off('click').on('click',function () {
			$confirmModal.modal('hide');
			$.ajax({
				url: fullBaseUrl+'/property_pictures/delete/'+id,
				type: 'POST',
				dataType: 'json',
				data:{data:{PropertyPicture:{id:id}}},
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