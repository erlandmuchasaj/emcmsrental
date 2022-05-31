<?php
// LIST BLOG
$directorySmURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Article'. DS . 'small' . DS;
$directorySmPATH = 'uploads/Article/small/';

// FEATURE
$directoryURLFeature = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Article'. DS;
$directoryPATHFeature = 'uploads/Article/';

// USER AVATAR
$userURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS . 'small'. DS;
$userPATH = 'uploads/User/small/';

$this->set('title_for_layout', __('Blog'));

// echo "<pre>";
// print_r($featuredArticles);
// echo "</pre>";

?>

<!-- Hero -->
<?php if (!empty($featuredArticles)) { ?>
<div id="hero-container-blog">
	<div id="carouselBlog" class="carousel slide featured" data-ride="carousel">
		<ol class="carousel-indicators">
			<?php
			foreach ($featuredArticles as $key => $featureArticle){
				if ($key == 0) {
					echo '<li data-target="#carouselBlog" data-slide-to="0" class="active"></li>';
				} else {
					echo "<li data-target='#carouselBlog' data-slide-to='".$key."'></li>";
				}
			}
			?>
		</ol>
		<div class="carousel-inner">
			<?php foreach ($featuredArticles as $key => $featureArticle){

				$articleLink = $this->Html->url(['controller' => 'articles', 'action' => 'view', $featureArticle['Article']['id'], Inflector::slug($featureArticle['Article']['slug'],'-')], true);

				if (file_exists($directoryURLFeature.$featureArticle['Article']['featured_image']) && is_file($directoryURLFeature.$featureArticle['Article']['featured_image'])) {
					$base64 =  Router::url("/img/".$directoryPATHFeature.$featureArticle['Article']['featured_image'], true);
				} else {
					$base64 =  Router::url("/img/no-img-available.png", true);
				}
				?>
				<div class="item <?php echo ($key == 0) ? 'active' : ''; ?>" style="background-image: url('<?php echo $base64; ?>');">
					<div class="container">
						<div class="carousel-caption">
							<div class="carousel-title"><?php echo __('Featured on Blog'); ?></div>
							<div class="caption-title"><?php echo h($featureArticle['Article']['title']); ?></div>
							<div class="caption-subtitle">
							<?php
								$pattern = "/<p[^>]*><\\/p[^>]*>/";
								$article_summary = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $featureArticle['Article']['summary']);
								$article_summary = preg_replace($pattern, '', $article_summary);
								echo htmlspecialchars_decode(stripslashes(h($article_summary)));
							?>
							</div>
							<a href="<?php echo $articleLink; ?>" class="btn btn-lg btn-o btn-white">
								<?php echo __('Read More'); ?>
							</a>
						</div>
						<div class="avatar-caption">
							<?php echo $this->Html->displayUserAvatar($featureArticle['User']['image_path']); ?>
							<div class="ac-user">
								<div class="ac-name">
									<?php echo h($featureArticle['User']['name']) .'&nbsp'. h($featureArticle['User']['surname']); ?>,&nbsp;
									<?php echo $this->Time->niceShort($featureArticle['Article']['created']); ?>
								</div>
								<div class="ac-title">
									<?php echo (!empty($featureArticle['User']['role'])) ? $featureArticle['User']['role'] : __('Article manager'); ?>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			<?php }  ?>
		</div>
		<a class="left carousel-control" href="#carouselBlog" role="button" data-slide="prev">
			<span class="fa fa-angle-left"></span>
		</a>
		<a class="right carousel-control" href="#carouselBlog" role="button" data-slide="next">
			<span class="fa fa-angle-right"></span>
		</a>
	</div>
</div>
<?php } ?>

<div class="blog-content">
	<div class="em-container">
		<div class="row">
			<div class="col-sm-12 col-md-9">
				<h2 class="osLight"><?php echo __('Latest Posts'); ?></h2>
				<div class="row">
				<?php
				if (!empty($articles)) {
					foreach ($articles as $article):
					$articleLink  = $this->Html->url(['controller' => 'articles', 'action' => 'view', $article['Article']['id'], Inflector::slug($article['Article']['slug'],'-')], true);
					?>
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="article">
							<?php
								if (file_exists($directorySmURL.$article['Article']['featured_image']) && is_file($directorySmURL.$article['Article']['featured_image'])) {
									$base64 = $directorySmPATH . $article['Article']['featured_image'];
								} else {
									$base64 = 'no-img-available.png';
								}
								echo $this->Html->link($this->Html->image($base64, array('alt'=>'featured image')), $articleLink, array('escape' => false, 'class'=>'image'));
							?>
							<div class="article-category">
								<a href="javascript:;" class="text-green"><?php echo h($article['Category']['name']); ?></a>
							</div>
							<h3 class="osLight"><a href="<?php echo $articleLink; ?>"><?php echo h($article['Article']['title']); ?></a></h3>
							<div class="summary-article">
								<?php
									$pattern = "/<p[^>]*><\\/p[^>]*>/";
									$article_summary = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $article['Article']['summary']);
									$article_summary = preg_replace($pattern, '', $article_summary);
									echo htmlspecialchars_decode(stripslashes($article_summary));
								?>
							</div>
							<div class="footer">
								<a href="javascript:;"><?php echo h($article['User']['name']) .'&nbsp'. h($article['User']['surname']); ?></a>,&nbsp;
								<a href="javascript:;"><?php echo $this->Time->niceShort($article['Article']['created']); ?></a>
							</div>
						</div>
					</div>
					<?php
					endforeach;
				}
				?>
				</div>
				<!-- pagination START -->
				<div class="row">
					<div class="col-xs-12">
						<ul class="pagination pagination-large">
							<?php
							echo $this->Paginator->prev(__('<span class="fa fa-angle-left"></span> Newer Articles'), array('tag' => 'li','escape' => false), null , array('tag' => 'li','class' => 'disabled','disabledTag' => 'a','escape' => false));
							echo $this->Paginator->next(__('Older Articles <span class="fa fa-angle-right"></span>'), array('tag' => 'li','currentClass' => 'disabled','escape' => false), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a','escape' => false));
							?>
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-3">
				<div class="row">
					<div class="col-md-12">
						<h2 class="osLight h-r"><?php echo __('Categories'); ?></h2>
						<ul class="blog-r-nav">
						<?php
							if (isset($categories) && !empty($categories)) {
								foreach ($categories as $category):
							?>
							<li><a href="javascript:;"><?php echo h($category['Category']['name']); ?></a></li>
							<?php
								endforeach;
							} else {
								echo "<li><a href='javascript:;'>".__('No Category')."</a></li>";
							}
						?>
						</ul>
					</div>
					<?php if (false) {?>
					<div class="col-md-12">
						<h2 class="osLight h-r">Popular Tags</h2>
						<div class="blog-tags">
							<a href="#" class="label label-default">furniture</a>
							<a href="#" class="label label-default">architect</a>
							<a href="#" class="label label-default">chair</a>
							<a href="#" class="label label-default">modern</a>
							<a href="#" class="label label-default">bathroom</a>
							<a href="#" class="label label-default">table</a>
							<a href="#" class="label label-default">sofa</a>
							<a href="#" class="label label-default">bed</a>
							<a href="#" class="label label-default">design</a>
							<a href="#" class="label label-default">apartment</a>
							<a href="#" class="label label-default">leather</a>
							<a href="#" class="label label-default">lamp</a>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>
