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
TDMSound_adminmenu(1, _PM_AM_PRUNE);
} else {
include_once XOOPS_ROOT_PATH.'/Frameworks/art/functions.admin.php';
loadModuleAdminMenu (1,_PM_AM_PRUNE);
}


$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : "form";
//load class
$pm_handler =& xoops_getModuleHandler('tdmmp_messages', 'TDMMp');
$folder_handler =& xoops_getModuleHandler('tdmmp_folder', 'TDMMp');

//menu
echo '<div class="CPbigTitle" style="background-image: url(../images/decos/prune.png); background-repeat: no-repeat; background-position: left; padding-left: 60px; padding-top:20px; padding-bottom:15px;">
<h3><strong>'._PM_AM_MANAGE_MP.'</strong></h3>';
echo '</div><br />';

switch ($op) {
default:
case "form":
    $form = $pm_handler->getPruneForm();
    $form->display();
    break;
    
case "prune":
    $criteria = new CriteriaCompo();
    if ($_REQUEST['after']['date'] && $_REQUEST['after']['date'] != "YYYY/MM/DD") {
        $criteria->add(new Criteria('msg_time', strtotime($_REQUEST['after']['date']) + intval($_REQUEST['after']['time']), ">"));
    }
    if ($_REQUEST['before']['date'] && $_REQUEST['before']['date'] != "YYYY/MM/DD") {
        $criteria->add(new Criteria('msg_time', strtotime($_REQUEST['before']['date']) + intval($_REQUEST['before']['time']), "<"));
    }
    if (isset($_REQUEST['onlyread']) && $_REQUEST['onlyread'] == 1) {
        $criteria->add(new Criteria('read_msg', 1));
    }
    if ((!isset($_REQUEST['includesave']) || $_REQUEST['includesave'] == 0)) {
        $criteria->add(new Criteria('msg_folder', 7, '<'));
    }
    if (isset($_REQUEST['notifyusers']) && $_REQUEST['notifyusers'] == 1) {
        $notifycriteria = $criteria;
        $notifycriteria->add(new Criteria('to_delete', 0));
        $notifycriteria->setGroupBy('to_userid');
        // Get array of uid => number of deleted messages
        $uids = $pm_handler->getCount($notifycriteria);
    }
    $deletedrows = $pm_handler->deleteAll($criteria);
    if ($deletedrows === false) {
        redirect_header('prune.php', 2, _PM_AM_ERRORWHILEPRUNING);
    }
    if (isset($_REQUEST['notifyusers']) && $_REQUEST['notifyusers'] == 1) {
        $errors = false;
        foreach ($uids as $uid => $messagecount) {
            $pm = $pm_handler->create();
            $pm->setVar("subject", $xoopsModuleConfig['prunesubject']);
            $pm->setVar("msg_text", str_replace('{PM_COUNT}', $messagecount, $xoopsModuleConfig['prunemessage']));
            $pm->setVar("to_userid", $uid);
            $pm->setVar("from_userid", $xoopsUser->getVar("uid"));
            $pm->setVar("msg_time", time());
            if (!$pm_handler->insert($pm)) {
                $errors = true;
                $errormsg[] = $pm->getHtmlErrors();
            }
            unset($pm);
        }
        if ($errors == true) {
            echo implode('<br />', $errormsg);
            xoops_cp_footer();
            exit();
        }
    }
    redirect_header('prune.php', 2, sprintf(_PM_AM_MESSAGESPRUNED, $deletedrows));
    break;
}
xoops_cp_footer();
?>