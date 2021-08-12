<?php
include '../../config/clsConnection.php';
include '../../objects/clsAsset.php';
include '../../objects/clsRepairHistory.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);
$repair = new RepairHistory($db);
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
$condition = $_GET['condition'];
$project_id = $_GET['project'];
$type = $_GET['type'];
//condition status
if($condition == 1){
    $status = 'For Repair';
}elseif($condition == 2){
    $status = 'Under Repair';
}else{
    $status = 'Repaired T&E';
}

//check if assignee if empty/null
if($condition == 1 && $type == 1)
{	
    //get the asset/items that associated with the project
    $tbl = "";
    $get = $asset->get_asset_for_repair();
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
        $code = $row['code'];
        $description = $row['description'];
        $project = $row['location'];
        $date1 = '-';
        $date2 = '-';
        $remarks = '-';
        
        $tbl .= '
            <tr>
                <td width="12%" align="center" style="border-right-style:2px;">'.$code.'</td>
                <td width="30%" style="border-right-style:2px;">'.$description.'</td>
                <td width="15%" align="center" style="border-right-style:2px">'.$project.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date1.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date2.'</td>
                <td width="17%" align="center" style="border-right-style:2px">'.$remarks.'</td>
                
            </tr>';
    }
    //check if table is empty or not
    if($tbl == null || $tbl == "")
    {
        $tbl .= '<tr>
                    <td width="100%" align="center"><p style="color: red"><b><i>No Tools & Equipment found - 2.</i></b></p></td>
                </tr>';
    }
}

if($condition == 1 && $type == 2)
{
    //get the asset/items that associated with the project
    $tbl = "";
    $asset->project = $project_id;
    $get = $asset->get_asset_for_repair_by_proj();
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
        $code = $row['code'];
        $description = $row['description'];
        $project = $row['location'];
        $date1 = '-';
        $date2 = '-';
        $remarks = '-';
        $tbl .= '
            <tr>
                <td width="12%" align="center" style="border-right-style:2px;">'.$code.'</td>
                <td width="30%" style="border-right-style:2px;">'.$description.'</td>
                <td width="15%" align="center" style="border-right-style:2px">'.$project.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date1.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date2.'</td>
                <td width="17%" align="center" style="border-right-style:2px">'.$remarks.'</td>
            </tr>';
    }
    //check if table is empty or not
    if($tbl == null || $tbl == "")
    {
        $tbl .= '<tr>
                    <td width="100%" align="center"><p style="color: red"><b><i>No Tools & Equipment found</i></b></p></td>
                </tr>';
    }
}

if($condition == 2 && $type == 1)
{
    //get the asset/items that associated with the project
    $tbl = "";
    $get = $asset->get_asset_under_repair();
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
        $code = $row['code'];
        $description = $row['description'];
        $project = 'All Projects';
        $date1 = date('m/d/Y', strtotime($row['date_repair']));
        $date2 = '-';
        $remarks = $row['repair_remark'];
        
        $tbl .= '
            <tr>
                <td width="12%" align="center" style="border-right-style:2px;">'.$code.'</td>
                <td width="30%" style="border-right-style:2px;">'.$description.'</td>
                <td width="15%" align="center" style="border-right-style:2px">'.$project.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date1.'</td>
                <td width="13%" align="center" style="border-right-style:2px">'.$date2.'</td>
                <td width="17%" align="center" style="border-right-style:2px">'.$remarks.'</td>
            </tr>';
    }
    //check if table is empty or not
    if($tbl == null || $tbl == "")
    {
        $tbl .= '<tr>
                    <td width="100%" align="center"><p style="color: red"><b><i>No Tools & Equipment found-1.</i></b></p></td>
                </tr>';
    } 
}

if($condition == 2 && $type == 2)
{
    //get the asset/items that associated with the project
    $tbl = "";
    $asset->project = $project_id;
    $get = $asset->get_asset_under_repair_by_proj();
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
        $code = $row['code'];
        $description = $row['description'];
        $project = $row['location'];
        $date1 = date('m/d/Y', strtotime($row['date_repair']));
        $date2 = '-';
        $remarks = $row['repair_remark'];
        
        $tbl .= '
            <tr>
                <td width="12%" align="center" style="border-right-style:2px;">'.$code.'</td>
                <td width="30%" style="border-right-style:2px;">'.$description.'</td>
                <td width="15%" align="center" style="border-right-style:2px">'.$project.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date1.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date2.'</td>
                <td width="17%" align="center" style="border-right-style:2px">'.$remarks.'</td>
            </tr>';
    }
    //check if table is empty or not
    if($tbl == null || $tbl == "")
    {
        $tbl .= '<tr>
                    <td width="100%" align="center"><p style="color: red"><b><i>No Tools & Equipment found-2.</i></b></p></td>
                </tr>';
    } 
}

if($condition == 3 && $type == 1)
{
    //get the T&E repaired
    $tbl = "";
    $get = $repair->view_repair_history();
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
        $code = $row['code'];
        $description = $row['description'];
        $brand = $row['brand'];
        $project = 'All Projects';
        $date1 = date('m/d/Y', strtotime($row['date_repair']));
        $date2 = date('m/d/Y', strtotime($row['date_returned']));
        $remarks = $row['remarks'];
        
        $tbl .= '
            <tr>
                <td width="12%" align="center" style="border-right-style:2px;">'.$code.'</td>
                <td width="30%" style="border-right-style:2px;">'.$description.'</td>
                <td width="15%" align="center" style="border-right-style:2px">'.$project.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date1.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date2.'</td>
                <td width="17%" align="center" style="border-right-style:2px">'.$remarks.'</td>
            </tr>';
    }
    //check if table is empty or not
    if($tbl == null || $tbl == "")
    {
        $tbl .= '<tr>
                    <td width="100%" align="center"><p style="color: red"><b><i>No Tools & Equipment found-2.</i></b></p></td>
                </tr>';
    }
}

if($condition == 3 && $type == 2)
{
    //get the asset/items that associated with the project
    $tbl = "";
    $repair->project = $project_id;
    $get = $repair->view_repair_history_by_proj();
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
        $code = $row['code'];
        $description = $row['description'];
        $project = $row['location'];
        $date1 = date('m/d/Y', strtotime($row['date_repair']));
        $date2 = date('m/d/Y', strtotime($row['date_returned']));
        $remarks = $row['remarks'];
        
        $tbl .= '
            <tr>
                <td width="12%" align="center" style="border-right-style:2px;">'.$code.'</td>
                <td width="30%" style="border-right-style:2px;">'.$description.'</td>
                <td width="15%" align="center" style="border-right-style:2px">'.$project.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date1.'</td>
                <td width="13%" align="center" style="border-right-style:2px;">'.$date2.'</td>
                <td width="17%" align="center" style="border-right-style:2px">'.$remarks.'</td>
            </tr>';
    }
    //check if table is empty or not
    if($tbl == null || $tbl == "")
    {
        $tbl .= '<tr>
                    <td width="100%" align="center"><p style="color: red"><b><i>No Tools & Equipment found.</i></b></p></td>
                </tr>';
    }
}

//Set the format to print/display
$html = <<<EOD
<html>
<head>
</head>
<body>
<h3><i>ASSET MANAGEMENT SYSTEM RECORDS</i></h3>
<div>
    <label>T&E Condition: <b><u>$status</u></b></label><br>
</div>
<table width="100%" cellpadding="10" style="border-top-style:2px; border-left-style:2px; border-right-style:2px; border-bottom-style:2px; font-size: 10px">
    <thead>
        <tr>
            <td width="12%" align="center" style="border-top-style:2px; border-bottom-style:2px"> T&E Code</td>
            <td width="30%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Description</td>
            <td width="15%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Project</td>
            <td width="13%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Date Repair</td>
            <td width="13%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Date Returned</td>
            <td width="17%" align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">Remarks</td>
            
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