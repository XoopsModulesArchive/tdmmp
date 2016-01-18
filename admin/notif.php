<?PHP
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
TDMSound_adminmenu(3, _PM_AM_NOTIF);
} else {
include_once XOOPS_ROOT_PATH.'/Frameworks/art/functions.admin.php';
loadModuleAdminMenu (3, _PM_AM_NOTIF);
}

//load class
$pm_handler =& xoops_getModuleHandler('tdmmp_messages', 'TDMMp');
$folder_handler =& xoops_getModuleHandler('tdmmp_folder', 'TDMMp');
$member_handler =& xoops_gethandler('member');


$myts =& MyTextSanitizer::getInstance();
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';


$after = empty($_REQUEST['after']) ? time() :strtotime($_REQUEST['after']);
$before = empty($_REQUEST['before']) ? time() :strtotime($_REQUEST['before']);

//menu
echo '<div class="CPbigTitle" style="background-image: url(../images/decos/notif.png); background-repeat: no-repeat; background-position: left; padding-left: 60px; padding-top:20px; padding-bottom:15px;">
<h3><strong>'._PM_AM_MANAGE_NOTIF.'</strong></h3>';
echo '</div><br />';
echo '<span style="color: #567; margin: 3px 0 18px 0; font-size: small; display: block;">'. _PM_AM_NOTIF_WARNING .'</span>';

switch( $op )
{
//supr le message
case "delmp":
 
 if (isset($_REQUEST['msg_id'])) {
 $size = count($_REQUEST['msg_id']);
 $msg =& $_REQUEST['msg_id'];
 for ( $i = 0; $i < $size; $i++ ) {
 $sq2 = "UPDATE ".$xoopsDB->prefix("users")." SET notify_method = '0' WHERE uid = ".$msg[$i]; 
 $result2=$xoopsDB->queryF($sq2);
 } 
 redirect_header( 'notif.php?op=tris&start='.$_REQUEST['start'].'&limit='.$_REQUEST['limit'].'&after='.$_REQUEST['after'].'&before='.$_REQUEST['before'].'', 1, _PM_AM_NOTIF_REDIRECT);
 exit();
}
   break;

case "default":
   default:


 
 $criteria = new CriteriaCompo();
 $criteria->add(new Criteria('notify_method', 1));
	
 if (isset($_REQUEST['limit'])) {
 $criteria->setLimit($_REQUEST['limit']);
 $limit = $_REQUEST['limit'];
 } else {
 $criteria->setLimit(10);
 $limit = 10;
 }

 if (isset($_REQUEST['start'])) {
 $criteria->setStart($_REQUEST['start']);
 $start = $_REQUEST['start'];
 } else {
 $criteria->setStart(0);
 $start = 0;
 }

 if (@$_REQUEST['after'] && $_REQUEST['after'] != "YYYY/MM/DD") {
 $criteria->add(new Criteria('last_login', strtotime($_REQUEST['after']), ">"));
 $after = strtotime($_REQUEST['after']);		
 }

 if (@$_REQUEST['before'] && $_REQUEST['before'] != "YYYY/MM/DD") {
 $criteria->add(new Criteria('last_login', strtotime($_REQUEST['before']), "<"));
 $before = strtotime($_REQUEST['before']);
 }
 
 $criteria->setSort('uname');
 $criteria->setOrder('ASC');
 $foundusers =& $member_handler->getUsers($criteria, true);
 $numrows = $member_handler->getUserCount($criteria);	

 if ( $numrows > $limit ) {
 $pagenav = new XoopsPageNav($numrows, $limit, $start, 'start', 'op=tris&limit='.$limit.'&after='.@$_REQUEST['after'].'&before='.@$_REQUEST['before']);
 $pagenav = $pagenav->renderNav(4);
 } else {
 $pagenav = '';
 }

 $form = new XoopsThemeForm(_PM_AM_TRIENOTIF, "tris", "notif.php");
 $limit_select = array('10' => 10,'15' => 15,'20' => 20,'25' => 25,'30' => 30);
 $promotray = new XoopsFormElementTray(_PM_AM_TRIE_PAR);
 $liste_limit = new XoopsFormSelect (_PM_AM_TRIE_PAR, "limit", $limit);
 $liste_limit->addOptionArray($limit_select);

 $form->addElement(new XoopsFormTextDateSelect(_PM_AM_NOTIFAFTER, 'after', '', @$after));
 $form->addElement(new XoopsFormTextDateSelect(_PM_AM_NOTIFBEFORE, 'before', '', @$before));
 
 $texte_hidden = new XoopsFormHidden("op", "tris");

 $form->addElement($liste_limit);

 $form->addElement($texte_hidden);
 
 $button_tray = new XoopsFormElementTray(_PM_AM_ACTION ,'');
 $button_tray->addElement(new XoopsFormButton('', 'submit',_SUBMIT, 'submit'));
 $form->addElement($button_tray);

 $form->display();
 
 echo"<br />";

  
 if ($numrows>0) {
 echo '<table width="100%" cellspacing="1" class="outer"><tr>
 <th align="center" colspan="7"><b>('.$numrows.') '._PM_AM_LAST10NOTIF.'</b></th>
 </tr><tr><form name="prvmsg" method="post" action="notif.php">
 <td class="head" align="center">'._PM_AM_NICKNAME.'</td><td class="head" align="center">'._PM_AM_REELNAME.'</td>
 <td class="head" align="center">'._PM_AM_NOTIF_REGDATE.'</td><td class="head" align="center">'._PM_AM_NOTIF_LAST.'</td>
 <td class="head" align="center">NB</td><td align="center" class="head">
 <input name="allbox" id="allbox" onclick="xoopsCheckAll(\'prvmsg\', \'allbox\');" type="checkbox" value="Check All" /></td></tr>';						
		  foreach (array_keys($foundusers) as $i) {
		  $criteria = new CriteriaCompo();
		   $criteria->add(new Criteria('to_userid', $foundusers[$i]->getVar("uid")));
		    $numpm = $pm_handler->getCount($criteria);
			$uname = $foundusers[$i]->getVar("uname");
			$name = $foundusers[$i]->getVar("name");
			$user_regdate = formatTimeStamp($foundusers[$i]->getVar("user_regdate"),"s");
			$last_login =  formatTimeStamp($foundusers[$i]->getVar("last_login"),"m");

 echo '<tr><td class="even" align="center">'.$uname.'</td>
 <td class="odd" align="center">'.$name.'</td>
 <td class="even" align="center">'.$user_regdate.'</td>
 <td class="odd" align="center">'.$last_login.'</td>
 <td class="even" align="center">'.$numpm.'</td>
 <td valign="top" align="center" class="even">
 <input type="checkbox" id="msg_id[]" name="msg_id[]" value="'.$foundusers[$i]->getVar('uid').'"/>
 </td></tr>';
} 
    
 echo "&nbsp;<td colspan='7' class='even' align='right'><input name='op' type='hidden' id='op' value='delmp'>
 <input type='submit' class='formButton' name='delmp' value='"._SUBMIT."' />
 </td>
 <input name='start' type='hidden' value='$start'>
 <input name='limit' type='hidden' value='$limit'>
 <input name='after[date]' type='hidden' value='".@$_REQUEST['after']."'>
 <input name='before[date]' type='hidden' value='".@$_REQUEST['before']."'>
 </table><div align=right>".$pagenav."</div><br />";
 } else {
 echo '<br /><table width="100%" cellspacing="1" class="outer">
 <tr><th align="center" colspan="6"><b>'._PM_AM_NOTIF_NONE.'</b></th>
 </tr></table></div><br /><br />';
		}
break;   
   
   }
   xoops_cp_footer();
   
?>