<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kur_functions{
  
  var $profile;
  var $nama;
  
    
    function functions()
    {
        $this->obj =& get_instance();
        $this->prefix = "kop_";   
    }   
  
     
    function periode_to_text($periode)
    {
      $year = substr($periode,0,4);
	  $month = substr($periode,-2);
	  $arrMonth = array('01'=>'Januari','02'=>'Pebruari','03'=>'Maret','04'=>'April',
						'05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September',
						'10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
	  $text = $arrMonth[$month]." ".$year;
	  return $text;
    }
} 
?>
