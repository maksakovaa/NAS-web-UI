<?php
include '../nav.php';
include '../header.php';
include '../menu.php';
exec ('sudo smartctl -i /dev/sda',$name1);
exec ('sudo smartctl -A /dev/sda',$out1);
echo "<br>";
	echo "<table>";
		echo "<tr class='border'><td colspan='10'>";
		$i = 4;
		while ($i <= count($name1)-2) {
			echo $name1[$i]."<br>";
			$i++;
		}
		echo "</td></tr>";
		$i = 6;
		while ($i <= count($out1)-2) {
			$output1 = explode(" (Average ", $out1[$i]);
			$output1 = str_ireplace (" (Min/Max 20/54)", "", $output1[0]);
			$output1 = preg_replace('| +|', ' ', $output1);
			$output1 = ltrim($output1);
			$output1 = str_replace (" ", "</td><td>", $output1);
			if ($i == 6) {
				echo "<tr class='center1'><td>".$output1."</td></tr>";
			}
			else {
				echo "<tr class='center2'><td>".$output1."</td></tr>";
			}
			$i++;
	}

	echo "</table>";
	
	exec ('sudo smartctl -i /dev/sdb',$name2);
	exec ('sudo smartctl -A /dev/sdb',$out2);
	echo "<table>";
	echo "<tr class='border'><td colspan='10'>";
	$i = 4;
	while ($i <= count($name2)-2) {
		echo $name2[$i]."<br>";
		$i++;
	}
	echo "</td></tr>";
	$i = 6;
	while ($i <= count($out2)-2) {
		$output2 = explode(" (Average ", $out2[$i]);
		$output2 = str_ireplace (" (Min/Max 20/54)", "", $output2[0]);
		$output2 = preg_replace('| +|', ' ', $output2);
		$output2 = ltrim($output2);
		$output2 = str_replace (" ", "</td><td>", $output2);
		if ($i == 6) {
			echo "<tr class='center1'><td>".$output2."</td></tr>";
		}
		else {
			echo "<tr class='center2'><td>".$output2."</td></tr>";
		}		
		$i++;
	}
	echo "</table>";
echo "</section></div></body></html>";
?>
