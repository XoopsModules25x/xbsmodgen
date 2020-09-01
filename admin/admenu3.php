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
 * Table definitions for module
 *
 * Initially displays a list of tables for the module
 * and allows user to add, edit or delete them
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

//check to see if we have a selected module to work with
if (!isset($_SESSION['xbs_modgen_mod'])) {
    //redirect to module choosing page

    redirect_header(XBS_MODGEN_URL . '/admin/admenu1.php', 1, _AM_XBSMODGEN_ADMINMSG3);
}

//Display the admin menu
//xoops_module_admin_menu(3,_AM_XBSMODGEN_ADMENU3);

/**
 * To use this as a template you need to write code to display
 * whatever it is you want displaying between here...
 */

/**
 * admin menu common processing
 */
require __DIR__ . '/common.php';

if ($edit) { //User has selected a table to edit
    adminEditTable($_SESSION['xbs_modgen_mod'], $id);
} elseif ($insert) {
    //create a new table item

    adminEditTable($_SESSION['xbs_modgen_mod']);
} elseif ($save) {
    //user has edited or created a config so save it

    $ret = adminSaveTable($clean);

    if ($ret > 0) {
        redirect_header(XBS_MODGEN_URL . '/admin/admenu3.php', 1, _AM_XBSMODGEN_ADMINMSG4);
    } else {
        //should never get here as redirection occurs

        // in adminSaveTable on error

        die('Oops - should not have got here #1 - admenu3.php');
    }
} elseif ($del) {
    if (adminDelTable($id)) {
        redirect_header(XBS_MODGEN_URL . '/admin/admenu3.php', 1, _AM_XBSMODGEN_ADMINMSG5);
    } else {
        //should never get here as redirection occurs

        // in adminDelTable on error

        die('Oops - should not have got here #2 - admenu3.php');
    }
} elseif ($cancel) {
    redirect_header(XBS_MODGEN_URL . '/admin/admenu3.php', 1, _AM_XBSMODGEN_ADMINERR1);
} else {
    //Present a list of tables for the module to select to work with

    adminSelectTable();
} //end if

/**
 * and here.
 */
//And put footer in
xoops_cp_footer();
