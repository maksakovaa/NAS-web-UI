<nav>
	<ul class='top-menu'>
		<?php
			$i = 0;
			while ($i <= 8) {
				echo "<li ".$cssclass[$i].">".$link[$i]."</li>";
				$i++;
			}
		?>
	</ul>
</nav>
<section align='center'>