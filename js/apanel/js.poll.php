<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.poll.php';
}
function getTableId(){
	return 'table_dnd';
}

$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.poll.php?action=sort",
		  fnSuccess: function(message) { 
					var msg = jQuery.parseJSON(message);
					showMessage(msg.action,msg.message);
			   }
		   });
});

/***************************************** Add New Row *******************************************/
function addnewRow() {	
	var rowNum = Math.floor((Math.random()*999)+1);	
	var newRow ='<div class="form-row my-style" id="NewRow'+rowNum+'">';
        newRow +='<div class="form-label col-md-2"></div>';
		newRow +='<div class="form-input col-md-12">';                    
			newRow+='<div class="col-md-4">';
				newRow+='<input placeholder="Options Title" type="text" name="pollOption[]" id="pollOption" class="validate[required]">';
			newRow+='</div>';
			newRow+='<div>';
				newRow+='<a href="javascript:void(0);" class="btn medium bg-blue tooltip-button" data-placement="right" title="Add" onclick="addnewRow(this);">';
					newRow+='<i class="glyph-icon icon-plus-square"></i>';
			   newRow+='</a>';
			    newRow+='<a href="javascript:void(0);" class="btn medium bg-red tooltip-button" data-placement="right" title="Delete" onclick="deletenewRow('+rowNum+');">';
					newRow+='<i class="glyph-icon icon-minus-square"></i>';
			   newRow+='</a>';
			 newRow+='</div>';                                          
		 newRow+='</div>';
		 newRow+='</div>';
	
	$('#option-field').append(newRow);
}

/***************************************** Delete Add Row *******************************************/
function deletenewRow(rnum)
{	
	/*var x = confirm("Are you sure you want to delete?");
	if (x){*/		
		$('#NewRow'+rnum).remove();
	/*}else{
	return false;		
   }*/	
}

/*************************************** Toggle AddEdit Form ********************************************/	
function toggleMetadata(){
	$( ".metadata" ).slideToggle("slow",function(){});
}

$(document).ready(function(){		
	// form submisstion actions		
	jQuery('#poll_frm').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('#btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=add&" : "action=edit&" ;
				for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();

				var data = $('#poll_frm').serialize();
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
						   setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>poll/list";},3000);
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
});

// Edit records
function editRecord(Re)
{
	$.ajax({
	   type: "POST",
	   dataType:"JSON",
	   url:  getLocation(),
	   data: 'action=editExistsRecord&id='+Re,
	   success: function(data){
		   var msg = eval(data);
		   $("#title").val(msg.title);
		   $("#idValue").val(msg.editId);		   
	   }
	});
}
		
// Deleting Record
function recordDelete(Re){
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"poll")?>');															
	$('.pText').html('Click on yes button to delete this poll permanently.!!');
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
				 var msg = eval(data);  
				 showMessage(msg.action,msg.message);
				 $('#'+Re).remove();
				 reStructureList(getTableId());
			   }
			});
		}else{ Re=null;}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}

/***************************************** View Newss Lists *******************************************/
function viewpolllist()
{
	window.location.href="<?php echo ADMIN_URL?>poll/list";
}

/***************************************** Add New Newss *******************************************/
function AddNewNewss()
{
	window.location.href="<?php echo ADMIN_URL?>poll/addEdit";
}

/***************************************** Edit records *****************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>poll/addEdit/"+Re;
}
</script>