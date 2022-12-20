<?php

session_start();

require(__DIR__ . '/config.php');
require(__DIR__ . '/functions.php');
require(__DIR__ . '/routes.php');

$connect = connect();

if (!$connect) {
	exit();
}

// Site Configuration
$settings = getSettings($connect);
$theme = getTheme($connect);

// Get Languages
$getLanguages = getLanguages($connect);

// Get Local Language Cookies
$lang = checkLanguage($connect, $settings['st_language']);

// Get Translation
$translation = getStrings($connect, $settings['st_language'], $lang);

// Get General Settings
$currency = $settings['st_currency'];
$unit = $settings['st_unit'];

// Get Language Settings
$getInfoLangByCode = getInfoLangByCode($connect, $lang);

$langDir = $getInfoLangByCode['language_type'];

// Ads
$headerAd = getHeaderAd($connect, $lang);
$footerAd = getFooterAd($connect, $lang);
$sidebarAd = getSidebarAd($connect, $lang);

// Social Media Links
$socialMedia = getSocialMedia($connect);

// Get user info
if (isLogged()){

$userInfo = getUserInfo($connect);

}

// Default Pages
$defaultSearchPage = getDefaultPage($connect, $settings['st_defaultsearchpage'], $lang);
$defaultPropertiesPage = getDefaultPage($connect, $settings['st_defaultpropertiespage'], $lang);
$defaultContactPage = getDefaultPage($connect, $settings['st_defaultcontactpage'], $lang);
$defaultBlogPage = getDefaultPage($connect, $settings['st_defaultblogpage'], $lang);
$defaultPrivacyPage = getDefaultPage($connect, $settings['st_defaultprivacypage'], $lang);
$defaultTermsPage = getDefaultPage($connect, $settings['st_defaulttermspage'], $lang);

define('SEARCH_PAGE', $defaultSearchPage['tr_slug']);
define('PROPERTIES_PAGE', $defaultPropertiesPage['tr_slug']);
define('CONTACT_PAGE', $defaultContactPage['tr_slug']);
define('BLOG_PAGE', $defaultBlogPage['tr_slug']);
define('PRIVACY_PAGE', $defaultPrivacyPage['tr_slug']);
define('TERMS_PAGE', $defaultTermsPage['tr_slug']);

// Maintenance Mode
$maintenanceMode = $settings['st_maintenance'];

$urlPath = new Routes();

if (isLogged()) {

if ($maintenanceMode == 1 && !isAdmin() && basename($_SERVER['PHP_SELF']) != 'offline.php') {

	header('Location: '. $urlPath->offline());
}

}elseif($maintenanceMode == 1 && basename($_SERVER['PHP_SELF']) != 'offline.php') {

	header('Location: '. $urlPath->offline());
}


?>