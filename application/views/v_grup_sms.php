<div class="jumbotron well">
	<h4><?php echo $title; ?></h4>



		<form method="post" action="<?php echo $base_url;?>c_grup_sms/kelompok_baru" class="pull-right form-inline">
		<input type="text" name="grup_nama" class="" data-validation="required alphanumeric" placeholder="Nama kelompok"> <input type="submit" name="submit" value="Buat kelompok baru" class="btn btn-primary">
		</form>

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
		<?php echo $table; ?>
		<div class="pagination"><?php echo $pagination; ?></div>
	</div>

