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

        $this->data['btn_submit'] = 'Submit';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        $this->data['page_title'] = 'Surat Pengantar Bepergian Untuk Nikah';

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
            '0'             => '',
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
        $this->data['status'] = [
            'name'          => 'status',
            'id'            => 'status',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['status_value'] = [
            '0'             => '',
            '1'             => 'Belum Kawin',
            '2'             => 'Kawin',
            '3'             => 'Cerai Hidup',
            '4'             => 'Cerai Mati',
        ];
        $this->data['pekerjaan'] = [
            'name'          => 'pekerjaan',
            'id'            => 'pekerjaan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['pekerjaan_value'] = [
            '0'             => '',
            '1'             => 'PNS',
            '2'             => 'Wiraswasta',
            '3'             => 'Karyawan Swasta',
            '4'             => 'Pensiunan',
            '5'             => 'Belum/Tidak Bekerja',
            '6'             => 'Pelajar/Mahasiswa',
            '7'             => 'Lainnya',
        ];
        $this->data['address'] = [
            'name'          => 'address',
            'id'            => 'address',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'rows'          => '2',
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
        $this->data['desa'] = [
            'name'          => 'desa',
            'id'            => 'desa',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kecamatan'] = [
            'name'          => 'kecamatan',
            'id'            => 'kecamatan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kabupaten'] = [
            'name'          => 'kabupaten',
            'id'            => 'kabupaten',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['provinsi'] = [
            'name'          => 'provinsi',
            'id'            => 'provinsi',
            'class'         => 'form-control',
            'required'      => '',
        ];

        $this->load->view('front/surat/create_surat_pengantar_nikah', $this->data);
    }
}
