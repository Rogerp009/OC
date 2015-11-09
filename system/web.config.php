<?php
//------------------------------------------------------------
// comment out if output_buffering is already turned on
//------------------------------------------------------------ 
ob_start();

//------------------------------------------------------------
// turn off magic quotes
//------------------------------------------------------------ 
//ini_set('magic_quotes_gpc', 0); // 1=on 0=off

//------------------------------------------------------------
// instantiate sessions
//------------------------------------------------------------ 
if(!isset($_SESSION)){
  session_start();
}

//------------------------------------------------------------
// 0. WARN IF IE EXPLODER IS LESS THAN 9.0
//------------------------------------------------------------ 
define('DETECT_IE', 0); // 1=Yes 0=No

// ------------------------------------------------------------
// 1. ROOT PATH FOR INCLUDE FILES
// ------------------------------------------------------------
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/oc/system/'); // psum is subdirectory

// ------------------------------------------------------------
// 2. WEBSITE ADDRESS
// ------------------------------------------------------------
function siteURL()
{
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domainName = $_SERVER['HTTP_HOST'].'/'.'/oc/system/'; // psum is subdirectory
	return $protocol.$domainName;
}
define( 'SITE_URL', siteURL() );

// ------------------------------------------------------------
// 3. ACCOUNT ACTIVATION URL
// ------------------------------------------------------------
function verificationURL()
{
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domainName = $_SERVER['HTTP_HOST'].'/'.'/oc/system/'; // psum is subdirectory
	$pageName = 'account-activation.php';
	return $protocol.$domainName.$pageName;
}
define( 'ACCOUNT_ACTIVATION_URL', verificationURL() );

// ------------------------------------------------------------
// 4. DEFAULT LOGIN DESTINATION URL
// ------------------------------------------------------------
// if USE_DEFAULT_LOGIN_DESTINATION is set to 1, all users will be 
// redirected to DEFAULT_LOGIN_DESTINATION_URL after login, accept 
// the users who's destination URL has been custom set in admin panel.
define( 'USE_DEFAULT_LOGIN_DESTINATION', 0 ); // 1=On 0=Off
define( 'DEFAULT_LOGIN_DESTINATION_URL', siteURL().'index.php' ); // global login destination

// ------------------------------------------------------------
// 5. DEFAULT THEMES - CSS
// ------------------------------------------------------------
define( 'SITE_STYLE', SITE_URL.'themes/default/default.css' ); // root files non IE
define( 'ADMIN_STYLE', SITE_URL.'admin/themes/default/default.css' ); // admin files
define( 'USER_STYLE', SITE_URL.'user/themes/default/default.css' ); // user area files
define( 'USER_MENU_STYLE', SITE_URL.'user/themes/default/superfish.css' ); // user area files
define( 'ACCORDION_STYLE', SITE_URL.'user/themes/default/accordion.css' ); // user area files
define( 'FEEDBACK_STYLE', SITE_URL.'feedback/themes/default/default.css' ); // feedback form

// ------------------------------------------------------------
// 6. EMAIL ADDRESSES
// ------------------------------------------------------------
define( 'NO_REPLY', 'hunzonian@gmail.com' );
define( 'GENERAL_CONTACT', 'hunzonian@gmail.com' );
define( 'BULK_MAIL_TO', 'hunzonian@gmail.com' );

// ------------------------------------------------------------
// 7. MINIMUM PASSWORD REQUIREMENTS
// ------------------------------------------------------------
define( 'MIN_PASSWORD_LENGTH', 6 ); // set min length
define( 'REQUIRE_NUMBER', 1 ); // 0=no 1=yes
define( 'REQUIRE_SPECIAL_CHAR', 0 ); // 0=no 1=yes
define( 'ALLOW_USERNAME_IN_PASS', 0 ); // 0=no 1=yes
define( 'ALLOW_PW_STRENGTH_CHECK', 0 ); // 0=no 1=yes

// ------------------------------------------------------------
// 8. APPROVE NEW ACCOUNT ON CREATION
// ------------------------------------------------------------
define('INSTANT_ACCOUNT_APPROVAL', 0); // 0=no 1=yes
define('BY_ADMIN_APPROVAL_ONLY', 1); // 0=no 1=yes

// notify admin on new registration
define('REGISTRATION_NOTIFICATION', 0); // 0=no 1=yes
// notify admin on account activation
define('ACTIVATION_NOTIFICATION', 0); // 0=no 1=yes

// ------------------------------------------------------------
// 9. DEFAULT ROLES IN ORDER OF PRIORITY
// ------------------------------------------------------------
// owner = 1
// superadmin = 2
// admin = 3
// member = 4
// user = 5
define('DEFAULT_ROLE', "user");
define('DEFAULT_ROLE_ID', 5);

// ------------------------------------------------------------
// 10. MAX NUMBER OF LOGIN ATTEMPTS BEFORE LOCKOUT
// ------------------------------------------------------------
define('MAX_LOGIN_ATTEMPT', 4); 
define('LOCKOUT_DURATION', 1); // minutes

// ------------------------------------------------------------
// 11. AUTO LOGIN DURATION - Remember me cookie
// ------------------------------------------------------------
define('AUTO_LOGIN_DURATION', 1728000); // 20 days in seconds

// ------------------------------------------------------------
// 12. GRIDVIEW DEFAULT PAGE SIZE
// ------------------------------------------------------------
define('GV_PAGE_SIZE', 10); // rows

// ------------------------------------------------------------
// 13. RECAPTCHA KEYS - GET YOURS @ http://www.google.com/recaptcha
// ------------------------------------------------------------
define( 'RECAPTCHA_PRIVATE_KEY', "6LeV3r4SAAAAADURcKoSWySxTj9CQyJXHD57yO1z" );
define( 'RECAPTCHA_PUBLIC_KEY', "6LeV3r4SAAAAABp2Q2bjyjCRW8E6vvZ06oM6-6yj" );

// ------------------------------------------------------------
// 14. ENABLE DISABLE CAPTCHA
// ------------------------------------------------------------
define('LOGIN_CAPTCHA_ON', 0); // 1=on 0=off
define('REGISTER_CAPTCHA_ON', 0); // 1=on 0=off
define('FEEDBACK_CAPTCHA_ON', 0); // 1=on 0=off
define('CAPTCHA_ON_X', 0); // turn captcha ON after x failure

// ------------------------------------------------------------
// 15. USER PROFILES
// ------------------------------------------------------------
define('ENABLE_USER_PROFILES', 1); // 1=yes 0=no

// ------------------------------------------------------------
// 16. AVATAR IMAGE FILE
// ------------------------------------------------------------
define('AVATAR_FILE_SIZE', 51200); // 50 Kb max. -> 1 kilobyte = 1024 bytes
define('AVATAR_FILE_DIRECTORY', ROOT_PATH.'user/upload/avatars/'); // upload directory
define('AVATAR_IMAGE_URL', SITE_URL.'user/upload/avatars/'); // default avatar url
define('DEFAULT_AVATAR_IMAGE', 'default-avatar.png'); // default avatar image

// ------------------------------------------------------------
// 17. UNIQUE VISITORS ONLINE COUNTER
// ------------------------------------------------------------
define('ENABLE_VISITOR_COUNT', 0); // 1=yes 0=no
define('LAST_X_MINUTES', 15); // counts number of visitors in last x minutes

// ------------------------------------------------------------
// 18. FEEDBACK / CONTACT FORM
// ------------------------------------------------------------
// company logo
define('COMPANY_LOGO_SIZE', 51200); // 50 Kb max. -> 1 kilobyte = 1024 bytes
define('COMPANY_LOGO_DIRECTORY', ROOT_PATH.'feedback/upload/'); // upload directory
define('COMPANY_LOGO_URL', SITE_URL.'feedback/upload/'); // default logo url
define('DEFAULT_COMPANY_LOGO', 'company.png'); // default logo image

// contact email form
define('MIN_FEEDBACK_LENGTH', 20); // min. text length
define('MAX_FEEDBACK_LENGTH', 1000); // max text length
define('MIN_FEEDBACK_WORDS', 3); // min number of words

// ------------------------------------------------------------
// 19. PREMIUM MEMBERSHIP
// ------------------------------------------------------------
define('ENABLE_PREMIUM_MEMBERSHIP', 1); // 1=yes 0=no
define('HIDE_PREMIUM_MEMBERSHIP_IN_ADMIN', 0); // 1=yes 0=no

// ------------------------------------------------------------
// 20. SCHEDULED MAINTENANCE
// ------------------------------------------------------------
/*
if set to 1, all pages with the following constant in their
header will be redirected to the page defined below.
*/
define('SCHEDULED_MAINTENANCE', 0); // 1=show 0=hide
define('UNDER_CONSTRUCTION_PAGE', SITE_URL.'maintenance.html');

// ------------------------------------------------------------
// 21. SHOW / HIDE THE FOLLOWING MODULES
// ------------------------------------------------------------
define('SHOW_REGISTRATION', 1); // 1=yes 0=no
define('SHOW_PASSWORD_RESET', 0); // 1=yes 0=no
define('SHOW_LOST_USER_NAME', 0); // 1=yes 0=no
define('SHOW_RESEND_ACTIVATION', 0); // 1=yes 0=no

// ------------------------------------------------------------
// 22. SHOW / HIDE ADMIN STICKY BUTTON BAR
// ------------------------------------------------------------
define('SHOW_STICKY_BAR', 0); // 1=yes 0=no

// ------------------------------------------------------------
// 23. PROTECTED DOWNLOAD
// ------------------------------------------------------------
define('ENABLE_DOWNLOADS', 1);
define('DOWNLOAD_DIRECTORY',  ROOT_PATH.'download/'); // protected download directory
define('MAX_UPLOAD_FILE_SIZE', 20971520); // 20 Mb max. -> 1 megabyte = 1048576 bytes

// ------------------------------------------------------------
// 24. ACCOUNT SHARING
// ------------------------------------------------------------
/*
if set to 0, only the latest login per account is valid and 
all others will be logged off. If set to 1, each account 
can be used simultaneously by multiple users.
*/
define('ACCOUNT_SHARING', 1); // 1=allowed 0=not allowed