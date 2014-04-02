<div class="well" style="width:300px;">
	<h4><?php echo $title; ?></h4><br>
		
	<form method="POST" name="people_add" action="<?php echo $base_url;?>c_people/simpan" class="">
		<input type="text" name="nama" data-validation="required alphanumeric" placeholder="Nama" style="width:300px;"><br>
		<input type="text" name="kode" data-validation="number" placeholder="Kode" style="width:300px;"><br>
		<input type="text" name="no_hp" data-validation="required number" placeholder="Nomor Telepon / HP" style="width:300px;"><br>
		<input type="submit" value="Simpan" name="submit" class="btn btn-primary pull-right">
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

	</form>
	
</div>
		
