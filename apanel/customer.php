<?php
include('../includes/initialize.php');
$body='';
$folder='pdf';
$file_name='abc';
$unique_id=rand(0,100);
foreach($_POST as $key=>$val){$$key=$val;}
if(!empty($customerId)):
$custInfo = Customer::find_by_id($customerId);
$body.='<div class="sales-title">Customer Report</div>
<div class="supplier-info">
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th width="100">Customer</th>
			<td>'.$custInfo->name.'</td>
		</tr>
		<tr>
			<th>Address</th>
			<td>'.$custInfo->address.'</td>
		</tr>
		<tr>
			<th>Contact</th>
			<td>'.$custInfo->contact.'</td>
		</tr>
		<tr>
			<th>Email</th>
			<td>'.$custInfo->email.'</td>
		</tr>
	</table>
</div>
<div class="listing"> 
	<table cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
			   <th>Date</th>
			   <th>Sales ID</th>
			   <th>Paid</th>                     
			   <th>Balance</th>
			   <th>Total</th>
			</tr>
			<tr>
				<td colspan="5">--------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
					</tr>
		</thead>                 
		<tbody>';
			$sLsitbyCustomer = Sales::get_allSalesList_ByCustomerId($customerId);	
			foreach($sLsitbyCustomer as $SLreportRow):		
			$body.='<tr>
					   <td>'.$SLreportRow->sales_date.'</td>
					   <td>'.$SLreportRow->code.'</td>
					   <td>'.$SLreportRow->payment.'</td>                     
					   <td>'.$SLreportRow->balance.'</td>
					   <td>'.$SLreportRow->payable_amount.'</td>				   
					</tr>';
			endforeach;
			$totpayment = Sales::FinalcalculationbycustId("payment",$customerId);
			$totbalance = Sales::FinalcalculationbycustId("balance",$customerId);
			$totgrand = Sales::FinalcalculationbycustId("grand_total",$customerId);
			$body.='<tr>
						<td colspan="5">--------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>'.$totpayment.'</td>
						<td>'.$totbalance.'</td>
						<td>'.$totgrand.'</td>
			 	    </tr>';
$body.='</tbody>
	</table>        
</div>';
else:
	$body.='Record Not Found !';
endif;
Mypdf::convertPDF($body,$folder,$file_name,$unique_id);
?>