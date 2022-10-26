<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_pengantar_nikah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Pengantar Nikah';

        $this->data['company_data']      = $this->Company_model->company_profile();
        $this->data['footer']            = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Kirim';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Surat Pengantar Bepergian Untuk Nikah';
        $this->data['action']     = 'surat_pengantar_nikah/create_action';

        //TODO Get data untuk dropdown reference
        $this->data['get_all_combobox_agama'] = $this->Agama_model->get_all_combobox();
        $this->data['get_all_combobox_status'] = $this->Status_model->get_all_combobox();
        $this->data['get_all_combobox_pekerjaan'] = $this->Pekerjaan_model->get_all_combobox();

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
        $this->data['bin_binti'] = [
            'name'          => 'bin_binti',
            'id'            => 'bin_binti',
            'class'         => 'form-control',
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
            ''             => '- Pilih Jenis Kelamin -',
            '1'             => 'Laki-laki',
            '2'             => 'Perempuan',
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
        $this->data['kebangsaan'] = [
            'name'          => 'kebangsaan',
            'id'            => 'kebangsaan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kebangsaan_value'] = [
            ''             => '- Pilih Kebangsaan -',
            '1'             => 'Warga Negara Indonesia',
            '2'             => 'Warga Negara Asing',
        ];
        $this->data['agama'] = [
            'name'          => 'agama',
            'id'            => 'agama',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['status'] = [
            'name'          => 'status',
            'id'            => 'status',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['pekerjaan'] = [
            'name'          => 'pekerjaan',
            'id'            => 'pekerjaan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['dusun'] = [
            'name'          => 'dusun',
            'id'            => 'dusun',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['rw'] = [
            'name'          => 'rw',
            'id'            => 'rw',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['rt'] = [
            'name'          => 'rt',
            'id'            => 'rt',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['dusun_tujuan'] = [
            'name'          => 'dusun_tujuan',
            'id'            => 'dusun_tujuan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['rw_tujuan'] = [
            'name'          => 'rw_tujuan',
            'id'            => 'rw_tujuan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['rt_tujuan'] = [
            'name'          => 'rt_tujuan',
            'id'            => 'rt_tujuan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['desa_tujuan'] = [
            'name'          => 'desa_tujuan',
            'id'            => 'desa_tujuan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['kecamatan_tujuan'] = [
            'name'          => 'kecamatan_tujuan',
            'id'            => 'kecamatan_tujuan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['kabupaten_tujuan'] = [
            'name'          => 'kabupaten_tujuan',
            'id'            => 'kabupaten_tujuan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['provinsi_tujuan'] = [
            'name'          => 'provinsi_tujuan',
            'id'            => 'provinsi_tujuan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];

        //TODO Load view dengan mengirim data
        $this->load->view('front/surat/create_surat_pengantar_nikah', $this->data);
    }

    function create_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        $this->form_validation->set_rules('bin_binti', 'Bin/Binti', 'trim|required');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
        $this->form_validation->set_rules('kebangsaan', 'Kebangsaan', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('status', 'Status Pernikahan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('dusun', 'Dusun', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');
        $this->form_validation->set_rules('dusun_tujuan', 'Dusun Tujuan', 'required');
        $this->form_validation->set_rules('rt_tujuan', 'RT Tujuan', 'required');
        $this->form_validation->set_rules('rw_tujuan', 'RW Tujuan', 'required');
        $this->form_validation->set_rules('desa_tujuan', 'Desa Tujuan', 'required');
        $this->form_validation->set_rules('kecamatan_tujuan', 'Kecamatan Tujuan', 'required');
        $this->form_validation->set_rules('kabupaten_tujuan', 'Kabupaten Tujuan', 'required');
        $this->form_validation->set_rules('provinsi_tujuan', 'Provinsi Tujuan', 'required');

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
            redirect('surat_pengantar_nikah/create');
        } else {
            //TODO Ubah Format phone number +62
            $selection_phone = substr($this->input->post('phone'), '1');
            $phone = '62' . $selection_phone;

            //TODO Format address
            $address = 'Dusun ' . $this->input->post('dusun') . ' RT/RW ' . $this->input->post('rt') . '/' . $this->input->post('rw');

            //TODO Simpan data ke array
            $data = array(
                'name'                  => $this->input->post('name'),
                'nik'                   => $this->input->post('nik'),
                'bin_binti'             => $this->input->post('bin_binti'),

                'gender'                => $this->input->post('gender'),
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'phone'                 => $phone,
                'kebangsaan'            => $this->input->post('kebangsaan'),
                'agama_id'              => $this->input->post('agama'),
                'status_id'             => $this->input->post('status'),
                'pekerjaan_id'          => $this->input->post('pekerjaan'),
                'address'               => $address,
                'dusun'                 => $this->input->post('dusun_tujuan'),
                'rt'                    => $this->input->post('rt_tujuan'),
                'rw'                    => $this->input->post('rw_tujuan'),
                'desa'                  => $this->input->post('desa_tujuan'),
                'kecamatan'             => $this->input->post('kecamatan_tujuan'),
                'kabupaten'             => $this->input->post('kabupaten_tujuan'),
                'provinsi'              => $this->input->post('provinsi_tujuan'),
            );

            //TODO Post to database with model
            $this->Surat_pengantar_nikah_model->insert($data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('surat_pengantar_nikah/create');
        }
    }

    function auth_download()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Authentikasi Download Dokumen';
        $this->data['action']     = 'surat_pengantar_nikah/auth_download_action';

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
        $this->load->view('front/surat/auth_download_surat_pengantar_nikah', $this->data);
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
            redirect('surat_pengantar_nikah/auth_download');
        } else {
            $this->data['surat_pengantar_nikah'] = $this->Surat_pengantar_nikah_model->get_by_token($this->input->post('token'));

            if ($this->data['surat_pengantar_nikah']) {
                $this->data['page_title'] = 'Download ' . $this->data['module'];

                $this->data['status'] = $this->Status_model->get_by_id($this->data['surat_pengantar_nikah']->status_id);
                $this->data['agama'] = $this->Agama_model->get_by_id($this->data['surat_pengantar_nikah']->agama_id);
                $this->data['pekerjaan'] = $this->Pekerjaan_model->get_by_id($this->data['surat_pengantar_nikah']->pekerjaan_id);

                $this->load->view('front/surat/download_surat_pengantar_nikah', $this->data);
            } else {
                //TODO Tampilkan notifikasi dan redirect
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Akses gagal, silahkan hubungi Admin.</div>');
                redirect('surat_pengantar_nikah/auth_download');
            }
        }
    }

    function preview_document($id_surat_pengantar_nikah)
    {
        $row = $this->Surat_pengantar_nikah_model->get_by_id_for_document($id_surat_pengantar_nikah);
        $data_master = $this->Auth_model->get_by_usertype_master();

        if ($row->gender === '1') {
            $gender = 'Laki-laki';
        } elseif ($row->gender === '2') {
            $gender = 'Perempuan';
        }

        if ($row->kebangsaan === '1') {
            $kebangsaan = 'WNI';
        } elseif ($row->kebangsaan === '2') {
            $kebangsaan = 'WNA';
        }

        require FCPATH . '/vendor/autoload.php';
        require FCPATH . '/vendor/setasign/fpdf/fpdf.php';

        $image = 'assets\images\kop_surat.png';
        $ttd_kades = $row->signature_image;
        $stempel = 'assets/images/stempel.png';

        $pdf = new FPDF('P', 'mm', 'A4');
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
        $pdf->Cell(0, 7, 'SURAT PENGANTAR BEPERGIAN UNTUK NIKAH', 0, 1, 'C');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(0, 5, 'Nomor : ' . $row->no_surat, 0, 1, 'C');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 6, '', 0, 1); //end of line

        //TODO Body Content
        $pdf->Cell(0, 8, 'Yang bertanda tangan di bawah ini menerangkan dengan sebenarnya bahwa:', 0, 1, 'L');
        $pdf->Cell(50, 8, 'Nama Lengkap', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->SetFont('Calibrib', '', '12');
        $pdf->Cell(0, 8, strtoupper($row->name), 0, 1, 'L');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(50, 8, 'Bin/Binti', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->bin_binti, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Jenis kelamin', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $gender, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Tempat / Tanggal Lahir', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->birthplace . ', ' . datetime_indo4($row->birthdate), 0, 1, 'L');
        $pdf->Cell(50, 8, 'No. KTP', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->nik, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Kewarganegaraan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $kebangsaan, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Agama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->agama_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Status perkawinan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->status_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Pekerjaan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->pekerjaan_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Alamat', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->address, 0, 1, 'L');
        $pdf->Cell(50, 8, '', 0, 0, 'L');
        $pdf->Cell(5, 8, '', 0, 0, 'C');
        $pdf->Cell(0, 8, 'Desa Saobi Kec.Kangayan Kab. Sumenep Jawa Timur', 0, 1, 'L');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 6, '', 0, 1); //end of line

        $pdf->Cell(50, 8, 'Keperluan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, 'Untuk melaksanakan perkawinan/pernikahan di:', 0, 1, 'L');
        $pdf->Cell(50, 8, 'Dusun/RT/RW', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, 'Dusun ' . $row->dusun . ' RT/RW ' . $row->rt . '/' . $row->rw, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Desa', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->desa, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Kecamatan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->kecamatan, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Kabupaten', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->kabupaten, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Provinsi', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->provinsi, 0, 1, 'L');

        $pdf->MultiCell(0, 8, 'Demikian surat keterangan ini dibuat dengan mengingat sumpah jabatan dan untuk dipergunakan sebagaimana mestinya.', 0, 'J');

        $pdf->Cell(115);
        $pdf->SetFont('Arial', 'I', '12');
        if ($row->acc_at !== NULL) {
            $pdf->Cell(0, 8, 'Saobi, ' . date_indonesian_only($row->acc_at), 0, 1, 'L');
        } else {
            $pdf->Cell(0, 8, 'Saobi, ', 0, 1, 'L');
        }

        $pdf->Cell(115);
        $pdf->SetFont('Arial', '', '12');
        $pdf->Cell(0, 8, 'Kepala Desa Saobi', 0, 1, 'C');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 8, '', 0, 1); //end of line

        if (!empty($row->signature_image)) {
            //TODO Image
            $pdf->Cell(50, 6, $pdf->Image($stempel, $pdf->GetX() + 100, $pdf->GetY() - 15, 35, 35), 0, 1, 'C');
            $pdf->Cell(50, 6, $pdf->Image($ttd_kades, $pdf->GetX() + 120, $pdf->GetY() - 17, 35, 25), 0, 1, 'C');
        }

        $pdf->SetFont('Arial', 'BU', '12');
        $pdf->Cell(107);
        $pdf->Cell(60, 8, strtoupper($data_master->name), 0, 1, 'C');

        $pdf->Output('I', $this->data['module'] . ' a.n ' . $row->name . '.pdf');
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
