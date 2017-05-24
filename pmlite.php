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

if (!defined('XOOPS_MAINFILE_INCLUDED')) {
    include_once "../../mainfile.php";
} else {
    chdir( XOOPS_ROOT_PATH . '/modules/TDMMp/' );
    xoops_loadLanguage('main', 'TDMMp');
}

$reply      = !empty($_GET['reply']) ? 1 : 0;
$send       = !empty($_GET['send']) ? 1 : 0;
$send2      = !empty($_GET['send2']) ? 1 : 0;
$sendmod    = !empty($_POST['sendmod']) ? 1 : 0; // send from other modules with post data
$to_userid  = isset($_GET['to_userid']) ? intval($_GET['to_userid']) : 0;
$msg_id     = isset($_GET['msg_id']) ? intval($_GET['msg_id']) : 0;

if ( empty($_GET['refresh']) && isset($_POST['op']) && $_POST['op'] != "submit" ) {
    $jump = "pmlite.php?refresh=" . time();
    if ( $send == 1 ) {
        $jump .= "&amp;send={$send}";
    } elseif ( $send2 == 1 ) {
        $jump .= "&amp;send2={$send2}&amp;to_userid={$to_userid}";
    } elseif ( $reply == 1 ) {
        $jump .= "&amp;reply={$reply}&amp;msg_id={$msg_id}";
    } else {
    }
    header('location: ' . $jump);
    exit();
}

if (!is_object($xoopsUser)) {
    redirect_header(XOOPS_URL, 3, _NOPERM);
    exit();
}

xoops_header();

$myts = MyTextSanitizer::getInstance();

$pm_handler =& xoops_getModuleHandler('tdmmp_messages', 'TDMMp');

//compte les message et bloque l'acces
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('to_userid', $xoopsUser->getVar('uid')));
$total = $pm_handler->getCount($criteria);
if ($total > $xoopsModuleConfig['tdmmp_maxalert']) {
    echo "<br /><br /><div style='text-align:center;'><h4>" . _PM_ALERT_MSG . "</h4><br /><a href=\"javascript:window.opener.location='".XOOPS_URL."/viewpmsg.php';window.close();\">"._PM_CLICKHERE."</a><br /><br /><a href=\"javascript:window.close();\">"._PM_ORCLOSEWINDOW."</a></div>";
    exit();
}


if (isset($_POST['op']) && $_POST['op'] == "submit") {
    $member_handler =& xoops_gethandler('member');
    $count = $member_handler->getUserCount(new Criteria('uid', intval($_POST['to_userid'])));
    if ($count != 1) {
        echo "<br /><br /><div><h4>"._PM_USERNOEXIST."<br />";
        echo _PM_PLZTRYAGAIN."</h4><br />";
        echo "[ <a href='javascript:history.go(-1)'>"._PM_GOBACK."</a> ]</div>";
    } elseif ($GLOBALS['xoopsSecurity']->check()) {
        //$pm_handler =& xoops_getModuleHandler('message', 'pm');
		$pm_handler =& xoops_getModuleHandler('tdmmp_messages', 'TDMMp');
        $pm =& $pm_handler->create();
		
        $pm->setVar("msg_time", time());
        $pm->setVar("subject", $_POST['subject']);
        $pm->setVar("msg_text", $_POST['message']);
        $pm->setVar("to_userid", $_POST['to_userid']);
        $pm->setVar("from_userid", $xoopsUser->getVar("uid"));
		$pm->setVar("msg_image", $_REQUEST['icon']);
        if (isset($_REQUEST['savecopy']) && $_REQUEST['savecopy'] == 1) {
            //message envoyer
			$subject = $_POST['subject']." (".XoopsUser::getUnameFromId($_POST['to_userid']).")";
			$pm->setVar("subject", $subject);
			$pm->setVar("to_userid", $xoopsUser->getVar("uid"));
			$pm->setVar("from_userid", $xoopsUser->getVar("uid"));
            $pm->setVar('msg_folder', 5);
			$pm_handler->insert($pm);
        }
		//brouillon
		 if (isset($_REQUEST['savedraft']) && $_REQUEST['savedraft'] == 1) {
            //PMs are by default not saved in outbox
			$pm->setVar("to_userid", $xoopsUser->getVar("uid"));
			$pm->setVar("from_userid", $xoopsUser->getVar("uid"));
			$pm->setVar("subject", $_POST['subject']);
            $pm->setVar('msg_folder', 4);
			$pm_handler->insert($pm);
        }
		 
		$pm->setVar("to_userid", $_POST['to_userid']);
        $pm->setVar("from_userid", $xoopsUser->getVar("uid"));
		$pm->setVar("subject", $_POST['subject']);
		$pm->setVar('msg_folder', 3);
		
        if (!$pm_handler->insert($pm)) {
            echo $pm->getHtmlErrors();
            echo "<br /><a href='javascript:history.go(-1)'>"._PM_GOBACK."</a>";
        } else {
            // @todo: Send notification email if user has selected this in the profile
            
            echo "<br /><br /><div style='text-align:center;'><h4>" . _PM_MESSAGEPOSTED . "</h4><br /><a href=\"javascript:window.opener.location='".XOOPS_URL."/viewpmsg.php';window.close();\">"._PM_CLICKHERE."</a><br /><br /><a href=\"javascript:window.close();\">"._PM_ORCLOSEWINDOW."</a></div>";
        }
		
		}
   
    else {
        echo implode('<br />', $GLOBALS['xoopsSecurity']->getErrors());
        echo "<br /><a href=\"javascript:window.close();\">"._PM_ORCLOSEWINDOW."</a>";
    }
        
} elseif ($reply == 1 || $send == 1 || $send2 == 1 || $sendmod =1) {
    if ($reply == 1) {
        //$pm_handler =& xoops_getModuleHandler('message', 'pm');
        $pm_handler =& xoops_getModuleHandler('tdmmp_messages', 'TDMMp');
		$pm =& $pm_handler->get($msg_id);
        if ($pm->getVar("to_userid") == $xoopsUser->getVar('uid')) {
            $pm_uname = XoopsUser::getUnameFromId($pm->getVar("from_userid"));
            $message  = "[quote]\n";
            $message .= sprintf(_PM_USERWROTE , $pm_uname);
            $message .= "\n" . $pm->getVar("msg_text", "E") . "\n[/quote]";
        } else {
            unset($pm);
            $reply = $send2 = 0;
        }
    }
    
	include_once XOOPS_ROOT_PATH . "/class/template.php";
	$xoopsTpl = new XoopsTpl();
    include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
    $pmform = new XoopsForm('', 'pmform', 'pmlite.php', 'post', true);
    
    if ($reply == 1) {
        $subject = $pm->getVar('subject', 'E');
        if (!preg_match("/^Re:/i", $subject)) {
            $subject = 'Re: ' . $subject;
        }
        $xoopsTpl->assign('to_username', $pm_uname);
        $pmform->addElement(new XoopsFormHidden('to_userid', $pm->getVar("from_userid")));
    } elseif ($sendmod == 1) {
        $xoopsTpl->assign('to_username', XoopsUser::getUnameFromId($_POST["to_userid"]));
        $pmform->addElement(new XoopsFormHidden('to_userid', $_POST["to_userid"]));
		$subject = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['subject']));
		$message = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['message']));
    } else {
        if ($send2 == 1) {
          $xoopsTpl->assign('to_username', XoopsUser::getUnameFromId($to_userid, false));
          $pmform->addElement(new XoopsFormHidden('to_userid', $to_userid));
	   } else {
            $to_username = new XoopsFormSelectUser('', 'to_userid');
            $xoopsTpl->assign('to_username', $to_username->render());
        }
        $subject = "";
        $message = "";
    }
    $pmform->addElement(new XoopsFormText('', 'subject', 30, 100, $subject), true);
    $icons_radio = new XoopsFormRadio(_PM_ICONC, 'icon');
	$subject_icons = XoopsLists::getSubjectsList();
	foreach ($subject_icons as $iconfile) {
	$icons_radio->addOption($iconfile, '<img src="'.XOOPS_URL.'/images/subject/'.$iconfile.'" alt="" />');
	}
	$pmform->addElement($icons_radio); 
	$pmform->addElement(new XoopsFormDhtmlTextArea('', 'message', $message, 8, 37), true);
    $pmform->addElement(new XoopsFormRadioYN('', 'savecopy', 0));
    $pmform->addElement(new XoopsFormRadioYN('', 'savedraft', 0));
	
    $pmform->addElement(new XoopsFormHidden('op', 'submit'));
    $pmform->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    $pmform->addElement(new XoopsFormButton('', 'reset', _PM_CLEAR, 'reset'));
    
    $cancel_send = new XoopsFormButton('', 'cancel', _PM_CANCELSEND, 'button');
    $cancel_send->setExtra("onclick='javascript:window.close();'");
    $pmform->addElement($cancel_send);
    $pmform->assign($xoopsTpl);
    $xoopsTpl->display("db:tdmmp_pmlite.html");
}

xoops_footer();
?>