<?php declare(strict_types=1);

namespace XoopsModules\Xbsmodgen;

use XoopsModules\Xbscdm;

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
 * Base class definitions
 *
 * @author     Ashley Kitson (http://xoobs.net)
 * @copyright  2006 Ashley Kitson, UK
 * @package    XBS_MODGEN
 * @subpackage Base
 * @access     public
 */
/**
 * Require CDM objects so we can extend them
 */

/**
 * Data container class for a Modgen Module
 *
 * @package    XBS_MODGEN
 * @subpackage Base
 * @access     public
 */
class Module extends ModgenObject
{
    public function __construct()
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, true, null, null, _AM_XBSMODGEN_TBL_MODID, XBS_FRM_TEXTBOX, '10', XBS_PAT_INT);

        $this->initVar('modname', XOBJ_DTYPE_TXTBOX, null, true, 40, null, _AM_XBSMODGEN_TBL_MODNAME, XBS_FRM_TEXTBOX, '40', XBS_PAT_TEXT);

        $this->initVar('modtag', XOBJ_DTYPE_TXTBOX, null, true, 10, null, _AM_XBSMODGEN_TBL_MODTAG, XBS_FRM_TEXTBOX, '10', XBS_PAT_TEXT);

        $this->initVar('moddesc', XOBJ_DTYPE_TXTAREA, null, false, 40, null, _AM_XBSMODGEN_TBL_MODDESC, XBS_FRM_TEXTAREA, '5,50', XBS_PAT_TEXT);

        $this->initVar('modcredits', XOBJ_DTYPE_TXTAREA, null, false, 40, null, _AM_XBSMODGEN_TBL_MODCREDITS, XBS_FRM_TEXTAREA, '5,50', XBS_PAT_TEXT);

        $this->initVar('hasadmin', XOBJ_DTYPE_INT, 1, true, null, null, _AM_XBSMODGEN_TBL_MODHASADMIN, XBS_FRM_RADIOYN, null, XBS_PAT_BOOLINT);

        $this->initVar('hasuserside', XOBJ_DTYPE_INT, 1, true, null, null, _AM_XBSMODGEN_TBL_MODHASUSERSIDE, XBS_FRM_RADIOYN, null, XBS_PAT_BOOLINT);

        $this->initVar('hassearch', XOBJ_DTYPE_INT, 0, true, null, null, _AM_XBSMODGEN_TBL_MODHASSEARCH, XBS_FRM_RADIOYN, null, XBS_PAT_BOOLINT);

        $this->initVar('hasnotification', XOBJ_DTYPE_INT, 0, true, null, null, _AM_XBSMODGEN_TBL_MODHASNOTIFICATION, XBS_FRM_RADIOYN, null, XBS_PAT_BOOLINT);

        $this->initVar('hascomments', XOBJ_DTYPE_INT, 0, true, null, null, _AM_XBSMODGEN_TBL_MODHASCOMMENTS, XBS_FRM_RADIOYN, null, XBS_PAT_BOOLINT);

        $this->initVar('moddir', XOBJ_DTYPE_TXTBOX, null, true, 10, null, _AM_XBSMODGEN_TBL_MODDIR, XBS_FRM_TEXTBOX, '10', XBS_PAT_TEXT);

        $this->initVar('modtargetdir', XOBJ_DTYPE_TXTBOX, null, true, 255, null, _AM_XBSMODGEN_TBL_MODTARGETDIR, XBS_FRM_TEXTBOX, '50', XBS_PAT_ABSPATH);

        $this->initVar('lastgen', XOBJ_DTYPE_MTIME, null, false, null, null, _AM_XBSMODGEN_TBL_MODLASTGEN, XBS_FRM_DATETIME, null);

        //$this->initVar('fileowner',XOBJ_DTYPE_TXTBOX,null,false,30,null,_AM_XBSMODGEN_TBL_MODFOWNER,XBS_FRM_TEXTBOX,'30',XBS_PAT_TEXT);

        parent::__construct();
    }

    //end function

    /**
     * get contents of a script file
     *
     * @param string $infile name of file (not path)
     * @return string contents of the script
     */
    public function getScriptContents($infile)
    {
        $infile = XBS_MODGEN_SCRIPTPATH . DIRECTORY_SEPARATOR . $infile;

        $fh = fopen($infile, 'rb');

        $contents = fread($fh, filesize($infile));

        fclose($fh);

        return $contents;
    }

    /**
     * Write output to script
     *
     * @param text   $header  script header text
     * @param text   $content script content text
     * @param text   $footer  script footer text
     * @param string $fname   relative path and name of file to write
     */
    public function writeScriptContents($header, $content, $footer, $fname)
    {
        $fh = fopen($fname, 'wb');

        fwrite($fh, $header . "\n" . $content . "\n" . $footer);

        fclose($fh);

        @chmod($fname, 0646);
    }

    //end function

    /**
     * generate variable values for scripts
     *
     * @param string $scriptName name of script variables are for
     * @param string $scriptDesc description of script
     * @param string $subpackage destination subpackage name (phpDocumentor usage)
     * @access private
     * @return array populated script variables
     */
    public function genScriptVars($scriptName, $scriptDesc, $subpackage)
    {
        /**
         * @global this module configuration
         */

        global $xoopsModuleConfig;

        //get the module id

        $modid = $this->getVar('id');

        //get the module tag names

        $tag = mb_strtoupper($this->getVar('modtag'));

        $ltag = mb_strtolower($tag);

        include XBS_MODGEN_SCRIPTPATH . DIRECTORY_SEPARATOR . 'licenses.php';

        //xoops_version config items

        $cfgHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Config');

        $cfgs = $cfgHandler->getAllConfigs($modid);

        $c = 0;

        $cfgline = '';

        $cfgDef = '';

        foreach ($cfgs as $cfg) {
            $cfgline .= "\$modversion['config'][$c]['name'] = '" . $ltag . '_cfg' . $c . "';\n";

            $cfgline .= "\$modversion['config'][$c]['title'] = '_MI_" . $tag . '_CFG' . $c . "NAME';\n";

            $cfgline .= "\$modversion['config'][$c]['description'] = '_MI_" . $tag . '_CFG' . $c . "DESC';\n";

            $cfgline .= "\$modversion['config'][$c]['formtype'] = XOBJ_DTYPE_" . $cfg->getVar('configformtype') . ";\n";

            $cfgline .= "\$modversion['config'][$c]['valuetype'] = '" . $cfg->getVar('configvaltype') . "';\n";

            $cfgline .= "\$modversion['config'][$c]['default'] = '" . $cfg->getVar('configdefault') . "';\n";

            $cfgline .= "\$modversion['config'][$c]['options'] = '" . $cfg->getVar('configoptions') . "';\n\n";

            $cfgDef .= "define('_MI_" . $tag . '_CFG' . $c . "NAME','" . $cfg->getVar('configname') . "');\n";

            $cfgDef .= "define('_MI_" . $tag . '_CFG' . $c . "DESC','" . $cfg->getVar('configdesc') . "');\n";

            $c++;
        }

        //-- Objects --

        $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Xbsobject');

        //sql tables

        $sqlLine = '';

        $tableLine = '';

        $tableDef = '';

        $numObj = $objHandler->countTypeObjects($modid, 'table');

        if ($numObj > 0) {
            $objs = $objHandler->getTypeObjects($modid, 'table');

            $c = 0;

            foreach ($objs as $table) {
                $tableName = $ltag . '_' . $table->getVar('objname');

                $sqlLine .= preg_replace('/{TABLENAME}/', $tableName, $table->getVar('objoptions')) . "\n\n";

                $tableLine .= "\$modversion['tables'][$c] = '$tableName';\n";

                $tableDef .= "/**\n* " . $table->getVar('objname') . " table\n*/\ndefine('" . $tag . '_TBL_' . mb_strtoupper($table->getVar('objname')) . "','" . $tableName . "');\n";

                $c++;
            }
        }

        //admin menu items

        $amenuLine = '';

        $adminMenuDef = '';

        $numObj = $objHandler->countTypeObjects($modid, 'amenu');

        if ($numObj > 0) {
            $objs = $objHandler->getTypeObjects($modid, 'amenu');

            $c = 0;

            foreach ($objs as $menu) {
                $amenuLine .= "\$adminmenu[$c]['title'] = _AM_" . $tag . "_ADMENU$c;\n";

                $amenuLine .= "\$adminmenu[$c]['link'] = 'admin/admenu$c.php';\n";

                $adminMenuDef .= "define('_AM_" . $tag . "_ADMENU$c','" . $menu->getVar('objname') . "');\n";

                $c++;
            }
        }

        //user menu items

        $umenuLine = '';

        $defMenu = '';

        $numObj = $objHandler->countTypeObjects($modid, 'umenu');

        if ($numObj > 0) {
            $objs = $objHandler->getTypeObjects($modid, 'umenu');

            $c = 0;

            foreach ($objs as $menu) {
                $umenuLine .= "\$modversion['sub'][$c]['name'] = _MI_" . $tag . "_UMNAME$c;\n";

                $umenuLine .= "\$modversion['sub'][$c]['url'] = 'umenu$c.php';\n";

                $defMenu .= "define('_MI_" . $tag . '_UMNAME' . $c . "','" . $menu->getVar('objname') . "');\n";

                $c++;
            }
        }

        //blocks

        $blocks = '';

        $defBlocks = '';

        $numObj = $objHandler->countTypeObjects($modid, 'bscript');

        if ($numObj > 0) {
            $objs = $objHandler->getTypeObjects($modid, 'bscript');

            $c = 0;

            foreach ($objs as $blk) {
                $blocks .= "\$modversion['blocks'][$c]['name'] = _MI_" . $tag . "_BLKNAME$c;\n";

                $blocks .= "\$modversion['blocks'][$c]['description'] = _MI_" . $tag . "_BLKDESC$c;\n";

                $blocks .= "\$modversion['blocks'][$c]['file'] = 'block$c.php';\n";

                $blocks .= "\$modversion['blocks'][$c]['show_func'] = 'b_" . $ltag . '_block' . $c . "_show';\n";

                $blocks .= "\$modversion['blocks'][$c]['edit_func'] = 'b_" . $ltag . '_block' . $c . "_edit';\n";

                $blocks .= "\$modversion['blocks'][$c]['template'] = 'b_" . $ltag . '_block' . $c . ".tpl';\n";

                //get any block options and retrieve the value parts

                $opts = $blk->getVar('objoptions');

                if (empty($opts)) {
                    $opts = '';
                } else {
                    $optArr = explode('|', $opts);

                    $opts = '';

                    foreach ($optArr as $value) {
                        $val = explode('=', $value);

                        $opts .= $val[1] . '|';
                    }

                    $opts = rtrim($opts, '|');
                }

                $blocks .= "\$modversion['blocks'][$c]['options'] = '$opts';\n";

                $defBlocks .= "define('_MI_" . $tag . '_BLKNAME' . $c . "','" . $blk->getVar('objname') . "');\n";

                $defBlocks .= "define('_MI_" . $tag . '_BLKDESC' . $c . "','" . $blk->getVar('objdesc') . "');\n";

                $c++;
            }
        }

        //XBS MetaTags

        $metatagline = '';

        $metatagline .= "\$metatags[$c]['module'] = '" . mb_strtoupper($this->getVar('modtag')) . "';\n";

        $metatagline .= "\$metatags[$c]['title'] = 'View values for a code set';\n";

        $metatagline .= "\$metatags[$c]['description'] = 'Allow users to review CDM codes by codeset';\n";

        $metatagline .= "\$metatags[$c]['script_name'] = 'index.php';\n";

        $metatagline .= "\$metatags[$c]['keywords'] = '';\n";

        $metatagline .= "\$metatags[$c]['maxkeys'] = 40;\n";

        $metatagline .= "\$metatags[$c]['minkeylen'] = 5;\n";

        $metatagline .= "\$metatags[$c]['config'] = 'mostorder';\n\n";

        //construct replacement array

        return [
            '{!SCRIPTNAME}'    => $scriptName,
            '{!DATETIME}'      => $this->getCurrentDateTime(),
            '{MODNAME}'        => $this->getVar('modname'),
            '{MODDESC}'        => $this->getVar('moddesc'),
            '{MODDIR}'         => $this->getVar('moddir'),
            '{UMODDIR}'        => mb_strtoupper($this->getVar('moddir')),
            '{UMODTAG}'        => $tag,
            '{LMODTAG}'        => $ltag,
            '{COPYRIGHT}'      => date('Y') . ' ' . $xoopsModuleConfig['xbs_modgen_author'] . ', ' . $xoopsModuleConfig['xbs_modgen_country'],
            '{CONTACT}'        => $xoopsModuleConfig['xbs_modgen_contact'],
            '{LICENSE}'        => $xoopsModuleConfig['xbs_modgen_license'],
            '{LICENSETEXT}'    => 'GPL' == $xoopsModuleConfig['xbs_modgen_license'] ? $gpl : $lgpl,
            '{!SCRIPTDESC}'    => $scriptDesc,
            '{AUTHOR}'         => $xoopsModuleConfig['xbs_modgen_author'],
            '{AUTHURL}'        => $xoopsModuleConfig['xbs_modgen_authurl'],
            '{!PACKAGE}'       => $tag,
            '{!SUBPACKAGE}'    => $subpackage,
            '{!XCFGTABLES}'    => $tableLine,
            '{!XCFGUSERMENU}'  => $umenuLine,
            '{!XCFGADMINMENU}' => $amenuLine,
            '{!XCFGCONFIG}'    => $cfgline,
            '{HASUSERMENU}'    => $this->getVar('hasuserside'),
            '{HASADMINMENU}'   => $this->getVar('hasadmin'),
            '{HASSEARCH}'      => $this->getVar('hassearch'),
            '{HASCOMMENTS}'    => $this->getVar('hascomments'),
            '{HASNOTIFY}'      => $this->getVar('hasnotification'),
            '{!METATAGS}'      => $metatagline,
            '{!SQL}'           => $sqlLine,
            '{!DEFTABLES}'     => $tableDef,
            '{!DEFADMMENU}'    => $adminMenuDef,
            '{!YEAR}'          => date('Y'),
            '{!DEFCONFIG}'     => $cfgDef,
            '{!DEFMENU}'       => $defMenu,
            '{!XCFGBLOCKS}'    => $blocks,
            '{!DEFBLOCKS}'     => $defBlocks,
        ];
    }

    /**
     * Change script specific values for replacement variable array
     *
     * @param        $vars
     * @param string $scriptName name of script variables are for
     * @param        $scriptDesc
     * @param string $subpackage destination subpackage name (phpDocumentor usage)
     * @param int    $counter    a number counter
     * @access private
     */
    public function genChangeVars(&$vars, $scriptName, $scriptDesc, $subpackage, $counter = 0)
    {
        $vars['{!SCRIPTNAME}'] = $scriptName;

        $vars['{!SCRIPTDESC}'] = $scriptDesc;

        $vars['{!SUBPACKAGE}'] = $subpackage;

        $vars['{!COUNTER}'] = $counter;
    }

    /**
     * Replace script variables with actual values
     *
     * @param text  $content script raw text
     * @param array $vars    replacement values
     * @return string instantiated script text
     * @access private
     */
    public function genReplaceVars($content, $vars)
    {
        $search = [];

        $replace = [];

        foreach ($vars as $key => $value) {
            $search[] = "/$key/";

            $replace[] = $value;
        }

        return preg_replace($search, $replace, $content);
    }

    //end function

    /**
     * generate header of a script
     *
     * @param array $repl Replacement script variable array
     * @access private
     * @return string header text
     */
    public function genHeader($repl)
    {
        $contents = $this->getScriptContents('scriptheader.scr');

        return $this->genReplaceVars($contents, $repl);
    }

    //end function

    /**
     * generate footer of script
     * @return string footer text
     * @access private
     */
    public function genFooter()
    {
        return "/*\n * This file was generated by XBS ModGen, (c) 2006 A Kitson, UK. See http://xoobs.net\n * ModGen is a Module Code Generator for the Xoops CMS.  See http://xoops.org\n */\n?>";
    }

    //end function

    /**
     * Generate module scripts
     */
    public function generate()
    {
        /**
         * @global module configuration
         */

        global $xoopsModuleConfig;

        /**
         * @global Xoops database object
         */

        global $xoopsDB;

        //check for script target directory and create if not already existing

        $targetDir = $this->getVar('modtargetdir') . DIRECTORY_SEPARATOR . $this->getVar('moddir');

        if (is_dir($this->getVar('modtargetdir'))) {
            if (!is_dir($targetDir)) {
                //create directory

                if (!mkdir($targetDir, 0757) && !is_dir($targetDir)) {
                    return 2; //unable to create directory
                }
            }

            //find language name

            $sql = 'SELECT conf_id FROM ' . $xoopsDB->prefix('config') . " WHERE conf_name = 'xbs_modgen_lang'";

            if ($result = $xoopsDB->query($sql)) {
                $ret = $xoopsDB->fetchArray($result);

                $sql = 'SELECT confop_name FROM ' . $xoopsDB->prefix('configoption') . ' WHERE conf_id = ' . $ret['conf_id'] . ' AND confop_value = ' . $xoopsDB->quoteString($xoopsModuleConfig['xbs_modgen_lang']);

                if ($result = $xoopsDB->query($sql)) {
                    $ret = $xoopsDB->fetchArray($result);

                    $ret = explode(' ', $ret['confop_name']);

                    $lang = mb_strtolower($ret[count($ret) - 1]);
                } else {
                    $lang = 'english'; //default value
                }
            }

            //create subdirectories

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'admin', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'images', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'blocks', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'class', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'docs', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'include', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'images', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'shots', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'language', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR . $lang, 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'sql', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'templates', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (!mkdir($concurrentDirectory = $targetDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'blocks', 0757) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            //module objecthandler

            $objHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Xbsobject');

            /* Script generation - root directory */

            $footer = $this->genFooter();

            $replVars = $this->genScriptVars('xoops_version.php', _AM_XBSMODGEN_SCR_XVERDESC, 'Installation');

            //xoops_version.php

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('xoops_version.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $targetDir . DIRECTORY_SEPARATOR . 'xoops_version.php');

            //metatags_info.php

            $this->genChangeVars($replVars, 'metatags_info.php', _AM_XBSMODGEN_SCR_MTAGDESC, 'Installation');

            $content = $this->genReplaceVars($this->getScriptContents('metatags_info.scr'), $replVars);

            $this->writeScriptContents('', $content, $footer, $targetDir . DIRECTORY_SEPARATOR . 'metatags_info.php');

            //install_funcs.php

            $this->genChangeVars($replVars, 'install_funcs.php', _AM_XBSMODGEN_SCR_INSTDESC, 'Installation');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('install_funcs.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $targetDir . DIRECTORY_SEPARATOR . 'install_funcs.php');

            //header.php

            $this->genChangeVars($replVars, 'header.php', _AM_XBSMODGEN_SCR_HEADDESC, 'Main');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('header.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $targetDir . DIRECTORY_SEPARATOR . 'header.php');

            //If there is a userside for the module then create an index.php file

            if (1 == (int)$this->getVar('hasuserside')) {
                $this->genChangeVars($replVars, 'index.php', _AM_XBSMODGEN_SCR_UINDXDESC, 'User_Function');

                $header = $this->genHeader($replVars);

                $content = $this->genReplaceVars($this->getScriptContents('umenu.scr'), $replVars);

                $this->writeScriptContents($header, $content, $footer, $targetDir . DIRECTORY_SEPARATOR . 'index.php');
            }

            //user menu scripts - one per option

            if ($objHandler->countTypeObjects($this->getVar('id'), 'umenu') > 0) {
                $objs = $objHandler->getTypeObjects($this->getVar('id'), 'umenu');

                $c = 0;

                foreach ($objs as $menu) {
                    $menuName = "umenu$c.php";

                    $this->genChangeVars($replVars, $menuName, sprintf(_AM_XBSMODGEN_SCR_UMENUDESC, $menu->getVar('objdesc')), 'User_Function');

                    $header = $this->genHeader($replVars);

                    $content = $this->genReplaceVars($this->getScriptContents('umenu.scr'), $replVars);

                    $this->writeScriptContents($header, $content, $footer, $targetDir . DIRECTORY_SEPARATOR . $menuName);

                    $c++;
                }
            }//end if

            //block scripts - one per block definition

            // also block template - one per block definition

            if ($objHandler->countTypeObjects($this->getVar('id'), 'bscript') > 0) {
                $objs = $objHandler->getTypeObjects($this->getVar('id'), 'bscript');

                $c = 0;

                foreach ($objs as $block) {
                    //block script

                    $blockName = "block$c.php";

                    $this->genChangeVars($replVars, $blockName, sprintf(_AM_XBSMODGEN_SCR_BLOCKDESC, $block->getVar('objdesc')), 'Blocks', $c);

                    $header = $this->genHeader($replVars);

                    $content = $this->genReplaceVars($this->getScriptContents('block.scr'), $replVars);

                    $this->writeScriptContents($header, $content, $footer, $targetDir . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR . $blockName);

                    //block template

                    $content = $this->genReplaceVars($this->getScriptContents('mytemplate.scr'), $replVars);

                    $this->writeScriptContents('', $content, '', $targetDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR . 'b_' . mb_strtolower($this->getVar('modtag')) . '_block' . $c . '.tpl');

                    $c++;
                }
            }//end if

            /* Script generation - sql directory */

            //$this->genChangeVars($replVars,'','','');

            $content = $this->genReplaceVars($this->getScriptContents('sql.scr'), $replVars);

            $content = preg_replace("/<br \>/", "\n", $content);

            $content = preg_replace('/&#039;/', "'", $content);

            $this->writeScriptContents('', $content, '', $targetDir . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . $replVars['{LMODTAG}'] . '_mysql.sql');

            /* Script generation - language directory */

            $langDir = $targetDir . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR;

            //admin.php

            $this->genChangeVars($replVars, 'admin.php', _AM_XBSMODGEN_SCR_ADMINDESC, 'Definitions');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('admin.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $langDir . 'admin.php');

            //admin2.php

            $this->genChangeVars($replVars, 'admin2.php', _AM_XBSMODGEN_SCR_ADMIN2DESC, 'Definitions');

            $header = $this->genHeader($replVars);

            $content = $this->getScriptContents('admin2.scr');

            $this->writeScriptContents($header, $content, $footer, $langDir . 'admin2.php');

            //main.php

            $this->genChangeVars($replVars, 'main.php', '', 'Definitions');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('main.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $langDir . 'main.php');

            //modinfo.php

            $this->genChangeVars($replVars, 'modinfo.php', '', 'Definitions');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('modinfo.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $langDir . 'modinfo.php');

            //blocks.php

            $this->genChangeVars($replVars, 'blocks.php', '', 'Definitions');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('blocklang.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $langDir . 'blocks.php');

            /* Script generation - include directory */

            $incDir = $targetDir . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR;

            //defines.php

            $this->genChangeVars($replVars, 'defines.php', _AM_XBSMODGEN_SCR_DEFINESDESC, 'Definitions');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('defines.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $incDir . 'defines.php');

            //functions.php

            $this->genChangeVars($replVars, 'functions.php', _AM_XBSMODGEN_SCR_UFUNCDESC, 'API_Functions');

            $header = $this->genHeader($replVars);

            $content = $this->getScriptContents('ufunctions.scr');

            $this->writeScriptContents($header, $content, $footer, $incDir . 'functions.php');

            //notification.php

            $this->genChangeVars($replVars, 'notification.php', _AM_XBSMODGEN_SCR_NOTIFYDESC, 'Xoops_Integration');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('notification.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $incDir . 'notification.php');

            //comments.php

            $this->genChangeVars($replVars, 'comments.php', _AM_XBSMODGEN_SCR_COMMENTSDESC, 'Xoops_Integration');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('comments.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $incDir . 'comments.php');

            //search.php

            $this->genChangeVars($replVars, 'search.php', _AM_XBSMODGEN_SCR_SEARCHDESC, 'Xoops_Integration');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('search.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $incDir . 'search.php');

            /* Script generation - admin directory */

            $adminDir = $targetDir . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR;

            //adminindex.php

            if (1 == $this->getVar('hasadmin')) {
                $this->genChangeVars($replVars, 'adminindex.php', _AM_XBSMODGEN_SCR_AINDXDESC, 'Admin');

                $header = $this->genHeader($replVars);

                $content = $this->genReplaceVars($this->getScriptContents('adminindex.scr'), $replVars);

                $this->writeScriptContents($header, $content, $footer, $adminDir . 'adminindex.php');
            }

            //menu.php

            $this->genChangeVars($replVars, 'menu.php', _AM_XBSMODGEN_SCR_AMENUDESC, 'Admin');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('menu.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $adminDir . 'menu.php');

            //functions.php

            $this->genChangeVars($replVars, 'functions.php', _AM_XBSMODGEN_SCR_AFUNCDESC, 'API_Functions');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('afunctions.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $adminDir . 'functions.php');

            //adminmenus - one per option

            if ($objHandler->countTypeObjects($this->getVar('id'), 'amenu') > 0) {
                $objs = $objHandler->getTypeObjects($this->getVar('id'), 'amenu');

                $c = 0;

                foreach ($objs as $menu) {
                    $menuName = "admenu$c.php";

                    $this->genChangeVars($replVars, $menuName, sprintf(_AM_XBSMODGEN_SCR_AMENU2DESC, $menu->getVar('objdesc')), 'Admin_Function', $c);

                    $header = $this->genHeader($replVars);

                    $content = $this->genReplaceVars($this->getScriptContents('amenu.scr'), $replVars);

                    $this->writeScriptContents($header, $content, $footer, $adminDir . $menuName);

                    $c++;
                }
            }//end if

            //help.php

            $this->genChangeVars($replVars, 'help.php', _AM_XBSMODGEN_SCR_HELPDESC, 'Help');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('help.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $adminDir . 'help.php');

            //adminheader.php

            $this->genChangeVars($replVars, 'adminheader,inc', _AM_XBSMODGEN_SCR_ADHEADDESC, 'Admin');

            $header = $this->genHeader($replVars);

            $content = $this->genReplaceVars($this->getScriptContents('adminheader.scr'), $replVars);

            $this->writeScriptContents($header, $content, $footer, $adminDir . 'adminheader.php');

            //mytemplate.tpl

            $content = $this->genReplaceVars($this->getScriptContents('mytemplate.scr'), $replVars);

            $this->writeScriptContents('', $content, '', $targetDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'mytemplate.tpl');

            /* Copy standard files */

            //logo

            copy('..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'slogo.png', $targetDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $replVars['{LMODTAG}'] . '_slogo.png');

            @chmod($targetDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $replVars['{LMODTAG}'] . '_slogo.png', 0646);

            //admin images

            copy('..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'left_both.gif', $targetDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'left_both.gif');

            copy('..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'right_both.gif', $targetDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'right_both.gif');

            copy('..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'bg.gif', $targetDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'bg.gif');

            copy('..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'left_both.gif', $targetDir . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'left_both.gif');

            copy('..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'right_both.gif', $targetDir . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'right_both.gif');

            copy('..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'bg.gif', $targetDir . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'bg.gif');

            //index.html to every directory

            $ifname = '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'index.html';

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'index.html');

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'index.html');

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR . 'index.html');

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'index.html');

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'index.html');

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'index.html');

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'index.html');

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'index.html');

            copy($ifname, $langDir . 'index.html');

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR . 'index.html');

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'index.html');

            copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'index.html');

            if (1 != (int)$this->getVar('hasuserside')) {
                copy($ifname, $targetDir . DIRECTORY_SEPARATOR . 'index.html');
            }
        } else {
            return 1; //no target directory
        }

        return 0; //All OK
    }
    //end function
}//end class
