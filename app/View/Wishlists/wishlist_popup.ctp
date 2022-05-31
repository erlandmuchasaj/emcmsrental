<div class="row remove-margin">
	<div class="col-lg-7 col-md-6 col-sm-6 hidden-xs remove-padding wl-modal__col">
		<?php 
			$base64 = $this->webroot.'img/placeholder.png';
			$directoryURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Property'.DS.$property['Property']['id'].DS.'PropertyPicture'.DS.'medium'.DS;
			$directoryPATH = 'img/uploads/Property/'.$property['Property']['id'].'/PropertyPicture/medium/';
			if (file_exists($directoryURL.$property['Property']['thumbnail']) && is_file($directoryURL.$property['Property']['thumbnail'])) {    
				$thumbnail = $this->webroot.$directoryPATH.$property['Property']['thumbnail'];  
			}
		?>
		<div class="media-cover media-cover-dark background_preview" style="background-image:url(<?php echo $thumbnail;?>);">
		</div>
		<div class="wl-modal-listing-tabbed">
			<div class="va-container media">
				<div class="media-left">
			   		<?php 
			    		echo $this->Html->image('uploads/User/small/'.$property['User']['image_path'], array('alt' => 'property image', 'class' => 'media-object media-photo media-round', 'style'=>"width: 67px; height: 67px;"))
			    	?>
				</div>
				<div class="media-body va-middle">
			    	<h4 class="media-heading wl-modal-listing__name"><?php echo h($property['PropertyTranslation']['title']);?></h4>
			    	<p class="wl-modal-listing__address wl-modal-listing__text"><?php echo h($property['Property']['country']);?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-5 col-md-6 col-sm-6 remove-padding wl-modal__col">
		<div class="modal-header wl-modal__header">
			<div class="va-container va-container-h va-container-v">
				<div class="va-middle">
					<?php echo $this->Html->tag('h3', __('Save to Wishlist'), ['class'=>'h3'])?>
				</div>
			</div>
			<button type="button" class="close wl-modal__modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div> 
		<div class="modal-body wl-modal-wishlists">
			<div class="panel-body wl-modal-wishlists__body">
				<?php foreach ($wishlistCategories as $key => $wishlistCategory): ?>
					<div class="wl-modal-wishlist-row clickable" oncontextmenu="return false" onclick="addToWishlist(<?php echo $property['Property']['id']; ?>,<?php echo $wishlistCategory['Wishlist']['id']; ?>, 'Property', this);">
						<div class="va-container va-container-v va-container-h">
							<div class="va-middle text-left wl-modal-wishlist-row__name">
								<?php echo h($wishlistCategory['Wishlist']['name']); ?>
							</div>
							<div class="va-middle text-right">
								<div class="h3 wl-modal-wishlist-row__icons">
									<?php if ($wishlistCategory['Wishlist']['short_listed']): ?>
										<i class="fa fa-heart wl-modal-wishlist-row__icon-heart wishlist-icon" aria-hidden="true"></i>
									<?php else: ?>
										<i class="fa fa-heart-o wl-modal-wishlist-row__icon-heart-alt wishlist-icon" aria-hidden="true"></i>
									<?php endif ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
		<div class="panel-footer modal-footer wl-modal__footer">
			<?php echo $this->Form->create('Wishlist', array('url' => array('controller' => 'wishlists', 'action' => 'add'), 'class'=>'form-inline wl-modal-footer__form clearfix hide', 'id'=>'WishlistAddFormModal', 'role'=>'form', 'onsubmit'=>'createWishlist(event, this, '.(int)$property['Property']['id'].', "Property")')); ?>
				<?php echo $this->Form->input('name', array('label'=>false, 'type'=>'text', 'div'=>false,'class'=>'form-control wl-modal-footer__input', 'autocomplete'=>'off', 'placeholder'=>__('Name your wishlist'), 'required'=>'required', 'id'=>'wish_list_text')); ?>
				<button id="wish_list_btn" class="btn btn-flat wl-modal-wishlists__footer__save-button btn-contrast"><?php echo __('Create'); ?></button>
			<?php echo $this->Form->end(); ?>
			<div class="text-rausch va-container va-container-v va-container-h">
				<?php echo $this->Html->link(__('Create new wishlist'), 'javascript:;', array('escape' => false, 'class'=>'va-middle text-lead wl-modal-footer__text', 'onclick'=>'toggleWishlistForm(event, this)')); ?>
			</div> 
		</div>
	</div>
</div>	
<script>
/**
 * [AddToWishlist Change publish/unpublish status]
 * @param  {$this} obj       [description]
 * @param  {INT} data_id     [description]
 * @param  {INT} data_status [1/0]
 * @return {string}          [description]
 */
	function addToWishlist(model_id, wishlist_id, model, that){
		$.ajax({
			url: fullBaseUrl+'/wishlists/addToWishlist/'+model_id+'/'+wishlist_id+'/'+model,
			type: 'POST',
			dataType: 'json',
			async: true,
			data: {data:{UserWishlist:{model_id:model_id, wishlist_id:wishlist_id, model:model}}},
			beforeSend: function() {
				// called before response
				$(that).mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='success') {
					var response = $.parseJSON(JSON.stringify(data));
					if (response.error) {
						toastr.error(response.message,'Error!');
					} else {
						toastr.success(response.message, 'Success!');
						var $element = $(that).find('i.wishlist-icon');
						if ($element.hasClass('fa-heart')) {
							$element.removeClass('fa-heart wl-modal-wishlist-row__icon-heart')
									.addClass('fa-heart-o wl-modal-wishlist-row__icon-heart-alt');
						} else {
							$element.removeClass('fa-heart-o wl-modal-wishlist-row__icon-heart-alt')
									.addClass('fa-heart wl-modal-wishlist-row__icon-heart');
						}
					}
				} else {
					toastr.warning(textStatus,'Warning!');
				}
			},
			complete: function(xhr, textStatus) {
				//called when complete
				$(that).unmask();
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				var message = '';
				if(xhr.responseJSON.hasOwnProperty('message')){
					//do struff		
					message = xhr.responseJSON.message;
				}
				$(that).unmask();
				toastr.error(errorThrown+":&nbsp;"+message, textStatus);
			}
		});
	}

	function createWishlist(event, that, model_id, model) {
		event.preventDefault();
		var name = document.getElementById("wish_list_text").value;
		// that.preventDefault();
		$.ajax({
			url: fullBaseUrl+'/wishlists/add',
			type: 'POST',
			dataType: 'json',
			async: true,
			data: {data:{Wishlist:{name: name}}},
			beforeSend: function() {
				// called before response
				$(that).mask('Waiting...');
			},
			success: function(data, textStatus, xhr) {
				//called when successful
				if (textStatus =='success') {
					var response = $.parseJSON(JSON.stringify(data));
					if (response.error) {
						toastr.error(response.message,'Error!');
					} else {
						toastr.success('Reload wish list on modal', 'Success!');
						$.get(fullBaseUrl+'/wishlists/wishlist_popup/'+model_id+'/'+model, function( data, textStatus, xhr ) {
							//called when successful
							if (textStatus =='error') {
								toastr.error(textStatus,'Error!');
							} else {
								$('#modal_content').html(data);
							}
						});

					}
				} else {
					toastr.warning(textStatus,'Warning!');
				}
			},
			complete: function(xhr, textStatus) {
				//called when complete
				$(that).unmask();
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
				var message = '';
				if(xhr.responseJSON.hasOwnProperty('message')){
					//do struff		
					message = xhr.responseJSON.message;
				}
				$(that).unmask();
				toastr.error(errorThrown+":&nbsp;"+message, textStatus);
			}
		});
	}

	function toggleWishlistForm(event, that){
		var form = document.getElementById("WishlistAddFormModal");
		toggleClass(form, 'hide');

		// // adds class "foo" to form
		// form.classList.add("foo");
		// // removes class "bar" from form
		// form.classList.remove("bar");
		// // toggles the class "foo"
		// form.classList.toggle("foo");
		// // outputs "true" to console if form contains "foo", "false" if not
		// console.log( form.classList.contains("foo") );
		// // add multiple classes to form
		// form.classList.add( "foo", "bar" );
	}

	function hasClass(elem, className) {
		return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
	}
	// toggleClass
	function toggleClass(elem, className) {
		var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, " " ) + ' ';
	    if (hasClass(elem, className)) {
	        while (newClass.indexOf(" " + className + " ") >= 0 ) {
	            newClass = newClass.replace( " " + className + " " , " " );
	        }
	        elem.className = newClass.replace(/^\s+|\s+$/g, '');
	    } else {
	        elem.className += ' ' + className;
	    }
	}

</script>
