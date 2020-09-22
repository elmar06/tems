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
require_once('tcpdf_include_ams.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Fixed Asset Transfer Form');
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

//initialize data from home page
$date_transfer = $_GET['date_transfer'];
$oldLocation = $_GET['oldLocation'];
$oldDept = $_GET['oldDept'];
$oldAssignee = $_GET['oldAssignee'];
$quantity = $_GET['quantity'];

//get the new assignee name 
$person->id = $_GET['new_assignee'];
$get_name = $person->get_person_name();
while($row = $get_name->fetch(PDO::FETCH_ASSOC))
{
	$fullname = $row['firstname'].' '.$row['lastname'];
	$newAssignee = $fullname;
} 

//get the new location of item
$loc->id = $_GET['new_location'];
$get_loc = $loc->get_location_name();
while($row = $get_loc->fetch(PDO::FETCH_ASSOC))
{
	$new_location = $row['location'];
}

//get the new department
$dept->id = $_GET['department'];
$get_dept = $dept->get_dept_name();
while($row = $get_dept->fetch(PDO::FETCH_ASSOC))
{
	$new_dept = $row['department'];
}

$data = $_GET['id'];//get the array from URL
$array = explode(',', $data);//initialize array
$itemTransfer = '';
//count the array
$j = count($array);

if($j == 1)
{
	$asset->id = $array[0];
	$get = $asset->get_asset_byID();
	while($row = $get->fetch(PDO::FETCH_ASSOC))
	{
		$type1 = $row['cat_name'];
		$desc1 = $row['description'];
		$code = $row['code'];
		$quantity1 = $row['quantity'];
	}
	$itemTransfer .=
		'<tr>
			<td width="5%" align="center">1</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type1.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc1.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity1.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center"><br>2</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">3</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">4</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">5</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>';
}
elseif($j == 2)
{
	$asset->id = $array[0];
	$get = $asset->get_asset_byID();
	while($row = $get->fetch(PDO::FETCH_ASSOC))
	{
		$type1 = $row['asset_type'];
		$desc1 = $row['description'];
		$code1 = $row['code'];
		$quantity1 = $row['quantity'];
	}

	$asset->id = $array[1];
	$get2 = $asset->get_asset_byID();
	while($row = $get2->fetch(PDO::FETCH_ASSOC))
	{
		$type2 = $row['asset_type'];
		$desc2 = $row['description'];
		$code2 = $row['code'];
		$quantity2 = $row['quantity'];
	}
	$itemTransfer .=
		'<tr>
			<td width="5%" align="center">1</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type1.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc1.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code1.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity1.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">2</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type2.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc2.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code2.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity2.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">3</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">4</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">5</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>';
}
elseif($j == 3)
{
	$asset->id = $array[0];
	$get = $asset->get_asset_byID();
	while($row = $get->fetch(PDO::FETCH_ASSOC))
	{
		$type1 = $row['asset_type'];
		$desc1 = $row['description'];
		$code1 = $row['code'];
		$quantity1 = $row['quantity'];
	}
	$asset->id = $array[1];
	$get2 = $asset->get_asset_byID();
	while($row = $get2->fetch(PDO::FETCH_ASSOC))
	{
		$type2 = $row['asset_type'];
		$desc2 = $row['description'];
		$code2 = $row['code'];
		$quantity2 = $row['quantity'];
	}
	$asset->id = $array[2];
	$get3 = $asset->get_asset_byID();
	while($row = $get3->fetch(PDO::FETCH_ASSOC))
	{
		$type3 = $row['asset_type'];
		$desc3 = $row['description'];
		$code3 =  $row['code'];
		$quantity3 = $row['quantity'];
	}
	$itemTransfer .=
		'<tr>
			<td width="5%" align="center">1</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type1.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc1.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code1.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity1.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">2</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type2.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc2.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code2.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity2.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">3</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type3.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc3.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code3.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity3.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">4</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">5</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>';
}
elseif($j == 4)
{
	$asset->id = $array[0];
	$get = $asset->get_asset_byID();
	while($row = $get->fetch(PDO::FETCH_ASSOC))
	{
		$type1 = $row['asset_type'];
		$desc1 = $row['description'];
		$code1 = $row['code'];
		$quantity1 = $row['quantity'];
	}
	$asset->id = $array[1];
	$get2 = $asset->get_asset_byID();
	while($row = $get2->fetch(PDO::FETCH_ASSOC))
	{
		$type2 = $row['asset_type'];
		$desc2 = $row['description'];
		$code2 =  $row['code'];
		$quantity2 = $row['quantity'];
	}
	$asset->id = $array[2];
	$get3 = $asset->get_asset_byID();
	while($row = $get3->fetch(PDO::FETCH_ASSOC))
	{
		$type3 = $row['asset_type'];
		$desc3 = $row['description'];
		$code3 =  $row['code'];
		$quantity3 = $row['quantity'];
	}
	$asset->id = $array[3];
	$get4 = $asset->get_asset_byID();
	while($row = $get4->fetch(PDO::FETCH_ASSOC))
	{
		$type4 = $row['asset_type'];
		$desc4 = $row['description'];
		$code4 =  $row['code'];
		$quantity4 = $row['quantity'];
	}
	$itemTransfer .=
		'<tr>
			<td width="5%" align="center">1</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type1.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc1.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code1.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity1.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">2</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type2.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc2.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code2.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity2.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">3</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type3.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc3.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code3.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity3.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">4</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type4.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc4.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code4.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity4.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">5</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>';
}
elseif($j == 5)
{
	$asset->id = $array[0];
	$get = $asset->get_asset_byID();
	while($row = $get->fetch(PDO::FETCH_ASSOC))
	{
		$type1 = $row['asset_type'];
		$desc1 = $row['description'];
		$code1 =  $row['code'];
		$quantity1 = $row['quantity'];
	}
	$asset->id = $array[1];
	$get2 = $asset->get_asset_byID();
	while($row = $get2->fetch(PDO::FETCH_ASSOC))
	{
		$type2 = $row['asset_type'];
		$desc2 = $row['description'];
		$code2 =  $row['code'];
		$quantity2 = $row['quantity'];
	}
	$asset->id = $array[2];
	$get3 = $asset->get_asset_byID();
	while($row = $get3->fetch(PDO::FETCH_ASSOC))
	{
		$type3 = $row['asset_type'];
		$desc3 = $row['description'];
		$code3 =  $row['code'];
		$quantity3 = $row['quantity'];
	}
	$asset->id = $array[3];
	$get4 = $asset->get_asset_byID();
	while($row = $get4->fetch(PDO::FETCH_ASSOC))
	{
		$type4 = $row['asset_type'];
		$desc4 = $row['description'];
		$code4 =  $row['code'];
		$quantity4 = $row['quantity'];
	}
	$asset->id = $array[4];
	$get5 = $asset->get_asset_byID();
	while($row = $get5->fetch(PDO::FETCH_ASSOC))
	{
		$type5 = $row['asset_type'];
		$desc5 = $row['description'];
		$code5 = $row['code'];
		$quantity5 = $row['quantity'];
	}
	$itemTransfer .=
		'<tr>
			<td width="5%" align="center">1</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type1.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc1.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code1.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity1.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">2</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type2.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc2.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code2.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity2.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">3</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type3.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc3.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code3.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity3.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">4</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type4.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc4.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code4.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity4.'</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">5</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center">'.$type5.'</td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br>'.$desc5.'</td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center">'.$code5.'</td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center">'.$quantity5.'</td>
		</tr>';
}
else
{
	$itemTransfer .=
		'<tr>
			<td width="5%" align="center">1</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center"><br>2</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">3</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">4</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td width="5%" align="center">5</td>
			<td width="2%"></td>
			<td width="20%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="48%" style="border-bottom-style: 1px;" align="center"><br></td>
			<td width="2%"></td>
			<td width="10%" style="border-bottom-style: 1px;" align="center"></td>
			<td width="2%"></td>
			<td width="8%" style="border-bottom-style: 1px;" align="center"></td>
		</tr>';
}

// Set some content to print
$html = <<<EOD
<html>
<head>
</head>
<body>
<table width="100%">
	<tr>
		<td width="600"><h3>ACCOUNTABILITY TRANSFER AND RECEIVING FORM</h3></td>
		<td width="70" align="right"><p style="font-size:7px">ARTF-3</p></td>
	</tr>
	<tr><td width="670" align="right"><p style="font-size:7px">070114-v3</p></td></tr>
	<tr><td width="670"><p style="font-size:8px">Please fill out the fields below to document change of location/accountable person of fixed asset or accountable items.</p></td></tr>
	<tr>
		<td></td>
	</tr>
	<tr>
		<td width="80"><i>RELEASING:</i></td>
		<td width="200"></td>
		<td width="50"></td>
		<td width="100"><i>RECEIVING:</i></td>
		<td width="200"></td>
	</tr>
	<tr>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$oldDept</td>
		<td width="50"></td>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$new_dept</td>
	</tr>
	<tr>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>Releasing Department<br></i></td>
		<td width="50"></td>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>Receiving Department<br></i></td>
	</tr>
	<tr>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$oldLocation</td>
		<td width="50"></td>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$new_location</td>
	</tr>
	<tr>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>Current Location</i></td>
		<td width="50"></td>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>New Location</i></td>
	</tr>
	<tr>
		<td width="100%"></td>
	</tr>
	<tr>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$oldAssignee</td>
		<td width="50"></td>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$newAssignee</td>
	</tr>
	<tr>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><b><i>Name of Current Assignee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIGNATURE<br></i></b></td>
		<td width="50"></td>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><b><i>Name of New Assignee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIGNATURE<br></i></b></td>
	</tr>
	<tr>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$date_transfer</td>
		<td width="50"></td>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;"></td>
	</tr>
	<tr>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>Date Released<br></i></td>
		<td width="50"></td>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>Date Received<br></i></td>
	</tr>
	<tr>
		<td width="100%" align="center"><br>FIXED ASSET/ACCOUNTABILITY INFORMATION</td>
	</tr>
	<tr>
		<td width="5%" align="center">No</td>
		<td width="2%"></td>
		<td width="20%" align="center">Item to Transfer</td>
		<td width="2%"></td>
		<td width="48%" align="center">Description<br></td>
		<td width="2%"></td>
		<td width="10%" align="center">T&E Code</td>
		<td width="2%"></td>
		<td width="8%" align="center">Quantity</td>
	</tr>
	$itemTransfer
	<tr><td></td></tr>
	<tr>	
		<td width="43%" style="border-left-style:1px; border-right-style:1px; border-top-style:1px;"> Condition:</td>
		<td width="34%" style="border-right-style:1px; border-top-style:1px;"> Reason: Please check all that applies</td>
		<td width="23%" style="border-right-style:1px; border-top-style:1px;"> Noted By:</td>
	</tr>
	<tr>	
		<td width="13%" style="border-left-style:1px;"><p style="font-size:8px"> &#9634; Newly Purchased</p></td>
		<td width="9%"><p style="font-size:8px"> &#9634; Used - Fair</p></td>
		<td width="21%" style="border-right-style:1px;"><p style="font-size:8px"> &#9634; Repairs Required (Minor)</p></td>
		<td width="17%"><p style="font-size:8px"> &#9634; Transfer to Inventory</p></td>
		<td width="17%" style="border-right-style:1px;"><p style="font-size:8px"> &#9634; Temporary only</p></td>
		<td width="23%" style="border-right-style:1px;"></td>
	</tr>
	<tr>	
		<td width="13%" style="border-left-style:1px; border-bottom-style:1px;"><p style="font-size:8px"> &#9634; Used - Good</p></td>
		<td width="9%" style="border-bottom-style:1px;"><p style="font-size:8px;"> &#9634; Used - Poor</p></td>
		<td width="21%" style="border-right-style:1px; border-bottom-style:1px;"><p style="font-size:8px"> &#9634; Repairs Required (Moderate)</p></td>
		<td width="17%" style="border-bottom-style:1px;"><p style="font-size:8px;"> &#9634; Transfer from Inventory</p></td>
		<td width="17%" style="border-right-style:1px; border-bottom-style:1px;"><p style="font-size:8px"> &#9634; Temporary of Assignee</p></td>
		<td width="23%" style="border-right-style:1px; border-bottom-style:1px;"><p style="font-size:8px" align="center">Support Services/Immediate Superior</p></td>
	</tr>
	<tr>
		<td width="100%"><p style="font-size: 7px;" align="justify"><br>By signing this form, the <b>NEW ASSIGNEE</b> shall be responsible for the item(s) issued and be used in the manner intended. In the event of separation from the company, change of assignment and/or replacement, the ff. item(s) must be turned over in proper working order. <i>*DISTRIBUTION: (1) Releasing (2) Support Services</i></p></td>
	</tr>
	<tr>
		<td><br><hr></td>
	</tr>
	<tr>
		<td width="600"><h3>ACCOUNTABILITY TRANSFER AND RECEIVING FORM</h3></td>
		<td width="70" align="right"><p style="font-size:7px">ARTF-3</p></td>
	</tr>
	<tr><td width="670" align="right"><p style="font-size:7px">070114-v3</p></td></tr>
	<tr><td width="670"><p style="font-size:8px">Please fill out the fields below to document change of location/accountable person of fixed asset or accountable items.</p></td></tr>
	<tr>
		<td></td>
	</tr>
	<tr>
		<td width="80"><i>RELEASING:</i></td>
		<td width="200"></td>
		<td width="50"></td>
		<td width="100"><i>RECEIVING:</i></td>
		<td width="200"></td>
	</tr>
	<tr>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$oldDept</td>
		<td width="50"></td>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$new_dept</td>
	</tr>
	<tr>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>Releasing Department<br></i></td>
		<td width="50"></td>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>Receiving Department<br></i></td>
	</tr>
	<tr>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$oldLocation</td>
		<td width="50"></td>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$new_location</td>
	</tr>
	<tr>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>Current Location</i></td>
		<td width="50"></td>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>New Location</i></td>
	</tr>
	<tr>
		<td width="100%"></td>
	</tr>
	<tr>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$oldAssignee</td>
		<td width="50"></td>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$newAssignee</td>
	</tr>
	<tr>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><b><i>Name of Current Assignee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIGNATURE<br></i></b></td>
		<td width="50"></td>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><b><i>Name of New Assignee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIGNATURE<br></i></b></td>
	</tr>
	<tr>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;">$date_transfer</td>
		<td width="50"></td>
		<td width="80" align="right">&#x2714;</td>
		<td width="200" style="border-bottom-style: 1px;"></td>
	</tr>
	<tr>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>Date Released<br></i></td>
		<td width="50"></td>
		<td width="80" align="right"></td>
		<td width="200" style="font-size:7px;"><i>Date Received<br></i></td>
	</tr>
	<tr>
		<td width="100%" align="center"><br>FIXED ASSET/ACCOUNTABILITY INFORMATION</td>
	</tr>
	<tr>
		<td width="5%" align="center">No</td>
		<td width="2%"></td>
		<td width="20%" align="center">Item to Transfer</td>
		<td width="2%"></td>
		<td width="48%" align="center">Description<br></td>
		<td width="2%"></td>
		<td width="10%" align="center">T&E Code</td>
		<td width="2%"></td>
		<td width="8%" align="center">Quantity</td>
	</tr>
	$itemTransfer
	<tr><td></td></tr>
	<tr>	
		<td width="43%" style="border-left-style:1px; border-right-style:1px; border-top-style:1px;"> Condition:</td>
		<td width="34%" style="border-right-style:1px; border-top-style:1px;"> Reason: Please check all that applies</td>
		<td width="23%" style="border-right-style:1px; border-top-style:1px;"> Noted By:</td>
	</tr>
	<tr>	
		<td width="13%" style="border-left-style:1px;"><p style="font-size:8px"> &#9634; Newly Purchased</p></td>
		<td width="9%"><p style="font-size:8px"> &#9634; Used - Fair</p></td>
		<td width="21%" style="border-right-style:1px;"><p style="font-size:8px"> &#9634; Repairs Required (Minor)</p></td>
		<td width="17%"><p style="font-size:8px"> &#9634; Transfer to Inventory</p></td>
		<td width="17%" style="border-right-style:1px;"><p style="font-size:8px"> &#9634; Temporary only</p></td>
		<td width="23%" style="border-right-style:1px;"></td>
	</tr>
	<tr>	
		<td width="13%" style="border-left-style:1px; border-bottom-style:1px;"><p style="font-size:8px"> &#9634; Used - Good</p></td>
		<td width="9%" style="border-bottom-style:1px;"><p style="font-size:8px;"> &#9634; Used - Poor</p></td>
		<td width="21%" style="border-right-style:1px; border-bottom-style:1px;"><p style="font-size:8px"> &#9634; Repairs Required (Moderate)</p></td>
		<td width="17%" style="border-bottom-style:1px;"><p style="font-size:8px;"> &#9634; Transfer from Inventory</p></td>
		<td width="17%" style="border-right-style:1px; border-bottom-style:1px;"><p style="font-size:8px"> &#9634; Temporary of Assignee</p></td>
		<td width="23%" style="border-right-style:1px; border-bottom-style:1px;"><p style="font-size:8px" align="center">Support Services/Immediate Superior</p></td>
	</tr>
	<tr>
		<td width="100%"><p style="font-size: 7px;" align="justify"><br>By signing this form, the <b>NEW ASSIGNEE</b> shall be responsible for the item(s) issued and be used in the manner intended. In the event of separation from the company, change of assignment and/or replacement, the ff. item(s) must be turned over in proper working order. <i>*DISTRIBUTION: (1) Releasing (2) Support Services</i></p></td>
	</tr>
	<tr>
		<td><br><hr></td>
	</tr>
	
</table>	
</body>
</html>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('printARTF3.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
