<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
$( "#datepicker" ).datepicker();
 format: 'mm-dd-yyyy'
});
</script>
<div class="well">
<h4>Tetapkan kuota</h4>
Kuota sebelumnya : <?php echo $kuota; ?> SMS per tanggal <?php echo $tanggal; ?>.
<br>
<p>
<form method="post" action="<?php echo $base_url;?>c_smsd_statistik/set_kuota">
<input type="text"  id="datepicker" name="tanggal" data-date-format="dd/mm/yy" value="" placeholder="per tanggal">
<br>
<input type="text" name="kuota" value="" placeholder="tetapan kuota">
<br>
<input type="submit" name="submit" value="Simpan" class="btn btn-primary">&nbsp&nbsp&nbsp&nbsp<a href="<?php echo $base_url;?>c_smsd_statistik" class="btn">Batal</a>
</form>
</p>
</div>

