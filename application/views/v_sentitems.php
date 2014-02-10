<div class="well">
	<h4><?php echo $title; ?></h4>
		<?php 
		if ($is_table_empty) {
			echo "<p class=\"text-center\">Tidak ada SMS yang terkirim.</p>";
		}
		else {
		echo "Ada ".$count." SMS yang sudah terkirim.";
		echo "<p class=\"pull-right\"> <a href=\"".$base_url."c_sentitems/failed\" class=\"btn\">Lihat yang gagal terkirim</a>&nbsp&nbsp&nbsp<a href=\"".$base_url."c_sentitems/hapus_semua\" class=\"btn btn-danger\" onclick=\"return confirm('Anda yakin ingin menghapus SEMUA?');\">Hapus Semua</a></p>";

			echo $table; 	
		}
		?>
		<div class="pagination"><?php echo $pagination; ?></div>
	</div>
