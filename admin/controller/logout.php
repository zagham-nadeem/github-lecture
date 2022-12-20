<?php 

/*--------------------*/
// Description: Evora - Real Estate CMS
// Author: Evora
// Author URI: https://wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

$connect = connect($database);

if (isAdmin($connect) || isAgent($connect)){
    
	session_start();

	session_destroy();
	$_SESSION = array ();

	header('Location: ./login.php');

}else{

    header('Location:'.SITE_URL);
}




?>