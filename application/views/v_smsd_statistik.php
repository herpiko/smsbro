<div class="well">
	<h4><?php echo $title; ?></h4>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart1);
      google.setOnLoadCallback(drawChart2);
      function drawChart1() {
	       var data = google.visualization.arrayToDataTable([
          ['Tanggal', 'SMS Keluar'],

          <?php echo $statistik_bulan_ini; ?>
        ]);

        var options = {
          title: '',
          hAxis: {title: 'Tanggal',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div1'));
        chart.draw(data,options);
      }

      function drawChart2() {
	       var data = google.visualization.arrayToDataTable([
          ['Tanggal', 'SMS Keluar'],

          <?php echo $statistik_bulan_seb; ?>
        ]);

        var options = {
          title: '',
          hAxis: {title: 'Tanggal',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>

	<p>
  <?php
    if ($kuota_use=="TRUE") {
    echo $kuota_use;
      echo "Kuota : ".$kuota." per tanggal ".$kuota_tanggal;
      echo "<br>";
      echo "Kuota terpakai : ".$kuota_terpakai;
      echo "<br>";
      echo "Kuota tersisa : ".$kuota_tersisa;
  }
   ?>
  <br>
  <br>
	Periode <?php echo $bulan_ini_awal; ?> sampai dengan <?php echo $bulan_ini_akhir; ?>. Total SMS keluar : <?php echo $jumlah_bulanan; ?>
    <div id="chart_div1" style="height: 400px;"></div>
	</p>
	<br>
	<br>
  Bulan sebelumnya :
  <br>
	<p>
	Periode <?php echo $bulan_seb_awal; ?> sampai dengan <?php echo $bulan_seb_akhir; ?>. Total SMS keluar : <?php echo $jumlah_bulanan_seb; ?>
    <div id="chart_div2" style="height: 400px;"></div>
	</p>

	</div>
