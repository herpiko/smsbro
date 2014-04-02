<div class="well">
	<h4><?php echo $title; ?></h4>
		<?php 
		if ($is_table_empty) {
			echo "<p class=\"text-center\">Tidak ada SMS yang gagal terkirim.</p>";

		}
		else {
		echo "Ada ".$count." SMS yang gagal terkirim.<br><br>*) Tombol <strong>Kirim Ulang</strong> hanya akan memproses SMS gagal single (kurang dari 160 karakter)<br> dan menyisakan SMS gagal multipart (lebih dari 160 karakter). Harap sisanya dikirim ulang secara manual.";
		echo "<a href=\"".$base_url."c_sentitems/hapus_semua_failed\" class=\"btn btn-danger pull-right\" onclick=\"return confirm('Anda yakin ingin menghapus SEMUA?');\">Hapus semua</a><span class=\"pull-right\">&nbsp&nbsp&nbsp</span>
			<a href=\"".$base_url."c_send/failed_resend\" class=\"btn btn-primary pull-right\" onclick=\"return confirm('Anda yakin ingin mengirim ulang semua SMS yang gagal terkirim?');\">Kirim Ulang *</a>";
		echo $table; 	
		}
		?>
		</div>
