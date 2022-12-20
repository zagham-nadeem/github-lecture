<?php

require '../config.php';
require '../routes.php';
require './app_functions.php';

$connect = connect();

// Site Configuration
$settings = getSettings($connect);

// Theme Configuration
$theme = getTheme($connect);

// Get Languages
$getLanguages = getLanguages($connect);

// Get Language
$lang = checkLanguage(getParamsLang());

// Get Translation
$translation = getStrings($connect, $settings['st_language'], $lang);

// Get General Settings
$currency = $settings['st_currency'];
$unit = $settings['st_unit'];

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

$urlPath = new Routes();

?>