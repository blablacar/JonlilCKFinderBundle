<?php
/*
 * ### CKFinder : Configuration File - Basic Instructions
 *
 * In a generic usage case, the following tasks must be done to configure
 * CKFinder:
 *     1. Check the $baseUrl and $baseDir variables;
 *     2. If available, paste your license key in the "LicenseKey" setting;
 *     3. Create the CheckAuthentication() function that enables CKFinder for authenticated users;
 *
 * Other settings may be left with their default values, or used to control
 * advanced features of CKFinder.
 */

/**
 * This function must check the user session to be sure that he/she is
 * authorized to upload and access files in the File Browser.
 *
 * @todo solve authentication
 * @return boolean
 */
 
//custom CheckAuthentication function
if(defined('CKFINDER_CONNECTOR_CUSTOM_AUTHENTICATION')) 
{
	require_once CKFINDER_CONNECTOR_CUSTOM_AUTHENTICATION;
}

if (!function_exists('CheckAuthentication')) 
{
        
    function CheckAuthentication()
    {
        // WARNING : DO NOT simply return "true". By doing so, you are allowing
        // "anyone" to upload and list the files in your server. You must implement
        // some kind of session validation here. Even something very simple as...
    
        // return isset($_SESSION['IsAuthorized']) && $_SESSION['IsAuthorized'];
    
        // ... where $_SESSION['IsAuthorized'] is set to "true" as soon as the
        // user logs in your system. To be able to use session variables don't
        // forget to add session_start() at the top of this file.
    
        return true;
    }

}


include_once __DIR__ . "/../../../ckfinder/plugins/imageresize/plugin.php";
include_once __DIR__ . "/../../../ckfinder/plugins/fileeditor/plugin.php";
include_once __DIR__ . "/../../../ckfinder/plugins/zip/plugin.php";
