<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anggota extends CI_Controller {

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
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		
		// load data
		$persons = $this->Anggota_model->get_paged_list($this->limit, $offset)->result();
		// generate pagination
		$this->load->library('pagination');
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
			$this->table->add_row(++$i, $person->id_anggota, $person->nama, strtoupper($person->jk)=='L'? 'Laki-laki':'Perempuan', date('d-m-Y',strtotime($person->tgl_lahir)), 
				anchor('anggota/view/'.$person->id_anggota,'lihat detail',array('class'=>'view')).' '.
				anchor('anggota/update/'.$person->id_anggota,'Ubah',array('class'=>'delete'))
			);
		}
		$data['role_user'] = $this->session->userdata('kop_sess_role');
		$data['table'] = $this->table->generate();
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		
		// load view
		$this->load->view('personList', $data);
	}
	
	function add()
	{
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		$data['title'] = 'Tambah Anggota';
		$data['message'] = '';
		$data['action'] = site_url('anggota/addPerson');
		$data['link_back'] = anchor('anggota/index/','Kembali ke Daftar Anggota',array('class'=>'back'));
	
		// set empty default form field values
		$this->_set_fields();
		// set validation properties
		$this->_set_rules();
		// load view
		$this->load->view('personEdit', $data);
	}	
	
	function home(){
		// set common properties
		$id = $this->session->userdata('kop_sess_userid');
		$this->_view($id,'');	
	}
	
	function view($id,$periode=''){
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		$this->_view($id,$periode);	
		
	}
	
	function cetak( $id,$periode='' ){
		$this->kur_auth->is_logged_in();
		#$this->kur_auth->allowed(array(0));
		$this->_cetak($id,$periode);	
	}
	
	/* untuk halaman member, sekalian halaman detail dr web,
		berisi :
		- profile anggota
		- Rekap Simpanan
		- Rekap Belanja & Rekening
		- Rekap Murabahah
		- 15 Transaksi Terakhir, tp klo ada $periode, ambil dari periode berjalan
		*/
	private function _view($id,$periode)
	{
		// set common properties
		$data['title'] = 'Informasi Anggota';
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		$data['action'] = site_url('trans/add');		
		$data['link_back'] = anchor('anggota/index/','Kembali ke Daftar',array('class'=>'back'));
	
		// get person details
		$data['person'] = $this->Anggota_model->get_by_id($id)->row();
		$data['periode'] = $periode;
		
		// get keuangan details
		$this->Keuangan_model->set_periode($periode);
		$data['simpanan'] = $this->Keuangan_model->fetch_jumlah_simpanan_id($id)->row();
		$data['murabahah'] = $this->Keuangan_model->fetch_rekap_murabahah_id($id)->result();
		$data['qordunhasan'] = $this->Keuangan_model->fetch_rekap_qhasan_id($id)->result();		
		
		$data['trans'] = $this->Keuangan_model->fetch_recent_trans_id($id)->result();
		$data['berek'] = $this->Keuangan_model->fetch_jumlah_berek_id($id)->row();
		$data['role_user'] = $this->session->userdata('kop_sess_role');
		
		// load view
		$this->load->view('personView', $data);
	}
	
	/* untuk halaman cetak rekap dan transaksi anggota per bulan
		berisi :
		- profile anggota
		- Rekap Simpanan
		- Rekap Belanja & Rekening
		- Rekap Murabahah
		- 15 Transaksi Terakhir
		*/
	
	private function _cetak($id,$periode)	
	{
		// set common properties
		$this->Keuangan_model->set_periode($periode);
		// get person details
		$data['person'] = $this->Anggota_model->get_by_id($id)->row();
		if ($periode != '' ) $data['periode_to_text'] = $this->kur_functions->periode_to_text($periode);
		// get keuangan details
		$data['simpanan'] = $this->Keuangan_model->fetch_jumlah_simpanan_id($id)->row();
		$data['murabahah'] = $this->Keuangan_model->fetch_rekap_murabahah_id($id)->result();
		$data['trans'] = $this->Keuangan_model->fetch_recent_trans_id($id)->result();
		$data['berek'] = $this->Keuangan_model->fetch_jumlah_berek_id($id)->row();
		$data['role_user'] = $this->session->userdata('kop_sess_role');
		
		// load view
		$this->load->view('anggotaCetak', $data);
	}
	
	function update($id)
	{
		
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		// set validation properties
		$this->_set_rules();
		
		// prefill form values
		$person = $this->Anggota_model->get_by_id($id)->row();
		$this->form_data->id_anggota = $id;
		$this->form_data->tmt_aktif = $person->tmt_aktif;
		$this->form_data->tmt_nonaktif = $person->tmt_nonaktif;
		$this->form_data->nama = $person->nama;
		$this->form_data->jk = strtoupper($person->jk);
		$this->form_data->tgl_lahir = date('d-m-Y',strtotime($person->tgl_lahir));
		
		// set common properties
		$data['title'] = 'Update person';
		$data['message'] = '';
		$data['action'] = site_url('anggota/updateAnggota');
		$data['link_back'] = anchor('anggota/index/','Kembali ke Daftar Anggota',array('class'=>'back'));
	
		// load view
		$this->load->view('personEdit', $data);
	}
	
	function updateAnggota()
	{
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		$data['name_login'] = $this->session->userdata('kop_sess_username');
		
		// set common properties
		$data['title'] = 'Update person';
		$data['action'] = site_url('anggota/updateAnggota');
		$data['link_back'] = anchor('anggota/index/','Back to list of persons',array('class'=>'back'));
		// save data
		$id = $this->input->post('id');
		// set empty default form field values
		$this->_set_fields();
		// set validation properties
		$this->_set_rules();
		
		// run validation
		if ($this->form_validation->run() == FALSE)
		{
			$data['message'] = '';
		}
		else
		{
			$person = array('nama' => $this->input->post('nama'),
							'jk' => $this->input->post('jk'),
							'tmt_aktif' => date('Y-m-d', strtotime($this->input->post('tmt_aktif'))),
							'tmt_nonaktif' => date('Y-m-d', strtotime($this->input->post('tmt_nonaktif'))));
			if ( $this->input->post('pass') != '' )
			{ $person['pass'] = md5($this->input->post('pass')); }
			$this->Anggota_model->update($id,$person);
			
			// set user message
			$data['message'] = '<div class="success">Data Anggota Berhasil diUbah</div>';
		}
		
		// load view
		$this->load->view('personEdit', $data);
		
		/* Logging */
		$log = "Data Dirubah : ".$this->input->post('user_name')."#".$this->input->post('nama')."#".$this->input->post('tgl_lahir');		
		$this->kur_log->write($id,$log);
	}
	
	
	function addPerson()
	{
		// set empty default form field values
		$this->_set_fields();
		// set validation properties
		$this->_set_rules();
		
		// run validation
		if ($this->form_validation->run() == FALSE)
		{
			$data['message'] = '';
		}
		else
		{
			// save data
			$person = array('nama' => $this->input->post('nama'),
							'jk' => $this->input->post('jk'),
							'role' => 2,
							'pass' => md5($this->input->post('pass')),
							'is_active' => 1,
							'tmt_aktif' => date('Y-m-d', strtotime($this->input->post('tmt_aktif'))));
		
			$id = $this->Anggota_model->save($person);
			// set user message
			$data['message'] = '<div class="success">Anggota  baru berhasil ditambah</div>';
		}
		
		// load view
		$this->load->view('personEdit', $data);
		
		/* Logging */
		$log = "Data tambah : ".$this->input->post('user_name')."#".$this->input->post('nama')."#".$this->input->post('tgl_lahir');		
		$this->kur_log->write($id,$log);
	}
	
	
	
	function disable($id)
	{
		// delete person
		$person = array('is_active' => 0 );
		$this->Anggota_model->update($id,$person);
		
		/* Logging */
		$log = "Dinonaktifkan";		
		$this->kur_log->write($id,$log);
		
		// redirect to person list page
		redirect('anggota/index/','refresh');
	}
	
	function enable($id)
	{
		// delete person
		$person = array('is_active' => 1 );
		$this->Anggota_model->update($id,$person);
		
		
		/* Logging */
		$log = "Diaktifkan";		
		$this->kur_log->write($id,$log);
		
		// redirect to person list page
		redirect('anggota/index/','refresh');
	}
	
	// set empty default form field values
	function _set_fields()
	{
		$this->form_data->id_anggota = '';
		$this->form_data->nama = '';
		$this->form_data->jk = '';
		//$this->form_data->tgl_lahir = '';
		$this->form_data->tmt_aktif = '';
		$this->form_data->tmt_nonaktif = '';
	}
	
	// validation rules
	function _set_rules()
	{
		$this->form_validation->set_rules('nama', 'Name', 'trim|required');
		$this->form_validation->set_rules('jk', 'Gender', 'trim|required');
		//$this->form_validation->set_rules('tgl_lahir', 'DoB', 'trim|required|callback_valid_date');
		//$this->form_validation->set_rules('tmt_aktif', 'DoB', 'trim|required|callback_valid_date');
		$this->form_validation->set_message('required', '* required');
		$this->form_validation->set_message('isset', '* required');
		$this->form_validation->set_message('valid_date', 'date format is not valid. dd-mm-yyyy');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	}
	
	// date_validation callback
	function valid_date($str)
	{
		//match the format of the date
		if (preg_match ("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/", $str, $parts))
		{
			//check weather the date is valid of not
			if(checkdate($parts[2],$parts[1],$parts[3]))
				return true;
			else
				return false;
		}
		else
			return false;
	}
}
?>