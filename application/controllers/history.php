<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History extends CI_Controller {

	// num of records per page
	private $limit = 10;
	
	function __construct()
	{
		parent::__construct();
		// load library
		$this->load->library(array('table','form_validation','session'));
		$this->limit = 20;
		
		// load helper
		$this->load->helper('url');
		
		// load model
		$this->load->model('Anggota_model','',TRUE);
		$this->load->model('Keuangan_model','',TRUE);
		$this->kur_auth->is_logged_in();
		//$this->kur_auth->allowed(array(0));
		
	}
	
	function index($offset = 0)
	{
		// offset
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		
		// load data
		$persons = $this->Anggota_model->get_paged_list($this->limit, $offset)->result();
		// generate pagination
		$this->load->library('pagination');
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		$config['base_url'] = site_url('anggota/index/');
 		$config['total_rows'] = $this->Anggota_model->count_all();
 		$config['per_page'] = $this->limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('No', 'ID Anggota', 'Nama','JK', 'Tgl lahir (dd-mm-yyyy)', 'Actions');
		$i = 0 + $offset;
		foreach ($persons as $person)
		{
			$this->table->add_row(++$i, $person->id_anggota, $person->nama, strtoupper($person->jk)=='M'? 'Male':'Female', date('d-m-Y',strtotime($person->tgl_lahir)), 
				anchor('anggota/view/'.$person->id_anggota,'view',array('class'=>'view')).' '.
				anchor('anggota/update/'.$person->id_anggota,'update',array('class'=>'update')).' '.
				anchor('anggota/disable/'.$person->id_anggota,'nonaktifkan',array('class'=>'delete','onclick'=>"return confirm('Are you sure want to delete this person?')"))
			);
		}
		$data['table'] = $this->table->generate();
		
		// load view
		$this->load->view('personList', $data);
	}
	
	function simpanan($jenis,$id){
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		$this->load->library('table');
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('No', 'Tgl Transaksi', 'Jenis','Nilai','Keterangan');
		$i = 0;
		$simpanans = $this->Keuangan_model->fetch_simpanan_id($jenis,$id)->result();	
		$jml = 0;
		foreach ($simpanans as $simpanan)
				{
					$jml += $simpanan->nilai;
					$nilai = array('data' => number_format($simpanan->nilai,2,',','.'),'class' => 'alignRight');
					$this->table->add_row(++$i, $simpanan->tgl_trans, $simpanan->jenis.' '.$simpanan->kode_simpanan,
					$nilai ,$simpanan->ket);
				}		
		
		$cell = array('data' => 'Jumlah','class' => 'bold','colspan' => 3);	
		$nilai = array('data' => number_format($jml,2,',','.'),'class' => 'bold alignRight');		
		$this->table->add_row($cell, $nilai);		
		$data['title'] ="History Simpanan";
		$data['link_back'] = '<a class="back" href="javascript:window.history.back()">Kembali</a>';
		$data['table'] = $this->table->generate();
		
		// load view
		$this->load->view('transaksiList', $data);
	}
	
	function berek($jenis,$id){
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		$this->load->library('table');
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('No', 'Tgl Transaksi', 'Jenis','Nilai','Keterangan');
		$i = 0;
		$bereks = $this->Keuangan_model->fetch_berek_id($jenis,$id)->result();	
		$jml = 0;
		foreach ($bereks as $berek)
				{
					$jml += $berek->nilai;
					$nilai = array('data' => number_format($berek->nilai,2,',','.'),'class' => 'alignRight');
					$this->table->add_row(++$i, $berek->tgl_trans, $berek->jenis.' '.$berek->kode_berek,
					$nilai ,$berek->ket);
				}		
		
		$cell = array('data' => 'Jumlah','class' => 'bold','colspan' => 3);	
		$nilai = array('data' => number_format($jml,2,',','.'),'class' => 'bold alignRight');		
		$this->table->add_row($cell, $nilai);		
		
		$data['title'] ="History Simpanan";
		$data['link_back'] = '<a class="back" href="javascript:window.history.back()">Kembali</a>';
		$data['table'] = $this->table->generate();
		
		// load view
		$this->load->view('transaksiList', $data);
	}

	function angsuran($id_mrbh){
		
		$this->load->library('table');
		$this->table->set_empty("&nbsp;");
		
		$this->table->set_heading('No', 'Tgl Transaksi', 'Nilai','Keterangan');
		$i = $jml = 0 ;
		$simpanans = $this->Keuangan_model->fetch_angsuran_id($id_mrbh)->result();	
		foreach ($simpanans as $simpanan)
				{
					$jml += $simpanan->nilai;
					$nilai = array('data' => number_format($simpanan->nilai,2,',','.'),'class' => 'alignRight');		
					$this->table->add_row(++$i, $simpanan->tgl_trans,$nilai ,$simpanan->ket);
				}		
		$cell = array('data' => 'Jumlah','class' => 'bold','colspan' => 2);	
		$nilai = array('data' => number_format($jml,2,',','.'),'class' => 'bold alignRight');		
		$this->table->add_row($cell, $nilai);	
	
		$data['title'] = "Riwayat Angsuran";
		$data['link_back'] = '<a class="back" href="javascript:window.history.back()">Kembali</a>';
		$data['table'] = $this->table->generate();
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		
		// load view
		$this->load->view('transaksiList', $data);
	}	
	
	function kas($type,$periode=''){
		$this->load->library('table');
		$this->table->set_empty("&nbsp;");
		
		$this->table->set_heading('No','Jenis','Ket', 'Tgl Transaksi', 'Nilai','Action');
		$i = $jml = 0 ;
		$rows = $this->Keuangan_model->fetch_kas( strtoupper($type), $periode )->result();	
		foreach ($rows as $row)
				{
					$jml += $row->nilai;
					$nilai = array('data' => number_format($row->nilai,2,',','.'),'class' => 'alignRight');	
					$link_hapus = "<a class='delete' href='javascript:;' onclick=\"show_confirm('Ingin Menghapus Transaksi ini?','".site_url('trans/del/kas/'.$row->idx)."/0')\">hapus</a>";					
					if ( $row->is_deletable != '' )
					$link_hapus = "";
					$this->table->add_row(++$i, $row->jenis_format,$row->ket,$row->tgl_trans,$nilai ,$link_hapus);
				}		
		$cell = array('data' => 'Jumlah','class' => 'bold','colspan' => 4);	
		$nilai = array('data' => number_format($jml,2,',','.'),'class' => 'bold alignRight');		
		$this->table->add_row($cell, $nilai);	
		$data['link_add'] = "<a href=\"javascript:set_field('kas','".strtoupper($type)."')\" class='add'>Tambah Transaksi</a>";
		$data['link_back'] = '<a class="back" href="javascript:window.history.back()">Kembali</a>';
		$data['action'] = site_url('trans/add');	
		
		$data['table'] = $this->table->generate();
		$data['title'] = "History Kas";
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		
		// load view
		$this->load->view('transaksiList', $data);	
	}
		
}
?>