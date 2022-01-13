<?php
// memanggil library FPDF
require('fpdf/fpdf.php');

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('l','mm','A5');

// membuat halaman baru
$pdf->AddPage();

// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',16);
// mencetak string 
$pdf->Cell(190,7,'PROGRAM STUDI TEKNIK INFORMATIKA',0,1,'C');
// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',12);
// mencetak string 
$pdf->Cell(190,7,'DAFTAR MAHASISWA MATKUL PEMROGRAMAN WEB DINAMIS',0,1,'C');

// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,7,'',0,1);
// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',10);
// mencetak string 
$pdf->Cell(20,6,'BARKAS',1,0);
// mencetak string 
$pdf->Cell(50,6,'HARGA',1,0);
// mencetak string 
$pdf->Cell(25,6,'PEMILIK',1,0);
// mencetak string 
$pdf->Cell(50,6,'KONTAK',1,0);
// mencetak string 
$pdf->Cell(30,6,'STATUS',1,1);
// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','',10);

// perulangan menampilkan isi array data mahasiswa
foreach ($barkas as $barkas) {
    
    $pdf->Cell(20,6,$barkas['barkas_nama'],1,0);
    $pdf->Cell(50,6,$barkas['barkas_harga'],1,0);
    $pdf->Cell(25,6,$barkas['barkas_pemilik'],1,0);
    $pdf->Cell(50,6,$barkas['barkas_kontak'],1,0);
    $pdf->Cell(30,6,$barkas['barkas_status'],1,1); 
}

// menampilkan pdf
$pdf->Output();
?>