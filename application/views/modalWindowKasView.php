<div class="overlay"></div>	
	<div id="modalAddkas" class="modalBox">
		<div class="modalTitle">Tambah Transaksi Kas Masuk dan Keluar</div>
		<div class="modalBody">
		<form id="formAddTrans" autocomplete="off" method="post" action="<?php if ( isset($action) ) echo $action;?>">
			Jenis 	<input type="radio" name="type" checked="checked" value="k">Kas Keluar
			<input type="radio" name="type" value="m">Kas Masuk
			
			<br />Keterangan <br />
			<input type="text" class="text" name="ket" value="">
			<br />Nilai Transaksi <br />
			<input type="text" class="text" name="nilai" value="">
			<br />Tgl Transaksi <br />
			<input type="text" value="" class="text" name="tgl_trans"><a onclick="displayDatePicker('tgl_trans');"><img src="<?php echo base_url(); ?>res/css/images/calendar.png" alt="calendar" border="0"></a>
			<br />
			<input type="hidden" name="jenis_trans" value="kas">
			<input type="submit" class="btnSubmit" value="OK">
			<input type="button" class="btnBatal cancel" value="Batal">
		</form>
		</div>
		
		
	</div>
