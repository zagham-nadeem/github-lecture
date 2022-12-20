<?php 

/*--------------------*/
// Description: Evora - Real Estate CMS
// Author: Evora
// Author URI: https://wicombit.com
/*--------------------*/

session_start();
if (isset($_SESSION['user_email'])){


require '../../config.php';
require '../functions.php';
require '../views/header.view.php';

$connect = connect($database);
if(!$connect){
header('Location: ./error.php');
} 

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

$partner_name = cleardata($_POST['partner_name']);
$partner_status = cleardata($_POST['partner_status']);

$partner_image = $_FILES['partner_image']['tmp_name'];

$imagefile = explode(".", $_FILES["partner_image"]["name"]);
$renamefile = round(microtime(true)) . '.' . end($imagefile);

$image_upload = '../../images/';

move_uploaded_file($partner_image, $image_upload . 'partner_' . $renamefile);

$statment = $connect->prepare("INSERT INTO partners (partner_id, partner_name, partner_image, partner_status) VALUES (null, :partner_name, :partner_image, :partner_status)");

$statment->execute(array(
':partner_name' => $partner_name,
':partner_image' => 'partner_' . $renamefile,
':partner_status' => $partner_status
));

header('Location: ./partners.php');


}

require '../views/new.partner.view.php';

}elseif($check_access['user_role'] == 2){

	require '../views/denied.view.php';
	
}else{
	
	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';

}else {
header('Location: ./login.php');		
}


?>