<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_pindah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Pindah';

        $this->data['company_data']             = $this->Company_model->company_profile();
        $this->data['layout_template']          = $this->Template_model->layout();
        $this->data['skins_template']           = $this->Template_model->skins();
        $this->data['footer']                   = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Simpan';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['add_action'] = base_url('admin/sk_pindah/create');

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

        //TODO Get data SK Pindah dari database
        if (is_masteradmin()) {
            $this->data['get_all'] = $this->Sk_pindah_model->get_all_by_numbering();
        } elseif (is_superadmin() or is_grandadmin()) {
            $this->data['get_all'] = $this->Sk_pindah_model->get_all();
        }

        $this->load->view('back/sk_pindah/sk_pindah_list', $this->data);
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = $this->data['module'];
        $this->data['action']     = 'admin/sk_pindah/create_action';

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
        $this->data['phone'] = [
            'name'          => 'phone',
            'id'            => 'phone',
            'class'         => 'form-control',
            'onChange'      => 'checkFormatPhone()',
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
            ''             => '- Pilih Jenis Kelamin -',
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
            ''             => '- Pilih Kebangsaan -',
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
        $this->data['dusun'] = [
            'name'          => 'dusun',
            'id'            => 'dusun',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['rw'] = [
            'name'          => 'rw',
            'id'            => 'rw',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['rt'] = [
            'name'          => 'rt',
            'id'            => 'rt',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
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
        $this->load->view('back/sk_pindah/sk_pindah_add', $this->data);
    }

    function create_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('status', 'Status Pernikahan', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('kebangsaan', 'Kebangsaan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('pendidikan_akhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('dusun', 'Dusun', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');

        $this->form_validation->set_rules('alamat_pindah', 'Alamat Pindah', 'required');
        $this->form_validation->set_rules('desa_pindah', 'Desa (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('kecamatan_pindah', 'Kecamatan (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('kota_pindah', 'Kota (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('kabupaten_pindah', 'Kabupaten (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('provinsi_pindah', 'Provinsi (Tempat Pindah)', 'required');
        $this->form_validation->set_rules('tgl_pindah', 'Tanggal Pindah', 'required');
        $this->form_validation->set_rules('alasan_pindah', 'Alasan Pindah', 'required');

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
            redirect('admin/sk_pindah/create');
        } else {
            //TODO Ubah Format phone number +62
            $selection_phone = substr($this->input->post('phone'), '1');
            $phone = '62' . $selection_phone;

            //TODO Format address
            $address = 'Dusun ' . $this->input->post('dusun') . ' RT/RW ' . $this->input->post('rt') . '/' . $this->input->post('rw');

            //TODO Simpan data ke array
            $data = array(
                'name'                  => $this->input->post('name'),
                'nik'                   => $this->input->post('nik'),
                'phone'                 => $phone,
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'gender'                => $this->input->post('gender'),
                'status_id'             => $this->input->post('status'),
                'agama_id'              => $this->input->post('agama'),
                'kebangsaan'            => $this->input->post('kebangsaan'),
                'pekerjaan_id'          => $this->input->post('pekerjaan'),
                'pendidikan_akhir_id'   => $this->input->post('pendidikan_akhir'),
                'address'               => $address,
                'alamat_pindah'         => $this->input->post('alamat_pindah'),
                'desa_pindah'           => $this->input->post('desa_pindah'),
                'kecamatan_pindah'      => $this->input->post('kecamatan_pindah'),
                'kota_pindah'           => $this->input->post('kota_pindah'),
                'kabupaten_pindah'      => $this->input->post('kabupaten_pindah'),
                'provinsi_pindah'       => $this->input->post('provinsi_pindah'),
                'tgl_pindah'            => $this->input->post('tgl_pindah'),
                'alasan_pindah'         => $this->input->post('alasan_pindah'),
                'created_by'            => $this->session->username,
            );

            //TODO eksekusi query INSERT
            $this->Sk_pindah_model->insert($data);

            $sk_pindah_id = $this->db->insert_id();

            write_log();

            if (!empty($this->input->post('nik_pengikut')) and !empty($this->input->post('pengikut_name'))) {
                $count = count($this->input->post('nik_pengikut'));

                for ($i = 0; $i < $count; $i++) {
                    $data_sk_pindah_id[$i] = array(
                        'sk_pindah_id'      => $sk_pindah_id,
                        'nik_pengikut'      => $this->input->post('nik_pengikut[' . $i . ']'),
                        'pengikut_name'     => $this->input->post('pengikut_name[' . $i . ']'),
                        'keterangan'        => $this->input->post('keterangan[' . $i . ']'),
                        'created_by'        => $this->session->username,
                    );

                    $this->db->insert('pengikut_sk_pindah', $data_sk_pindah_id[$i]);

                    write_log();
                }
            }

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_pindah');
        }
    }

    function update($id_sk_pindah)
    {
        is_update();

        //TODO Get by id data sk_pindah
        $this->data['sk_pindah']     = $this->Sk_pindah_model->get_by_id($id_sk_pindah);

        //TODO Jika sk_pindah ditemukan
        if ($this->data['sk_pindah']) {
            //TODO Inisialisasi variabel
            $this->data['page_title'] = 'Update Data ' . $this->data['module'];
            $this->data['action']     = 'admin/sk_pindah/update_action';

            $this->data['pengikut'] = $this->Sk_pindah_model->get_pengikut_by_id_sk_pindah($id_sk_pindah);

            //TODO Get data untuk dropdown reference
            $this->data['get_all_combobox_status'] = $this->Status_model->get_all_combobox();
            $this->data['get_all_combobox_agama'] = $this->Agama_model->get_all_combobox();
            $this->data['get_all_combobox_pekerjaan'] = $this->Pekerjaan_model->get_all_combobox();
            $this->data['get_all_combobox_pendidikan_akhir'] = $this->Pendidikan_akhir_model->get_all_combobox();

            //TODO Rancangan form
            $this->data['id_sk_pindah'] = [
                'name'          => 'id_sk_pindah',
                'type'          => 'hidden',
            ];
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
            $this->data['phone'] = [
                'name'          => 'phone',
                'id'            => 'phone',
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
                ''             => '- Pilih Jenis Kelamin -',
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
                ''             => '- Pilih Kebangsaan -',
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

            $this->load->view('back/sk_pindah/sk_pindah_edit', $this->data);
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_pindah');
        }
    }

    function update_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
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
        $this->form_validation->set_message('is_numeric', '{field} harus angka');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        //TODO Jika data tidak lolos validasi
        if ($this->form_validation->run() === FALSE) {
            $this->update($this->input->post('id_sk_pindah'));
        } else {
            $data = array(
                'name'                  => $this->input->post('name'),
                'nik'                   => $this->input->post('nik'),
                'phone'                 => $this->input->post('phone'),
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
                'modified_by'            => $this->session->username,
            );

            //TODO Jalankan proses update
            $this->Sk_pindah_model->update($this->input->post('id_sk_pindah'), $data);

            write_log();

            $this->Sk_pindah_model->delete_pengikut_by_id_sk_pindah($this->input->post('id_sk_pindah'));

            if (!empty($this->input->post('nik_pengikut')) and !empty($this->input->post('pengikut_name'))) {
                $count = count($this->input->post('nik_pengikut'));

                for ($i = 0; $i < $count; $i++) {
                    $data_sk_pindah_id[$i] = array(
                        'sk_pindah_id'      => $this->input->post('id_sk_pindah'),
                        'nik_pengikut'      => $this->input->post('nik_pengikut[' . $i . ']'),
                        'pengikut_name'     => $this->input->post('pengikut_name[' . $i . ']'),
                        'keterangan'        => $this->input->post('keterangan[' . $i . ']'),
                        'created_by'        => $this->session->username,
                        'modified_by'       => $this->session->username,
                    );

                    $this->db->insert('pengikut_sk_pindah', $data_sk_pindah_id[$i]);

                    write_log();
                }
            }

            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_pindah');
        }
    }

    function delete($id_sk_pindah)
    {
        is_delete();

        //TODO Get sk_pindah by id
        $delete = $this->Sk_pindah_model->get_by_id($id_sk_pindah);

        //TODO Jika data sk_pindah ditemukan
        if ($delete) {
            $data = array(
                'is_delete'   => '1',
                'deleted_by'  => $this->session->username,
                'deleted_at'  => date('Y-m-d H:i:a'),
            );

            //TODO Jalankan proses softdelete
            $this->Sk_pindah_model->soft_delete($id_sk_pindah, $data);

            write_log();

            //TODO Kirim notifikasi berhasil dihapus
            $this->session->set_flashdata('message', 'dihapus');
            redirect('admin/sk_pindah');
        } else {
            //TODO Kirim notifikasi data tidak ditemukan
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_pindah');
        }
    }

    function numbering($id_sk_pindah)
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Penomoran ' . $this->data['module'];
        $this->data['action']     = 'admin/sk_pindah/numbering_action';

        //TODO Rancangan form
        $this->data['id_sk_pindah'] = [
            'name'          => 'id_sk_pindah',
            'type'          => 'hidden',
        ];
        $this->data['no_surat'] = [
            'name'          => 'no_surat',
            'id'            => 'no_surat',
            'class'         => 'form-control',
            'required'      => '',
        ];

        //TODO Get detail sk_pindah by id
        $this->data['data_sk_pindah'] = $this->Sk_pindah_model->get_by_id($id_sk_pindah);
        $this->data['pengikut'] = $this->Sk_pindah_model->get_pengikut_by_id_sk_pindah($id_sk_pindah);

        $this->data['status'] = $this->Status_model->get_by_id($this->data['data_sk_pindah']->status_id);
        $this->data['agama'] = $this->Agama_model->get_by_id($this->data['data_sk_pindah']->agama_id);
        $this->data['pekerjaan'] = $this->Pekerjaan_model->get_by_id($this->data['data_sk_pindah']->pekerjaan_id);
        $this->data['pendidikan_akhir'] = $this->Pendidikan_akhir_model->get_by_id($this->data['data_sk_pindah']->pendidikan_akhir_id);

        //TODO Load view dengan mengirim data
        $this->load->view('back/sk_pindah/sk_pindah_numbering', $this->data);
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
            redirect('admin/sk_pindah/numbering/' . $this->input->post('id_sk_pindah'));
        } else {
            //TODO Simpan data ke array
            $data = array(
                'no_surat'              => $this->input->post('no_surat'),
                'is_readed'             => '1',
                'numbered_by'           => $this->session->username,
                'numbered_at'           => date('Y-m-d H:i:a'),
            );

            //TODO Post to database with model
            $this->Sk_pindah_model->update($this->input->post('id_sk_pindah'), $data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_pindah/numbering/' . $this->input->post('id_sk_pindah'));
        }
    }

    function delete_permanent($id_sk_pindah)
    {
        is_delete();

        //TODO Get data sk_pindah by id
        $delete = $this->Sk_pindah_model->get_by_id($id_sk_pindah);

        //TODO Jika data sk_pindah yg akan dihapus ditemukan
        if ($delete) {
            //TODO Jalankan proses delete dengan model
            $this->Sk_pindah_model->delete($id_sk_pindah);

            write_log();

            //TODO Kirim notifikasi berhasil dihapus permanen
            $this->session->set_flashdata('message', 'dihapus');
            redirect('admin/sk_pindah/deleted_list');
        } else {
            //TODO Kirim notifikasi data tidak ditemukan
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_pindah');
        }
    }

    function deleted_list()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

        //TODO Get data Sk_pindah dari database
        if (is_masteradmin()) {
            $this->data['get_all'] = $this->Sk_pindah_model->get_all_deleted_for_masteradmin();
        } elseif (is_superadmin() or is_grandadmin()) {
            $this->data['get_all'] = $this->Sk_pindah_model->get_all_deleted();
        }

        $this->load->view('back/sk_pindah/sk_pindah_deleted_list', $this->data);
    }

    function restore($id_sk_pindah)
    {
        is_restore();

        //TODO Get data sk_pindah by id
        $row = $this->Sk_pindah_model->get_by_id($id_sk_pindah);

        //TODO Jika data ditemukan
        if ($row) {
            $data = array(
                'is_delete'   => '0',
                'deleted_by'  => NULL,
                'deleted_at'  => NULL,
            );

            //TODO Jalankan proses update dengan model
            $this->Sk_pindah_model->update($id_sk_pindah, $data);

            write_log();

            //TODO Kirim notifikasi data berhasil dikembalikan
            $this->session->set_flashdata('message', 'dikembalikan');
            redirect('admin/sk_pindah/deleted_list');
        } else {
            //TODO Kirim notifikasi data tidak ditemukan
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_pindah');
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
