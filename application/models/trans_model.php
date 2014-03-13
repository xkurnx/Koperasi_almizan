<?php
class Trans_model extends CI_Model {
	
	
	function __construct(){
		parent::__construct();
	}
	
	function list_all(){
		$this->db->order_by('id','asc');
		return $this->db->get($tbl_person);
	}
	
	function count_all(){
		return $this->db->count_all($this->tbl_person);
	}
	
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('user_id','asc');
		return $this->db->get($this->tbl_person, $limit, $offset);
	}
	
	function fetch_jumlah_simpanan_id($id){
		$sql = "select sum(case when kode_simpanan='SP' then nilai end) as T_SP,
				sum(case when kode_simpanan='SW' then nilai end) as T_SW,
				sum(case when kode_simpanan='SK' then nilai end) as T_SK,
				sum(case when kode_simpanan='JS' then nilai end) as T_JS				
				from d_simpanan
				where id_anggota=$id";
		$data = $this->db->query($sql);
		return $data;		
	}
	
	function fetch_simpanan_id($jenis,$id){
		$sql = "select tgl_trans,kode_simpanan, 
				case when nilai < 0 then 'penarikan' else 'penyetoran' end as jenis,nilai,ket
				from d_simpanan				
				where id_anggota=$id
				and kode_simpanan='$jenis'
				order by tgl_trans asc";
		$data = $this->db->query($sql);
		return $data;	
	}
	
	function fetch_angsuran_id($id_mrbh){
		$sql = "select * from d_angsuran				
				where id_mrbh=$id_mrbh
				order by tgl_trans asc";
		$data = $this->db->query($sql);
		return $data;
	
	}
	
	function fetch_rekap_murabahah_id($id){
		 $sql = "select * from m_murabahah  m 
				left outer join (
				select id_mrbh,sum(nilai) diangsur
								from d_angsuran
						group by id_mrbh
				) as a on a.id_mrbh=m.id_mrbh
				where m.id_anggota=$id";
		#echo $sql;
		$data = $this->db->query($sql);
		return $data;		
	}	
	
	
	function save($person){
		$this->db->insert($this->tbl_person, $person);
		return $this->db->insert_id();
	}
	
	function update($id, $person){
		$this->db->where('user_id', $id);
		$this->db->update($this->tbl_person, $person);
	}
	
	function delete($id){
		$this->db->where('user_id', $id);
		$this->db->update($this->tbl_person, $person);
	}
}
?>