<?php
require_once('../../includes/initialize.php');
$result='';
$prentId = addslashes($_REQUEST['parentOf']);
$parentName = addslashes($_REQUEST['Rname']);
$indx = addslashes($_REQUEST['Indx'])+1;

$result.='<script>
			$(document).ready(function() {
				oTable = $("#example'.$indx.'").dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"fnDrawCallback": function ( oSettings ) {
						/* Need to redo the counters if filtered or sorted */
						if ( oSettings.bSorted || oSettings.bFiltered )
						{
							for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
							{
								$("td:eq(0)", oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
							}
						}
					}
				}).rowReordering({ 
					  sURL:"'.BASE_URL.'includes/controllers/ajax.menu.php?action=sort",
					  fnSuccess: function(message) { 
								var msg = jQuery.parseJSON(message);
								showMessage(msg.action,msg.message);
						   }
					   });
				/*************************************** Sub menu Status Toggler ******************************************/	
				$(".submenuToggler").on("click", function(){	
					var id 		= $(this).attr("moduleId");
					var status 	= $(this).attr("status");		
					newStatus = (status == 1) ? 0 : 1;
					$.ajax({
					   type: "POST",
					   url:  getLocation(),
					   data: "action=toggleStatus&id="+id,
					   success: function(msg){}
					});
					$(this).attr({"status":newStatus});
					if(status==1){
						$("#imgHolder_"+id).removeClass("bg-green");
						$("#imgHolder_"+id).addClass("bg-red");
					}else{
						$("#imgHolder_"+id).removeClass("bg-red");
						$("#imgHolder_"+id).addClass("bg-green");
					}
				});		   
			});
		  </script>';

$result.='<h3>List Menu <i>[ '.$parentName.' ]</i></h3>';

$result.='<div class="example-box">
    <div class="example-code">
    	<table cellpadding="0" cellspacing="0" border="0" class="table" id="example'.$indx.'">
            <thead>
                <tr>
                   <th>S.No.</th>
                   <th>Name</th>
                   <th class="text-center">Link</th>
                   <th class="text-center">'.$GLOBALS["basic"]["action"].'</th>
                </tr>
            </thead> 
                
            <tbody>';
            $menuSQL = "SELECT * FROM tbl_menu WHERE parentOf=".$prentId." ORDER BY sortorder ASC";
			$menus = Menu::find_by_sql($menuSQL);
			
            foreach($menus as $row):   
       $result.='<tr id="'.$row->id.'">
                    <td class="text-center">'.$row->sortorder.'</td>               
                    <td>';
					$submenu = Menu::countSubMenu($row->id); 
					$level = ($submenu)?$indx:0;
					if($submenu):
			  $result.='<a href="javascript:void(0);" title="title" onClick="displaySubMenu('.$row->id.',\''.$row->name.'\','.$indx.')" id="" name="'.$row->name.'">
							'.$row->name.'<i>['.Menu::countSubMenu($row->id).']</i>
						</a>';
					else:
						$result.=$row->name;
					endif;	
		 $result.='</td>
                    <td>'.$row->linksrc.'</td>           
        
                    <td class="text-center">';    
                    $statusImage = ($row->status == 1) ? "bg-green" : "bg-red" ; 
                    $statusText = ($row->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ; 

                    $result.='<a href="javascript:void(0);" class="btn small '.$statusImage.' tooltip-button submenuToggler" data-placement="top" title="'.$statusText.'" status="'.$row->status.'" id="imgHolder_'.$row->id.'" moduleId="'.$row->id.'">
                            <i class="glyph-icon icon-flag"></i>
                        </a>
                        <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button" data-placement="top" title="Edit" onclick="editRecord('.$row->id.');">
                            <i class="glyph-icon icon-edit"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="recordDelete('.$row->id.','.$level.');">
                            <i class="glyph-icon icon-remove"></i>
                        </a>
                        <input name="sortId" type="hidden" value="'.$row->id.'">
                    </td>
                </tr>';
                endforeach;
  $result.='</tbody>
        </table>
    </div>
</div>';

$results['submenu'] = $result;
echo json_encode($results);
?>