
<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<?php
$moduleTablename  = "tbl_news_comment"; // Database table name
$moduleFoldername = "newscomment";     // Image folder name

if(isset($_GET['page']) && $_GET['page'] == "combinednews" && isset($_GET['mode']) && $_GET['mode']=="commentlist"):   
    $id = intval(addslashes($_GET['id']));  

?>
<h3>
List Comments
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewcombinednewslist();">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>

    <span class="button-content"> Back </span></a>

</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">    
    <table cellpadding="0" cellspacing="0" border="0" class="table" id="subexample">
        <thead>
            <tr>
               <th style="display:none;"></th>
               <th class="text-center"><input class="check-all" type="checkbox" /></th>
               <th class="text-center">Name</th>              
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = NewsComment::find_by_sql("SELECT * FROM ".$moduleTablename." WHERE news_id=".$id." ORDER BY sortorder DESC ");  

                  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
                <td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td><div class="col-md-7">
                    <a href="javascript:void(0);" onClick="editComment(<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->person_name;?>"><?php echo $record->person_name;?></a>
                    </div>
                </td>               
                <td class="text-center">
                    <?php  
                    //echo"<pre>";print_r($record->status);die(); 
                        $statusImage = ($record->status == 1) ? "bg-green" : "bg-red" ; 
                        $statusText = ($record->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ; 
                    ?>                                             
                    <a href="javascript:void(0);" class="btn small <?php echo $statusImage;?> tooltip-button statusSubToggler" data-placement="top" title="<?php echo $statusText;?>" status="<?php echo $record->status;?>" id="imgHolder_<?php echo $record->id;?>" moduleId="<?php echo $record->id;?>">
                        <i class="glyph-icon icon-flag"></i>
                    </a>
                    <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button"
                           data-placement="top" title="View detail" onclick="editComment(<?php echo $record->id; ?>);">

                            <span class="button-content"> View Detail </span>


                        </a>
                   
                    <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="subrecordDelete(<?php echo $record->id;?>);">
                        <i class="glyph-icon icon-remove"></i>
                    </a>
                    <input name="sortId" type="hidden" value="<?php echo $record->id;?>">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <div class="pad0L col-md-2">
<select name="dropdown" id="groupTaskField" class="custom-select">
    <option value="0"><?php echo $GLOBALS['basic']['choseAction'];?></option>
    <option value="subdelete"><?php echo $GLOBALS['basic']['delete'];?></option>
    <option value="subtoggleStatus"><?php echo $GLOBALS['basic']['toggleStatus'];?></option>
</select>
</div>
    <a class="btn medium primary-bg" href="javascript:void(0);" id="applySelected_btn">
        <span class="glyph-icon icon-separator float-right">
          <i class="glyph-icon icon-cog"></i>
        </span>
        <span class="button-content"> Click </span>
    </a>
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "EditComment"): 
if(isset($_GET['id']) && !empty($_GET['id'])):
    $commentId     = addslashes($_REQUEST['id']);
    $commentInfo   = NewsComment::find_by_id($commentId);

endif;  
?>
<h3>
<?php echo (isset($_GET['id']))?'View Comment':'View Comment';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewcombinednewslist();">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>

    <span class="button-content"> Back </span></a>
</h3>

<div class="my-msg"></div>
 <table cellpadding="0" cellspacing="0" border="0" class="table">

        <thead>


            <th style="display:none;"></th>


        </tr>

        </thead>

        <tr>

        <tbody>

        <?php $record = NewsComment::find_by_sql("SELECT * FROM " . $moduleTablename . " ORDER BY sortorder DESC ");
        

        ?>

        <tr id="<?php echo $record->id; ?>"></tr>

        <td style="display:none;"><?php echo $commentInfo ->sortorder; ?></td>

        <tr>
            <th>Name</th>
            <td><?php echo $commentInfo ->person_name; ?></td>
        </tr>
        <tr>
            <th class="text-center">Address</th>
            <td><?php echo $commentInfo ->person_address; ?></td>
        </tr>
       

        <tr>
            <th class="text-center">Email</th>
            <td><?php echo $commentInfo ->person_email; ?></td>
        </tr>


        <tr>
            <th class="text-center">Comments</th>
            <td><?php echo $commentInfo ->comment; ?></td>
        </tr>
        
        <tr>
            <th class="text-center">Phone</th>
            <td><?php echo $commentInfo ->phone; ?></td>
        </tr>


       <tr>
            <th class="text-center">Image</th>
            <td><a href='../../../images/newscomment/<?php echo $commentInfo ->image; ?>' target="_blank"><?php echo $commentInfo ->image; ?></a></td>
        </tr> 



        </tbody>

    </table>


<?php endif; ?>