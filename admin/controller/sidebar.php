<?php 

/*--------------------*/
// Description: Evora - Real Estate CMS
// Author: Evora
// Author URI: https://wicombit.com
/*--------------------*/

include_once '../../config.php';
include_once '../functions.php';

if(!isset($connect)){

	$connect = connect($database);
}

if (isAdmin($connect) || isAgent($connect)){

 
$user = get_user_information($connect);
$user = $user['0'];

$check_access = check_access($connect);

if ($check_access['user_role'] == 2){

require '../views/sidebar-editor.view.php';

}elseif($check_access['user_role'] == 1) {

require '../views/sidebar.view.php';

}

}else{

    header('Location:'.SITE_URL);
}

?>