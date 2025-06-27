<?php
$vacencylist = '';



//echo"<pre>";var_dump($vacencies);die();

if (defined('CAREER_PAGE'))  {
    $vacencies = Vacency::get_allvacancy();
    if(!empty($vacencies)) {
          
    //$slug = !empty($_REQUEST['slug']) ? addslashes($_REQUEST['slug']) : '';
    //$vacancy = Vacency::find_by_id($slug);
    //$date = strtotime($vacancy->vacency_date) - strtotime(date('Y-m-d'));
    //$date = $date / 86400;
    foreach ($vacencies as $vacency) {
       $vacencylist .= '<div class="col-md-9">
         <h4>' . $vacency->title . '- ' . $vacency->pax . '</h4> 
              <p>' . $vacency->content . '</p>
          </div>
          <div class="col-md-3">
              <a href="' . BASE_URL . 'careerform/' . $vacency->slug . '"><span data-hover="APPLY NOW">APPLY NOW</span></a>
          </div>';



         
    }
        
    }else{
         $vacencylist.= '<h4 style="text-align: center;
    font-size: 55px;">NO VACANCY!!!!</h4></br></br>';
    }
    }
 /*else {
    $vacencies = Vacency::find_all_current();
    foreach ($vacencies as $key => $vacency) {
        $date = strtotime($vacency->vacency_date) - strtotime(date('Y-m-d'));
        $date = $date / 86400;
        $vacencylist .= '<div class="col-md-12">
         <strong>' . ($key + 1) . '. <a href="' . BASE_URL . 'vacancy/' . $vacency->id . '" >' . $vacency->title . '</a></strong> <small class=" redfont pull-right"><i>' . $date . ' days left </i></small><br><hr>
        </div> ';
    }
}*/


$jVars['module:vacencylist'] = $vacencylist;
$careerform='';
if (defined('CAREER_PAGE') and isset($_REQUEST['slug']))  {
    $slug = $_REQUEST['slug'];

$v = Vacency::find_by_slug($slug);
$careerform='<div class="col-xs-12">
<form action="" id="careerform" method="post" enctype="multipart/form-data">
<input type="hidden" name="position" value="' . $v->id . '">
          <div class="form-group">
            <label>Your Name</label>
            <input type="text" placeholder="Type Your Full Name" name="fname"> 
          </div>
          <!-- end form-group -->
          <div class="form-group">
            <label>Your E-mail</label>
            <input type="text" placeholder="Type Your E-Mail" name="email">
          </div>
          <!-- end form-group -->
          <div class="form-group">
            <label>Phone Number</label>
            <input type="text" placeholder="Type Your Phone Number" name="contact">
          </div>
          <!-- end form-group -->
          <div class="form-group">
            <label>Your Address</label>
            <input type="text" placeholder="Type Your Address" name="address">
          </div>
          <!-- end form-group -->
          <div class="form-group">
            <label>Upload Your Resume</label>
        <div class="file"><i class="flaticon-file-1"></i><input type="file" id="FileAttachment" name="myfile"><div id="file"><input type="hidden" name="fileArrayname" value="" class="" /></div><input type="text" id="fileuploadurl" readonly="" placeholder="Maximum file size is 500KB"><span class="button">UPLOAD FILE</span></div>
        <div id="responseFile"></div>
        <!-- end file -->
          </div>
          <!-- end form-group -->
          <div class="form-group">
            <label>Your Message</label>
            <textarea placeholder="Why should we hire you?"  name="message"></textarea>
          </div> 
          
          <div class="form-group agree">
          
            <input type="checkbox" id="Agree" name="agreements" value="">
            <p  id="Agrees" >  I hereby certify that the above information is true and correct to the best of my knowledge. I understand that false information may disqualify me.</p>
            
        </div>
  
          <!-- end form-group -->
          <div class="form-group">
        <button type="submit" id="button"><span data-hover="APPLY NOW">APPLY NOW</span></button>
<div class="alert alert-success" id="msg" style="display:none;"></div>
          </div>
          
          <!-- end form-group -->
        </form>
      </div>';
}
      $jVars['module:careerform'] = $careerform;

?>