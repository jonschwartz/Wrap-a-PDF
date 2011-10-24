<?php

/*Generate Header/Footer on PDF
// v 1.1
//  built with fpdf library ( http://www.fpdf.org/ )
//  By Jon Schwartz
//		8/15/2011 */

$orig_pdf = $_REQUEST['orig'];

ini_set('display_errors', 1); 
error_reporting(E_ALL);

require('./fpdf.php');
require('./fpdi/fpdi.php');

class PDF extends FPDI
{
	//Page header
	function Header()
	{
		//Logo
		$this->Image('logo.gif',10,10,70);
		//Arial bold 15
		$this->SetFont('Arial','',12);
	}

	//Page footer
	function Footer()
	{
		$this->SetY(-35);
		$this->SetTextColor(50);
		$this->SetFont('Arial','',8);
		
		$this->Cell(0,10,'Documentation Provided By Fakey McFakerson',0,1,'C');
		$this->Cell(0,8,'123 Fake St Anytown USA 01010',0,1,'C');
		$this->Cell(0,8,'http://www.google.com',0,1,'C',false,'http://www.google.com');
		$this->Cell(0,8,'(800) 867-5309',0,1,'C');
	}
}

//Instanciation of inherited class
$pdf = new PDF();
$pdf->AddPage();
$pdf->Header();
$pdf->SetTextColor(50);
$pdf->SetFont('Arial','',8);

$page_count = $pdf->setSourceFile($orig_pdf); 

$tplidx = $pdf->ImportPage(1); 
$size = $pdf->useTemplate($tplidx, '10', '30', '178', '230', true);

if ($page_count > 1)
{
	for ($n = 2; $n <= $page_count; $n++) 
	{ 
		$pdf->AddPage();	
		$tplidx = $pdf->ImportPage($n); 
		$size = $pdf->useTemplate($tplidx, '10', '30', '178', '230', true);
	}	
}
$pdf->Output();
?>