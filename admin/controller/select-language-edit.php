<?php 

/*--------------------*/
// Description: Evora - Real Estate CMS
// Author: Evora
// Author URI: https://wicombit.com
/*--------------------*/

$url = strtok($_SERVER["REQUEST_URI"],'?');
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$url";

if (isset($_GET['lang'])) {
	$lang = $_GET['lang'];
}

require '../views/select-language-edit.view.php';


?>