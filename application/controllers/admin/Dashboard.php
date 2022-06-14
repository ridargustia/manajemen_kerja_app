<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('Surat_model'));

		$this->data['company_data']             = $this->Company_model->company_profile();
		$this->data['layout_template']          = $this->Template_model->layout();
		$this->data['skins_template']           = $this->Template_model->skins();
		$this->data['footer']                   = $this->Footer_model->footer();

		is_login();
	}

	public function index()
	{
		//TODO Inisialisasi variabel
		$this->data['page_title'] = 'Dashboard';

		if (is_grandadmin()) {	//? Apakah user adalah grandadmin?
			$this->data['get_total_skck'] = $this->Surat_model->total_rows_skck();
			$this->data['get_total_sk_domisili'] = $this->Surat_model->total_rows_sk_domisili();
			$this->data['get_total_sk_jalan'] = $this->Surat_model->total_rows_sk_jalan();
			$this->data['get_total_sk_hilang_ktp'] = $this->Surat_model->total_rows_sk_hilang_ktp();
			$this->data['get_total_sk_meninggal_dunia'] = $this->Surat_model->total_rows_sk_meninggal_dunia();
			$this->data['get_total_sk_nikah'] = $this->Surat_model->total_rows_sk_nikah();
			$this->data['get_total_sk_pindah'] = $this->Surat_model->total_rows_sk_pindah();
			$this->data['get_total_sk_usaha'] = $this->Surat_model->total_rows_sk_usaha();
			$this->data['get_total_surat_pengantar_nikah'] = $this->Surat_model->total_rows_surat_pengantar_nikah();
			$this->data['get_total_surat_pernyataan_miskin'] = $this->Surat_model->total_rows_surat_pernyataan_miskin();
			$this->data['get_total_surat_rekomendasi'] = $this->Surat_model->total_rows_surat_rekomendasi();
			$this->data['get_total_user'] = $this->Auth_model->total_rows();
			$this->data['get_total_menu'] = $this->Menu_model->total_rows();
			$this->data['get_total_submenu'] = $this->Submenu_model->total_rows();
			$this->data['get_total_usertype'] = $this->Usertype_model->total_rows();
		} elseif (is_masteradmin()) {	//?Apakah user adalah masteradmin?
			$this->data['get_total_skck'] = $this->Surat_model->total_rows_skck();
			$this->data['get_total_sk_domisili'] = $this->Surat_model->total_rows_sk_domisili();
			$this->data['get_total_sk_jalan'] = $this->Surat_model->total_rows_sk_jalan();
			$this->data['get_total_sk_hilang_ktp'] = $this->Surat_model->total_rows_sk_hilang_ktp();
			$this->data['get_total_sk_meninggal_dunia'] = $this->Surat_model->total_rows_sk_meninggal_dunia();
			$this->data['get_total_sk_nikah'] = $this->Surat_model->total_rows_sk_nikah();
			$this->data['get_total_sk_pindah'] = $this->Surat_model->total_rows_sk_pindah();
			$this->data['get_total_sk_usaha'] = $this->Surat_model->total_rows_sk_usaha();
			$this->data['get_total_surat_pengantar_nikah'] = $this->Surat_model->total_rows_surat_pengantar_nikah();
			$this->data['get_total_surat_pernyataan_miskin'] = $this->Surat_model->total_rows_surat_pernyataan_miskin();
			$this->data['get_total_surat_rekomendasi'] = $this->Surat_model->total_rows_surat_rekomendasi();
		} elseif (is_superadmin()) {	//?Apakah user adalah superadmin?
			$this->data['get_total_skck'] = $this->Surat_model->total_rows_skck();
			$this->data['get_total_sk_domisili'] = $this->Surat_model->total_rows_sk_domisili();
			$this->data['get_total_sk_jalan'] = $this->Surat_model->total_rows_sk_jalan();
			$this->data['get_total_sk_hilang_ktp'] = $this->Surat_model->total_rows_sk_hilang_ktp();
			$this->data['get_total_sk_meninggal_dunia'] = $this->Surat_model->total_rows_sk_meninggal_dunia();
			$this->data['get_total_sk_nikah'] = $this->Surat_model->total_rows_sk_nikah();
			$this->data['get_total_sk_pindah'] = $this->Surat_model->total_rows_sk_pindah();
			$this->data['get_total_sk_usaha'] = $this->Surat_model->total_rows_sk_usaha();
			$this->data['get_total_surat_pengantar_nikah'] = $this->Surat_model->total_rows_surat_pengantar_nikah();
			$this->data['get_total_surat_pernyataan_miskin'] = $this->Surat_model->total_rows_surat_pernyataan_miskin();
			$this->data['get_total_surat_rekomendasi'] = $this->Surat_model->total_rows_surat_rekomendasi();
		}

		$this->load->view('back/dashboard/body', $this->data);
	}
}
