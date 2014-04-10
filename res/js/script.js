$(document).ready(function(){
	//alert(1);
		
		// table style untuk laporan
		$('td').each(function(){
			if ($(this).html() == 0 )
			$(this).addClass('null');
		});
		$('td.nama_trans').each(function(){
			nama = $(this).html().replace('dr','');
			id_anggota=$(this).attr('rel');
			periode = $('input[name=periode]').val();
			/* klo periode nya null, maka ambil dari periode_hidden */
			if ( periode == null )
			periode = $('.periode_hidden').html();
			URL = "Dari <a target='_blank' href='"+base_url+"index.php/anggota/view/"+id_anggota+"/"+periode+"'>"+nama+"</a>";
			if (id_anggota != '0' )
			$(this).html(URL);
		})
		
		add_simpanan=function (kode_simpanan,nilai_default){
			$('.text').val('');
			$('#modalAddSimpanan input[name=ket]').focus();
			$('.overlay').css('display','block');
			$('.overlay').height($(document).height());
				var h = $(window).height();
				var w = $(window).width();
				$('#modalAddSimpanan').css({
					display:"block",
					left: (w - $('.modalBox').width()) / 2,
					top: (h - $('.modalBox').height()) / 2
				});
			$('#modalAddSimpanan input[name=kode_simpanan]').val(kode_simpanan);
			$('#modalAddSimpanan input[name=nilai]').val(nilai_default);
		}
		
		
		add_angsuran=function (id_mrbh,nilai){
			$('.text').val('');
			$('#modalAddAngsuran input[name=ket]').focus();
			$('.overlay').css('display','block');
			$('.overlay').height($(document).height());
				var h = $(window).height();
				var w = $(window).width();
				$('#modalAddAngsuran').css({
					display:"block",
					left: (w - $('.modalBox').width()) / 2,
					top: (h - $('.modalBox').height()) / 2
				});
			$('#modalAddAngsuran input[name=id_mrbh]').val(id_mrbh);
			$('#modalAddAngsuran input[name=nilai]').val(nilai);
		}
		
		add_berek=function (kode_berek){
			$('.text').val('');
			$('#modalAddBerek input[name=ket]').focus();
			$('.overlay').css('display','block');
			$('.overlay').height($(document).height());
				var h = $(window).height();
				var w = $(window).width();
				$('#modalAddBerek').css({
					display:"block",
					left: (w - $('.modalBox').width()) / 2,
					top: (h - $('.modalBox').height()) / 2
				});
			$('#modalAddBerek input[name=kode_berek]').val(kode_berek);
		}
		
		add_murabahah=function (kode_berek){
			$('.text').val('');
			$('#modalAddMurabahah input[name=ket]').focus();
			$('.overlay').css('display','block');
			$('.overlay').height($(document).height());
				var h = $(window).height();
				var w = $(window).width();
				$('#modalAddMurabahah').css({
					display:"block",
					left: (w - $('.modalBox').width()) / 2,
					top: (h - $('.modalBox').height()) / 2
				});
		}
		
		add_qhasan = function (kode_berek){
			//$('.text').val('');
			$('#modalAddQHasan input[name=ket]').focus();
			$('.overlay').css('display','block');
			$('.overlay').height($(document).height());
				var h = $(window).height();
				var w = $(window).width();
				$('#modalAddQHasan').css({
					display:"block",
					left: (w - $('.modalBox').width()) / 2,
					top: (h - $('.modalBox').height()) / 2
				});
		}
		
		add_kas=function(){		
			$('.text').val('');
				$('#modalAddkas input[name=ket]').focus();
				$('.overlay').css('display','block');
				$('.overlay').height($(document).height());
					var h = $(window).height();
					var w = $(window).width();
					$('#modalAddkas').css({
						display:"block",
						left: (w - $('.modalBox').width()) / 2,
						top: (h - $('.modalBox').height()) / 2
					});		
		}
				
		$('.overlay,.btnBatal').click(function(){
			$('.overlay,.modalBox').css('display','none');	
			$('#datepicker,#datepickeriframe').hide();	
			
		})
		
		// submit button on modal window
		$('.btnSubmit').click(function(){
			if ( $(this).parent().find('input.tgl_trans').val() == '' || $(this).parent().find('input[name=nilai]').val() == '') {
				alert('Tgl dan Nilai Transaksi harus diisi');
				return false;
			}
			else{				
					$(this).parent().submit();
			}		
		})
		
		show_confirm=function(msg,url){
			var r=confirm(msg);
			if (r==true)
			  {
			  location.href= url ;
			  }					
		}
		
		/* del Row on Multiple Kas Keluar */
		
		$('a.btnDelRow').click(function(){
			$(this).parent().parent().remove();
		})
		
		cetakBuku = function(id_anggota,periode){
			url = base_url+"index.php/anggota/cetak/"+id_anggota+"/"+periode;			
			openpopupWindow(url);					
		}
		
		var item1 = $('.KasKeluarForm input.tgl_trans')[0];
		//$(item1).remove();
		$(item1).change(function(){
		 $('.KasKeluarForm input.tgl_trans').val($(this).val());
		});
				
		//$('input[name=tgl_trans]').remove();
		
		
		/* open on new window */
		openpopupWindow = function(url){
			var title = "Buku Anggota";
			var w = 800;
			var h = 500;
			var left = (screen.width/2)-(w/2);
			var top = (screen.height/2)-(h/2);
			return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);

		}
		
		showKasKeluarForm = function (){
					
		
		}
	
})