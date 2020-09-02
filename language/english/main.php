<?php declare(strict_types=1);

/**
 * Constant definitions that are language specific rather than module specific
 *
 * Definitions contained in this file conform to the Xoops standard for Language main.php file format
 *
 * @package       XBS_MODGEN
 * @subpackage    Definitions
 * @copyright     Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
 */

/**#@+
 * Language specific definitions
 */
//Message Constants
define('_MD_XBSMODGEN_MSG1', '%s module last generated on %s');
define('_MD_XBSMODGEN_MSG2', 'No modules have yet been generated');

// Error string constants
define('_MD_XBSMODGEN_ERR_1', 'No data for XBS_MODGENobject indexed by %s');
define('_MD_XBSMODGEN_ERR_2', 'Unable to instantiate Xbsobject %s');
define('_MD_XBSMODGEN_ERR_3', 'Unable to reload. Given class is %s. Expected %s');
define('_MD_XBSMODGEN_ERR_4', 'Unable to reload Xbsobject with null key');
define('_MD_XBSMODGEN_ERR_5', 'You must be logged in to edit records');
define('_MD_XBSMODGEN_ERR_6', 'is not a valid value for a code set name');

//SQL file update processing errors and messages
define('_MD_XBSMODGEN_ERR_20', 'SQL file not found at <b>%s</b>');
define('_MD_XBSMODGEN_ERR_21', 'SQL file found at <b>%s</b>.');
define('_MD_XBSMODGEN_ERR_22', '<b>%s</b> is not valid SQL syntax!');
define('_MD_XBSMODGEN_ERR_23', 'SQL command <b>%s</b> executed');
define('_MD_XBSMODGEN_ERR_24', '<b>%s</b> is a reserved table!');

/**#@-*/
