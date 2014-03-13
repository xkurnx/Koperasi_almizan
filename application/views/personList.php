<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Daftar Anggota</title>

<link href="<?php echo base_url(); ?>res/css/style.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="wrapper">
	
	<?php require_once('header.html.php');?>
	
	<div class="content">
		
		<div class="infoValidasi">
		Validasi (coming soon):
		<ul>
		<li>Simpanan tak bertuan = 0</li>		
		<li>Murabahah tak bertuan = 0</li>
		<li>Angsuran tak bertuan = 0</li>
		<li>Jasa Belanja tak bertuan = 0</li>
		<li>Jasa Rekening tak bertuan = 0</li>
		<li>Anggota yang memiliki Tunggakan = 0</li>
		<li>Anggota belum Mendapat Jasa Simpanan Suka Rela = 0 </li>
		<li>Anggota yang tidak memiliki simpanan pokok wajib, dan tetap = 0</li>
		</div>
		<h1>DAFTAR ANGGOTA</h1>
		<div class="paging"><?php echo $pagination; ?></div>
		<div class="data"><?php echo $table; ?></div>
		<br />
		<?php echo anchor('anggota/add/','Tambah Anggota',array('class'=>'add')); ?>
	</div>
</div>	
</body>
</html>