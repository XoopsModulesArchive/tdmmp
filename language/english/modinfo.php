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
define("_PM_MI_NAME","Private Messages"); 
define("_PM_MI_DESC","Module to exchange private messages between members"); 

define("_PM_MI_INDEX","index"); 
define("_PM_MI_PRUNE","Purge messages"); 
define("_PM_MI_FOLDER","Folders"); 
define("_PM_MI_NOTIF","Notifications"); 
define("_PM_MI_ABOUT","About"); 

define("_PM_MI_LINK_TITLE","Link private message"); 
define("_PM_MI_LINK_DESCRIPTION","Display a link to send a private message to a member"); 
define("_PM_MI_MESSAGE","Send message"); 

define("_PM_MI_PRUNESUBJECT","Contents of the notification of messages purged"); 
define("_PM_MI_PRUNESUBJECT_DESC","This will be the subject of the message sent to the member following the purge"); 
define("_PM_MI_PRUNEMESSAGE","Contents of the message after a purge"); 
define("_PM_MI_PRUNEMESSAGE_DESC","This text will be displayed in the message sent to users after one or more of their messages have been purged from their inbox. PM_COUNT () is replaced by the number of messages purged from this user "); 
define("_PM_MI_PRUNESUBJECTDEFAULT","Messages deleted during the purge"); 
define("_PM_MI_PRUNEMESSAGEDEFAULT","During the purge, we PM_COUNT) (deleted messages in your inbox to save space and resources"); 

define("_PM_MI_MAXSAVE","Maximum messages in the backup directory"); 
define("_PM_MI_MAXSAVE_DESC",""); 

define("_PM_MI_PERPAGE","Number of posts per page"); 
define("_PM_MI_PERPAGE_DESC","How many messages you want displayed on each page?"); 


define("_PM_MI_NEWMSG","Show new messages in a popup"); 
define("_PM_MI_POPUP","This text will be displayed in the popup sent to users.
<br /> {X_UNAME} print the user name
<br /> {X_COUNT} print the number message"); 

define("_PM_MI_NOTIFY","Hello, {X_UNAME} you have {X_COUNT} new Private message.");
//1.1
define("_PM_MI_MAXSUBJECT","Taille Maximum des sujects");
//1.2
define("_PM_MI_CLASS","Style");
//1.06
define("_PM_MI_MAXALERT","Limit message for your users");
?>
