<?php
include '../../config/clsConnection.php';
include '../../objects/clsLocation.php';
include '../../objects/clsPersonnel.php';
include '../../objects/clsDepartment.php';
include '../../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$loc = new Location($db);
$person = new Personnel($db);
$dept = new Department($db);
$asset = new Asset($db);

//initailize the passed data
$name = "";
$department = "";
//check if assignee if empty/null
if($_GET['assignee'] != null || $_GET['assignee'] != '')
{
	//get the name of personnel/employee
	$assignee = $_GET['assignee'];
	$person->id = $assignee;
	$view = $person->get_person_name();
	while($person_row = $view->fetch(PDO::FETCH_ASSOC))
	{
		$name = $person_row['lastname'].', '.$person_row['firstname'];
		//get the department name
		$view_dept = $dept->get_dept_name();
		while($dept_row = $view_dept->fetch(PDO::FETCH_ASSOC))
		{
			$department = $dept_row['department'];
		}
	}
	
	//get the asset/items that associated with the personnel
	$tbl = "";
	$asset->assign = $assignee;
	$view_asset = $asset->get_asset_byPerson();
	while($asset_row = $view_asset->fetch(PDO::FETCH_ASSOC))
	{
		$barcode = $asset_row['code'];
		$description = $asset_row['description'];
		$quantity = $asset_row['quantity'];
		$location = $asset_row['loc_name'];
		if($asset_row['date_transfer'] == "0000-00-00 00:00:00" || $asset_row['date_transfer'] == "" || $asset_row['date_transfer'] == null)
		{
			$date_transfer = "-";
		}
		else
		{
			$date_transfer = date('m/d/y',strtotime($asset_row['date_transfer']));
		}
		
		$tbl .= '
			<tr>
				<td width="10%" align="center" style="border-right-style:2px;">'.$barcode.'</td>
				<td width="25%" style="border-right-style:2px;">'.$description.'</td>
				<td width="7%" align="center" style="border-right-style:2px;">'.$quantity.'</td>
				<td width="10%" style="border-right-style:2px;" align="center">'.$location.'</td>
				<td width="10%" style="border-right-style:2px;" align="center">'.$date_transfer.'</td>
				<td width="14%" style="border-right-style:2px;">_______________________</td>
				<td width="13%" style="border-right-style:2px;">_____________________</td>
				<td width="13%" style="border-right-style:2px;">_____________________</td>
			</tr>
		';
	}
	//check if table is empty or not
	if($tbl == null || $tbl == "")
	{
		$tbl .= '<tr>
					<td width="100%" align="center"><p style="color: red"><b><i>No Assets/Items found.</i></b></p></td>
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
<h3><i>ASSET MANAGEMENT SYSTEM RECORDS</i></h3>
<div>
	<label id="lblName" style="font-size: 11px">Name of Assignee: <b><i><u>$name</u></i></b></label><br>
</div>
<table width="100%" cellpadding="10" style="border-top-style:2px; border-left-style:2px; border-right-style:2px; border-bottom-style:2px; font-size: 10px">
	<tr>
		<td width="100%"><i>Below are Assets/Items that employee acquired.</i></td>		
	</tr>
	<thead>
		<tr>
			<td width="10%" align="center" style="border-top-style:2px; border-bottom-style:2px">T&E Code</td>
			<td width="25%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Description</td>
			<td width="7%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Quantity</td>
			<td width="10%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Location</td>
			<td width="10%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Date Transfer</td>
			<td width="14%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">New Assignee</td>
			<td width="13%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Signature</td>
			<td width="13%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Remarks</td>
		</tr>
	</thead>
	<tbody id="asset_by_person">
		$tbl
	</tbody>
</table>
<table width="100%">
	<tbody>
		<tr>
			<td width="100%"><br><br><br><br><br></td>
		</tr>
		<tr>
			<td width="25%"></td>
			<td width="50%"></td>
			<td width="23%">Verified by:</td>
			<td width="2%"></td>
		</tr>
		<tr>
			<td width="25%"><br><br><br></td>
			<td width="50%"></td>
			<td width="23%" style="border-bottom-style:2px"></td>
			<td width="2%"></td>
		</tr>
		<tr>
			<td width="25%"></td>
			<td width="50%"></td>
			<td width="23%" align="center">Blanca Amor Jaravelo-Palermo</td>
			<td width="2%"></td>
		</tr>
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
