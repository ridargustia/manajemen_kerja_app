<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_pindah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Pindah';

        $this->data['company_data']      = $this->Company_model->company_profile();
        $this->data['footer']            = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Kirim';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = $this->data['module'];
        $this->data['action']     = 'sk_pindah/create_action';

        //TODO Get data untuk dropdown reference
        $this->data['get_all_combobox_status'] = $this->Status_model->get_all_combobox();
        $this->data['get_all_combobox_agama'] = $this->Agama_model->get_all_combobox();
        $this->data['get_all_combobox_pekerjaan'] = $this->Pekerjaan_model->get_all_combobox();
        $this->data['get_all_combobox_pendidikan_akhir'] = $this->Pendidikan_akhir_model->get_all_combobox();

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
        $this->data['status'] = [
            'name'          => 'status',
            'id'            => 'status',
            'class'         => 'form-control',
            'required'      => '',
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
        $this->data['pekerjaan'] = [
            'name'          => 'pekerjaan',
            'id'            => 'pekerjaan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['pendidikan_akhir'] = [
            'name'          => 'pendidikan_akhir',
            'id'            => 'pendidikan_akhir',
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
        $this->data['alamat_pindah'] = [
            'name'          => 'alamat_pindah',
            'id'            => 'alamat_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['desa_pindah'] = [
            'name'          => 'desa_pindah',
            'id'            => 'desa_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['kecamatan_pindah'] = [
            'name'          => 'kecamatan_pindah',
            'id'            => 'kecamatan_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['kota_pindah'] = [
            'name'          => 'kota_pindah',
            'id'            => 'kota_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['kabupaten_pindah'] = [
            'name'          => 'kabupaten_pindah',
            'id'            => 'kabupaten_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['provinsi_pindah'] = [
            'name'          => 'provinsi_pindah',
            'id'            => 'provinsi_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['tgl_pindah'] = [
            'name'          => 'tgl_pindah',
            'id'            => 'tgl_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['alasan_pindah'] = [
            'name'          => 'alasan_pindah',
            'id'            => 'alasan_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['nik_pengikut'] = [
            'name'          => 'nik_pengikut[]',
            'id'            => 'nik_pengikut',
            'class'         => 'form-control',
            'placeholder'   => 'NIK',
        ];
        $this->data['pengikut_name'] = [
            'name'          => 'pengikut_name[]',
            'id'            => 'pengikut_name',
            'class'         => 'form-control',
            'placeholder'   => 'Nama',
        ];
        $this->data['keterangan'] = [
            'name'          => 'keterangan[]',
            'id'            => 'keterangan',
            'class'         => 'form-control',
            'placeholder'   => 'Keterangan',
        ];

        //TODO Load view dengan mengirim data
        $this->load->view('front/surat/create_sk_pindah', $this->data);
    }

    function create_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('status', 'Status Pernikahan', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('kebangsaan', 'Kebangsaan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('pendidikan_akhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('dusun', 'Dusun', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');

        $this->form_validation->set_rules('alamat_pindah', 'Alamat Pindah', 'required');
        $this->form_validation->set_rules('desa_pindah', 'Desa (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('kecamatan_pindah', 'Kecamatan (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('kota_pindah', 'Kota (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('kabupaten_pindah', 'Kabupaten (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('provinsi_pindah', 'Provinsi (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('tgl_pindah', 'Tanggal Pindah', 'required');
        $this->form_validation->set_rules('alasan_pindah', 'Alasan Pindah', 'required');

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
            redirect('sk_pindah/create');
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
                'phone'                 => $phone,
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'gender'                => $this->input->post('gender'),
                'status_id'             => $this->input->post('status'),
                'agama_id'              => $this->input->post('agama'),
                'kebangsaan'            => $this->input->post('kebangsaan'),
                'pekerjaan_id'          => $this->input->post('pekerjaan'),
                'pendidikan_akhir_id'   => $this->input->post('pendidikan_akhir'),
                'address'               => $address,
                'alamat_pindah'         => $this->input->post('alamat_pindah'),
                'desa_pindah'           => $this->input->post('desa_pindah'),
                'kecamatan_pindah'      => $this->input->post('kecamatan_pindah'),
                'kota_pindah'           => $this->input->post('kota_pindah'),
                'kabupaten_pindah'      => $this->input->post('kabupaten_pindah'),
                'provinsi_pindah'       => $this->input->post('provinsi_pindah'),
                'tgl_pindah'            => $this->input->post('tgl_pindah'),
                'alasan_pindah'         => $this->input->post('alasan_pindah'),
                'created_by'            => $this->session->username,
            );

            //TODO eksekusi query INSERT
            $this->Sk_pindah_model->insert($data);
            $sk_pindah_id = $this->db->insert_id();

            write_log();

            if (!empty($this->input->post('nik_pengikut')) and !empty($this->input->post('pengikut_name'))) {
                $count = count($this->input->post('nik_pengikut'));

                for ($i = 0; $i < $count; $i++) {
                    $data_sk_pindah_id[$i] = array(
                        'sk_pindah_id'      => $sk_pindah_id,
                        'nik_pengikut'      => $this->input->post('nik_pengikut[' . $i . ']'),
                        'pengikut_name'     => $this->input->post('pengikut_name[' . $i . ']'),
                        'keterangan'        => $this->input->post('keterangan[' . $i . ']'),
                    );

                    $this->db->insert('pengikut_sk_pindah', $data_sk_pindah_id[$i]);

                    write_log();
                }
            }

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('sk_pindah/create');
        }
    }

    function auth_download()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Authentikasi Download Dokumen';
        $this->data['action']     = 'sk_pindah/auth_download_action';

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
        $this->load->view('front/surat/auth_download_sk_pindah', $this->data);
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
            redirect('sk_pindah/auth_download');
        } else {
            $this->data['sk_pindah'] = $this->Sk_pindah_model->get_by_token($this->input->post('token'));

            if ($this->data['sk_pindah']) {
                $this->data['page_title'] = 'Download ' . $this->data['module'];
                $this->data['pengikut'] = $this->Sk_pindah_model->get_pengikut_by_id_sk_pindah($this->data['sk_pindah']->id_sk_pindah);

                $this->data['status'] = $this->Status_model->get_by_id($this->data['sk_pindah']->status_id);
                $this->data['agama'] = $this->Agama_model->get_by_id($this->data['sk_pindah']->agama_id);
                $this->data['pekerjaan'] = $this->Pekerjaan_model->get_by_id($this->data['sk_pindah']->pekerjaan_id);
                $this->data['pendidikan_akhir'] = $this->Pendidikan_akhir_model->get_by_id($this->data['sk_pindah']->pendidikan_akhir_id);

                $this->load->view('front/surat/download_sk_pindah', $this->data);
            } else {
                //TODO Tampilkan notifikasi dan redirect
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Akses gagal, silahkan hubungi Admin.</div>');
                redirect('sk_pindah/auth_download');
            }
        }
    }

    function preview_document($id_sk_pindah)
    {
        $row = $this->Sk_pindah_model->get_by_id_for_document($id_sk_pindah);
        $data_master = $this->Auth_model->get_by_usertype_master();

        $jml_pengikut = $this->Sk_pindah_model->total_rows_pengikut($id_sk_pindah);
        $data_pengikut = $this->Sk_pindah_model->get_pengikut_by_id_sk_pindah($id_sk_pindah);

        if ($row->gender === '1') {
            $gender = 'Laki-laki';
        } elseif ($row->gender === '2') {
            $gender = 'Perempuan';
        }

        if ($row->kebangsaan === '1') {
            $kebangsaan = 'Warga Negara Indonesia';
        } elseif ($row->kebangsaan === '2') {
            $kebangsaan = 'Warga Negara Asing';
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
        $pdf->Cell(0, 7, 'SURAT KETERANGAN PINDAH', 0, 1, 'C');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(0, 5, 'Nomor : ' . $row->no_surat, 0, 1, 'C');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 6, '', 0, 1); //end of line

        //TODO Body Content
        $pdf->Cell(0, 6, 'Diberikan kepada', 0, 1, 'L');
        $pdf->Cell(50, 6, 'Nama', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->SetFont('Calibrib', '', '12');
        $pdf->Cell(0, 6, strtoupper($row->name), 0, 1, 'L');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(50, 6, 'Tempat / Tanggal Lahir', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->birthplace . ', ' . datetime_indo4($row->birthdate), 0, 1, 'L');
        $pdf->Cell(50, 6, 'Jenis kelamin', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $gender, 0, 1, 'L');
        $pdf->Cell(50, 6, 'Status perkawinan', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->status_name, 0, 1, 'L');
        $pdf->Cell(50, 6, 'Agama', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->agama_name, 0, 1, 'L');
        $pdf->Cell(50, 6, 'Kebangsaan', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $kebangsaan, 0, 1, 'L');
        $pdf->Cell(50, 6, 'Pekerjaan', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->pekerjaan_name, 0, 1, 'L');
        $pdf->Cell(50, 6, 'Pendidikan Terakhir', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->pendidikan_akhir_name, 0, 1, 'L');
        $pdf->Cell(50, 6, 'Alamat', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->address, 0, 1, 'L');
        $pdf->Cell(50, 6, '', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, 'Saobi Kangayan Sumenep', 0, 1, 'L');
        $pdf->Cell(50, 6, 'No. KTP', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->nik, 0, 1, 'L');
        $pdf->Cell(50, 6, 'Pindah ke', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 1, 'C');
        $pdf->Cell(10);
        $pdf->Cell(40, 6, 'Alamat', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->alamat_pindah, 0, 1, 'L');
        $pdf->Cell(10);
        $pdf->Cell(40, 6, 'Desa/Kelurahan', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->desa_pindah, 0, 1, 'L');
        $pdf->Cell(10);
        $pdf->Cell(40, 6, 'Kecamatan', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->kecamatan_pindah, 0, 1, 'L');
        $pdf->Cell(10);
        $pdf->Cell(40, 6, 'Kota', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->kota_pindah, 0, 1, 'L');
        $pdf->Cell(10);
        $pdf->Cell(40, 6, 'Kabupaten', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->kabupaten_pindah, 0, 1, 'L');
        $pdf->Cell(10);
        $pdf->Cell(40, 6, 'Provinsi', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->provinsi_pindah, 0, 1, 'L');
        $pdf->Cell(50, 6, 'Pada Tanggal', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, date_indonesian_only($row->tgl_pindah), 0, 1, 'L');
        $pdf->Cell(50, 6, 'Alasan Pindah', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, $row->alasan_pindah, 0, 1, 'L');
        $pdf->Cell(50, 6, 'Pengikut', 0, 0, 'L');
        $pdf->Cell(5, 6, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 6, '(' . $jml_pengikut . ') Orang', 0, 1, 'L');

        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Nomor NIK', 1, 0, 'C');
        $pdf->Cell(70, 8, 'Nama', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Keterangan', 1, 1, 'C');
        $no = 1;
        foreach ($data_pengikut as $data) {
            $pdf->Cell(10, 8, $no++, 1, 0, 'C');
            $pdf->Cell(40, 8, $data->nik_pengikut, 1, 0, 'L');
            $pdf->Cell(70, 8, $data->pengikut_name, 1, 0, 'L');
            $pdf->Cell(40, 8, $data->keterangan, 1, 1, 'L');
        }

        $pdf->MultiCell(0, 8, 'Demikian surat keterangan pindah ini dibuat untuk dipergunakan sebagaimana mestinya.', 0, 'J');

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
        $pdf->Cell(0, 8, '', 0, 1); //end of line

        if (!empty($row->signature_image)) {
            //TODO Image
            $pdf->Cell(50, 6, $pdf->Image($stempel, $pdf->GetX() + 95, $pdf->GetY() - 15, 35, 35), 0, 1, 'C');
            $pdf->Cell(50, 6, $pdf->Image($ttd_kades, $pdf->GetX() + 118, $pdf->GetY() - 17, 35, 25), 0, 1, 'C');
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
