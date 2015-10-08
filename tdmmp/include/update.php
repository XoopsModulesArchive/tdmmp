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

function xoops_module_update_TDMMp(&$module) 
{

global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsModule;	

   // insert folder
  $sq1 = $xoopsDB->queryF("INSERT INTO `".$xoopsDB->prefix('tdmmp_folder')."` (`cid`, `pid`, `title`, `uid`, `ver`) VALUES (1, 0, 'Bo&#238;te de r&#233;ception', NULL, 1)");
  $sq1 = $xoopsDB->queryF("INSERT INTO `".$xoopsDB->prefix('tdmmp_folder')."` (`cid`, `pid`, `title`, `uid`, `ver`) VALUES (2, 0, 'Sauvegarde', NULL, 1)");
  $sq1 = $xoopsDB->queryF("INSERT INTO `".$xoopsDB->prefix('tdmmp_folder')."` (`cid`, `pid`, `title`, `uid`, `ver`) VALUES (3, 1, 'Messages Reçus', NULL, 1)");
  $sq1 = $xoopsDB->queryF("INSERT INTO `".$xoopsDB->prefix('tdmmp_folder')."` (`cid`, `pid`, `title`, `uid`, `ver`) VALUES (4, 1, 'Brouillons', NULL, 1)"); 
  $sq1 = $xoopsDB->queryF("INSERT INTO `".$xoopsDB->prefix('tdmmp_folder')."` (`cid`, `pid`, `title`, `uid`, `ver`) VALUES (5, 1, 'Messages envoy&#233;s', NULL, 1)");
  $sq1 = $xoopsDB->queryF("INSERT INTO `".$xoopsDB->prefix('tdmmp_folder')."` (`cid`, `pid`, `title`, `uid`, `ver`) VALUES (6, 1, 'Messages supprim&#233;s', NULL, 1)");
  $sq1 = $xoopsDB->queryF("INSERT INTO `".$xoopsDB->prefix('tdmmp_folder')."` (`cid`, `pid`, `title`, `uid`, `ver`) VALUES (7, 2, 'Travail', NULL, 1)");
  $sq1 = $xoopsDB->queryF("INSERT INTO `".$xoopsDB->prefix('tdmmp_folder')."` (`cid`, `pid`, `title`, `uid`, `ver`) VALUES (8, 2, 'Funy', NULL, 1)");
  $sq1 = $xoopsDB->queryF("INSERT INTO `".$xoopsDB->prefix('tdmmp_folder')."` (`cid`, `pid`, `title`, `uid`, `ver`) VALUES (9, 0, 'Contact', NULL, 1)");

    //migrate msgeck pm table version
   
        // Check pm table version
        $sql = "SHOW COLUMNS FROM " . $xoopsDB->prefix("priv_msgs");
        if (!$result = $xoopsDB->queryF($sql)) {
            return false;
        }
        // Migrate from existent pm module
       // if ( ($rows = $xoopsDB->getRowsNum($result)) == 12) {
        //    $sql = "INSERT INTO `" . $xoopsDB->prefix("tdmmp_messages") . "` SELECT * FROM `" . $xoopsDB->prefix("priv_msgs") . "`";
       // } elseif ($rows == 8) {
        //    $fields = "`msg_id`, `msg_image`, `subject`, `from_userid`, `to_userid`, `msg_time`, `msg_text`, `read_msg`";
        //    $sql = "INSERT INTO `" . $xoopsDB->prefix("tdmmp_messages") . "` ({$fields}) SELECT ({$fields}) FROM `" . $xoopsDB->prefix("priv_msgs") . "`";
       // } elseif ($rows == 13) {
        //    $fields = "`msg_id`, `msg_image`, `subject`, `from_userid`, `to_userid`, `msg_time`, `msg_text`, `read_msg`";
       //     $sql = "INSERT INTO `" . $xoopsDB->prefix("tdmmp_messages") . "` ({$fields}) SELECT {$fields} FROM `" . $xoopsDB->prefix("priv_msgs") . "`";
       // }  else {
       //     return true;
       // }
       // $result = $xoopsDB->queryF($sql);
       // return true;
   
   	     // Migrate from existent pm module
    if ( ($rows = $xoopsDB->getRowsNum($result)) == 9) {
        return true;
    } elseif ($rows != 9) {
        return $xoopsDB->queryFromFile(XOOPS_ROOT_PATH . "/modules/" . $module->getVar('dirname', 'n') . "/sql/mysql.upgrade.sql");
    } else {
        return false;
    }
   
}
?>