<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>
<div class="well">
	<h4><?php echo $title; ?></h4>
		
<br>
<p>
<form method="post" action="<?php 
$action=$base_url."c_terjadwal/bulanan_simpan";
echo $action;?>" class="form-horizontal">
	<input type="text" class="input-block-level" name="deskripsi" <?php if ($empty==FALSE) { echo "value=\"".$deskripsi_edit."\"";} ?> placeholder="Deskripsi jadwal"><br><br>
Dijadwal setiap tanggal : 
<input class="input-mini" type="text" name="tgl" <?php if ($empty==FALSE) { echo "value=\"".$tgl_edit."\"";} ?> placeholder="">
 jam : <input class="input-mini" type="text" name="jam" <?php if ($empty==FALSE) { echo "value=\"".$jam_menit_edit."\"";} ?> placeholder="00:00">

		<br><br>
		<div class="control-group">
		<select class="input-block-level" type="text" name="tujuan" value="">
		<option></option>
		
		<?php 
		$j=count($kelompok);
		for ($i=0; $i < $j; $i++) { 
			$selected="";
			if ($tujuan_edit==$kelompok[$i]['grup_id']) {
				if ($empty==FALSE) {
					$selected="selected";
				}
				
			}
			echo "<option value=\"".$kelompok[$i]['grup_id']."\"  ".$selected.">".$kelompok[$i]['grup_nama']."</option>";
		}
		?>
		</select>
		</div>	

		<div class="control-group">
		<textarea row="3" class="input-block-level" name="pesan" value="" placeholder="Pesan"  onkeyup="countChar1(this)"><?php if ($empty==FALSE) { echo $pesan_edit;} ?></textarea>
		</div>
		<div class="control-group">
		<input type="hidden" name="action_type" <?php if ($empty==FALSE) { echo "value=\"update\"";} else {echo "value=\"append\"";} ?>>
		<?php if ($empty==FALSE) { echo "<input type=\"hidden\" name=\"id_edit\" value=\"".$id_edit."\">";}?>
		<input type="submit" name="submit1" value="Simpan" class="btn btn-primary">
		&nbsp&nbsp&nbsp
		<a href="<?php echo $base_url;?>c_grup_sms" class="btn">Kelola kelompok</a>&nbsp&nbsp&nbsp<a href="<?php echo $base_url;?>c_send/index/4#tab4" class="btn">Batal</a>
		<p class="pull-right"><strong id="charNum1"></strong><i id="charNumPart1"></i></p>
		</div>

		</form>
</p>
</div>

</div></div></div>