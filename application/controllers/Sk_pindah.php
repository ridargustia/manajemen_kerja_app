<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_pindah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Pindah';

        $this->data['company_data']      = $this->Company_model->company_profile();
        $this->data['footer']            = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Kirim';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Surat Keterangan Pindah';
        $this->data['action']     = 'sk_pindah/create_action';

        //TODO Get data untuk dropdown reference
        $this->data['get_all_combobox_status'] = $this->Status_model->get_all_combobox();
        $this->data['get_all_combobox_agama'] = $this->Agama_model->get_all_combobox();
        $this->data['get_all_combobox_pekerjaan'] = $this->Pekerjaan_model->get_all_combobox();
        $this->data['get_all_combobox_pendidikan_akhir'] = $this->Pendidikan_akhir_model->get_all_combobox();

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
        $this->data['pekerjaan'] = [
            'name'          => 'pekerjaan',
            'id'            => 'pekerjaan',
            'class'         => 'form-control',
            'required'      => '',
        ];
        $this->data['pendidikan_akhir'] = [
            'name'          => 'pendidikan_akhir',
            'id'            => 'pendidikan_akhir',
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
        $this->data['alamat_pindah'] = [
            'name'          => 'alamat_pindah',
            'id'            => 'alamat_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['desa_pindah'] = [
            'name'          => 'desa_pindah',
            'id'            => 'desa_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['kecamatan_pindah'] = [
            'name'          => 'kecamatan_pindah',
            'id'            => 'kecamatan_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['kota_pindah'] = [
            'name'          => 'kota_pindah',
            'id'            => 'kota_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['kabupaten_pindah'] = [
            'name'          => 'kabupaten_pindah',
            'id'            => 'kabupaten_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['provinsi_pindah'] = [
            'name'          => 'provinsi_pindah',
            'id'            => 'provinsi_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['tgl_pindah'] = [
            'name'          => 'tgl_pindah',
            'id'            => 'tgl_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['alasan_pindah'] = [
            'name'          => 'alasan_pindah',
            'id'            => 'alasan_pindah',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['nik_pengikut'] = [
            'name'          => 'nik_pengikut[]',
            'id'            => 'nik_pengikut',
            'class'         => 'form-control',
            'placeholder'   => 'NIK',
        ];
        $this->data['pengikut_name'] = [
            'name'          => 'pengikut_name[]',
            'id'            => 'pengikut_name',
            'class'         => 'form-control',
            'placeholder'   => 'Nama',
        ];
        $this->data['keterangan'] = [
            'name'          => 'keterangan[]',
            'id'            => 'keterangan',
            'class'         => 'form-control',
            'placeholder'   => 'Keterangan',
        ];

        //TODO Load view dengan mengirim data
        $this->load->view('front/surat/create_sk_pindah', $this->data);
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
        $this->form_validation->set_rules('kebangsaan', 'Kebangsaan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('pendidikan_akhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('alamat_pindah', 'Alamat Pindah', 'required');
        $this->form_validation->set_rules('desa_pindah', 'Desa (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('kecamatan_pindah', 'Kecamatan (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('kota_pindah', 'Kota (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('kabupaten_pindah', 'Kabupaten (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('provinsi_pindah', 'Provinsi (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('tgl_pindah', 'Tanggal Pindah', 'required');
        $this->form_validation->set_rules('alasan_pindah', 'Alasan Pindah', 'required');

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
                'kebangsaan'            => $this->input->post('kebangsaan'),
                'pekerjaan_id'          => $this->input->post('pekerjaan'),
                'pendidikan_akhir_id'   => $this->input->post('pendidikan_akhir'),
                'address'               => $this->input->post('address'),
                'alamat_pindah'         => $this->input->post('alamat_pindah'),
                'desa_pindah'           => $this->input->post('desa_pindah'),
                'kecamatan_pindah'      => $this->input->post('kecamatan_pindah'),
                'kota_pindah'           => $this->input->post('kota_pindah'),
                'kabupaten_pindah'      => $this->input->post('kabupaten_pindah'),
                'provinsi_pindah'       => $this->input->post('provinsi_pindah'),
                'tgl_pindah'            => $this->input->post('tgl_pindah'),
                'alasan_pindah'         => $this->input->post('alasan_pindah'),
            );

            //TODO eksekusi query INSERT
            $this->Sk_pindah_model->insert($data);

            write_log();

            $sk_pindah_id = $this->db->insert_id();

            if (!empty($this->input->post('nik_pengikut')) and !empty($this->input->post('pengikut_name'))) {
                $count = count($this->input->post('nik_pengikut'));

                for ($i = 0; $i < $count; $i++) {
                    $data_sk_pindah_id[$i] = array(
                        'sk_pindah_id'      => $sk_pindah_id,
                        'nik_pengikut'      => $this->input->post('nik_pengikut[' . $i . ']'),
                        'pengikut_name'     => $this->input->post('pengikut_name[' . $i . ']'),
                        'keterangan'        => $this->input->post('keterangan[' . $i . ']'),
                    );

                    $this->db->insert('pengikut_sk_pindah', $data_sk_pindah_id[$i]);

                    write_log();
                }
            }

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('sk_pindah/create');
        }
    }
}
