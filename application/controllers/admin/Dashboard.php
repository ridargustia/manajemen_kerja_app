<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('Peminjaman_model', 'Pengembalian_model', 'Arsip_model', 'Rak_model', 'Baris_model', 'Box_model', 'Map_model'));

		$this->data['company_data']             = $this->Company_model->company_profile();
    $this->data['layout_template']          = $this->Template_model->layout();
    $this->data['skins_template']           = $this->Template_model->skins();
    $this->data['footer']                   = $this->Footer_model->footer();

		is_login();

		if (is_pegawai()) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak masuk ke halaman sebelumnya</div>');
			redirect('home');
		}
	}

	public function index()
	{
		$this->data['page_title'] = 'Dashboard';

		if (is_grandadmin()) {
			$this->data['get_total_user']     			= $this->Auth_model->total_rows();
			$this->data['get_total_arsip']     			= $this->Arsip_model->total_rows();
			$this->data['get_total_baris']     			= $this->Baris_model->total_rows();
			$this->data['get_total_box']     				= $this->Box_model->total_rows();
			$this->data['get_total_map']     				= $this->Map_model->total_rows();
			$this->data['get_total_menu']     			= $this->Menu_model->total_rows();
			$this->data['get_total_peminjaman']     = $this->Peminjaman_model->total_rows();
			$this->data['get_total_pengembalian']   = $this->Pengembalian_model->total_rows();
			$this->data['get_total_rak']     				= $this->Rak_model->total_rows();
			$this->data['get_total_submenu']     		= $this->Submenu_model->total_rows();
			$this->data['get_total_usertype']     	= $this->Usertype_model->total_rows();
		} elseif (is_masteradmin()) {
			$this->data['get_total_user']     			= $this->Auth_model->total_rows_by_instansi();
			$this->data['get_total_arsip']     			= $this->Arsip_model->total_rows_by_instansi();
			$this->data['get_total_baris']     			= $this->Baris_model->total_rows_by_instansi();
			$this->data['get_total_box']     				= $this->Box_model->total_rows_by_instansi();
			$this->data['get_total_map']     				= $this->Map_model->total_rows_by_instansi();
			$this->data['get_total_peminjaman']     = $this->Peminjaman_model->total_rows_by_instansi();
			$this->data['get_total_pengembalian']   = $this->Pengembalian_model->total_rows_by_instansi();
			$this->data['get_total_rak']     				= $this->Rak_model->total_rows_by_instansi();
		} elseif (is_superadmin()) {
			$this->data['get_total_user']     			= $this->Auth_model->total_rows_by_cabang();
			$this->data['get_total_arsip']     			= $this->Arsip_model->total_rows_by_cabang();
			$this->data['get_total_baris']     			= $this->Baris_model->total_rows_by_cabang();
			$this->data['get_total_box']     				= $this->Box_model->total_rows_by_cabang();
			$this->data['get_total_map']     				= $this->Map_model->total_rows_by_cabang();
			$this->data['get_total_peminjaman']     = $this->Peminjaman_model->total_rows_by_cabang();
			$this->data['get_total_pengembalian']   = $this->Pengembalian_model->total_rows_by_cabang();
			$this->data['get_total_rak']     				= $this->Rak_model->total_rows_by_cabang();
		} else {
			$this->data['get_total_arsip']     			= $this->Arsip_model->total_rows_by_divisi();
			$this->data['get_total_peminjaman']     = $this->Peminjaman_model->total_rows_by_divisi();
			$this->data['get_total_pengembalian']   = $this->Pengembalian_model->total_rows_by_divisi();
		}

		$this->load->view('back/dashboard/body', $this->data);
	}
}
