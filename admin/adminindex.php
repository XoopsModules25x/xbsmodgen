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
 * Admin index page
 *
 * Displays last generated module information
 *
 * @copyright (c) 2004, Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
 * @package       XBS_MODGEN
 * @subpackage    Admin
 * @version       1
 * @access        private
 */

/**
 * Do all the declarations etc needed by an admin page
 */

use XoopsModules\Xbsmodgen\Helper;

require_once __DIR__ . '/admin_header.php';

//Display the admin menu
//xoops_module_admin_menu(0, _AM_XBSMODGEN_ADMENU0);

//get a module handler
$moduleHandler = Helper::getInstance()->getHandler('Module');
//get current module name
if (isset($_SESSION['xbsmodgen_mod'])) {
    $mod = $moduleHandler->get($_SESSION['xbsmodgen_mod']);

    $modNameMsg = sprintf(_AM_XBSMODGEN_ADMINMSG2, $mod->getVar('modname'), $_SESSION['xbsmodgen_mod']);
} else {
    $modNameMsg = _AM_XBSMODGEN_ADMINMSG3;
}
//get module generation message to display to user
$modGenMsg = $moduleHandler->getLastGen();
echo "<div align=center><p>$modNameMsg<br><p>$modGenMsg</div>";
unset($moduleHandler);
unset($mod);

//And put footer in
xoops_cp_footer();
