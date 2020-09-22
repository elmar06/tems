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
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include_report.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('AMS Report Generation');
$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);
//$pdf->setFooterData(array(0,64,0), array(0,64,128));
//remove the header and footer data
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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

//initailize the passed data
$name = "";
$proj_id = $_GET['project'];
//check if assignee if empty/null
if($proj_id != null || $proj_id != '')
{
	//get the department name
	$loc->id = $proj_id;
	$view_proj = $loc->get_location_name();
	while($loc_row = $view_proj->fetch(PDO::FETCH_ASSOC))
	{
		$project = $loc_row['location'];
	}
	
	//get the asset/items that associated with the project
	$tbl = "";
	$asset->project = $proj_id;
	$view_asset = $asset->get_asset_byProj();
	while($asset_row = $view_asset->fetch(PDO::FETCH_ASSOC))
	{
		$code = $asset_row['code'];
		$description = $asset_row['description'];
		$quantity = $asset_row['quantity'];
		$location = $asset_row['project'];
		$fullname = $asset_row['fullname'];

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
				<td width="15%" align="center" style="border-right-style:2px;">'.$code.'</td>
				<td width="35%" style="border-right-style:2px;">'.$description.'</td>
				<td width="10%" align="center" style="border-right-style:2px;">'.$quantity.'</td>
				<td width="25%" align="center" style="border-right-style:2px">'.$fullname.'</td>
				<td width="15%" align="center">'.$date_transfer.'</td>
			</tr>';
	}
	//check if table is empty or not
	if($tbl == null || $tbl == "")
	{
		$tbl .= '<tr>
					<td width="100%" align="center"><p style="color: red"><b><i>No Assets/Items found.</i></b></p></td>
				</tr>';
	}
}

// Set some content to print
$html = <<<EOD
<html>
<head>
</head>
<body>
<h3><i>ASSET MANAGEMENT SYSTEM RECORDS</i></h3>
<div>
	<label style="">Department: <b><i><u>$project</u></i></b></label><br>
</div>
<table width="100%" cellpadding="10" style="border-top-style:2px; border-left-style:2px; border-right-style:2px; border-bottom-style:2px; font-size: 10px">
	<tr>
		<td width="100%"><i>Below are Assets/Items that employee acquired.</i></td>		
	</tr>
	<thead>
		<tr>
			<td width="15%" align="center" style="border-top-style:2px; border-bottom-style:2px"> T&E Code</td>
			<td width="35%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Description</td>
			<td width="10%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Quantity</td>
			<td width="25%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Assignee</td>
			<td width="15%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Date Transfer</td>
		</tr>
	</thead>
	<tbody id="asset_by_person">
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
