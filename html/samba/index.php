<?php
$smb = "/etc/samba/smb.conf";
exec ("cat ".$smb, $config);

//Проверка наличия передачи данных формы методом POST и отстутствие данных переданных методом GET:
if (!empty($_POST) and empty($_GET)) {
		if (isset($_POST['name']) and isset($_POST['path'])) {
			$z = count($config);
			$config[$z] = "[".$_POST['name']."]";
			$z++;
			$config[$z] = "path = ".$_POST['path'];
			$z++;
			if ($_POST['rw'] == "on") {
				$config[$z] = "read only = no";
				$z++;
				$config[$z] = "writable = yes";
				$z++;
				}
			else {
				$config[$z] = "read only = yes";
				$z++;
				$config[$z] = "writable = no";
				$z++;
			}
			$config[$z] = "hide files = /$RECYCLE.BIN/desktop.ini/lost+found/Thumbs.db/~*/";
			$z++;
			$config[$z] = "public = yes";
			$i++;
			$z++;
		}
		$c = 0;
		exec ("sudo rm ".$smb);
		while ($c < count($config)) {
			$write[$c] = "echo '".$config[$c]."' | sudo tee -a ".$smb;
			exec ($write[$c]);
			$c++;
		}
		exec ("sudo systemctl restart smbd");
		header('Location: /samba/');
	}

//В случае наличия данных переданных методом POST и GET 
elseif (!empty($_POST) and !empty($_GET) and $_GET['edit'] == '1') {
	$q = ((count($_POST)/3)-1);
	$i = 0;
	if (count($config)>19)	{
		$z=0;
		while ($z<20) {
			$temp[$z] = $config[$z];
			$z++;
		}
		while ($i <= $q) {
				if ($_POST['delshare'.$i] == "on") { $i++; }
				else if (isset($_POST['name'.$i]) and isset($_POST['path'.$i])) {
					$temp[$z] = "[".$_POST['name'.$i]."]";
					$z++;
					$temp[$z] = "path = ".$_POST['path'.$i];
					$z++;
					if ($_POST['rw'.$i] == "on") {
						$temp[$z] = "read only = no";
						$z++;
						$temp[$z] = "writable = yes";
						$z++;
					}
					else {
						$temp[$z] = "read only = yes";
						$z++;
						$temp[$z] = "writable = no";
						$z++;
					}
					$temp[$z] = "hide files = /$RECYCLE.BIN/desktop.ini/lost+found/Thumbs.db/~*/";
					$z++;
					$temp[$z] = "public = yes";
					$i++;
					$z++;
				}
				else { $i++; }
			}
			$c = 0;
			exec ("sudo rm ".$smb);
			while ($c < count($temp)) {
				$write[$c] = "echo '".$temp[$c]."' | sudo tee -a ".$smb;
				exec ($write[$c]);
				$c++;
			}
			exec ("sudo systemctl restart smbd");
			header('Location: /samba/');
		}
		else {
			$z=20;
			while ($i <= $q) {
				$config[$z] = "[".$_POST['name'.$i]."]";
				$z++;
				$config[$z] = "path = ".$_POST['path'.$i];
				$z++;
				if ($_POST['rw'.$i] == "on") {
					$config[$z] = "read only = no";
					$z++;
					$config[$z] = "writable = yes";
					$z++;
				}
				else {
					$config[$z] = "read only = yes";
					$z++;
					$config[$z] = "writable = no";
					$z++;
				}
				$config[$z] = "hide files = /$RECYCLE.BIN/desktop.ini/lost+found/Thumbs.db/~*/";
				$z++;
				$config[$z] = "public = yes";
				$i++;
				$z++;
			}
			$c = 0;
			exec ("sudo rm ".$smb);
			while ($c < count($config)) {
				$write[$c] = "echo '".$config[$c]."' | sudo tee -a ".$smb;
				exec ($write[$c]);
				$c++;
			}
			exec ("sudo systemctl restart smbd");
			header('Location: /samba/');
		}
}

//В случае наличия данных переданных методом GET и отсутствия данных переданных методом POST 
elseif (empty($_POST) and !empty($_GET) and $_GET['edit'] == '1') {
	include '../nav.php';
	include '../header.php';
	include '../menu.php';
	echo "<br>";
		if (count($config)>19) {
		$i=20;
		$k=0;
		while (count($config)>$i) {
				$share[$k] = $config[$i]."|";
				$i++;
				$share[$k] .= $config[$i]."|";
				$i++;
				$share[$k] .= $config[$i]."|";
				$i++;
				$share[$k] .= $config[$i]."|";
				$i++;
				$share[$k] .= $config[$i]."|";
				$i++;
				$share[$k] .= $config[$i];
				$i++;
				$k++;
		}
		echo "<table><tr class='center1'><td>Share name</td><td>Share path</td><td>Writable</td><td>Delete</td></tr>";
		echo "<form method=post name=tableshare>";
		foreach ($share as $key => $value) {
			$temp = explode ("|", $value);
			$name = str_replace("[", "", $temp[0]);
			$name = str_replace("]", "", $name);
			$path = explode (" = ", $temp[1]);
			$path = $path[1];
			if ($temp[2] == "read only = no" AND $temp[3] == "writable = yes") {
					$rw = "checked";
			} else { $rw = ""; }
			echo "<tr class='center2'><td width=150><input maxlength='20' size='20' name='name".$key."' value='".$name."' required></td><td width=200><input maxlength='25' size='25' name='path".$key."' value='".$path."' required></td><td><input type='checkbox' name='rw".$key."' ".$rw."></td><td><input type=checkbox name='delshare".$key."'></td></tr>";
		}
		echo "<tr><td colspan=4 align='left'><button>Сохранить изменения</button><input type='button' value='Отмена' onClick=location.href='/samba/'></td></tr></form>";
		echo "</table>";
	}
	echo "</section></div></body></html>";
}

//В случае отсутствия данных переданных методом POST и GET
else {
	include '../nav.php'; // php определение текущей страницы и тайтла для страницы
	include '../header.php'; // html болванка со стилями
	include '../menu.php'; // панель навигации
	echo "<br>";
		if (count($config)>19) {
		$i=20;
		$k=0;
		while (count($config)>$i) {
				$share[$k] = $config[$i]."|";
				$i++;
				$share[$k] .= $config[$i]."|";
				$i++;
				$share[$k] .= $config[$i]."|";
				$i++;
				$share[$k] .= $config[$i]."|";
				$i++;
				$share[$k] .= $config[$i]."|";
				$i++;
				$share[$k] .= $config[$i];
				$i++;
				$k++;
		}
		echo "<table><tr class='center1'><td width=150>Share name</td><td width=200>Share path</td><td>Writable</td></tr>";
		foreach ($share as $value) {
			$temp = explode ("|", $value);
			$name = str_replace("[", "", $temp[0]);
			$name = str_replace("]", "", $name);
			$path = explode (" = ", $temp[1]);
			$path = $path[1];
			if ($temp[2] == "read only = no" AND $temp[3] == "writable = yes") {
					$rw = "yes";
			} else { $rw = "no"; }
			echo "<tr class='center2'><td>".$name."</div></td><td>".$path."</td><td>".$rw."</td></tr>";
		}
		echo "<tr><td colspan=3><form name='edit'><button name=edit value=1>Изменить</button></form></td></tr></table>";
	}
	else { echo "<br>В данный момент не задано ни одной общей папки."; }
		echo "<table>";
			echo "<tr class='center1'>";
				echo "<td>Share name</td>";
				echo "<td>Share path</td>";
				echo "<td>Writable</td>";
			echo "</tr>";
			echo "<form method=post name=add_share>";
				echo "<tr class='center1'>";
					echo "<td width=150><input maxlength='20' size='20' name='name' required></td>";
					echo "<td width=200><input maxlength='25' size='25' name='path' required></td>";
					echo "<td><input type='checkbox' name='rw'></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td colspan=3><button>Добавить</button></td>";
				echo "</tr>";
			echo "</form>";
		echo "</table>";
	echo "</section></div></body></html>";
}
?>
