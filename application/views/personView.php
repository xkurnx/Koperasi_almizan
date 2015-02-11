<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $title; ?></title>

<?php
 require_once('head.assets.php');
?>

<style>
<?php if ( $role_user != 0 ) echo "a.add,a.delete{display:none}";?>
</style>

<?php
// tgl transaksi default setiap tgl 5
$tgl_default = "05-12-2013";
?>
</head>
<body>
<div class="wrapper">
	<?php require_once('header.html.php');?>
	<div class="content">
		<h1><?php echo $title; ?></h1>
		<div class="data">
		<table>
			<tr>
				<td width="20%">Nomor Anggota</td>
				<td><?php echo $person->id_anggota; ?>
				<a class="cetak" href="javascript:cetakBuku('<?php echo $person->id_anggota; ?>','<?php echo $periode; ?>');">cetak</a>
				</td>
			</tr>
			<tr>
				<td valign="top">Nama Anggota</td>
				<td><?php echo $person->nama; ?></td>
			</tr>
			<tr>
				<td valign="top">Jenis Kelamin</td>
				<td><?php echo strtoupper($person->jk)=='L'? 'Laki-Laki':'Perempuan' ; ?></td>
			</tr>
			<!-- <tr>
				<td valign="top">Tgl Lahir (dd-mm-yyyy)</td>
				<td><?php echo date('d-m-Y',strtotime($person->tgl_lahir)); ?></td>
			</tr>
			-->
			<tr>
				<td valign="top">Simpanan</td>
				<td>
				<table class='w400 noBorder'>
				<?php
				 echo "<tr><td>Simpanan Pokok <a href=\"javascript:add_simpanan('SP',20000)\" class='add'>Anggota agt baru</a> | <a href=\"javascript:add_simpanan('SP',-20000)\" class=''>pengmb. aset</a></td></td><td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/simpanan/SP/'.$person->id_anggota)."'>".number_format($simpanan->T_SP,2,',','.')."</a></td></tr>";
				 echo "<tr><td>Simpanan Wajib <a href=\"javascript:add_simpanan('SW','65000')\" class='add'>tambah transaksi</a> | <a href=\"javascript:add_simpanan('SW','-".$simpanan->T_SW."')\">Pengmb. aset</a></td><td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/simpanan/SW/'.$person->id_anggota)."'>".number_format($simpanan->T_SW,2,',','.')."</a></td></tr>";
				 echo "<tr><td>Simpanan Sukarela <a href=\"javascript:add_simpanan('SK','50000')\" class='add'>tambah transaksi </a> | <a href=\"javascript:add_simpanan('SK','-".$simpanan->T_SK."')\">Pengmb. aset</a></a></td><td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/simpanan/SK/'.$person->id_anggota)."'>".number_format($simpanan->T_SK,2,',','.')."</a></td></tr>";
				 echo "<tr><td>Jasa Simpanan Sukarela <a href=\"javascript:add_simpanan('JS','-".$simpanan->T_JS."')\" class=''>pengmb. aset</a></td><td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/simpanan/JS/'.$person->id_anggota)."'>".number_format($simpanan->T_JS,2,',','.')."</a></td></tr>";				 
				 echo "<tr><td>Kompensasi Murabahah <a href=\"javascript:add_simpanan('KP','-".$simpanan->T_KP."')\" class=''>pengmb. aset</a></td><td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/simpanan/KP/'.$person->id_anggota)."'>".number_format($simpanan->T_KP,2,',','.')."</a></td></tr>";				 
				 echo "<tr><td>Kompensasi Belanja <a href=\"javascript:add_simpanan('KP_BL','-".$simpanan->T_KP_BL."')\" class=''>pengmb. aset</a></td><td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/simpanan/KP_BL/'.$person->id_anggota)."'>".number_format($simpanan->T_KP_BL,2,',','.')."</a></td></tr>";				 
				 echo "<tr><td>Kompensasi Rekening <a href=\"javascript:add_simpanan('KP_RK','-".$simpanan->T_KP_RK."')\" class=''>pengmb. aset</a></td><td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/simpanan/KP_RK/'.$person->id_anggota)."'>".number_format($simpanan->T_KP_RK,2,',','.')."</a></td></tr>";				 
				 echo "<tr><td>Jumlah Simpanan</td><td class='w20'>Rp.</td><td class='uang'> <strong>".number_format($simpanan->T_SP + $simpanan->T_SW + $simpanan->T_SK + $simpanan->T_JS,2,',','.')."</strong></td></tr>";
				?>
				</table>
				</td>				
			</tr>
			<tr>
				<td valign="top">Belanja & Rekening</td>
				<td>
				<table class='w400 noBorder'>
				<?php
				  echo "<tr><td>Jasa Rekening <a href=\"javascript:add_berek('RK')\" class='add'>tambah transaksi</a></td><td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/berek/RK/'.$person->id_anggota)."'>".number_format($berek->T_RK,2,',','.')."</a></td></tr>";
				  echo "<tr><td>Jasa Belanja <a href=\"javascript:add_berek('BL')\" class='add'>tambah transaksi</a></td><td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/berek/BL/'.$person->id_anggota)."'>".number_format($berek->T_BL,2,',','.')."</a></td></tr>";
				?>
				</table>
				</td>
				
			</tr>
			
			<tr>
				<td valign="top">Murabahah <br /><a href="javascript:;" onclick="add_murabahah()" class="add">Buat Murabahah Baru</a></td>
				<td>
				<table class='small w400'>
				<tr class='head'><td class='w300'>Murabahah</td><td>Jangka</td><td>Agsrn Ke</td><td colspan='2'>Harga Jual</td><td colspan='2'>Angsuran/ Bln</td><td colspan='2'>Sudah dibayar</td></tr>
				 
				
				<?php
				foreach ($murabahah as $data ):
					$html = ( $data->diangsur >= $data->jual or $data->diangsur + 4 >= $data->jual )?" <span class='lunas'>- lunas</span>":"<a href=\"javascript:add_angsuran($data->id_mrbh,'MRBH','".($data->jual/$data->jgk)."')\" class='add'>tbh cicilan</a>";
					$ubah_link = "<a href=\"javascript:showMrbhEditForm('$data->id_mrbh','');\">ubah</a>"; 
					echo "<tr><td>$data->ket ($ubah_link) <br/ >$html </td>";
					echo "<td>$data->jgk</td><td>$data->angsuran_ke</td>";
					echo "<td class='w20'>Rp.</td><td class='uang'>".number_format($data->jual,2,',','.')."</td>";
					echo "<td class='w20'>Rp.</td><td class='uang'>".number_format($data->jual/$data->jgk,2,',','.')."</td>";
					echo "<td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/angsuran/'.$data->id_mrbh)."'>".number_format($data->diangsur,2,',','.')."</a></td></tr>";
				endforeach;
					?>
				</table>
				</td>
			</tr>
			
			<!-- ------------------------- qordun hasan ----------------------------->
			<tr>
				<td valign="top">Qordun Hasan <br /><a href="javascript:;" onclick="add_qhasan()" class="add">Buat Qordun Hasan Baru</a></td>
				<td>
				<table class='small w400'>
				<tr class='head'><td class='w300'>Qordun Hasan</td><td>Jangka</td><td>Agsrn Ke</td><td colspan='2'>Harga Jual</td><td colspan='2'>Angsuran/ Bln</td><td colspan='2'>Sudah dibayar</td></tr>
				 
				
				<?php
				foreach ($qordunhasan as $data ):
					$html = ( $data->diangsur >= $data->jual )?" <span class='lunas'>- lunas</span>":"<a href=\"javascript:add_angsuran($data->id_qhasan,'QHASAN','".($data->jual/$data->jgk)."')\" class='add'>tbh trans</a>";
					echo "<tr><td>$data->ket <br/ >$html </td>";
					echo "<td>$data->jgk</td><td>$data->angsuran_ke</td>";
					echo "<td class='w20'>Rp.</td><td class='uang'>".number_format($data->jual,2,',','.')."</td>";
					echo "<td class='w20'>Rp.</td><td class='uang'>".number_format($data->jual/$data->jgk,2,',','.')."</td>";
					echo "<td class='w20'>Rp.</td><td class='uang'><a href='".site_url('history/angsuran/'.$data->id_qhasan)."'>".number_format($data->diangsur,2,',','.')."</a></td></tr>";
				endforeach;
					?>
				</table>
				</td>
			</tr>
			
			<tr>
				<td valign="top">Transaksi Terakhir</td>
				<td>
				<table class='noBorder w400'>
				<tr class='head'><td>Tgl Transaksi</td><td class="w200">Jenis</td><td colspan="2">Rupiah</td><td>Keterangan</td><td></td></tr>
				<?php
				foreach ($trans as $data ):
					$html_del = ( $data->is_deletable == 0 ) ? "":"<a class='delete' href=\"javascript:show_confirm('Yakin Akan Menghapus?','".site_url('trans/del/'.$data->tabel.'/'.$data->idx.'/'.$person->id_anggota)."')\">del</a>";
					echo "<tr><td>$data->tgl_trans_format</td><td>$data->jenis</td><td class='w20'>Rp.</td><td class='uang'>".number_format($data->nilai,2,',','.')."</td><td>$data->ket </td> <td>$html_del</td>
					</td></tr>";
				 
				endforeach;
					?>
				</table>
				<ul>
					<li>JS = Jasa</li>
					<li>KP = Kompensasi Angsuran, nilainya 30% dari laba</li>
					<li>SK = Simpanan Sukarela</li>
					<li>SW = Simpanan Wajib</li>
					<li>BL = Belanja Pokok</li>
					<li>RK = Rekening</li>
				</ul>	
				</td>
			</tr>
			
		</table>
		</div>
		<br />
		<?php echo $link_back; ?>
	</div>

</div>	
<div class="overlay"></div>	
	<div id="modalAddAngsuran" class="modalBox">
		<div class="modalTitle">Angsuran</div>
		<div class="modalBody" >
		<form id="formAddTrans" autocomplete="off" method="post" action="<?php if ( isset($action) ) echo $action;?>">
			Keterangan <br />
			<input type="text" class="text" name="ket" value="">
			<br />Nilai (Rp.) <br />
			<input type="text" class="text" name="nilai" value="">
			<br />Denda (Rp.) <br />
			<input type="text" class="text" name="denda" value="">
			<br />Tgl Transaksi <br />
			<input type="text" value="<?php echo $tgl_default ;?>" class="text tgl_trans" name="tgl_trans_angsuran"><a onclick="displayDatePicker('tgl_trans_angsuran');"><img src="<?php echo base_url(); ?>res/css/images/calendar.png" alt="calendar" border="0"></a>
			<input type="hidden" name="jenis_trans" value="angsuran">
			<input type="hidden" name="id_mrbh" value="">
			<input type="hidden" name="kategori" value="">
			<input type="hidden" name="id_anggota" value="<?php echo $person->id_anggota;?>">
			<br />
			<input type="button" class="btnSubmit" value="OK">
			<input type="button" class="btnBatal cancel" value="Batal">
		</form>
		</div>
		<?php
		foreach ($murabahah as $data ):
		?>
			<div id="c<?php echo $data->id_mrbh;?>" class="contentSource">
				<span class="title">Angsuran - <?php echo $data->ket;?></span>  
			</div>
		<?php
		endforeach;
		?>		
	</div>
	
	<!-- Simpanan -->
	<div id="modalAddSimpanan" class="modalBox">
		<div class="modalTitle">Simpanan</div>
		<div class="modalBody" >
		<form id="formAddTrans" autocomplete="off" method="post" action="<?php if ( isset($action) ) echo $action;?>">
			Keterangan <br />
			<input type="text" class="text" name="ket" value="">
			<br />Nilai (Rp.) <br />
			<input type="text" class="text" name="nilai" value="">
			<br />Tgl Transaksi <br />
			<input type="text" value="<?php echo $tgl_default ;?>" class="text tgl_trans" name="tgl_trans_simpanan"><a onclick="displayDatePicker('tgl_trans_simpanan');"><img src="<?php echo base_url(); ?>res/css/images/calendar.png" alt="calendar" border="0"></a>
			<input type="hidden" name="jenis_trans" value="simpanan">
			<input type="hidden" name="kode_simpanan" value="">
			<input type="hidden" name="id_anggota" value="<?php echo $person->id_anggota;?>">
			<br />
			<input type="button" class="btnSubmit" value="OK">
			<input type="button" class="btnBatal cancel" value="Batal">
		</form>
		</div>		
	</div>
	
	<!-- Berek -->
	<div id="modalAddBerek" class="modalBox">
		<div class="modalTitle">Belanja & Rekening</div>
		<div class="modalBody" >
		<form id="formAddTrans" autocomplete="off" method="post" action="<?php if ( isset($action) ) echo $action;?>">
			Keterangan <br />
			<input type="text" class="text" name="ket" value="">
			<br />Harga Pokok (Rp.) <br />
			<input type="text" class="text" name="nilai_pokok" value="">
			<br />Jasa/Laba (Rp.) <br />
			<input type="text" class="text" name="nilai" value="">
			<br />Tgl Transaksi <br />
			<input type="text" value="<?php echo $tgl_default ;?>" class="text tgl_trans" name="tgl_trans_berek"><a onclick="displayDatePicker('tgl_trans_berek');"><img src="<?php echo base_url(); ?>res/css/images/calendar.png" alt="calendar" border="0"></a>
			<input type="hidden" name="jenis_trans" value="berek">
			<input type="hidden" name="kode_berek" value="">
			<input type="hidden" name="id_anggota" value="<?php echo $person->id_anggota;?>">
			<br />
			<input type="button" class="btnSubmit" value="OK">
			<input type="button" class="btnBatal cancel" value="Batal">
		</form>
		</div>		
	</div>
	
	<!-- Buat Murabahah Baru -->
	<div id="modalAddMurabahah" class="modalBox">
		<div class="modalTitle">Buat Murabahah Baru</div>
		<div class="modalBody" >
		<form id="formAddTrans" autocomplete="off" method="post" action="<?php if ( isset($action) ) echo $action;?>">
			Nama Barang <br />
			<input type="text" class="text" name="ket" value="<?php echo $person->nama; ?>">
			<br />Harga Pokok (Rp.) <br />
			<input type="text" class="text" name="nilai" value="">
			<br />Jangka Waktu (max. 60 Bulan)<br />
			<input type="text" style="width:30px" class="text" name="jgk" value="">
			<br />Margin (otomatis)<br />
			<input type="text" style="width:30px" class="text" name="margin" value="">% 
			<br />Harga Jual (Rp.) <br />
			<input type="text" class="text" name="jual" value="">
			<br />Cicilan per bulan (otomatis)<br />
			<input type="text" class="text" name="cicilan" value="">
			<br />Adm (Rp.) <br />
			<input type="text" class="text" name="biaya_adm" value="">
			<br />Tgl Pembelian Barang <br />
			<input type="text" value="" class="text tgl_trans" name="tgl_trans_murabahah"><a onclick="displayDatePicker('tgl_trans_murabahah');"><img src="<?php echo base_url(); ?>res/css/images/calendar.png" alt="calendar" border="0"></a>
			<input type="hidden" name="jenis_trans" value="create_murabahah">
			<input type="hidden" name="kode_berek" value="">
			<input type="hidden" name="id_mrbh" value="">
			<input type="hidden" name="id_anggota" value="<?php echo $person->id_anggota;?>">
			<br />Catatan<br />
			<textarea name="catatan" cols=20 rows=3></textarea>
			<br />
			<input type="button" class="btnSubmit" value="OK">
			<input type="button" class="btnBatal cancel" value="Batal">
		</form>
		</div>		
	</div>
	
	
	<!-- Buat Qordun Hasan -->
	<div id="modalAddQHasan" class="modalBox">
		<div class="modalTitle">Buat Qordun Hasan Baru</div>
		<div class="modalBody" >
		<form id="formAddTrans" autocomplete="off" method="post" action="<?php if ( isset($action) ) echo $action;?>">
			Nama Qordun Hasan <br />
			<input type="text" class="text" name="ket" value="<?php echo $person->nama; ?>">
			<br />Nilai (Rp.) <br />
			<input type="text" class="text" name="nilai" value="">
			<br />Adm (Rp.) <br />
			<input type="text" class="text" name="biaya_adm" value="">
			<br />Jangka Waktu (max. 12 Bulan) <br />
			<input type="text" class="text" name="jgk" value="12">
			</select>
			<br />Tgl Pencairan Dana <br />
			<input type="text" value="" class="text tgl_trans" name="tgl_trans_qhasan"><a onclick="displayDatePicker('tgl_trans_murabahah');"><img src="<?php echo base_url(); ?>res/css/images/calendar.png" alt="calendar" border="0"></a>
			<input type="hidden" name="jenis_trans" value="create_qhasan">
			<input type="hidden" name="kode_berek" value="">
			<input type="hidden" name="id_anggota" value="<?php echo $person->id_anggota;?>">
			<br />Catatan<br />
			<textarea name="catatan" cols=20 rows=3></textarea>
			<br />
			<input type="button" class="btnSubmit" value="OK">
			<input type="button" class="btnBatal cancel" value="Batal">
		</form>
		</div>		
	</div>
	
	
	
	
	
	
	
	
	
	
</body>
</html>