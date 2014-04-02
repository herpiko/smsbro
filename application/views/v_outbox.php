<div class="well">
	<h4><?php echo $title; ?></h4>
		<?php 
		if ($is_table_empty) {
			echo "<p class=\"text-center\">Tidak ada SMS yang sedang diproses.</p>";
		}
		else {
		echo "Ada ".$count." SMS yang sedang diproses";
		echo "<form action=\"".$base_url."c_outbox/hapus_semua\" class=\"pull-right\" onsubmit=\"return confirm('Anda yakin ingin membatalkan semua SMS di Kotak Keluar?');\">
		<input type=\"submit\" name=\"submit\" value=\"Batalkan semua\" class=\"btn btn-danger\">
		</form>";

			echo $table; 	
		}
		?>
		<div class="pagination"><?php echo $pagination; ?></div>
	</div>
