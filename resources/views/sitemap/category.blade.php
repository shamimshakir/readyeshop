<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($category as $content)
        <url>
            <loc>{{  url('') }}/category/{{ str_replace(' ', '-',$content->cat_name ) }}?catid={{ $content->id }}</loc>
            <lastmod>{{ Carbon\Carbon::parse($content->created_at)->format('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset> 