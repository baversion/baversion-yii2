<?php

/* @var $this yii\web\View */

?>

<?php if ($sitemap === null): ?>
    <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <?php foreach ($items as $item): ?>
        <sitemap>
          <loc><?= $item['loc'] ?></loc>
          <?php if (isset($item['lastmod'])): ?>
          <lastmod><?= $item['lastmod'] ?></lastmod>
          <?php endif; ?>
        </sitemap>
        <?php endforeach; ?>
    </sitemapindex>
<?php else: ?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
            xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
            xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
        <?php foreach ($items as $item): ?>
            <url>
                <loc><?= $item['loc'] ?></loc>

                <?php if (isset($item['lastmod'])): ?>
                    <lastmod><?= $item['lastmod'] ?></lastmod>
                <?php endif; ?>

                <?php if (isset($item['changefreq'])): ?>
                    <changefreq><?= $item['changefreq'] ?></changefreq>
                <?php endif; ?>

                <?php if (isset($item['priority'])): ?>
                    <priority><?= $item['priority'] ?></priority>
                <?php endif; ?>

                <?php if (isset($item['image'])): ?>
                    <image:image>
                        <image:loc><?= $item['image']['loc'] ?></image:loc>
                        <?php if (isset($item['image']['title'])): ?>
                            <image:title><?= $item['image']['title'] ?></image:title>
                        <?php endif; ?>
                    </image:image>
                <?php endif; ?>
            </url>
        <?php endforeach; ?>
    </urlset>
<?php endif; ?>