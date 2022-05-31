<?php App::uses('CakeTime', 'Utility'); ?>
<?php echo "<?xml version='1.0' encoding='UTF-8'?>\n" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
	<url>
		<loc><?php echo $this->Html->url('/',true); ?></loc>
		<changefreq>weekly</changefreq>
	</url>
	<?php foreach ($properties as $property): ?>
	<url>
		<loc>
			<?php 
				echo $this->Html->url(array('controller' => 'properties', 'action' => 'view', $property['Property']['id']), true);
			?>
		</loc>
		<lastmod><?php echo $this->Time->toAtom($property['Property']['modified']); ?></lastmod>
		<changefreq>weekly</changefreq>
	</url>
	<?php endforeach; ?>
</urlset>