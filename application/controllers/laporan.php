<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {

	// num of records per page
	private $limit = 10;
	
	function __construct()
	{
		parent::__construct();
		// load library
		$this->load->library(array('table','form_validation','session','kur_functions'));
		$this->limit = 20;
		
		// load helper
		$this->load->helper('url');
		
		// load model
		$this->load->model('Laporan_model','',TRUE);	
		
	}
	
	function index($offset = 0)
	{
		// offset
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		$periode = '201302';
		$this->transaksi_harian($periode);	
		
	}
	
	function transaksi_harian($periode){
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		$data_table['periode'] = $periode;
		$data_table['action'] = site_url('trans/add');
		$data_table['periode_text'] = $this->kur_functions->periode_to_text($periode);
		$data_table['base_url'] = site_url('laporan/transaksi_harian');
		#echo $periode;
		$data_table['saldo_awal'] = $this->Laporan_model->get_saldo_awal($periode);
		$data_table['saldo_akhir'] = $this->Laporan_model->get_saldo_akhir($periode);
		$data_table['trans'] = $this->Laporan_model->buka_kas_harian($periode)->result();
		
		$data['title'] = "Buku Kas Harian ".$this->kur_functions->periode_to_text($periode);
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		// load view
		$html_table = $this->load->view('tableKasHarian', $data_table,true);
		$data['role_user'] = $this->session->userdata('kop_sess_role');		
		$data['html_table'] = $html_table;
		$this->load->view('laporanView', $data);	
	}
	
	function daftar_simpanan($tahun){
		$this->kur_auth->is_logged_in();
		$data_table['base_url'] = site_url('laporan/daftar_simpanan');
		$data_table['trans'] = $this->Laporan_model->daftar_simpanan($tahun)->result();
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		print_r($data_table['trans']);
		// load view
		$html_table = $this->load->view('tableKasHarian', $data_table,true);
		$data['role_user'] = $this->session->userdata('kop_sess_role');		
		$data['html_table'] = $html_table;
		$this->load->view('laporanView', $data);	
	}
	
	
	
	
	
	
}
?>