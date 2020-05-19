<?php declare(strict_types=1);

use XoopsModules\Xbsmodgen;
use XoopsModules\Xbsmodgen\Form;

//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://xoops.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author:    Ashley Kitson                                                  //
// Copyright: (c) 2006, Ashley Kitson
// URL:       http://xoobs.net			                                     //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    XBS Module Generator (XBS_MODGEN)                              //
// ------------------------------------------------------------------------- //
/**
 * Admin page functions
 *
 * @author     Ashley Kitson http://xoobs.net
 * @copyright  2006 Ashley Kitson, UK
 * @package    XBS_MODGEN
 * @subpackage Admin
 * @access     private
 * @version    1
 * @param mixed $id
 * @param mixed $set
 */

/**
 * Set or unset session data
 *
 * @param      $id
 * @param bool $set
 */
function setSession($id, $set = true)
{
    if ($set) {
        $_SESSION['xbs_modgen_mod'] = (int)$id;
    } else {
        unset($_SESSION['xbs_modgen_mod']);
    }
}//end function

/**
 * Check that a url page basename is the one we want
 *
 * @param string $pageName
 * @return bool
 */
function checkRequest($pageName)
{
    /* When PHP is running as a CGI script. $_SERVER['SCRIPT_FILENAME']
    always returns 'php.cgi', not the actual page name, so this check
    is not as good as it could be
    */

    $requestFName = basename($_SERVER['SCRIPT_FILENAME']);

    if (XBS_MODGEN_DEBUG) {
        print "request page name = $requestFName<br>request check name = $pageName<br>";
    }

    return $requestFName == $pageName || 'php.cgi' == $requestFName;
}//end function

/**
 * Delete an object from the database
 *
 * @param int    $id       Internal identifier of object
 * @param string $pageName valid page to request op
 * @param string $hName    name of Xbsobject handler
 * @return bool true on success
 */
function adminDelObject($id, $pageName, $hName)
{
    if (checkRequest($pageName)) {
        //process the request

        $id = (int)$id;

        //delete object

        $objHandler = xoops_getModuleHandler($hName);

        if ($obj = $objHandler->get($id)) {
            if ($objHandler->delete($obj)) {
                return true;
            }

            redirect_header(XBS_MODGEN_URL . "/admin/$pageName", 5, sprintf(_AM_XBS_MODGEN_ADMINERR5, $objHandler->getError()));
        }
    } else {
        redirect_header(XBS_MODGEN_URL . "/admin/$pageName", 5, sprintf(_AM_XBS_MODGEN_ADMINERR5, $objHandler->getError()));
    }
}//end function

/**
 * Function: Edit module details
 *
 * Allow user to edit new or existing module details prior to code generations
 *
 * @param int $modid Module internal identifier
 * @version 1
 */
function adminEditModule($modid = 0)
{
    $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

    if (0 != $modid) {
        $obj = $objHandler->get($modid);
    } else {
        $obj = $objHandler->create();
    }

    $adminEditForm = new Form\FormEdit($obj, _AM_XBS_MODGEN_MODEDITFORM, 'admenu1.php', 'xbs_modgen_mod,lastgen', 'id', 'xbs_modgen_mod');

    $adminEditForm->display();
}//end function

/**
 * Function: Save module details
 *
 * Save module parameters to database
 *
 * @param array $data array of key => value pairs of data items to save
 * @return int New module internal identifier (0 if failure)
 * @version 1
 */
function adminSaveModule($data)
{
    if (checkRequest('admenu1.php')) {
        //process the request

        //revert key to correct name

        $id = $data['xbs_modgen_mod'];

        unset($data['xbs_modgen_mod']);

        $data['id'] = $id;

        $id = (int)$id;

        //create module object

        $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

        if (0 != $id) {
            $obj = $objHandler->get($id);
        } else {
            $obj = $objHandler->create();

            $data['id'] = '0';
        }

        $obj->setVars($data);

        //make sure that data is valid

        if ($obj->validateData()) {
            if ($objHandler->insert($obj)) {
                return (int)$obj->getVar('id');
            }

            unset($_SESSION['xbs_modgen_mod']); //clear session data

            redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 5, sprintf(_AM_XBS_MODGEN_ADMINERR4, $objHandler->getError()));
        } else {
            redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 5, sprintf(_AM_XBS_MODGEN_ADMINERR3, $obj->getHtmlErrors()));
        }
    } //else do nothing and return to form without informing user

    // we don't say anything so as not to give anything away to potential hackers

    redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, (XBS_MODGEN_DEBUG ? 'Invalid Requesting URL' : ''));
}//end function

/**
 * Function: Allow user to select an existing module or create a new one
 *
 * @version 1
 */
function adminSelectModule()
{
    /**
     * @global array user session
     */

    global $_SESSION;

    //Check to see if there are any Module records created yet.

    //If not then display a Module details input form

    // else allow user to select a Module

    $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

    if (0 == $objHandler->countModules()) {
        adminEditModule();
    } else {
        //check to see if user has already chosen a module previously

        // so we can use it as default choice

        $mod_choice = $_SESSION['xbs_modgen_mod'] ?? 0;

        // Get data and assign to form

        $fmod = new Form\FormSelectModule(_AM_XBS_MODGEN_SELMOD, 'xbs_modgen_mod', $mod_choice, 1);

        $ftray = new Form\FormElementTray(_AM_XBS_MODGEN_BUTTONTRAY, true, false, true, false, false, true); //button tray

        $form = new \XoopsThemeForm(_AM_XBS_MODGEN_MODFORM, 'modselform', 'admenu1.php');

        $form->addElement($fmod, true);

        $form->addElement($ftray);

        $form->display();
    }
}//end function

/**
 * Display module details prior to generating scripts
 *
 * @param int $modid module internal identifier
 */
function adminReviewModule($modid)
{
    //Module global parameters

    $moduleHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

    if (!$module = $moduleHandler->get($modid)) {
        redirect_header(XBS_MODGEN_URL . '/admin/admindex.php', 5, sprintf(_AM_XBS_MODGEN_ADMINERR6, $modid));
    }

    $output = "<div align='center'><h3>" . _AM_XBS_MODGEN_RVW_MODDETS . '</h3><table>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODNAME . ': </td><td>' . $module->getVar('modname') . '</td></tr>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODTAG . ': </td><td>' . $module->getVar('modtag') . '</td></tr>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODDIR . ': </td><td>' . $module->getVar('moddir') . '</td></tr>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODTARGETDIR . ': </td><td>' . $module->getVar('modtargetdir') . '</td></tr>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODDESC . ': </td><td>' . $module->getVar('moddesc') . '</td></tr>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODCREDITS . ': </td><td>' . $module->getVar('modcredits') . '</td></tr>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODHASADMIN . ': </td><td>' . (1 == (int)$module->getVar('hasadmin') ? _YES : _NO) . '</td></tr>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODHASUSERSIDE . ': </td><td>' . (1 == (int)$module->getVar('hasuserside') ? _YES : _NO) . '</td></tr>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODHASCOMMENTS . ': </td><td>' . (1 == (int)$module->getVar('hascomments') ? _YES : _NO) . '</td></tr>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODHASNOTIFICATION . ': </td><td>' . (1 == (int)$module->getVar('hasnotification') ? _YES : _NO) . '</td></tr>';

    $output .= '<tr><td>' . _AM_XBS_MODGEN_TBL_MODHASSEARCH . ': </td><td>' . (1 == (int)$module->getVar('hassearch') ? _YES : _NO) . '</td></tr>';

    $output .= '</table><p>';

    //module configs

    $cfgHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Config');

    if ($objs = $cfgHandler->getAllConfigs($modid)) {
        $output .= '<h3>' . _AM_XBS_MODGEN_RVW_MODCFGS . '</h3><table>';

        $output .= '<tr><th>' . _AM_XBS_MODGEN_TBL_CFGLNAME . '</th><th>' . _AM_XBS_MODGEN_TBL_CFGLDESC . '</th></tr>';

        foreach ($objs as $obj) {
            $output .= '<tr><td>' . $obj->getVar('configname') . '</td><td>' . $obj->getVar('configdesc') . '</td></tr>';
        }

        $output .= '</table><p>';
    }

    // -- objects --

    $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Xbsobject');

    //module tables

    $numObj = $objHandler->countTypeObjects($modid, 'table');

    if ($numObj > 0) {
        $objs = $objHandler->getTypeObjects($modid, 'table');

        $output .= '<h3>' . _AM_XBS_MODGEN_RVW_MODTBLE . '</h3><table>';

        $output .= '<tr><th>' . _AM_XBS_MODGEN_TBL_TBLNAME . '</th><th>' . _AM_XBS_MODGEN_TBL_TBLDESC . '</th></tr>';

        foreach ($objs as $obj) {
            $output .= '<tr><td>' . $obj->getVar('objname') . '</td><td>' . $obj->getVar('objdesc') . '</td></tr>';
        }

        $output .= '</table><p>';
    }

    //module admin menu items

    $numObj = $objHandler->countTypeObjects($modid, 'amenu');

    if ($numObj > 0) {
        $objs = $objHandler->getTypeObjects($modid, 'amenu');

        $output .= '<h3>' . _AM_XBS_MODGEN_RVW_MODAMEN . '</h3><table>';

        $output .= '<tr><th>' . _AM_XBS_MODGEN_TBL_MENUNAME . '</th><th>' . _AM_XBS_MODGEN_TBL_MENUDESC . '</th></tr>';

        foreach ($objs as $obj) {
            $output .= '<tr><td>' . $obj->getVar('objname') . '</td><td>' . $obj->getVar('objdesc') . '</td></tr>';
        }

        $output .= '</table><p>';
    }

    //module user menu items

    $numObj = $objHandler->countTypeObjects($modid, 'umenu');

    if ($numObj > 0) {
        $objs = $objHandler->getTypeObjects($modid, 'umenu');

        $output .= '<h3>' . _AM_XBS_MODGEN_RVW_MODUMEN . '</h3><table>';

        $output .= '<tr><th>' . _AM_XBS_MODGEN_TBL_MENUNAME . '</th><th>' . _AM_XBS_MODGEN_TBL_MENUDESC . '</th></tr>';

        foreach ($objs as $obj) {
            $output .= '<tr><td>' . $obj->getVar('objname') . '</td><td>' . $obj->getVar('objdesc') . '</td></tr>';
        }

        $output .= '</table><p>';
    }

    //blocks

    $numObj = $objHandler->countTypeObjects($modid, 'bscript');

    if ($numObj > 0) {
        $objs = $objHandler->getTypeObjects($modid, 'bscript');

        $output .= '<h3>' . _AM_XBS_MODGEN_RVW_MODBLKS . '</h3><table>';

        $output .= '<tr><th>' . _AM_XBS_MODGEN_TBL_BLKNAME . '</th><th>' . _AM_XBS_MODGEN_TBL_BLKDESC . '</th></tr>';

        foreach ($objs as $obj) {
            $output .= '<tr><td>' . $obj->getVar('objname') . '</td><td>' . $obj->getVar('objdesc') . '</td></tr>';
        }

        $output .= '</table><p>';
    }

    //add a go button

    $output .= "<br><form name='frm' id='frm' action='admenu7.php' method='post'><table' class='outer' cellspacing='1'><tr valign='top' align='left'><td class='head'>"
               . _AM_XBS_MODGEN_RVW_MODBUTN
               . "</td><td class='even'><input type='submit' class='formButton' name='submit'  id='submit' value='"
               . _AM_XBS_MODGEN_GO
               . "'></td></tr></table></form></div>";

    //display output

    echo $output;
}

/**
 * Generate the module scripts
 *
 * @param int $modid module internal identifier
 * @param     $requestUrl
 */
function adminGenerateModule($modid, $requestUrl)
{
    //check that requesting script was ours

    $requestFName = basename((string)$requestUrl);

    if ($requestFName = 'admenu7.php') {
        $moduleHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

        if ($mod = $moduleHandler->get($modid)) {
            $ret = $mod->generate();

            $msgs = [_AM_XBS_MODGEN_ADMINMSG6, _AM_XBS_MODGEN_ADMINERR7, _AM_XBS_MODGEN_ADMINERR8];

            if (0 == $ret) {
                //write generation data to module

                $mod->setVar('lastgen', time());

                $moduleHandler->insert($mod);
            }

            //display appropriate message and return user to screen

            redirect_header(XBS_MODGEN_URL . '/admin/admenu7.php', 2, $msgs[$ret]);
        } else {
            redirect_header(XBS_MODGEN_URL . '/admin/admenu7.php', 5, sprintf(_AM_XBS_MODGEN_ADMINERR6, $modid));
        }
    } //else do nothing and return to form without informing user

    // we don't say anything so as not to give anything away to potential hackers

    redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, (XBS_MODGEN_DEBUG ? 'Invalid Requesting URL' : ''));
}//end function

/**
 * Function: Edit config details
 *
 * Allow user to edit new or existing module config details prior to code generations
 *
 * @param int $modid Module internal identifier
 * @param int $cfgid Config item internal identifier
 * @version 1
 */
function adminEditConfig($modid, $cfgid = 0)
{
    $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Config');

    if (0 != $cfgid) {
        $obj = $objHandler->get($cfgid);
    } else {
        $obj = $objHandler->create();

        $obj->setVar('modid', $modid);
    }

    $adminEditForm = new Form\FormEdit($obj, _AM_XBS_MODGEN_CFGEDITFORM, 'admenu2.php', 'modid,id');

    $adminEditForm->display();
}//end function

/**
 * Function: Allow user to select an existing module config item or
 * create a new one
 *
 * @version 1
 */
function adminSelectConfig()
{
    /**
     * @global array user session
     */

    global $_SESSION;

    //Make sure user has selected a module

    if (!isset($_SESSION['xbs_modgen_mod'])) {
        redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, _AM_XBS_MODGEN_ADMINMSG3);
    }

    //Check to see if there are any Module config records created yet.

    // If not then display a config details input form

    // else allow user to select a config item

    $cfgHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Config');

    if (0 == $cfgHandler->countConfigs($_SESSION['xbs_modgen_mod'])) {
        adminEditConfig($_SESSION['xbs_modgen_mod']);
    } else {
        // Column name list

        $cols = [_AM_XBS_MODGEN_TBL_CFGLID, _AM_XBS_MODGEN_TBL_CFGLNAME, _AM_XBS_MODGEN_TBL_CFGLDESC];

        //Table name

        $moduleHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

        $mod = $moduleHandler->get($_SESSION['xbs_modgen_mod']);

        $tname = sprintf(_AM_XBS_MODGEN_TBL_CFGLTNAME, $mod->getVar('modname'));

        //create table form

        $fcfg = new Form\FormTable($cols, $tname, true, XBS_MODGEN_URL . '/admin/admenu2.php?op=new', XBS_MODGEN_URL . '/admin/admenu2.php?op=edit&id=', XBS_MODGEN_URL . '/admin/admenu2.php?op=del&id=');

        //add data rows to it

        $objs = $cfgHandler->getAllConfigs($_SESSION['xbs_modgen_mod']);

        $row = [];

        foreach ($objs as $obj) {
            $row[] = $obj->getVar('id');

            $row[] = $obj->getVar('configname');

            $row[] = $obj->getVar('configdesc');

            $fcfg->addRow($row);

            unset($row);
        }

        //and display

        $fcfg->display();
    }
}//end function

/**
 * Function: Save module config details
 *
 * Save module config items to database
 *
 * @param array $data array of key => value pairs of data items to save
 * @return int New module internal identifier (0 if failure)
 * @version 1
 */
function adminSaveConfig($data)
{
    if (checkRequest('admenu2.php')) {
        //process the request

        $id = (int)$data['id'];

        //create config item object

        $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Config');

        if (0 != $id) {
            $obj = $objHandler->get($id);
        } else {
            $obj = $objHandler->create();

            $data['id'] = '0';
        }

        $obj->setVars($data);

        //make sure that data is valid

        if ($obj->validateData()) {
            if ($objHandler->insert($obj)) {
                return (int)$obj->getVar('id');
            }

            redirect_header(XBS_MODGEN_URL . '/admin/admenu2.php', 5, sprintf(_AM_XBS_MODGEN_ADMINERR4, $objHandler->getError()));
        } else {
            redirect_header(XBS_MODGEN_URL . '/admin/admenu2.php', 5, sprintf(_AM_XBS_MODGEN_ADMINERR3, $obj->getHtmlErrors()));
        }
    } //else do nothing and return to form without informing user

    // we don't say anything so as not to give anything away to potential hackers

    redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, (XBS_MODGEN_DEBUG ? 'Invalid Requesting URL' : ''));
}//end function

/**
 * Delete a module config item
 *
 * @param int       $id         config internal identifier
 * @param urlstring $requesturl url of requesting page
 * @return bool true if delete succesful
 */
function adminDelConfig($id, $requesturl)
{
    return adminDelObject($id, $requesturl, 'admenu2.php', 'XBS_MODGENConfig');
}//end function

/**
 * Function: Edit a ModGen Object details
 *
 * Allow user to edit new or existing details prior to code generations
 *
 * @param int    $modid    Module internal identifier
 * @param int    $objid    item internal identifier
 * @param string $frmTitle Title of form
 * @param array  $frmNames array of names to use on form
 * @param string $retScr   name of script to return to on form post
 * @param string $objType  type of object being edited
 * @version 1
 */
function adminEditObject($modid, $objid, $frmTitle, $frmNames, $retScr, $objType)
{
    $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Xbsobject');

    if (0 != $objid) {
        $obj = $objHandler->get($objid);
    } else {
        $obj = $objHandler->create();

        $obj->setVar('modid', $modid);
    }

    $obj->useFormNames($frmNames);

    $obj->setVar('objtype', $objType);

    switch ($objType) {
        case 'table':
            $obj->setVar('objloc', '/sql/mysql.sql');
            break;
        case 'amenu':
            $obj->setVar('objloc', '/admin/menu.php');
            break;
        case 'umenu':
        case 'bscript':
            $obj->setVar('objloc', '/xoops_version.php');
            break;
        default:
            break;
    }

    $adminEditForm = new Form\FormEdit($obj, $frmTitle, $retScr, 'modid,id,objtype,objloc');

    $adminEditForm->display();
}//end function

/**
 * Function: Edit table details
 *
 * Allow user to edit new or existing module table details prior to code generations
 *
 * @param int $modid  Module internal identifier
 * @param int $tbleid Table item internal identifier
 * @version 1
 */
function adminEditTable($modid, $tbleid = 0)
{
    $frmNames = ['modid' => _AM_XBS_MODGEN_TBL_TBLMODID, 'id' => _AM_XBS_MODGEN_TBL_TBLID, 'objtype' => _AM_XBS_MODGEN_TBL_TBLTYPE, 'objname' => _AM_XBS_MODGEN_TBL_TBLNAME, 'objdesc' => _AM_XBS_MODGEN_TBL_TBLDESC, 'objloc' => _AM_XBS_MODGEN_TBL_TBLLOC, 'objoptions' => _AM_XBS_MODGEN_TBL_TBLSCRIPT];

    adminEditObject($modid, $tbleid, _AM_XBS_MODGEN_TBLEDITFORM, $frmNames, 'admenu3.php', 'table');

    echo '<p align=center><b><i>' . _AM_XBS_MODGEN_TBL_TBLNOTE . '</b></i>';
}//end function

/**
 * Function: Allow user to select an existing table definoition or
 * create a new one
 *
 * @version 1
 */
function adminSelectTable()
{
    //Make sure user has selected a module

    if (!isset($_SESSION['xbs_modgen_mod'])) {
        redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, _AM_XBS_MODGEN_ADMINMSG3);
    }

    //Check to see if there are any table records created yet.

    // If not then display a table details input form

    // else allow user to select a table

    $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Xbsobject');

    if (0 == $objHandler->countTypeObjects($_SESSION['xbs_modgen_mod'], 'table')) {
        adminEditTable($_SESSION['xbs_modgen_mod']);
    } else {
        // Column name list

        $cols = [_AM_XBS_MODGEN_TBL_TBLID, _AM_XBS_MODGEN_TBL_TBLNAME, _AM_XBS_MODGEN_TBL_TBLDESC];

        //Table name

        $moduleHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

        $mod = $moduleHandler->get($_SESSION['xbs_modgen_mod']);

        $tname = sprintf(_AM_XBS_MODGEN_TBL_TBLLTNAME, $mod->getVar('modname'));

        //create table form

        $fcfg = new Form\FormTable($cols, $tname, true, XBS_MODGEN_URL . '/admin/admenu3.php?op=new', XBS_MODGEN_URL . '/admin/admenu3.php?op=edit&id=', XBS_MODGEN_URL . '/admin/admenu3.php?op=del&id=');

        //add data rows to it

        $objs = $objHandler->getTypeObjects($_SESSION['xbs_modgen_mod'], 'table');

        $row = [];

        foreach ($objs as $obj) {
            $row[] = $obj->getVar('id');

            $row[] = $obj->getVar('objname');

            $row[] = $obj->getVar('objdesc');

            $fcfg->addRow($row);

            unset($row);
        }

        //and display

        $fcfg->display();
    }
}//end function

/**
 * Function: Save table details
 *
 * Save table definition to database
 *
 * @param array $data array of key => value pairs of data items to save
 * @return int New table internal identifier (0 if failure)
 * @version 1
 */
function adminSaveTable($data)
{
    if (checkRequest('admenu3.php')) {
        //process the request

        $id = (int)$data['id'];

        //create config item object

        $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Xbsobject');

        if (0 != $id) {
            $obj = $objHandler->get($id);
        } else {
            $obj = $objHandler->create();

            $data['id'] = '0';
        }

        $obj->setVars($data);

        //make sure that data is valid

        if ($obj->validateData()) {
            if ($objHandler->insert($obj)) {
                return (int)$obj->getVar('id');
            }

            redirect_header(XBS_MODGEN_URL . '/admin/admenu3.php', 5, sprintf(_AM_XBS_MODGEN_ADMINERR4, $objHandler->getError()));
        } else {
            redirect_header(XBS_MODGEN_URL . '/admin/admenu3.php', 5, sprintf(_AM_XBS_MODGEN_ADMINERR3, $obj->getHtmlErrors()));
        }
    } //else do nothing and return to form without informing user

    // we don't say anything so as not to give anything away to potential hackers

    redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, (XBS_MODGEN_DEBUG ? 'Invalid Requesting URL' : ''));
}//end function

/**
 * Delete a table description
 *
 * @param int $id table internal identifier
 * @return bool true if delete succesful
 */
function adminDelTable($id)
{
    return adminDelObject($id, 'admenu3.php', 'Xbsobject');
}//end function

/**
 * Edit a menu object
 *
 * @param int    $modid    Module internal identifier
 * @param string $menuType 'amenu' or 'umenu'
 * @param int    $id       Menu internal identifier
 */
function adminEditMenu($modid, $menuType, $id = 0)
{
    switch ($menuType) {
        case 'amenu':  //admin menu
            $pgName   = 'admenu4.php';
            $frmTitle = _AM_XBS_MODGEN_AMENEDITFORM;
            break;
        case 'umenu':  //user menu
            $pgName   = 'admenu5.php';
            $frmTitle = _AM_XBS_MODGEN_UMENEDITFORM;

            break;
        default:
            redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, sprintf(_AM_XBS_MODGEN_ADMINERR9, 'adminEditMenu()'));
            break;
    }

    $frmNames = ['modid'      => _AM_XBS_MODGEN_TBL_MENUMODID,
                 'id'         => _AM_XBS_MODGEN_TBL_MENUID,
                 'objtype'    => _AM_XBS_MODGEN_TBL_MENUTYPE,
                 'objname'    => _AM_XBS_MODGEN_TBL_MENUNAME,
                 'objdesc'    => _AM_XBS_MODGEN_TBL_MENUDESC,
                 'objloc'     => _AM_XBS_MODGEN_TBL_MENULOC,
                 'objoptions' => _AM_XBS_MODGEN_TBL_MENUOPT,
    ];

    adminEditObject($modid, $id, $frmTitle, $frmNames, $pgName, $menuType);
}//end function

/**
 * Select a menu to edit
 *
 * @param string $menuType type of menu 'amenu' or 'umenu'
 */
function adminSelectMenu($menuType)
{
    //Make sure user has selected a module

    if (!isset($_SESSION['xbs_modgen_mod'])) {
        redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, _AM_XBS_MODGEN_ADMINMSG3);
    }

    //check menutype

    if ('amenu' == $menuType) {
        $pgName = 'admenu4.php';

        $lTitle = _AM_XBS_MODGEN_ALFORM;
    } elseif ('umenu' == $menuType) {
        $pgName = 'admenu5.php';

        $lTitle = _AM_XBS_MODGEN_ULFORM;
    } else {
        redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, sprintf(_AM_XBS_MODGEN_ADMINERR9, 'adminSelectMenu()'));
    }

    //Check to see if there are any menu records created yet.

    // If not then display a menu details input form

    // else allow user to select a menu

    $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Xbsobject');

    if (0 == $objHandler->countTypeObjects($_SESSION['xbs_modgen_mod'], $menuType)) {
        adminEditMenu($_SESSION['xbs_modgen_mod'], $menuType);
    } else {
        // Column name list

        $cols = [_AM_XBS_MODGEN_TBL_MENUID, _AM_XBS_MODGEN_TBL_MENUNAME, _AM_XBS_MODGEN_TBL_MENUDESC];

        //Table name

        $moduleHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

        $mod = $moduleHandler->get($_SESSION['xbs_modgen_mod']);

        $tname = sprintf($lTitle, $mod->getVar('modname'));

        //create menu selection list form

        $fcfg = new Form\FormTable($cols, $tname, true, XBS_MODGEN_URL . '/admin/' . $pgName . '?op=new', XBS_MODGEN_URL . '/admin/' . $pgName . '?op=edit&id=', XBS_MODGEN_URL . '/admin/' . $pgName . '?op=del&id=');

        //add data rows to it

        $objs = $objHandler->getTypeObjects($_SESSION['xbs_modgen_mod'], $menuType);

        $row = [];

        foreach ($objs as $obj) {
            $row[] = $obj->getVar('id');

            $row[] = $obj->getVar('objname');

            $row[] = $obj->getVar('objdesc');

            $fcfg->addRow($row);

            unset($row);
        }

        //and display

        $fcfg->display();
    }
}//end function

/**
 * Function: Save menu details
 *
 * Save menu definition to database
 *
 * @param array  $data     array of key => value pairs of data items to save
 * @param string $menuType type of menu 'amenu' or 'umenu'
 * @return int New table internal identifier (0 if failure)
 * @version 1
 */
function adminSaveMenu($data, $menuType)
{
    //check menutype

    if ('amenu' == $menuType) {
        $pgName = 'admenu4.php';
    } elseif ('umenu' == $menuType) {
        $pgName = 'admenu5.php';
    } else {
        redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, sprintf(_AM_XBS_MODGEN_ADMINERR9, 'adminSaveMenu()'));
    }

    if (checkRequest($pgName)) {
        //process the request

        $id = (int)$data['id'];

        //create config item object

        $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Xbsobject');

        if (0 != $id) {
            $obj = $objHandler->get($id);
        } else {
            $obj = $objHandler->create();

            $data['id'] = '0';
        }

        $obj->setVars($data);

        //make sure that data is valid

        if ($obj->validateData()) {
            if ($objHandler->insert($obj)) {
                return (int)$obj->getVar('id');
            }

            redirect_header(XBS_MODGEN_URL . '/admin/' . $pgName, 5, sprintf(_AM_XBS_MODGEN_ADMINERR4, $objHandler->getError()));
        } else {
            redirect_header(XBS_MODGEN_URL . '/admin/' . $pgName, 5, sprintf(_AM_XBS_MODGEN_ADMINERR3, $obj->getHtmlErrors()));
        }
    } //else do nothing and return to form without informing user

    // we don't say anything so as not to give anything away to potential hackers

    redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, (XBS_MODGEN_DEBUG ? 'Invalid Requesting URL' : ''));
}//end function

/**
 * Delete a menu description
 *
 * @param int    $id       menu internal identifier
 * @param string $menuType menu type 'amenu' or 'umenu'
 * @return bool true if delete succesful
 */
function adminDelMenu($id, $menuType)
{
    //check menutype

    if ('amenu' == $menuType) {
        $pgName = 'admenu4.php';
    } elseif ('umenu' == $menuType) {
        $pgName = 'admenu5.php';
    } else {
        redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, sprintf(_AM_XBS_MODGEN_ADMINERR9, 'adminDelMenu()'));
    }

    return adminDelObject($id, $pgName, 'Xbsobject');
}//end function

/**
 * Edit a block object
 *
 * @param int $modid Module internal identifier
 * @param int $id    block internal identifier
 */
function adminEditBlock($modid, $id = 0)
{
    $pgName = 'admenu6.php';

    $frmTitle = _AM_XBS_MODGEN_BLKEDITFORM;

    $frmNames = ['modid' => _AM_XBS_MODGEN_TBL_BLKMODID, 'id' => _AM_XBS_MODGEN_TBL_BLKID, 'objtype' => _AM_XBS_MODGEN_TBL_BLKTYPE, 'objname' => _AM_XBS_MODGEN_TBL_BLKNAME, 'objdesc' => _AM_XBS_MODGEN_TBL_BLKDESC, 'objloc' => _AM_XBS_MODGEN_TBL_BLKLOC, 'objoptions' => _AM_XBS_MODGEN_TBL_BLKOPT];

    adminEditObject($modid, $id, $frmTitle, $frmNames, $pgName, 'bscript');
}//end function

/**
 * Select a block to edit
 */
function adminSelectBlock()
{
    //Make sure user has selected a module

    if (!isset($_SESSION['xbs_modgen_mod'])) {
        redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, _AM_XBS_MODGEN_ADMINMSG3);
    }

    $pgName = 'admenu6.php';

    $lTitle = _AM_XBS_MODGEN_BLKFORM;

    //Check to see if there are any block records created yet.

    // If not then display a menu details input form

    // else allow user to select a menu

    $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Xbsobject');

    if (0 == $objHandler->countTypeObjects($_SESSION['xbs_modgen_mod'], 'bscript')) {
        adminEditBlock($_SESSION['xbs_modgen_mod']);
    } else {
        // Column name list

        $cols = [_AM_XBS_MODGEN_TBL_BLKID, _AM_XBS_MODGEN_TBL_BLKNAME, _AM_XBS_MODGEN_TBL_BLKDESC];

        //Table name

        $moduleHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

        $mod = $moduleHandler->get($_SESSION['xbs_modgen_mod']);

        $tname = sprintf($lTitle, $mod->getVar('modname'));

        //create block selection list form

        $fcfg = new Form\FormTable($cols, $tname, true, XBS_MODGEN_URL . '/admin/' . $pgName . '?op=new', XBS_MODGEN_URL . '/admin/' . $pgName . '?op=edit&id=', XBS_MODGEN_URL . '/admin/' . $pgName . '?op=del&id=');

        //add data rows to it

        $objs = $objHandler->getTypeObjects($_SESSION['xbs_modgen_mod'], 'bscript');

        $row = [];

        foreach ($objs as $obj) {
            $row[] = $obj->getVar('id');

            $row[] = $obj->getVar('objname');

            $row[] = $obj->getVar('objdesc');

            $fcfg->addRow($row);

            unset($row);
        }

        //and display

        $fcfg->display();
    }
}//end function

/**
 * Function: Save block details
 *
 * Save block definition to database
 *
 * @param array $data array of key => value pairs of data items to save
 * @return int New block internal identifier (0 if failure)
 * @version 1
 */
function adminSaveBlock($data)
{
    if (checkRequest('admenu6.php')) {
        //process the request

        $id = (int)$data['id'];

        //create config item object

        $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Xbsobject');

        if (0 != $id) {
            $obj = $objHandler->get($id);
        } else {
            $obj = $objHandler->create();

            $data['id'] = '0';
        }

        $obj->setVars($data);

        //make sure that data is valid

        if ($obj->validateData()) {
            if ($objHandler->insert($obj)) {
                return (int)$obj->getVar('id');
            }

            redirect_header(XBS_MODGEN_URL . '/admin/admenu6.php', 5, sprintf(_AM_XBS_MODGEN_ADMINERR4, $objHandler->getError()));
        } else {
            redirect_header(XBS_MODGEN_URL . '/admin/admenu6.php', 5, sprintf(_AM_XBS_MODGEN_ADMINERR3, $obj->getHtmlErrors()));
        }
    } //else do nothing and return to form without informing user

    // we don't say anything so as not to give anything away to potential hackers

    redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, (XBS_MODGEN_DEBUG ? 'Invalid Requesting URL' : ''));
}//end function

/**
 * Delete a block description
 *
 * @param int $id block internal identifier
 * @return bool true if delete succesful
 */
function adminDelBlock($id)
{
    return adminDelObject($id, 'admenu6.php', 'Xbsobject');
}//end function
