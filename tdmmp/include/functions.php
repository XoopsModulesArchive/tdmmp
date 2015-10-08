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
 
if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}

/**
 * Creation des meta keywords
 *
 */
 
    function tdmmp_renderNav($total, $perpage, $current, $folder_id)
    {
        $ret = '';
        if ( $total <= $perpage ) {
            return $ret;
        }
        $total_pages = ceil($total / $perpage);
        if ( $total_pages > 1 ) {
            $ret .= '<div id="xo-pagenav">';
            $prev = $current - $perpage;
            if ( $prev >= 0 ) {
                $ret .= '<a class="xo-pagarrow" href="javascript:;" onclick="AddFolder('.$folder_id.', '.$prev.');return false;"><u>&laquo;</u></a> ';
            }
            $counter = 1;
            $current_page = intval(floor(($current + $perpage) / $perpage));
            while ( $counter <= $total_pages ) {
                if ( $counter == $current_page ) {
                    $ret .= '<strong class="xo-pagact" >('.$counter.')</strong> ';
                } elseif ( ($counter > $current_page-4 && $counter < $current_page + 4 ) || $counter == 1 || $counter == $total_pages ) {
                    if ( $counter == $total_pages && $current_page < $total_pages - 4 ) {
                        $ret .= '... ';
                    }
                    $ret .= '<a class="xo-counterpage" href="javascript:;" onclick="AddFolder('.$folder_id.', '.(($counter - 1) * $perpage).');return false;">'.$counter.'</a> ';
                    if ( $counter == 1 && $current_page > 1 + 4 ) {
                        $ret .= '... ';
                    }
                }
                $counter++;
            }
            $next = $current + $perpage;
            if ( $total > $next ) {
                $ret .= '<a class="xo-pagarrow" href="javascript:;"  onclick="AddFolder('.$folder_id.', '.$next.');return false;"><u>&raquo;</u></a> ';
          // href="javascript:;" onclick="AddFolder('.$folder_arr[$i]->getVar('cid').');return false;" 

		   }
            $ret .= '</div> ';
        }
        return $ret;
    }
 
 

/**
 * xd_getdefaultmatchtypeid
 *
 * Returns default matchtype id
 *
 * @package pronoboulistenaute
 * @author wild0ne (mailto:wild0ne@partypilger.de)
 * @copyright (c) wild0ne
 * @param $eventid    get default matchtype for related event
 */

 function tdmmp_PrettySize($size)
{
    $mb = 1024 * 1024;
    if ($size > $mb)
    {
        $mysize = sprintf ("%01.2f", $size / $mb) . " Mo";
    }elseif ($size >= 1024)
    {
        $mysize = sprintf ("%01.2f", $size / 1024) . " Ko";
    }
    else
    {
		$mysize = sprintf("%01.2f", $size). " Oc";
    }
    return $mysize;
}

function creeMsg(&$texte, $valeur, $libelle)
{
	//-- passage du message par référence, donc pas besoin de return ---------
	if ($valeur > 0)
	{
		$pluriel = ($valeur == 1) ? '' : 's';
		$texte .= $valeur . ' ' . $libelle . $pluriel . ' ';
	}
}

 function tdmmp_mathtemps($dateDebut, $dateFin, $var=0)
{
//Temp entre les dates
//TDMAssoc_mathtemps($dateDebut, $dateFin, 0);
//
//TEMP PASSE depuis $datebut j'usqu'a aujourd'hui
//TDMAssoc_mathtemps($dateDebut, $dateFin, 1);
//
//temp restant jusqu'a $datefin
//TDMAssoc_mathtemps($dateDebut, $dateFin, 2);
//
	$time = $dateFin - $dateDebut;
	if ($time != 0) 
	{
		//-- si dateDebut = '' on l'initialise avec la date courante -------------
		if ($var == '2') $dateDebut = time();
		//-- si dateFin = '' on l'initialise avec la date courante ---------------
		if ($var == '1') $dateFin =  time();
		
		if ($dateDebut > $dateFin) return ;
		
		$duree = $dateFin - $dateDebut;
		if ($duree == 0) return ;
		
		$jour = floor($duree / 86400);
		$reste = $duree % 86400;
		$heure = floor($reste / 3600);
		$reste = $reste % 3600;
		$minute = floor($reste / 60);
		$seconde = $reste % 60;
		
		$texte = '';
		creeMsg($texte, $jour, 'jour');
		creeMsg($texte, $heure, 'heure');
		creeMsg($texte, $minute, 'minute');
		creeMsg($texte, $seconde, 'seconde');
		
		return $texte;
	}
}

  function tdmmp_compareFile($source,$dest) {
    if (md5_file($source) == md5_file($dest)) {
      return true;
    }else{
      return false;
    }
  }
  
    function tdmmp_copyFile($source,$dest) {
	
	if(file_exists($dest)){
	$result = rename($dest,$dest.'.svg');
	} else {
	$result = copy($source,$dest);
	}
	if ($result) {
     return true;
    }else{
      return false;
    }
	}
  

/**
 * admin menu
 */
 function Adminmenu ($currentoption = 0, $breadcrumb = '') {      
		
	/* Nice buttons styles */
	echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/TDMAssoc/images/deco/bg.png') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/TDMAssoc/images/deco/left_both.png') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/TDMAssoc/images/deco/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		
	.CPbigTitle{
	font-size: 20px;
	color: #1E90FF;
	background: no-repeat left top;
	font-weight: bold;
	height: 40px;
	vertical-align: middle;
	padding: 10px 0 0 50px;
	border-bottom: 3px solid #1E90FF;
	}
		
		</style>
    ";
	
	global $xoopsModule, $xoopsConfig;
	$myts = &MyTextSanitizer::getInstance();
	
	$tblColors = Array();
	$tblColors[0] = $tblColors[1] = $tblColors[2] = $tblColors[3] = $tblColors[4] = $tblColors[5] = $tblColors[6] = $tblColors[7] = $tblColors[8] = '';
	$tblColors[$currentoption] = 'current';
	if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/english/modinfo.php';
	}
	
	echo "<div id='buttontop'>";
	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	//echo "<td style=\"width: 45%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "\">" . _AM_SF_OPTS . "</a> | <a href=\"import.php\">" . _AM_SF_IMPORT . "</a> | <a href=\"../index.php\">" . _AM_SF_GOMOD . "</a> | <a href=\"../help/index.html\" target=\"_blank\">" . _AM_SF_HELP . "</a> | <a href=\"about.php\">" . _AM_SF_ABOUT . "</a></td>";
	echo "<td style='font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;'>
	<a href='" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/index.php'>".$xoopsModule->getVar('dirname')."</a>
	</td>";
	echo "<td style='font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;'><b>" . $myts->displayTarea($xoopsModule->name()) . "  </b> ".$breadcrumb." </td>";
	echo "</tr></table>";
	echo "</div>";
	
	echo "<div id='buttonbar'>";
	echo "<ul>";
    echo "<li id='" . $tblColors[0] . "'><a href=\"" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/admin/index.php\"><span>"._PM_MI_INDEX."</span></a></li>";
	echo "<li id='" . $tblColors[1] . "'><a href=\"" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/admin/prune.php\"><span>"._PM_MI_PRUNE."</span></a></li>";
	echo "<li id='" . $tblColors[2] . "'><a href=\"" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/admin/folder.php\"><span>"._PM_MI_FOLDER."</span></a></li>";
	echo "<li id='" . $tblColors[3] . "'><a href=\"" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/admin/notif.php\"><span>"._PM_MI_NOTIF."</span></a></li>";
	echo "<li id='" . $tblColors[4] . "'><a href=\"" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/admin/about.php\"><span>"._PM_MI_ABOUT."</span></a></li>";
	echo "<li id='" . $tblColors[5] . "'><a href='../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule ->getVar('mid')."'><span>" ._PM_AM_NAVPREFERENCES. "</span></a></li>";
	echo "</ul></div>&nbsp;";
}


?>
