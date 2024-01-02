<?php
/*ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/
if (!empty($_GET) AND $_GET["power"] == "off") {
		include 'nav.php';
		include 'header.php';
		include 'menu.php';
		echo "<br>NAS выключается...</section></div></body></html>";
		exec("sudo poweroff");
} elseif (!empty($_GET) AND $_GET["power"] == "reboot") {
		include 'nav.php';
		include 'header.php';
		include 'menu.php';
		echo "<br>NAS перезагружается...</section></div></body></html>";
		exec("sudo reboot");
} else {
		include 'nav.php';
		include 'header2.php';
		include 'menu.php';
		exec ("df /dev/nvme0n1p2", $ssd);
		exec ("df -BGB /dev/mapper/vg1-Data", $lvm);
		$lvm = preg_replace('!\s++!u', ' ', $lvm);
		$lvm = str_replace('&amp;', '&', $lvm);
		$lvm = str_replace('&nbsp;', ' ', $lvm);
		$lvm = str_replace('GB', '', $lvm);
		preg_replace('/\s+/', ' ', $lvm);
		$lvma = explode (" ", $lvm[1]);
		$ssda = explode (" ", $ssd[1]);
		$measure = "TB";
		$lvma[1] = round($lvma[1]/1024, 2);		
		$lvma[2] = round($lvma[2]/1024, 2);
		$lvma[3] = round($lvma[3]/1024, 2);
		$ssda[1] = round($ssda[1]/1048576, 2);
		$ssda[2] = round($ssda[2]/1048576, 2);
		$ssda[3] = round($ssda[3]/1048576, 2);
		?>
		<table style="border=0">
			<tr>
				<td colspan=2 align=center style="font-size: 18px">Состояние накопителей NAS:</td>
			</tr>
			<tr>
				<td> 
					<div style="width: 350px; height: 200px; border: 1px solid #b2b2b2; font-size: 16px; padding: 10px 0px;" align=center>
					LVM - массив [<?php echo $lvma[1].$measure; ?>]:
					<canvas id="myChart"></canvas>
					</div>
					<script>
					var ctx = document.getElementById('myChart').getContext('2d');
					var myPieChart = new Chart(ctx, {
						type: 'pie',
					data: {
							labels: ['Свободно (<?php echo $lvma[3].$measure ?>)', 'Занято (<?php echo $lvma[2].$measure ?>)'],
							datasets: [{
								data: [<?php echo $lvma[3]; ?>, <?php echo $lvma[2]; ?>],
								backgroundColor: [
									'rgba(0, 255, 0, 1)',
									'rgba(255, 0, 0, 1)',
								],
								borderColor: [
									'rgba(0, 0, 0, 1)',
									'rgba(0, 0, 0, 1)',
								],
								borderWidth: 1
							}]
						},
					});
					</script>
				</td>
				<td>
					<div style="width: 350px; height: 200px; border: 1px solid #b2b2b2; font-size: 16px; padding: 10px 0px;"  align=center>
					NVME-SSD [<?php echo $ssda[1]."GB"; ?>]:
					<canvas id="myChart2"></canvas>
					</div>
					<script>
					var ctx = document.getElementById('myChart2').getContext('2d');
					var myPieChart = new Chart(ctx, {
						type: 'pie',
					data: {
							labels: ['Свободно (<?php echo $ssda[3]; ?>GB)', 'Занято (<?php echo $ssda[2]; ?>GB)'],
							datasets: [{
								data: [<?php echo $ssda[3]; ?>, <?php echo $ssda[2]; ?>],
								backgroundColor: [
									'rgba(0, 255, 0, 1)',
									'rgba(255, 0, 0, 1)',
								],
								borderColor: [
									'rgba(0, 0, 0, 1)',
									'rgba(0, 0, 0, 1)',
								],
								borderWidth: 1
							}]
						},
					});
					</script>
				</td>
			</tr>
				<tr>
				<td colspan=2 align=center style="font-size: 18px">Управление питанием NAS:</td>
			</tr>
			
			<tr align='center'>
				<td>
					<div style="border: 1px solid #b2b2b2; font-size: 16px; padding: 10px 0px;">
					<br><a href='/?power=off' class="rollover1" style="text-decoration: none;"></a>Power OFF
					</div>
				</td>
				<td>
					<div style="border: 1px solid #b2b2b2; font-size: 16px; padding: 10px 0px;  text-decoration: none;">
					<br><a href='/?power=reboot' class="rollover2" style="text-decoration: none;"></a>Restart NAS
					</div>
				</td>
			</tr>
			
		</table>
		</section></div></body></html>
<?php } ?>
