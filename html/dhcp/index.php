<?php
$interfaces = "/etc/network/interfaces";
$dhcpd = "/etc/dhcp/dhcpd.conf";
exec ("cat ".$dhcpd, $dhcp);
if (!empty($_POST))
{
		$dhcp[0] = "subnet ".$_POST['net']." netmask ".$_POST['mask']." {";
		$net = explode (".", $_POST['net']);
		if ($_POST['ipf'] > $_POST['ipt']) { $range0 = $_POST['ipt']; $range1 = $_POST['ipf']; }
		else { $range0 = $_POST['ipf']; $range1 = $_POST['ipt']; }
		$dhcp[1] = "range ".$net[0].".".$net[1].".".$net[2].".".$range0." ".$net[0].".".$net[1].".".$net[2].".".$range1.";";
		$dhcp[2] = "option domain-name-servers ".$_POST['dns1'].", ".$_POST['dns2'].";";
		$dhcp[3] = "option routers ".$_POST['gate'].";";
		if (count($dhcp) > 5) {
			$q=4;
			while (count($dhcp)-$q >= 1) {
				$del = "delmac".$q;
				if (isset($_POST[$del])) {
					unset ($dhcp[$q]);
				}
				$q++;
			}
		$dhcp = array_values($dhcp);
		}
/*		var_dump($dhcp);*/
		$i = 0;
		exec ("sudo rm ".$dhcpd);
		while ($i < count($dhcp)) {
			$write[$i] = "echo '".$dhcp[$i]."' | sudo tee -a ".$dhcpd;
			exec ($write[$i]);
			$i++;
		}
		header('Location: /dhcp');
}
else {
	$subnet = explode (" ", $dhcp[0]);
	$range = explode (" ", $dhcp[1]);
	$range0 = explode (".", $range[1]);
	$range1 = explode (".", $range[2]);
	$range1[3] = str_replace (";", "", $range1[3]);
	$net = explode (".", $subnet[1]);
	$dns = explode (" ", $dhcp[2]);
	$dns1 = str_replace (",", "", $dns[2]);
	$dns2 = str_replace (";", "", $dns[3]);
	$gateway =  explode (" ", $dhcp[3]);
	$gate =  str_replace (";", "", $gateway[2]);
	if (count($dhcp) > 5) {
		$q = 4;
		while (count($dhcp)-$q > 1) {
			$host[] = $dhcp[$q];
			$q++;
		}
	}
	include '../nav.php';
	include '../header.php';
	include '../menu.php';
	?>
				<br>
					<form method='post'>
						<table class="border">
							<tr>
								<td>Подсеть:</td>
								<td><input name='net' type='text' minlength='7' maxlength='15' size='15' pattern='^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$'value='<?php echo $subnet[1] ?>'></td>
								<td rowspan='8' valign='top'>Привязка IP к MAC-адресу:<br>
									<table>
										<tr><td>Имя</td><td>MAC</td><td>IP-адресс</td><td>Удалить?</td><tr>
										<?php
										if (count($dhcp) > 5) {
											$q = 4;
											while (count($dhcp)-$q > 1) {
												$temp = explode (" ", $dhcp[$q]);
												$temp[5] = str_replace (";", "", $temp[5]);
												$temp[7] = str_replace (";", "", $temp[7]);
												echo "<tr><td>".$temp[1]."</td><td>".$temp[5]."</td><td>".$temp[7]."</td><td><input type='checkbox' name='delmac".$q."'></td></tr>";
											$q++;
											}
										}
										else { echo "<tr><td colspan='4'>Пока что нет добавленных устройств</td></tr>"; }
										
										?>
										
									</table>
								</td>
							</tr>
							<tr>
								<td>Маска сети:</td>
								<td><input name='mask' type='text' minlength='7' maxlength='15' size='15' pattern='^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$'value='<?php echo $subnet[3] ?>'></td>
							</tr>
							<tr>
								<td>Основной шлюз:</td>
								<td><input name='gate' type='text' minlength='7' maxlength='15' size='15' pattern='^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$'value='<?php echo $gate ?>'></td>
							</tr>
							<tr>
								<td colspan='2'>Диапазон IP-адресов:</td>
							</tr>
							<tr>
								<td>От <?php echo $net[0]; ?>.<?php echo $net[1]; ?>.<?php echo $net[2]; ?><input name='ipf' type='text' maxlength='3' size='3' value='<?php echo $range0[3]; ?>'></td>
								<td> до: <?php echo $net[0]; ?>.<?php echo $net[1]; ?>.<?php echo $net[2]; ?><input name='ipt' type='text' maxlength='3' size='3' value='<?php echo $range1[3]?>'></td>
							</tr>
							<tr>
								<td colspan='2'>Сервера системы доменных имён:</td>
							<tr>
								<td>DNS1:</td>
								<td><input name='dns1' type='text' minlength='7' maxlength='15' size='15' pattern='^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$'value='<?php echo $dns1; ?>'></td>
							</tr>
							<tr>
								<td>DNS2:</td>
								<td><input name='dns2' type='text' minlength='7' maxlength='15' size='15' pattern='^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$'value='<?php echo $dns2; ?>'></td>
							</tr>
							<tr>
								<td colspan='3' style="text-align: center;"><button type='submit'>Сохранить изменения</button></td>
							</tr>
						</table>
					</form>
				</section>
			</div>
		</body>
	</html>
<?php } ?>