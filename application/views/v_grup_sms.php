<div class="jumbotron well">
	<h4><?php echo $title; ?></h4>
		<form method="post" action="<?php echo $base_url;?>c_grup_sms/kelompok_baru" class="pull-right form-inline">
		<input type="text" name="grup_nama" class="" placeholder="Nama kelompok"> <input type="submit" name="submit" value="Buat kelompok baru" class="btn btn-primary">
		</form>
		<?php echo $table; ?>
		<div class="pagination"><?php echo $pagination; ?></div>
	</div>

