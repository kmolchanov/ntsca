<?php

use yii\helpers\Html;

/** @var array[] $urls */

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url): ?>
    <url>
        <loc><?= Html::encode($url['loc']) ?></loc>
        <?php if (!empty($url['lastmod'])): ?>
            <lastmod><?= Html::encode($url['lastmod']) ?></lastmod>
        <?php endif; ?>
        <changefreq><?= Html::encode($url['changefreq']) ?></changefreq>
        <priority><?= Html::encode($url['priority']) ?></priority>
    </url>
<?php endforeach; ?>
</urlset>
