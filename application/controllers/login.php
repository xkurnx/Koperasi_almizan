<?php

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->library(array('session','Kur_auth'));
		// load helper
		$this->load->helper('url');
	}
	
	function index()
	{
	  $data['fungsi'] = "INDEX";
	  $data['frmAction'] = site_url('login/cek/');
	  $this->load->view('login',$data);
	}
	
	function cek()
	{
		if( $this->kur_auth->check() )
		{
		  $this->kur_auth->set_session();
		  // kalo yang login = 0, lalu ke halaman list anggota
		  if ( $this->session->userdata("kop_sess_role") == 0 ) 
			header("location:".site_url('anggota/'));  
		  else
			header("location:".site_url('anggota/home')); 
		  
		}
		else
		{
		  $data['frmAction'] = site_url('login/cek/');
		  $data['msg'] = "Login Error";
		  $this->load->view('login',$data);
		}    
    
	}
	function logout()
	{
		$log = "Logout";		
		#$this->kur_log->write($id,$log);
		echo $this->kur_auth->logout();    
    
	}
	
	
}

