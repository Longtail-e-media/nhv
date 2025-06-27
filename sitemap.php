<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
header('Content-type: application/xml; charset=utf-8');
require_once("includes/initialize.php");

$xml = '';
$xml .= '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xmlns:xhtml="http://www.w3.org/1999/xhtml"
      xsi:schemaLocation="
            http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
            <url>
                <loc>' . BASE_URL . '</loc>
                <lastmod>' . date('Y-m-dTH:i:sP') . '</lastmod>
                <priority>1.00</priority>
            </url>';

$staticblocks = array('home', 'contact-us', 'destination-list', 'gallery', 'searchlist', 'customize');
foreach ($staticblocks as $page) {
    $xml.='
        <url>
            <loc>' . BASE_URL . $page . '</loc>
            <lastmod>' . date('Y-m-dTH:i:sP') . '</lastmod>
            <priority>0.9</priority>
        </url>
    ';
}

$pages = Articles::find_all_active();
foreach ($pages as $page) {
    $xml .= '
        <url>
            <loc>' . BASE_URL . 'pages/' . $page->slug . '</loc>
            <lastmod>' . date('Y-m-dTH:i:sP', strtotime($page->added_date)) . '</lastmod>
            <priority>0.75</priority>
        </url>
    ';
}

$packages = Package::getPackage();
foreach ($packages as $package) {
    $xml .= '
        <url>
            <loc>' . BASE_URL . 'package/' . $package->slug . '</loc>
            <lastmod>' . date('Y-m-dTH:i:sP', strtotime($package->added_date)) . '</lastmod>
            <priority>0.80</priority>
        </url>
        <url>
            <loc>' . BASE_URL . 'enquiry/package/' . $package->slug . '</loc>
            <lastmod>' . date('Y-m-dTH:i:sP', strtotime($package->added_date)) . '</lastmod>
            <priority>0.51</priority>
        </url>
        <url>
            <loc>' . BASE_URL . 'book/package/' . $package->slug . '</loc>
            <lastmod>' . date('Y-m-dTH:i:sP', strtotime($package->added_date)) . '</lastmod>
            <priority>0.51</priority>
        </url>
    ';
}

$destinations = Destination::find_all();
foreach ($destinations as $destination) {
    $xml .= '
        <url>
            <loc>' . BASE_URL . 'destination/' . $destination->slug . '</loc>
            <lastmod>' . date('Y-m-dTH:i:sP', strtotime($destination->added_date)) . '</lastmod>
            <priority>0.80</priority>
        </url>
        <url>
            <loc>' . BASE_URL . 'activity-list/' . $destination->slug . '</loc>
            <lastmod>' . date('Y-m-dTH:i:sP', strtotime($destination->added_date)) . '</lastmod>
            <priority>0.64</priority>
        </url>
    ';
}

$activities = Activities::find_all();
foreach ($activities as $activity) {
    $xml .= '
        <url>
            <loc>' . BASE_URL . 'activity/' . $activity->slug . '</loc>
            <lastmod>' . date('Y-m-dTH:i:sP', strtotime($activity->added_date)) . '</lastmod>
            <priority>0.80</priority>
        </url>
    ';
}

$blogs = CombinedNews::find_all();
foreach ($blogs as $blog) {
    $xml .= '
        <url>
            <loc>' . BASE_URL . 'blog/' . $blog->slug . '</loc>
            <lastmod>' . date('Y-m-dTH:i:sP', strtotime($blog->added_date)) . '</lastmod>
            <priority>0.75</priority>
        </url>
    ';
}

$xml .= '</urlset>';
$myfile = fopen("sitemap.xml", "w") or die("Unable to open file!");
fwrite($myfile, $xml);
fclose($myfile);
echo $xml;

?>