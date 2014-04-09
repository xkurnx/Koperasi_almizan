<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trans extends CI_Controller {

	// num of records per page
	private $limit = 10;
	private $operator_id =0;
	
	function __construct()
	{
		parent::__construct();
		// load library
		$this->load->library(array('table','form_validation','user_agent','kur_functions'));
		$this->limit = 20;
		
		// load helper
		$this->load->helper('url');
		
		// load model
		$this->load->model('Anggota_model','',TRUE);
		$this->load->model('Keuangan_model','',TRUE);
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		$this->operator_id = $this->session->userdata('kop_sess_userid');;
		
	}
	
	function index($offset = 0)
	{
		
	}
	
	function _get_no_angsuran($id){
		
		$sql = "select init_angsuran_ke+angsuran_ke angsuran_ke from m_murabahah  m 
				left outer join (
				select id_mrbh,sum(nilai) diangsur,sum(case when ket not like '%migrasi%'then 1 else 0 end ) angsuran_ke 
								from d_angsuran
						group by id_mrbh
				) as a on a.id_mrbh=m.id_mrbh
				where m.id_mrbh=$id";
		$data = $this->db->query($sql);
		return $data;			
	}
	
	function _get_no_urut_murabahah(){
		$sql = "select IFNULL(max(urut_mrbh),0)+1 urut_mrbh from m_murabahah where tahun=year(now())";
		$data = $this->db->query($sql);
		return $data;
	}
	
	function del($jenis_trans,$id,$id_anggota){
		switch ($jenis_trans){
			case 'angsuran':				
				
				$table = 'd_angsuran';	
				$this->Keuangan_model->delete($table,'idx',$id,$id_anggota);
				redirect('anggota/view/'.$id_anggota, 'location');	
					
				break;
			
			case 'simpanan':
				// insert simpanan 
				
				$table = 'd_simpanan';	
				$this->Keuangan_model->delete($table,'idx',$id,$id_anggota);
				redirect('anggota/view/'.$id_anggota, 'location');	
					
				break;
			case 'berek':
				
				$table = 'd_berek';	
				$this->Keuangan_model->delete($table,'idx',$id,$id_anggota);
				redirect('anggota/view/'.$id_anggota, 'location');	
					
				break;	
				
			case 'kas':
				
				$table = 'd_kas';	
				$this->Keuangan_model->delete($table,'idx',$id,$id_anggota);
				redirect($this->agent->referrer(), 'location');	
					
				break;		
		}
		
	}
	
	function add()
	{
		$this->kur_auth->is_logged_in();
		$this->kur_auth->allowed(array(0));
		// set common properties
		
		
		/*$jenis_trans
		- angsuran -> id_mrbh
		- simpanan -> kode_simpanan
		- berek -> kode_berek
		*/
		
		
		$nilai = $this->input->post('nilai');
		$jenis_trans = $this->input->post('jenis_trans');
		switch ($jenis_trans){
			case 'angsuran':
				// insert Angsuran 
				// get angsuran ke 	, lalu tambahkan 1
				$angsuran_ke = $this->_get_no_angsuran($this->input->post('id_mrbh'))->row();
				
				$data = array('id_mrbh' => $this->input->post('id_mrbh'),
								'nilai' => $nilai,
								'denda' => $this->input->post('denda'),
								'tgl_trans' => date('Y-m-d', strtotime($this->input->post('tgl_trans_angsuran'))),
								'tgl_input' => date('Y-m-d'),
								'operator' => $this->operator_id,
								'ip' => $_SERVER['REMOTE_ADDR'],
								'ket' => 'Angsuran ke '.($angsuran_ke->angsuran_ke	+ 1 )						
							);
				$table = 'd_angsuran';	
				$id = $this->Keuangan_model->save($table,$data);
				redirect('anggota/view/'.$this->input->post('id_anggota'), 'location');	
				break;
			
			case 'simpanan':
				// insert simpanan 
				$data = array('id_anggota' => $this->input->post('id_anggota'),
								'nilai' => $nilai,
								'kode_simpanan' => $this->input->post('kode_simpanan'),
								'ket' => $this->input->post('ket'),
								'tgl_trans' => date('Y-m-d', strtotime($this->input->post('tgl_trans_simpanan'))),
								'tgl_input' => date('Y-m-d'),
								'ip' => $_SERVER['REMOTE_ADDR']				
							);
				$table = 'd_simpanan';	
				$id = $this->Keuangan_model->save($table,$data);
				redirect('anggota/view/'.$this->input->post('id_anggota'), 'location');	
				break;
			case 'berek':
				// insert berek 
				$data = array('id_anggota' => $this->input->post('id_anggota'),
								'tgl_trans' => date('Y-m-d', strtotime($this->input->post('tgl_trans_berek'))),
								'tgl_input' => date('Y-m-d'),	
								'kode_berek' => $this->input->post('kode_berek'),
								'ket' => $this->input->post('ket'),
								'nilai_pokok' => $this->input->post('nilai_pokok'),
								'nilai' => $nilai,
								'ip' => $_SERVER['REMOTE_ADDR']				
							);
				$table = 'd_berek';	
				$id = $this->Keuangan_model->save($table,$data);
				redirect('anggota/view/'.$this->input->post('id_anggota'), 'location');	
				break;	
			case 'kas':
				// insert berek 
				$data = array('tgl_trans' => date('Y-m-d', strtotime($this->input->post('tgl_trans'))),
								'tgl_input' => date('Y-m-d'),								
								'jenis' => $this->input->post('type'),
								'ket' => $this->input->post('ket'),
								'nilai' => $nilai,
								'ip' => $_SERVER['REMOTE_ADDR']				
							);
				$table = 'd_kas';	
				$id = $this->Keuangan_model->save($table,$data);
				redirect($this->agent->referrer(), 'location');		
				break;	
				case 'create_murabahah':
				// insert Murabahah 
				$jgk = $this->input->post('jgk');
				$margin = 15;
				$urut_mrbh = $this->_get_no_urut_murabahah()->row();
				$jual = $nilai * ( ( 100 + $margin ) / 100 );
				$angsuran = $jual / $jgk ;
				$data = array('tgl_pencairan' => date('Y-m-d', strtotime($this->input->post('tgl_trans_murabahah'))),								
								'jgk' => $jgk,
								'id_anggota' => $this->input->post('id_anggota'), 
								'ket' => $this->input->post('ket'),
								'modal' => $nilai,
								'jual' => $jual,
								'angsuran' => $angsuran,
								'tahun' => date('Y'),
								'urut_mrbh'=> $urut_mrbh->urut_mrbh,
								'ip' => $_SERVER['REMOTE_ADDR']				
							);
				$table = 'm_murabahah';
				$id = $this->Keuangan_model->save($table,$data);
				redirect($this->agent->referrer(), 'location');		
				break;	
				
				case 'tutup_buku':
				// hapus data saldo awal sebelumnya
				$data = array('periode' => $this->input->post('periode'),
								'tgl_create' => date('Y-m-d'),	
								'nilai' => $nilai,
								'catatan' => $this->input->post('catatan')				
							);
				$table = 'd_saldoakhir';	
					
				$this->Keuangan_model->delete($table,'periode',$this->input->post('periode'));				
				/* bagi2 jasa dan Kompensasi */
				$periode = $this->input->post('periode');
				$text_periode = $this->kur_functions->periode_to_text($periode);
				$this->Keuangan_model->_bagi_jasa_dan_kompensasi($periode,$text_periode);
				/* simpan saldo awal */
				$id = $this->Keuangan_model->save($table,$data);
				redirect($this->agent->referrer(), 'location');	
				break;	
				
		
		}
		
		
	}
	
	function multipleadd(){
			
	}
	
	
}
?>