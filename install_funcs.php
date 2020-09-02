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
 * Module install, uninstall and update scripts
 *
 * Callback functions that are called during module update, install and delete
 * processing.
 *
 * @copyright     Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
 * @package       XBS_MODGEN
 * @subpackage    Installation
 * @access        private
 */

/**
 * Include module defines
 */
//require_once XOOPS_ROOT_PATH . '/modules/xbsmodgen/include/defines.php';

/**
 * function xoops_module_update_xbs_modgen
 *
 * module update function
 *
 * @param xoopsModule &$module     Handle to current module
 * @param int          $oldVersion version of module prior to update
 * @return bool True if success else False
 * @global xoopsDB xoopsDatabase object
 */
function xoops_module_update_xbs_modgen(&$module, $oldVersion)
{
    global $xoopsDB;

    xbsModGenLogNotify('Updated');

    return true;
}//end function

/**
 * function xoops_module_install_xbs_modgen
 *
 * module install function
 *
 * @param xoopModule &$module Handle to current module
 * @return bool True if success else False
 */
function xoops_module_install_xbs_modgen(&$module)
{
    //The basic SQL install is done via the SQL script

    xbsModGenLogNotify('Install');

    return true;
}//end function

/**
 * function xoops_module_uninstall_xbs_modgen
 *
 * module uninstall function
 *
 * @param xoopModule &$module Handle to current module
 * @return bool True if success else False
 */
function xoops_module_uninstall_xbs_modgen($module)
{
    //remove CDM codes inserted for Modgen

    global $xoopsDB;

    $sql1 = 'delete from ' . $xoopsDB->prefix(xbscdm_code) . " where cd_set like 'XOBJ%'";

    $sql2 = 'delete from ' . $xoopsDB->prefix(xbscdm_meta) . " where cd_set like 'XOBJ%'";

    $ret1 = ($result = $xoopsDB->queryF($sql1));

    $ret2 = ($result = $xoopsDB->queryF($sql2));

    if (!($ret1 && $ret2)) {
        $module->setErrors('Unable to remove ModGen data from CDM tables whilst uninstalling XBS ModGen module');

        return false;
    }

    xbsModGenLogNotify('Uninstall');

    return true;
}//end function
