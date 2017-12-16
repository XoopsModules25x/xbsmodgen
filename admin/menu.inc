<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
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
// Copyright: (c) 2006, Ashley Kitson                                        //
// URL:       http://xoobs.net			                                     //
// Project:   The XOOPS Project (http://www.xoops.org/)                      //
// Module:    XBS Modudule Generator (XBS_MODGEN)                            //
// ------------------------------------------------------------------------- //
/**
* Admin menu declaration
*
* This script conforms to the Xoops standard for admin/menu.php
*
* @author Ashley Kitson http://xoobs.net
* @copyright 2005 Ashley Kitson, UK
* @package XBS_MODGEN
* @subpackage Admin
* @version 1
* @access private
*/

/**
 * @global Xoops Configuration Object
 */
global $xoopsConfig;

if ( file_exists( XOOPS_ROOT_PATH."/modules/xbs_modgen/language/" . $xoopsConfig['language'] . "/admin.php" ) ) {
	/**
 	* Include menu language definitions
 	*/
    include_once XOOPS_ROOT_PATH."/modules/xbs_modgen/language/" . $xoopsConfig['language'] . "/admin.php";
}
elseif ( file_exists( XOOPS_ROOT_PATH."/modules/xbs_modgen/language/english/admin.php" ) ) {
	/**
	 * @ignore 
	 */
    include_once XOOPS_ROOT_PATH."/modules/xbs_modgen/language/english/admin.php";
}
/**
* Whilst you can link your menu options to a single file, typically admin/index.php
* and use a switch statement on a variable passed to it from here, to keep things
* simple, use one script per menu option;
*/
$adminmenu[1]['title'] = _AM_XBS_MODGEN_ADMENU1;
$adminmenu[1]['link'] = "admin/admenu1.php";
$adminmenu[2]['title'] = _AM_XBS_MODGEN_ADMENU2;
$adminmenu[2]['link'] = "admin/admenu2.php";
$adminmenu[3]['title'] = _AM_XBS_MODGEN_ADMENU3;
$adminmenu[3]['link'] = "admin/admenu3.php";
$adminmenu[4]['title'] = _AM_XBS_MODGEN_ADMENU4;
$adminmenu[4]['link'] = "admin/admenu4.php";
$adminmenu[5]['title'] = _AM_XBS_MODGEN_ADMENU5;
$adminmenu[5]['link'] = "admin/admenu5.php";
$adminmenu[6]['title'] = _AM_XBS_MODGEN_ADMENU6;
$adminmenu[6]['link'] = "admin/admenu6.php";
$adminmenu[7]['title'] = _AM_XBS_MODGEN_ADMENU7;
$adminmenu[7]['link'] = "admin/admenu7.php";
?>