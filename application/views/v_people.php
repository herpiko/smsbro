<div class="well">
	<h4><?php echo $title; ?></h4><br>
		<a href="<?php echo $base_url;?>c_people/add" class="btn btn-primary">Tambah</a>
		<a href="" class="btn">Tambahkan ke Kelompok</a>
		<a href="" class="btn">Impor dari CSV</a>
		<a href="<?php echo $base_url;?>c_people/hapus_semua"  onclick="return confirm('Semua kelompok kontak juga akan terhapus. Anda yakin ingin menghapus semua?')" class="btn btn-danger">Hapus semua</a>
	</div>
		<div class="well">

		<table class="table table-hover table-striped">
		<?php
			//set heading

			echo "<tr>";	
			echo "<td><strong>No.</strong></td>";
			echo "<td><strong>Kode</strong></td>";
			echo "<td><strong>Nama</strong></td>";
			echo "<td><strong>Nomor Telepon / HP</strong></td>";
			// echo "<td></td>";
			// echo "<td></td>";
			echo "</tr>";
		
		foreach ($table as $row) {
			//generate data
			echo "<tr>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['kode']."</td>";
			echo "<td>".$row['nama']."</td>";
			echo "<td>".$row['no_hp']."</td>";
			echo "<td><a href=\"".$base_url."c_people/edit/".$row['id']."\"><i class=\"icon-edit\"></i></a></td>";
			echo "<td><a href=\"".$base_url."c_people/hapus/".$row['id']."\" onclick=\"return confirm('Anda yakin ingin menghapus?')\"><i class=\"icon-remove\"></i></a></td>";
			// echo "<td>edit</td>";
			// echo "<td>delete</td>";
			echo "</tr>";
		}
		 ?>
		</table>
	</div>

