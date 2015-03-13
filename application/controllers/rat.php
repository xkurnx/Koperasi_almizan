<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rat extends CI_Controller {

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
		$periode = date('Ym');
		$this->transaksi_harian($periode);	
		
	}
	
	function kembali_aset($periode,$view = 'web'){
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		
		$data_table['periode'] = $periode;
		$tahun = substr($periode,0,4);
		// ambil data tutup buku 
				
		$data['title'] = "Laporan Aset Anggota yang akan dikembalikan ";
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		$data['view'] = $view; // XLS or WEB
		$data['role_user'] = $this->session->userdata('kop_sess_role');		
		
		// load view
		$rows = $this->Laporan_model->rat_kembali_aset($tahun)->result();	
		$this->load->library('table');

		$this->table->set_heading('No', 'Nama', 'Komp. Murabahah', 'Komp. Belanja', 'Komp. Listrik', 'Jasa Simp.');
		$i = 0;
		foreach ($rows as $row ):
			$i++;
			$nama = "<a href='".site_url('anggota/view/'.$row->id_anggota.'/'.$tahun.'12')."'>$row->nama</a>";
			$KP_MRBH = array('data' => number_format($row->KP_MRBH), 'class' => 'alignRight');
			$KP_BL = array('data' => number_format($row->KP_BL), 'class' => 'alignRight');
			$KP_RK = array('data' => number_format($row->KP_RK), 'class' => 'alignRight');
			$JS_SK = array('data' => number_format($row->JS_SK), 'class' => 'alignRight');
			$this->table->add_row($i, $nama, $KP_MRBH,$KP_BL,$KP_RK,$JS_SK);
		endforeach;
		$html_table = $this->table->generate(); 
		$data['html_table'] = $html_table;
		$this->load->view('simple_template', $data);
		
		
		
		
		
	}

	
	
	
	
	
	
}
?>