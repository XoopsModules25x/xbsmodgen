<?php declare(strict_types=1);

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Common admin menu page processing
 *
 * @copyright     Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
 * @package       XBS_MODGEN
 * @subpackage    Admin
 * @version       1
 * @access        private
 */

use XoopsModules\Xbsmodgen\Utility;

//get POST data and clean it up
$clean = Utility::cleanInput($_POST);
//get GET data and clean it up
$clean2 = Utility::cleanInput($_GET);

//input can come from GET or POST
$edit   = false;
$insert = false;
$del    = false;
if (isset($clean2['op'])) {
    if ('edit' == $clean2['op']) {
        $edit = true;
    }

    if ('new' == $clean2['op']) {
        $insert = true;
    }

    if ('del' == $clean2['op']) {
        $del = true;
    }
}
$save   = isset($clean['save']);
$cancel = isset($clean['cancel']);

if (($edit || $insert || $del) && isset($clean2['id'])) {
    $id = (int)$clean2['id'];
} elseif (isset($clean['id'])) {
    $id = (int)$clean['id'];
} else {
    $id = null;
}
