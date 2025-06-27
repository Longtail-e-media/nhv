<?php 
/*
* Links module page
*/
$reslinks='';

$linkRec = Links::find_all_byparnt();
if($linkRec){
	foreach($linkRec as $linkRow){
		$reslinks.='<div class="treak_link">
			<h5>'.$linkRow->title.'</h5>';
			$sublinkRec = Links::find_all_byparnt($linkRow->id);
			if($sublinkRec){
				$reslinks.='<ul>';
				foreach($sublinkRec as $sublinkRow){
					$purelink = PureUrl($sublinkRow->title, $sublinkRow->linksrc, $sublinkRow->linktype, $sublinkRow->title);
					$reslinks.='<li>'.$purelink.'</li>';
				}
				$reslinks.='</ul>';
			}
		$reslinks.='</div>';
	}
}

$jVars['module:links-list'] = $reslinks;
?>