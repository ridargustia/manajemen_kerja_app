<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_nikah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Nikah';

        $this->data['company_data']             = $this->Company_model->company_profile();
        $this->data['layout_template']          = $this->Template_model->layout();
        $this->data['skins_template']           = $this->Template_model->skins();
        $this->data['footer']                   = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Simpan';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['add_action'] = base_url('admin/sk_nikah/create');

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
        //TODO Get data SK Nikah dari database
        if (is_masteradmin()) {
            $this->data['get_all'] = $this->Sk_nikah_model->get_all_by_numbering();
        } elseif (is_superadmin() or is_grandadmin()) {
            $this->data['get_all'] = $this->Sk_nikah_model->get_all();
        }

        $this->load->view('back/sk_nikah/sk_nikah_list', $this->data);
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = $this->data['module'];
        $this->data['action']     = 'admin/sk_nikah/create_action';

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
        $this->data['phone'] = [
            'name'          => 'phone',
            'id'            => 'phone',
            'class'         => 'form-control',
            'onChange'      => 'checkFormatPhone()',
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
        $this->load->view('back/sk_nikah/sk_nikah_add', $this->data);
    }

    function create_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('suami_name', 'Nama Suami', 'trim|required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
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
        $this->form_validation->set_message('is_numeric', '{field} harus angka');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        $check_format_phone = substr($this->input->post('phone'), '0', '2');

        //?Apakah validasi gagal?
        if ($this->form_validation->run() === FALSE) {
            //TODO Kondisi validasi gagal, redirect ke halaman create
            $this->create();
        } elseif ($check_format_phone != '08') {
            $this->session->set_flashdata('message', 'no HP/Telephone salah');
            redirect('admin/sk_nikah/create');
        } else {
            //TODO Ubah Format phone number +62
            $selection_phone = substr($this->input->post('phone'), '1');
            $phone = '62' . $selection_phone;

            //TODO Simpan data ke array
            $data = array(
                'suami_name'            => $this->input->post('suami_name'),
                'phone'                 => $phone,
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
                'created_by'            => $this->session->username,
            );

            //TODO Post to database with model
            $this->Sk_nikah_model->insert($data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_nikah');
        }
    }

    function update($id_sk_nikah)
    {
        is_update();

        //TODO Get by id data sk_nikah
        $this->data['sk_nikah']     = $this->Sk_nikah_model->get_by_id($id_sk_nikah);

        //TODO Jika sk_nikah ditemukan
        if ($this->data['sk_nikah']) {
            //TODO Inisialisasi variabel
            $this->data['page_title'] = 'Update Data ' . $this->data['module'];
            $this->data['action']     = 'admin/sk_nikah/update_action';

            //TODO Get data untuk dropdown reference
            $this->data['get_all_combobox_status'] = $this->Status_model->get_all_combobox();
            $this->data['get_all_combobox_agama'] = $this->Agama_model->get_all_combobox();

            //TODO Rancangan form
            $this->data['id_sk_nikah'] = [
                'name'          => 'id_sk_nikah',
                'type'          => 'hidden',
            ];
            //TODO Rancangan form data suami
            $this->data['suami_name'] = [
                'name'          => 'suami_name',
                'id'            => 'suami_name',
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

            $this->load->view('back/sk_nikah/sk_nikah_edit', $this->data);
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_nikah');
        }
    }

    function update_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('suami_name', 'Nama Suami', 'trim|required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
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
        $this->form_validation->set_message('is_numeric', '{field} harus angka');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        //TODO Jika data tidak lolos validasi
        if ($this->form_validation->run() === FALSE) {
            $this->update($this->input->post('id_sk_nikah'));
        } else {
            $data = array(
                'suami_name'            => $this->input->post('suami_name'),
                'phone'                 => $this->input->post('phone'),
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
                'modified_by'           => $this->session->username,
            );

            //TODO Jalankan proses update
            $this->Sk_nikah_model->update($this->input->post('id_sk_nikah'), $data);

            write_log();

            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_nikah');
        }
    }

    function delete($id_sk_nikah)
    {
        is_delete();

        //TODO Get sk_nikah by id
        $delete = $this->Sk_nikah_model->get_by_id($id_sk_nikah);

        //TODO Jika data sk_nikah ditemukan
        if ($delete) {
            $data = array(
                'is_delete'   => '1',
                'deleted_by'  => $this->session->username,
                'deleted_at'  => date('Y-m-d H:i:a'),
            );

            //TODO Jalankan proses softdelete
            $this->Sk_nikah_model->soft_delete($id_sk_nikah, $data);

            write_log();

            //TODO Kirim notifikasi berhasil dihapus
            $this->session->set_flashdata('message', 'dihapus');
            redirect('admin/sk_nikah');
        } else {
            //TODO Kirim notifikasi data tidak ditemukan
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_nikah');
        }
    }

    function numbering($id_sk_nikah)
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Penomoran ' . $this->data['module'];
        $this->data['action']     = 'admin/sk_nikah/numbering_action';

        //TODO Rancangan form
        $this->data['id_sk_nikah'] = [
            'name'          => 'id_sk_nikah',
            'type'          => 'hidden',
        ];
        $this->data['no_surat'] = [
            'name'          => 'no_surat',
            'id'            => 'no_surat',
            'class'         => 'form-control',
            'required'      => '',
        ];

        //TODO Get detail sk_nikah by id
        $this->data['data_sk_nikah'] = $this->Sk_nikah_model->get_by_id($id_sk_nikah);

        $this->data['suami_status'] = $this->Status_model->get_by_id($this->data['data_sk_nikah']->suami_status_id);
        $this->data['istri_status'] = $this->Status_model->get_by_id($this->data['data_sk_nikah']->istri_status_id);
        $this->data['suami_agama'] = $this->Agama_model->get_by_id($this->data['data_sk_nikah']->suami_agama_id);
        $this->data['istri_agama'] = $this->Agama_model->get_by_id($this->data['data_sk_nikah']->istri_agama_id);

        //TODO Load view dengan mengirim data
        $this->load->view('back/sk_nikah/sk_nikah_numbering', $this->data);
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
            redirect('admin/sk_nikah/numbering/' . $this->input->post('id_sk_nikah'));
        } else {
            //TODO Simpan data ke array
            $data = array(
                'no_surat'              => $this->input->post('no_surat'),
                'is_readed'             => '1',
                'numbered_by'           => $this->session->username,
                'numbered_at'           => date('Y-m-d H:i:a'),
            );

            //TODO Post to database with model
            $this->Sk_nikah_model->update($this->input->post('id_sk_nikah'), $data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_nikah/numbering/' . $this->input->post('id_sk_nikah'));
        }
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
