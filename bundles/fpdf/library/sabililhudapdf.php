<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of myfpdf
 *
 * @author Klik
 */
class Sabililhudapdf extends Fpdf{
    
    private $reportTitle;
    private $reportSubTitle;
    private $namaSekolah;
    private $alamat;
    private $isNewPage = false;
    
    public function getIsNewPage(){
        return $this->isNewPage;
    }
        
    public function setReportTitle($reportTitle){
        $this->reportTitle = $reportTitle;
    }
    public function setReportSubTitle($reportSubTitle){
        $this->reportSubTitle = $reportSubTitle;
    }
    public function setNamaSekolah($namaSekolah){
        $this->namaSekolah = $namaSekolah;
    }
    public function setAlamat($alamat){
        $this->alamat = $alamat;
    }
    
    function Header() {
        parent::Header();
        
        //create page header
        $this->SetFont('Courier','B',14);
        $this->Cell(0,5,$this->reportTitle,0,1,'C');
        if($this->reportSubTitle != ''){
            $this->SetFont('Courier','B',12);
            $this->Cell(0,5,$this->reportSubTitle,0,1,'C');
        }
        $this->SetFont('Courier','',12);
        $this->Cell(0,5,$this->namaSekolah,0,1,'C');
        $this->SetFont('Courier','',10);
        $this->Cell(0,5,$this->alamat,0,1,'C');
        $this->Cell(0,2,'','B',1);
        $this->Cell(0,0.1,'','B',1);
        $this->Cell(0,0.1,'','B',1);
        $this->Cell(0,1,'','B',1);
        $this->ln(5);
        
    }
    
    public function Footer() {
        parent::Footer();
        
        // Position at 1.5 cm from bottom
        $this->SetY(-10);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    }
    
    public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '') {
        //parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
        
        
	// Output a cell
	$k = $this->k;
	if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
	{
		// Automatic page break
		$x = $this->x;
		$ws = $this->ws;
		if($ws>0)
		{
			$this->ws = 0;
			$this->_out('0 Tw');
		}
		$this->AddPage($this->CurOrientation,$this->CurPageSize);
		$this->x = $x;
		if($ws>0)
		{
			$this->ws = $ws;
			$this->_out(sprintf('%.3F Tw',$ws*$k));
		}
	}
	if($w==0)
		$w = $this->w-$this->rMargin-$this->x;
	$s = '';
	if($fill || $border==1)
	{
		if($fill)
			$op = ($border==1) ? 'B' : 'f';
		else
			$op = 'S';
		$s = sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
	}
	if(is_string($border))
	{
		$x = $this->x;
		$y = $this->y;
		if(strpos($border,'L')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
		if(strpos($border,'T')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
		if(strpos($border,'R')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
		if(strpos($border,'B')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
	}
	if($txt!=='')
	{
		if($align=='R')
			$dx = $w-$this->cMargin-$this->GetStringWidth($txt);
		elseif($align=='C')
			$dx = ($w-$this->GetStringWidth($txt))/2;
		else
			$dx = $this->cMargin;
		if($this->ColorFlag)
			$s .= 'q '.$this->TextColor.' ';
		$txt2 = str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
		$s .= sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$txt2);
		if($this->underline)
			$s .= ' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
		if($this->ColorFlag)
			$s .= ' Q';
		if($link)
			$this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$this->GetStringWidth($txt),$this->FontSize,$link);
	}
	if($s)
		$this->_out($s);
	$this->lasth = $h;
	if($ln>0)
	{
		// Go to next line
		$this->y += $h;
		if($ln==1)
			$this->x = $this->lMargin;
	}
	else
		$this->x += $w;
    }
}
