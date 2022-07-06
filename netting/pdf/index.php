<?php
require_once 'fpdf/fpdf.php';

function turkce($k)
{
    return iconv('utf-8', 'iso-8859-9', $k);
}


class PDF extends FPDF {



    function Header()
    {
        $this->SetFont('times', '', 12);
        $this->Image("logo.png",5,5,50);
        $this->Ln(15);

    }

    function Footer()
    {
        $this->SetY(-15); # aşağıdan yukarısı için 1.5 santim bırak

        $this->SetFont('arial_tr','',8);
        $this->Cell(0,10,$this->PageNo(),0,0,'C');
        $this->Ln();
    }

    function headerTable() {
        $this->SetFont("Times", "B",12);
        $this->Cell(20,10,"Id",1,0,'C');
        $this->Cell(20,10,"Name",1,0,'C');
        $this->Cell(20,10,"Position",1,0,'C');
        $this->Cell(20,10,"Office",1,0,'C');
        $this->Cell(20,10,"Age",1,0,'C');
        $this->Cell(20,10,"Start",1,0,'C');
        $this->Cell(20,10,"Salary",1,0,'C');
        $this->Cell(20,10,"Salary",1,0,'C');
        $this->Cell(20,10,"Salary",1,0,'C');
        $this->Cell(10,10,"Age",1,0,'C');
        $this->Ln();
    }

    function viewTable() {
        $this->SetFont("Times", "",12);

        for ($i =0; $i< 100; $i++) {
            $this->SetFillColor(224,235,255);

            $this->SetTextColor(0);
            $this->SetFont('');
            // Data
            $this->SetTextColor(0);
            $this->SetDrawColor(128,0,0);
            $this->SetLineWidth(.3);

            $this->Cell(20,10,"Id",1,0,'C', true);
            $this->Cell(20,10,"Name",1,0,'C', true);
            $this->Cell(20,10,"Position",1,0,'C', true);
            $this->Cell(20,10,"Office",1,0,'C',true);
            $this->Cell(20,10,"Age",1,0,'C', true);
            $this->Cell(20,10,"Start",1,0,'C', true);
            $this->Cell(20,10,"Salary",1,0,'C', true);
            $this->Cell(20,10,"Salary",1,0,'C', true);
            $this->Cell(20,10,"Salary",1,0,'C', true);
            $this->Cell(10,10,"Age",1,0,'C', true);
            $this->Ln();
        }

    }

}

$tarih = "04.07.2022";
$tableTitle = "Tablo İsmi";
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("P","A4",0);


$pdf->AddFont('arial_tr', '', 'arial_tr.php');
$pdf->AddFont('arial_tr', 'B', 'arial_tr_bold.php');
$pdf->SetFont('arial_tr', 'B', 10);
$pdf->Cell(190,"10","Tarih: " . $tarih,0,0,"R");
$pdf->Ln(6);
$pdf->Cell(0,10,turkce($tableTitle),0,0,'C');
$pdf->Ln(12);

$pdf->headerTable();
$pdf->viewTable();

$pdf->Output();

?>