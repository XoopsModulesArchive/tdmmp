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
include '../../../include/cp_header.php'; 
include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
include_once(XOOPS_ROOT_PATH."/class/tree.php");
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar("dirname").'/include/common.php';

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'list';

 switch($op) {
  

	 case "contact":
  global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsModule;
  
  $error = $xoopsDB->queryF("INSERT INTO ".$xoopsDB->prefix('tdmmp_contact')." 
  (id, userid, contact, name, uname, regdate) 
	SELECT 
	  '', ct_userid, ct_contact, ct_name , ct_uname , ct_regdate 
	FROM ".$xoopsDB->prefix("priv_msgscont"));
	  
if ($error) {
 redirect_header('import.php', 2, _PM_AM_BASE);
} else {  
redirect_header('import.php', 2, _PM_AM_BASEERROR);
}

 	break;
	
 case "list": 
  default:
   xoops_cp_header();
if ( !is_readable(XOOPS_ROOT_PATH . "/Frameworks/art/functions.admin.php"))	{
TDMSound_adminmenu(20, _PM_AM_MANAGE_IMPORT);
} else {
include_once XOOPS_ROOT_PATH.'/Frameworks/art/functions.admin.php';
loadModuleAdminMenu (20, _PM_AM_MANAGE_IMPORT);
}

//menu
echo '<div class="CPbigTitle" style="background-image: url(../images/decos/import.png); background-repeat: no-repeat; background-position: left; padding-left: 60px; padding-top:20px; padding-bottom:15px;"><h3><strong>'._PM_AM_MANAGE_IMPORT.'</strong></h3>';
echo '</div><br />';

	
$sq1 = "SHOW TABLE STATUS FROM `".XOOPS_DB_NAME."` LIKE '".$xoopsDB->prefix("priv_msgscont")."'";
$result1=$xoopsDB->queryF($sq1); 
$contact=$xoopsDB->fetchArray($result1);
 
 echo '<fieldset><legend class="CPmediumTitle">priv_msgscont</legend>

		<br/>';
		if ($contact > 0) {
		echo '<b><span style="color: green; padding-left: 20px;"><img src="./../images/on.gif" > ' .$contact['Name']. ' : '.tdmmp_PrettySize($contact['Data_length'] + $contact['Index_length']) . '  | <b><a href="import.php?op=contact">'._PM_AM_IMPORT.'</a></b>';
		} else {
		echo '<b><span style="color: red; padding-left: 20px;"><img src="./../images/off.gif"> '. _PM_AM_IMPORT_NONE .'</a></span></b>';
		}
		echo '<br /><br />
	</fieldset><br />'; 
	
	
//$sq1 = "SHOW TABLE STATUS FROM `".XOOPS_DB_NAME."` LIKE '".$xoopsDB->prefix("wfs_article")."'";
//$result1=$xoopsDB->queryF($sq1); 
//$wf=$xoopsDB->fetchArray($result1);
 
// echo '<fieldset><legend class="CPmediumTitle">'._AM_SPOT_IMPORT_WFSECTION.'</legend>
//		<br/>';
//		if ($wf > 0) {
//		echo '<b><span style="color: green; padding-left: 20px;"><img src="./../images/on.gif" > ' .  tdmspot_PrettySize($wf['Data_length'] + $wf['Index_length']) . '</span></b> | <b><a href="index.php?op=wfsection">'._AM_SPOT_IMPORT.'</a></b>';
//		} else {
//		echo '<b><span style="color: red; padding-left: 20px;"><img src="./../images/off.gif"> '. _AM_SPOT_IMPORT_NONE .'</a></span></b>';
//		}
//		echo '<br /><br />
//	</fieldset><br />'; 
	
//$sq1 = "SHOW TABLE STATUS FROM `".XOOPS_DB_NAME."` LIKE '".$xoopsDB->prefix("xfs_article")."'";
//$result1=$xoopsDB->queryF($sq1); 
//$xf=$xoopsDB->fetchArray($result1);
 
// echo '<fieldset><legend class="CPmediumTitle">'._AM_SPOT_IMPORT_XFSECTION.'</legend>
//		<br/>';
//		if ($xf > 0) {
//		echo '<b><span style="color: green; padding-left: 20px;"><img src="./../images/on.gif" > ' .  tdmspot_PrettySize($xf['Data_length'] + $xf['Index_length']) . '</span></b> | <b><a href="index.php?op=xfsection">'._AM_SPOT_IMPORT.'</a></b>';
//		} else {
//		echo '<b><span style="color: red; padding-left: 20px;"><img src="./../images/off.gif"> '. _AM_SPOT_IMPORT_NONE .'</a></span></b>';
//		}
//		echo '<br /><br />
//	</fieldset><br />'; 
	
  break;
  }
 xoops_cp_footer(); 
?>
