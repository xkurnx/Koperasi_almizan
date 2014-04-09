<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>List Transaksi</title>
<?php
 require_once('head.assets.php');
?>

<style>
<?php if ( $role_user != 0 ) echo "a.add{display:none}";?>
</style>
</head>
<body>	
<div class="wrapper">
	<?php require_once('header.html.php');?>
	<div class="content">
		<h1><?php echo $title; ?></h1>
		<div class="boxWarning">
		 <ul>
		 <li>Kas Keluar disini adalah semua Pengeluaran Kas selain Murahabah,dan Jasa</li>
		 <li>Kas Keluar Masuk adalah semua Penerimaan Selain Simpanan, Angsuran, dan Denda</li>
		 </ul>
		 </div>
		 <!-- multipl form untuk kas keluar -->
		 <form class="KasKeluarForm" action="<?php echo site_url('trans/multipleadd');?>">
		 <table>
		 <tr><td width="300">Transaksi Keluar</td><td>Nilai (Rp.)</td><td>Tgl. Trans</td><td></td></tr>
		 <?php
		 foreach ($recent_kas_keluar as $kas):
		 ?>		 
		 <tr><td><input type="text" name="nama_trans" value="<?php echo $kas->ket;?>"></td><td><input type="text" name="nilai_trans" value=""></td><td><input type="text" name="tgl_trans" value=""></td><td><a class="btnDelRow" href="javascript:;">del</a></td></tr>
		 <?php
		 endforeach;
		 ?>
		 </table>
		 <input type="submit" value="OK">
		 </form>
		<?php if ( isset($link_add) ) echo $link_add;?>
		<div class="data"><?php echo $table; ?></div>
		<br />
		<?php echo $link_back; ?>
	</div>
</div>	

<?php
 if (isset($modalWindow)) echo $modalWindow;
?>
<!--
<div class="overlay"></div>	
	<div id="formAddAngsuran" class="modalBox">	
		<div class="modalTitle">Modal Title</div>
		<form id="formAddTrans" autocomplete="off" method="post" action="<?php if ( isset($action) ) echo $action;?>">
			Nama Transaksi <br />
			<input type="text" class="text" name="ket" value="">
			<br />Nilai Transaksi <br />
			<input type="text" class="text" name="nilai" value="">
			<br />Tgl Transaksi <br />
			<input type="text" value="" class="text" name="tgl_trans"><a onclick="displayDatePicker('tgl_trans');"><img src="<?php echo base_url(); ?>res/css/images/calendar.png" alt="calendar" border="0"></a>
			<input type="hidden" name="jenis_trans" value="angsuran">
			<input type="hidden" name="id_trans" value="">
			<br />
			<input type="submit" class="btnSubmit" value="OK">
			<input type="button" class="btnBatal cancel" value="Batal">
		</form>
		<div id="cM" class="contentSource">
			<span class="title">Kas Masuk</span>  
		</div>
		<div id="cK" class="contentSource">
			<span class="title">Kas Keluar</span>  
		</div>
			
		
	</div>
-->	
</body>
</html>