<?php
include '../../config/clsConnection.php';
include '../../objects/clsToolKeeper.php';

$database = new clsConnection();
$db = $database->connect();

$records = new ToolKeeper($db);

$date_from = $_GET['from'];
$date_to = $_GET['to'];
$report_stat = '';

//print report by status only
if($_GET['action'] == 1)
{
	//get the record base in date and by project
	$tbl = "";
	$project = $_GET['project'];
	$status = $_GET['status'];
	$records->status = $status;
	$records->project = $project;
	$get = $records->get_borrow_records_bystat();
	while($row = $get->fetch(PDO::FETCH_ASSOC))
	{
		$proj_name = $row['project'];
		$date_borrow = date('m/d/y (g:i a)', strtotime($row['date_borrow']));
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
		$report_stat = $status;
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

//generate report by date span only
if($_GET['action'] == 2)
{
	//get the record base in date and by project
	$tbl = "";
	$from = date('Y-m-d', strtotime($date_from));
	$to = date('Y-m-d', strtotime($date_to));
	$project = $_GET['project'];

	$get = $records->get_borrow_records_bydate($from, $to, $project);
	while($row = $get->fetch(PDO::FETCH_ASSOC))
	{
		$proj_name = $row['project'];
		$date_borrow = date('m/d/y (g:i a)', strtotime($row['date_borrow']));
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
		$report_stat = $date_from.' - '.$date_to;
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

//generate report by date span and status
if($_GET['action'] == 3)
{
	//get the record base in date and by project
	$tbl = "";
	$from = date('Y-m-d', strtotime($date_from));
	$to = date('Y-m-d', strtotime($date_to));
	$project = $_GET['project'];
	$status = $_GET['status'];

	$get = $records->get_borrow_records_bydate_stat($from, $to, $project, $status);
	while($row = $get->fetch(PDO::FETCH_ASSOC))
	{
		$proj_name = $row['project'];
		$date_borrow = date('m/d/y (g:i a)', strtotime($row['date_borrow']));
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
		$report_stat = $date_from.' - '.$date_to;
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
<h2><i>AMS T&E BORROWING RECORDS ($report_stat)</i></h2>
<table width="100%" cellpadding="10" style="border-top-style:2px; border-left-style:2px; border-right-style:2px; border-bottom-style:2px; font-size: 10px">
	<thead>
		<tr>
			<th style="border-bottom-style:2px;" align="center">Tool Code</th>
			<th style="max-width: 200px; border-bottom-style:2px; border-left-style:2px;" align="center">Description</th>
			<th style="border-bottom-style:2px; border-left-style:2px;" align="center">Borrower's name</th>
			<th style="border-bottom-style:2px; border-left-style:2px;" align="center">Date Borrowed</th>
			<th style="border-bottom-style:2px; border-left-style:2px;" align="center">Returned By</th>
			<th style="border-bottom-style:2px; border-left-style:2px;" align="center">Date Returned</th>
			<th style="border-bottom-style:2px; border-left-style:2px;" align="center">Status</th>
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
