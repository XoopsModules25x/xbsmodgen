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
// URL:       http://xoobs.net			                                     //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    XBS Module Generator (XBS_MODGEN)                              //
// ------------------------------------------------------------------------- //
/**
* Common admin menu page processing
*
* @author Ashley Kitson http://xoobs.net
* @copyright 2006 Ashley Kitson, UK
* @package XBS_MODGEN
* @subpackage Admin
* @version 1
* @access private
*/

//get POST data and clean it up
$clean = cleanInput($_POST);
//get GET data and clean it up
$clean2 = cleanInput($_GET);

//input can come from GET or POST
$edit = false;
$insert = false;
$del = false;
if (isset($clean2['op'])) {
	if ('edit' == $clean2['op']) $edit = true;
	if ('new' == $clean2['op']) $insert = true;
	if ('del' == $clean2['op']) $del = true;
}
$save = isset($clean['save']);
$cancel = isset($clean['cancel']);

if (($edit || $insert || $del) && isset($clean2['id'])) {
	$id = (int)$clean2['id'];
} elseif (isset($clean['id'])) {
	$id = (int)$clean['id'];
} else {
	$id = null;
}
