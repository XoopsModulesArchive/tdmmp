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

xoops_cp_header();
//apelle du menu admin
if ( !is_readable(XOOPS_ROOT_PATH . "/Frameworks/art/functions.admin.php"))	{
TDMSound_adminmenu(2, _PM_AM_FOLDER);
} else {
include_once XOOPS_ROOT_PATH.'/Frameworks/art/functions.admin.php';
loadModuleAdminMenu (2, _PM_AM_FOLDER);
}

//load class
$pm_handler =& xoops_getModuleHandler('tdmmp_messages', 'TDMMp');
$folder_handler =& xoops_getModuleHandler('tdmmp_folder', 'TDMMp');


$myts = MyTextSanitizer::getInstance();
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'list';
$ver = isset($_REQUEST['ver']) ? $_REQUEST['ver'] : 1;

//menu
echo '<div class="CPbigTitle" style="background-image: url(../images/decos/folder.png); background-repeat: no-repeat; background-position: left; padding-left: 60px; padding-top:20px; padding-bottom:15px;">
<h3><strong>'._PM_AM_MANAGE_FOLDER.'</strong></h3>';
echo '</div><br /><div class="head" align="center">';
echo !isset($ver) ||  $ver == 1 ? '<a href="folder.php?op=list&ver=0">'._PM_AM_MANAGE_FOLDER_USER.'</a>' : '<a href="folder.php?op=list&ver=1">'._PM_AM_MANAGE_FOLDER.'</a>';
echo '</div><br>';

 switch($op) {
  
    //sauv  
 case "save":
 
		if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('folder.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if (isset($_REQUEST['cid'])) {
        $obj =& $folder_handler->get($_REQUEST['cid']);
		} else {
        $obj =& $folder_handler->create();
		} 

		//$obj->setVar('pid', $_REQUEST['pid']);
		$obj->setVar('title', $_REQUEST['title']);
		
		if ($folder_handler->insert($obj)) {
        redirect_header('folder.php', 2, _PM_AM_BASE);
		}
		//include_once('../include/forms.php');
		echo $obj->getHtmlErrors();
		$form =& $obj->getForm();
		$form->display();
    break;
	
	
	 case "edit": 
    $obj = $folder_handler->get($_REQUEST['cid']);
    $form = $obj->getForm();
    $form->display();
    break;

    break;
	
 case "delete":
	$obj =& $folder_handler->get($_REQUEST['cid']);
	
    if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('folder.php', 2, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
	//supprimer le dossier et c'est messages
	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('msg_folder', $_REQUEST['cid']));
	$pm_arr = $pm_handler->getall($criteria);
			foreach (array_keys($pm_arr) as $a) {
				$remove_pm =& $pm_handler->get($pm_arr[$a]->getVar('msg_id'));
				$pm_handler->delete($remove_pm);
			}
	//supprimer le dossier
     if ($folder_handler->delete($obj)) {
        redirect_header('folder.php', 2, _PM_AM_BASE);
       } else {
           echo $obj->getHtmlErrors();
        }
    } else {
        xoops_confirm(array('ok' => 1, 'cid' => $_REQUEST['cid'], 'op' => 'delete'), $_SERVER['REQUEST_URI'], sprintf(_PM_AM_FORMSUREDEL, $obj->getVar('title')));
    }
    break;
	
 case "list": 
  default:	
	//Parameters	
	$criteria = new CriteriaCompo();
	$limit = 10;
	
	if (isset($_REQUEST['start'])) {
	$criteria->setStart($_REQUEST['start']);
	$start = $_REQUEST['start'];
	} else {
	$criteria->setStart(0);
	$start = 0;
	}
	
	$criteria->add(new Criteria('ver', $ver));
	$criteria->setLimit($limit);
	$criteria->setOrder('ASC');
	$folder_arr = $folder_handler->getAll($criteria);
	$numrows = $folder_handler->getCount($criteria);

	//nav
	if ( $numrows > $limit ) {
	$pagenav = new XoopsPageNav($numrows, $limit, $start, 'start', 'op=list');
	$pagenav = $pagenav->renderNav(2);
	} else {
	$pagenav = '';
	}
		//Affichage du tableau des catégories
		if ($numrows>0) {
			
			echo '<table width="100%" cellspacing="1" class="outer">';
			echo '<tr>';
			echo '<th align="center" width="10%">CID</th>';
			echo '<th align="center" width="35%">PID</th>';
			echo '<th align="center" width="35%">'._PM_AM_TITLE.'</th>';
			echo '<th align="center" width="10%">NB</th>';
			echo '<th align="center" width="10%">'._PM_AM_ACTION.'</th>';
			echo '</tr>';
			$class = 'odd';
		    foreach (array_keys($folder_arr) as $i) {
			
	//compte les messages
	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('msg_folder', $folder_arr[$i]->getVar('cid')));
    $num_rows = $pm_handler->getCount($criteria);
	
			$class = ($class == 'even') ? 'odd' : 'even';
			$folder_cid = $folder_arr[$i]->getVar('cid');
			$folder_pid = $folder_arr[$i]->getVar('pid');
			$folder_title = $myts->displayTarea($folder_arr[$i]->getVar('title'));
			
			//trouve le sous dossiers
			if ($obj = $folder_handler->get($folder_arr[$i]->getVar('pid'))){
			$obj_title = $myts->displayTarea($obj->getVar('title'));
			} else {
			$obj_title = false;
			}
			//$display = $folder_arr[$i]->getVar('folder_display') == 1 ? "<img src='./../images/on.gif' border='0'>" : "<a href='folderiste.php?op=update&folder_id=".$folder_id."'><img alt='"._AM_TDMSOUND_UPDATE."' title='"._AM_TDMSOUND_UPDATE."' src='./../images/off.gif' border='0'></a>";
	
			
 				echo '<tr class="'.$class.'">';
				echo '<td align="center" width="10%">'.$folder_cid.'</td>';
				echo '<td align="center" width="35%">'.$obj_title.'</td>';
				echo '<td align="center" width="35%">'.$folder_title.'</td>';
				echo '<td align="center" width="10%">'.$num_rows.'</td>';
				echo '<td align="center" width="10%">';
				echo '<a href="folder.php?op=edit&cid='.$folder_cid.'"><img src="./../images/edit_mini.gif" border="0" alt="'._PM_AM_EDIT.'" title="'._PM_AM_EDIT.'"></a>';
				if ($ver != 1) {
				echo '<a href="folder.php?op=delete&cid='.$folder_cid.'"><img src="./../images/delete_mini.gif" border="0" alt="'._PM_AM_DEL.'" title="'._PM_AM_DEL.'"></a>';
				}
				echo '</td>';
				echo '</tr>';
			 }
			 echo '</table><br /><br />';
			 echo '<div align=right>'.$pagenav.'</div><br />';
		}
		// Affichage du formulaire de cr?ation de cat?gories
    	//$obj =& $folder_handler->create();
    	//$form = $obj->getForm();
    	//$form->display();
    break;
	
  }
xoops_cp_footer();
?>