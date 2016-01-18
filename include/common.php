<?php
/**
 * ****************************************************************************
 *  - TDMSpot By TDM   - TEAM DEV MODULE FOR XOOPS
 *  - Licence PRO Copyright (c)  (http://www.)
 *
 * Cette licence, contient des limitations
 *
 * 1. Vous devez posséder une permission d'exécuter le logiciel, pour n'importe quel usage.
 * 2. Vous ne devez pas l' étudier ni l'adapter à vos besoins,
 * 3. Vous ne devez le redistribuer ni en faire des copies,
 * 4. Vous n'avez pas la liberté de l'améliorer ni de rendre publiques les modifications
 *
 * @license     TDMFR GNU public license
 * @author		TDMFR ; TEAM DEV MODULE 
 *
 * ****************************************************************************
 */
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

define("TDMMP_DIRNAME", basename(dirname(dirname(__FILE__))));
define("TDMMP_URL", XOOPS_URL . '/modules/' . TDMMP_DIRNAME);
define("TDMMP_IMAGES_URL", TDMMP_URL . '/images');
define("TDMMP_UPLOAD_URL", TDMMP_URL . '/upload');
define("TDMMP_ROOT_PATH", XOOPS_ROOT_PATH . '/modules/' . TDMMP_DIRNAME);
define("TDMMP_UPLOAD_PATH", XOOPS_ROOT_PATH . '/modules/' . TDMMP_DIRNAME.'/upload');

include_once TDMMP_ROOT_PATH . '/include/functions.php';

?>
