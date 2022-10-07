<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_nikah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Nikah';

        $this->data['company_data']      = $this->Company_model->company_profile();
        $this->data['footer']            = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Kirim';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Surat Keterangan Nikah';
        $this->data['action']     = 'sk_nikah/create_action';

        //TODO Get data untuk dropdown reference
        $this->data['get_all_combobox_status'] = $this->Status_model->get_all_combobox();
        $this->data['get_all_combobox_agama'] = $this->Agama_model->get_all_combobox();

        //TODO Rancangan form data suami
        $this->data['suami_name'] = [
            'name'          => 'suami_name',
            'id'            => 'suami_name',
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
        $this->data['suami_birthplace'] = [
            'name'          => 'suami_birthplace',
            'id'            => 'suami_birthplace',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['suami_birthdate'] = [
            'name'          => 'suami_birthdate',
            'id'            => 'suami_birthdate',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['suami_gender'] = [
            'name'          => 'suami_gender',
            'id'            => 'suami_gender',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['suami_status'] = [
            'name'          => 'suami_status',
            'id'            => 'suami_status',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['suami_agama'] = [
            'name'          => 'suami_agama',
            'id'            => 'suami_agama',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kebangsaan_suami'] = [
            'name'          => 'kebangsaan_suami',
            'id'            => 'kebangsaan_suami',
            'class'         => 'form-control',
            'required'      => '',
        ];
        //TODO Rancangan form data istri
        $this->data['istri_name'] = [
            'name'          => 'istri_name',
            'id'            => 'istri_name',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['istri_birthplace'] = [
            'name'          => 'istri_birthplace',
            'id'            => 'istri_birthplace',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['istri_birthdate'] = [
            'name'          => 'istri_birthdate',
            'id'            => 'istri_birthdate',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['istri_gender'] = [
            'name'          => 'istri_gender',
            'id'            => 'istri_gender',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['istri_status'] = [
            'name'          => 'istri_status',
            'id'            => 'istri_status',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['istri_agama'] = [
            'name'          => 'istri_agama',
            'id'            => 'istri_agama',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kebangsaan_istri'] = [
            'name'          => 'kebangsaan_istri',
            'id'            => 'kebangsaan_istri',
            'class'         => 'form-control',
            'required'      => '',
        ];
        //TODO Value dropdown reference
        $this->data['gender_value'] = [
            ''              => '- Pilih Jenis Kelamin -',
            '1'             => 'Laki-laki',
            '2'             => 'Perempuan',
        ];
        $this->data['kebangsaan_value'] = [
            ''              => '- Pilih Kebangsaan -',
            '1'             => 'Warga Negara Indonesia',
            '2'             => 'Warga Negara Asing',
        ];

        //TODO Load view dengan mengirim data
        $this->load->view('front/surat/create_sk_nikah', $this->data);
    }

    function create_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('suami_name', 'Nama Suami', 'trim|required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
        $this->form_validation->set_rules('suami_birthplace', 'Tempat Lahir Suami', 'trim|required');
        $this->form_validation->set_rules('suami_birthdate', 'Tanggal Lahir Suami', 'required');
        $this->form_validation->set_rules('suami_gender', 'Jenis Kelamin Suami', 'required');
        $this->form_validation->set_rules('suami_status', 'Status Pernikahan Suami', 'required');
        $this->form_validation->set_rules('suami_agama', 'Agama Suami', 'required');
        $this->form_validation->set_rules('kebangsaan_suami', 'Kebangsaan Suami', 'required');
        $this->form_validation->set_rules('istri_name', 'Nama Istri', 'trim|required');
        $this->form_validation->set_rules('istri_birthplace', 'Tempat Lahir Istri', 'trim|required');
        $this->form_validation->set_rules('istri_birthdate', 'Tanggal Lahir Istri', 'required');
        $this->form_validation->set_rules('istri_gender', 'Jenis Kelamin Istri', 'required');
        $this->form_validation->set_rules('istri_status', 'Status Pernikahan Istri', 'required');
        $this->form_validation->set_rules('istri_agama', 'Agama Istri', 'required');
        $this->form_validation->set_rules('kebangsaan_istri', 'Kebangsaan Istri', 'required');

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
            redirect('sk_nikah/create');
        } else {
            //TODO Ubah Format phone number +62
            $selection_phone = substr($this->input->post('phone'), '1');
            $phone = '62' . $selection_phone;

            //TODO Simpan data ke array
            $data = array(
                'suami_name'            => $this->input->post('suami_name'),
                'phone'                 => $phone,
                'suami_birthplace'      => $this->input->post('suami_birthplace'),
                'suami_birthdate'       => $this->input->post('suami_birthdate'),
                'suami_gender'          => $this->input->post('suami_gender'),
                'suami_status_id'       => $this->input->post('suami_status'),
                'suami_agama_id'        => $this->input->post('suami_agama'),
                'kebangsaan_suami'      => $this->input->post('kebangsaan_suami'),
                'istri_name'            => $this->input->post('istri_name'),
                'istri_birthplace'      => $this->input->post('istri_birthplace'),
                'istri_birthdate'       => $this->input->post('istri_birthdate'),
                'istri_gender'          => $this->input->post('istri_gender'),
                'istri_status_id'       => $this->input->post('istri_status'),
                'istri_agama_id'        => $this->input->post('istri_agama'),
                'kebangsaan_istri'      => $this->input->post('kebangsaan_istri'),
            );

            //TODO Post to database with model
            $this->Sk_nikah_model->insert($data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('sk_nikah/create');
        }
    }

    function auth_download()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Authentikasi Download Dokumen';
        $this->data['action']     = 'sk_nikah/auth_download_action';

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
        $this->load->view('front/surat/auth_download_sk_nikah', $this->data);
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
            redirect('sk_nikah/auth_download');
        } else {
            $this->data['sk_nikah'] = $this->Sk_nikah_model->get_by_token($this->input->post('token'));

            if ($this->data['sk_nikah']) {
                $this->data['page_title'] = 'Download ' . $this->data['module'];

                $this->data['suami_status'] = $this->Status_model->get_by_id($this->data['sk_nikah']->suami_status_id);
                $this->data['istri_status'] = $this->Status_model->get_by_id($this->data['sk_nikah']->istri_status_id);
                $this->data['suami_agama'] = $this->Agama_model->get_by_id($this->data['sk_nikah']->suami_agama_id);
                $this->data['istri_agama'] = $this->Agama_model->get_by_id($this->data['sk_nikah']->istri_agama_id);

                $this->load->view('front/surat/download_sk_nikah', $this->data);
            } else {
                //TODO Tampilkan notifikasi dan redirect
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Akses gagal, silahkan hubungi Admin.</div>');
                redirect('sk_nikah/auth_download');
            }
        }
    }

    function preview_document($id_sk_nikah)
    {
        $row = $this->Sk_nikah_model->get_by_id_for_document($id_sk_nikah);
        $status_istri = $this->Status_model->get_by_id($row->istri_status_id);
        $agama_istri = $this->Agama_model->get_by_id($row->istri_agama_id);

        $data_master = $this->Auth_model->get_by_usertype_master();

        //TODO Data Suami
        if ($row->suami_gender === '1') {
            $suami_gender = 'Laki-laki';
        } elseif ($row->suami_gender === '2') {
            $suami_gender = 'Perempuan';
        }

        if ($row->kebangsaan_suami === '1') {
            $kebangsaan_suami = 'Warga Negara Indonesia';
        } elseif ($row->kebangsaan_suami === '2') {
            $kebangsaan_suami = 'Warga Negara Asing';
        }

        //TODO Data Istri
        if ($row->istri_gender === '1') {
            $istri_gender = 'Laki-laki';
        } elseif ($row->istri_gender === '2') {
            $istri_gender = 'Perempuan';
        }

        if ($row->kebangsaan_istri === '1') {
            $kebangsaan_istri = 'Warga Negara Indonesia';
        } elseif ($row->kebangsaan_istri === '2') {
            $kebangsaan_istri = 'Warga Negara Asing';
        }

        require FCPATH . '/vendor/autoload.php';
        require FCPATH . '/vendor/setasign/fpdf/fpdf.php';

        $image = 'assets/images/kop_surat.png';
        $ttd_kades = $row->signature_image;
        $stempel = 'assets/images/stempel.png';

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->SetTitle($this->data['module'] . ' a.n ' . $row->suami_name);
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
        $pdf->Cell(0, 7, 'SURAT KETERANGAN ASAL USUL PERNIKAHAN', 0, 1, 'C');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(0, 5, 'NOMOR : ' . $row->no_surat, 0, 1, 'C');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 6, '', 0, 1); //end of line

        //TODO Body Content
        $pdf->MultiCell(0, 8, '         Yang bertanda tangan di bawah ini Kepala Desa Saobi Kecamatan Kangayan Kabupaten Sumenep, menerangkan dengan sebenarnya bahwa :', 0, 'J');
        $pdf->Cell(50, 8, 'Nama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->SetFont('Calibrib', '', '12');
        $pdf->Cell(0, 8, strtoupper($row->suami_name), 0, 1, 'L');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(50, 8, 'Tempat / Tanggal Lahir', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->suami_birthplace . ', ' . datetime_indo4($row->suami_birthdate), 0, 1, 'L');
        $pdf->Cell(50, 8, 'Jenis kelamin', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $suami_gender, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Status perkawinan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->status_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Agama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->agama_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Kebangsaan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $kebangsaan_suami, 0, 1, 'L');
        $pdf->SetFont('Calibrib', '', '12');
        $pdf->Cell(0, 8, 'Adalah suami dari :', 0, 1, 'L');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(50, 8, 'Nama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->SetFont('Calibrib', '', '12');
        $pdf->Cell(0, 8, strtoupper($row->istri_name), 0, 1, 'L');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(50, 8, 'Tempat / Tanggal Lahir', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->istri_birthplace . ', ' . datetime_indo4($row->istri_birthdate), 0, 1, 'L');
        $pdf->Cell(50, 8, 'Jenis kelamin', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $istri_gender, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Status perkawinan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $status_istri->status_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Agama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $agama_istri->agama_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Kebangsaan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $kebangsaan_istri, 0, 1, 'L');

        $pdf->MultiCell(0, 8, 'Dan nama yang tersebut diatas tidak mempunyai Surat Nikah.', 0, 'J');
        $pdf->MultiCell(0, 8, 'Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya.', 0, 'J');

        $pdf->Cell(115);
        $pdf->SetFont('Arial', 'I', '12');
        if ($row->acc_at !== NULL) {
            $pdf->Cell(0, 8, 'Saobi, ' . date_indonesian_only($row->acc_at), 0, 1, 'L');
        } else {
            $pdf->Cell(0, 8, 'Saobi, ', 0, 1, 'L');
        }

        $pdf->Cell(20);
        $pdf->SetFont('Arial', '', '12');
        $pdf->Cell(85, 8, 'Yang bersangkutan', 0, 0, 'L');
        $pdf->Cell(0, 8, 'Kepala Desa Saobi', 0, 1, 'C');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 20, '', 0, 1); //end of line

        if (!empty($row->signature_image)) {
            //TODO Image
            $pdf->Image($stempel, 120, 218, 35, 35);
            $pdf->Image($ttd_kades, 140, 218, 35, 25);
        }

        $pdf->SetFont('Arial', 'BU', '12');
        $pdf->Cell(80, 8, strtoupper($row->suami_name), 0, 0, 'C');
        $pdf->Cell(65, 8, strtoupper($data_master->name), 0, 1, 'R');

        $pdf->Output('I', $this->data['module'] . ' a.n ' . $row->suami_name . '.pdf');
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
