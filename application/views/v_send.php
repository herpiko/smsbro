<p class="well">
<?php
//shell_exec("gammu-smsd -d");
$output = shell_exec("/opt/smsbro/check-running.sh gammu-smsd");

echo "<strong>Status : </strong>Gammu service is ";

 	if ($output==1) {
 		echo "running.";
 	} else {
 		echo "NOT RUNNING!";
 	}
 	 

 ?>
 &nbsp&nbsp&nbsp&nbsp&nbsp
 <?php
    if ($kuota_use=="TRUE") {
      echo "<strong>Kuota tersisa : </strong> ".$kuota_tersisa." SMS";
  }
   ?>
&nbsp&nbsp&nbsp&nbsp&nbsp
 <strong>Sinyal</strong> : <?php 
 	if ($output==1) {
 		echo $signal;
 	} else {
 		echo " --- ";
 	}
  ?>
 	 	
 </a>
<br>
</p>

	<div class="">
		<div class="tabbable">
<ul class="nav nav-tabs">
<?php if ($active_tab==1) {	echo "<li class=\"active\">"; } else { echo "<li>";} ?><a href="#tab1" data-toggle="tab">Tujuan bebas</a></li>
<li><a href="#tab2" data-toggle="tab">Tujuan terdaftar</a></li>
<li><a href="#tab3" data-toggle="tab">Tujuan kelompok</a></li>
<?php if ($active_tab==4) {	echo "<li class=\"active\">"; } else { echo "<li>";} ?><a href="#tab4" data-toggle="tab">Tujuan terjadwal</a></li>
</ul>
<div class="tab-content">
<?php if ($active_tab==1) {	echo "<div class=\"tab-pane active well\" id=\"tab1\">"; } else { echo "<div class=\"tab-pane well\" id=\"tab1\">";} ?>

<p>
	<strong>Kirim ke satu tujuan nomor bebas</strong>
		<form method="post" action="<?php echo $base_url;?>c_send/send_single" class="form-horizontal">
		
		<div class="control-group">
		<input class="input-block-level" type="text" name="notujuan" value="" placeholder="Nomor Tujuan">
		</div>	

		<div class="control-group">
		<textarea row="3" class="input-block-level" name="pesan" value="" placeholder="Pesan" onkeyup="countChar1(this)"></textarea>
		</div>
		<div class="control-group">
		<input type="submit" name="submit" value="Kirim" class="btn btn-primary">
		<p class="pull-right"><strong id="charNum1"></strong><i id="charNumPart1"></i></p>
		</div>
		</form>

</p>
</div>
<div class="tab-pane well" id="tab2">
<p>
	<strong>Kirim ke beberapa tujuan terdaftar</strong>
		<form method="post" action="<?php echo $base_url;?>c_send/send_multi" class="form-horizontal">
		
		<div class="control-group">
		<select class="input-block-level" multiple="multiple" type="text" name="notujuan[]" value="">
		<?php 
		$j=count($peg);
		for ($i=0; $i < $j; $i++) { 
			echo "<option value=\"".$peg[$i]['no_hp']."\">".$peg[$i]['nama']."</option>";
		}
		?>

		</select>
		</div>
		<div class="control-group">
		<textarea row="3" class="input-block-level" name="pesan" value="" placeholder="Pesan"  onkeyup="countChar2(this)"></textarea>
		</div>
		<div class="control-group">
		<input type="submit" name="submit2" value="Kirim" class="btn btn-primary">
		<p class="pull-right"><strong id="charNum2"></strong><i id="charNumPart2"></i></p>
		</div>
		</form>

</p>
</div>
<div class="tab-pane well" id="tab3">
<p>
<strong>Kirim berdasarkan kelompok </strong>
		<form method="post" action="<?php echo $base_url;?>c_send/send_group" class="form-horizontal">
		
		<div class="control-group">
		<select class="input-block-level" type="text" name="kelompok_id" value="">
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
		<textarea row="3" class="input-block-level" name="pesan" value="" placeholder="Pesan"  onkeyup="countChar3(this)"></textarea>
		</div>
		<div class="control-group">
		<input type="submit" name="submit3" value="Kirim" class="btn btn-primary">
		&nbsp&nbsp&nbsp
		<a href="<?php echo $base_url;?>c_grup_sms" class="btn">Kelola kelompok</a>
		<p class="pull-right"><strong id="charNum3"></strong><i id="charNumPart3"></i></p>
		</div>
		</form>
</p>
</div>

<?php if ($active_tab==4) {	echo "<div class=\"tab-pane active well\" id=\"tab4\">"; } else { echo "<div class=\"tab-pane well\" id=\"tab4\">";} ?>
<p>
<strong>Kirim berdasarkan jadwal yang sudah ditentukan</strong>
<div class="pull-right">
<div class="btn-group">
<button class="btn dropdown-toggle" data-toggle="dropdown">Buat SMS terjadwal</button>
</button>
<ul class="dropdown-menu">
<li><a href="<?php echo $base_url;?>c_terjadwal/bulanan">Bulanan</a></li>
<!--<li><a href="#">Mingguan</a></li>
<li><a href="#">Harian</a></li>
<li><a href="#">Non-interval</a></li>-->
</ul>
</div>


<?php if ($empty==FALSE) {
	echo "<a href=\"".$base_url."c_terjadwal/hapus_semua\" class=\"btn btn-danger\" onclick=\"return confirm('Anda yakin ingin menghapus semua?')\">Hapus semua</a>";
} ?>


</div>
<br><br><br><br>

<?php if ($empty==TRUE) {
	echo "<p class=\"text-center\">Tidak ada jadwal.</p>";
} else {
echo $terjadwal;
} ?>
</p>
</div>
</div>
</div>

