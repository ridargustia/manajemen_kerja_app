<?php

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(' ' . $company_data->company_name . ' ');
$pdf->SetAuthor(' ' . $company_data->company_name . ' ');
$pdf->SetTitle('LAPORAN ARSIP KESELURUHAN');

// set header false
$pdf->setPrintHeader(false);

// set margins
$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);

// set auto pagebreak
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set default font subsetting mode
$pdf->setFontSubsetting(true);

$pdf->SetFont('helvetica', '', 14, '', true);

$pdf->AddPage('L');

if (is_grandadmin() or is_masteradmin()) {
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
  
  <h3 align="center">LAPORAN ARSIP KESELURUHAN</h3>
  
  <table cellpadding="1" border="1">
    <thead>
      <tr>
        <td style="width: 5%; text-align: center; font-weight: bold">No. Urut</td>
        <td style="width: 10%; text-align: center; font-weight: bold">No. Arsip</td>
        <td style="width: 25%; text-align: center; font-weight: bold">Nama</td>
        <td style="width: 10%; text-align: center; font-weight: bold">Masa Retensi</td>
        <td style="width: 5%; text-align: center; font-weight: bold">Status Retensi</td>      
        <td style="width: 15%; text-align: center; font-weight: bold">Divisi</td>
        <td style="width: 15%; text-align: center; font-weight: bold">Cabang</td>
        <td style="width: 15%; text-align: center; font-weight: bold">Instansi</td>
      </tr>
    </thead>
    <tbody>
  ';

  $no = 1;
  foreach ($get_all as $data) {
    if ($data->status_retensi = '1') {
      $statusRetensi = 'Aktif';
    } else {
      $statusRetensi = 'InAktif';
    }

    $html .= '
      <tr>
        <td style="width: 5%; text-align: center;">' . $no++ . '</td>
        <td style="width: 10%; text-align: center;">' . $data->no_arsip . '</td>
        <td style="width: 25%; text-align: left;">' . $data->arsip_name . '</td>
        <td style="width: 10%; text-align: center;">' . date_only($data->masa_retensi) . '</td>
        <td style="width: 5%; text-align: center;">' . $statusRetensi . '</td>
        <td style="width: 15%; text-align: center;">' . $data->divisi_name . '</td>
        <td style="width: 15%; text-align: center;">' . $data->cabang_name . '</td>
        <td style="width: 15%; text-align: center;">' . $data->instansi_name . '</td>
      </tr>
      ';
  }
} else {
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
    LAPORAN ARSIP KESELURUHAN
    <br>'.$this->session->instansi_name.' CABANG '.strtoupper($this->session->cabang_name).' DIVISI '.strtoupper($this->session->divisi_name).'
  </h3>
  
  <p><hr/></p>
  
  <table cellpadding="1" border="1">
    <thead>
      <tr>
        <td style="width: 10%; text-align: center; font-weight: bold">No. Urut</td>
        <td style="width: 10%; text-align: center; font-weight: bold">No. Arsip</td>
        <td style="width: 50%; text-align: center; font-weight: bold">Nama</td>
        <td style="width: 20%; text-align: center; font-weight: bold">Masa Retensi</td>
        <td style="width: 10%; text-align: center; font-weight: bold">Status Retensi</td>
      </tr>
    </thead>
    <tbody>
  ';

  $no = 1;
  foreach ($get_all as $data) {
    if ($data->status_retensi = '1') {
      $statusRetensi = 'Aktif';
    } else {
      $statusRetensi = 'InAktif';
    }

    $html .= '
      <tr>
        <td style="width: 10%; text-align: center;">' . $no++ . '</td>
        <td style="width: 10%; text-align: center;">' . $data->no_arsip . '</td>
        <td style="width: 50%; text-align: left;">' . $data->arsip_name . '</td>
        <td style="width: 20%; text-align: center;">' . date_only($data->masa_retensi) . '</td>
        <td style="width: 10%; text-align: center;">' . $statusRetensi . '</td>        
      </tr>
      ';
  }
}

$html .= '</table></body>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->Output('LAPORAN_PEMINJAMAN_KESELURUHAN.pdf', 'I');
