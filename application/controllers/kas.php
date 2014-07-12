<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kas extends CI_Controller {

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
		$this->load->model('Anggota_model','',TRUE);
		$this->load->model('Keuangan_model','',TRUE);
		
		
		
	}
	function index(){
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		$this->semua(date('Ym'));
	}
	
	function semua($periode){
		$this->_kas('All',$periode);
	}
	
	function masuk($periode){
		$this->_kas('M',$periode);
	}
	
	function keluar($periode){
		$this->_kas('K',$periode);
	}
	
	function _kas($type,$periode)
	{
		// offset
		$uri_segment = 3;
		$offset = ( $this->uri->segment($uri_segment)  )?  $this->uri->segment($uri_segment) : 0;
		
		$this->load->library('pagination');
		$config['base_url'] = site_url('kas/index/');
 		
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('kas/index/');
 		$config['total_rows'] = $this->Anggota_model->count_all();
 		$config['per_page'] = $this->limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$this->table->set_heading('No','Jenis','Ket', 'Tgl Transaksi', 'Nilai','Action');
		$i = $jml = 0 ;
		$rows = $this->Keuangan_model->fetch_kas( strtoupper($type), $periode , $this->limit, $offset)->result();	
		$recent_kas_keluar = $this->Keuangan_model->fetch_recent_kas_keluar()->result();	
		
		foreach ($rows as $row)
				{
					$jml += $row->nilai;
					$nilai = array('data' => number_format($row->nilai,2,',','.'),'class' => 'alignRight');	
					$link_hapus = ( $row->is_deletable == 0 ) ? "":"<a class='delete' href='javascript:;' onclick=\"show_confirm('Ingin Menghapus Transaksi ini?','".site_url('trans/del/kas/'.$row->idx)."/0')\">hapus</a>";					
					$this->table->add_row(++$i, $row->jenis_format,$row->ket,$row->tgl_trans,$nilai ,$link_hapus);
				}		
		$cell = array('data' => 'Jumlah','class' => 'bold','colspan' => 4);	
		$nilai = array('data' => number_format($jml,2,',','.'),'class' => 'bold alignRight');		
		$this->table->add_row($cell, $nilai);	
		$data['role_user'] = $this->session->userdata('kop_sess_role');
		$data['title'] = 'Transaksi Kas periode '.$this->kur_functions->periode_to_text($periode);
		$data['link_add'] = "<a href=\"javascript:add_kas('kas','".strtoupper($type)."')\" class='add'>Tambah satu Transaksi Masuk/Keluar</a>";
		$data['link_back'] = '<a class="back" href="javascript:window.history.back()">Kembali</a>';
		
		$data['table'] = $this->table->generate();
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		
		$data['recent_kas_keluar'] = $recent_kas_keluar; 
		
		
	// modal window untuk add Kas
		$datamodal['periode'] = $periode; 
		$datamodal['type'] = $type; // k -or- m
		$datamodal['action'] = site_url('trans/add');
		$data['modalWindow'] = $this->load->view('modalWindowKasView', $datamodal,true); 
		// load view
		$this->load->view('kasView', $data);
	}
		
}
?>