<?php
$moduleTablename  = "tbl_bookinginfo"; // Database table name
$moduleId 		  = 23;				// module id >>>>> tbl_modules
$moduleFoldername = "";		// Image folder name
	
if(isset($_GET['page']) && $_GET['page'] == "bookinginfo" && isset($_GET['mode']) && $_GET['mode']=="list"):     
?>
<h3>List Booking Info</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">    
    <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
        <thead>
            <tr>
               <th class="text-center">S.No.</th>
               <th>Code</th>
               <th>Fullname</th> 
               <th>Contact Info</th>                   
               <th>Trip Date</th> 
               <th>Pay Type</th>
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Bookinginfo::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC "); 
            $cn=1;
            foreach($records as $record): ?>    
            <tr id="<?php echo $record->id;?>">
                <td class="text-center"><?php echo $cn++;?></td>                
                <td><?php echo set_na($record->accesskey);?></td>                             
                <td><?php echo set_na($record->person_title.' '.$record->person_fname.' '.$record->person_mname.' '.$record->person_lname);?></td>
                <td>Email : <?php echo set_na($record->person_email);?><br />Contact No. : <?php echo set_na($record->person_phone);?></td>
                <td><?php echo $record->trip_date;?></td>
                <td><?php echo set_na($record->pay_type);?></td>
                <td class="text-center">                                            
                    <a href="javascript:void(0);" class="loadingbar-demo btn small bg-green tooltip-button" data-placement="top" title="View" onclick="viewRecord(<?php echo $record->id;?>);">
                        <i class="glyph-icon icon-eye"></i>
                    </a>
                    <?php if($record->status!='1') { ?>
                    <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="recordDelete(<?php echo $record->id;?>);">
                        <i class="glyph-icon icon-remove"></i>
                    </a>
                    <?php } ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "view"): 
if(isset($_GET['id']) && !empty($_GET['id'])):
    $bookingId   = addslashes($_REQUEST['id']);
    $bookingRow  = Bookinginfo::find_by_id($bookingId);
endif;  
?>

<h3>
    View Booking Info
    <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewBookinglist();">
        <span class="glyph-icon icon-separator">
            <i class="glyph-icon icon-arrow-circle-left"></i>
        </span>
        <span class="button-content"> Back </span>
    </a>
</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
        <div class="col-sm-6">
            <h3>Personal Information</h3>
            <ul>
                <li><strong>Fullname : </strong><?php echo $bookingRow->person_title.' '.$bookingRow->person_fname.' '.$bookingRow->person_mname.' '.$bookingRow->person_lname;?></li>
                <li><strong>Contact No. : </strong><?php echo set_na($bookingRow->person_phone);?></li>
                <li><strong>Email Address : </strong><?php echo set_na($bookingRow->person_email);?></li>
                <li><strong>Address : </strong><?php echo set_na($bookingRow->person_address);?></li>
                <li><strong>City : </strong><?php echo set_na($bookingRow->person_city);?></li>
                <li><strong>Postal / Zip Code : </strong><?php echo set_na($bookingRow->person_postal);?></li>
                <li><strong>Country Code : </strong><?php echo set_na($bookingRow->person_country_code);?></li>
                <li><strong>Country : </strong><?php echo set_na($bookingRow->person_country);?></li>
                <li><strong>Contact Type : </strong><?php echo set_na($bookingRow->person_ctype);?></li>
            </ul>
        </div>
        <div class="col-sm-6">
            <h3>Booking Information</h3>
            <ul>
                <li><strong>Order Id : </strong><?php echo set_na($bookingRow->accesskey);?></li>
                <li><strong>Trip Name : </strong><?php echo set_na(Package::field_by_id($bookingRow->pkg_id, 'title'));?></li>
                <li><strong>Trip Date : </strong><?php echo set_na($bookingRow->trip_date);?></li>
                <li><strong>Trip Rate : </strong><?php echo set_na($bookingRow->trip_currency.' '.$bookingRow->date_rate);?></li>
                <li><strong>No. of Pax. : </strong><?php echo set_na($bookingRow->trip_pax);?></li>
                <li><strong>Flight Require : </strong><?php echo set_na($bookingRow->trip_flight);?></li>
                <li><strong>Inquiry Date : </strong><?php echo set_na($bookingRow->added_date);?></li>
                <li><strong>Inquiry Ip : </strong><?php echo set_na($bookingRow->ip_address);?></li>
                <li><strong>Fixed Departure: </strong><?php echo ($bookingRow->fixed_date_id != 0)?'Yes':'No';?></li>
            </ul>
        </div>
        <div class="clear"></div>
        <div class="col-sm-12">
            <h3>Extra Information</h3>
            <ul>
                <!--<li><strong>How did you Hear About Us ?</strong><p><?php echo set_na($bookingRow->person_hear);?></p></li>-->
                <li><strong>Question/Comments</strong><p><?php echo set_na($bookingRow->person_comment);?></p></li>
            </ul>
        </div>
        
        <!--<div class="col-sm-12">
            <h3>Payment Information</h3>
            <ul>-->
            <?php if($bookingRow->status==1) { ?>
                <!--<li><strong>Payment Type : </strong>Online Payment (<?php echo $bookingRow->pay_type;?>)</li>
                <li><strong>Transaction Code : </strong><?php echo set_na($bookingRow->transaction_code);?></li>
                <li><strong>Paid Amount (US $) : </strong><?php echo set_na($bookingRow->pay_amt);?></li>
                <li><strong>Confirm Date : </strong><?php echo set_na($bookingRow->confirm_date);?></li>
                <li><strong>Confirm IP : </strong><?php echo set_na($bookingRow->confirm_ip);?></li>-->
            <?php } else { ?> 
                <!--<li><strong>Payment Date : </strong>Online <?php echo $bookingRow->pay_type;?></li>-->
            <?php } ?>
            <!--</ul>
        </div>-->

    </div>
</div>  
<?php endif; ?>