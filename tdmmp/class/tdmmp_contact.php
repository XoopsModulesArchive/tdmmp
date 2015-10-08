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

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

if (!class_exists('XoopsPersistableObjectHandler')) {
  include_once XOOPS_ROOT_PATH.'/modules/TDMMp/class/object.php';
}

class tdmmp_contact extends XoopsObject
{ 

// constructor
	function __construct()
	{
		$this->XoopsObject();
		$this->initVar("id",XOBJ_DTYPE_INT,null,false,8);
		$this->initVar("userid",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("contact",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("name",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("uname",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("regdate",XOBJ_DTYPE_INT,null,false,10);
	}

	  function tdmmp_contact()
    {
        $this->__construct();
    }


    function getForm($action = false)
    {
 global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $title = $this->isNew() ? sprintf(_PM_AM_ADD) : sprintf(_PM_AM_EDIT);

        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
        $form->addElement(new XoopsFormText(_PM_AM_TITLE, 'title', 100, 255, $this->getVar('title')), true);
        if (!$this->isNew()) {
            //Load groups
            $form->addElement(new XoopsFormHidden('cid', $this->getVar('cid')));
	   }
	   
	   //categorie
		if ($this->isNew()) {
		$folder_handler =& xoops_getModuleHandler('TDMMp_folder', 'TDMMp');
		$arr = $folder_handler->getall();
		$mytree = new XoopsObjectTree($arr, 'cid', 'pid');
		$form->addElement(new XoopsFormLabel(_AM_TDMSOUND_PARENT, $mytree->makeSelBox('pid', 'title','-','',true)));
		}
		
		//$form->addElement(new XoopsFormText(_AM_SPOT_WEIGHT, 'weight', 10, 10, $this->getVar('weight')));			
        //$form->addElement(new XoopsFormRadioYN(_AM_SPOT_VISIBLE, 'visible', $this->getVar('visible'), _YES, _NO));
		$form->addElement(new XoopsFormHidden('op', 'save'));
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
	}

}


class TDMMptdmmp_contactHandler extends XoopsPersistableObjectHandler 
{

    function __construct(&$db) 
    {
        parent::__construct($db, "tdmmp_contact", 'tdmmp_contact', 'id', 'uname');
    }

}


?>