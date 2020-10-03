<?php


namespace App\Core\FPdf;


class Pdf extends FPdf
{

    // Simple table
    function basicTable($header, $data)
    {
        // Header
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Data
        $total = 0;
        foreach($data as $row)
        {
            $total += $row->sellPrice;
            $this->Cell(40,6,$row->title,1);
            $this->Cell(40,6,$row->subtitle,1);
            $this->Cell(40,6,$row->author,1);
            $this->Cell(40,6,$row->conditions,1);
            $this->Cell(40,6,$row->sellPrice,1);
            $this->Ln();
        }
        $this->Cell(40,6,'Total',1);
        $this->Cell(40,6,'',1);
        $this->Cell(40,6,'',1);
        $this->Cell(40,6,'',1);
        $this->Cell(40,6,$total,1);
    }
}