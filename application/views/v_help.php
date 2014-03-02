<div class="well">
	<h4><?php echo $title; ?></h4>
	<br><br>
		<h4>Mengenai Service Gammu</h4>
		<p>Secara default, service gammu-smsd tidak dapat dijalankan oleh user biasa, termasuk user milik service apache2. Anda perlu membuat sebuah aturan khusus untuk perangkat GSM anda di /etc/udev/rules.d/99-phone.rules agar gammu-smsd dapat dijalankan oleh user biasa sehingga tombol "Jalankan Gammu" di antar muka web dapat berfungsi.
		</p>

		<p>
			Dengan asumsi perangkat GSM anda memiliki idVendor 0eba dan idProduct 1080 (dapat dilihat dengan lsusb), berikut contoh isi berkas 99-phone.rules :
			<br><br>
			ACTION=="add", SUBSYSTEM=="tty", ATTRS{idVendor}=="0eba", ATTRS{idProduct}=="1080", NAME="phone", MODE="0777"
			<br><br>
			Kemudian restart sistem anda untuk melihat hasilnya.
			<br><br>
			Referensi : <a target="_blank" href="http://askubuntu.com/questions/211739/gammu-and-device-permissions">http://askubuntu.com/questions/211739/gammu-and-device-permissions</a>
		</p>
		<br><br>
		<h4>Berkas log</h4>
		<p>Pada 'Lainnya --> Pengaturan', tuliskan lokasi berkas log dari gammu-smsd yang benar di sistem anda sesuai konfigurasi yang ada. Hal ini penting untuk memonitor status sinyal dan lainnya.
		</p>

		<br><br>

		<h4>Lain-lain</h4>
		<p>Beberapa fitur mungkin tidak berfungsi dan masih dalam pengerjaan. Anda bisa mengulangi proses instalasi untuk mendapatkan update dari github.
		<br><br>

			Untuk segala jenis bentuk timbal balik, saya dengan senang hati menerima surat di herpiko@gmail.com
		</p>

	</div>
