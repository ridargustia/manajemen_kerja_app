<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sk_meninggal_dunia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Surat Keterangan Meninggal Dunia';

        $this->data['company_data']             = $this->Company_model->company_profile();
        $this->data['layout_template']          = $this->Template_model->layout();
        $this->data['skins_template']           = $this->Template_model->skins();
        $this->data['footer']                   = $this->Footer_model->footer();

        $this->data['btn_submit'] = 'Simpan';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['add_action'] = base_url('admin/sk_meninggal_dunia/create');

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

        //TODO Get data SK Meninggal Dunia dari database
        if (is_masteradmin()) {
            $this->data['get_all'] = $this->Sk_meninggal_dunia_model->get_all_by_numbering();
        } elseif (is_superadmin() or is_grandadmin()) {
            $this->data['get_all'] = $this->Sk_meninggal_dunia_model->get_all();
        }

        $this->load->view('back/sk_meninggal_dunia/sk_meninggal_dunia_list', $this->data);
    }

    function create()
    {
        //TODO Inisialisasi variabel
        $this->data['page_title'] = $this->data['module'];
        $this->data['action']     = 'admin/sk_meninggal_dunia/create_action';

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
        $this->data['pekerjaan'] = [
            'name'          => 'pekerjaan',
            'id'            => 'pekerjaan',
            'class'         => 'form-control',
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
        $this->load->view('back/sk_meninggal_dunia/sk_meninggal_dunia_add', $this->data);
    }

    function create_action()
    {
        //TODO sistem validasi data inputan
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('birthplace', 'Tempat Lahir', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('phone', 'No HP/Telepon', 'required|is_numeric');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('dusun', 'Dusun', 'required');
        $this->form_validation->set_rules('tgl_meninggal', 'Tanggal Meninggal', 'required');
        $this->form_validation->set_rules('penyebab_kematian', 'Penyebab Kematian', 'required');

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
            redirect('admin/sk_meninggal_dunia/create');
        } else {
            //TODO Ubah Format phone number +62
            $selection_phone = substr($this->input->post('phone'), '1');
            $phone = '62' . $selection_phone;

            //TODO Format address
            $address = 'Dsn ' . $this->input->post('dusun') . ' RT/RW ' . $this->input->post('rt') . '/' . $this->input->post('rw');

            //TODO Simpan data ke array
            $data = array(
                'name'                  => $this->input->post('name'),
                'birthplace'            => $this->input->post('birthplace'),
                'birthdate'             => $this->input->post('birthdate'),
                'phone'                 => $phone,
                'gender'                => $this->input->post('gender'),
                'pekerjaan'             => $this->input->post('pekerjaan'),
                'address'               => $address,
                'tgl_meninggal'         => $this->input->post('tgl_meninggal'),
                'penyebab_kematian'     => $this->input->post('penyebab_kematian'),
                'created_by'            => $this->session->username,
            );

            //TODO Post to database with model
            $this->Sk_meninggal_dunia_model->insert($data);

            write_log();

            //TODO Tampilkan notifikasi dan redirect
            $this->session->set_flashdata('message', 'Sukses');
            redirect('admin/sk_meninggal_dunia');
        }
    }

    function delete($id_sk_meninggal_dunia)
    {
        is_delete();

        $delete = $this->Sk_meninggal_dunia_model->get_by_id($id_sk_meninggal_dunia);

        if ($delete) {
            $data = array(
                'is_delete'   => '1',
                'deleted_by'  => $this->session->username,
                'deleted_at'  => date('Y-m-d H:i:a'),
            );

            $this->Sk_meninggal_dunia_model->soft_delete($id_sk_meninggal_dunia, $data);

            write_log();

            $this->session->set_flashdata('message', 'dihapus');
            redirect('admin/sk_meninggal_dunia');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect('admin/sk_meninggal_dunia');
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
