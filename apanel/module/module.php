<?php
if(isset($_GET['page']) && $_GET['page'] == "module" && isset($_GET['mode']) && $_GET['mode']=="list"):	
?>
<h3>
List Module
<?php if(isset($_REQUEST['id']) and !empty($_REQUEST['id'])):?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right mrg5R" href="javascript:void(0);" onClick="viewchild('');">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
<?php endif;?>
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
               <th>Link</th>            
               <th class="text-center">Child</th>
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $parentId = (isset($_REQUEST['id']) and !empty($_REQUEST['id']))?addslashes($_REQUEST['id']):0; 
                  $records = Module::find_all_byparnt($parentId);
				  foreach($records as $record): ?>    
            <tr id="<?php echo $record->id;?>">
            	<td style="display:none;"><?php echo $record->sortorder;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td><?php echo $record->name;?></td>
                <td><?php echo $record->link;?></td>   
                <td class="text-center">
                <?php $countChild = Module::getTotalSub($record->id);
                $childlink = ($countChild)?'onClick="viewchild('.$record->id.');"':'';?>
                    <a class="medium btn loadingbar-demo" title="" <?php echo $childlink;?>  href="javascript:void(0);">
                        <span class="badge bg-green radius-all-4 mrg5R" title="" ><?php echo $countChild;?></span>                            
                    </a>
                </td>            
                <td class="text-center">
					<?php	
                        $statusImage = ($record->status == 1) ? "bg-green" : "bg-red" ; 
                        $statusText = ($record->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ; 
                    ?>                                             
                    <a href="javascript:void(0);" class="btn small <?php echo $statusImage;?> tooltip-button statusToggler" data-placement="top" title="<?php echo $statusText;?>" status="<?php echo $record->status;?>" id="imgHolder_<?php echo $record->id;?>" moduleId="<?php echo $record->id;?>">
                        <i class="glyph-icon icon-flag"></i>
                    </a>
					<input name="sortId" type="hidden" value="<?php echo $record->id;?>">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>