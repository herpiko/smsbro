<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>
<div class="">
	<h4><?php echo $title; ?></h4>
		

		<div class="">
		<div class="tabbable">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">Bulanan</a></li>
<li><a href="#tab2" data-toggle="tab">Mingguan</a></li>
<li><a href="#tab3" data-toggle="tab">Harian</a></li>
<li><a href="#tab4" data-toggle="tab">Non-interval</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane active well" id="tab1">
<p>
<form method="post" action="<?php echo $base_url;?>c_terjadwal/bulanan_append" class="form-horizontal">
	<input type="text" class="input-block-level" name="deskripsi" value="" placeholder="Deskripsi jadwal"><br><br>
Dijadwal setiap tanggal : <select class="input-mini" type="text" name="tgl" value="">
		<option></option>
		<option>1</option>
		<option>2</option>
		<option>3</option>
		<option>4</option>
		<option>5</option>
		<option>6</option>
		<option>7</option>
		<option>8</option>
		<option>9</option>
		<option>10</option>
		<option>11</option>
		<option>12</option>
		<option>13</option>
		<option>14</option>
		<option>15</option>
		<option>16</option>
		<option>17</option>
		<option>18</option>
		<option>19</option>
		<option>20</option>
		<option>21</option>
		<option>22</option>
		<option>23</option>
		<option>24</option>
		<option>25</option>
		<option>26</option>
		<option>27</option>
		<option>28</option>
		<option>29</option>
		<option>30</option>
		<option>31</option>
		</select> jam : <input class="input-mini" type="text" name="jam" value="" placeholder="00:00">

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
		<textarea row="3" class="input-block-level" name="pesan" value="" placeholder="Pesan"  onkeyup="countChar1(this)"></textarea>
		</div>
		<div class="control-group">
		<input type="submit" name="submit1" value="Simpan" class="btn btn-primary">
		&nbsp&nbsp&nbsp
		<a href="<?php echo $base_url;?>c_grup_sms" class="btn">Kelola kelompok</a>&nbsp&nbsp&nbsp<a href="<?php echo $base_url;?>c_send/index/4#tab4" class="btn">Batal</a>
		<p class="pull-right"><strong id="charNum1"></strong><i id="charNumPart1"></i></p>
		</div>
		</form>
</p>
</div>
<div class="tab-pane well" id="tab2">
<p>
<form method="post" action="<?php echo $base_url;?>c_terjadwal/mingguan_append" class="form-horizontal">
	<input type="text" class="input-block-level" name="deskripsi" value="" placeholder="Deskripsi jadwal"><br><br>
Dijadwal setiap hari : <select class="input-small" type="text" name="hari" value="">
		<option></option>
		<option>Minggu</option>
		<option>Senin</option>
		<option>Selasa</option>
		<option>Rabu</option>
		<option>Kamis</option>
		<option>Jumat</option>
		<option>Sabtu</option>
		
		</select> pada jam : <input class="input-mini" type="text" name="jam" value="" placeholder="00:00">

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
		<textarea row="3" class="input-block-level" name="pesan" value="" placeholder="Pesan"  onkeyup="countChar2(this)"></textarea>
		</div>
		<div class="control-group">
		<input type="submit" name="submit2" value="Simpan" class="btn btn-primary">
		&nbsp&nbsp&nbsp
		<a href="<?php echo $base_url;?>c_grup_sms" class="btn">Kelola kelompok</a>&nbsp&nbsp&nbsp<a href="<?php echo $base_url;?>c_send/index/4#tab4" class="btn">Batal</a>
		<p class="pull-right"><strong id="charNum2"></strong><i id="charNumPart2"></i></p>
		</div>
		</form>
</p>
</div>
<div class="tab-pane well" id="tab3">
<p>
<form method="post" action="<?php echo $base_url;?>c_terjadwal/harian_append" class="form-horizontal">
	<input type="text" class="input-block-level" name="deskripsi" value="" placeholder="Deskripsi jadwal"><br><br>
Dijadwal setiap jam : <input class="input-mini" type="text" name="jam" value="" placeholder="00:00">

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
		<textarea row="3" class="input-block-level" name="pesan" value="" placeholder="Pesan"  onkeyup="countChar3(this)"></textarea>
		</div>
		<div class="control-group">
		<input type="submit" name="submit3" value="Simpan" class="btn btn-primary">
		&nbsp&nbsp&nbsp
		<a href="<?php echo $base_url;?>c_grup_sms" class="btn">Kelola kelompok</a>&nbsp&nbsp&nbsp<a href="<?php echo $base_url;?>c_send/index/4#tab4" class="btn">Batal</a>
		<p class="pull-right"><strong id="charNum3"></strong><i id="charNumPart3"></i></p>
		</div>
		</form>
</p>
</div>

<div class="tab-pane well" id="tab4">
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
</div>