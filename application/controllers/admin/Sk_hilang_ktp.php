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

    function check_format_phone()
    {
        $phone = $this->input->post('phone');
        $check_phone = substr($phone, '0', '2');

        if ($check_phone != '08') {
            // var_dump($check_phone);
            echo "<div class='text-red'>Format penulisan no HP/Telephone tidak valid</div>";
        }
    }
}
