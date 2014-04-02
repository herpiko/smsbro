<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<div class="well">
<h4><?php echo $title ?></h4>

<br>
<p>
<form method="post" action="<?php echo $base_url;?>c_log_gammu/set_path_log">
<input type="text" name="path_log" value="" placeholder="lokasi berkas log">
<br>
<input type="submit" name="submit" value="Simpan" class="btn btn-primary">&nbsp&nbsp&nbsp&nbsp<a href="<?php echo $base_url;?>c_smsd_statistik" class="btn">Batal</a>
</form>
</p>
</div>

