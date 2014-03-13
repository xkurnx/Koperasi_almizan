<?php
class Anggota_model extends CI_Model {
	
	private $tbl_person= 'm_anggota';
	
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
		$this->db->order_by('id_anggota','asc');
		return $this->db->get($this->tbl_person, $limit, $offset);
	}
	
	function get_by_id($id){
		$this->db->where('id_anggota', $id);
		return $this->db->get($this->tbl_person);
	}
	
	function save($person){
		$this->db->insert($this->tbl_person, $person);
		return $this->db->insert_id();
	}
	
	function update($id, $person){
		$this->db->where('id_anggota', $id);
		$this->db->update($this->tbl_person, $person);
	}
	
	function delete($id){
		$this->db->where('id_anggota', $id);
		$this->db->update($this->tbl_person, $person);
	}
}
?>