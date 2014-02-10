<div class="well" style="width:300px;">
	<h4><?php echo $title; ?></h4><br>
		
	<form method="POST" name="people_add" action="<?php echo $base_url;?>c_people/simpan" class="">
		<input type="text" name="nama" placeholder="Nama" style="width:300px;"><br>
		<input type="text" name="kode" placeholder="NPWP" style="width:300px;"><br>
		<input type="text" name="no_hp" placeholder="Nomor Telepon / HP" style="width:300px;"><br>
		<input type="submit" value="Simpan" name="submit" class="btn btn-primary pull-right">


	</form>

</div>
		
