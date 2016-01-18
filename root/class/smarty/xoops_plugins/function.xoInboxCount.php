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
function smarty_function_xoInboxCount( $params, &$smarty ) 
{
    global $xoopsUser, $xoopsConfig;
    
    if ( !isset($xoopsUser) || !is_object($xoopsUser) ) {
        return;
    }
	
    $time = time();
    if ( isset( $_SESSION['xoops_inbox_count'] ) && @$_SESSION['xoops_inbox_count_expire'] > $time ) {
        $count = intval( $_SESSION['xoops_inbox_count'] );
    } else {
        $module_handler = xoops_gethandler('module');
        $pm_module = $module_handler->getByDirname('pm');
		$tdmmp_module = $module_handler->getByDirname('TDMMp');
		
        if ($pm_module && $pm_module->getVar('isactive')) {
            $pm_handler =& xoops_getModuleHandler( 'message', 'pm' );
        } else {
            $pm_handler =& xoops_gethandler( 'privmessage' );
        }
		
		if ($tdmmp_module && $tdmmp_module->getVar('isactive')) {
		$config_handler = &xoops_gethandler('config');
		$xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $tdmmp_module->getVar('mid'));
		include_once(XOOPS_ROOT_PATH."/modules/TDMMp/language/".$xoopsConfig['language']."/main.php");
		
        $pm_handler =& xoops_getModuleHandler('tdmmp_messages', 'TDMMp');
		} else {
            $pm_handler =& xoops_gethandler( 'privmessage' );
        }
		
		
        $criteria = new CriteriaCompo( new Criteria('read_msg', 0) );
        $criteria->add( new Criteria( 'to_userid', $xoopsUser->getVar('uid') ) );
        $count = intval( $pm_handler->getCount($criteria) );
        $_SESSION['xoops_inbox_count'] = $count;
        $_SESSION['xoops_inbox_count_expire'] = $time + 60;
    }
	
	if ($tdmmp_module && $tdmmp_module->getVar('isactive')) {
	
	$style = isset($_COOKIE['tdmmp_style']) ? $_COOKIE['tdmmp_style'] : 'cupertino';

	if ($xoopsModuleConfig['tdmmp_popup'] == 1 && $count > 0) {
	echo "
	<script type='text/javascript' src='".XOOPS_URL."/modules/TDMMp/js/jquery.js'></script>
	<script type='text/javascript' src='".XOOPS_URL."/modules/TDMMp/js/jquery-ui-1.7.2.custom.min.js'></script>
	<link rel='stylesheet' type='text/css' href='".XOOPS_URL."/modules/TDMMp/css/".$style."/jquery-ui-1.7.2.custom.css'>";
	
	echo '<script type="text/javascript">
	var $tdmmp = jQuery.noConflict();
	$tdmmp(document).ready( function() {
		$tdmmp("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:200,
			modal: true,
			overlay: {
				backgroundColor: "#000",
				opacity: 0.5
			},
			buttons: {
				"'._PM_ACTION_MSG.'": function() {
				$tdmmp(this).dialog("close");
				window.location.replace("'.XOOPS_URL.'/modules/TDMMp/");
				},
				Cancel: function() {
					$tdmmp(this).dialog("close");
				}
			}
		});
	});
	</script>';
	//trouve le nom de l'envoyeur
	
	$msg_text = str_replace("{X_UNAME}", $xoopsUser->getVar('uname'),  $xoopsModuleConfig['tdmmp_popupmessage']);
	$msg_text = str_replace("{X_COUNT}", $count,  $msg_text);
	
echo '<div id="dialog" title="'._PM_INBOX.'">'.$msg_text.'</div>';	
	
	}
	}
	

    if ( !@empty( $params['assign'] ) ) {
        $smarty->assign( $params['assign'], $count );	
    } else {
        echo $count;
	}
}

?>