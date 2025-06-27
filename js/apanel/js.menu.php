<script language="javascript">
//alert(abc.toSource())
function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.menu.php';
}
function getTableId(){
	return 'table_dnd';
}


$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"fnDrawCallback": function ( oSettings ) {
			/* Need to redo the counters if filtered or sorted */
			if ( oSettings.bSorted || oSettings.bFiltered )
			{
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
				{
					$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
				}
			}
		}
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.menu.php?action=sort",
		  fnSuccess: function(message) { 
					var msg = jQuery.parseJSON(message);
					showMessage(msg.action,msg.message);
			   }
		   });
});

$(document).ready(function(){
	$('.btn-submit').on('click',function(){
		var actVal = $(this).attr('btn-action');
		$('#idValue').attr('myaction',actVal);
	})	
	
	// form submisstion actions		
	jQuery('#menu_frm').validationEngine({
		prettySelect : true,
		autoHidePrompt:true,
		useSuffix: "_chosen",
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				var module = $('option:selected', "#linkPage").attr('module');
				var module_id = $('option:selected', "#linkPage").attr('module_id');
				var mods = (module)?module:'None';
				var modsid = (module_id)?module_id:'0';
				$('#btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=add&module="+mods+"&module_id="+modsid+"&" : "action=edit&module="+module+"&module_id="+module_id+"&" ;
				var data = $('#menu_frm').serialize();
				queryString = action+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  getLocation(),
				   data: queryString,
				   success: function(data){
					   var msg = eval(data);
					   if(msg.action=='warning'){
						   showMessage(msg.action,msg.message);
						   $('#btn-submit').removeAttr('disabled');						   			   
		 				   $('.formButtons').show();
						   return false
					   }
					   if(msg.action=='success'){
						 showMessage(msg.action,msg.message);	
						   var actionId = $('#idValue').attr('myaction');
						   if(actionId==2)
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>menu/list";},3000);						   	
						   if(actionId==1)	
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>menu/addEdit";},3000);						   	
						   if(actionId==0)
						   	setTimeout( function(){window.location.href="";},3000);	
					   }
					   if(msg.action=='notice'){
					  	 showMessage(msg.action,msg.message);		   					   
					   	 setTimeout( function(){window.location.href=window.location.href;},3000);
					   }			   					   
					   if(msg.action=='error'){
						   showMessage(msg.action,msg.message);
						   $('#buttonsP img').remove();
		 				   $('.formButtons').show();
						   return false;
					   }
				   }
				});
			return false;
			}
		}
	})

	//Parent onchange Event
	$('#parentOf').on('change',function(){
		var selVal = $("select option:selected").val();
		(selVal==0)?$('.menu-position').slideDown():$('.menu-position').slideUp();
	})
});

/***************************************** AddEdit New Menu *******************************************/
function AddNewMenu()
{
	window.location.href="<?php echo ADMIN_URL?>menu/addEdit";
} 

/***************************************** View Person List *******************************************/
function viewMenulist()
{
	window.location.href="<?php echo ADMIN_URL?>menu/list";
}

/***************************************** view person details *******************************************/
function viewMenuDetails(Re)
{
	window.location.href="<?php echo ADMIN_URL?>menu/view/"+Re;
}

/***************************************** Edit records *******************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>menu/addEdit/"+Re;
}

/*$(function(){
	$('#personsetting_frm')[0].reset();
	$('#btn-submit').removeAttr('disabled');	
});*/
function deleteSavedDestinationimage(Re)
{	
	$('.MsgTitle').html('Do you want to delete the record ?');															
	$('.pText').html('Clicking yes will be delete this record permanently. !!!');
	$('.divMessageBox').fadeIn();
	$('.MessageBoxContainer').fadeIn(1000);
	
	$(".botTempo").on("click",function(){						
		var popAct=$(this).attr("id");						
		if(popAct=='yes'){
			$('#removeSavedimg'+Re).fadeOut(1000,function(){$('#removeSavedimg'+Re).remove(); $('.uploader').fadeIn(500);});
		}else{Re='';}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}
/***************************************** Link Type Choose *******************************************/
function linkTypeSelect(Re){
	if(Re == 0) {		
		$('#linkPage_chosen').removeClass("hide");
		($('#linksrc').val() == 'http://www.') ? $('#linksrc').val('') : null ;
	} else {
		$('#linkPage_chosen').addClass("hide");
		($('#linksrc').val() == '') ? $('#linksrc').val("http://www.") : null ;
	}
}
$(document).ready(function(){	
	$('#linkPage').change(function(){
		$('#linksrc').val($(this).val());
	});
});
		
/***************************************** Delete Records *******************************************/
function recordDelete(Re,Relvl){
	var level = Relvl;
	
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"menu")?>');															
	$('.pText').html('Clicking yes will be delete this record permanently. !!!');
	$('.divMessageBox').fadeIn();
	$('.MessageBoxContainer').fadeIn(1000);	
	
	$(".botTempo").on("click",function(){						
		var popAct=$(this).attr("id");		

		if(popAct=='yes'){
			$.ajax({
			   type: "POST",
			   dataType:"JSON",
			   url:  getLocation(),
			   data: 'action=delete&id='+Re,
			   success: function(data){
				  if(level!=0){
						if(level==1){
							$('.submenu1, .submenu2, .submenu3, .submenu4').fadeOut(500);
						}else if(level==2){
							$('.submenu2, .submenu3, .submenu4').fadeOut(500);
						}else if(level==3){
							$('.submenu3, .submenu4').fadeOut(500);
						}else if(level==4){
							$('.submenu4').fadeOut(500);
						}		
					} 
									   
				 var msg = eval(data);  
				 showMessage(msg.action,msg.message);
				 $('#'+Re).remove();
				 reStructureList(getTableId());
			   }
			});
		}else{ Re = null;}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}

/***************************************** Level wise sub menu *******************************************/
function displaySubMenu(Re,Rename,Ind){		
	var Indx = (Ind==null)?1:Ind;
	$('.submenu'+Indx).html('<img src="<?php echo BASE_URL;?>images/apanel/load.gif">');
	$('.submenu'+Indx).slideDown(500, function(){
		$.ajax({
		   type: "POST",
		   dataType:"JSON",
		   url:  "<?php echo ADMIN_URL?>menu/submenu.php",
		   data: 'action=submenu&parentOf='+Re+'&Rname='+Rename+'&Indx='+Indx,
		   success: function(data){
			   if(Indx!=0){
					if(Indx==1){
						$('.submenu2, .submenu3, .submenu4').fadeOut(500);
					}else if(Indx==2){
						$('.submenu3, .submenu4').fadeOut(500);
					}else if(Indx==3){
						$('.submenu4').fadeOut(500);
					}	
				} 
			   
				var msg = eval(data);
				$('.submenu'+Indx).html(msg.submenu);
		   }
		});
		return false;
	});
}
</script>