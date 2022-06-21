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
            '0'             => '- Pilih Jenis Kelamin -',
            '1'             => 'Laki-laki',
            '2'             => 'Perempuan',
        ];
        $this->data['kebangsaan_value'] = [
            '0'             => '- Pilih Kebangsaan -',
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

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        //?Apakah validasi gagal?
        if ($this->form_validation->run() === FALSE) {
            //TODO Kondisi validasi gagal, redirect ke halaman create
            $this->create();
        } else {
            //TODO Simpan data ke array
            $data = array(
                'suami_name'            => $this->input->post('suami_name'),
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
}
