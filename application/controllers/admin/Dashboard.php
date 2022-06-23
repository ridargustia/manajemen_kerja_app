<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

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
			$this->data['get_total_skck'] = $this->Skck_model->total_rows();
			$this->data['get_total_sk_domisili'] = $this->Sk_domisili_model->total_rows();
			$this->data['get_total_sk_jalan'] = $this->Sk_jalan_model->total_rows();
			$this->data['get_total_sk_hilang_ktp'] = $this->Sk_hilang_ktp_model->total_rows();
			$this->data['get_total_sk_meninggal_dunia'] = $this->Sk_meninggal_dunia_model->total_rows();
			$this->data['get_total_sk_nikah'] = $this->Sk_nikah_model->total_rows();
			$this->data['get_total_sk_pindah'] = $this->Sk_pindah_model->total_rows();
			$this->data['get_total_sk_usaha'] = $this->Sk_usaha_model->total_rows();
			$this->data['get_total_surat_pengantar_nikah'] = $this->Surat_pengantar_nikah_model->total_rows();
			$this->data['get_total_surat_pernyataan_miskin'] = $this->Surat_pernyataan_miskin_model->total_rows();
			$this->data['get_total_surat_rekomendasi'] = $this->Surat_rekomendasi_model->total_rows();
			$this->data['get_total_user'] = $this->Auth_model->total_rows();
			$this->data['get_total_menu'] = $this->Menu_model->total_rows();
			$this->data['get_total_submenu'] = $this->Submenu_model->total_rows();
			$this->data['get_total_usertype'] = $this->Usertype_model->total_rows();
		} elseif (is_masteradmin()) {	//?Apakah user adalah masteradmin?
			$this->data['get_total_skck'] = $this->Skck_model->total_rows();
			$this->data['get_total_sk_domisili'] = $this->Sk_domisili_model->total_rows();
			$this->data['get_total_sk_jalan'] = $this->Sk_jalan_model->total_rows();
			$this->data['get_total_sk_hilang_ktp'] = $this->Sk_hilang_ktp_model->total_rows();
			$this->data['get_total_sk_meninggal_dunia'] = $this->Sk_meninggal_dunia_model->total_rows();
			$this->data['get_total_sk_nikah'] = $this->Sk_nikah_model->total_rows();
			$this->data['get_total_sk_pindah'] = $this->Sk_pindah_model->total_rows();
			$this->data['get_total_sk_usaha'] = $this->Sk_usaha_model->total_rows();
			$this->data['get_total_surat_pengantar_nikah'] = $this->Surat_pengantar_nikah_model->total_rows();
			$this->data['get_total_surat_pernyataan_miskin'] = $this->Surat_pernyataan_miskin_model->total_rows();
			$this->data['get_total_surat_rekomendasi'] = $this->Surat_rekomendasi_model->total_rows();
		} elseif (is_superadmin()) {	//?Apakah user adalah superadmin?
			$this->data['get_total_skck'] = $this->Skck_model->total_rows();
			$this->data['get_total_sk_domisili'] = $this->Sk_domisili_model->total_rows();
			$this->data['get_total_sk_jalan'] = $this->Sk_jalan_model->total_rows();
			$this->data['get_total_sk_hilang_ktp'] = $this->Sk_hilang_ktp_model->total_rows();
			$this->data['get_total_sk_meninggal_dunia'] = $this->Sk_meninggal_dunia_model->total_rows();
			$this->data['get_total_sk_nikah'] = $this->Sk_nikah_model->total_rows();
			$this->data['get_total_sk_pindah'] = $this->Sk_pindah_model->total_rows();
			$this->data['get_total_sk_usaha'] = $this->Sk_usaha_model->total_rows();
			$this->data['get_total_surat_pengantar_nikah'] = $this->Surat_pengantar_nikah_model->total_rows();
			$this->data['get_total_surat_pernyataan_miskin'] = $this->Surat_pernyataan_miskin_model->total_rows();
			$this->data['get_total_surat_rekomendasi'] = $this->Surat_rekomendasi_model->total_rows();
		}

		$this->load->view('back/dashboard/body', $this->data);
	}
}
