<?php
include '../nav.php';
include '../header.php';
include '../menu.php';
exec ('sudo ifconfig',$ifconfig);
exec ('sudo /etc/hostapd/show',$wifi);
?>
			<br>
				<table>
					<tr class='center1'>
						<td align=center>Network Interfaces:</td>
						<td align=center>Wi-Fi clients:</td>
					</tr>
					<tr class='border'>
						<td>
							<?php
								$i = 0;
								while ($i <= count($ifconfig)) {
									echo $ifconfig[$i]."<br>";
									$i++;
								}
							?>
						</td>
						<td valign=top>
							<table>
							<?php
								$i = 0;
								while ($i <= count($wifi)-1) {
									$wifi = str_replace ("|", "</td><td>", $wifi);
									$wifi = preg_replace('| +|', ' ', $wifi);
									echo "<tr><td>".$wifi[$i]."</td></tr>";
									$i++;
								}
							?>
							</table>
						</td>
					</tr>
				</table>
			</section>
		</div>
	</body>
</html>