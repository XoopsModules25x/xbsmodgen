<?php declare(strict_types=1);

/**
 * Constant definitions that are module specific.
 *
 * Definitions in this file conform to the Xoops standard for the modinfo.php file
 *
 * @package       XBS_MODGEN
 * @subpackage    Definitions
 * @version       1.5
 * @access        private
 * @copyright     Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
 */

/**
 * The name of this module
 */
define('_MI_XBSMODGEN_NAME', 'XBS Module Generator');

/**
 *  A brief description of this module
 */
define('_MI_XBSMODGEN_DESC', 'Creates a new \Xoops module shell.  Takes away a lot of tedious work for mod devs.');

/**#@+
 * Configuration item names and descriptions
 */
define('_MI_XBSMODGEN_CFG1NAME', 'Author Name');
define('_MI_XBSMODGEN_CFG1DESC', "Module developer's name");
define('_MI_XBSMODGEN_CFG2NAME', 'License Type');
define('_MI_XBSMODGEN_CFG2DESC', 'Default license type for module');
define('_MI_XBSMODGEN_CFG3NAME', 'Default Language');
define('_MI_XBSMODGEN_CFG3DESC', 'Default language for module');
define('_MI_XBSMODGEN_CFG4NAME', 'Country of Origin');
define('_MI_XBSMODGEN_CFG4DESC', 'Country in which software is developed');
define('_MI_XBSMODGEN_CFG5NAME', 'URL');
define('_MI_XBSMODGEN_CFG5DESC', "URL of author's website");
define('_MI_XBSMODGEN_CFG6NAME', 'Contact Details');
define('_MI_XBSMODGEN_CFG6DESC', 'How to contact the software author');

/**#@-*/

//Help
define('_MI_XBSMODGEN_DIRNAME', basename(dirname(__DIR__, 2)));
define('_MI_XBSMODGEN_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_XBSMODGEN_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_XBSMODGEN_OVERVIEW', 'Overview');

//define('_MI_XBSMODGEN_HELP_DIR', __DIR__);

//help multi-page
define('_MI_XBSMODGEN_DISCLAIMER', 'Disclaimer');
define('_MI_XBSMODGEN_LICENSE', 'License');
define('_MI_XBSMODGEN_SUPPORT', 'Support');
