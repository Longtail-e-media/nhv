<?php
/*
* Top Social Links
*/
$resocl = '';

$socialRec = SocialNetworking::getSocialNetwork();


if (!empty($socialRec)) {
    $resocl .= '<ul>';

    foreach ($socialRec as $socialRow) {
        $resocl .= '<li><a target="_blank" href="' . $socialRow->linksrc . '">
		<i class="fa ' . $socialRow->image . ' fa" aria-hidden="true"></i>
	    	
	  	</a></li>';
    }

    $resocl .= '</ul>';
}

$jVars['module:socilaLinktop'] = $resocl;


/*
*  Social link
*/
$ressl = '';


if (!empty($socialRec)) {
     $ressl .= '<div class="col-sm-12">
                <div class="header-contacts">';
    foreach ($socialRec as $socialRow) {
        $ressl .= '<a href="' . $socialRow->linksrc . '" target="_blank" class="social-icon img-bg-icon rounded-icon soc-' . $socialRow->title . '"></a> ';
    }
    $ressl .= '</div>
            </div>';
}

$jVars['module:socilaLinkbtm'] = $ressl;


/*
*   Footer
*/
$ressl = '';

if (!empty($socialRec)) {
     $ressl .= '<ul class="affilation-footer">';
    foreach ($socialRec as $socialRow) {
        $ressl .= '<li><a href="' . $socialRow->linksrc . '" target="_blank"><i class="fab ' . $socialRow->image . '"></i></a></li>';
    }
    $ressl .= '</ul>';
}

$jVars['module:socilaLinkbtmFooter'] = $ressl;

?>