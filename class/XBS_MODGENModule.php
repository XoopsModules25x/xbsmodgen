<?php declare(strict_types=1);

//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://xoops.org>                             //
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
// URL:       http://xoobs.net                                               //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    XBS Module Generator (XBS_MODGEN)                                     //
// ------------------------------------------------------------------------- //
/**
 * XBS Module object handler
 *
 * @package       XBS_MODGEN
 * @subpackage    Module
 * @author        Ashley Kitson http://xoobs.net
 * @copyright (c) 2006 Ashley Kitson, Great Britain
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit('Call to include XBS_MODGENModule.php failed as XOOPS_ROOT_PATH not defined');
}

/**
 * ModGen definitions
 */
require_once XOOPS_ROOT_PATH . '/modules/xbs_modgen/include/defines.php';

/**
 * Modgen common functions
 */
require_once XBS_MODGEN_PATH . '/include/functions.php';

/**
 * ModGen base classes
 */
require_once XBS_MODGEN_PATH . '/class/class.xbs_modgen.base.php';

/**
 * CDM Base classes
 */
require_once CDM_PATH . '/class/class.cdm.base.php';

/**
 * Object handler for XBS_MODGENModule
 *
 * @subpackage XBS_MODGENModule
 * @package    XBS_MODGEN
 */
class Xbs_ModgenXBS_MODGENModuleHandler extends CDMBaseHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db Handle to xoopsDb object
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db); //call ancestor constructor
        $this->classname = 'xbs_modgen_Module';  //set name of object that this handler handles
    }

    /**
     * Create a new module object
     *
     * @access private
     * @return  xbs_modgen_Module object
     */
    public function &_create()
    {
        return new xbs_modgen_Module();
    }

    //end function _create

    /**
     * Returns sql code to get a module data record
     *
     * OVERIDE ancestor
     *
     * @param int    $id       internal id of the object. Internal code is a unique int value.
     * @param string $row_flag default null (get all), Option(CDM_RSTAT_ACT, CDM_RSTAT_DEF, CDM_RSTAT_SUS)
     * @param string $lang     default null (get all), Valid LANGUAGE code.  Will only return object of that language set
     * @return  string SQL string to get data
     */
    public function _get($id, $row_flag, $lang)
    {
        //overide in ancestor and supply the sql string to get the data
        return sprintf('SELECT * FROM %s WHERE id = %u', $this->db->prefix(XBS_MODGEN_TBL_MOD), $id);
    }

    /**
     * Get internal identifier (primary key) based on user visible code
     *
     * @param string $modname Name of module
     * @return int Internal identifier of module else false on failure
     */
    public function getKey($modname)
    {
        $sql = sprintf('SELECT id FROM %s WHERE modname = %s', $this->db->prefix(XBS_MODGEN_TBL_MOD), $this->db->quoteString($modname));

        if ($result = $this->db->query($sql)) {
            if (1 == $this->db->getRowsNum($result)) {
                $ret = $this->db->fetchArray($result);

                return $ret[0];
            }
        }

        return false;
    }

    /**
     * Function: return sql to insert module to database
     *
     * OVERIDE ancestor
     *
     * @param array $cleanVars module parameters array
     * @return string SQL insert string
     * @version 1
     */
    public function _ins_insert($cleanVars)
    {
        extract($cleanVars);

        return sprintf(
            'INSERT INTO %s (modname, modtag, hasadmin, hasuserside, hassearch, hasnotification, hascomments, moddir, moddesc, modcredits, modtargetdir) VALUES (%s,%s,%u,%u,%u,%u,%u,%s,%s,%s,%s)',
            $this->db->prefix(XBS_MODGEN_TBL_MOD),
            $this->db->quoteString($modname),
            $this->db->quoteString($modtag),
            $hasadmin,
            $hasuserside,
            $hassearch,
            $hasnotification,
            $hascomments,
            $this->db->quoteString($moddir),
            $this->db->quoteString($moddesc),
            $this->db->quoteString($modcredits),
            $this->db->quoteString($modtargetdir)
        );
    }

    /**
     * Function: return sql to update module to database
     *
     * OVERIDE ancestor
     *
     * @param array $cleanVars module parameters array
     * @return string SQL insert string
     * @version 1
     */
    public function _ins_update($cleanVars)
    {
        extract($cleanVars);

        //fixup for lastgen

        if ($lastgen < 0 || null === $lastgen) {
            $lastgen = time();
        } else {
            $lastgen = (int)$lastgen;
        }

        return sprintf(
            'UPDATE %s SET modname=%s, modtag=%s, hasadmin=%u, hasuserside=%u, hassearch=%u, hasnotification=%u, hascomments=%u, moddir=%s, moddesc=%s, modcredits=%s, modtargetdir=%s, lastgen=FROM_UNIXTIME(%u) WHERE id = %u',
            $this->db->prefix(XBS_MODGEN_TBL_MOD),
            $this->db->quoteString($modname),
            $this->db->quoteString($modtag),
            $hasadmin,
            $hasuserside,
            $hassearch,
            $hasnotification,
            $hascomments,
            $this->db->quoteString($moddir),
            $this->db->quoteString($moddesc),
            $this->db->quoteString($modcredits),
            $this->db->quoteString($modtargetdir),
            $lastgen,
            $id
        );
        /*$sql = sprintf("update %s set modname=%s, modtag=%s, hasadmin=%u, hasuserside=%u, hassearch=%u, hasnotification=%u, hascomments=%u, moddir=%s, moddesc=%s, modcredits=%s, modtargetdir=%s, lastgen=FROM_UNIXTIME(%u), fileowner=%s where id = %u",$this->db->prefix(XBS_MODGEN_TBL_MOD),$this->db->quoteString($modname), $this->db->quoteString($modtag), $hasadmin, $hasuserside, $hassearch, $hasnotification, $hascomments, $this->db->quoteString($moddir), $this->db->quoteString($moddesc), $this->db->quoteString($modcredits), $this->db->quoteString($modtargetdir),$lastgen,$this->db->quoteString($fileowner),$id);
        */
    }

    /**
     * Delete Module from the database
     *
     * This will also delete any child objects and config records
     * OVERIDE ancestor
     *
     * @param \XoopsObject $obj
     */
    public function delete(XoopsObject $obj)
    {
        $id = $obj->getVar('id');

        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->db->prefix(XBS_MODGEN_TBL_MOD), $id);

        $this->db->queryF($sql);

        $sql = sprintf('DELETE FROM %s WHERE modid = %u', $this->db->prefix(XBS_MODGEN_TBL_CNF), $id);

        $this->db->queryF($sql);

        $sql = sprintf('DELETE FROM %s WHERE modid = %u', $this->db->prefix(XBS_MODGEN_TBL_OBJ), $id);

        $this->db->queryF($sql);
    }

    /**
     * Function: Count the number of Modules
     *
     * @return int number of modules
     * @version 1
     */
    public function countModules()
    {
        $sql = sprintf('SELECT count(*) FROM %s', $this->db->prefix(XBS_MODGEN_TBL_MOD));

        $result = $this->db->queryF($sql);

        $ret = $this->db->fetchRow($result);

        return $ret[0];
    }

    //end function countModules

    /**
     * return an array of Id, ModuleName pairs for use in a select box
     *
     * @return array
     */
    public function getSelectList()
    {
        $sql = sprintf('SELECT id, modname FROM %s', $this->db->prefix(XBS_MODGEN_TBL_MOD));

        $result = $this->db->query($sql);

        $ret = [];

        while (false !== ($res = $this->db->fetchArray($result))) {
            $ret[$res['id']] = $res['modname'];
        }//end while

        return $ret;
    }

    /**
     * Function: return date and time of last generated module
     *
     * Returns a descriptive string for display to user
     *
     * @return string last mod generation description
     * @version 1
     */
    public function getLastGen()
    {
        $sql = sprintf('SELECT modname, lastgen FROM %s WHERE lastgen = (SELECT max(lastgen) FROM %s) ORDER BY lastgen DESC', $this->db->prefix(XBS_MODGEN_TBL_MOD), $this->db->prefix(XBS_MODGEN_TBL_MOD));

        if ($result = $this->db->query($sql)) {
            $res = $this->db->fetchArray($result);

            if ('0000-00-00 00:00:00' != $res['lastgen']) {
                $ret = sprintf(_MD_XBS_MODGEN_MSG1, $res['modname'], $res['lastgen']);
            } else {
                $ret = _MD_XBS_MODGEN_MSG2;
            }
        } else {
            $ret = _MD_XBS_MODGEN_MSG2;
        }

        return $ret;
    }
    //end function getLastGen
} //end class Xbs_ModgenXBS_MODGENModuleHandler
