<?php

if ( $view == 'web' ) {
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
<?php } ?>
<table class="report" cellspacing="0" cellpadding="4" border="<?php echo ( $view == 'web' ) ? 0:1;?>">
<thead>
<tr>
<th>No</th>
<th width="170">Nama Anggota</th>
<th>S.AWAL <br />Sp.Pokok</th>
<th>MASUK SP</th>
<th>KELUAR SP</th>
<th>S.AKHIR <br />Sp.Pokok</th>

<th>S.AWAL <br />Sp.Wajib</th>
<th>MASUK SW</th>
<th>KELUAR SW</th>
<th>S.AKHIR <br />Sp.Wajib</th>

<th>S.AWAL <br />Sp.Sukarela</th>
<th>MASUK SK</th>
<th>KELUAR SK</th>
<th>S.AKHIR <br />Sp.Sukarela</th>
</tr>
</thead>
<tbody>
<?php
$i=1;
$j_SP_AWAL = 0;
$j_SP_M = 0;
$j_SP_K = 0;
$j_SP_AKHIR = 0;

$j_SW_AWAL = 0;
$j_SW_M = 0;
$j_SW_K = 0;
$j_SW_AKHIR = 0;

$j_SK_AWAL = 0;
$j_SK_M = 0;
$j_SK_K = 0;
$j_SK_AKHIR = 0;



foreach ($rekap as $result)
{
$i++;
?>
<tr>
<td class="alignRight"><?php echo $i;?></td>
<td class="nama_trans" rel="<?php echo $result->id_anggota;?>"><?php echo $result->nama;?></td>
<td class="alignRight"><?php echo number_format($result->SP_SAWAL);?></td>
<td class="alignRight"><?php echo number_format($result->SP_M);?></td>
<td class="alignRight"><?php echo number_format($result->SP_K);?></td>
<td class="alignRight"><?php echo number_format($result->SP_SAKHIR);?></td>

<td class="alignRight"><?php echo number_format($result->SW_SAWAL);?></td>
<td class="alignRight"><?php echo number_format($result->SW_M);?></td>
<td class="alignRight"><?php echo number_format($result->SW_K);?></td>
<td class="alignRight"><?php echo number_format($result->SW_SAKHIR);?></td>

<td class="alignRight"><?php echo number_format($result->SK_SAWAL);?></td>
<td class="alignRight"><?php echo number_format($result->SK_M);?></td>
<td class="alignRight"><?php echo number_format($result->SK_K);?></td>
<td class="alignRight <?php echo ( $result->SK_SAKHIR < 0 ? "red":"" );?>"><?php echo number_format($result->SK_SAKHIR);?></td>

</tr>
<?php

// jumlahkan
$j_SP_AWAL += $result->SP_SAWAL;
$j_SP_M += $result->SP_M;
$j_SP_K += $result->SP_K;
$j_SP_AKHIR += $result->SP_SAKHIR;

$j_SW_AWAL += $result->SW_SAWAL;
$j_SW_M += $result->SW_M;
$j_SW_K += $result->SW_K;
$j_SW_AKHIR += $result->SW_SAKHIR;

$j_SK_AWAL += $result->SK_SAWAL;
$j_SK_M += $result->SK_M;
$j_SK_K += $result->SK_K;
$j_SK_AKHIR += $result->SK_SAKHIR;

}
?>
<!-- baris total -->
<tr class="total">
<td class="alignRight" colspan=2>Jumlah</td>
<td class="alignRight"><?php echo number_format($j_SP_AWAL);?></td>
<td class="alignRight"><?php echo number_format($j_SP_M);?></td>
<td class="alignRight"><?php echo number_format($j_SP_K);?></td>
<td class="alignRight"><?php echo number_format($j_SP_AKHIR);?></td>

<td class="alignRight"><?php echo number_format($j_SW_AWAL);?></td>
<td class="alignRight"><?php echo number_format($j_SW_M);?></td>
<td class="alignRight"><?php echo number_format($j_SW_K);?></td>
<td class="alignRight"><?php echo number_format($j_SW_AKHIR);?></td>

<td class="alignRight"><?php echo number_format($j_SK_AWAL);?></td>
<td class="alignRight"><?php echo number_format($j_SK_M);?></td>
<td class="alignRight"><?php echo number_format($j_SK_K);?></td>
<td class="alignRight"><?php echo number_format($j_SK_AKHIR);?></td>
</tr>

</tbody>
</table>

<!-- IF only on WEB View -->
<?php if ( $view == 'web' ) { ?>
<a class="xls excel" href="<?php echo site_url('laporan/rekap_simpanan/'.$periode.'/xls'); ?>">download sebagai excel</a><br /><br />
<?php } ?>
	