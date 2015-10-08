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


$modversion['name'] = "TDMMp";
$modversion['version'] = 1.06;
$modversion['description'] = _PM_MI_DESC;
$modversion['author'] = 'TDM';
$modversion['author_website_url'] = "http://www.tdmxoops.net/";
$modversion['author_website_name'] = "Team Dev Mdodule";
$modversion['credits'] = "none";
$modversion['license'] = "LICENSE PRO";
$modversion['image'] = "images/logo.png";
$modversion['dirname'] = "TDMMp";

//about
$modversion['demo_site_url'] = "http://www.tdmxoops.net/";
$modversion['demo_site_name'] = "TDM";
$modversion["module_website_url"] = "http://www.tdmxoops.net/";
$modversion["module_website_name"] = "TDM";

$modversion["release"] = "09-06-2009";
$modversion["module_status"] = "Release";
//

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Mysql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Table
//$modversion['tables'][0] = "tdmmp_messages";
$modversion['tables'][1] = "tdmmp_folder";
$modversion['tables'][2] = "tdmmp_contact";

// Scripts to run upon installation or update
$modversion['onInstall'] = "include/install.php";
$modversion['onUpdate'] = "include/update.php";

// Templates
$modversion['templates'] = array();
$modversion['templates'][1]['file'] = 'tdmmp_pmlite.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'tdmmp_readpmsg.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'tdmmp_lookup.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'tdmmp_viewpmsg.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'tdmmp_tabsindex.html';
$modversion['templates'][5]['description'] = 'Tabs index';
$modversion['templates'][6]['file'] = 'tdmmp_contactpmsg.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'tdmmp_viewcontact.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = 'tdmmp_fullindex.html';
$modversion['templates'][8]['description'] = 'Full index';
$modversion['templates'][9]['file'] = 'tdmmp_folderindex.html';
$modversion['templates'][9]['description'] = 'Folder index';
$modversion['templates'][10]['file'] = 'tdmmp_menu.html';
$modversion['templates'][10]['description'] = 'menu';
$modversion['templates'][11]['file'] = 'tdmmp_header.html';
$modversion['templates'][11]['description'] = 'header';


// Menu
$modversion['hasMain'] = 0;

$modversion['config'] = array();
$modversion['config'][]=array(
	'name' => 'tdmmp_perpage',
	'title' => '_PM_MI_PERPAGE',
	'description' => '_PM_MI_PERPAGE_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 20);

//admin config
$modversion['config'][]=array(
	'name' => 'tdmmp_maxalert',
	'title' => '_PM_MI_MAXALERT',
	//'description' => '_PM_MI_MAXALERT_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 500);

$modversion['config'][]=array(
	'name' => 'prunesubject',
	'title' => '_PM_MI_PRUNESUBJECT',
	'description' => '_PM_MI_PRUNESUBJECT_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => _PM_MI_PRUNESUBJECTDEFAULT);

$modversion['config'][]=array(
	'name' => 'prunemessage',
	'title' => '_PM_MI_PRUNEMESSAGE',
	'description' => '_PM_MI_PRUNEMESSAGE_DESC',
	'formtype' => 'textarea',
	'valuetype' => 'text',
	'default' => _PM_MI_PRUNEMESSAGEDEFAULT);
	
$modversion['config'][]=array(
	'name' => 'tdmmp_popup',
	'title' => '_PM_MI_NEWMSG',
	'description' => '',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => '0');
	
$modversion['config'][]=array(
	'name' => 'tdmmp_popupmessage',
	'title' => '_PM_MI_POPUP',
	'description' => '',
	'formtype' => 'textarea',
	'valuetype' => 'text',
	'default' => _PM_MI_NOTIFY);
	
$modversion['config'][]=array(
	'name' => 'tdmmp_subject',
	'title' => '_PM_MI_MAXSUBJECT',
	'description' => '',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 30);

$modversion['config'][]=array (
	'name'	=> 'tdmmp_class',
	'title'	=> '_PM_MI_CLASS',
	'description'	=> '',
	'formtype'	=> 'select',
	'valuetype'	=> 'textarea',
	'default'	=> 'full',
	'options'	=> array('full' => 'full', 'tabs' => 'tabs', 'folder' => 'folder')
);
?>