<?php
$hostapd = '/etc/hostapd/hostapd.conf';
if (!empty($_POST))
{
		exec("cat ".$hostapd, $config);
		$config[3] = "ssid=".$_POST[ssid];
		$config[4] = "hw_mode=".$_POST[hw_mode];
		$config[5] = "channel=".$_POST[channel];
		$config[13] = "wpa_passphrase=".$_POST[pass];
		$i = 0;
		exec ("sudo rm ".$hostapd);
		while ($i <= count($config)) {
			$write[$i] = "echo '".$config[$i]."' | sudo tee -a ".$hostapd;
			exec ($write[$i]);
			$i++;
		}
		header('Location: /settings');
}
else {
		include '../nav.php';
		include '../header.php';
		include '../menu.php';
		exec ("cat ".$hostapd, $config);
		$ssid = explode ("=",$config[3]);
		$hw_mode = explode ("=",$config[4]);
		$channel = explode ("=",$config[5]);
		$pass = explode ("=", $config[13]);
?>
		<form method='post'>
		<br>
			<table class="border">
				<tr>
					<td><b>Имя сети (SSID):</b></td>
					<td><input maxlength='25' size='25' name='ssid' value="<?php echo $ssid[1]; ?>"></td>
				</tr>
				<tr>
					<td><b>Пароль:</b></td>
					<td><input type='password' maxlength='25' size='25' name='pass' value="<?php echo $pass[1]; ?>"></td>
				</tr>
				<tr>
					<td><b>Режим сети</b></td>
					<td>
						<?php	
								if ($hw_mode[1] == "g") {
									echo "<select name='hw_mode'><option value='a'>a (5 GHz)</option><option value='g' selected>g (2.4 GHz)</option></select>";
								}
								else {
									echo "<select name='hw_mode'><option value='a' selected>a (5 GHz)</option><option value='g'>g (2.4 GHz)</option></select>";
								}
						?>
					</td>
				</tr>
				<tr>
					<td><b>Канал сети:</b></td>
					<td>
						<select name='channel'>
							<?php	$i = 1;
									while ($i <= 11) {
										echo "<option value='".$i;
										if ($channel[1] == $i)
											echo "' selected>".$i."</option>";
										else
											echo "'>".$i."</option>";
										$i++;
									}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan='2'><button type='submit'>Сохранить изменения</button></td>
				</tr>
			</table>
		</form>
		<?php } ?>
		</section>
		</div>
	</body>
</html>
