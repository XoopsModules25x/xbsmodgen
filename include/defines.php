<?php declare(strict_types=1);

/*  XBS Modgen Module shell generator for Xoops CMS
    Copyright (C) 2006 Ashley Kitson, UK
    admin at xoobs dot net

    This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/
/**
 * XBS Modgen Module shell generator for Xoops CMS
 *
 * Non language specific definitions for module operation
 *
 * @author     Ashley Kitson (http://xoobs.net)
 * @copyright  2006 Ashley Kitson, UK
 * @package    DEFINITIONS
 * @subpackage Module
 * @access     public
 */

/**
 * @global Current Xoops module object
 */
global $xoopsModule;
/**
 * @global Xoops configuration
 */
global $xoopsConfig;

/**
 * The module directory name
 */
define('XBS_MODGEN_DIR', 'xbsmodgen');

/**#@+
 * Constants for XBS_MODGEN objects
 */

/**
 * Full file path to XBS_MODGEN directory
 */
define('XBS_MODGEN_PATH', XOOPS_ROOT_PATH . '/modules/' . XBS_MODGEN_DIR);
/**
 * URL to XBS_MODGEN
 */
define('XBS_MODGEN_URL', XOOPS_URL . '/modules/' . XBS_MODGEN_DIR);
/**
 * Path to scripts directory
 */
define('XBS_MODGEN_SCRIPTPATH', XBS_MODGEN_PATH . '/language/' . $xoopsConfig['language'] . '/scripts');

/**
 * Turn on or off module specific debug messaging
 *
 * @access private
 */
define('XBS_MODGEN_DEBUG', false);

/**
 * Constant defs for tables used by XBS_MODGEN
 */
/**
 * modules table
 */
define('XBS_MODGEN_TBL_MOD', 'xbs_modgen_module');

/**
 * code objects table
 */
define('XBS_MODGEN_TBL_OBJ', 'xbs_modgen_object');
/**
 * module config options table
 */
define('XBS_MODGEN_TBL_CNF', 'xbs_modgen_config');

/**#@-*/

/**#@+
 * Constants for ModgenObject variable initialisation
 * and used by FormEdit to determine field type to display
 */

define('XBS_FRM_CHECKBOX', 1);
define('XBS_FRM_DATETIME', 2);
define('XBS_FRM_FILE', 3);
define('XBS_FRM_HIDDEN', 4);
define('XBS_FRM_LABEL', 5);
define('XBS_FRM_PASSWORD', 5);
define('XBS_FRM_RADIO', 6);
define('XBS_FRM_RADIOYN', 7);
define('XBS_FRM_SELECT', 8);
define('XBS_FRM_CDMCOUNTRY', 9);
define('XBS_FRM_CDMLANG', 10);
define('XBS_FRM_CDMCURRENCY', 11);
define('XBS_FRM_CDMSELECT', 12);
define('XBS_FRM_TEXTBOX', 13);
define('XBS_FRM_TEXTAREA', 14);
define('XBS_FRM_DATESELECT', 15);
/**#@-*/

/**#@+
 * Some useful data validity patterns
 */
define('XBS_PAT_INT', "/^\d*$/");
define('XBS_PAT_DECIMAL', "/^\d*\.\d*$/");
define('XBS_PAT_BOOLINT', '/^[01]$/');
define('XBS_PAT_TEXT', "/^[.\s\w\W]*$/");
define('XBS_PAT_ABSPATH', "/^[\/a-z][.:a-zA-Z\/]*$/");
/**#@-*/

/**
 * XBS Notify
 */
require_once XBS_MODGEN_PATH . '/include/xbsnotice.php';
