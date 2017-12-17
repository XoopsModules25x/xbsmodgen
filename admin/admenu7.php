<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://xoops.org/>                             //
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
 * Module generation page
 *
 * @author     Ashley Kitson http://xoobs.net
 * @copyright  2006 Ashley Kitson, UK
 * @package    XBS_MODGEN
 * @subpackage Admin
 * @version    1
 * @access     private
 */

/**
 * @global array Form Post variables
 */
include_once __DIR__ . '/admin_header.php';
global $_POST;
/**
 * @global array User Session variables
 */
global $_SESSION;
/**
 * Do all the declarations etc needed by an admin page
 */
include_once __DIR__ . '/adminheader.php';

//check to see if we have a selected module to work with
if (!isset($_SESSION['xbs_modgen_mod'])) {
    //redirect to module choosing page
    redirect_header(XBS_MODGEN_URL . '/admin/admenu1.php', 1, _AM_XBS_MODGEN_ADMINMSG3);
}
//Display the admin menu
//xoops_module_admin_menu(7,_AM_XBS_MODGEN_ADMENU7);

//get POST data and clean it up
$clean = cleanInput($_POST);

if (isset($clean['submit'])) {
    //store the requesting page URL
    if (isset($_REQUEST['original_url'])) {
        $requrl = $_REQUEST['original_url'];
    } else {
        $requrl = null;
    }
    //user has clicked GO so generate module scripts
    adminGenerateModule($_SESSION['xbs_modgen_mod'], $requrl);
} else {
    //display module review screen
    adminReviewModule($_SESSION['xbs_modgen_mod']);
}//end if

//And put footer in
xoops_cp_footer();
