<?php
class Pdf_file {
	
	public function convertPDF($body='',$folder,$file_name){
		require_once(SITE_ROOT.'assets/tcpdf/config/lang/eng.php');
		require_once(SITE_ROOT.'assets/tcpdf/tcpdf.php');
		
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Royal Astoria Hotel');
		$pdf->SetTitle('Royal Astoria Hotel Booking Form');
		$pdf->SetSubject('Royal Astoria Hotel Booking Form');
		
		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
		
		// set header and footer fonts
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		
		//set auto page breaks
		
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetMargins(10, 5, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);
		
		
		
		//set auto page breaks
		//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetAutoPageBreak(TRUE, 0);
		
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		//set some language-dependent strings
		$pdf->setLanguageArray($l);
		
		// ---------------------------------------------------------
		
		// set font
		$pdf->SetFont('dejavusans', '', 8);
		
		// add a page
		$pdf->AddPage();
		
		//$html='';
		// output the HTML content
		$pdf->writeHTML($body, true, false, true, false, '');
			
		//Close and output PDF document
		//$tmp = ini_get('upload_tmp_dir');
		//phpalert($tmp );
		//F for save only
		//I to browse
		$pdf->Output(SITE_ROOT.$folder.'/'.$file_name.'.pdf', 'F');
		//redirect_to('roomrates');
		//============================================================+
		// END OF FILE                                                
		//============================================================+
		return true;
	}
}
$Pdf_file = new Pdf_file();
?>