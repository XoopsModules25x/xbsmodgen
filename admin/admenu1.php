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
 * Module Global Information Page
 *
 * Allows user to create new module or edit existing module details.
 * All other menu tabs work for the module selected here. Current module
 * selection is saved in $_SESSION
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

use XoopsModules\Xbsmodgen\{Utility
};

/**
 * Do all the declarations etc needed by an admin page
 */
require_once __DIR__ . '/admin_header.php';
//require_once __DIR__ . '/adminheader.php';

//Display the admin menu
//xoops_module_admin_menu(1,_AM_XBSMODGEN_ADMENU1);

/**
 * To use this as a template you need to write code to display
 * whatever it is you want displaying between here...
 */

//get POST data and clean it up
$clean = Utility::cleanInput($_POST);

if (isset($clean['edit'])) { //User has selected a module to edit
    Utility::adminEditModule((int)$clean['xbsmodgen_mod']);
} elseif (isset($clean['insert'])) {
    //create a new module

    Utility::adminEditModule();
} elseif (isset($clean['save'])) {
    //store the requesting page URL

    $requrl = $_REQUEST['original_url'] ?? null;

    //user has edited or created a module so save it

    $ret = Utility::adminSaveModule($clean, $requrl);

    if ($ret > 0) {
        //save the module id for later use

        Utility::setSession($ret);

        redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, sprintf(_AM_XBSMODGEN_ADMINMSG1, $ret));
    } else {
        //should never get here as redirection occurs

        // in adminSaveModule on error

        die('Oops - should not have got here - admenu1.php');
    }
} elseif (isset($clean['use'])) {
    //user has selected module to use so show index page

    Utility::setSession($clean['xbsmodgen_mod']);

    redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, sprintf(_AM_XBSMODGEN_ADMINMSG1, (int)$clean['xbsmodgen_mod']));
} elseif (isset($clean['cancel'])) {
    Utility::setSession(0, false);

    redirect_header(XBS_MODGEN_URL . '/admin/adminindex.php', 1, _AM_XBSMODGEN_ADMINERR1);
} else {
    //Present a list of modules to select to work with

    Utility::adminSelectModule();
} //end if

/**
 * and here.
 */
//And put footer in
xoops_cp_footer();
