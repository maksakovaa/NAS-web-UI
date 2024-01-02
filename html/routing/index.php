<?php
$iptables = "/etc/network/if-pre-up.d/nat";
exec ("cat ".$iptables, $config);
if (!empty($_POST) and empty($_GET)) { }
elseif (empty($_POST) and !empty($_GET)) { }
else {
	include '../nav.php';
	include '../header.php';
	include '../menu.php';
	$expWAN = explode ("=", $config[5]);
	$expLAN = explode ("=", $config[8]);
	$expLANR = explode ("=", $config[9]);
	echo "<table align='left'><caption>Таблица переменных интерфейсов</caption>";
	echo "<tr class='center1'><td>Интерфейс для выхода в интернет</td><td>".$expWAN[1]."</td></tr>";
	echo "<tr class='center1'><td>Интерфейс локальной сети</td><td>".$expLAN[1]."</td></tr>";
	echo "<tr class='center1'><td>Диапазон IP-адресов ЛВС</td><td>".$expLANR[1]."</td></tr>";
	echo "</table>";
	echo "<table><caption>Таблица правил IPTABLES</caption><tr class='center1'><td>Цепочка</td><td>Протокол</td><td>Интерфейс</td><td>Доп.параметры</td><td>Порт</td><td>Действие</td></tr>";
	$c = 78;
	while ($c < count($config)) {
		$temp = str_replace("\$IPT -A ", "", $config[$c]);
		echo "<tr class='center1'><td>".stristr($temp, ' ', true)."</td>";
		if (strpos($temp, "-p tcp") !== false) {
			echo "<td>tcp</td>";
			$temp = str_replace("-p tcp", "", $temp);
		}
		elseif (strpos($temp, "-p udp") !== false) {
			echo "<td>udp</td>";
			$temp = str_replace("-p udp", "", $temp);
		}
		if (strpos($temp, "-i \$WAN") !== false) {
			echo "<td>".$expWAN[1]."</td>";
			$temp = str_replace("-i \$WAN", "", $temp);
		}
		else { echo "<td>ALL</td>"; }
		if (strpos($temp, "--ports") !== false) {
			echo "<td>".stristr(stristr($temp, ' '), '--ports', true)."</td>";
			echo "<td>".str_replace("--ports ", "", stristr(stristr(stristr($temp, ' '), '-j ', true), "--ports"))."</td>";
		}
		else {
			echo "<td>".stristr(stristr($temp, ' '), '--dport', true)."</td>";
			echo "<td>".str_replace("--dport ", "", stristr(stristr(stristr($temp, ' '), '-j ', true), "--dport"))."</td>";
		}
		echo "<td>".str_replace("-j ", "", stristr($temp, '-j '))."</td></tr>";
		$c++;
	}	
	echo "</table>";
	echo "</section></div></body></html>";
}
?>
