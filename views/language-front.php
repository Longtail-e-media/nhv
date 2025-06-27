<?php
/*
* Front Language 
*/

/*
* Constant For Home Page
*/
$thmId  = 1;
$thmRec = Themes::field_by_id('cssproperties',$thmId);
$thmRow = unserialize($thmRec);
$jVars['bgclass'] = $thmRow['bodybgtype'];
/* End Body Background */

$resintdu='';
$thmId  = 4;
$thmRec = Themes::field_by_id('properties',$thmId);
$thmRow = unserialize($thmRec);
$jVars['home:intdutitle'] = $thmRow['intdutitle'];
$jVars['home:intdubrief'] = $thmRow['intdubrief'];
$resintdu.='<ul class="services-lines">';
for($i=1; $i<=8; $i++){
	if(!empty($thmRow['ads'.$i.'icon']) and !empty($thmRow['ads'.$i.'title'])){
	    $resintdu.='<li>
	        <div class="item-service-line">
	            <a href="'.$thmRow['ads'.$i.'link'].'">
	                <i class="fa '.$thmRow['ads'.$i.'icon'].'"></i>
	                <h5>'.$thmRow['ads'.$i.'title'].'</h5>
	            </a>
	        </div>
	    </li>';
	}
}
$resintdu.='</ul>';
$jVars['home:intdulists'] = $resintdu;
/* End Interduction Block */

$thmId  = 5;
$thmRec = Themes::field_by_id('properties',$thmId);
$thmRow = unserialize($thmRec);
$jVars['home:pkgtitle'] = $thmRow['mpkgtitle'];
/* End Package Block */

$thmId  = 7;
$thmRec = Themes::field_by_id('properties',$thmId);
$thmRow = unserialize($thmRec);
$jVars['home:offerstitle'] = $thmRow['offerstitle'];
/* End Offers Block */

$thmId  = 8;
$thmRec = Themes::field_by_id('properties',$thmId);
$thmRow = unserialize($thmRec);
$jVars['home:testimonial-title'] = $thmRow['testimonialtitle'];
$jVars['home:testimonial-breif'] = $thmRow['testimonialbrief'];
/* End Testimonial Block */

$thmId  = 9;
$thmRec = Themes::field_by_id('properties',$thmId);
$thmRow = unserialize($thmRec);
$jVars['home:footer-infotext'] = $thmRow['footerbrief']; 
/* End Footer Brief */


$jVars['fornt:discover'] = 'Discover';
$jVars['front:travenews'] = 'Travel News';
$jVars['fornt:mailing'] = 'Mailing List';
$jVars['front:mailing-text'] = 'Sign up for our mailing list to get latest updates and offers.';
$jVars['front:mailing-respect'] = 'We respect your privacy';
$jVars['front:about'] = 'CONTACT US';

/*
* Constant For Inner Page
*/

/*
* Contact us page
*/
$jVars['front:sendmsg'] = 'Send us a Message';
$jVars['front:sendmsgsub'] = 'Etiam gravida ac mi ut posuere. Nunc laoreet nulla a porttitor volutpat. Praesent in rutrum justo, in fermentum nulla. Ut vel nulla tincidunt, lobortis tortor eu, venenatis ligula. Vivamus laoreet leo nulla, nec venenatis erat laoreet et. Integer tincidunt nulla at leo dignissim, ut iaculis libero mattis.';
$jVars['front:wer'] = 'We are on 24/7';
$jVars['front:wersub'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
$jVars['front:sentml'] = 'Send us email on';
$jVars['front:sentmlsub'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
$jVars['front:fadres'] = 'Meet us now';
$jVars['front:fadresub'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';

?>