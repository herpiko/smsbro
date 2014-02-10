<div class="row">
	<div class="column">
		<div class="span3 well">
	<h4><?php echo $title; ?></h4>
		<form method="post" action="<?php echo $base_url;?>c_grup_sms/edit_simpan" class="form-horizontal">
		
		<div class="control-group">
		<input style="width:220px;" type="text" name="grup_nama" value="<?php echo $grup_nama; ?>">
		</div>	
		<input type="hidden" name="grup_id" value="<?php echo $grup_id; ?>">
		<div class="control-group">
		<select multiple="multiple" type="text" name="grup_anggota[]" value="">
		<?php 
		$j=count($peg);
		for ($i=0; $i < $j; $i++) { 
			$x="";
			foreach ($grup_anggota as $key) {
		
			if ($peg[$i]['id']===$key) {
				$x="selected=\"selected\"";

			}
			}
			echo "<option value=\"".$peg[$i]['id']."\" ".$x.">".$peg[$i]['nama']."</option>";
		}
		?>
		</select>
		</div>
		<div class="control-group">
		<input type="submit" name="submit" value="Simpan" class="btn btn-primary">&nbsp&nbsp&nbsp<a href="<?php echo $base_url;?>c_grup_sms/" class="btn">Batal</a>
		</div>
		</form>
		
		</div>
</div></div>
