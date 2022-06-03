<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arsip extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Home';

    $this->load->helper(array('highlight'));

    $this->load->model(array('Arsip_model', 'File_model', 'Rak_model', 'Baris_model', 'Kategori_model'));
    
    $this->data['company_data']      = $this->Company_model->company_profile();
    $this->data['footer']            = $this->Footer_model->footer();

    if (is_grandadmin()) {
      $this->data['get_all_instansi'] = $this->Instansi_model->get_all_active();
    } elseif (is_masteradmin()) {
      $this->data['get_all_cabang']   = $this->Cabang_model->get_all_by_instansi();
    } else {
      $this->data['get_all_divisi']   = $this->Divisi_model->get_all_by_cabang();
    }

    is_login_front();
    is_active_instansi_front();
  }

  function cari_arsip()
  {
    $this->data['page_title']       = 'Hasil Pencarian';

    $search_form  = $this->input->get('search_form');
    $instansi_id  = $this->input->get('instansi_id');
    $cabang_id    = $this->input->get('cabang_id');
    $divisi_id    = $this->input->get('divisi_id');
    
    $this->data['instansi']   = $this->Instansi_model->get_by_id($instansi_id);
    $this->data['cabang']     = $this->Cabang_model->get_by_id($cabang_id);
    $this->data['divisi']     = $this->Divisi_model->get_by_id($divisi_id);

    if (is_grandadmin()) {
      if ($search_form == NULL and $instansi_id == NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->get_all_front();
      }
      // jika form pencarian KOSONG dan CABANG DIISI
      elseif ($search_form == NULL and $instansi_id != NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->cari_all_arsip_by_instansi_with_searchFormNull_and_instansiIdNotNull($instansi_id);
      }
      // jika form pencarian DIISI dan CABANG KOSONG
      elseif ($search_form != NULL and $instansi_id == NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->cari_all_arsip_by_instansi_with_searchFormNotNull_and_instansiIdNull($search_form);
      }
      // jika form pencarian DIISI dan CABANG DIISI
      elseif ($search_form != NULL and $instansi_id != NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->cari_all_arsip_by_instansi_with_searchFormNotNull($search_form, $instansi_id);
      }
    } elseif (is_masteradmin()) {
      if ($search_form == NULL and $cabang_id == NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->get_all_by_instansi();
      }
      // jika form pencarian KOSONG dan CABANG DIISI
      elseif ($search_form == NULL and $cabang_id != NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->get_all_by_instansi_with_searchFormNull_and_cabangNotNull($cabang_id);
      }
      // jika form pencarian DIISI dan CABANG KOSONG
      elseif ($search_form != NULL and $cabang_id == NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->get_all_by_instansi_with_searchFormNotNull_and_cabangNull($search_form);
      }
      // jika form pencarian DIISI dan CABANG DIISI
      elseif ($search_form != NULL and $cabang_id != NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->get_all_by_instansi_with_searchFormNotNull_and_cabangNotNull($search_form, $cabang_id);
      }
    } else {
      if ($search_form == NULL and $divisi_id == NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->get_all_by_instansi();
      }
      // jika form pencarian KOSONG dan CABANG DIISI
      elseif ($search_form == NULL and $divisi_id != NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->get_all_by_instansi_with_searchFormNull_and_divisiNotNull($divisi_id);
      }
      // jika form pencarian DIISI dan CABANG KOSONG
      elseif ($search_form != NULL and $divisi_id == NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->get_all_by_instansi_with_searchFormNotNull_and_divisiNull($search_form);
      }
      // jika form pencarian DIISI dan CABANG DIISI
      elseif ($search_form != NULL and $divisi_id != NULL) {
        $this->data['hasil_pencarian']  = $this->Arsip_model->get_all_by_instansi_with_searchFormNotNull_and_divisiNotNull($search_form, $divisi_id);
      }
    }

    $this->load->view('front/arsip/hasil_pencarian', $this->data);
  }

  function detail($id)
  {
    $this->data['page_title']   = 'Detail Arsip';

    $this->data['detail_arsip']   = $this->Arsip_model->get_by_id_front($id);
    $this->data['file_upload']    = $this->File_model->get_by_arsip_id($id);

    $instansi                     = $this->Instansi_model->get_by_id($this->data['detail_arsip']->instansi_id);
    $this->data['instansiName']   = $instansi->instansi_name;

    $row = $this->data['detail_arsip'];

    if ($this->data['detail_arsip'] == TRUE) {
      if (is_masteradmin() && $row->instansi_id != $this->session->instansi_id) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak melihat data orang lain</div>');
        redirect('home');
      } else {
        $this->data['arsip_files']  = $this->Arsip_model->get_files_id_result($this->uri->segment(3));

        $this->load->view('front/arsip/detail_arsip', $this->data);
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger"><i class="fa fa-bullhorn"></i> Arsip yang Anda cari tidak ditemukan!</div>');
      redirect('home');
    }
  }
}
