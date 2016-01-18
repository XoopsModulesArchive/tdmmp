<?php
/**
 * ****************************************************************************
 *  - TDMMp By TDM   - TEAM DEV MODULE FOR XOOPS
 *  - Licence PRO Copyright (c)  (http://www.tdmxoops.net)
 *
 * Cette licence, contient des limitations!!!
 *
 * 1. Vous devez posséder une permission d'exécuter le logiciel, pour n'importe quel usage.
 * 2. Vous ne devez pas l' étudier,
 * 3. Vous ne devez pas le redistribuer ni en faire des copies,
 * 4. Vous n'avez pas la liberté de l'améliorer et de rendre publiques les modifications
 *
 * @license     TDMFR PRO license
 * @author		TDMFR ; TEAM DEV MODULE 
 *
 * ****************************************************************************
 */

include '../../../include/cp_header.php'; 
include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
include_once(XOOPS_ROOT_PATH."/class/tree.php");
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
include_once("../include/functions.php");
include_once("../include/common.php");

xoops_cp_header();
if (isset($_REQUEST['op'])) {
	$op = $_REQUEST['op'];
} else {
	@$op = 'default';
}

//apelle du menu admin
if ( !is_readable(XOOPS_ROOT_PATH . "/Frameworks/art/functions.admin.php"))	{
TDMSound_adminmenu(0, _PM_AM_INDEX);
} else {
include_once XOOPS_ROOT_PATH.'/Frameworks/art/functions.admin.php';
loadModuleAdminMenu (0, _PM_AM_INDEX);
}

//load class
$pm_handler =& xoops_getModuleHandler('tdmmp_messages', 'TDMMp');
$folder_handler =& xoops_getModuleHandler('tdmmp_folder', 'TDMMp');
$member_handler =& xoops_gethandler('member');
//compte les messages
$numpm = $pm_handler->getCount();
//compte les dossiers
$numfolder = $folder_handler->getCount();
//info dossier
$sq2 = "SHOW TABLE STATUS FROM `".XOOPS_DB_NAME."` LIKE '".$xoopsDB->prefix("priv_msgscat")."'";
$result2=$xoopsDB->queryF($sq2); 
$myrow=$xoopsDB->fetchArray($result2);
//compte les dossiers utilisateur
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('ver', 1, '!='));
$folder_waiting = $folder_handler->getCount($criteria);
unset($criteria);
//compte les notification utilisateur
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('notify_method', 1));
$numnotif = $member_handler->getUserCount($criteria);
unset($criteria);
//$stop = strtotime("+30 days", "1255338748");     
//echo tdmmp_mathtemps('1255338748', $stop, 2);

//prepare la comparaison des fichiers
  $i=0;
	$tdmmp_files[$i]['path'] =  TDMMP_ROOT_PATH.'/root/pmlite.php';
    $tdmmp_files[$i]['dest'] = XOOPS_ROOT_PATH.'/pmlite.php';
    $i++;
 	$tdmmp_files[$i]['path'] =  TDMMP_ROOT_PATH.'/root/readpmsg.php';
    $tdmmp_files[$i]['dest'] = XOOPS_ROOT_PATH.'/readpmsg.php';
    $i++;
	$tdmmp_files[$i]['path'] =  TDMMP_ROOT_PATH.'/root/viewpmsg.php';
    $tdmmp_files[$i]['dest'] = XOOPS_ROOT_PATH.'/viewpmsg.php';
    $i++;
	$tdmmp_files[$i]['path'] =  TDMMP_ROOT_PATH.'/root/class/smarty/xoops_plugins/function.xoInboxCount.php';
    $tdmmp_files[$i]['dest'] = XOOPS_ROOT_PATH.'/class/smarty/xoops_plugins/function.xoInboxCount.php';
    $i++;
	

 if($op == "optimise"){
 $sq1 = "OPTIMIZE TABLE ".$xoopsDB->prefix("priv_msgs");
 $result1 = $xoopsDB->queryF($sq1);
 if($result1){
 redirect_header( 'index.php', 1, _PM_AM_BASE);
 } }
 
  if($op == "integ"){
  
  foreach ($tdmmp_files as $file) {
$result .= tdmmp_copyFile($file['path'],$file['dest']);
}
 if($result){
 redirect_header( 'index.php', 1, _PM_AM_BASE);
 } 
 
 }

if (phpversion() >= 5){
include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/class/menu.php';

				//showIndex();
				$menu = new TDMMpMenu();
				$menu->addItem('prune', 'prune.php', '../images/decos/prune.png', _PM_AM_MANAGE_MP);
				$menu->addItem('file', 'folder.php', '../images/decos/folder.png',  _PM_AM_MANAGE_FOLDER);
				$menu->addItem('notif', 'notification.php', '../images/decos/notif.png',  _PM_AM_MANAGE_NOTIF);
				$menu->addItem('about', 'about.php', '../images/decos/about.png',  _PM_AM_NAVABOUT);
				$menu->addItem('update', '../../system/admin.php?fct=modulesadmin&op=update&module='.$xoopsModule ->getVar('name')
												, '../images/decos/update.png',  _PM_AM_NAVUPDATE);	
				//$menu->addItem('permissions', 'permissions.php', '../images/decos/permissions.png', _AM_TDMSOUND_NAVPERMISSIONS);
				$menu->addItem('import', 'import.php', '../images/decos/import.png', _PM_AM_MANAGE_IMPORT);
				$menu->addItem('optimise', 'index.php?op=optimise', '../images/decos/optimise.png', _PM_AM_OPTIMISE);
				$menu->addItem('integration', 'index.php?op=integ', '../images/decos/optimie.png', _PM_AM_FILE);
				$menu->addItem('Preference', '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod='.$xoopsModule ->getVar('mid').
												'&amp;&confcat_id=1', '../images/decos/pref.png',  _PM_AM_NAVPREFERENCES);	
				
	echo $menu->getCSS();
}	


echo '<div class="CPbigTitle" style="background-image: url(../images/decos/index.png); background-repeat: no-repeat; background-position: left; padding-left: 60px; padding-top:20px; padding-bottom:15px;">
		<h3><strong>'._PM_AM_INDEXDESC.'</strong></h3>
	</div><br /><table width="100%" border="0" cellspacing="10" cellpadding="4">
  <tr>
  <td valign="top">';
  
  if (phpversion() >= 5){
 echo $menu->render();
  }else{
    echo '<table width="100%" border="0" cellspacing="10" cellpadding="4">';
    echo '<tr><td><div class="errorMsg" style="text-align: left;">' . _PM_AM_ERREURPHP . '</div></td>';
}

  echo '</td>
  <td valign="top" width="60%">
 <fieldset><legend class="CPmediumTitle">'._PM_AM_MANAGE_MP.'</legend>
		<br/>';
		printf(_PM_AM_THEREARE_MP,$numpm);
		echo '<br/>';
		echo '<br />';
		foreach($pm_handler->getInfo() as $cle=>$valeur) 
		{ 
		echo $cle.' :<b> '.$valeur.'</b><br>'; 
		} 
echo '</fieldset><br /><br />
	
	 <fieldset><legend class="CPmediumTitle">'._PM_AM_MANAGE_FOLDER.'</legend>
		<br/>';
		printf(_PM_AM_THEREARE_FOLDER,$numfolder);
		echo '<br/><br/>';
		printf(_PM_AM_THEREARE_FOLDER_WAITING,$folder_waiting);
		echo '<br/>
	</fieldset><br /> <br />
	
	<fieldset><legend class="CPmediumTitle">'._PM_AM_MANAGE_NOTIF.'</legend>
		<br/>';
		printf(_PM_AM_THEREARE_NOTIF,$numnotif);
		echo '<br/>
	</fieldset><br /> <br />';
	
	echo '<fieldset><legend class="CPmediumTitle">'._PM_AM_MANAGE_INSTALL.'</legend>
		<br/>';	
		echo _PM_AM_INSTALL_HELP;
			echo '<br/><br/>';
		
		
foreach ($tdmmp_files as $file) {
echo tdmmp_compareFile($file['path'],$file['dest']) == true ? "<img src='".TDMMP_IMAGES_URL."/on.gif' border='0'> ".$file['path'] : "
<img src='".TDMMP_IMAGES_URL."/off.gif' border='0'>"._PM_AM_INSTALL_COPY.$file['path']."  "._PM_AM_INSTALL_IN.$file['dest'];
echo '<br/><br/>';
}

		echo '<br/>
	</fieldset><br /> <br />';

	echo '</td></tr></table>';
xoops_cp_footer();
?>