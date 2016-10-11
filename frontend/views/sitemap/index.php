<?php /* @var $urls */
    /* @var $host */
    echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($urls as $url): ?>
        <url>
            <loc><?= $host.$url['loc'] ?></loc>
            <lastmod><?= isset($url['lastmod'])?date('Y-m-d H:m:s Z', $url['lastmod']):''?></lastmod>
            <changefreq><?= $url['changefreq'] ?></changefreq>
            <priority>0.5</priority>
        </url>
    <?php endforeach; ?>
</urlset>
