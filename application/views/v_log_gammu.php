
<div class="well">
	<h4><?php echo $title; ?></h4>
		<p>
			<strong>Ukuran / Lokasi berkas log </strong> : <?php $ukuran=exec("du -hs ".$path_log); echo $ukuran; ?>
			<br>
			<strong>tail : </strong>
			<br>
			<?php echo $log_gammu;?>
			<br><br>
		</p>
			<br><br><br>
		<strong>Crontab list :</strong>
		<p><?php echo $crontab;?></p>
		<br><br><br>
		<strong>Cron syslog :</strong>
		<p><?php $cronsyslog=shell_exec('grep CRON /var/log/syslog > /tmp/cronsyslog'); echo $cronsyslog;?>
			
		</p>
		
	</div>
