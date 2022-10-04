<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_hilang_ktp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Kehilangan KTP';

        // $this->load->model(array('Skck_model'));

        $this->data['company_data']             = $this->Company_model->company_profile();
        $this->data['layout_template']          = $this->Template_model->layout();
        $this->data['skins_template']           = $this->Template_model->skins();
        $this->data['footer']                   = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Simpan';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['add_action'] = base_url('admin/sk_hilang_ktp/create');

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

        //TODO Get data SK Hilang KTP dari database
        if (is_masteradmin()) {
            $this->data['get_all'] = $this->Sk_hilang_ktp_model->get_all_by_numbering();
        } elseif (is_superadmin() or is_grandadmin()) {
            $this->data['get_all'] = $this->Sk_hilang_ktp_model->get_all();
        }

        $this->load->view('back/sk_hilang_ktp/sk_hilang_ktp_list', $this->data);
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = $this->data['module'];
        $this->data['action']     = 'admin/sk_hilang_ktp/create_action';

        //TODO Get data untuk dropdown reference
        $this->data['get_all_combobox_status'] = $this->Status_model->get_all_combobox();
        $this->data['get_all_combobox_agama'] = $this->Agama_model->get_all_combobox();
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
            'required'      => '',
        ];
        $this->data['rt'] = [
            'name'          => 'rt',
            'id'            => 'rt',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['rw'] = [
            'name'          => 'rw',
            'id'            => 'rw',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['tempat_kehilangan'] = [
            'name'          => 'tempat_kehilangan',
            'id'            => 'tempat_kehilangan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['tgl_kehilangan'] = [
            'name'          => 'tgl_kehilangan',
            'id'            => 'tgl_kehilangan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];

        $this->load->view('back/sk_hilang_ktp/sk_hilang_ktp_add', $this->data);
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
        $this->form_validation->set_rules('status', 'Status Pernikahan', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('dusun', 'Dusun', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required|is_numeric');
        $this->form_validation->set_rules('rt', 'RT', 'required|is_numeric');
        $this->form_validation->set_rules('tempat_kehilangan', 'Tempat Kehilangan', 'required');
        $this->form_validation->set_rules('tgl_kehilangan', 'Tanggal Kehilangan', 'required');

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
            redirect('admin/sk_hilang_ktp/create');
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
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'phone'                 => $phone,
                'gender'                => $this->input->post('gender'),
                'status_id'             => $this->input->post('status'),
                'agama_id'              => $this->input->post('agama'),
                'pekerjaan_id'          => $this->input->post('pekerjaan'),
                'address'               => $address,
                'tempat_kehilangan'     => $this->input->post('tempat_kehilangan'),
                'tgl_kehilangan'        => $this->input->post('tgl_kehilangan'),
                'created_by'            => $this->session->username,
            );

            //TODO Post to database with model
            $this->Sk_hilang_ktp_model->insert($data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_hilang_ktp');
        }
    }

    function update($id_sk_hilang_ktp)
    {
        is_update();

        //TODO Get by id data sk_hilang_ktp
        $this->data['sk_hilang_ktp']     = $this->Sk_hilang_ktp_model->get_by_id($id_sk_hilang_ktp);

        //TODO Jika sk_hilang_ktp ditemukan
        if ($this->data['sk_hilang_ktp']) {
            //TODO Inisialisasi variabel
            $this->data['page_title'] = 'Update Data ' . $this->data['module'];
            $this->data['action']     = 'admin/sk_hilang_ktp/update_action';

            //TODO Get data untuk dropdown reference
            $this->data['get_all_combobox_status'] = $this->Status_model->get_all_combobox();
            $this->data['get_all_combobox_agama'] = $this->Agama_model->get_all_combobox();
            $this->data['get_all_combobox_pekerjaan'] = $this->Pekerjaan_model->get_all_combobox();

            //TODO Rancangan form
            $this->data['id_sk_hilang_ktp'] = [
                'name'          => 'id_sk_hilang_ktp',
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
            $this->data['pekerjaan'] = [
                'name'          => 'pekerjaan',
                'id'            => 'pekerjaan',
                'class'         => 'form-control',
                'required'      => '',
            ];
            $this->data['address'] = [
                'name'          => 'address',
                'id'            => 'address',
                'class'         => 'form-control',
                'required'      => '',
            ];
            $this->data['tempat_kehilangan'] = [
                'name'          => 'tempat_kehilangan',
                'id'            => 'tempat_kehilangan',
                'class'         => 'form-control',
                'required'      => '',
            ];
            $this->data['tgl_kehilangan'] = [
                'name'          => 'tgl_kehilangan',
                'id'            => 'tgl_kehilangan',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
            ];

            $this->load->view('back/sk_hilang_ktp/sk_hilang_ktp_edit', $this->data);
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_hilang_ktp');
        }
    }

    function update_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'is_numeric|required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('status', 'Status Pernikahan', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('tempat_kehilangan', 'Tempat Kehilangan', 'required');
        $this->form_validation->set_rules('tgl_kehilangan', 'Tanggal Kehilangan', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');
        $this->form_validation->set_message('is_numeric', '{field} harus angka');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        //TODO Jika data tidak lolos validasi
        if ($this->form_validation->run() === FALSE) {
            $this->update($this->input->post('id_sk_hilang_ktp'));
        } else {
            $data = array(
                'name'                  => $this->input->post('name'),
                'nik'                   => $this->input->post('nik'),
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'phone'                 => $this->input->post('phone'),
                'gender'                => $this->input->post('gender'),
                'status_id'             => $this->input->post('status'),
                'agama_id'              => $this->input->post('agama'),
                'pekerjaan_id'          => $this->input->post('pekerjaan'),
                'address'               => $this->input->post('address'),
                'tempat_kehilangan'     => $this->input->post('tempat_kehilangan'),
                'tgl_kehilangan'        => $this->input->post('tgl_kehilangan'),
                'modified_by'           => $this->session->username,
            );

            //TODO Jalankan proses update
            $this->Sk_hilang_ktp_model->update($this->input->post('id_sk_hilang_ktp'), $data);

            write_log();

            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_hilang_ktp');
        }
    }

    function delete($id_sk_hilang_ktp)
    {
        is_delete();

        //TODO Get sk hilang ktp by id
        $delete = $this->Sk_hilang_ktp_model->get_by_id($id_sk_hilang_ktp);

        //TODO Jika data sk hilang ktp ditemukan
        if ($delete) {
            $data = array(
                'is_delete'   => '1',
                'deleted_by'  => $this->session->username,
                'deleted_at'  => date('Y-m-d H:i:a'),
            );

            //TODO Jalankan proses softdelete
            $this->Sk_hilang_ktp_model->soft_delete($id_sk_hilang_ktp, $data);

            write_log();

            //TODO Kirim notifikasi berhasil dihapus
            $this->session->set_flashdata('message', 'dihapus');
            redirect('admin/sk_hilang_ktp');
        } else {
            //TODO Kirim notifikasi data tidak ditemukan
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_hilang_ktp');
        }
    }

    function numbering($id_sk_hilang_ktp)
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Penomoran ' . $this->data['module'];
        $this->data['action']     = 'admin/sk_hilang_ktp/numbering_action';

        //TODO Rancangan form
        $this->data['id_sk_hilang_ktp'] = [
            'name'          => 'id_sk_hilang_ktp',
            'type'          => 'hidden',
        ];
        $this->data['no_surat'] = [
            'name'          => 'no_surat',
            'id'            => 'no_surat',
            'class'         => 'form-control',
            'required'      => '',
        ];

        //TODO Get detail sk_hilang_ktp by id
        $this->data['data_sk_hilang_ktp'] = $this->Sk_hilang_ktp_model->get_by_id($id_sk_hilang_ktp);
        $this->data['status'] = $this->Status_model->get_by_id($this->data['data_sk_hilang_ktp']->status_id);
        $this->data['agama'] = $this->Agama_model->get_by_id($this->data['data_sk_hilang_ktp']->agama_id);
        $this->data['pekerjaan'] = $this->Pekerjaan_model->get_by_id($this->data['data_sk_hilang_ktp']->pekerjaan_id);

        //TODO Load view dengan mengirim data
        $this->load->view('back/sk_hilang_ktp/sk_hilang_ktp_numbering', $this->data);
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
            redirect('admin/sk_hilang_ktp/numbering/' . $this->input->post('id_sk_hilang_ktp'));
        } else {
            //TODO Simpan data ke array
            $data = array(
                'no_surat'              => $this->input->post('no_surat'),
                'is_readed'             => '1',
                'numbered_by'           => $this->session->username,
                'numbered_at'           => date('Y-m-d H:i:a'),
            );

            //TODO Post to database with model
            $this->Sk_hilang_ktp_model->update($this->input->post('id_sk_hilang_ktp'), $data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_hilang_ktp/numbering/' . $this->input->post('id_sk_hilang_ktp'));
        }
    }

    function delete_permanent($id_sk_hilang_ktp)
    {
        is_delete();

        //TODO Get data sk_hilang_ktp by id
        $delete = $this->Sk_hilang_ktp_model->get_by_id($id_sk_hilang_ktp);

        //TODO Jika data sk_hilang_ktp yg akan dihapus ditemukan
        if ($delete) {
            //TODO Jalankan proses delete dengan model
            $this->Sk_hilang_ktp_model->delete($id_sk_hilang_ktp);

            write_log();

            //TODO Kirim notifikasi berhasil dihapus permanen
            $this->session->set_flashdata('message', 'dihapus');
            redirect('admin/sk_hilang_ktp/deleted_list');
        } else {
            //TODO Kirim notifikasi data tidak ditemukan
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_hilang_ktp');
        }
    }

    function deleted_list()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

        //TODO Get data Sk_hilang_ktp dari database
        if (is_masteradmin()) {
            $this->data['get_all'] = $this->Sk_hilang_ktp_model->get_all_deleted_for_masteradmin();
        } elseif (is_superadmin() or is_grandadmin()) {
            $this->data['get_all'] = $this->Sk_hilang_ktp_model->get_all_deleted();
        }

        $this->load->view('back/sk_hilang_ktp/sk_hilang_ktp_deleted_list', $this->data);
    }

    function restore($id_sk_hilang_ktp)
    {
        is_restore();

        //TODO Get data sk_hilang_ktp by id
        $row = $this->Sk_hilang_ktp_model->get_by_id($id_sk_hilang_ktp);

        //TODO Jika data ditemukan
        if ($row) {
            $data = array(
                'is_delete'   => '0',
                'deleted_by'  => NULL,
                'deleted_at'  => NULL,
            );

            //TODO Jalankan proses update dengan model
            $this->Sk_hilang_ktp_model->update($id_sk_hilang_ktp, $data);

            write_log();

            //TODO Kirim notifikasi data berhasil dikembalikan
            $this->session->set_flashdata('message', 'dikembalikan');
            redirect('admin/sk_hilang_ktp/deleted_list');
        } else {
            //TODO Kirim notifikasi data tidak ditemukan
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_hilang_ktp');
        }
    }

    function preview_document($id_sk_hilang_ktp)
    {
        $row = $this->Sk_hilang_ktp_model->get_by_id_for_document($id_sk_hilang_ktp);
        $data_master = $this->Auth_model->get_by_usertype_master();

        if ($row->gender === '1') {
            $gender = 'Laki-laki';
        } elseif ($row->gender === '2') {
            $gender = 'Perempuan';
        }

        require FCPATH . '/vendor/autoload.php';
        require FCPATH . '/vendor/setasign/fpdf/fpdf.php';

        $image = FCPATH . 'assets\images\kop_surat.png';
        $ttd_kades = base_url($row->signature_image);
        $stempel = base_url('assets/images/stempel.png');

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
        $pdf->Cell(0, 7, 'SURAT KETERANGAN KEHILANGAN KTP', 0, 1, 'C');
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
        $pdf->Cell(50, 8, 'Status', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->status_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Jenis kelamin', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $gender, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Agama', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->agama_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Pekerjaan', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->pekerjaan_name, 0, 1, 'L');
        $pdf->Cell(50, 8, 'Alamat', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->address, 0, 1, 'L');
        $pdf->Cell(50, 8, '', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, 'Desa Saobi Kec.Kangayan Kab. Sumenep', 0, 1, 'L');
        $pdf->Cell(50, 8, 'No. NIK', 0, 0, 'L');
        $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
        $pdf->Cell(0, 8, $row->nik, 0, 1, 'L');

        $pdf->MultiCell(0, 8, '         Adalah benar-benar penduduk Desa Saobi yang kehilangan KTP di ' . $row->address . ' Desa Saobi Kangayan pada tanggal ' . date_indonesian_only($row->tgl_kehilangan) . '.', 0, 'J');
        $pdf->MultiCell(0, 8, '     Demikian surat keterangan ini kami buat dengan sebenarnya dan diberikan kepada yang bersangkutan guna untuk digunakan seperlunya.', 0, 'J');

        $pdf->Cell(115);
        $pdf->SetFont('Arial', 'I', '12');
        if ($row->acc_at !== NULL) {
            $pdf->Cell(0, 8, 'Saobi, ' . date_indonesian_only($row->acc_at), 0, 1, 'L');
        } else {
            $pdf->Cell(0, 8, 'Saobi, ', 0, 1, 'L');
        }

        $pdf->Cell(115);
        $pdf->SetFont('Arial', '', '12');
        $pdf->Cell(0, 8, 'Mengetahui,', 0, 1, 'L');

        $pdf->Cell(20);
        $pdf->Cell(85, 8, 'Yang bersangkutan', 0, 0, 'L');
        $pdf->Cell(0, 8, 'Kepala Desa Saobi', 0, 1, 'C');

        //TODO make a dummy empty cell as a vertical spacer
        $pdf->Cell(0, 20, '', 0, 1); //end of line

        if (!empty($row->signature_image)) {
            //TODO Image
            $pdf->Image($stempel, 120, 226, 35, 35);
            $pdf->Image($ttd_kades, 140, 226, 35, 25);
        }

        $pdf->SetFont('Arial', 'BU', '12');
        $pdf->Cell(80, 8, strtoupper($row->name), 0, 0, 'C');
        $pdf->Cell(65, 8, strtoupper($data_master->name), 0, 1, 'R');

        $pdf->Output('I', $this->data['module'] . ' a.n ' . $row->name . '.pdf');
    }

    function signature($id_sk_hilang_ktp)
    {
        //TODO Authentikasi hak akses usertype
        if (is_superadmin()) {
            $this->session->set_flashdata('message', 'tidak memiliki akses');
            redirect('admin/dashboard');
        }

        //TODO Get data sk_hilang_ktp by id
        $this->data['sk_hilang_ktp'] = $this->Sk_hilang_ktp_model->get_by_id($id_sk_hilang_ktp);

        //TODO Cek apakah data sk_hilang_ktp ada
        if ($this->data['sk_hilang_ktp']) {
            //TODO Inisialisasi variabel
            $this->data['page_title'] = 'ACC Dokumen ' . $this->data['module'];

            //TODO Rancangan form
            $this->data['id_sk_hilang_ktp'] = [
                'name'          => 'id_sk_hilang_ktp',
                'id'            => 'id_sk_hilang_ktp',
                'type'          => 'hidden',
            ];

            //TODO load view tampilan signature
            $this->load->view('back/sk_hilang_ktp/sk_hilang_ktp_signature', $this->data);
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_hilang_ktp');
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
        $this->Sk_hilang_ktp_model->update($this->input->post('id_sk_hilang_ktp'), $data);

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
