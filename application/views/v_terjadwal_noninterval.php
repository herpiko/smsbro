<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>
<div class="well">
	<h4><?php echo $title; ?></h4>
		
<br>
<p>
<form method="post" action="<?php echo $base_url;?>c_terjadwal/noninterval_append" class="form-horizontal"><input type="text" class="input-block-level" name="deskripsi" value="" placeholder="Deskripsi jadwal"><br><br>
Dijadwal pada tanggal : <input type="text" class="input-small"  id="datepicker" name="tgl" value="" placeholder="tanggal">  pada jam : <input class="input-mini" type="text" name="jam" value="" placeholder="00:00">

		<br><br>
		<div class="control-group">
		<select class="input-block-level" type="text" name="tujuan" value="">
		<option></option>
		
		<?php 
		$j=count($kelompok);
		for ($i=0; $i < $j; $i++) { 
			echo "<option value=\"".$kelompok[$i]['grup_id']."\">".$kelompok[$i]['grup_nama']."</option>";
		}
		?>
		</select>
		</div>	

		<div class="control-group">
		<textarea row="3" class="input-block-level" name="pesan" value="" placeholder="Pesan"  onkeyup="countChar4(this)"></textarea>
		</div>
		<div class="control-group">
		<input type="submit" name="submit4" value="Simpan" class="btn btn-primary">
		&nbsp&nbsp&nbsp
		<a href="<?php echo $base_url;?>c_grup_sms" class="btn">Kelola kelompok</a>&nbsp&nbsp&nbsp<a href="<?php echo $base_url;?>c_send/index/4#tab4" class="btn">Batal</a>
		<p class="pull-right"><strong id="charNum4"></strong><i id="charNumPart4"></i></p>
		</div>
		</form>
</p>
</div>
</div>
</div>
</div>
