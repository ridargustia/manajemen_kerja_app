<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_jalan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Jalan';

        $this->data['company_data']      = $this->Company_model->company_profile();
        $this->data['footer']            = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Kirim';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Surat Keterangan Jalan';
        $this->data['action']     = 'sk_jalan/create_action';

        //TODO Get data untuk dropdown reference
        $this->data['get_all_combobox_agama'] = $this->Agama_model->get_all_combobox();

        //TODO Rancangan form
        $this->data['name'] = [
            'name'          => 'name',
            'id'            => 'name',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['nik'] = [
            'name'          => 'nik',
            'id'            => 'nik',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['birthplace'] = [
            'name'          => 'birthplace',
            'id'            => 'birthplace',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['birthdate'] = [
            'name'          => 'birthdate',
            'id'            => 'birthdate',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['phone'] = [
            'name'          => 'phone',
            'id'            => 'phone',
            'class'         => 'form-control',
            'onChange'      => 'checkFormatPhone()',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['gender'] = [
            'name'          => 'gender',
            'id'            => 'gender',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['gender_value'] = [
            ''              => '- Pilih Jenis Kelamin -',
            '1'             => 'Laki-laki',
            '2'             => 'Perempuan',
        ];
        $this->data['agama'] = [
            'name'          => 'agama',
            'id'            => 'agama',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kebangsaan'] = [
            'name'          => 'kebangsaan',
            'id'            => 'kebangsaan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kebangsaan_value'] = [
            ''              => '- Pilih Kebangsaan -',
            '1'             => 'Warga Negara Indonesia',
            '2'             => 'Warga Negara Asing',
        ];
        $this->data['dusun'] = [
            'name'          => 'dusun',
            'id'            => 'dusun',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kepentingan'] = [
            'name'          => 'kepentingan',
            'id'            => 'kepentingan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['tempat_tujuan'] = [
            'name'          => 'tempat_tujuan',
            'id'            => 'tempat_tujuan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['tgl_berangkat'] = [
            'name'          => 'tgl_berangkat',
            'id'            => 'tgl_berangkat',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['barang_dibawa'] = [
            'name'          => 'barang_dibawa',
            'id'            => 'barang_dibawa',
            'class'         => 'form-control',
        ];
        $this->data['lama_pergi'] = [
            'name'          => 'lama_pergi',
            'id'            => 'lama_pergi',
            'class'         => 'form-control',
        ];
        $this->data['pengikut'] = [
            'name'          => 'pengikut',
            'id'            => 'pengikut',
            'class'         => 'form-control',
        ];
        $this->data['lain_lain'] = [
            'name'          => 'lain_lain',
            'id'            => 'lain_lain',
            'class'         => 'form-control',
        ];

        $this->load->view('front/surat/create_sk_jalan', $this->data);
    }

    function create_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'is_numeric|required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('kebangsaan', 'Kebangsaan', 'required');
        $this->form_validation->set_rules('dusun', 'Dusun', 'required');
        $this->form_validation->set_rules('kepentingan', 'Kepentingan', 'required');
        $this->form_validation->set_rules('tempat_tujuan', 'Tempat Tujuan', 'required');
        $this->form_validation->set_rules('tgl_berangkat', 'Tanggal Berangkat', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');
        $this->form_validation->set_message('is_numeric', '{field} harus angka');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        $check_format_phone = substr($this->input->post('phone'), '0', '2');

        //?Apakah validasi gagal?
        if ($this->form_validation->run() === FALSE) {
            //TODO Kondisi validasi gagal, redirect ke halaman create
            $this->create();
        } elseif ($check_format_phone != '08') {
            $this->session->set_flashdata('message', 'no HP/Telephone salah');
            redirect('sk_jalan/create');
        } else {
            //TODO Ubah Format phone number +62
            $selection_phone = substr($this->input->post('phone'), '1');
            $phone = '62' . $selection_phone;

            //TODO Simpan data ke array
            $data = array(
                'name'                  => $this->input->post('name'),
                'nik'                   => $this->input->post('nik'),
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'phone'                 => $phone,
                'gender'                => $this->input->post('gender'),
                'agama_id'              => $this->input->post('agama'),
                'kebangsaan'            => $this->input->post('kebangsaan'),
                'address'               => $this->input->post('dusun'),
                'kepentingan'           => $this->input->post('kepentingan'),
                'tempat_tujuan'         => $this->input->post('tempat_tujuan'),
                'tgl_berangkat'         => $this->input->post('tgl_berangkat'),
                'barang_dibawa'         => $this->input->post('barang_dibawa'),
                'lama_pergi'            => $this->input->post('lama_pergi'),
                'pengikut'              => $this->input->post('pengikut'),
                'lain_lain'             => $this->input->post('lain_lain'),
            );

            //TODO Post to database with model
            $this->Sk_jalan_model->insert($data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('sk_jalan/create');
        }
    }

    function auth_download()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Authentikasi Download Dokumen';
        $this->data['action']     = 'sk_jalan/auth_download_action';

        //TODO Kondisi menampilkan halaman Auth download dokumen
        $this->data['token'] = [
            'name'              => 'token',
            'id'                => 'token',
            'class'             => 'form-control',
            'autocomplete'      => 'off',
            'required'          => '',
            'value'             => $this->form_validation->set_value('token'),
        ];

        //TODO Load view halaman login
        $this->load->view('front/surat/auth_download_sk_jalan', $this->data);
    }

    function auth_download_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('token', 'Token', 'trim|required');

        $this->form_validation->set_message('required', '{field} wajib diisi');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        //?Apakah validasi gagal?
        if ($this->form_validation->run() === FALSE) {
            //TODO Kondisi validasi gagal, redirect ke halaman create
            redirect('sk_jalan/auth_download');
        } else {
            $this->data['sk_jalan'] = $this->Sk_jalan_model->get_by_token($this->input->post('token'));

            if ($this->data['sk_jalan']) {
                $this->data['page_title'] = 'Download ' . $this->data['module'];
                $this->data['agama'] = $this->Agama_model->get_by_id($this->data['sk_jalan']->agama_id);

                $this->load->view('front/surat/download_sk_jalan', $this->data);
            } else {
                //TODO Tampilkan notifikasi dan redirect
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Akses gagal, silahkan hubungi Admin.</div>');
                redirect('sk_jalan/auth_download');
            }
        }
    }

    function preview_document($id_sk_jalan)
    {
        $row = $this->Sk_jalan_model->get_by_id_for_document($id_sk_jalan);
        $data_master = $this->Auth_model->get_by_usertype_master();

        if ($row->gender === '1') {
            $gender = 'Laki-laki';
        } elseif ($row->gender === '2') {
            $gender = 'Perempuan';
        }

        if ($row->kebangsaan === '1') {
            $kebangsaan = 'Indonesia';
        } elseif ($row->kebangsaan === '2') {
            $kebangsaan = 'Asing';
        }

        require FCPATH . '/vendor/autoload.php';
        require FCPATH . '/vendor/setasign/fpdf/fpdf.php';

        $image = 'assets\images\kop_surat.png';
        $ttd_kades = $row->signature_image;
        $stempel = 'assets/images/stempel.png';

        $pdf = new FPDF('P', 'mm', 'Legal');
        $pdf->SetTitle($this->data['module'] . ' a.n ' . $row->name);
        $pdf->SetTopMargin(10);
        $pdf->SetLeftMargin(25);
        $pdf->SetRightMargin(25);
        $pdf->AddFont('Calibri', '', 'calibri.php');
        $pdf->AddFont('Calibrib', '', 'calibrib.php');
        $pdf->AddPage();

        //TODO Image
        $pdf->Image($image, 25, 10, 24, 25);

        //TODO Judul Surat
        $pdf->SetFont('Arial', '', '11');
        $pdf->Cell(0, 6, 'PEMERINTAH KABUPATEN SUMENEP', 0, 1, 'C');
        $pdf->Cell(0, 6, 'KECAMATAN KANGAYAN', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', '11');
        $pdf->Cell(0, 6, 'KANTOR KEPALA DESA SAOBI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', '11');
        $pdf->Cell(0, 6, 'Jalan Raya Masjid No. 50. Email desasaobi90@gmail.com', 0, 1, 'C');
        $pdf->SetFont('Arial', 'BU', '11');
        $pdf->Cell(0, 6, 'S A O B I', 0, 1, 'C');
        $pdf->Cell(130);
        $pdf->SetFont('Arial', 'I', '8');
        $pdf->Cell(0, 3, 'Kode Pos 69491', 0, 1, 'C');

        //TODO Body Surat
        $pdf->SetFont('Calibrib', '', '12');
        $pdf->Cell(0, 7, 'SURAT KETERANGAN JALAN', 0, 1, 'C');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(0, 5, 'NOMOR : ' . $row->no_surat, 0, 1, 'C');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 6, '', 0, 1); //end of line

        //TODO Body Content
        $pdf->Cell(0, 8, 'Yang bertanda tangan dibawah ini :', 0, 1, 'L');
        $pdf->Cell(50, 8, 'Nama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->SetFont('Calibrib', '', '12');
        $pdf->Cell(0, 8, strtoupper($data_master->name), 0, 1, 'L');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(50, 8, 'Alamat', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $data_master->address, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Jabatan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $data_master->jabatan_name, 0, 1, 'L');
        $pdf->Cell(0, 8, 'Menerangkan dengan sebenarnya bahwa :', 0, 1, 'L');
        $pdf->Cell(50, 8, 'Nama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->SetFont('Calibrib', '', '12');
        $pdf->Cell(0, 8, strtoupper($row->name), 0, 1, 'L');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(50, 8, 'Tempat, Tanggal Lahir', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->birthplace . ', ' . datetime_indo4($row->birthdate), 0, 1, 'L');
        $pdf->Cell(50, 8, 'Jenis kelamin', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $gender, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Alamat', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, 'Dsn. ' . $row->address . ' Desa Saobi Kangayan Sumenep', 0, 1, 'L');
        $pdf->Cell(50, 8, 'Agama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->agama_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Kewarganegaraan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $kebangsaan, 0, 1, 'L');
        $pdf->Cell(50, 8, 'No. NIK', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->nik, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Kepentingan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->kepentingan, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Tempat Tujuan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->tempat_tujuan, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Berangkat Tanggal', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, date_indonesian_only($row->tgl_berangkat), 0, 1, 'L');
        $pdf->Cell(50, 8, 'Barang yang dibawa', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->barang_dibawa, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Lamanya', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->lama_pergi, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Pengikut', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->pengikut, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Lain-lain', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->lain_lain, 0, 1, 'L');

        $pdf->MultiCell(0, 8, '         Adalah benar - benar penduduk Desa Saobi yang bertempat tinggal di Desa Saobi yang telah tercatat di buku register Desa, dan orang tersebut di atas orang baik-baik dan dalam kondisi baik-baik, serta tidak pernah terlibat G 30 S PKI  dan tidak pernah terlibat jaringan kriminal lainnya.', 0, 'J');
        $pdf->MultiCell(0, 8, '     Demikian surat keterangan ini, kami buat dengan sebenar-benarnya dan dapat dipergunakan sebagaimana mestinya.', 0, 'J');

        $pdf->Cell(115);
        $pdf->SetFont('Arial', 'I', '12');
        if ($row->acc_at !== NULL) {
            $pdf->Cell(0, 8, 'Saobi, ' . date_indonesian_only($row->acc_at), 0, 1, 'L');
        } else {
            $pdf->Cell(0, 8, 'Saobi, ', 0, 1, 'L');
        }

        $pdf->Cell(20);
        $pdf->SetFont('Arial', '', '12');
        $pdf->Cell(85, 8, 'Yang berkepentingan', 0, 0, 'L');
        $pdf->Cell(0, 8, 'Kepala Desa Saobi', 0, 1, 'C');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 20, '', 0, 1); //end of line

        if (!empty($row->signature_image)) {
            //TODO Image
            $pdf->Image($stempel, 123, 274, 35, 35);
            $pdf->Image($ttd_kades, 143, 274, 35, 25);
        }

        $pdf->SetFont('Arial', 'BU', '12');
        $pdf->Cell(80, 8, strtoupper($row->name), 0, 0, 'C');
        $pdf->Cell(65, 8, strtoupper($data_master->name), 0, 1, 'R');

        $pdf->Output('D', $this->data['module'] . ' a.n ' . $row->name . '.pdf');
    }

    function check_format_phone()
    {
        $phone = $this->input->post('phone');
        $check_phone = substr($phone, '0', '2');

        if ($check_phone != '08') {
            // var_dump($check_phone);
            echo "<div class='text-red'>Format penulisan no HP/Telephone tidak valid. Awali dengan 08xxxxxxxxxx</div>";
        }
    }
}
