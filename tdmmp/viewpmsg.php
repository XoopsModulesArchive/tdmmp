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

include_once "../../mainfile.php";

global $xoopsModuleConfig;
if (!is_object($xoopsUser)) {
    redirect_header(XOOPS_URL, 3, _NOPERM);
    exit();
}
$xoopsConfig['module_cache'] = 0; //disable caching since the URL will be the same, but content different from one user to another
if ($xoopsModuleConfig['tdmmp_class'] == "full") {
$xoopsOption['template_main'] = "tdmmp_fullindex.html";
} elseif ($xoopsModuleConfig['tdmmp_class'] == "folder") {
$xoopsOption['template_main'] = "tdmmp_folderindex.html";
 } else {
$xoopsOption['template_main'] = "tdmmp_tabsindex.html";
}
include XOOPS_ROOT_PATH . '/header.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar("dirname").'/include/common.php';

$_REQUEST['op'] = empty($_REQUEST['op']) ? "in" : $_REQUEST['op'];
$start = empty($_REQUEST["start"]) ? 0 : intval($_REQUEST["start"]);
//$pm_handler =& xoops_getModuleHandler('message');
$pm_handler =& xoops_getModuleHandler('tdmmp_messages', 'TDMMp');
$folder_handler =& xoops_getModuleHandler('tdmmp_folder', 'TDMMp');

//compte les message et affiche le %
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('to_userid', $xoopsUser->getVar('uid')));
$total = $pm_handler->getCount($criteria); 
$precistotal = number_format(($total*100)/$xoopsModuleConfig['tdmmp_maxalert'], 0, ",", " ");
$xoopsTpl->assign('tdmmp_pourcent', $precistotal);
$xoopsTpl->assign('tdmmp_pourc', sprintf(_PM_ALERT_POURC, $precistotal.'%'));
  
$xoopsTpl->assign('anonymous', $xoopsConfig['anonymous']);
$xoopsTpl->assign('tdmmp_class', $xoopsModuleConfig['tdmmp_class']);

$mp_style = isset($_REQUEST['mp_style']) ? $_REQUEST['mp_style'] : 'cupertino';    
 
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";


if (empty($_COOKIE['tdmmp_style']) || isset($_REQUEST['mp_style'])) {
setcookie('tdmmp_style', $mp_style, (time() + 10*365*24*60*60), '/');
$tdmmp_style = $mp_style; 
} else {
$tdmmp_style = $_COOKIE['tdmmp_style']; 
}


// style display
	
	$tagchannel = array('viewpmsg.php?mp_style=cupertino' => 'cupertino', 'viewpmsg.php?mp_style=lightness' => 'lightness', 'viewpmsg.php?mp_style=darkness' => 'darkness', 'viewpmsg.php?mp_style=smoothness' => 'smoothness', 'viewpmsg.php?mp_style=start' => 'start', 'viewpmsg.php?mp_style=redmond' => 'redmond', 'viewpmsg.php?mp_style=sunny' => 'sunny', 'viewpmsg.php?mp_style=pepper' => 'pepper', 'viewpmsg.php?mp_style=eggplant' => 'eggplant' ,
	'viewpmsg.php?mp_style=dark-hive' => 'dark-hive', 'viewpmsg.php?mp_style=excite' => 'excite', 'viewpmsg.php?mp_style=vader' => 'vader', 'viewpmsg.php?mp_style=trontastic' => 'trontastic' );
	$tagchannel_select = new XoopsFormSelect('', 'style', 'viewpmsg.php?mp_style='.$tdmmp_style);
	//$tagchannel_select->setDescription(_AM_SPOT_PLUGSTYLE_DESC);
	$tagchannel_select->addOptionArray($tagchannel);
	$test = 'viewpmsg.php?mp_style=';
	$tagchannel_select->setExtra("OnChange='window.document.location=this.options[this.selectedIndex].value;'");

//affiche les dossier menu
	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('pid', 0, '!='));
	$criteria->add(new Criteria('uid', $xoopsUser->getVar('uid')), 'OR');
	$folder_arr = $folder_handler->getObjects($criteria);
unset($criteria);	
	foreach (array_keys($folder_arr) as $i) {
	$folder['cid'] = $folder_arr[$i]->getVar('cid');
	$folder['title'] = $folder_arr[$i]->getVar('title');
	$xoopsTpl->append('folders', $folder);
      }
	  
//affiche les dossier image
	$couleur = range(0, 19);
	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('ver', 1));
	$criteria->add(new Criteria('pid', 0));
	$criteria->add(new Criteria('uid', $xoopsUser->getVar('uid')), 'OR');
	$criteria->setSort('cid');
	$criteria->setOrder('ASC');
	$folder_img = $folder_handler->getObjects($criteria);
unset($criteria);	
	$countcat = 1;
	$souscountcat = 1;	
	foreach (array_keys($folder_img) as $i) {
	$folder_img['cid'] = $folder_img[$i]->getVar('cid');
	$folder_img['title'] = $folder_img[$i]->getVar('title');
	if ($folder_img[$i]->getVar('cid') == 9) {
	$folder_img['couleur'] = 'contact';
	} elseif ($folder_img[$i]->getVar('cid') == 1) {
	$folder_img['couleur'] = 'received';	
	}elseif ($folder_img[$i]->getVar('cid') == 2) {
	$folder_img['couleur'] = 'save';	
	}else{
	$folder_img['couleur'] = 'open';
	}
	//trouve les sous dossier
	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('ver', 1));
	$criteria->add(new Criteria('pid', $folder_img[$i]->getVar('cid')));
	$criteria->setSort('cid');
	$criteria->setOrder('ASC');
	$folder_sous = $folder_handler->getObjects($criteria);
	unset($criteria);
		
	$souscountcat = $countcat;	
	foreach (array_keys($folder_sous) as $e) {
	$sous_img['cid'] = $folder_sous[$e]->getVar('cid');
	$sous_img['title'] = $folder_sous[$e]->getVar('title');
	$sous_img['couleur'] = array_rand($couleur);
	$folder_img['sous'][] = $sous_img;
	$countcat++;
	}
	$countcat++;
	$folder_img['newline'] = ($countcat % 5 == 1) ? true : false;
	$xoopsTpl->append('folders_img', $folder_img);
	unset($folder_img['sous']);
	  }
	  
$pmform = new XoopsForm('', 'pmform', 'viewpmsg.php', 'post', true);
$pmform->addElement($tagchannel_select);
$pmform->assign($xoopsTpl);

//include script
$xoTheme->addScript(XOOPS_URL."/modules/".$xoopsModule->dirname()."/js/jquery.js");
$xoTheme->addScript(XOOPS_URL."/modules/".$xoopsModule->dirname()."/js/jquery-ui-1.7.2.custom.min.js");
$xoTheme->addScript(XOOPS_URL."/modules/".$xoopsModule->dirname()."/js/jquery.easing.js");
$xoTheme->addScript(XOOPS_URL."/modules/".$xoopsModule->dirname()."/js/jqueryFileTree.js");

$xoTheme->addStylesheet(XOOPS_URL."/modules/".$xoopsModule->dirname()."/js/jqueryFileTree.css");
$xoTheme->addStylesheet(XOOPS_URL."/modules/".$xoopsModule->dirname()."/css/".$tdmmp_style."/jquery-ui-1.7.2.custom.css");
//
include XOOPS_ROOT_PATH."/footer.php";
?>