<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kur_log{
	
	private $tbl_log= 't_log';	
	
	function Kur_log(){
		 $this->obj =& get_instance();
		 $this->prefix = "kop_";  
		 
	}
	
	function list_all(){
		$this->db1 = $this->obj->load->database('default',true);
		$this->db1->order_by('id','asc');
		return $this->db1->get($tbl_log);
	}
	
	function write($object_id,$log){
		$this->db1 = $this->obj->load->database('default',true);
		$operator_id = $this->obj->session->userdata( $this->prefix."sess_userid" );
		$operator_name = $this->obj->session->userdata( $this->prefix."sess_username" );
		$log .= " oleh ".$operator_name."(".$operator_id.")";
		$activity = array('anggota_id' => $object_id,
						  'aktivitas' => $log,
						  'ip' => $_SERVER['REMOTE_ADDR'],		
						  'waktu' => date('Y-m-d h:i:s'));	
				  
		$this->db1->insert($this->tbl_log, $activity);
		return $this->db1->insert_id();
	}
	

}
?>