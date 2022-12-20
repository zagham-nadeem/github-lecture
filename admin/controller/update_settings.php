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

$connect = connect($database);
if(!$connect){
	
	header('Location: ./error.php');

} 

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$st_language = $_POST['st_language'];
	$st_currency = $_POST['st_currency'];
	$st_dateformat = $_POST['st_dateformat'];
	$st_currencyposition = $_POST['st_currencyposition'];
	$st_decimalseparator = $_POST['st_decimalseparator'];
	$st_facebook = $_POST['st_facebook'];
	$st_twitter = $_POST['st_twitter'];
	$st_youtube = $_POST['st_youtube'];
	$st_instagram = $_POST['st_instagram'];
	$st_linkedin = $_POST['st_linkedin'];
	$st_whatsapp = $_POST['st_whatsapp'];
	$st_email = $_POST['st_email'];
	$st_phone = $_POST['st_phone'];
	$st_officeaddress = $_POST['st_officeaddress'];
	$st_unit = $_POST['st_unit'];
	$st_maintenance = $_POST['st_maintenance'];
	$st_featuredproperties = $_POST['st_featuredproperties'];
	$st_recentproperties = $_POST['st_recentproperties'];
	$st_featuredposts = $_POST['st_featuredposts'];
	$st_featuredcities = $_POST['st_featuredcities'];
	$st_similarproperties = $_POST['st_similarproperties'];
	$st_offersproperties = $_POST['st_offersproperties'];
	$st_searchlimit = $_POST['st_searchlimit'];
	$st_propertieslimit = $_POST['st_propertieslimit'];
	$st_bloglimit = $_POST['st_bloglimit'];
	$st_defaultsearchpage = $_POST['st_defaultsearchpage'];
	$st_defaultpropertiespage = $_POST['st_defaultpropertiespage'];
	$st_defaultblogpage = $_POST['st_defaultblogpage'];
	$st_defaultprivacypage = $_POST['st_defaultprivacypage'];
	$st_defaultcontactpage = $_POST['st_defaultcontactpage'];
	$st_defaulttermspage = $_POST['st_defaulttermspage'];
	$st_analytics = $_POST['st_analytics'];
	$st_calculator = $_POST['st_calculator'];
	$st_recipientemail = $_POST['st_recipientemail'];
	$st_smtphost = $_POST['st_smtphost'];
	$st_smtpemail = $_POST['st_smtpemail'];
	$st_smtppassword = $_POST['st_smtppassword'];
	$st_smtpencrypt = $_POST['st_smtpencrypt'];
	$st_smtpport = $_POST['st_smtpport'];
	$st_recaptchakey = $_POST['st_recaptchakey'];
	$st_recaptchasecretkey = $_POST['st_recaptchasecretkey'];

$statment = $connect->prepare(
	"UPDATE settings SET
	st_language = :st_language,
	st_currency = :st_currency,
	st_dateformat = :st_dateformat,
	st_currencyposition = :st_currencyposition,
	st_decimalseparator = :st_decimalseparator,
	st_facebook = :st_facebook,
	st_twitter = :st_twitter,
	st_youtube = :st_youtube,
	st_instagram = :st_instagram,
	st_linkedin = :st_linkedin,
	st_whatsapp = :st_whatsapp,
	st_email = :st_email,
	st_phone = :st_phone,
	st_officeaddress = :st_officeaddress,
	st_unit = :st_unit,
	st_maintenance = :st_maintenance,
	st_featuredproperties = :st_featuredproperties,
	st_recentproperties = :st_recentproperties,
	st_featuredposts = :st_featuredposts,
	st_featuredcities = :st_featuredcities,
	st_similarproperties = :st_similarproperties,
	st_offersproperties = :st_offersproperties,
	st_searchlimit = :st_searchlimit,
	st_propertieslimit = :st_propertieslimit,
	st_bloglimit = :st_bloglimit,
	st_defaultsearchpage = :st_defaultsearchpage,
	st_defaultpropertiespage = :st_defaultpropertiespage,
	st_defaultblogpage = :st_defaultblogpage,
	st_defaultprivacypage = :st_defaultprivacypage,
	st_defaultcontactpage = :st_defaultcontactpage,
	st_defaulttermspage = :st_defaulttermspage,
	st_analytics = :st_analytics,
	st_calculator = :st_calculator,
	st_recipientemail = :st_recipientemail,
	st_smtphost = :st_smtphost,
	st_smtpemail = :st_smtpemail,
	st_smtppassword = :st_smtppassword,
	st_smtpencrypt = :st_smtpencrypt,
	st_smtpport = :st_smtpport,
	st_recaptchakey = :st_recaptchakey,
	st_recaptchasecretkey = :st_recaptchasecretkey
	");

$statment->execute(array(
	':st_language' => $st_language,
	':st_currency' => $st_currency,
	':st_dateformat' => $st_dateformat,
	':st_currencyposition' => $st_currencyposition,
	':st_decimalseparator' => $st_decimalseparator,
	':st_facebook' => $st_facebook,
	':st_twitter' => $st_twitter,
	':st_youtube' => $st_youtube,
	':st_instagram' => $st_instagram,
	':st_linkedin' => $st_linkedin,
	':st_whatsapp' => $st_whatsapp,
	':st_email' => $st_email,
	':st_phone' => $st_phone,
	':st_officeaddress' => $st_officeaddress,
	':st_unit' => $st_unit,
	':st_maintenance' => $st_maintenance,
	':st_featuredproperties' => $st_featuredproperties,
	':st_recentproperties' => $st_recentproperties,
	':st_featuredposts' => $st_featuredposts,
	':st_featuredcities' => $st_featuredcities,
	':st_similarproperties' => $st_similarproperties,
	':st_offersproperties' => $st_offersproperties,
	':st_searchlimit' => $st_searchlimit,
	':st_propertieslimit' => $st_propertieslimit,
	':st_bloglimit' => $st_bloglimit,
	':st_defaultsearchpage' => $st_defaultsearchpage,
	':st_defaultpropertiespage' => $st_defaultpropertiespage,
	':st_defaultblogpage' => $st_defaultblogpage,
	':st_defaultprivacypage' => $st_defaultprivacypage,
	':st_defaultcontactpage' => $st_defaultcontactpage,
	':st_defaulttermspage' => $st_defaulttermspage,
	':st_analytics' => $st_analytics,
	':st_calculator' => $st_calculator,
	':st_recipientemail' => $st_recipientemail,
	':st_smtphost' => $st_smtphost,
	':st_smtpemail' => $st_smtpemail,
	':st_smtppassword' => $st_smtppassword,
	':st_smtpencrypt' => $st_smtpencrypt,
	':st_smtpport' => $st_smtpport,
	':st_recaptchakey' => $st_recaptchakey,
	':st_recaptchasecretkey' => $st_recaptchasecretkey
));

}

}elseif($check_access['user_role'] == 2){

	require '../views/denied.view.php';
	
}else{
	
	header('Location:'.SITE_URL);
}

    
}else {
		header('Location: ./login.php');		
		}


?>