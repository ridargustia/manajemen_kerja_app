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

        $this->data['btn_submit'] = 'Submit';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        $this->data['page_title'] = 'Surat Keterangan Nikah';

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
        $this->data['gender_value'] = [
            '0'             => '',
            '1'             => 'Laki-laki',
            '2'             => 'Perempuan',
        ];
        $this->data['status_value'] = [
            '0'             => '',
            '1'             => 'Belum Kawin',
            '2'             => 'Kawin',
            '3'             => 'Cerai Hidup',
            '4'             => 'Cerai Mati',
        ];
        $this->data['agama_value'] = [
            '0'             => '',
            '1'             => 'Islam',
            '2'             => 'Kristen Protestan',
            '3'             => 'Kristen Katolik',
            '4'             => 'Buddha',
            '5'             => 'Hindu',
            '6'             => 'Konghucu',
        ];
        $this->data['kebangsaan_value'] = [
            '0'             => '',
            '1'             => 'Warga Negara Indonesia',
            '2'             => 'Warga Negara Asing',
        ];

        $this->load->view('front/surat/create_sk_nikah', $this->data);
    }
}
