<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_jalan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Jalan';

        $this->data['company_data']             = $this->Company_model->company_profile();
        $this->data['layout_template']          = $this->Template_model->layout();
        $this->data['skins_template']           = $this->Template_model->skins();
        $this->data['footer']                   = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Simpan';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['add_action'] = base_url('admin/sk_jalan/create');

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

        //TODO Get data SK Jalan dari database
        if (is_masteradmin()) {
            $this->data['get_all'] = $this->Sk_jalan_model->get_all_by_numbering();
        } elseif (is_superadmin() or is_grandadmin()) {
            $this->data['get_all'] = $this->Sk_jalan_model->get_all();
        }

        $this->load->view('back/sk_jalan/sk_jalan_list', $this->data);
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = $this->data['module'];
        $this->data['action']     = 'admin/sk_jalan/create_action';

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
        $this->data['agama'] = [
            'name'          => 'agama',
            'id'            => 'agama',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kebangsaan'] = [
            'name'          => 'kebangsaan',
            'id'            => 'kebangsaan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['kebangsaan_value'] = [
            '0'             => '- Pilih Kebangsaan -',
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
            'autocomplete'  => 'off',
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
            'autocomplete'  => 'off',
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

        $this->load->view('back/sk_jalan/sk_jalan_add', $this->data);
    }

    function create_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('kebangsaan', 'Kebangsaan', 'required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('kepentingan', 'Kepentingan', 'required');
        $this->form_validation->set_rules('tempat_tujuan', 'Tempat Tujuan', 'required');
        $this->form_validation->set_rules('tgl_berangkat', 'Tanggal Berangkat', 'required');

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
                'agama_id'              => $this->input->post('agama'),
                'kebangsaan'            => $this->input->post('kebangsaan'),
                'address'               => $this->input->post('address'),
                'kepentingan'           => $this->input->post('kepentingan'),
                'tempat_tujuan'         => $this->input->post('tempat_tujuan'),
                'tgl_berangkat'         => $this->input->post('tgl_berangkat'),
                'barang_dibawa'         => $this->input->post('barang_dibawa'),
                'lama_pergi'            => $this->input->post('lama_pergi'),
                'pengikut'              => $this->input->post('pengikut'),
                'lain_lain'             => $this->input->post('lain_lain'),
                'created_by'            => $this->session->username,
            );

            //TODO Post to database with model
            $this->Sk_jalan_model->insert($data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_jalan');
        }
    }

    function delete($id_sk_jalan)
    {
        is_delete();

        $delete = $this->Sk_jalan_model->get_by_id($id_sk_jalan);

        if ($delete) {
            $data = array(
                'is_delete'   => '1',
                'deleted_by'  => $this->session->username,
                'deleted_at'  => date('Y-m-d H:i:a'),
            );

            $this->Sk_jalan_model->soft_delete($id_sk_jalan, $data);

            write_log();

            $this->session->set_flashdata('message', 'dihapus');
            redirect('admin/sk_jalan');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_jalan');
        }
    }
}
