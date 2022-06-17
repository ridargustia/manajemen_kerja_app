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

        $this->data['btn_submit'] = 'Kirim';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Surat Keterangan Meninggal Dunia';
        $this->data['action']     = 'sk_meninggal_dunia/create_action';

        //TODO Get data untuk dropdown reference
        $this->data['get_all_combobox_pekerjaan'] = $this->Pekerjaan_model->get_all_combobox();

        //TODO Rancangan form
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
            '0'             => '- Pilih Jenis Kelamin -',
            '1'             => 'Laki-laki',
            '2'             => 'Perempuan',
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
        $this->data['tgl_meninggal'] = [
            'name'          => 'tgl_meninggal',
            'id'            => 'tgl_meninggal',
            'class'         => 'form-control',
            'type'          => 'datetime-local',
            'required'      => '',
        ];
        $this->data['penyebab_kematian'] = [
            'name'          => 'penyebab_kematian',
            'id'            => 'penyebab_kematian',
            'class'         => 'form-control',
            'required'      => '',
        ];

        //TODO Load view dengan mengirim data
        $this->load->view('front/surat/create_sk_meninggal_dunia', $this->data);
    }

    function create_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('tgl_meninggal', 'Tanggal Meninggal', 'required');
        $this->form_validation->set_rules('penyebab_kematian', 'Penyebab Kematian', 'required');

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
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'gender'                => $this->input->post('gender'),
                'pekerjaan_id'          => $this->input->post('pekerjaan'),
                'address'               => $this->input->post('address'),
                'tgl_meninggal'         => $this->input->post('tgl_meninggal'),
                'penyebab_kematian'     => $this->input->post('penyebab_kematian'),
            );

            //TODO Post to database with model
            $this->Sk_meninggal_dunia_model->insert($data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil di kirim. Mohon ditunggu hasilnya.</div>');
            redirect('sk_meninggal_dunia/create');
        }
    }
}
