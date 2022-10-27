 <?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($product as $content)
        <url>
            <loc>{{  url('') }}/product/details/{{ str_replace(' ', '-',$content->pd_name ) }}</loc>
            <lastmod>{{ Carbon\Carbon::parse($content->created_at)->format('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset> 