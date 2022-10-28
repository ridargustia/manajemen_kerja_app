<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_pernyataan_miskin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Pernyataan Miskin';

        $this->data['company_data']             = $this->Company_model->company_profile();
        $this->data['layout_template']          = $this->Template_model->layout();
        $this->data['skins_template']           = $this->Template_model->skins();
        $this->data['footer']                   = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Simpan';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['add_action'] = base_url('admin/surat_pernyataan_miskin/create');

        is_login();

        //TODO Autentikasi hak akses user
        if ($this->uri->segment(2) != NULL) {
            menuaccess_check();
        } elseif ($this->uri->segment(3) != NULL) {
            submenuaccess_check();
        }
    }

    function index()
    {
        //TODO Authentication hak akses usertype
        is_read();

        //TODO Inisialisasi variabel judul
        $this->data['page_title'] = 'Data ' . $this->data['module'];

        //TODO Get data Surat Pernyataan Miskin dari database
        if (is_masteradmin()) {
            $this->data['get_all'] = $this->Surat_pernyataan_miskin_model->get_all_by_numbering();
        } elseif (is_superadmin() or is_grandadmin()) {
            $this->data['get_all'] = $this->Surat_pernyataan_miskin_model->get_all();
        }

        $this->load->view('back/surat_pernyataan_miskin/surat_pernyataan_miskin_list', $this->data);
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = $this->data['module'];
        $this->data['action']     = 'admin/surat_pernyataan_miskin/create_action';

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
        $this->data['agama'] = [
            'name'          => 'agama',
            'id'            => 'agama',
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

        //TODO Load view dengan mengirim data
        $this->load->view('back/surat_pernyataan_miskin/surat_pernyataan_miskin_add', $this->data);
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
        $this->form_validation->set_rules('kebangsaan', 'Kebangsaan', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('dusun', 'Dusun', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');

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
            redirect('admin/surat_pernyataan_miskin/create');
        } else {
            //TODO Ubah Format phone number +62
            $selection_phone = substr($this->input->post('phone'), '1');
            $phone = '62' . $selection_phone;

            //TODO Format address
            $address = 'Dusun ' . $this->input->post('dusun') . ' RT. ' . $this->input->post('rt') . ' /RW. ' . $this->input->post('rw');

            //TODO Simpan data ke array
            $data = array(
                'name'                  => $this->input->post('name'),
                'nik'                   => $this->input->post('nik'),
                'phone'                 => $phone,
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'gender'                => $this->input->post('gender'),
                'kebangsaan'            => $this->input->post('kebangsaan'),
                'agama_id'              => $this->input->post('agama'),
                'address'               => $address,
                'created_by'            => $this->session->username,
            );

            //TODO Post to database with model
            $this->Surat_pernyataan_miskin_model->insert($data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/surat_pernyataan_miskin');
        }
    }

    function update($id_surat_pernyataan_miskin)
    {
        is_update();

        //TODO Get by id data surat_pernyataan_miskin
        $this->data['surat_pernyataan_miskin']     = $this->Surat_pernyataan_miskin_model->get_by_id($id_surat_pernyataan_miskin);

        //TODO Jika surat_pernyataan_miskin ditemukan
        if ($this->data['surat_pernyataan_miskin']) {
            //TODO Inisialisasi variabel
            $this->data['page_title'] = 'Update Data ' . $this->data['module'];
            $this->data['action']     = 'admin/surat_pernyataan_miskin/update_action';

            //TODO Get data untuk dropdown reference
            $this->data['get_all_combobox_agama'] = $this->Agama_model->get_all_combobox();

            //TODO Rancangan form
            $this->data['id_surat_pernyataan_miskin'] = [
                'name'          => 'id_surat_pernyataan_miskin',
                'type'          => 'hidden',
            ];
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
            $this->data['agama'] = [
                'name'          => 'agama',
                'id'            => 'agama',
                'class'         => 'form-control',
                'required'      => '',
            ];
            $this->data['address'] = [
                'name'          => 'address',
                'id'            => 'address',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
            ];

            $this->load->view('back/surat_pernyataan_miskin/surat_pernyataan_miskin_edit', $this->data);
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/surat_pernyataan_miskin');
        }
    }

    function update_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('kebangsaan', 'Kebangsaan', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');
        $this->form_validation->set_message('is_numeric', '{field} harus angka');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        //TODO Jika data tidak lolos validasi
        if ($this->form_validation->run() === FALSE) {
            $this->update($this->input->post('id_surat_pernyataan_miskin'));
        } else {
            $data = array(
                'name'                  => $this->input->post('name'),
                'nik'                   => $this->input->post('nik'),
                'phone'                 => $this->input->post('phone'),
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'gender'                => $this->input->post('gender'),
                'kebangsaan'            => $this->input->post('kebangsaan'),
                'agama_id'              => $this->input->post('agama'),
                'address'               => $this->input->post('address'),
                'modified_by'           => $this->session->username,
            );

            //TODO Jalankan proses update
            $this->Surat_pernyataan_miskin_model->update($this->input->post('id_surat_pernyataan_miskin'), $data);

            write_log();

            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/surat_pernyataan_miskin');
        }
    }

    function delete($id_surat_pernyataan_miskin)
    {
        is_delete();

        //TODO Get surat_pernyataan_miskin by id
        $delete = $this->Surat_pernyataan_miskin_model->get_by_id($id_surat_pernyataan_miskin);

        //TODO Jika data surat_pernyataan_miskin ditemukan
        if ($delete) {
            $data = array(
                'is_delete'   => '1',
                'deleted_by'  => $this->session->username,
                'deleted_at'  => date('Y-m-d H:i:a'),
            );

            //TODO Jalankan proses softdelete
            $this->Surat_pernyataan_miskin_model->soft_delete($id_surat_pernyataan_miskin, $data);

            write_log();

            //TODO Kirim notifikasi berhasil dihapus
            $this->session->set_flashdata('message', 'dihapus');
            redirect('admin/surat_pernyataan_miskin');
        } else {
            //TODO Kirim notifikasi data tidak ditemukan
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/surat_pernyataan_miskin');
        }
    }

    function numbering($id_surat_pernyataan_miskin)
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Penomoran ' . $this->data['module'];
        $this->data['action']     = 'admin/surat_pernyataan_miskin/numbering_action';

        //TODO Rancangan form
        $this->data['id_surat_pernyataan_miskin'] = [
            'name'          => 'id_surat_pernyataan_miskin',
            'type'          => 'hidden',
        ];
        $this->data['no_surat'] = [
            'name'          => 'no_surat',
            'id'            => 'no_surat',
            'class'         => 'form-control',
            'required'      => '',
        ];

        //TODO Get detail surat_pernyataan_miskin by id
        $this->data['data_surat_pernyataan_miskin'] = $this->Surat_pernyataan_miskin_model->get_by_id($id_surat_pernyataan_miskin);

        $this->data['agama'] = $this->Agama_model->get_by_id($this->data['data_surat_pernyataan_miskin']->agama_id);

        //TODO Load view dengan mengirim data
        $this->load->view('back/surat_pernyataan_miskin/surat_pernyataan_miskin_numbering', $this->data);
    }

    function numbering_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('no_surat', 'No Surat', 'required');
        $this->form_validation->set_message('required', '{field} wajib diisi');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        //?Apakah validasi gagal?
        if ($this->form_validation->run() === FALSE) {
            //TODO Kondisi validasi gagal, redirect ke halaman create
            redirect('admin/surat_pernyataan_miskin/numbering/' . $this->input->post('id_surat_pernyataan_miskin'));
        } else {
            //TODO Simpan data ke array
            $data = array(
                'no_surat'              => $this->input->post('no_surat'),
                'is_readed'             => '1',
                'numbered_by'           => $this->session->username,
                'numbered_at'           => date('Y-m-d H:i:a'),
            );

            //TODO Post to database with model
            $this->Surat_pernyataan_miskin_model->update($this->input->post('id_surat_pernyataan_miskin'), $data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/surat_pernyataan_miskin/numbering/' . $this->input->post('id_surat_pernyataan_miskin'));
        }
    }

    function delete_permanent($id_surat_pernyataan_miskin)
    {
        is_delete();

        //TODO Get data surat_pernyataan_miskin by id
        $delete = $this->Surat_pernyataan_miskin_model->get_by_id($id_surat_pernyataan_miskin);

        //TODO Jika data surat_pernyataan_miskin yg akan dihapus ditemukan
        if ($delete) {
            //TODO Jalankan proses delete dengan model
            $this->Surat_pernyataan_miskin_model->delete($id_surat_pernyataan_miskin);

            write_log();

            //TODO Kirim notifikasi berhasil dihapus permanen
            $this->session->set_flashdata('message', 'dihapus');
            redirect('admin/surat_pernyataan_miskin/deleted_list');
        } else {
            //TODO Kirim notifikasi data tidak ditemukan
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/surat_pernyataan_miskin');
        }
    }

    function deleted_list()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

        //TODO Get data Surat Pernyataan Miskin dari database
        if (is_masteradmin()) {
            $this->data['get_all'] = $this->Surat_pernyataan_miskin_model->get_all_deleted_for_masteradmin();
        } elseif (is_superadmin() or is_grandadmin()) {
            $this->data['get_all'] = $this->Surat_pernyataan_miskin_model->get_all_deleted();
        }

        $this->load->view('back/surat_pernyataan_miskin/surat_pernyataan_miskin_deleted_list', $this->data);
    }

    function restore($id_surat_pernyataan_miskin)
    {
        is_restore();

        //TODO Get data surat_pernyataan_miskin by id
        $row = $this->Surat_pernyataan_miskin_model->get_by_id($id_surat_pernyataan_miskin);

        //TODO Jika data ditemukan
        if ($row) {
            $data = array(
                'is_delete'   => '0',
                'deleted_by'  => NULL,
                'deleted_at'  => NULL,
            );

            //TODO Jalankan proses update dengan model
            $this->Surat_pernyataan_miskin_model->update($id_surat_pernyataan_miskin, $data);

            write_log();

            //TODO Kirim notifikasi data berhasil dikembalikan
            $this->session->set_flashdata('message', 'dikembalikan');
            redirect('admin/surat_pernyataan_miskin/deleted_list');
        } else {
            //TODO Kirim notifikasi data tidak ditemukan
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/surat_pernyataan_miskin');
        }
    }

    function preview_document($id_surat_pernyataan_miskin)
    {
        $row = $this->Surat_pernyataan_miskin_model->get_by_id_for_document($id_surat_pernyataan_miskin);
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
        $pdf->Cell(0, 7, 'SURAT PERNYATAAN MISKIN', 0, 1, 'C');
        $pdf->SetFont('Calibri', '', '12');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 6, '', 0, 1); //end of line

        //TODO Body Content
        $pdf->Cell(0, 8, 'Yang bertanda tangan di bawah ini:', 0, 1, 'L');
        $pdf->Cell(50, 8, 'Nama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->SetFont('Calibrib', '', '12');
        $pdf->Cell(0, 8, strtoupper($row->name), 0, 1, 'L');
        $pdf->SetFont('Calibri', '', '12');
        $pdf->Cell(50, 8, 'NIK', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->nik, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Tempat / Tanggal Lahir', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->birthplace . ', ' . datetime_indo4($row->birthdate), 0, 1, 'L');
        $pdf->Cell(50, 8, 'Jenis kelamin', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $gender, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Kewarganegaraan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $kebangsaan, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Agama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->agama_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Tempat Tinggal', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->address, 0, 1, 'L');
        $pdf->Cell(50, 8, '', 0, 0, 'L');
        $pdf->Cell(5, 8, '', 0, 0, 'C');
        $pdf->Cell(0, 8, 'Desa Saobi Kec. Kangayan Kab. Sumenep', 0, 1, 'L');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 6, '', 0, 1); //end of line

        $pdf->MultiCell(0, 8, '     Dengan ini menyatakan dengan sebenarnya bahwa saya sungguh-sungguh sebagai masyarakat miskin yang tidak mempunyai kartu Jamkesmas dan Jamkesda Provinsi Jawa Timur.', 0, 'J');
        $pdf->MultiCell(0, 8, '     Demikian pernyataan miskin ini dibuat dengan sebenarnya, dan apabila dikemudian hari pernyataan tersebut tidak benar, maka saya bersedia diberi sangsi sesuai ketentuan yang berlaku.', 0, 'J');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 15, '', 0, 1); //end of line

        $pdf->Cell(105, 8, 'Nomor : ' . $row->no_surat, 0, 0, 'L');
        $pdf->SetFont('Arial', 'I', '12');
        if ($row->acc_at !== NULL) {
            $pdf->Cell(0, 8, 'Saobi, ' . date_indonesian_only($row->acc_at), 0, 1, 'L');
        } else {
            $pdf->Cell(0, 8, 'Saobi, ', 0, 1, 'L');
        }

        $pdf->SetFont('Arial', '', '12');
        $pdf->Cell(80, 8, 'Mengetahui,', 0, 1, 'C');

        $pdf->Cell(80, 8, 'Kepala Desa Saobi', 0, 0, 'C');
        $pdf->Cell(0, 8, 'Yang membuat pernyataan', 0, 1, 'R');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 8, '', 0, 1); //end of line

        if (!empty($row->signature_image)) {
            //TODO Image
            $pdf->Cell(50, 6, $pdf->Image($stempel, $pdf->GetX() + 0, $pdf->GetY() - 15, 35, 35), 0, 1, 'C');
            $pdf->Cell(50, 6, $pdf->Image($ttd_kades, $pdf->GetX() + 23, $pdf->GetY() - 17, 35, 25), 0, 1, 'C');
        }

        $pdf->SetFont('Arial', 'BU', '12');
        $pdf->Cell(80, 8, strtoupper($data_master->name), 0, 0, 'C');
        $pdf->Cell(13, 8, '', 0, 0, 'C');
        $pdf->Cell(80, 8, strtoupper($row->name), 0, 1, 'C');

        $pdf->Output('I', $this->data['module'] . ' a.n ' . $row->name . '.pdf');
    }

    function signature($id_surat_pernyataan_miskin)
    {
        //TODO Authentikasi hak akses usertype
        if (is_superadmin()) {
            $this->session->set_flashdata('message', 'tidak memiliki akses');
            redirect('admin/dashboard');
        }

        //TODO Get data surat_pernyataan_miskin by id
        $this->data['surat_pernyataan_miskin'] = $this->Surat_pernyataan_miskin_model->get_by_id($id_surat_pernyataan_miskin);

        //TODO Cek apakah data surat_pernyataan_miskin ada
        if ($this->data['surat_pernyataan_miskin']) {
            //TODO Inisialisasi variabel
            $this->data['page_title'] = 'ACC Dokumen ' . $this->data['module'];

            //TODO Rancangan form
            $this->data['id_surat_pernyataan_miskin'] = [
                'name'          => 'id_surat_pernyataan_miskin',
                'id'            => 'id_surat_pernyataan_miskin',
                'type'          => 'hidden',
            ];

            //TODO load view tampilan signature
            $this->load->view('back/surat_pernyataan_miskin/surat_pernyataan_miskin_signature', $this->data);
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/surat_pernyataan_miskin');
        }
    }

    function signature_action()
    {
        //TODO Dekripsi chipertext dengan metode base64
        $data = base64_decode($this->input->post('image'));

        //TODO Set direktori tempat menyimpan tanda tangan
        $file = './assets/signature_images/' . uniqid() . '.png';
        //TODO Jalankan proses penyimpanan file image ke direktori
        file_put_contents($file, $data);

        //TODO Hilangkan karakter './' pada variabel direktori file
        $image = str_replace('./', '', $file);

        //TODO Simpan pada array
        $data = array(
            'signature_image'       => $image,
            'is_readed_masteradmin' => '1',
            'token'                 => substr(md5(random_bytes(10)), 0, 10),
            'acc_by'                => $this->session->username,
            'acc_at'                => date('Y-m-d H:i:a'),
        );

        //TODO Jalankan proses update
        $this->Surat_pernyataan_miskin_model->update($this->input->post('id_surat_pernyataan_miskin'), $data);

        write_log();

        $this->session->set_flashdata('message', 'Sukses');
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
