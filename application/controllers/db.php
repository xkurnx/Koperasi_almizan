<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db extends CI_Controller {

	// num of records per page
	private $limit = 10;
	
	function __construct()
	{
		parent::__construct();
		// load library
		$this->load->library(array('table','form_validation','session','kur_functions','Unzip'));
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
		
		$prefs = array(
                'format'      => 'zip',
				'filename'    => 'dbAppKopAlmizan.sql',    // File name - NEEDED ONLY WITH ZIP FILES
				'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );

		$backup = $this->dbutil->backup($prefs); 
		force_download($namaFile, $backup);
	}
	
	function restore(){
		$data['error'] = '';
		echo $this->load->view('upload_sql', $data,true);
	
	}
	
	function do_restore(){
		$name=time();
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'zip|rar';
		if ( !$this->input->post('pwd') != 'almizan2014' )
		{
			exit('Access Denied');
		}
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_sql', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			// Optional: Only take out these files, anything else is ignored
			$this->unzip->allow(array('sql', 'js', 'png', 'gif', 'jpeg', 'jpg', 'tpl', 'html', 'swf'));
			#echo $data['upload_data']['full_path'];
			$extracted = $this->unzip->extract($data['upload_data']['full_path']) ;
			
			$this->load->helper('file');
			$query = utf8_decode (read_file($extracted [0] ));
			$sqls = explode(';', $query);
				array_pop($sqls);
				 
				foreach($sqls as $statement){
					$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
					$this->db->query($statement);
					$this->db->query("SET FOREIGN_KEY_CHECKS = 1");
				}
				echo "done";
		}
		
	}
	
	
	
}
?>