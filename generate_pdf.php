<?php

require "fpdf/fpdf.php";

class MYPDF extends FPDF {

    public function flightsTable($header, $xmlData){

        $this->SetFillColor(170,57,57);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');

        //calculate cell width so table would be centered and fit pdf document
        $width=($this->w - $this->lMargin * 2)/5;

        //header
        for($i=0;$i<count($header);$i++)
            $this->Cell($width,7,$header[$i],1,0,'C',true);
        $this->Ln();

        //data
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $cellHeight=8;
        $fill = false;
        foreach($xmlData->children() as $row)
        {
            $this->Cell($width,$cellHeight,$row->from,'LR',0,'L',$fill);
            $this->Cell($width,$cellHeight,$row->to,'LR',0,'L',$fill);
            $this->Cell($width,$cellHeight,$row->date,'LR',0,'L',$fill);
            $this->Cell($width,$cellHeight,$row->duration,'LR',0,'L',$fill);
            $this->Cell($width,$cellHeight,$row->cost,'LR',0,'L',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        //last line
        $this->Cell(5*$width,0,'','T');
    }
}
$pdf = new MYPDF();

$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$xml = simplexml_load_file("data/xml/flights.xml");
$pdf->SetAuthor("CredaAirlines");
$pdf->SetTitle("Flights report");

$pdf->SetFillColor(224,235,255);
$pdf->Cell(0, 10, "Zakazani letovi","D",1,"C",true);
$pdf->Ln();
$header=array("FROM", "TO", "DATE", "DURATION", "COST");
$pdf->flightsTable($header, $xml);

$pdf->Output();


