<div class="well">
	<h4><?php echo $title; ?></h4>
		<?php 
		if ($is_table_empty) {
			echo "<p class=\"text-center\">Kotak masuk kosong.</p>";
		}
		else {
		echo "Ada ".$count." SMS di Kotak masuk.";
		echo "<form action=\"".$base_url."c_inbox/hapus_semua\" class=\"pull-right\" onsubmit=\"return confirm('Anda yakin ingin menghapus SEMUA?');\">
		<input type=\"submit\" name=\"submit\" value=\"Hapus semua\" class=\"btn btn-danger\">
		</form>";

			echo $table; 	
		}
		?>
		<div class="pagination"><?php echo $pagination; ?></div>
	</div>
