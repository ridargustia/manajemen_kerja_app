<?php

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(' '.$company_data->company_name.' ');
$pdf->SetAuthor(' '.$company_data->company_name.' ');
$pdf->SetTitle('LAPORAN PEMINJAMAN PERIODE '.date_only($this->input->post('tgl_awal')).' - '.date_only($this->input->post('tgl_akhir')).' ');

// set header false
$pdf->setPrintHeader(false);

// set margins
$pdf->SetMargins(10,10,10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);

// set auto pagebreak
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set default font subsetting mode
$pdf->setFontSubsetting(true);

$pdf->SetFont('helvetica', '', 14, '', true);

$pdf->AddPage();

$html = '
<style>
body{
  font-size: 10px;
}
.header{
  font-size: 12px;
}
</style>
<body>

<h3 align="center">
  LAPORAN PEMINJAMAN PERIODE <br>
  '.date_only($this->input->post('tgl_awal')).' - '.date_only($this->input->post('tgl_akhir')).'
</h3>

<p><hr/></p>

<table cellpadding="1" border="1">
  <thead>
    <tr>
    <td style="width: 10%; text-align: center; font-weight: bold">No.</td>
    <td style="width: 20%; text-align: center; font-weight: bold">Tgl Peminjaman</td>
    <td style="width: 20%; text-align: center; font-weight: bold">Tgl Pengembalian</td>
    <td style="width: 20%; text-align: center; font-weight: bold">Nama Peminjam</td>
    <td style="width: 30%; text-align: center; font-weight: bold">Nama Arsip</td>
    </tr>
  </thead>
  <tbody>
';

  $no = 1;
  foreach($get_all_periode as $data)
  {
    $html.= '
    <tr>
      <td style="width: 10%; text-align: center;">'.$no++.'</td>
      <td style="width: 20%; text-align: center;">'.date_only($data->tgl_peminjaman).'</td>
      <td style="width: 20%; text-align: center;">'.date_only($data->tgl_kembali).'</td>
      <td style="width: 20%; text-align: center;">'.$data->name.'</td>
      <td style="width: 30%; text-align: left;">'.$data->arsip_name.'</td>
    </tr>
    ';
  }

$html.= '</table></body>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->Output('LAPORAN_PEMINJAMAN_PERIODE '.date_only($this->input->post('tgl_awal')).' - '.date_only($this->input->post('tgl_akhir')).'.pdf', 'I');

?>
