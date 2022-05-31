<?php
// Article Image PATH
$directorySmURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Article'. DS;
$directorySmPATH = 'uploads/Article/';

// USER Image PATH
$userURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS . 'small'. DS;
$userPATH = 'uploads/User/small/';

$articleId = (int)$article['Article']['id'];

$this->set('title_for_layout', getDescriptionHtml($article['Article']['title']));

if (!empty($article['Article']['meta_title'])) {
	$this->assign('meta_title', getDescriptionHtml($article['Article']['meta_title']));
}

if (!empty($article['Article']['meta_description'])) {
	$this->assign('meta_description', getDescriptionHtml($article['Article']['meta_description']));
}

if (!empty($article['Article']['meta_keywords'])) {
	$this->assign('meta_keywords', getDescriptionHtml($article['Article']['meta_keywords']));
}

$this->assign('meta_url', Router::Url(null, true));
$this->assign('meta_image', Router::url("/img/uploads/Article/{$article['Article']['featured_image']}", true));

// echo "<pre>";
// print_r($articleNeighbors);
// echo "</pre>";
?>
<!-- Hero -->
<div id="hero-container-blog">
	<div class="carousel featured">
		<div class="carousel-inner">
			<?php
				if (file_exists($directorySmURL. $article['Article']['featured_image']) && is_file($directorySmURL.$article['Article']['featured_image'])) {
					$base64 =  Router::url("/img/".$directorySmPATH . $article['Article']['featured_image'], true);
				} else {
					$base64 =  Router::url("/img/no-img-available.png", true);
				}
			?>
			<div class="item active background_preview" style="background-image: url('<?php echo $base64; ?>');">
				<div class="container">
					<div class="carousel-caption">
						<div class="carousel-title"><?php echo h($article['Category']['name']); ?></div>
						<div class="caption-title"><?php echo h($article['Article']['title']); ?></div>
						<div class="p-n-articles">
							<?php if (isset($articleNeighbors['prev'])) { ?>
								<div class="p-article">
									<div class="pna-title"><?php echo __('Previous article');?></div>
									<?php echo $this->Html->link(h($articleNeighbors['prev']['Article']['title']), array(
											'controller' => 'articles',
											'action' => 'view',
											$articleNeighbors['prev']['Article']['id'],
											Inflector::slug($articleNeighbors['prev']['Article']['slug'],'-')
										), array(
											'escape' => false
										)
									); ?>
								</div>
							<?php } ?>
							<?php if (isset($articleNeighbors['next'])) { ?>
								<div class="n-article">
									<div class="pna-title"><?php echo __('Next article');?></div>
									<?php echo $this->Html->link(h($articleNeighbors['next']['Article']['title']), array(
											'controller' => 'articles',
											'action' => 'view',
											$articleNeighbors['next']['Article']['id'],
											Inflector::slug($articleNeighbors['next']['Article']['slug'],'-')
										), array(
											'escape' => false
										)
									); ?>
								</div>
							<?php	}	?>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Content -->
<div class="blog-content">
	<div class="home-wrapper em-container">
		<div class="row">
			<div class="col-xs-12 col-md-9">
				<div class="post-top">
					<div class="post-author">
						<?php
							echo $this->Html->link($this->Html->displayUserAvatar($article['User']['image_path']),'javascript:void(0);',array('escape' => false));
						?>
						<div class="pa-user">
							<div class="pa-name">
							<?php echo h($article['User']['name']) .'&nbsp'. h($article['User']['surname']); ?>
							<?php echo $this->Time->niceShort($article['Article']['created']); ?>
							</div>
							<div class="pa-title">
							<?php echo (!empty($article['User']['role'])) ?  $article['User']['role'] : __('Article manager') ; ?>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- Social share and stat -->
					<!-- @TODO -->
					<?php if (false) {?>
						<div class="post-share">
							<div class="ps-social">
								<a href="#" class="btn btn-sm btn-icon btn-round btn-o btn-facebook"><span class="fa fa-facebook"></span></a>
								<a href="#" class="btn btn-sm btn-icon btn-round btn-o btn-twitter"><span class="fa fa-twitter"></span></a>
								<a href="#" class="btn btn-sm btn-icon btn-round btn-o btn-google"><span class="fa fa-google-plus"></span></a>
								<a href="#" class="btn btn-sm btn-icon btn-round btn-o btn-blue"><span class="fa fa-linkedin"></span></a>
							</div>
							<div class="ps-stats">
								<span>245</span> Shares&nbsp;&nbsp;&nbsp;
								<span>4</span> Comments
							</div>
						</div>
					<?php } ?>
					<div class="clearfix"></div>
				</div>

				<div class="post-content">
					<h2 class="osLight"><?php echo h($article['Article']['title']);?></h2>
					<div class="summary-article">
						<?php
							$pattern = "/<p[^>]*><\\/p[^>]*>/";
							$article_content = $article['Article']['content'];
							$article_content = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $article_content);
							$article_content = preg_replace($pattern, '', $article_content);
							echo getDescriptionHtml($article_content);
						?>
					</div>
				</div>

				<div class="f-pn-articles">
					<?php if (isset($articleNeighbors['prev'])) {
						$articleLink  = Router::Url(array('controller' =>'articles','action' => 'view', $articleNeighbors['prev']['Article']['id'], Inflector::slug($articleNeighbors['prev']['Article']['slug'],'-')), true);
					?>
						<a href="<?php echo h($articleLink);?>" class="f-p-article">
							<div class="fpna-title"><?php echo __('Previous article');?></div>
							<span class="fpna-header">
								<?php echo h($articleNeighbors['prev']['Article']['title']); ?>
							</span>
							<span class="fa fa-angle-left pull-left pn-icon"></span>
						</a>
					<?php	}	?>

					<?php if (isset($articleNeighbors['next'])) {
						$articleLink  = Router::Url(array('controller' =>'articles','action' => 'view',$articleNeighbors['next']['Article']['id'], Inflector::slug($articleNeighbors['next']['Article']['slug'],'-')), true);
					?>
						<a href="<?php echo h($articleLink); ?>" class="f-n-article">
							<div class="fpna-title"><?php echo __('Next article');?></div>
							<span class="fpna-header">
								<?php echo h($articleNeighbors['next']['Article']['title']); ?>
							</span>
							<span class="fa fa-angle-right pull-right pn-icon"></span>
						</a>
					<?php	}	?>
					<div class="clearfix"></div>
				</div>

				<?php if (!empty($relatedArticles)) { ?>
					<h2 class="osLight align-left"><?php echo __('Related Articles');?></h2>
					<div class="row pb20">
						<?php
						$directorySmURLRelated = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Article'. DS.'small'.DS;
						$directorySmPATHRelated = 'uploads/Article/small/';

						foreach ($relatedArticles as $relatedArticle) {
							$articleLink  = Router::Url(array('controller' =>'articles','action' => 'view', $relatedArticle['Article']['id'], Inflector::slug($relatedArticle['Article']['slug'],'-')), true);
						?>
						<div class="col-xs-12 col-sm-4">
							<div class="article bg-w">
								<?php
									if (file_exists($directorySmURLRelated.$relatedArticle['Article']['featured_image']) && is_file($directorySmURLRelated.$relatedArticle['Article']['featured_image'])) {
										$base64 = $directorySmPATHRelated.$relatedArticle['Article']['featured_image'];
									} else {
										$base64 = 'no-img-available.png';
									}
									echo $this->Html->link($this->Html->image($base64, array('alt'=>'blog image')),array(
											'controller' => 'articles', 
											'action' => 'view', 
											$relatedArticle['Article']['id'], 
											Inflector::slug($relatedArticle['Article']['slug'],'-')
										),
										array('escape' => false, 'class'=>'image')
									);
								?>
								<div class="article-category">
									<a href="javascript:void();" class="text-green">
										<?php echo h($relatedArticle['Category']['name']); ?>
									</a>
								</div>
								<h3 class="osLight"><a href="<?php echo h($articleLink); ?>"><?php echo h($relatedArticle['Article']['title']); ?></a></h3>
								<div class="summary-article">
									<?php
										$pattern = "/<p[^>]*><\\/p[^>]*>/";
										$article_summary = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $relatedArticle['Article']['summary']);
										$article_summary = preg_replace($pattern, '', $article_summary);
										echo htmlspecialchars_decode(stripslashes(h($article_summary)));
									?>
								</div>
								<div class="footer">
									<a href="javascript:;">
										<?php echo h($relatedArticle['User']['name']) .'&nbsp'. h($relatedArticle['User']['surname']); ?>
									</a>,&nbsp;
									<a href="javascript:;">
										<?php echo $this->Time->niceShort($relatedArticle['Article']['created']);?>
									</a>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				<?php } ?>
				<!-- comments-->
				<!-- @TODO -->
				<?php if (false) {?>
					<h2 class="osLight align-left"><span>4</span> Comments</h2>
					<div class="post-comments">
						<div class="comment">
							<div class="commentAvatar">
								<img class="avatar" src="images/avatar-3.png" alt="avatar">
								<div class="commentArrow bg-w"><span class="fa fa-caret-left"></span></div>
							</div>
							<div class="commentContent bg-w">
								<div class="commentName">Rust Cohle</div>
								<div class="commentBody">
									It is a long established fact that a reader will be distracted by the readable content
								</div>
								<div class="commentActions">
									<div class="commentTime"><span class="icon-clock"></span> 1 day ago</div>
									<ul>
										<li><a href="#"><span class="icon-action-undo"></span></a></li>
										<li><a href="#"><span class="icon-like"></span> 13</a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="comment reply">
							<div class="commentAvatar">
								<img class="avatar" src="images/avatar-1.png" alt="avatar">
								<div class="commentArrow bg-w"><span class="fa fa-caret-left"></span></div>
							</div>
							<div class="commentContent bg-w">
								<div class="commentName">John Smith</div>
								<div class="commentBody">
									Comment posted by me. I have the power to remove it.
								</div>
								<div class="commentActions">
									<div class="commentTime"><span class="icon-clock"></span> 2 hours ago</div>
									<ul>
										<li><a href="#"><span class="fa fa-trash-o"></span></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="comment">
							<div class="commentAvatar">
								<img class="avatar" src="images/avatar-5.png" alt="avatar">
								<div class="commentArrow bg-w"><span class="fa fa-caret-left"></span></div>
							</div>
							<div class="commentContent bg-w">
								<div class="commentName">Alex Rogers</div>
								<div class="commentBody">
									Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit
								</div>
								<div class="commentActions">
									<div class="commentTime"><span class="icon-clock"></span> 20 minutes ago</div>
									<ul>
										<li><a href="#"><span class="icon-action-undo"></span></a></li>
										<li><a href="#"><span class="icon-like"></span> 13</a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="comment">
							<div class="commentAvatar">
								<img class="avatar" src="images/avatar-2.png" alt="avatar">
								<div class="commentArrow bg-w"><span class="fa fa-caret-left"></span></div>
							</div>
							<div class="commentContent bg-w">
								<div class="commentName">Jane Smith</div>
								<div class="commentBody">
									Lorem ipsum dolor sit amet, consecteter adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet
								</div>
								<div class="commentActions">
									<div class="commentTime"><span class="icon-clock"></span> 5 minutes ago</div>
									<ul>
										<li><a href="#"><span class="icon-action-undo"></span></a></li>
										<li><a href="#"><span class="icon-like"></span> 13</a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>

					<h2 class="osLight align-left">Leave a Comment</h2>
					<form role="form" class="pb20">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<input type="text" placeholder="Name" class="form-control">
								</div>
							 </div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<input type="text" placeholder="Email" class="form-control">
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group">
									<textarea placeholder="Comment" class="form-control" rows="3"></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<a href="#" class="btn btn-green">Post comment</a>
						</div>
					</form>
				<?php }	?>
			</div>

			<div class="col-xs-12 col-md-3">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
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
									echo "<li><a href='javascript:;'>No Category</a></li>";
								}
							?>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h2 class="osLight h-r"><?php echo __('Article Tags');?></h2>
						<div class="blog-tags">
							<?php
								if (isset($article['Article']['tags']) && !empty($article['Article']['tags'])) {
									$keywords = explode(',' , $article['Article']['tags']);
									foreach ($keywords as $tag){
										echo $this->Html->link(h($tag),'javascript:void(0);',array('escape' => false, 'class'=>'label label-default'));
									}
								} else {
									echo __('No tag for this article');
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>