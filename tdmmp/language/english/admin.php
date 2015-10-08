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
//BOX install
define("_MP_BOX1","Inbox"); 
define("_MP_BOX2","Save"); 
define("_MP_BOX3","Inbox"); 
define("_MP_BOX4","Drafts"); 
define("_MP_BOX5","Sent"); 
define("_MP_BOX6","Deleted Messages"); 
define("_MP_BOX7","Work"); 
define("_MP_BOX8","Funy"); 
define("_MP_BOX9","Contact");
//

define("_PM_AM_INDEX","Index");
define("_PM_AM_PRUNE","Prune");
define("_PM_AM_FOLDER","Folder");
define("_PM_AM_NAVPREFERENCES","Preferences");
define("_PM_AM_NAVPERMISSIONS","Permissions");
define("_PM_AM_NAVUPDATE","Update");
define("_PM_AM_NAVABOUT","About");
define("_PM_AM_NOTIF","Notifications");

define("_PM_AM_INDEXDESC","Index Module");

//index.php
define("_PM_AM_MANAGE_MP","Managing Messages");
define("_PM_AM_THEREARE_MP","There are <span style='color: #ff0000; font-weight: bold'>%s</span> Messages in the Database");

define("_PM_AM_MANAGE_FOLDER","Managing Folders");
define("_PM_AM_MANAGE_FOLDER_USER","Gestion des Dossiers Utilisateurs");
define("_PM_AM_THEREARE_FOLDER","There are <span style='color: #ff0000; font-weight: bold'>%s</span> Folder in the Database");
define("_PM_AM_THEREARE_FOLDER_WAITING","There are <span style='color: #ff0000; font-weight: bold'>%s</span> Personal folder in the database");

define("_PM_AM_MANAGE_NOTIF","Managing Notifications");
define("_PM_AM_THEREARE_NOTIF","There are <span style='color: #ff0000; font-weight: bold'>%s</span> Users active in the notification database");

//form
define("_PM_AM_TITLE","Title"); 
define("_PM_AM_ACTION","Action"); 
define("_PM_AM_TRIE_PAR","View By"); 
define("_PM_AM_NICKNAME","name of the user");
define("_PM_AM_REELNAME","Real Name"); 
define("_PM_AM_DEL","Delete"); 
define("_PM_AM_EDIT","Edit"); 
define("_PM_AM_ADD","Add");

define("_PM_AM_FORMSUREDEL","Are you sure you want to delete <b> <span style='color: Red'>% s </ span> </ b> messages in the folder will be deleted"); 
define("_PM_AM_BASE","Your changes are successfully saved"); 
define("_PM_AM_BASEERROR","Error: Your changes are not saved");
//prune.php
define("_PM_AM_PRUNEAFTER","Prune messages posted after this date (leave blank for no start date)");
define("_PM_AM_PRUNEBEFORE","Prune messages posted before this date (leave blank for no end date)");
define("_PM_AM_ONLYREADMESSAGES","Prune only read messages");
define("_PM_AM_INCLUDESAVE","Include messages in users' \"save\" folders");
define("_PM_AM_NOTIFYUSERS","Notify affected users about the prune?");

define("_PM_AM_MESSAGESPRUNED","%u Messages Pruned");
define("_PM_AM_ERRORWHILEPRUNING","An error occurred during prune");

// notif.php 
define("_PM_AM_DNOTIF","Set the active notification"); 
define("_PM_AM_LAST10NOTIF","User (s)"); 
define("_PM_AM_TRIENOTIF","Members currently sorted by:"); 
define("_PM_AM_NOTIFAFTER","connection after this date (white for any date)"); 
define("_PM_AM_NOTIFBEFORE","Connection before this date (white for any date)"); 
define("_PM_AM_NOTIF_REGDATE","Joined"); 
define("_PM_AM_NOTIF_LAST","Last Login"); 
define("_PM_AM_NOTIF_DEL","Disable notifications"); 
define("_PM_AM_NOTIF_WARNING","Disable notifications of members who did not come on your site for some time. deactivation This concerns only the members who activated the notification by private message."); 
define("_PM_AM_NOTIF_REDIRECT","Notification (s) Off (s)"); 
define("_PM_AM_NOTIF_NONE","No notification (s) active for your selection");

//About (about.php)
define("_AM_ABOUT_RELEASEDATE","Release Date");
define("_AM_ABOUT_AUTHOR","Author");
define("_AM_ABOUT_CREDITS","Cr&#233;dits");
define("_AM_ABOUT_README","Générale Information");
define("_AM_ABOUT_MANUAL","Aide");
define("_AM_ABOUT_LICENSE","Licence");
define("_AM_ABOUT_MODULE_STATUS","Status");
define("_AM_ABOUT_WEBSITE","Web Site");
define("_AM_ABOUT_AUTHOR_NAME","Author Name");
define("_AM_ABOUT_AUTHOR_WORD","Author Word");
define("_AM_ABOUT_CHANGELOG","Change Log");
define("_AM_ABOUT_MODULE_INFO","Module Info");
define("_AM_ABOUT_AUTHOR_INFO","Author Info");
define("_AM_ABOUT_DISCLAIMER","Disclaimer");
define("_AM_ABOUT_DISCLAIMER_TEXT","GPL Licensed - No Warranty");

//1.3
define("_PM_AM_MANAGE_IMPORT","Managing imports");
define("_PM_AM_IMPORT_NONE","Table sql none");
define("_PM_AM_IMPORT","Import");

//1.5
define("_PM_AM_MANAGE_INSTALL","integration");
define("_PM_AM_INSTALL_HELP","<b> handling of the files you need to keep a copy of the original </ b>");
define("_PM_AM_INSTALL_COPY","<span style='color: #ff0000; font-weight: bold'> Please copy: </ span>");
define("_PM_AM_INSTALL_IN","<span style='color: #ff0000; font-weight: bold'> in: </ span>");

//1.6
define("_PM_AM_OPTIMISE","Optimise tables");
?>
