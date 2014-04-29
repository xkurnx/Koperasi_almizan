<?php

#print_r($datakas);
/*
foreach ($datakas as $result)
{
	$this->table->add_row(++$i,$result->jenis,$result->tgl,$result->nama,$result->SW,$result->SP,$result->pokok_pinj,
	$result->laba_pinj,$result->jasa_rk,$result->jasa_bl,$result->denda,$result->pengeluaran);
}
*/
	

$arrayBulan = array ('01'=>'Januari','02'=>'Pebruari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni',
'06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');	
$bulan = substr($periode,-2);
$tahun = substr($periode,0,4);
?>
<ul class="tabBulanan">
	<?php
	foreach ($arrayBulan as $data => $key ){
	 echo "<li class='". ( $bulan == $data ? "active":"") ."'><a href='".$base_url."/$tahun$data'>$key</a></li>";
	}
	?>
	
</ul>
<table class="report" cellspacing="0" cellpadding="4" border="0">
<thead>
<tr>
<th>No</th>
<th>KD</th>
<th>Tgl</th>
<th width="170">Transaksi</th>
<th>Simp Wjb</th>
<th>Simp SKRL</th>
<th>Pokok Pinj</th>
<th>Laba Pinj.</th>
<th>Pokok Rek.</th>
<th>Jasa Rek.</th>
<th>Pokok Bel.</th>
<th>Jasa Bel.</th>
<th>Denda</th>
<th>Kas Masuk</th>
<th>Kas Keluar</th>
<th>Saldo</th>
</tr>
</thead>
<tbody>
<?php
$i=1;
$j_SK = 0;
$j_SW = 0;
$j_pokok_pinj = 0;
$j_laba_pinj = 0;
$j_pokok_rk = 0;
$j_pokok_bl = 0;
$j_jasa_rk = 0;
$j_jasa_bl = 0;
$j_denda = 0;
$j_kas_masuk =0 ;
$kas_masuk = 0;
$j_pengeluaran = 0;
$j_kas = $saldo_awal;
?>
<!-- saldo awal -->
<tr>
<td class="alignRight">1</td>
<td colspan="14">Saldo Awal setelah tutup buku di bulan sebelumnya</td>
<td><?php echo number_format($saldo_awal);?></td>
</tr>


<?php

foreach ($trans as $result)
{
$i++;
$kas_masuk = $result->SW + $result->SK + $result->pokok_pinj + $result->laba_pinj
		+ $result->pokok_rk + $result->pokok_bl + $result->jasa_rk + $result->jasa_bl + $result->denda + $result->pemasukan ;
$j_kas = $j_kas + $kas_masuk - $result->pengeluaran;

$zebra_style = ( $i % 2 == 0 ? "odd": "");
?>
<tr class="<?php echo $zebra_style;?>">
<td class="alignRight"><?php echo $i;?></td>
<td><?php echo $result->jenis;?></td>
<td><?php echo $result->tgl;?></td>
<td class="nama_trans" rel="<?php echo $result->id_anggota;?>"><?php echo $result->nama;?></td>
<td class="alignRight"><?php echo number_format($result->SW);?></td>
<td class="alignRight"><?php echo number_format($result->SK);?></td>
<td class="alignRight"><?php echo number_format($result->pokok_pinj);?></td>
<td class="alignRight"><?php echo number_format($result->laba_pinj);?></td>
<td class="alignRight"><?php echo number_format($result->pokok_rk);?></td>
<td class="alignRight"><?php echo number_format($result->jasa_rk);?></td>
<td class="alignRight"><?php echo number_format($result->pokok_bl);?></td>
<td class="alignRight"><?php echo number_format($result->jasa_bl);?></td>
<td class="alignRight"><?php echo number_format($result->denda);?></td>
<td class="alignRight"><?php echo number_format($kas_masuk);?></td>
<td class="alignRight"><?php echo number_format($result->pengeluaran);?></td>
<td class="alignRight"><?php echo number_format($j_kas);?></td>

</tr>
<tr>
<?php

// jumlahkan
$j_SW += $result->SW;
$j_SK += $result->SK;
$j_pokok_pinj += $result->pokok_pinj;
$j_laba_pinj += $result->laba_pinj;
$j_pokok_rk += $result->pokok_rk;
$j_jasa_rk += $result->jasa_rk;
$j_pokok_bl += $result->pokok_bl;
$j_jasa_bl += $result->jasa_bl;
$j_denda += $result->denda;
$j_kas_masuk += $kas_masuk;
$j_pengeluaran += $result->pengeluaran;
}
?>
<! -- baris total -->
<tr class="total">
<td class="alignRight" colspan=4>Jumlah</td>
<td class="alignRight"><?php echo  number_format($j_SW);?></td>
<td class="alignRight"><?php echo number_format($j_SK);?></td>
<td class="alignRight"><?php echo number_format($j_pokok_pinj);?></td>
<td class="alignRight"><?php echo number_format($j_laba_pinj);?></td>
<td class="alignRight"><?php echo number_format($j_pokok_rk);?></td>
<td class="alignRight"><?php echo number_format($j_jasa_rk);?></td>
<td class="alignRight"><?php echo number_format($j_pokok_bl);?></td>
<td class="alignRight"><?php echo number_format($j_jasa_bl);?></td>
<td class="alignRight"><?php echo number_format($j_denda);?></td>
<td class="alignRight"><?php echo number_format($j_kas_masuk);?></td>
<td class="alignRight"><?php echo number_format($j_pengeluaran);?></td>
<td class="alignRight"><big><?php echo number_format($j_kas);?></big></td>
</tr>

</tbody>
</table>
<div class="boxGreen">
	<span class="floatRight">Saldo Akhir Kas = <big>Rp.<?php echo number_format($j_kas);?></big></span>
	<?php
	if ($saldo_akhir != 0 ){
	?>
	<br />Periode ini sudah tutup buku dengan saldo akhir <big><?php echo number_format($saldo_akhir);?></big>	
	<?php
	}	
	?>
	
	<?php
	if ($saldo_akhir != $j_kas && $saldo_akhir != 0 ){
		echo "<br />Namun Saldo Akhir Kas TIDAK SAMA dengan Saldo Akhir saat tutup buku, silahkan proses ulang";
	}
	if ( $saldo_akhir != $j_kas && $j_kas != $saldo_awal ) {
	?>
	<ul>
	<li>Proses Tutup Buku akan menjadikan Saldo Akhir Periode ini sebagai Saldo Awal Periode Berikutnya</li>
	<li>Jika ada transaksi setelah tutup buku, silahkan lakukan kembali tutup buku</li>
	<li>Proses Tutup Buku Jasa-Jasa dan mendistribusikannya ke tiap anggota</li>
	<li>Proses Tutup Buku akan menghitung Jasa-Jasa dan mendistribusikannya ke tiap anggota</li>
	<li>Proses Tutup Buku akan menghasilkan file backup (ZIP), mohon simpan file tersebut di tempat yang aman</li>
	<li>Proses Tutup Buku akan mengirim/mengupload data ke website koperasi almizan</li>
	</ul>
	<form method="post" action="<?php echo $action;?>">
	<input type="hidden" name="jenis_trans" value="tutup_buku">
	<input type="hidden" name="periode" value="<?php echo $periode;?>">
	<input type="hidden" name="nilai" value="<?php echo $j_kas;?>">
	<input type="submit" name="btnSubmit" value="Klik untuk Proses Tutup Buku periode <?php echo $periode_text;?>">
	</form>
	<?php
	}
	?>
	
	
</div>	