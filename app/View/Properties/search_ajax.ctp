<!-- 
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-">
        <a href="#" class="propWidget-2">
            <div class="fig">
                <img src="images/prop/2-1.png" alt="image">
                <img class="blur" src="images/prop/2-1.png" alt="image">
                <div class="opac"></div>
                <div class="priceCap osLight"><span>$1,750,000</span></div>
                <div class="figType">FOR RENT</div>
                <h3 class="osLight">Hauntingly Beautiful Estate</h3>
                <div class="address">39 Remsen St, Brooklyn, NY 11201, USA</div>
                <ul class="rating">
                    <li><span class="fa fa-star star-1"></span></li>
                    <li><span class="fa fa-star star-2"></span></li>
                    <li><span class="fa fa-star star-3"></span></li>
                    <li><span class="fa fa-star star-4"></span></li>
                    <li><span class="fa fa-star-o star-5"></span></li>
                </ul>
            </div>
        </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <a href="#" class="propWidget-1">
            <div class="fig">
                <img src="images/prop/1-1.png" alt="image">
                <div class="priceCap"><span>$1,930,000</span></div>
                <div class="figType">FOR SALE</div>
                <div class="figCap">
                    <h3>Modern Residence in New York</h3>
                    <div class="address">39 Remsen St, Brooklyn, NY 11201, USA</div>
                    <div class="feat feat-1"><span class="fa fa-moon-o"></span> 3</div>
                    <div class="feat feat-2"><span class="icon-drop"></span> 2</div>
                    <div class="feat feat-3"><span class="icon-frame"></span> 3430 Sq Ft</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <a href="#" class="propWidget-1">
            <div class="fig">
                <img src="images/prop/1-1.png" alt="image">
                <div class="priceCap"><span>$1,930,000</span></div>
                <div class="figType">FOR SALE</div>
                <div class="figCap">
                    <h3>Modern Residence in New York</h3>
                    <div class="address">39 Remsen St, Brooklyn, NY 11201, USA</div>
                    <div class="feat feat-1"><span class="fa fa-moon-o"></span> 3</div>
                    <div class="feat feat-2"><span class="icon-drop"></span> 2</div>
                    <div class="feat feat-3"><span class="icon-frame"></span> 3430 Sq Ft</div>
                </div>
            </div>
        </a>
    </div> 
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div id="propWidget-3" class="carousel slide propWidget-3" data-ride="carousel">
            <h3 class="osLight">Luxury Mansion</h3>
            <div class="address">39 Remsen St, Brooklyn, NY 11201, USA</div>
            <div class="priceCap">
                <div class="price">$2,350,000</div>
                <div class="type">FOR RENT</div>
                <div class="clearfix"></div>
            </div>
            <ol class="carousel-indicators">
                <li data-target="#propWidget-3" data-slide-to="0" class="active"></li>
                <li data-target="#propWidget-3" data-slide-to="1"></li>
                <li data-target="#propWidget-3" data-slide-to="2"></li>
                <li data-target="#propWidget-3" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner">
                <div class="item active">
                    <a href="#"><img src="images/prop/4-1.png" alt="First slide"></a>
                    <div class="container">
                        <div class="carousel-caption">
                            <img src="images/prop/4-1.png" alt="image">
                            <div class="opac"></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a href="#"><img src="images/prop/4-2.png" alt="Second slide"></a>
                    <div class="container">
                        <div class="carousel-caption">
                            <img src="images/prop/4-2.png" alt="image">
                            <div class="opac"></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a href="#"><img src="images/prop/4-3.png" alt="Third slide"></a>
                    <div class="container">
                        <div class="carousel-caption">
                            <img src="images/prop/4-3.png" alt="image">
                            <div class="opac"></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a href="#"><img src="images/prop/4-4.png" alt="Fourth slide"></a>
                    <div class="container">
                        <div class="carousel-caption">
                            <img src="images/prop/4-4.png" alt="image">
                            <div class="opac"></div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#propWidget-3" role="button" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
            <a class="right carousel-control" href="#propWidget-3" role="button" data-slide="next"><span class="fa fa-chevron-right"></span></a>
        </div>
    </div>
-->
<?php if (!empty($searchResults)) { ?>
<?php foreach ($searchResults as $key => $searchResult) { ?>
<?php
    $propertyThumbnail  = $this->webroot.'img/no-img-available.png';
    $directoryMdURL     = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Property'.DS.$searchResult['Property']['id'].DS.'PropertyPicture'.DS.'medium'.DS;
    $directoryMdPATH    = 'img/uploads/Property/'.$searchResult['Property']['id'].'/PropertyPicture/medium/';
    if (file_exists($directoryMdURL.$searchResult['Property']['thumbnail']) && is_file($directoryMdURL.$searchResult['Property']['thumbnail'])) {    
        $propertyThumbnail = $this->webroot.$directoryMdPATH.$searchResult['Property']['thumbnail'];
    }
    $propertyLink  = Router::Url(array('controller' => 'properties','action' => 'view', $searchResult['Property']['id']), true);
?>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <a href="<?php echo $propertyLink; ?>" class="card">
        <div class="figure">
            <?php echo $this->Html->image($propertyThumbnail, array('alt' => 'image', 'class'=>'img-responsive')) ?>
            <div class="figCaption">
                <div><?php echo $searchResult['Property']['price_converted'];?></div>
                <span class="fa fa-eye">&nbsp;<?php echo $searchResult['Property']['hits']; ?></span>
                <span class="fa fa-heart">&nbsp;54</span>
                <span class="fa fa-comment">&nbsp;13</span>
            </div>
            <div class="figView"><span class="icon-eye"></span></div>
            <div class="figType"><?php echo $searchResult['Property']['type_formated']; ?></div>
        </div>
        <h2><?php echo h($searchResult['PropertyTranslation']['title']); ?></h2>
        <div class="cardAddress"><span class="icon-pointer"></span><?php echo $searchResult['Property']['address']; ?> </div>
        <div class="cardRating">
            <span class="fa fa-star"></span>
            <span class="fa fa-star"></span>
            <span class="fa fa-star"></span>
            <span class="fa fa-star"></span>
            <span class="fa fa-star-o"></span>
            (146)
        </div>
        <ul class="cardFeat">
            <li><span class="fa fa-moon-o"></span>&nbsp;3</li>
            <li><span class="fa fa-tint"></span>&nbsp;2</li>
            <li><span class="fa fa-square"></span>&nbsp;<?php echo $searchResult['Property']['surface_area'];?>m<sup>2</sup></li>
        </ul>
        <div class="clearfix"></div>
    </a>
</div>
<?php } ?>
<?php } else { ?>
<div class="col-sm-10 col-sm-offset-1">

<h3><?php echo __('We couldn’t find any results that matched your criteria, but tweaking your search may help. Here are some ideas:') ?></h3>
<p>
<?php echo __('Remove some filters.') ?><br>
<?php echo __('Expand the area of your search.') ?><br>
<?php echo __('Search for a city, address, or landmark.') ?><br>
</p>
</div>
<?php } ?>
