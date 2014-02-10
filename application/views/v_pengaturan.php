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
&nbsp&nbsp&nbsp&nbsp&nbsp
 <strong>Sinyal</strong> : <?php 
 	if ($output==1) {
 		echo $signal;
 	} else {
 		echo " --- ";
 	}
  ?>
 	<?php
 	if ($output==0) {
 		echo "<a href=\"".$base_url."c_log_gammu/restart_gammu\" class=\"pull-right btn btn-primary\">Jalankan Gammu</a>";
 	} else {
 		echo "<a href=\"".$base_url."c_log_gammu/stop_gammu\" class=\"pull-right btn btn-danger\">Hentikan Gammu</a>";	
 	}
 	 ?>
 	
 </a>
<br>
</p>
		<!--some src for datepicker
		<link rel="stylesheet" href="<?php echo $base_url;?>application/views/datepicker/css/bootstrap.css">-->
	    <link rel="stylesheet" href="<?php echo $base_url;?>application/views/datepicker/css/datepicker.css">
	    <script src="<?php echo $base_url;?>application/views/datepicker/js/bootstrap.js"></script>
	    <script src="<?php echo $base_url;?>application/views/datepicker/js/jquery.js"></script>
	    <style>
		.datepicker{z-index:1151;}
	    </style>
	    <!--some script for datepicker-->
	    <script>
		$(function(){
		    $("#tanggal").datepicker({
			format:'dd-mm-yy'
			
		    });
                });
	    </script>
<div class="well">
	<h4><?php echo $title; ?></h4>
		
		<p>
			<form action="<?php echo $base_url;?>c_pengaturan" method="POST">
			<table border="0">
				
				<tr>
					<td width="350">
						SMS dengan menyebut nama *
					</td>
					<td>
						<select name="sebut_nama" class="input-small">
							<option value="TRUE" >Ya</option>
							<option value="FALSE" <?php if ($sebut_nama=="FALSE") { echo "selected";} else { echo "";}?>> Tidak</option>
						</select>

					</td>
				</tr>
				<tr>
					<td>
						Kata pengawal sebelum menyebut nama
					</td>
					<td>
						<input type="text" name="sebut_nama_awalan" value="<?php echo $sebut_nama_awalan; ?>" placeholder="Kata pengawal">
					</td>
				</tr>
				<tr>
					<td>
						Gunakan kuota SMS
					</td>
					<td>
						<select name="kuota_use" class="input-small">
							<option value="TRUE">Ya</option>
							<option value="FALSE" <?php if ($kuota_use=="FALSE") { echo "selected";} else { echo "";}?>> Tidak</option>
						</select>

					</td>
				</tr>
				<tr>
					<td>
						Jumlah kuota
					</td>
					<td>
						<input type="text" value="<?php echo $kuota; ?>" name="kuota" placeholder="Kuota">
					</td>
				</tr>
				<tr>
					<td>
						Tanggal tetapan kuota
					</td>
					<td>
<input type="text" id="tanggal" value="<?php echo $kuota_tanggal; ?>" name="kuota_tanggal">

            <!--javascript for datepicker-->
            <script src="<?php echo $base_url;?>application/views/datepicker/js/bootstrap-modal.js"></script>
            <script src="<?php echo $base_url;?>application/views/datepicker/js/bootstrap-transition.js"></script>
            <script src="<?php echo $base_url;?>application/views/datepicker/js/bootstrap-datepicker.js"></script>

					</td>
				</tr>
				<tr>
					<td>
						Lokasi berkas log
					</td>
					<td>
						<input type="text" class="something" name="path_log" value="<?php echo $path_log; ?>" placeholder="Path">
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
						<input type="hidden" value="TRUE" name="action">
						<input type="submit" value="Simpan" name="submit" class="btn btn-primary">
					</td>
				</tr>
			</table>
			</form>
		</p>
		* SMS secara personal dengan menyebut nama, misal "Yth Bpk. $nama, isi sms".
	</div>
