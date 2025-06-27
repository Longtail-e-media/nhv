<?php
// SEO Meta Tags And Meta Description

function className_metatags()
{
    $current_url = pathinfo($_SERVER["PHP_SELF"]);
    $fileName = $current_url['filename'];

    if ($fileName == 'inner'):
        $className = 'Articles';
        return $className;
        exit;
    endif;

    if ($fileName == 'subpkgdetail'):
        $className = 'Subpackage';
        return $className;
        exit;
    endif;

    if ($fileName == 'blog'):
        $className = 'CombinedNews';
        return $className;
        exit;
    endif;

    if ($fileName != 'index'):
        $className = ucfirst(strtolower($fileName));
        return $className;
        exit;
    endif;

    return '';
}

function MetaTagsFor_SEO()
{

    $c_url = pathinfo($_SERVER["PHP_SELF"]);
    $chk = $c_url['filename'];
    $config = Config::find_by_id(1);
    $sitetitle = (!empty($config->meta_title) and $chk == 'index') ? $config->meta_title : $config->sitetitle;
    $keywords = $config->site_keywords;
    $description = $config->site_description;

    $addtitle = '';
    $class = className_metatags();

    $class_path = SITE_ROOT . 'includes/modals/class.' . strtolower($class) . '.php';
    if (file_exists($class_path)) {
        // Transaction start
        if (isset($_REQUEST['slug']) and !empty($_REQUEST['slug'])) {
            $cls = new $class;
            $rec = $cls->find_by_slug(addslashes($_REQUEST['slug']));
            if (!empty($rec)) {
                $addtitle = !empty($rec->meta_title) ? $rec->meta_title : $rec->title;
                if (!empty($rec->meta_keywords)) {
                    $keywords = $rec->meta_keywords;
                    $description = $rec->meta_description;
                }
            }
        }

        if (isset($_REQUEST['id']) and !empty($_REQUEST['id'])) {
            $cls = new $class;
            $rec = $cls->find_by_id($_REQUEST['id']);
            if ($rec) {
                $addtitle = $rec->title;
            }
        }
    }

    $altclass = !empty($class) ? $class : '';
    $addtitle = !empty($addtitle) ? $addtitle : $altclass;
    $addsep = !empty($addtitle) ? ' - ' : '';

    $sociallinks = SocialNetworking::getSocialNetwork();
    $sameas = '';
    foreach ($sociallinks as $social) {
        if (end($sociallinks) === $social) {
            $sameas .= '"' . $social->linksrc . '"';
        } else {
            $sameas .= '"' . $social->linksrc . '",';
        }

    }
    $schema = '';
    $schema .= '<script type="application/ld+json">
	{
		"@context": "http://schema.org/",
		"@type": "Organization",
		"headline": "' . $config->sitetitle . '|' . $config->sitename . '",
		"keywords": "' . $config->site_keywords . '",
		"description": "' . $config->site_description . '",
		"url": "' . BASE_URL . '",
		"sameAs": [
					' . $sameas . '
					],
		"image": {
		  "@type": "ImageObject",
		  "height": "",
		  "width": "",
		  "url": "' . IMAGE_PATH . 'preference/' . $config->logo_upload . '"
		},
		"author": "' . $config->sitetitle . '",
		"publisher": {
		  "@type": "Organization",
		  "logo": {
			"@type": "ImageObject",
			"url": "' . IMAGE_PATH . 'preference/' . $config->logo_upload . '"
		  },
		  "name": "' . $config->sitetitle . '|' . $config->sitename . '"
	  }';
    if (!empty($config->schema_code)) {
        $schema .= ',' . $config->schema_code;
    }

    $schema .= '}</script>';

    if (!empty($config->google_anlytics)) {
        $analytic = '<!-- Global Site Tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=' . $config->google_anlytics . '"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag(\'js\', new Date());
		
		  gtag(\'config\', \'' . $config->google_anlytics . '\');
		</script>';
    } else {
        $analytic = '';
    }

    $seoSources = '<title>' . $addtitle . $addsep . $sitetitle . '</title>' . "\n";
    $seoSources .= '' . "\n";
    $seoSources .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">' . "\n";
    $seoSources .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">' . "\n";
    $seoSources .= '<meta name="robots" content="index,follow">' . "\n";
    $seoSources .= '<meta name="Googlebot" content="index, follow"/>' . "\n";
    $seoSources .= '<meta name="distribution" content="Global">' . "\n";
    $seoSources .= '<meta name="revisit-after" content="2 Days" />' . "\n";
    $seoSources .= '<meta name="classification" content="Hotel, Hotels in Nepal" />' . "\n";
    $seoSources .= '<meta name="category" content="Hotel, Hotels in Nepal" />' . "\n";
    $seoSources .= '<meta name="language" content="en-us" />' . "\n";
    $seoSources .= '<meta name="keywords" content="' . $keywords . '">' . "\n";
    $seoSources .= '<meta name="description" content="' . $description . '">' . "\n";
    $seoSources .= '<meta name="author" content="Longtail-e-media">' . "\n";
    $seoSources .= '<meta name="msvalidate.01" content="D3ADCF98EF3FBD0D274199D4EAE2A73E" />' . "\n\n";

    //Facebook and twitter sharing
     if (isset($_REQUEST['slug']) and !empty($_REQUEST['slug'])) {
     if ($class == 'Package') {
                    $rec = $cls->find_by_slug(addslashes($_REQUEST['slug']));
                    // pr($rec);
                    if (!empty($rec)) {
                        $images = $rec->image;
                        if (!empty($images)) {
                            $img = $images[0];
                            $imagePath = SITE_ROOT . 'images/package/' . $images;
                            if (file_exists($imagePath)) {
                                $seoSources .= '<meta property="og:image" content="' . IMAGE_PATH . 'package/' . $images . '">' . "\n";
                                $seoSources .= '<meta property="twitter:image" content="' . IMAGE_PATH . 'package/' . $images . '">' . "\n";
                                $seoSources .= '<meta property="twitter:card" content="summary_large_image">' . "\n";
                                $seoSources .= '<meta property="twitter:url" content="' . BASE_URL . 'blog/' . $rec->slug . '">'."\n";
                            } else {
                                $seoSources .= '<meta property="og:image" content="' . IMAGE_PATH . 'preference/' . $config->fb_upload . '">' . "\n";
                                $seoSources .= '<meta property="twitter:image" content="' . IMAGE_PATH . 'preference/' . $config->twitter_upload . '">' . "\n";
                                $seoSources .= '<meta property="twitter:card" content="summary_large_image">' . "\n";
                                $seoSources .= '<meta property="twitter:url" content="' . BASE_URL . 'blog/' . $rec->slug . '">'."\n";
                            }
                        } else {
                            $seoSources .= '<meta property="og:image" content="' . IMAGE_PATH . 'preference/' . $config->fb_upload . '">' . "\n";
                            $seoSources .= '<meta property="twitter:image" content="' . IMAGE_PATH . 'preference/' . $config->twitter_upload . '">' . "\n";
                                $seoSources .= '<meta property="twitter:card" content="summary_large_image">' . "\n";
                                $seoSources .= '<meta property="twitter:url" content="' . BASE_URL . 'blog/' . $rec->slug . '">'."\n";
                                $seoSources .= '<meta property="twitter:url" content="' . BASE_URL . 'blog/' . $rec->slug . '">'."\n";
                        }
                    } else {
                        $seoSources .= '<meta property="og:image" content="' . IMAGE_PATH . 'preference/' . $config->fb_upload . '">' . "\n";
                        $seoSources .= '<meta property="twitter:image" content="' . IMAGE_PATH . 'preference/' . $config->twitter_upload . '">' . "\n";
                                $seoSources .= '<meta property="twitter:card" content="summary_large_image">' . "\n";
                                $seoSources .= '<meta property="twitter:url" content="' . BASE_URL . 'blog/' . $rec->slug . '">'."\n";
                    }
                }
    if ($class == 'CombinedNews') {
        $seoSources .= '<meta property="og:title" content="' . $rec->title . '">
            <meta property="og:description" content="' . $rec->brief . '">
            <meta property="og:image" content="' . IMAGE_PATH . 'combinednews/' . $rec->image . '">
            <meta property="twitter:image" content="' . IMAGE_PATH . 'combinednews/' . $rec->image . '">
            <meta property="og:url" content="' . BASE_URL . 'blog/' . $rec->slug . '">
            <meta property="twitter:url" content="' . BASE_URL . 'blog/' . $rec->slug . '">
            <meta property="og:type" content="website">
            <meta property="twitter:card" content="summary_large_image">' . "\n\n";
    }
      
    if ($class == 'Article') {
                    $rec = $cls->find_by_slug(addslashes($_REQUEST['slug']));
                    if (!empty($rec)) {
                        $images = unserialize($rec->image);
                        if (!empty($images)) {
                            $img = $images[0];
                            $imagePath = SITE_ROOT . 'images/articles/' . $img;
                            if (file_exists($imagePath)) {
                                $seoSources .= '<meta property="og:image" content="' . IMAGE_PATH . 'articles/' . $img . '">' . "\n";
                                $seoSources .= '<meta property="twitter:image" content="' . IMAGE_PATH . 'articles/' . $img . '">' . "\n";
                            } else {
                                $seoSources .= '<meta property="og:image" content="' . IMAGE_PATH . 'preference/' . $config->fb_upload . '">' . "\n";
                                $seoSources .= '<meta property="twitter:image" content="' . IMAGE_PATH . 'preference/' . $config->twitter_upload . '">' . "\n";
                            }
                        } else {
                            $seoSources .= '<meta property="og:image" content="' . IMAGE_PATH . 'preference/' . $config->fb_upload . '">' . "\n";
                            $seoSources .= '<meta property="twitter:image" content="' . IMAGE_PATH . 'preference/' . $config->twitter_upload . '">' . "\n";
                        }
                    } else {
                        $seoSources .= '<meta property="og:image" content="' . IMAGE_PATH . 'preference/' . $config->fb_upload . '">' . "\n";
                        $seoSources .= '<meta property="twitter:image" content="' . IMAGE_PATH . 'preference/' . $config->twitter_upload . '">' . "\n";
                    }
                }
     }else {
        $seoSources .= '<meta property="og:image" content="' . IMAGE_PATH . 'preference/' . $config->fb_upload . '">' . "\n";
        $seoSources .= '<meta property="twitter:image" content="' . IMAGE_PATH . 'preference/' . $config->twitter_upload . '">' . "\n";
    }
$tot = strlen(SITE_FOLDER) + 2;
    $data = substr($_SERVER['REQUEST_URI'], $tot);
    $seoSources .= '<meta property="og:title" content="' . $addtitle . '">' . "\n";
    //$seoSources.='<link rel="canonical" href="'.curPageURL().':443" />'."\n";
    // $seoSources.='<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5cff382e5aa44b23"></script>'."\n";
    $seoSources .= '<base url="' . BASE_URL . '"/>' . "\n";
    $seoSources .= $analytic . "\n";
    $seoSources .= $schema . "\n";

    return $seoSources;
}

?>