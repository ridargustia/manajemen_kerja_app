<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_meninggal_dunia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Meninggal Dunia';

        $this->data['company_data']      = $this->Company_model->company_profile();
        $this->data['footer']            = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Submit';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        $this->data['page_title'] = 'Surat Keterangan Meninggal Dunia';

        $this->data['name'] = [
            'name'          => 'name',
            'id'            => 'name',
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
        $this->data['tgl_meninggal'] = [
            'name'          => 'tgl_meninggal',
            'id'            => 'tgl_meninggal',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['penyebab_kematian'] = [
            'name'          => 'penyebab_kematian',
            'id'            => 'penyebab_kematian',
            'class'         => 'form-control',
            'required'      => '',
        ];

        $this->load->view('front/surat/create_sk_meninggal_dunia', $this->data);
    }
}
