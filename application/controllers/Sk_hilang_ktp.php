<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_hilang_ktp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Kehilangan KTP';

        $this->data['company_data']      = $this->Company_model->company_profile();
        $this->data['footer']            = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Kirim';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Surat Keterangan Kehilangan KTP';
        $this->data['action']     = 'sk_hilang_ktp/create_action';

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
        $this->data['gender'] = [
            'name'          => 'gender',
            'id'            => 'gender',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['gender_value'] = [
            '0'             => '- Pilih Jenis Kelamin -',
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
            'autocomplete'  => 'off',
            'rows'          => '2',
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
            'required'      => '',
        ];

        $this->load->view('front/surat/create_sk_hilang_ktp', $this->data);
    }

    function create_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('status', 'Status Pernikahan', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('tempat_kehilangan', 'Tempat Kehilangan', 'required');
        $this->form_validation->set_rules('tgl_kehilangan', 'Tanggal Kehilangan', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        //?Apakah validasi gagal?
        if ($this->form_validation->run() === FALSE) {
            //TODO Kondisi validasi gagal, redirect ke halaman create
            $this->create();
        } else {
            //TODO Simpan data ke array
            $data = array(
                'name'                  => $this->input->post('name'),
                'nik'                   => $this->input->post('nik'),
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'gender'                => $this->input->post('gender'),
                'status_id'             => $this->input->post('status'),
                'agama_id'              => $this->input->post('agama'),
                'pekerjaan_id'          => $this->input->post('pekerjaan'),
                'address'               => $this->input->post('address'),
                'tempat_kehilangan'     => $this->input->post('tempat_kehilangan'),
                'tgl_kehilangan'        => $this->input->post('tgl_kehilangan'),
            );

            //TODO Post to database with model
            $this->Sk_hilang_ktp_model->insert($data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('sk_hilang_ktp/create');
        }
    }
}
