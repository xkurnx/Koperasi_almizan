<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kur_auth{
  
  var $profile;
  var $nama;
  
    
    function Kur_auth()
    {
        $this->obj =& get_instance();
        $this->prefix = "kop_";   
    }   
  
     
    function check()
    {
      $userid = $this->obj->input->post("user");
      $passwd = $this->obj->input->post("password");
      $this->userid = "guest";
      $this->nama = "Guest";
      $this->role = "99";
      
      #check to database
      $this->db1=$this->obj->load->database('default',true);
      $cek=$this->db1->query("select * from m_anggota where id_anggota = '$userid' and pass=md5('$passwd')");
      
      if(	$cek->num_rows()>0	){      
        foreach(	$cek->result() as $result	){
          $this->user_id = $result->id_anggota;
          $this->user_name = $result->nama;
          $this->role = $result->role;   
		  #echo $this->profile."x";
		#  exit;
        }          
       return true;
      }
      
      else{
        return false;
      }
      
      /*DO SOME CHEKCING*/
    }
    
    function is_logged_in(){
    if( $this->obj->session->userdata( $this->prefix."sess_userid" ) == null ){
      redirect('login/', 'location');
      return false;
     }
     else
     {
      return true;
     }    
    }
	
	function allowed($roles) {
	if ( !in_array($this->obj->session->userdata( $this->prefix."sess_role" ) , $roles ) ){
      echo "Permission Denied";
      exit;
	  return false;
     }
     else
     {
      return true;
     }    
    }
    
    
    function logout(){
      $this->obj->session->unset_userdata($this->prefix."sess_userid");
      redirect('login/', 'location');
    }
    
    function set_session(){
      $this->role = 1 ; // on live, ADMIN(0) is not allowed
	  $array = array(
				$this->prefix."sess_userid"=>"$this->user_id",
				$this->prefix."sess_username"=>"$this->user_name",
				$this->prefix."sess_role"=>"$this->role");
      $this->obj->session->set_userdata($array);        
    }
} 
?>
