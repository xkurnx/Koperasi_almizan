<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Cetak Buku Anggota</title>

<?php
 require_once('head.assets.php');
?>

<link href="<?php echo base_url(); ?>res/css/cetak.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="wrapper">
	<div class="content">
		<div class="data">
		<h4>Buku Transaksi Periode <?php echo $periode_to_text;?></h4>
		<table>
			<tr>
				<td width="20%">Nomor Anggota</td>
				<td><?php echo $person->id_anggota; ?></td>
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
				 echo "<tr><td>Simpanan Pokok </td></td><td class='w20'>Rp.</td><td class='uang'>".number_format($simpanan->T_SP,2,',','.')."</td></tr>";
				 echo "<tr><td>Simpanan Wajib </td><td class='w20'>Rp.</td><td class='uang'>".number_format($simpanan->T_SW,2,',','.')."</td></tr>";
				 echo "<tr><td>Simpanan Sukarela</td><td class='w20'>Rp.</td><td class='uang'>".number_format($simpanan->T_SK,2,',','.')."</td></tr>";
				 echo "<tr><td>Jasa Simpanan Sukarela</td><td class='w20'>Rp.</td><td class='uang'>".number_format($simpanan->T_JS,2,',','.')."</td></tr>";				 
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
				  echo "<tr><td>Jasa Rekening </td><td class='w20'>Rp.</td><td class='uang'>".number_format($berek->T_RK,2,',','.')."</td></tr>";
				  echo "<tr><td>Jasa Belanja </td><td class='w20'>Rp.</td><td class='uang'>".number_format($berek->T_BL,2,',','.')."</td></tr>";
				  
				?>
				</table>
				</td>
				
			</tr>
			
			<tr>
				<td valign="top">Murabahah </td>
				<td>
				<table class='small w400'>
				<tr class='head'><td class='w300'>Murabahah</td><td>Jangka</td><td>Agsrn Ke</td><td colspan='2'>Harga Jual</td><td colspan='2'>Angsuran/ Bln</td><td colspan='2'>Sudah dibayar</td></tr>
				 
				
				<?php
				foreach ($murabahah as $data ):
					echo "<tr><td>$data->ket</td>";
					echo "<td>$data->jgk</td><td>$data->angsuran_ke</td>";
					echo "<td class='w20'>Rp.</td><td class='uang'>".number_format($data->jual,2,',','.')."</td>";
					echo "<td class='w20'>Rp.</td><td class='uang'>".number_format($data->jual/$data->jgk,2,',','.')."</td>";
					echo "<td class='w20'>Rp.</td><td class='uang'>".number_format($data->diangsur,2,',','.')."</td></tr>";
				endforeach;
					?>
				</table>
				</td>
			</tr>
			
			<tr>
				<td valign="top">Transaksi</td>
				<td>
				<table class='noBorder w400'>
				<tr class='head'><td>Tgl Transaksi</td><td>Jenis</td><td colspan="2">Rupiah</td><td>Keterangan</td><td></td></tr>
				<?php
				foreach ($trans as $data ):
					echo "<tr><td>$data->tgl_trans_format</td><td>$data->jenis</td><td class='w20'>Rp.</td><td class='uang'>".number_format($data->nilai,2,',','.')."</td><td>$data->ket </td> <td></td>
					</td></tr>";
				 
				endforeach;
					?>
				</table>
				</td>
			</tr>
						
		</table>
		</div>
		<br />
		<table>
		<tr>
		<td>Kisaran, <?php echo date('d-m-Y');?><br/><br/><br/><br/>Indra Nawawi</td>
		</tr>
		</table>
	
	</div>

</div>	

		
	
</body>
<script>window.print();</script>
</html>