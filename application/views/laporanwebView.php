<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $title; ?></title>

<?php
 require_once('head.assets.php');
?>

</head>
<body>
<div class="wrapper">
	<?php require_once('header.html.php');?>
	<div class="content">
	<h1><?php echo $title; ?></h1>
		<span class="hide periode_hidden"><?php echo $periode;?></span>
		
		<ul class="menuSubLaporan">
		<?php
		preg_match("/laporan\/(?P<name>\w+)/",$base_url,$matches);	
		$current_laporan = $matches[1];		
		$sub_laporan = array ('Buku Kas Harian'=>'transaksi_harian','Rekap Simpanan ' => 'rekap_simpanan');	
		foreach ( $sub_laporan as $key => $v ):	
			if ( $current_laporan != $v ) { 
				echo "<li><a href='".site_url('laporan/'.$v.'/'.$periode)."'>$key</a></li>";
			}	
		endforeach;
		?>
		</ul>	
		<a class="xls excel" href="<?php echo $base_url.'/'.$periode.'/xls';?>">download sebagai excel</a><br /><br />
		<div class="data">
		<?php echo $html_table;?>		
	</div>	
	
</div>	
</body>
</html>