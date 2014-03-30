<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db extends CI_Controller {

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
	
	function index($offset = 0)
	{
		// offset
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		echo "backup";
	}
	
	function backup(){
		$this->load->helper('download');
		$tanggal=date('Ymd');
		$namaFile= 'db_koperasi_' . $tanggal . '.sql.zip';
		$this->load->dbutil();
		$backup=& $this->dbutil->backup();
		force_download($namaFile, $backup);
	}
	
	
}
?>