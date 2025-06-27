<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<?php
$moduleTablename  = "tbl_subscribers"; // Database table name
$moduleId 		  = 22;				// module id >>>>> tbl_modules
$moduleFoldername = "subscribers";		// Image folder name
	
if(isset($_GET['page']) && $_GET['page'] == "subscribers" && isset($_GET['mode']) && $_GET['mode']=="list"):       
?>
<h3>
List Subscribers
</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">    
    <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
        <thead>
            <tr>
               <th class="text-center">S.No.</th>
               <th>Fullname</th>
               <th class="text-center">Email Address</th>      
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Subscribers::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC "); 
                  $sn=1;
                  foreach($records as $record): ?>    
            <tr id="<?php echo $record->id;?>">
                <td class="text-center"><?php echo $sn++;?></td>                
                <td><?php echo !empty($record->title)?$record->title:'';?></td>                              
                <td><?php echo !empty($record->mailaddress)?$record->mailaddress:'';?></td>
                <td class="text-center">                    
                    <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="recordDelete(<?php echo $record->id;?>);">
                        <i class="glyph-icon icon-remove"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
<?php endif; ?>