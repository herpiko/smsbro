<div class="well" style="width:300px;">
	<h4><?php echo $title; ?></h4><br>
		
	<form method="POST" name="people_edit" action="<?php echo $base_url;?>c_people/edit_simpan" class="">
		<input type="text" name="nama" data-validation="required alphanumeric"  value="<?php echo $people['nama']?>" placeholder="Nama" style="width:300px;"><br>
		<input type="text" name="kode" data-validation="number"  value="<?php echo $people['kode']?>" placeholder="Kode" style="width:300px;"><br>
		<input type="text" name="no_hp" data-validation="required number"  value="<?php echo $people['no_hp']?>" placeholder="Nomor Telepon / HP" style="width:300px;"><br>
		<input type="hidden" name="id" value="<?php echo $people['id']?>">
		<input type="submit" value="Simpan" name="submit" class="btn btn-primary pull-right">


	</form>
<script src="http//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.1.38/jquery.form-validator.min.js"></script>
<script> 

 var myLanguage = {
      requiredFields : 'Tidak boleh kosong.',
      badInt : 'Masukkan angka saja untuk nomor ponsel.',
      badAlphaNumeric : 'Mesti alphanumeric saja.',
      };

  $.validate({
    language : myLanguage
});
  </script>
</div>
		
