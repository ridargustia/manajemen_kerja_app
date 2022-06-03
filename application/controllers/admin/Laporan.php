<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Laporan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Laporan';

    $this->load->library('Pdf');

    $this->load->model(array('Peminjaman_model', 'Pengembalian_model', 'Arsip_model'));

    $this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();
    

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';

    is_login();

    if (is_pegawai()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
      redirect('admin/dashboard');
    }

    if ($this->uri->segment(2) != NULL) {
      menuaccess_check();
    } elseif ($this->uri->segment(3) != NULL) {
      submenuaccess_check();
    }
  }

  function peminjaman()
  {
    is_read();

    $this->data['page_title'] = $this->data['module'] . ' Peminjaman';

    $this->load->view('back/laporan/laporan_peminjaman', $this->data);
  }

  function peminjaman_print_all()
  {
    is_read();

    if (is_grandadmin()) {
      $get_all = $this->Peminjaman_model->get_all();
    } elseif (is_masteradmin()) {
      $get_all = $this->Peminjaman_model->get_all_by_instansi();
    } elseif (is_superadmin()) {
      $get_all = $this->Peminjaman_model->get_all_by_cabang();
    } elseif (is_admin()) {
      $get_all = $this->Peminjaman_model->get_all_by_divisi();
    }

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()
      ->setCreator($this->session->username . '-' . $this->session->company_name)
      ->setLastModifiedBy($this->session->username . '-' . $this->session->company_name)
      ->setTitle('Laporan Peminjaman Arsip Keseluruhan - ' . $this->session->company_name)
      ->setSubject('Laporan Peminjaman Arsip Keseluruhan - ' . $this->session->company_name)
      ->setCompany($this->session->company_name)
      ->setDescription('Dokumen ini dicetak dari sistem JONARSIP). Copyright by JONARSIP. DEVELOPER: AmperaKoding/MuhAzmi (081228289766)')
      ->setKeywords('office 2007 openxml php')
      ->setCategory('laporan arsip keseluruhan');

    if (is_grandadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:H4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:H4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PEMINJAMAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL PEMINJAMAN')
        ->setCellValue('C4', 'TANGGAL KEMBALI')
        ->setCellValue('D4', 'NAMA PEMINJAM')
        ->setCellValue('E4', 'NAMA ARSIP')
        ->setCellValue('F4', 'DIVISI')
        ->setCellValue('G4', 'CABANG')
        ->setCellValue('H4', 'INSTANSI');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_peminjaman))
          ->setCellValue('C' . $i, date_only($data->tgl_kembali))
          ->setCellValue('D' . $i, $data->name)
          ->setCellValue('E' . $i, $data->arsip_name)
          ->setCellValue('F' . $i, $data->divisi_name)
          ->setCellValue('G' . $i, $data->cabang_name)
          ->setCellValue('H' . $i, $data->instansi_name);
        $i++;
      }
    }
    // jika masteradmin
    elseif (is_masteradmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:G2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:G4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:G4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PEMINJAMAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL PEMINJAMAN')
        ->setCellValue('C4', 'TANGGAL KEMBALI')
        ->setCellValue('D4', 'NAMA PEMINJAM')
        ->setCellValue('E4', 'NAMA ARSIP')
        ->setCellValue('F4', 'DIVISI')
        ->setCellValue('G4', 'CABANG');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_peminjaman))
          ->setCellValue('C' . $i, date_only($data->tgl_kembali))
          ->setCellValue('D' . $i, $data->name)
          ->setCellValue('E' . $i, $data->arsip_name)
          ->setCellValue('F' . $i, $data->divisi_name)
          ->setCellValue('G' . $i, $data->cabang_name);
        $i++;
      }
    }
    // jika superadmin
    elseif (is_superadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:F4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:F4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PEMINJAMAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL PEMINJAMAN')
        ->setCellValue('C4', 'TANGGAL KEMBALI')
        ->setCellValue('D4', 'NAMA PEMINJAM')
        ->setCellValue('E4', 'NAMA ARSIP')
        ->setCellValue('F4', 'DIVISI');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_peminjaman))
          ->setCellValue('C' . $i, date_only($data->tgl_kembali))
          ->setCellValue('D' . $i, $data->name)
          ->setCellValue('E' . $i, $data->arsip_name)
          ->setCellValue('F' . $i, $data->divisi_name);
        $i++;
      }
    }
    // jika admin
    elseif (is_admin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:E1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:E2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:E4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:E4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PEMINJAMAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL PEMINJAMAN')
        ->setCellValue('C4', 'TANGGAL KEMBALI')
        ->setCellValue('D4', 'NAMA PEMINJAM')
        ->setCellValue('E4', 'NAMA ARSIP');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_peminjaman))
          ->setCellValue('C' . $i, date_only($data->tgl_kembali))
          ->setCellValue('D' . $i, $data->name)
          ->setCellValue('E' . $i, $data->arsip_name);
        $i++;
      }
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Laporan Peminjaman Arsip');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Peminjaman Arsip Keseluruhan.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;

    // $this->load->view('back/laporan/print_peminjaman_all', $this->data);
  }

  function peminjaman_print_periode()
  {
    is_read();

    $tgl_awal   = $this->input->post('tgl_awal');
    $tgl_akhir  = $this->input->post('tgl_akhir');

    if (is_grandadmin()) {
      $get_all_periode = $this->Peminjaman_model->get_all_periode($tgl_awal, $tgl_akhir);
    } elseif (is_masteradmin()) {
      $get_all_periode = $this->Peminjaman_model->get_all_periode_by_instansi($tgl_awal, $tgl_akhir);
    } elseif (is_superadmin()) {
      $get_all_periode = $this->Peminjaman_model->get_all_periode_by_cabang($tgl_awal, $tgl_akhir);
    } elseif (is_admin()) {
      $get_all_periode = $this->Peminjaman_model->get_all_periode_by_divisi($tgl_awal, $tgl_akhir);
    }

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()
      ->setCreator($this->session->username . '-' . $this->session->company_name)
      ->setLastModifiedBy($this->session->username . '-' . $this->session->company_name)
      ->setTitle('Laporan Peminjaman Arsip Periode ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . ' - ' . $this->session->company_name)
      ->setSubject('Laporan Peminjaman Arsip Periode ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . ' - ' . $this->session->company_name)
      ->setCompany($this->session->company_name)
      ->setDescription('Dokumen ini dicetak dari sistem JONARSIP). Copyright by JONARSIP. DEVELOPER: AmperaKoding/MuhAzmi (081228289766)')
      ->setKeywords('office 2007 openxml php')
      ->setCategory('laporan arsip keseluruhan');

    if (is_grandadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:H4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:H4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PEMINJAMAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL PEMINJAMAN')
        ->setCellValue('C4', 'TANGGAL KEMBALI')
        ->setCellValue('D4', 'NAMA PEMINJAM')
        ->setCellValue('E4', 'NAMA ARSIP')
        ->setCellValue('F4', 'DIVISI')
        ->setCellValue('G4', 'CABANG')
        ->setCellValue('H4', 'INSTANSI');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_peminjaman))
          ->setCellValue('C' . $i, date_only($data->tgl_kembali))
          ->setCellValue('D' . $i, $data->name)
          ->setCellValue('E' . $i, $data->arsip_name)
          ->setCellValue('F' . $i, $data->divisi_name)
          ->setCellValue('G' . $i, $data->cabang_name)
          ->setCellValue('H' . $i, $data->instansi_name);
        $i++;
      }
    }
    // jika masteradmin
    elseif (is_masteradmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:G2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:G4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:G4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PEMINJAMAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL PEMINJAMAN')
        ->setCellValue('C4', 'TANGGAL KEMBALI')
        ->setCellValue('D4', 'NAMA PEMINJAM')
        ->setCellValue('E4', 'NAMA ARSIP')
        ->setCellValue('F4', 'DIVISI')
        ->setCellValue('G4', 'CABANG');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_peminjaman))
          ->setCellValue('C' . $i, date_only($data->tgl_kembali))
          ->setCellValue('D' . $i, $data->name)
          ->setCellValue('E' . $i, $data->arsip_name)
          ->setCellValue('F' . $i, $data->divisi_name)
          ->setCellValue('G' . $i, $data->cabang_name);
        $i++;
      }
    }
    // jika superadmin
    elseif (is_superadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:F4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:F4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PEMINJAMAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL PEMINJAMAN')
        ->setCellValue('C4', 'TANGGAL KEMBALI')
        ->setCellValue('D4', 'NAMA PEMINJAM')
        ->setCellValue('E4', 'NAMA ARSIP')
        ->setCellValue('F4', 'DIVISI');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_peminjaman))
          ->setCellValue('C' . $i, date_only($data->tgl_kembali))
          ->setCellValue('D' . $i, $data->name)
          ->setCellValue('E' . $i, $data->arsip_name)
          ->setCellValue('F' . $i, $data->divisi_name);
        $i++;
      }
    }
    // jika admin
    elseif (is_admin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:E1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:E2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:E4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:E4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PEMINJAMAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL PEMINJAMAN')
        ->setCellValue('C4', 'TANGGAL KEMBALI')
        ->setCellValue('D4', 'NAMA PEMINJAM')
        ->setCellValue('E4', 'NAMA ARSIP');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_peminjaman))
          ->setCellValue('C' . $i, date_only($data->tgl_kembali))
          ->setCellValue('D' . $i, $data->name)
          ->setCellValue('E' . $i, $data->arsip_name);
        $i++;
      }
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('LapPinjamPeriode');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Peminjaman Arsip Periode ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;

    // $this->load->view('back/laporan/print_peminjaman_periode', $this->data);
  }

  function pengembalian()
  {
    is_read();

    $this->data['page_title'] = $this->data['module'] . ' Pengembalian';

    $this->load->view('back/laporan/laporan_pengembalian', $this->data);
  }

  function pengembalian_print_all()
  {
    is_read();

    if (is_grandadmin()) {
      $get_all = $this->Pengembalian_model->get_all();
    } elseif (is_masteradmin()) {
      $get_all = $this->Pengembalian_model->get_all_by_instansi();
    } elseif (is_superadmin()) {
      $get_all = $this->Pengembalian_model->get_all_by_cabang();
    } elseif (is_admin()) {
      $get_all = $this->Pengembalian_model->get_all_by_divisi();
    }

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()
      ->setCreator($this->session->username . '-' . $this->session->company_name)
      ->setLastModifiedBy($this->session->username . '-' . $this->session->company_name)
      ->setTitle('Laporan Pengembalian Arsip Keseluruhan - ' . $this->session->company_name)
      ->setSubject('Laporan Pengembalian Arsip Keseluruhan - ' . $this->session->company_name)
      ->setCompany($this->session->company_name)
      ->setDescription('Dokumen ini dicetak dari sistem JONARSIP). Copyright by JONARSIP. DEVELOPER: AmperaKoding/MuhAzmi (081228289766)')
      ->setKeywords('office 2007 openxml php');

    if (is_grandadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:G2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:G4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:G4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PENGEMBALIAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL KEMBALI')
        ->setCellValue('C4', 'NAMA PEMINJAM')
        ->setCellValue('D4', 'NAMA ARSIP')
        ->setCellValue('E4', 'DIVISI')
        ->setCellValue('F4', 'CABANG')
        ->setCellValue('G4', 'INSTANSI');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_kembali))
          ->setCellValue('C' . $i, $data->name)
          ->setCellValue('D' . $i, $data->arsip_name)
          ->setCellValue('E' . $i, $data->divisi_name)
          ->setCellValue('F' . $i, $data->cabang_name)
          ->setCellValue('G' . $i, $data->instansi_name);
        $i++;
      }
    }
    // jika masteradmin
    elseif (is_masteradmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:F4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:F4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PENGEMBALIAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL KEMBALI')
        ->setCellValue('C4', 'NAMA PEMINJAM')
        ->setCellValue('D4', 'NAMA ARSIP')
        ->setCellValue('E4', 'DIVISI')
        ->setCellValue('F4', 'CABANG');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_kembali))
          ->setCellValue('C' . $i, $data->name)
          ->setCellValue('D' . $i, $data->arsip_name)
          ->setCellValue('E' . $i, $data->divisi_name)
          ->setCellValue('F' . $i, $data->cabang_name);
        $i++;
      }
    }
    // jika superadmin
    elseif (is_superadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:E1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:E2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:E4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:E4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PENGEMBALIAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL KEMBALI')
        ->setCellValue('C4', 'NAMA PEMINJAM')
        ->setCellValue('D4', 'NAMA ARSIP')
        ->setCellValue('E4', 'DIVISI');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_kembali))
          ->setCellValue('C' . $i, $data->name)
          ->setCellValue('D' . $i, $data->arsip_name)
          ->setCellValue('E' . $i, $data->divisi_name);
        $i++;
      }
    }
    // jika admin
    elseif (is_admin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:D1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:D2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:D4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:D4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PENGEMBALIAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL KEMBALI')
        ->setCellValue('C4', 'NAMA PEMINJAM')
        ->setCellValue('D4', 'NAMA ARSIP');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_kembali))
          ->setCellValue('C' . $i, $data->name)
          ->setCellValue('D' . $i, $data->arsip_name);
        $i++;
      }
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Laporan Pengembalian Arsip');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Pengembalian Arsip Keseluruhan.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;

    // $this->load->view('back/laporan/print_pengembalian_all', $this->data);
  }

  function pengembalian_print_periode()
  {
    is_read();

    $tgl_awal   = $this->input->post('tgl_awal');
    $tgl_akhir  = $this->input->post('tgl_akhir');

    if (is_grandadmin()) {
      $get_all_periode = $this->Pengembalian_model->get_all_periode($tgl_awal, $tgl_akhir);
    } elseif (is_masteradmin()) {
      $get_all_periode = $this->Pengembalian_model->get_all_periode_by_instansi($tgl_awal, $tgl_akhir);
    } elseif (is_superadmin()) {
      $get_all_periode = $this->Pengembalian_model->get_all_periode_by_cabang($tgl_awal, $tgl_akhir);
    } elseif (is_admin()) {
      $get_all_periode = $this->Pengembalian_model->get_all_periode_by_divisi($tgl_awal, $tgl_akhir);
    }

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()
      ->setCreator($this->session->username . '-' . $this->session->company_name)
      ->setLastModifiedBy($this->session->username . '-' . $this->session->company_name)
      ->setTitle('Laporan Pengembalian Arsip Periode ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . ' - ' . $this->session->company_name)
      ->setSubject('Laporan Pengembalian Arsip Periode ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . ' - ' . $this->session->company_name)
      ->setCompany($this->session->company_name)
      ->setDescription('Dokumen ini dicetak dari sistem JONARSIP). Copyright by JONARSIP. DEVELOPER: AmperaKoding/MuhAzmi (081228289766)')
      ->setKeywords('office 2007 openxml php');

    if (is_grandadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:G2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:G4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:G4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PENGEMBALIAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL KEMBALI')
        ->setCellValue('C4', 'NAMA PEMINJAM')
        ->setCellValue('D4', 'NAMA ARSIP')
        ->setCellValue('E4', 'DIVISI')
        ->setCellValue('F4', 'CABANG')
        ->setCellValue('G4', 'INSTANSI');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_kembali))
          ->setCellValue('C' . $i, $data->name)
          ->setCellValue('D' . $i, $data->arsip_name)
          ->setCellValue('E' . $i, $data->divisi_name)
          ->setCellValue('F' . $i, $data->cabang_name)
          ->setCellValue('G' . $i, $data->instansi_name);
        $i++;
      }
    }
    // jika masteradmin
    elseif (is_masteradmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:F4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:F4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PENGEMBALIAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL KEMBALI')
        ->setCellValue('C4', 'NAMA PEMINJAM')
        ->setCellValue('D4', 'NAMA ARSIP')
        ->setCellValue('E4', 'DIVISI')
        ->setCellValue('F4', 'CABANG');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_kembali))
          ->setCellValue('C' . $i, $data->name)
          ->setCellValue('D' . $i, $data->arsip_name)
          ->setCellValue('E' . $i, $data->divisi_name)
          ->setCellValue('F' . $i, $data->cabang_name);
        $i++;
      }
    }
    // jika superadmin
    elseif (is_superadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:E1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:E2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:E4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:E4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PENGEMBALIAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL KEMBALI')
        ->setCellValue('C4', 'NAMA PEMINJAM')
        ->setCellValue('D4', 'NAMA ARSIP')
        ->setCellValue('E4', 'DIVISI');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_kembali))
          ->setCellValue('C' . $i, $data->name)
          ->setCellValue('D' . $i, $data->arsip_name)
          ->setCellValue('E' . $i, $data->divisi_name);
        $i++;
      }
    }
    // jika admin
    elseif (is_admin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:D1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:D2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:D4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:D4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN PENGEMBALIAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'TANGGAL KEMBALI')
        ->setCellValue('C4', 'NAMA PEMINJAM')
        ->setCellValue('D4', 'NAMA ARSIP');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {
        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, date_only($data->tgl_kembali))
          ->setCellValue('C' . $i, $data->name)
          ->setCellValue('D' . $i, $data->arsip_name);
        $i++;
      }
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Laporan Pengembalian Arsip');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Pengembalian Arsip Periode ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;

    // $this->load->view('back/laporan/print_pengembalian_periode', $this->data);
  }

  function arsip()
  {
    is_read();

    $this->data['page_title'] = $this->data['module'] . ' Arsip';

    $this->load->view('back/laporan/laporan_arsip', $this->data);
  }

  function arsip_print_all()
  {
    if (is_grandadmin()) {
      $get_all = $this->Arsip_model->get_all_laporan();
    } elseif (is_masteradmin()) {
      $get_all = $this->Arsip_model->get_all_by_instansi_laporan();
    } elseif (is_superadmin()) {
      $get_all = $this->Arsip_model->get_all_by_cabang_laporan();
    } elseif (is_admin()) {
      $get_all = $this->Arsip_model->get_all_by_divisi_laporan();
    }

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()
      ->setCreator($this->session->username . '-' . $this->session->company_name)
      ->setLastModifiedBy($this->session->username . '-' . $this->session->company_name)
      ->setTitle('Laporan Arsip Keseluruhan - ' . $this->session->company_name)
      ->setSubject('Laporan Arsip Keseluruhan - ' . $this->session->company_name)
      ->setCompany($this->session->company_name)
      ->setDescription('Dokumen ini dicetak dari sistem JONARSIP). Copyright by JONARSIP. DEVELOPER: AmperaKoding/MuhAzmi (081228289766)')
      ->setKeywords('office 2007 openxml php')
      ->setCategory('laporan arsip');

    if (is_grandadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:O1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:O2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:O4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI')
        ->setCellValue('N4', 'CABANG')
        ->setCellValue('O4', 'INSTANSI');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } elseif ($data->keterangan = '1') {
          $keterangan = 'Musnah';
        } else {
          $keterangan = '-';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('O' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name)
          ->setCellValue('N' . $i, $data->cabang_name)
          ->setCellValue('O' . $i, $data->instansi_name);
        $i++;
      }
    }
    // jika masteradmin
    elseif (is_masteradmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:N1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:N2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI')
        ->setCellValue('N4', 'CABANG');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } elseif ($data->keterangan = '1') {
          $keterangan = 'Musnah';
        } else {
          $keterangan = '-';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name)
          ->setCellValue('N' . $i, $data->cabang_name);
        $i++;
      }
    }
    // jika superadmin
    elseif (is_superadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:M1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:M2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:M4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } elseif ($data->keterangan = '1') {
          $keterangan = 'Musnah';
        } else {
          $keterangan = '-';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name);
        $i++;
      }
    }
    // jika admin
    elseif (is_admin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:L1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:L2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:L4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:L4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP KESELURUHAN')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM');

      $i = 5;
      $no = '1';
      foreach ($get_all as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } elseif ($data->keterangan = '1') {
          $keterangan = 'Musnah';
        } else {
          $keterangan = '-';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available);
        $i++;
      }
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Laporan Arsip Keseluruhan');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Arsip Keseluruhan.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
  }

  function arsip_print_periode()
  {
    is_read();

    $tgl_awal   = $this->input->post('tgl_awal');
    $tgl_akhir  = $this->input->post('tgl_akhir');

    if (is_grandadmin()) {
      $get_all_periode = $this->Arsip_model->get_all_periode($tgl_awal, $tgl_akhir);
    } elseif (is_masteradmin()) {
      $get_all_periode = $this->Arsip_model->get_all_periode_by_instansi($tgl_awal, $tgl_akhir);
    } elseif (is_superadmin()) {
      $get_all_periode = $this->Arsip_model->get_all_periode_by_cabang($tgl_awal, $tgl_akhir);
    } elseif (is_admin()) {
      $get_all_periode = $this->Arsip_model->get_all_periode_by_divisi($tgl_awal, $tgl_akhir);
    }

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()
      ->setCreator($this->session->username . '-' . $this->session->company_name)
      ->setLastModifiedBy($this->session->username . '-' . $this->session->company_name)
      ->setTitle('Laporan Arsip Periode ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . ' - ' . $this->session->company_name)
      ->setSubject('Laporan Arsip Periode ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . ' - ' . $this->session->company_name)
      ->setCompany($this->session->company_name)
      ->setDescription('Dokumen ini dicetak dari sistem JONARSIP). Copyright by JONARSIP. DEVELOPER: AmperaKoding/MuhAzmi (081228289766)')
      ->setKeywords('office 2007 openxml php')
      ->setCategory('laporan arsip periode');

    if (is_grandadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:O1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:O2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:O4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . ' ')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI')
        ->setCellValue('N4', 'CABANG')
        ->setCellValue('O4', 'INSTANSI');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } elseif ($data->keterangan = '1') {
          $keterangan = 'Musnah';
        } else {
          $keterangan = '-';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('O' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name)
          ->setCellValue('N' . $i, $data->cabang_name)
          ->setCellValue('O' . $i, $data->instansi_name);
        $i++;
      }
    }
    // jika masteradmin
    elseif (is_masteradmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:N1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:N2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . ' ')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI')
        ->setCellValue('N4', 'CABANG');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } elseif ($data->keterangan = '1') {
          $keterangan = 'Musnah';
        } else {
          $keterangan = '-';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name)
          ->setCellValue('N' . $i, $data->cabang_name);
        $i++;
      }
    }
    // jika superadmin
    elseif (is_superadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:M1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:M2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:M4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . ' ')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } elseif ($data->keterangan = '1') {
          $keterangan = 'Musnah';
        } else {
          $keterangan = '-';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name);
        $i++;
      }
    }
    // jika admin
    elseif (is_admin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:L1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:L2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:L4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:L4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP PERIODE ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . ' ')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM');

      $i = 5;
      $no = '1';
      foreach ($get_all_periode as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } elseif ($data->keterangan = '1') {
          $keterangan = 'Musnah';
        } else {
          $keterangan = '-';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available);
        $i++;
      }
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Laporan Arsip Periode');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Arsip Periode ' . date_only($tgl_awal) . ' - ' . date_only($tgl_akhir) . '.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
  }

  function arsip_print_aktif()
  {
    is_read();

    if (is_grandadmin()) {
      $get_all_aktif = $this->Arsip_model->get_all_aktif();
    } elseif (is_masteradmin()) {
      $get_all_aktif = $this->Arsip_model->get_all_aktif_by_instansi();
    } elseif (is_superadmin()) {
      $get_all_aktif = $this->Arsip_model->get_all_aktif_by_cabang();
    } elseif (is_admin()) {
      $get_all_aktif = $this->Arsip_model->get_all_aktif_by_divisi();
    }

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()
      ->setCreator($this->session->username . '-' . $this->session->company_name)
      ->setLastModifiedBy($this->session->username . '-' . $this->session->company_name)
      ->setTitle('Laporan Arsip Aktif - ' . $this->session->company_name)
      ->setSubject('Laporan Arsip Aktif - ' . $this->session->company_name)
      ->setCompany($this->session->company_name)
      ->setDescription('Dokumen ini dicetak dari sistem JONARSIP). Copyright by JONARSIP. DEVELOPER: AmperaKoding/MuhAzmi (081228289766)')
      ->setKeywords('office 2007 openxml php')
      ->setCategory('laporan arsip aktif');

    if (is_grandadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:O1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:O2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:O4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP AKTIF')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI')
        ->setCellValue('N4', 'CABANG')
        ->setCellValue('O4', 'INSTANSI');

      $i = 5;
      $no = '1';
      foreach ($get_all_aktif as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } else {
          $keterangan = 'Musnah';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('O' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name)
          ->setCellValue('N' . $i, $data->cabang_name)
          ->setCellValue('O' . $i, $data->instansi_name);
        $i++;
      }
    }
    // jika masteradmin
    elseif (is_masteradmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:N1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:N2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP AKTIF')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI')
        ->setCellValue('N4', 'CABANG');

      $i = 5;
      $no = '1';
      foreach ($get_all_aktif as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } elseif ($data->keterangan = '1') {
          $keterangan = 'Musnah';
        } else {
          $keterangan = '-';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name)
          ->setCellValue('N' . $i, $data->cabang_name);
        $i++;
      }
    }
    // jika superadmin
    elseif (is_superadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:M1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:M2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:M4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP AKTIF')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI');

      $i = 5;
      $no = '1';
      foreach ($get_all_aktif as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } else {
          $keterangan = 'Musnah';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name);
        $i++;
      }
    }
    // jika admin
    elseif (is_admin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:L1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:L2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:L4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:L4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP AKTIF')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM');

      $i = 5;
      $no = '1';
      foreach ($get_all_aktif as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } else {
          $keterangan = 'Musnah';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available);
        $i++;
      }
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Laporan Arsip Aktif');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Arsip Aktif.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
  }

  function arsip_print_inaktif()
  {
    is_read();

    if (is_grandadmin()) {
      $get_all_inaktif = $this->Arsip_model->get_all_inaktif();
    } elseif (is_masteradmin()) {
      $get_all_inaktif = $this->Arsip_model->get_all_inaktif_by_instansi();
    } elseif (is_superadmin()) {
      $get_all_inaktif = $this->Arsip_model->get_all_inaktif_by_cabang();
    } elseif (is_admin()) {
      $get_all_inaktif = $this->Arsip_model->get_all_inaktif_by_divisi();
    }

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()
      ->setCreator($this->session->username . '-' . $this->session->company_name)
      ->setLastModifiedBy($this->session->username . '-' . $this->session->company_name)
      ->setTitle('Laporan Arsip InAktif - ' . $this->session->company_name)
      ->setSubject('Laporan Arsip InAktif - ' . $this->session->company_name)
      ->setCompany($this->session->company_name)
      ->setDescription('Dokumen ini dicetak dari sistem JONARSIP). Copyright by JONARSIP. DEVELOPER: AmperaKoding/MuhAzmi (081228289766)')
      ->setKeywords('office 2007 openxml php')
      ->setCategory('laporan arsip aktif');

    if (is_grandadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:O1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:O2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:O4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP INAKTIF')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI')
        ->setCellValue('N4', 'CABANG')
        ->setCellValue('O4', 'INSTANSI');

      $i = 5;
      $no = '1';
      foreach ($get_all_inaktif as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } else {
          $keterangan = 'Musnah';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('O' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name)
          ->setCellValue('N' . $i, $data->cabang_name)
          ->setCellValue('O' . $i, $data->instansi_name);
        $i++;
      }
    }
    // jika masteradmin
    elseif (is_masteradmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:N1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:N2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP INAKTIF')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI')
        ->setCellValue('N4', 'CABANG');

      $i = 5;
      $no = '1';
      foreach ($get_all_inaktif as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } else {
          $keterangan = 'Musnah';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name)
          ->setCellValue('N' . $i, $data->cabang_name);
        $i++;
      }
    }
    // jika superadmin
    elseif (is_superadmin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:M1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:M2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:I4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:M4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP INAKTIF')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM')
        ->setCellValue('M4', 'DIVISI');

      $i = 5;
      $no = '1';
      foreach ($get_all_inaktif as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } else {
          $keterangan = 'Musnah';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available)
          ->setCellValue('M' . $i, $data->divisi_name);
        $i++;
      }
    }
    // jika admin
    elseif (is_admin()) {
      // merge cells
      $spreadsheet->getActiveSheet()->mergeCells('A1:L1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:L2');
      // set warna font
      // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A1')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A2')
        ->getFont()->setBold(true);
      $spreadsheet->getActiveSheet()->getStyle('A4:L4')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      // styling dalam array
      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => [
            'argb' => '92D050',
          ],
        ],
      ];
      $spreadsheet->getActiveSheet()->getStyle('A4:L4')->applyFromArray($styleArray);

      // autowidth column
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

      // Add some data
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'LAPORAN ARSIP INAKTIF')
        ->setCellValue('A2', $this->session->instansi_name)
        ->setCellValue('A4', 'NO')
        ->setCellValue('B4', 'NO. ARSIP')
        ->setCellValue('C4', 'NAMA ARSIP')
        ->setCellValue('D4', 'LOKASI')
        ->setCellValue('E4', 'RAK')
        ->setCellValue('F4', 'BARIS')
        ->setCellValue('G4', 'BOX')
        ->setCellValue('H4', 'MAP')
        ->setCellValue('I4', 'MASA RETENSI')
        ->setCellValue('J4', 'STATUS')
        ->setCellValue('K4', 'KETERANGAN')
        ->setCellValue('L4', 'STATUS PINJAM');

      $i = 5;
      $no = '1';
      foreach ($get_all_inaktif as $data) {

        if ($data->status_retensi == '1') {
          $statusRetensi = 'Aktif';
        } else {
          $statusRetensi = 'InAktif';
        }

        if ($data->keterangan == '0') {
          $keterangan = 'Permanen';
        } else {
          $keterangan = 'Musnah';
        }

        if ($data->is_available == '1') {
          $is_available = 'Tersedia';
        } else {
          $is_available = 'Dipinjam';
        }

        $styleArray = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $styleArrayLeft = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ],
          'borders' => [
            'outline' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
        $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, $no++)
          ->setCellValue('B' . $i, $data->no_arsip)
          ->setCellValue('C' . $i, $data->arsip_name)
          ->setCellValue('D' . $i, $data->lokasi_name)
          ->setCellValue('E' . $i, $data->rak_name)
          ->setCellValue('F' . $i, $data->baris_name)
          ->setCellValue('G' . $i, $data->box_name)
          ->setCellValue('H' . $i, $data->map_name)
          ->setCellValue('I' . $i, date_only($data->masa_retensi))
          ->setCellValue('J' . $i, $statusRetensi)
          ->setCellValue('K' . $i, $keterangan)
          ->setCellValue('L' . $i, $is_available);
        $i++;
      }
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Laporan Arsip InAktif');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Arsip InAktif.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
  }
}
