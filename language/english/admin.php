<?php declare(strict_types=1);

/**
 * Module administration language constant definitions
 *
 * This is the language specific file for UK English language
 *
 * @author     Ashley Kitson http://xoobs.net
 * @copyright  2006 Ashley Kitson, UK
 * @package    XBS_MODGEN
 * @subpackage Definitions
 * @version    1
 * @access     private
 */

/**#@+
 * Constants for Admin menu - non language specific
 */

/**
 * Admin menu parameters
 *
 * These MUST follow the format _AM_<ModDir>_URL_DOCS etc
 * so that the xoops_module_admin_header functions can work.
 * The suffix after <modDir> is not optional!
 * Leave them commented out if you do not have the functionality for your module
 *
 * Relative url from module directory for documentation
 */
define('_AM_XBS_MODGEN_URL_DOCS', 'admin/help.php');
/**
 * Absolute url for module support site
 */
define('_AM_XBS_MODGEN_URL_SUPPORT', 'http://www.xoobs.net/modules/newbb/viewforum.php?forum=2');
/**
 * absolute url for module donations site
 */
//define("_AM_XBS_MODGEN_URL_DONATIONS","");

/**
 * Module configuration option - MUST follow the format _AM_<ModDir>_MODCONFIG
 * Value MUST be "xoops", "module" or "none"
 */
define('_AM_XBS_MODGEN_MODCONFIG', 'xoops');

/**
 * If module configuration option = "module" then define the name of the script
 * to call for module configuration.  This relative to modDir/admin/
 * MUST follow the format _AM_<ModDir>_MODCONFIGURL
 * e.g. define("_AM_XBS_MODGEN_MODCONFIGURL","xbs_modgen_config.php");
 * and define a message that is shown to users prior to redirecting to the config page
 * e.g. define("_AM_XBS_MODGEN_MODCONFIGREDIRECT","Configuration is done via the CDM system. You will shortly be redirected there.")
 */
/**#@-*/

/**#@+
 * Constants for Admin menus - Language specific
 */

// Admin menu breadcrumb
define('_AM_XBS_MODGEN_ADMENU0', 'Modgen Index');
define('_AM_XBS_MODGEN_ADMENU1', 'Module Parameters');
define('_AM_XBS_MODGEN_ADMENU2', 'Module Configs');
define('_AM_XBS_MODGEN_ADMENU3', 'Table Definitions');
define('_AM_XBS_MODGEN_ADMENU4', 'Admin Menu');
define('_AM_XBS_MODGEN_ADMENU5', 'User Menu');
define('_AM_XBS_MODGEN_ADMENU6', 'Blocks');
define('_AM_XBS_MODGEN_ADMENU7', 'Module Generation');

//buttons
define('_AM_XBS_MODGEN_INSERT', 'Insert');
define('_AM_XBS_MODGEN_BROWSE', 'Browse');
define('_AM_XBS_MODGEN_SUBMIT', 'Submit');
define('_AM_XBS_MODGEN_SAVE', 'Save');
define('_AM_XBS_MODGEN_CANCEL', 'Cancel');
define('_AM_XBS_MODGEN_RESET', 'Reset');
define('_AM_XBS_MODGEN_EDIT', 'Edit');
define('_AM_XBS_MODGEN_GO', 'Go');
define('_AM_XBS_MODGEN_DEL', 'Delete');
define('_AM_XBS_MODGEN_USE', 'Use This Record');

//button labels
define('_AM_XBS_MODGEN_INSERT_DESC', 'Create a new record');
define('_AM_XBS_MODGEN_BUTTONTRAY', 'Click to perform action');

//Error messages
define('_AM_XBS_MODGEN_ADMINERR1', 'Record edit cancelled');
define('_AM_XBS_MODGEN_ADMINERR2', 'Field %s with value %s failed to meet validation %s for object %s');
define('_AM_XBS_MODGEN_ADMINERR3', '<b>Field with failed validation</b><br>%s');
define('_AM_XBS_MODGEN_ADMINERR4', 'Record save failed with errors <br>%s');
define('_AM_XBS_MODGEN_ADMINERR5', 'Record delete failed with errors <br>%s');
define('_AM_XBS_MODGEN_ADMINERR6', 'Failed to load module data (modid = %u)');
define('_AM_XBS_MODGEN_ADMINERR7', 'Target directory does not exists');
define('_AM_XBS_MODGEN_ADMINERR8', 'Unable to create module directory');
define('_AM_XBS_MODGEN_ADMINERR9', 'Invalid menu type in call to %s');
define('_AM_XBS_MODGEN_ADMINERR10', 'Unable to change owner for file %s');

//Other messages
define('_AM_XBS_MODGEN_ADMINMSG1', 'Current module (id = %u) set');
define('_AM_XBS_MODGEN_ADMINMSG2', "Current module is '%s' (id = %u)");
define('_AM_XBS_MODGEN_ADMINMSG3', 'No module selected, please choose one');
define('_AM_XBS_MODGEN_ADMINMSG4', 'Config item saved');
define('_AM_XBS_MODGEN_ADMINMSG5', 'Config item deleted');
define('_AM_XBS_MODGEN_ADMINMSG6', 'Success - scripts generated');

//Form Labels - general
define('_AM_XBS_MODGEN_REQFLD', '* indicates required field');
define('_AM_XBS_MODGEN_ACTIONCOL', 'Action');

//Form labels - module selection
define('_AM_XBS_MODGEN_MODFORM', 'Module Selection');
define('_AM_XBS_MODGEN_SELMOD', 'Select a module');

//Form labels - module edit
define('_AM_XBS_MODGEN_MODEDITFORM', 'Module Global Parameters');
define('_AM_XBS_MODGEN_TBL_MODID', 'Module Id');
define('_AM_XBS_MODGEN_TBL_MODNAME', 'Module Name');
define('_AM_XBS_MODGEN_TBL_MODTAG', 'Module Tagname');
define('_AM_XBS_MODGEN_TBL_MODHASADMIN', 'Has admin menu?');
define('_AM_XBS_MODGEN_TBL_MODHASUSERSIDE', 'Has user menu?');
define('_AM_XBS_MODGEN_TBL_MODHASSEARCH', 'Has module search?');
define('_AM_XBS_MODGEN_TBL_MODHASNOTIFICATION', 'Has module notification?');
define('_AM_XBS_MODGEN_TBL_MODHASCOMMENTS', 'Has module comments?');
define('_AM_XBS_MODGEN_TBL_MODDIR', 'Module Directory');
define('_AM_XBS_MODGEN_TBL_MODDESC', 'Module Description');
define('_AM_XBS_MODGEN_TBL_MODCREDITS', 'Module Credits');
define('_AM_XBS_MODGEN_TBL_MODTARGETDIR', 'Target build root directory');
define('_AM_XBS_MODGEN_TBL_MODLASTGEN', 'Last generated');
define('_AM_XBS_MODGEN_TBL_MODFOWNER', 'File owner (your logon name)');

//Form labels - config list
define('_AM_XBS_MODGEN_TBL_CFGLTNAME', 'Config items for module %s');
define('_AM_XBS_MODGEN_TBL_CFGLID', 'Config Id');
define('_AM_XBS_MODGEN_TBL_CFGLNAME', 'Config Name');
define('_AM_XBS_MODGEN_TBL_CFGLDESC', 'Config Description');

//Form labels - config edit
define('_AM_XBS_MODGEN_CFGEDITFORM', 'Module Configuration Item');
define('_AM_XBS_MODGEN_TBL_CFGMODID', 'Module Id');
define('_AM_XBS_MODGEN_TBL_CFGID', 'Config item Id');
define('_AM_XBS_MODGEN_TBL_CFGNAME', 'Item name');
define('_AM_XBS_MODGEN_TBL_CFGDESC', 'Item description');
define('_AM_XBS_MODGEN_TBL_CFGFTYPE', 'Form Type');
define('_AM_XBS_MODGEN_TBL_CFGFVAL', 'Value Type');
define('_AM_XBS_MODGEN_TBL_CFGFLEN', 'Field Length');
define('_AM_XBS_MODGEN_TBL_CFGFDEF', 'Default value');
define('_AM_XBS_MODGEN_TBL_CFGFOPT', 'Options');

//Form Labels - table edit and list forms
define('_AM_XBS_MODGEN_TBLEDITFORM', 'Table Definition');
define('_AM_XBS_MODGEN_TBL_TBLMODID', 'Module Id');
define('_AM_XBS_MODGEN_TBL_TBLID', 'Table Id');
define('_AM_XBS_MODGEN_TBL_TBLNAME', 'Table Name');
define('_AM_XBS_MODGEN_TBL_TBLDESC', 'Description');
define('_AM_XBS_MODGEN_TBL_TBLSCRIPT', 'Table Create Script');
define('_AM_XBS_MODGEN_TBL_TBLTYPE', 'Object Type');
define('_AM_XBS_MODGEN_TBL_TBLLOC', 'Location');
define('_AM_XBS_MODGEN_TBL_TBLNOTE', 'Enter table SQL create script but please replace the actual table name with {TABLENAME}');
define('_AM_XBS_MODGEN_TBL_TBLLTNAME', 'Tables for module %s');

//Form labels - menu edit and list forms
define('_AM_XBS_MODGEN_AMENEDITFORM', 'Admin Menu Definition');
define('_AM_XBS_MODGEN_UMENEDITFORM', 'User Menu Definition');
define('_AM_XBS_MODGEN_ALFORM', 'Admin Menu items for module %s');
define('_AM_XBS_MODGEN_ULFORM', 'User Menu items for module %s');

define('_AM_XBS_MODGEN_TBL_MENUMODID', 'Module Id');
define('_AM_XBS_MODGEN_TBL_MENUID', 'Menu Id');
define('_AM_XBS_MODGEN_TBL_MENUNAME', 'Short Menu Name');
define('_AM_XBS_MODGEN_TBL_MENUDESC', 'Menu Description');
define('_AM_XBS_MODGEN_TBL_MENUOPT', 'Unused');
define('_AM_XBS_MODGEN_TBL_MENUTYPE', 'Menu Type');
define('_AM_XBS_MODGEN_TBL_MENULOC', 'Location');

//Form labels - block edit and list forms
define('_AM_XBS_MODGEN_BLKEDITFORM', 'Block Definition');
define('_AM_XBS_MODGEN_BLKFORM', 'Blocks for module %s');
define('_AM_XBS_MODGEN_TBL_BLKMODID', 'Module Id');
define('_AM_XBS_MODGEN_TBL_BLKID', 'Block Id');
define('_AM_XBS_MODGEN_TBL_BLKNAME', 'Short Block Name');
define('_AM_XBS_MODGEN_TBL_BLKDESC', 'Block Description');
define('_AM_XBS_MODGEN_TBL_BLKOPT', "Block config options  (opt1=value|opt2='value')");
define('_AM_XBS_MODGEN_TBL_BLKTYPE', 'Item Type');
define('_AM_XBS_MODGEN_TBL_BLKLOC', 'Location');

//Form labels - module review screen
define('_AM_XBS_MODGEN_RVW_MODDETS', 'Module Global Parameters');
define('_AM_XBS_MODGEN_RVW_MODCFGS', 'Module Configuration Items');
define('_AM_XBS_MODGEN_RVW_MODTBLE', 'Module Tables');
define('_AM_XBS_MODGEN_RVW_MODAMEN', 'Module Admin Menu Items');
define('_AM_XBS_MODGEN_RVW_MODUMEN', 'Module User Menu Items');
define('_AM_XBS_MODGEN_RVW_MODBLKS', 'Module Blocks');
define('_AM_XBS_MODGEN_RVW_MODBUTN', 'Click to generate module');

//script generation constants
define('_AM_XBS_MODGEN_SCR_XVERDESC', 'This file conforms to the Xoops standard for the xoops_version.php file. Constant declarations beginning _MI_ are contained in language/../modinfo.php');
define('_AM_XBS_MODGEN_SCR_MTAGDESC', 'XBS MetaTags information file');
define('_AM_XBS_MODGEN_SCR_HEADDESC', 'Module Header file');
define('_AM_XBS_MODGEN_SCR_INSTDESC', 'Module installation helper functions');
define('_AM_XBS_MODGEN_SCR_AMENUDESC', 'Administration menu description');
define('_AM_XBS_MODGEN_SCR_ADMINDESC', 'Module administration non language and language constant definitions');
define('_AM_XBS_MODGEN_SCR_ADMIN2DESC', 'Module administration language constant definitions');
define('_AM_XBS_MODGEN_SCR_DEFINESDESC', 'Non language specific constant definitions');
define('_AM_XBS_MODGEN_SCR_UFUNCDESC', 'General purpose module functions');
define('_AM_XBS_MODGEN_SCR_AFUNCDESC', 'Administration functions');
define('_AM_XBS_MODGEN_SCR_COMMENTSDESC', 'Xoops comment system integration');
define('_AM_XBS_MODGEN_SCR_NOTIFYDESC', 'Xoops notification system integration');
define('_AM_XBS_MODGEN_SCR_SEARCHDESC', 'Xoops search system integration');
define('_AM_XBS_MODGEN_SCR_AINDXDESC', 'Administration index page');
define('_AM_XBS_MODGEN_SCR_HELPDESC', 'Administration help page');
define('_AM_XBS_MODGEN_SCR_ADHEADDESC', 'Administration pages header script');
define('_AM_XBS_MODGEN_SCR_UMENUDESC', "Userside menu option:\n * %s");
define('_AM_XBS_MODGEN_SCR_AMENU2DESC', "Admin menu option:\n * %s");
define('_AM_XBS_MODGEN_SCR_UINDXDESC', 'Userside main page');
define('_AM_XBS_MODGEN_SCR_BLOCKDESC', "Block script:\n * %s");

/**#@-*/
