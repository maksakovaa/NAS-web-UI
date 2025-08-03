<?php
$current_page = $_SERVER['REQUEST_URI'];
$link[0] = "<a href='/'>Main</a>";
$link[1] = "<a target='_blank' href='/jellyfin'>Jellyfin</a>";
$link[2] = "<a target='_blank' href='/torrent'>qBittorrent</a>";
$link[3] = "<a href='/smart/'>SMART Status</a>";
$link[4] = "<a href='/network/'>Network Status</a>";
$link[5] = "<a href='/settings/'>Wi-Fi Settings</a>";
$link[6] = "<a href='/dhcp/'>DHCP</a>";
$link[7] = "<a href='/routing/'>Routing</a>";
$link[8] = "<a href='/samba/'>Samba</a>";
switch ($current_page) {
	case "/":
	$cssclass[0] = "class='active'";
	$link[0] = $current_page = "Main";
	$cssclass[1] = $cssclass[2] = $cssclass[3] = $cssclass[4] = $cssclass[5] = $cssclass[6] = $cssclass[7] = $cssclass[8] = "class='nonactive'";
	break;
	case "/smart/":
	$cssclass[3] = "class='active'";
	$link[3] = $current_page  = "SMART Status";
	$cssclass[1] = $cssclass[2] = $cssclass[0] = $cssclass[4] = $cssclass[5] = $cssclass[6] = $cssclass[7] = $cssclass[8] = "class='nonactive'";
	break;
	case "/network/":
	$cssclass[4] = "class='active'";
	$link[4] = $current_page  = "Network Status";
	$cssclass[1] = $cssclass[2] = $cssclass[0] = $cssclass[3] = $cssclass[5] = $cssclass[6] = $cssclass[7] = $cssclass[8] = "class='nonactive'";
	break;
	case "/settings/":
	$cssclass[5] = "class='active'";
	$link[5] = $current_page  = "Wi-Fi Settings";
	$cssclass[1] = $cssclass[2] = $cssclass[0] = $cssclass[4] = $cssclass[3] = $cssclass[6] = $cssclass[7] = $cssclass[8] = "class='nonactive'";
	break;
	case "/dhcp/":
	$cssclass[6] = "class='active'";
	$link[6] = $current_page  = "DHCP";
	$cssclass[1] = $cssclass[2] = $cssclass[0] = $cssclass[4] = $cssclass[3] = $cssclass[5] = $cssclass[7] = $cssclass[8] = "class='nonactive'";
	break;
	case "/routing/":
	$cssclass[7] = "class='active'";
	$link[7] = $current_page  = "Routing";
	$cssclass[1] = $cssclass[2] = $cssclass[0] = $cssclass[4] = $cssclass[3] = $cssclass[5] = $cssclass[6] = $cssclass[8] = "class='nonactive'";
	break;
	case "/samba/":
	$cssclass[8] = "class='active'";
	$link[8] = $current_page  = "Samba";
	$cssclass[1] = $cssclass[2] = $cssclass[0] = $cssclass[4] = $cssclass[3] = $cssclass[5] = $cssclass[6] = $cssclass[7] = "class='nonactive'";
	break;
	case "/samba/?edit=1":
	$cssclass[8] = "class='active'";
	$link[8] = $current_page  = "Samba";
	$cssclass[1] = $cssclass[2] = $cssclass[0] = $cssclass[4] = $cssclass[3] = $cssclass[5] = $cssclass[6] = $cssclass[7] = "class='nonactive'";
	break;
}
?>
