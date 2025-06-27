<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />

<?php

$moduleTablename  = "tbl_career"; // Database table name

$moduleId         = 32;              // module id >>>>> tbl_modules

$moduleFoldername = "";     // Image folder name



if(isset($_GET['page']) && $_GET['page'] == "career" && isset($_GET['mode']) && $_GET['mode']=="list"):   

?>

<h3>

List of candidates



</h3>

<div class="my-msg"></div>

<div class="example-box">

    <div class="example-code">    

    <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">

       <thead>

            <tr>

               <th style="display:none;"></th>

               <th class="text-center"><input class="check-all" type="checkbox" /></th>

               <th>Name</th>
               <th width="10%">Date</th>
               <th class="text-center">Address</th>   
               <th class="text-center">Phone</th>
               <th class="text-center">Email</th>
               <th class="text-center">Career Option</th>
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>


            </tr>

        </thead> 

            

        <tbody>

            <?php $records = Career::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY career_date DESC ");  

                  foreach($records as $record): ?>    

            <tr id="<?php echo $record->id;?>">

                <td style="display:none;"><?php echo $record->sortorder;?></td>

                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>

                <td><?php echo $record->fullname;?></td>
                <td><?php echo $record->career_date;?></td>
                <td><?php echo $record->current_address;?></td> 
             

                <td><?php echo $record->phone;?></td>                

                <td><?php echo $record->email;?></td>                

                <td><?php echo $record->career;?></td>               

                             

               
                <td class="text-center">

                  
                    <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button" data-placement="top" title="Edit" onclick="editRecord(<?php echo $record->id;?>);">

                        <span class="button-content"> View Detail </span>


                    </a>

                    <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="recordDelete(<?php echo $record->id;?>);">

                        <i class="glyph-icon icon-remove"></i>

                    </a>

                </td>
               

            <?php endforeach; ?>

        </tbody>

    </table>

    </div>

<div class="pad0L col-md-2">

<select name="dropdown" id="groupTaskField" class="custom-select">

    <option value="0"><?php echo $GLOBALS['basic']['choseAction'];?></option>

    <option value="delete"><?php echo $GLOBALS['basic']['delete'];?></option>

    <option value="toggleStatus"><?php echo $GLOBALS['basic']['toggleStatus'];?></option>

</select>

</div>

<a class="btn medium primary-bg" href="javascript:void(0);" id="applySelected_btn">

    <span class="glyph-icon icon-separator float-right">

      <i class="glyph-icon icon-cog"></i>

    </span>

    <span class="button-content"> Submit </span>

</a>

</div>



<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "addEdit"): 

if(isset($_GET['id']) && !empty($_GET['id'])):

    $careerId     = addslashes($_REQUEST['id']);

    $careerInfo   = Career::find_by_id($careerId);

endif;  

?>

<h3>

<?php echo (isset($_GET['id']))?'View career':'View career';?>

<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewcareerlist();">

    <span class="glyph-icon icon-separator">

        <i class="glyph-icon icon-arrow-circle-left"></i>

    </span>

    <span class="button-content"> Back </span>

</a>

</h3>



<div class="my-msg"></div>

<table cellpadding="0" cellspacing="0" border="0" class="table">

        <thead>

            <tr>

               <th style="display:none;"></th>

              

            </tr>

        </thead> 

            

        <tbody>

            <?php $record= Career::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC ");  

                ?>    

            <tr id="<?php echo $record->id;?>"></tr>

                <td style="display:none;"><?php echo $careerInfo->sortorder;?></td>

                <tr>
                    <th>Name</th> <td><?php echo $careerInfo->fullname;?></td>
                </tr>
                <tr><th class="text-center">Address</th><td><?php echo $careerInfo->current_address;?></td>
                  </tr>
                <tr><th class="text-center">Mobile</th><td><?php echo $careerInfo->mobile;?></td>     
                </tr>           

                <tr><th class="text-center">Phone</th><td><?php echo $careerInfo->phone;?></td></tr>                

                <tr><th class="text-center">Email</th><td><?php echo $careerInfo->email;?></td></tr>                

                <tr><th class="text-center">Career Option</th><td><?php echo $careerInfo->career;?></td></tr>               

                 <tr><th class="text-center">Experience</th> <td><?php echo $careerInfo->exp;?></td></tr>                

                <tr><th class="text-center">In years</th><td><?php echo $careerInfo->expyear;?></td></tr>                

                <tr><th class="text-center">In months</th><td><?php echo $careerInfo->expmonth;?></td></tr>                  

               <tr><th class="text-center">Salary</th> <td><?php echo $careerInfo->SalaryCriteria;?></td></tr>
                           
                <tr><th class="text-center">Currency</th><td><?php echo $careerInfo->ES_Currency_Abb;?></</td></tr>
            
                <tr><th class="text-center">Amount</th> <td><?php echo $careerInfo->salary;?></td></tr>  

                 <tr><th class="text-center">Career Level</th><td><?php echo $careerInfo->Level;?></td></tr> 
                                

                <tr><th class="text-center">Special Qualification</th><td><?php echo $careerInfo->qualification;?></td></tr>               

                <tr><th class="text-center">Resume</th><td><a href="../images/career/<?php echo $careerInfo->myfile;?>"target="_blank"><?php echo $careerInfo->myfile;?></a></td></tr>                

               
                <tr><td>
                <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="recordDelete(<?php echo $careerInfo->id;?>);">

                       <span class="button-content"> Remove </span>

                    </a></td></tr>
               

         

        </tbody>

    </table>   

<script>

var base_url =  "<?php echo ASSETS_PATH; ?>";

var editor_arr = ["content"];

create_editor(base_url,editor_arr);

</script>



<script type="text/javascript" src="../assets/uploadify/jquery.uploadify.min.js"></script>

<script type="text/javascript">

   // <![CDATA[

    $(document).ready(function() {

    $('#gallery_upload').uploadify({

    'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',

    'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',

    'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>/',targetFolder:'images/news/',thumb_width:200,thumb_height:200},

    'method'     : 'post',

    'cancelImg'  : '<?php echo BASE_URL;?>uploadify/cancel.png',

    'auto'       : true,

    'multi'      : true,    

    'hideButton' : false,   

    'buttonText' : 'Upload Image',

    'width'      : 125,

    'height'     : 21,

    'removeCompleted' : true,

    'progressData' : 'speed',

    'uploadLimit' : 100,

    'fileTypeExts' : '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',

     'buttonClass' : 'button formButtons',

   /* 'checkExisting' : '/uploadify/check-exists.php',*/

    'onUploadSuccess' : function(file, data, response) {

        $('#uploadedImageName').val('1');

        var filename =  data;

        $.post('<?php echo BASE_URL;?>apanel/news/uploaded_image.php',{imagefile:filename},function(msg){           

               $('#preview_Image').html(msg).show();

            }); 

            

    },

    'onDialogOpen'      : function(event,ID,fileObj) {      

    },

    'onUploadError' : function(file, errorCode, errorMsg, errorString) {

           alert(errorMsg);

        },

    'onUploadComplete' : function(file) {

          //alert('The file ' + file.name + ' was successfully uploaded');

        }   

  });

});

    // ]]>

</script>



<?php endif; ?>