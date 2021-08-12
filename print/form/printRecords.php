<?php
include '../../config/clsConnection.php';
include '../../objects/clsRecord.php';

$database = new clsConnection();
$db = $database->connect();

$records = new Records($db);

//initailize the passed data
$name = "";
$department = "";
//check if date if empty/null
if($_GET['from'] != null && $_GET['to'] != '' && $_GET['project'])
{
	//get the record base in date and by project
	$tbl = "";
	$from = date('Y-m-d', strtotime($_GET['from']));
	$to = date('Y-m-d', strtotime($_GET['to']));
	$project = $_GET['project'];
	$add_by = $_GET['add_by'];
	$from_date = date('F j, Y', strtotime($_GET['from']));
	$to_date = date('F j, Y', strtotime($_GET['to']));
	$date_print = date('F j, Y');
	$get = $records->get_records_report($from, $to, $project, $add_by);
	while($row = $get->fetch(PDO::FETCH_ASSOC))
	{
		$proj_name = $row['project'];
		$date_borrow = date('m/d/y (g:i a)', strtotime($row['date_borrow']));
		$toolkeeper = $row['fullname'];
		if($row['status'] == 1){
			$status = 'Returned';
		}else{
			$status = 'Borrowed';
		}
		//format date return
		if($row['date_return'] != ''){
			$date_return = date('m/d/y (g:i a)', strtotime($row['date_return']));
		}else{
			$date_return = ' - ';
		}
		$tbl .= '
			<tr>
				<td align="center" style="border-right-style:2px;">'.$row['tool_code'].'</td>
				<td style="border-right-style:2px;">'.$row['tool_desc'].'</td>
				<td style="border-right-style:2px;" align="center">'.$row['borrow_name'].'</td>
				<td align="center" style="border-right-style:2px;">'.$date_borrow.'</td>
				<td style="border-right-style:2px;" align="center">'.$row['returned_by'].'</td>
				<td style="border-right-style:2px;" align="center">'.$date_return.'</td>				
				<td style="border-right-style:2px;" align="center">'.$status.'</td>
			</tr>';
	}

	//check if table is empty or not
	if($tbl == null || $tbl == "")
	{
		$tbl .= '<tr>
					<td width="100%" align="center"><p style="color: red"><b><i>No Details found.</i></b></p></td>
				</tr>';
	}
}

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include_assign.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('AMS Report Generation');
$pdf->SetSubject('TCPDF Tutorial');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

//remove the header and footer data
$pdf->setPrintHeader(false);
//$pdf->setPrintFooter(false);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 8, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));


// Set some content to print
$html = <<<EOD
<html>
<head>
</head>
<body>
<h2><i>T&E MANAGEMENT SYSTEM RECORDS</i></h2>
<table width="100%">
	<tbody>
		<tr>
			<td style="font-size: 11px" width="15%">PROJECT NAME:</td>
			<td style="font-size: 11px" width="59%">$proj_name</td>
			<td style="font-size: 11px" width="10%">DATE SPAN:</td>
			<td style="font-size: 11px" width="20%">$from_date - $to_date</td>
		</tr>
		<tr>
			<td style="font-size: 11px" width="15%">INCHARGE PERSON:</td>
			<td style="font-size: 11px" width="59%">$toolkeeper</td>
			<td style="font-size: 11px" width="10%">DATE PRINTED:</td>
			<td style="font-size: 11px" width="20%">$date_print</td>
		</tr>
	</tbody>
</table>
<div></div>	
<table width="100%" cellpadding="10" style="border-top-style:2px; border-left-style:2px; border-right-style:2px; border-bottom-style:2px; font-size: 10px">
	<thead>
		<tr>
			<td align="center" style="border-top-style:2px; border-bottom-style:2px">T&E Code</td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Description</td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Borrower's Name</td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Date Borrow</td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Returned By</td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Date Returned</td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Status</td>
		</tr>
	</thead>
	<tbody>
		$tbl
	</tbody>
</table>
</body>
</html>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('printReport.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
