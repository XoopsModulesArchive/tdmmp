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
 
require('../../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');


 if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}


$myts = MyTextSanitizer::getInstance();

global $xoopsDB, $xoopsTpl, $xoopsModule, $xoopsModuleConfig, $xoopsUser;

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'list';

//load class
$pm_handler =& xoops_getModuleHandler('tdmmp_messages', 'TDMMp');
$folder_handler =& xoops_getModuleHandler('tdmmp_folder', 'TDMMp');
$contact_handler =& xoops_getModuleHandler('tdmmp_contact', 'TDMMp');
$gperm_handler =& xoops_gethandler('groupperm');

$module_handler =& xoops_gethandler('module');
$xoopsModule =& $module_handler->getByDirname('TDMMp');

if(!isset($xoopsModuleConfig)){
	$config_handler = &xoops_gethandler('config');
	$xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
    }	

include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar("dirname").'/include/common.php';
include_once(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/include/functions.php');
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/language/".$xoopsConfig['language']."/main.php");

$mydirname = basename( dirname( __FILE__ ) ) ;
require(XOOPS_ROOT_PATH.'/header.php');
header('Content-Type:text/html; charset=' . _CHARSET);

$xoopsTpl->assign('dirname', $mydirname);


//perm
if (is_object($xoopsUser)) {
    $groups = $xoopsUser->getGroups();
	$xd_uid = $xoopsUser->getVar('uid');
} else {
	$groups = XOOPS_GROUP_ANONYMOUS;
	$xd_uid = 0;
}


 switch($op) {
 
 	case "folder": 	
//interdit au non membre	
if (empty($xoopsUser)) {
echo "<a href='".XOOPS_URL."/user.php'>"._MD_TDMSOUND_QUERYNOREGISTER."</a>";
exit();
}

$_REQUEST['dir'] = $_REQUEST['dir'];

	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('ver', 1));
	$criteria->add(new Criteria('uid', $xoopsUser->getVar('uid')), 'OR');
	$folder_arr = $folder_handler->getObjects($criteria);	

	echo '<ul class="jqueryFileTree" style="display: none;">';

	foreach (array_keys($folder_arr) as $i) {
	
	if ($_REQUEST['dir'] == '/0/' && '/'.$folder_arr[$i]->getVar('pid').'/' == '/0/') {

	if($folder_arr[$i]->getVar('cid') == "9")
	{
	echo ' <li class="file ext_user" style="list-style-type: none;"><a href="javascript:;" onclick="AddFolder('.$folder_arr[$i]->getVar('cid').', 0);return false;"  rel="/'.$folder_arr[$i]->getVar('cid').'/">'.$folder_arr[$i]->getVar('title').'</a></li>';
	} else {
	echo ' <li class="directory collapsed" style="list-style-type: none;"><a href="javascript:;" onclick="AddFolder('.$folder_arr[$i]->getVar('cid').', 0);return false;"  rel="/'.$folder_arr[$i]->getVar('cid').'/">'.$folder_arr[$i]->getVar('title').'</a></li>';
	}
	} else {

	
	if ( '/'.$folder_arr[$i]->getVar('pid').'/' == $_REQUEST['dir']) {
	

	switch($folder_arr[$i]->getVar('cid')) {
	  case "3":
	  $stylefolder = 'file ext_received'; 
	  break;
	  
	  case "4":
	  $stylefolder = 'file ext_draft'; 
	  break;
	  
	  case "5":
	  $stylefolder = 'file ext_send'; 
	  break;
	  
	  case "6":
	  $stylefolder = 'file ext_del'; 
	  break;
	  
	  case "7":
	  $stylefolder = 'file ext_work'; 
	  break;
	  
	  case "8":
	  $stylefolder = 'file ext_funy'; 
	  break;
	  
	  case "9":
	  $stylefolder = 'file ext_user'; 
	  break;
	  
	  default:
	  $stylefolder = 'file ext_perso'; 
	  break;
	  

	}
	
	
	echo '<li class="'.$stylefolder.'" style="list-style-type: none;"><a href="javascript:;" onclick="AddFolder('.$folder_arr[$i]->getVar('cid').', 0);return false;" rel="'.$folder_arr[$i]->getVar('cid').'">'.$folder_arr[$i]->getVar('title').'</a></li>';
	}	
	
	}
	}

	echo '</ul>';

	 break;
	 
	case "removemsg": 
	
	$msg_id = empty($_REQUEST["msg_id"]) ? false : intval($_REQUEST["msg_id"]);
	$cid = empty($_REQUEST["cid"]) ? false : intval($_REQUEST["cid"]);
//interdit au non membre	


if (empty($xoopsUser)) {
echo _PM_ACTION_ERROR;
exit();
}

if (empty($msg_id)) {
echo _PM_ACTION_ERROR;
exit();
}

if (empty($cid)) {
echo _PM_ACTION_ERROR;
exit();
}

switch ($cid) {

default:

if ($msg_id > 0) {
	$pm =& $pm_handler->get($msg_id);
} else {
	$pm = null;
}

if ($pm->getVar('msg_folder') != 6) {
$pm->setVar("msg_folder", 6);
$erreur = $pm_handler->insert($pm);
} else {
$erreur = $pm_handler->delete($pm);
}

break;

case "9":

if ($msg_id > 0) {
	$pm =& $contact_handler->get($msg_id);
} else {
	$pm = null;
}

$erreur = $contact_handler->delete($pm);

break;

}


        //suppression
    if ($erreur){
    echo _PM_ACTION_DONE;
	exit();
    } else {
	 echo _PM_ACTION_ERROR;
	 exit();
	 }
	 
	 
	 break;
	 
	 
	case "addcontact": 
	
	$from_userid = empty($_REQUEST["from_userid"]) ? false : intval($_REQUEST["from_userid"]);
//interdit au non membre	
if (empty($xoopsUser)) {
echo "<a href='".XOOPS_URL."/user.php'>"._MD_TDMSOUND_QUERYNOREGISTER."</a>";
exit();
}

if (empty($from_userid)) {
echo _PM_USERNOEXIST;
exit();
}

if ($from_userid > 0) {
	$member_handler =& xoops_gethandler('member');
    $members =& $member_handler->getUser($from_userid);
    $pm =& $contact_handler->create();
    $pm->setVar("userid", $xoopsUser->getVar("uid")); 
    $pm->setVar("contact", $from_userid);
    $pm->setVar("name", $members->getVar("name"));
    $pm->setVar("uname", $members->getVar("uname"));
    $pm->setVar("regdate", $members->getVar("user_regdate"));
} else {
	$contact = null;
}

        //suppression
      if ($contact_handler->insert($pm)){
    echo _PM_ACTION_DONE;
	exit();
    } else {
	 echo _PM_ACTION_ERROR;
	 exit();
	 }
	 
	 
	 break;
	 
	case "viewcontact": 
	
	$contact = empty($_REQUEST["contact"]) ? false : intval($_REQUEST["contact"]);
//interdit au non membre	
if (empty($xoopsUser)) {
echo "<a href='".XOOPS_URL."/user.php'>"._MD_TDMSOUND_QUERYNOREGISTER."</a>";
exit();
}

if (empty($contact)) {
echo _PM_USERNOEXIST;
exit();
}

include_once(XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/user.php");
	//trouve l'id de l'utilisateur
	$pm =& $contact_handler->get($contact);
	
	$member_handler =& xoops_gethandler('member');
    $thisUser =& $member_handler->getUser($pm->getVar('contact'));
	$xoopsOption['xoops_pagetitle'] = sprintf(_US_ALLABOUT, $thisUser->getVar('uname'));
	$xoopsTpl->assign('lang_allaboutuser', sprintf(_US_ALLABOUT,$thisUser->getVar('uname')));
	//$xoopsTpl->assign('user_avatarurl', 'uploads/'.$thisUser->getVar('user_avatar'));
	$xoopsTpl->assign('user_uname', $thisUser->getVar('uname'));
	$xoopsTpl->assign('user_realname', $thisUser->getVar('name'));
	$xoopsTpl->assign('user_uid', $thisUser->getVar('uid'));
	if ($thisUser->getVar('user_avatar') != "blank.gif") {
	$xoopsTpl->assign('user_avatarurl', XOOPS_URL.'/uploads/'.$thisUser->getVar('user_avatar'));
	} else {
	$xoopsTpl->assign('user_avatarurl', TDMMP_IMAGES_URL.'/imguser.png');
	}
	
	if ( $thisUser->getVar('url', 'E') == '') {
    $xoopsTpl->assign('user_websiteurl', '');
} else {
    $xoopsTpl->assign('user_websiteurl', '<a href="'.$thisUser->getVar('url', 'E').'" rel="external">'.$thisUser->getVar('url').'</a>');
}
$xoopsTpl->assign('user_icq', $thisUser->getVar('user_icq'));
$xoopsTpl->assign('user_aim', $thisUser->getVar('user_aim'));
$xoopsTpl->assign('user_yim', $thisUser->getVar('user_yim'));
$xoopsTpl->assign('user_msnm', $thisUser->getVar('user_msnm'));
$xoopsTpl->assign('user_location', $thisUser->getVar('user_from'));
$xoopsTpl->assign('user_occupation', $thisUser->getVar('user_occ'));
$xoopsTpl->assign('user_interest', $thisUser->getVar('user_intrest'));
//extra
$var = $thisUser->getVar('bio', 'N');
$xoopsTpl->assign('user_extrainfo', $myts->displayTarea( $var,0,1,1) );
$var = $thisUser->getVar('user_regdate');
$xoopsTpl->assign('user_joindate', formatTimestamp( $var, 's' ) );
$xoopsTpl->assign('user_posts', $thisUser->getVar('posts'));
//signature
$xoopsTpl->assign('lang_signature', _US_SIGNATURE);
$var = $thisUser->getVar('user_sig', 'N');
$xoopsTpl->assign('user_signature', $myts->displayTarea( $var, 0, 1, 1 ) );
//email
if ($thisUser->getVar('user_viewemail') == 1) {
    $xoopsTpl->assign('user_email', $thisUser->getVar('email', 'E'));
} else {
    if (is_object($xoopsUser)) {
        // All admins will be allowed to see emails, even those that are not allowed to edit users (I think it's ok like this)
        if ($xoopsUserIsAdmin || ($xoopsUser->getVar("uid") == $thisUser->getVar("uid"))) {
            $xoopsTpl->assign('user_email', $thisUser->getVar('email', 'E'));
        } else {
            $xoopsTpl->assign('user_email', '&nbsp;');
        }
    }
}

$userrank = $thisUser->rank();
if ($userrank['image']) {
    $xoopsTpl->assign('user_rankimage', '<img src="'.XOOPS_UPLOAD_URL.'/'.$userrank['image'].'" alt="" />');
}
$xoopsTpl->assign('user_ranktitle', $userrank['title']);
$date = $thisUser->getVar("last_login");
if (!empty($date)) {
    $xoopsTpl->assign('user_lastlogin', formatTimestamp($date,"m"));
}

	$xoopsTpl->display('db:tdmmp_contactpmsg.html');
	 
	 
	 break;
	 
	case "clearmsg": 
	
	$cid = empty($_REQUEST["cid"]) ? false : intval($_REQUEST["cid"]);
	
	//interdit au non membre	
if (empty($xoopsUser)) {
echo _PM_ACTION_ERROR;
exit();
}

if (empty($cid)) {
echo _PM_ACTION_ERROR;
exit();
}


switch($cid) {

default:

	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('to_userid', $xoopsUser->getVar('uid')));
   	$criteria->add(new Criteria('msg_folder', $cid));
	$pm_arr = $pm_handler->getAll($criteria);
	$totals_messages = $pm_handler->getCount($criteria);
    $erreur ="";
	foreach (array_keys($pm_arr) as $i) {
	$pm =& $pm_handler->get($pm_arr[$i]->getVar('msg_id'));
	$erreur .= $pm_handler->delete($pm);
	}
	
break;

case "9":

	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('userid', $xoopsUser->getVar('uid')));
	$pm_arr = $contact_handler->getAll($criteria);
    $erreur ="";
	foreach (array_keys($pm_arr) as $i) {
	$pm =& $contact_handler->get($pm_arr[$i]->getVar('id'));
	$erreur .= $contact_handler->delete($pm);
	}

break;
}

        //suppression
     if ($erreur){
    echo _PM_DELETED;
	exit();
    } else {
	 echo _PM_ACTION_ERROR;
	 exit();
	 }
	 
	 break;
	 
//move msg
	case "movemsg": 
	
$msg_id = empty($_REQUEST["msg_id"]) ? 3 : intval($_REQUEST["msg_id"]);
$cid = empty($_REQUEST["cid"]) ? false : intval($_REQUEST["cid"]);

//interdit au non membre	
if (empty($xoopsUser)) {
echo _PM_ACTION_ERROR;
exit();
}

if (empty($cid)) {
echo _PM_ACTION_ERROR;
exit();
}

if ($msg_id > 0) {
	$pm =& $pm_handler->get($msg_id);
} else {
	$pm = null;
}
     //move
	$pm->setVar("msg_folder", $cid);
	
      if ($pm_handler->insert($pm)){
    echo _PM_SAVED_ALL;
	exit();
    } else {
	 echo _PM_UNSAVED;
	 exit();
	 }
 

	 break;
	 
//////////////////

//read msg
	case "readmsg": 
	
$msg_id = empty($_REQUEST["msg_id"]) ? 3 : intval($_REQUEST["msg_id"]);
$read = empty($_REQUEST["read"]) ? false : intval($_REQUEST["read"]);

//interdit au non membre	
if (empty($xoopsUser)) {
echo _PM_ACTION_ERROR;
exit();
}


if (!isset($read)) {
echo _PM_ACTION_ERROR;
exit();
}

if ($msg_id > 0) {
	$pm =& $pm_handler->get($msg_id);
} else {
	$pm = null;
}
     //read
	$pm->setVar("read_msg", $read);
	
      if ($pm_handler->insert($pm)){
    echo _PM_READ_ALL;
	exit();
    } else {
	 echo _PM_UNREAD;
	 exit();
	 }
 

	 break;
	 
//////////////////
	 
	
case "addfolder": 
	
	global $xoopsDB, $xoopsTpl, $xoopsModule, $xoopsModuleConfig, $xoopsUser;

	$start = empty($_REQUEST["start"]) ? 0 : intval($_REQUEST["start"]);
	
	$cid = empty($_REQUEST["cid"]) ? false : intval($_REQUEST["cid"]);
	
if (empty($xoopsUser)) {
	echo '<div class="head" align="center"><a href="'.XOOPS_URL.'/user.php">'._MD_TDMSOUND_QUERYNOREGISTER.'</a></div>';
exit();
}

if (empty($cid)) {
echo _PM_ACTION_ERROR;
exit();
}
	//trouve le nom du folder
	$folder = $folder_handler->get($cid);
	$folder_title = $myts->displayTarea($folder->getVar('title'));
	$xoopsTpl->assign('folder_title', $folder_title);
	//
	


switch($cid) {

default:

	//message
	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('to_userid', $xoopsUser->getVar('uid')));
   	$totals_messages = $pm_handler->getCount($criteria);
	
   if ($cid == 1) {
	$criteria->add(new Criteria('read_msg', 0));
	} else {
	$criteria->add(new Criteria('msg_folder', $cid));
	}
	 
	$total_messages = $pm_handler->getCount($criteria);
	
	$criteria->setStart($start);
	$criteria->setLimit($xoopsModuleConfig['tdmmp_perpage']);
	$criteria->setSort("msg_time");
	$criteria->setOrder("DESC");
	$pm_arr = $pm_handler->getAll($criteria);
	unset($criteria);


	$xoopsTpl->assign('total_messages', $total_messages);
	$xoopsTpl->assign('totals_messages', $totals_messages);
	$xoopsTpl->assign('op', $_REQUEST['op']);
		
	foreach (array_keys($pm_arr) as $i) {

	//trouve le nom du poster
	$message['postername'] = XoopsUser::getUnameFromId($pm_arr[$i]->getVar('from_userid'));
	//
	$message['posteruid'] = $pm_arr[$i]->getVar('from_userid');
	$message['msg_id'] = $pm_arr[$i]->getVar('msg_id');
	$message['msg_folder'] = $pm_arr[$i]->getVar('msg_folder');
	$message['msg_time'] = formatTimestamp($pm_arr[$i]->getVar('msg_time'), 'm');
	$message['msg_no'] = $i;
	//$message['subject'] = $myts->displayTarea($pm_arr[$i]->getVar('subject'));
	
	$message['subject'] = $myts->displayTarea((strlen($pm_arr[$i]->getVar('subject')) > $xoopsModuleConfig['tdmmp_subject'] ? substr($pm_arr[$i]->getVar('subject'),0,($xoopsModuleConfig['tdmmp_subject']))."..." : $pm_arr[$i]->getVar('subject')));
	
	$message['read_msg'] = $pm_arr[$i]->getVar('read_msg');
	$message['msg_image'] = $pm_arr[$i]->getVar('msg_image');
		
	$xoopsTpl->append('messages', $message);
	}
	//form
	include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
	$send_button = new XoopsFormButton('', 'send', _PM_SEND);
	$send_button->setExtra("onclick='javascript:openWithSelfMain(\"" . XOOPS_URL . "/modules/TDMMp/pmlite.php?send=1\", \"pmlite\", 550, 450);'");
	$delete_button = new XoopsFormButton('', 'delete_messages', _PM_DELETE, 'submit');
	$move_button = new XoopsFormButton('', 'move_messages', ($_REQUEST['op'] == 'save') ? _PM_UNSAVE : _PM_TOSAVE, 'submit');
	$empty_button = new XoopsFormButton('', 'empty_messages', _PM_EMPTY, 'submit');

	$pmform = new XoopsForm('', 'pmform', 'viewpmsg.php', 'post', true);
	$pmform->addElement($send_button);
	$pmform->addElement($move_button);
	$pmform->addElement($delete_button);
	$pmform->addElement($empty_button);
	$pmform->addElement(new XoopsFormHidden('op', $_REQUEST['op']));
	$pmform->assign($xoopsTpl);
	//
	//nav
	if ( $total_messages > $xoopsModuleConfig['tdmmp_perpage']) {
    $nav = tdmmp_renderNav($total_messages, $xoopsModuleConfig['tdmmp_perpage'], $start, $cid );
    $xoopsTpl->assign('pagenav', $nav);
	}
	//
	$xoopsTpl->display('db:tdmmp_viewpmsg.html');

	  break;
	  
	case "9":
	
	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('userid', $xoopsUser->getVar('uid')));
	$criteria->setStart($start);
    $criteria->setLimit($xoopsModuleConfig['tdmmp_perpage']);
	$criteria->setSort("uname");
	$criteria->setOrder("DESC");
	$total_messages = $contact_handler->getCount($criteria);
    $pm_cont =& $contact_handler->getAll($criteria);
	
	$xoopsTpl->assign('total_messages', $total_messages);
		
	foreach (array_keys($pm_cont) as $i) { 
	$poster = new XoopsUser($pm_cont[$i]->getVar('contact'));
	$message['msg_contact'] = $pm_cont[$i]->getVar('id');	
	$postername = $poster->getVar('uname')."<br />".$poster->getVar('name');
		  $userrank =& $poster->rank();
      /* No need to show deleted users */
      if ($postername) {
		    $message['msg_poster'] = "<a href='".XOOPS_URL."/userinfo.php?uid=".$pm_cont[$i]->getVar('contact')."'>".$postername."</a>";
      } else {
		    $message['msg_poster'] = $xoopsConfig['anonymous'];
      }
	  
		/* Online poster */
      if ($poster->isOnline()) {
        $message['msg_online'] = _PM_ONLINE;
      } else {
        $message['msg_online'] = _PM_OFFLINE;
      }
	  
	
    $message['msg_pmlink'] =  "<a href=\"javascript:openWithSelfMain('".XOOPS_URL."/modules/TDMMp/pmlite.php?send2=1&amp;to_userid=".$pm_cont[$i]->getVar('contact')."', 'pmlite', 550, 450);\"><img src=\"".XOOPS_URL."/images/icons/pm.gif\" alt=\"".sprintf(_SENDPMTO,$poster->getVar('uname'))."\" /></a>";

		  /**/
	$message['msg_last'] = formatTimestamp($poster->getVar("last_login"));
	$message['msg_groupe'] = $userrank['title'];
	   
    $xoopsTpl->append('messages', $message);
	  
    }	
	

	$xoopsTpl->display('db:tdmmp_viewcontact.html');
	break;
	
	  }

	

	
	 break;
	 
case "addmsg": 
	global $xoopsDB, $xoopsTpl, $xoopsModule, $xoopsModuleConfig, $xoopsUser;

$msg_id = empty($_REQUEST['msg_id']) ? false : intval($_REQUEST['msg_id']);


if (empty($xoopsUser)) {
echo '<div class="head" align="center"><a href="'.XOOPS_URL.'/user.php">'._MD_TDMSOUND_QUERYNOREGISTER.'</a></div>';
exit();
}

if (empty($msg_id)) {
echo _PM_ACTION_ERROR;
exit();
}


if ($msg_id > 0) {
	$pm =& $pm_handler->get($msg_id);
} else {
	$pm = null;
}

$start = !empty($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
$total_messages = !empty($_REQUEST['total_messages']) ? intval($_REQUEST['total_messages']) : 0;

 
if ($pm->getVar("from_userid") == $xoopsUser->getVar("uid")) {
    $poster = new XoopsUser($pm->getVar("to_userid"));
} else {
    $poster = new XoopsUser($pm->getVar("from_userid"));
}
if (!is_object($poster)) {
    $xoopsTpl->assign('poster', false);
    $xoopsTpl->assign('anonymous', $xoopsConfig['anonymous']);
} else {
    $xoopsTpl->assign('poster', $poster);
}

if ($pm->getVar("to_userid") == $xoopsUser->getVar("uid") && $pm->getVar('read_msg') == 0) {
    $pm_handler->setRead($pm);
}

include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

$pmform = new XoopsForm('', 'pmform', 'readpmsg.php', 'post', true);	 $quote_button = new XoopsFormButton('', 'send2', _PM_REPLY);
    $quote_button->setExtra("onclick='javascript:openWithSelfMain(\"" . XOOPS_URL . "/modules/TDMMp/pmlite.php?to_userid=".$pm->getVar("from_userid")."&amp;send2=1&amp;msg_id={$msg_id}\", \"pmlite\", 550, 450);'");
	$pmform->addElement($quote_button);
	
	    $reply_button = new XoopsFormButton('', 'send', _PM_QUOTE);
    $reply_button->setExtra("onclick='javascript:openWithSelfMain(\"" . XOOPS_URL . "/modules/TDMMp/pmlite.php?reply=1&amp;msg_id={$msg_id}\", \"pmlite\", 550, 450);'");
	$pmform->addElement($reply_button);
	
	$contact_button = new XoopsFormButton('', 'contact', _PM_ADDCONTACT);
   $contact_button->setExtra("onclick='javascript:AddContact(".$pm->getVar("from_userid").");'");
	$pmform->addElement($contact_button);
//$pmform->addElement(new XoopsFormButton('', 'email_message', _PM_EMAIL, 'submit'));
$pmform->addElement(new XoopsFormHidden('msg_id', $pm->getVar("msg_id")));
$pmform->addElement(new XoopsFormHidden('op', $_REQUEST['op']));
$pmform->addElement(new XoopsFormHidden('action', 1));
$pmform->assign($xoopsTpl);

	//trouve le nom du poster et c'est info
	$member_handler =& xoops_gethandler('member');
    $thisUser =& $member_handler->getUser($poster->getVar('uid'));
	
	$var = $thisUser->getVar('user_regdate');
	$xoopsTpl->assign('user_joindate' , formatTimestamp( $var, 's' ));
	$xoopsTpl->assign('user_posts', $thisUser->getVar('posts'));
	//son rank
	$userrank = $thisUser->rank();
	if ($userrank['image']) {
    $xoopsTpl->assign('user_rankimage', '<img src="'.XOOPS_UPLOAD_URL.'/'.$userrank['image'].'" alt="" />');
	}
	$xoopsTpl->assign('user_ranktitle', $userrank['title']);
	if ($thisUser->getVar('user_avatarurl') != "blank.gif") {
	$xoopsTpl->assign('user_avatarurl', XOOPS_URL.'/uploads/'.$thisUser->getVar('user_avatar'));
	} else {
	$xoopsTpl->assign('user_avatarurl', TDMMP_IMAGES_URL.'/imguser.png');
	}
	//$xoopsTpl->assign('user_avatarurl', 'uploads/'.$thisUser->getVar('user_avatar'));
	$xoopsTpl->assign('user_location', $thisUser->getVar('user_from'));
	//
	

$message = $pm->getValues();
$message['msg_time'] = formatTimestamp($pm->getVar("msg_time"));
$xoopsTpl->assign('message', $message);
$xoopsTpl->assign('op', $_REQUEST['op']);
$xoopsTpl->assign('previous', $start-1);
$xoopsTpl->assign('next', $start+1);
$xoopsTpl->assign('total_messages', $total_messages);

$xoopsTpl->display('db:tdmmp_readpmsg.html');
	
	//

	 break;

}

?>
