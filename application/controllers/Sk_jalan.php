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

        $this->data['btn_submit'] = 'Submit';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        $this->data['page_title'] = 'Surat Keterangan Jalan';

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
            '0'             => '',
            '1'             => 'Laki-laki',
            '2'             => 'Perempuan',
        ];
        $this->data['agama'] = [
            'name'          => 'agama',
            'id'            => 'agama',
            'class'         => 'form-control',
            'required'      => '',
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
        $this->data['kebangsaan'] = [
            'name'          => 'kebangsaan',
            'id'            => 'kebangsaan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kebangsaan_value'] = [
            '0'             => '',
            '1'             => 'Warga Negara Indonesia',
            '2'             => 'Warga Negara Asing',
        ];
        $this->data['address'] = [
            'name'          => 'address',
            'id'            => 'address',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'rows'          => '2',
            'required'      => '',
        ];
        $this->data['kepentingan'] = [
            'name'          => 'kepentingan',
            'id'            => 'kepentingan',
            'class'         => 'form-control',
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
}
