<?php declare(strict_types=1);

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
// URL:       http://xoobs.net                                               //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    XBS Module Generator (XBS_MODGEN)                              //
// ------------------------------------------------------------------------- //
/**
 * Module Global Information Page
 *
 * Allows user to create new module or edit existing module details.
 * All other menu tabs work for the module selected here. Current module
 * selection is saved in $_SESSION
 *
 * @author     Ashley Kitson http://xoobs.net
 * @copyright  2006 Ashley Kitson, UK
 * @package    XBS_MODGEN
 * @subpackage Admin
 * @version    1
 * @access     private
 */

/**
 * Do all the declarations etc needed by an admin page
 */
require_once __DIR__ . '/admin_header.php';
//require_once __DIR__ . '/adminheader.php';

//Display the admin menu
//xoops_module_admin_menu(1,_AM_XBS_MODGEN_ADMENU1);

/**
 * To use this as a template you need to write code to display
 * whatever it is you want displaying between here...
 */

//get POST data and clean it up
$clean = cleanInput($_POST);

if (isset($clean['edit'])) { //User has selected a module to edit
    adminEditModule((int)$clean['xbs_modgen_mod']);
} elseif (isset($clean['insert'])) {
    //create a new module

    adminEditModule();
} elseif (isset($clean['save'])) {
    //store the requesting page URL

    $requrl = $_REQUEST['original_url'] ?? null;

    //user has edited or created a module so save it

    $ret = adminSaveModule($clean, $requrl);

    if ($ret > 0) {
        //save the module id for later use

        setSession($ret);

        redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, sprintf(_AM_XBS_MODGEN_ADMINMSG1, $ret));
    } else {
        //should never get here as redirection occurs

        // in adminSaveModule on error

        die('Oops - should not have got here - admenu1.php');
    }
} elseif (isset($clean['use'])) {
    //user has selected module to use so show index page

    setSession($clean['xbs_modgen_mod']);

    redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, sprintf(_AM_XBS_MODGEN_ADMINMSG1, (int)$clean['xbs_modgen_mod']));
} elseif (isset($clean['cancel'])) {
    setSession(0, false);

    redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, _AM_XBS_MODGEN_ADMINERR1);
} else {
    //Present a list of modules to select to work with

    adminSelectModule();
} //end if

/**
 * and here.
 */
//And put footer in
xoops_cp_footer();
