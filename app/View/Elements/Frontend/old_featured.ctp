<?php
	$mostVisited = $this->requestAction('/properties/featured');
	if (!empty($mostVisited)) {
		echo '<div class="owl-carousel featured-properties">';
		foreach ($mostVisited as $mostVisit) { 

			$directoryURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Property'.DS.$mostVisit['Property']['id'].DS.'PropertyPicture'.DS.'large'.DS.$mostVisit['Property']['thumbnail'];
			$directoryPATH = 'img/uploads/Property/'.$mostVisit['Property']['id'].'/PropertyPicture/large/'.$mostVisit['Property']['thumbnail'];
			
			if (file_exists($directoryURL) && is_file($directoryURL)) {    
				//$thumbnail =  Router::url($directoryPATH, true);
				$thumbnail = $this->webroot.$directoryPATH;  
			} else {    
				//$thumbnail =  Router::url('/img/no-img-available.png', true);
				$thumbnail = $this->webroot.'img/no-img-available.png'; 
			}					
		?>
		<div class="property">
			<figure class="effect-oscar">
				<div data-src="<?php echo $thumbnail;?>" class="owl-lazy background_preview">
					<?php 
						echo $this->Html->image('general/noimg/empty.png', array('alt' => 'image', 'class'=>'img-responsive invisible', 'style'=>'visibility:hidden'));
					?>
				</div>
				<figcaption>
					<?php 
						echo $this->Html->tag('h2', EMCMS_strtoupper($mostVisit['RoomType']['room_type_name'])); 
						echo $this->Html->tag('p', getDescriptionHtml($mostVisit['PropertyTranslation']['title']));
						echo $this->Html->tag('span', $mostVisit['Property']['price_converted'], array('escape'=>false, 'class'=>'property-price'));
						if ($mostVisit['Property']['is_new']) {
							echo $this->Html->tag(
								'div', 
								$this->Html->tag('div', 
									__('New'), 
									array('escape'=>false, 'class'=>'ribbon-green')
								), 
								array('escape'=>false, 'class'=>'ribbon-wrapper-green')
							);
						}

						echo $this->Html->link(__('View more'), array('controller' =>'properties','action' => 'view', $mostVisit['Property']['id']), array('escape' => false, 'class'=>''));
					?>
				</figcaption>
			</figure>
		</div>
		<?php 
		}
		echo '</div>'; 
	}  else {
		echo $this->Html->tag('h3', __('No property to Display'), array('style'=>'text-align: center;', 'class'=>'section-title')); 
	} 
?>
