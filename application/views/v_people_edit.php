<div class="well" style="width:300px;">
	<h4><?php echo $title; ?></h4><br>
		
	<form method="POST" name="people_edit" action="<?php echo $base_url;?>c_people/edit_simpan" class="">
		<input type="text" name="nama" value="<?php echo $people['nama']?>" placeholder="Nama" style="width:300px;"><br>
		<input type="text" name="kode" value="<?php echo $people['kode']?>" placeholder="Kode" style="width:300px;"><br>
		<input type="text" name="no_hp" value="<?php echo $people['no_hp']?>" placeholder="Nomor Telepon / HP" style="width:300px;"><br>
		<input type="hidden" name="id" value="<?php echo $people['id']?>">
		<input type="submit" value="Simpan" name="submit" class="btn btn-primary pull-right">


	</form>

</div>
		
