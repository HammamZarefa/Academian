<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<?php echo '<?xml-stylesheet type="text/xsl" href="'.asset("css/sitemap.xsl").'"?>'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($data['routes'] as $name => $updated_date)
        <url>
            <loc>{{ route($name) }}</loc>
            @if($updated_date)
            <lastmod>{{ $updated_date->tz('UTC')->toAtomString() }}</lastmod>
            @endif        
        </url>
    @endforeach
</urlset> 