<?php
//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 011 for TCPDF class
//               Colored Table (very simple table)
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
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('../TCPDF-main/tcpdf.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {

    // Load table data from file
    public function LoadData() {

        // Read file lines       
        include("../config.php");
        session_start();
        if(isset($_GET['page'])) {
        $Student = $_GET['page'];
        $sql = mysqli_query($conn, "SELECT * FROM users JOIN section ON users.year_section=section.section_Id WHERE user_type = 'Student' AND student_status=0 ");
        // $query ="SELECT faculty.*, level_section.level, level_section.section FROM faculty INNER JOIN level_section ON faculty.level_section_id=level_section.lev_sec_Id WHERE level LIKE '%".$level_filter."%' ORDER BY faculty.lastname ASC";
        // $result = mysqli_query($conn,$query);
        return $sql;
       }
    }

        // Colored table
        public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header

        //column width
        $w = array(20, 40, 40, 40, 40, 40, 40, 40, 40);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {

            $this->Cell($w[0], 6, ' '.$row["student_ID"].' ', 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, ' '.$row["firstname"].' '.$row["middlename"].' '.$row["lastname"].' '.$row["suffix"].' ', 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, ' '.$row["firstname"].' ', 'LR', 0, 'L', $fill);
            // $this->Cell($w[1], 6, ' '.$row["age"].' '.$row["age"].' ', 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MNHS');
$pdf->SetTitle('Faculty Report');
$pdf->SetSubject('Report');
$pdf->SetKeywords('MNHS Report');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// column titles
$header = array('ID', 'Name', 'Section');
// $header = array('ID', 'Name', 'Section', 'Department', 'Birthday', 'Age', 'Sex', 'Email', 'Type');


// data loading
$data = $pdf->LoadData();

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------
// close and output PDF document
$pdf->Output('MNHSEnrollment', 'I');

//============================================================+
// END OF FILE
//============================================================+
