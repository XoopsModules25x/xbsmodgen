<?php declare(strict_types=1);

namespace XoopsModules\Xbsmodgen;

use XoopsModules\Xbscdm;

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
 * XBS Module Config object handler
 *
 * @package       XBS_MODGEN
 * @subpackage    Config
 * @author        Ashley Kitson http://xoobs.net
 * @copyright (c) 2006 Ashley Kitson, Great Britain
 */

/**
 * ModGen definitions
 */
require_once XOOPS_ROOT_PATH . '/modules/xbsmodgen/include/defines.php';

/**
 * Modgen common functions
 */
require_once XBS_MODGEN_PATH . '/include/functions.php';


/**
 * Object handler for Config
 *
 * @subpackage Config
 * @package    XBS_MODGEN
 */
class ConfigHandler extends Xbscdm\BaseHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db Handle to xoopsDb object
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db); //call ancestor constructor
        $this->classname = 'Config';  //set name of object that this handler handles
    }

    /**
     * Create a new Config object
     *
     * @access private
     * @return  Config object
     */
    public function _create()
    {
        return new Config();
    }

    //end function _create

    /**
     * Returns sql code to get a config data record
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
        return sprintf('SELECT * FROM %s WHERE id = %u', $this->db->prefix(XBS_MODGEN_TBL_CNF), $id);
    }

    /**
     * Get internal identifier (primary key) based on user visible code
     *
     * @param string $modname    Name of module
     * @param string $configname Name of config item
     * @return int Internal identifier of module else false on failure
     */
    public function getKey($modname, $configname)
    {
        $moduleHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

        if ($modid = $moduleHandler->getKey($modname)) {
            $sql = sprintf('SELECT id FROM %s WHERE configname = %s AND modid = %u', $this->db->prefix(XBS_MODGEN_TBL_CNF), $this->db->quoteString($modname), $modid);

            if ($result = $this->db->query($sql)) {
                if (1 == $this->db->getRowsNum($result)) {
                    $ret = $this->db->fetchArray($result);

                    return $ret[0];
                }
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
            'INSERT INTO %s (modid, configname, configdesc, configformtype, configvaltype,  configlen, configdefault, configoptions) VALUES (%u, %s, %s, %s, %s, %u, %s, %s)',
            $this->db->prefix(XBS_MODGEN_TBL_CNF),
            $modid,
            $this->db->quoteString($configname),
            $this->db->quoteString($configdesc),
            $this->db->quoteString($configformtype),
            $this->db->quoteString($configvaltype),
            $configlen,
            $this->db->quoteString($configdefault),
            $this->db->quoteString($configoptions)
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

        return sprintf(
            'UPDATE %s SET configname =%s, configdesc = %s, configformtype = %s, configvaltype = %s,  configlen = %u, configdefault = %s, configoptions = %s WHERE id = %u',
            $this->db->prefix(XBS_MODGEN_TBL_CNF),
            $this->db->quoteString($configname),
            $this->db->quoteString($configdesc),
            $this->db->quoteString($configformtype),
            $this->db->quoteString($configvaltype),
            $configlen,
            $this->db->quoteString($configdefault),
            $this->db->quoteString($configoptions),
            $id
        );
    }

    /**
     * Delete config item from the database
     *
     * OVERIDE ancestor
     *
     * @param \XoopsObject $obj Handle to config object
     * @return bool TRUE on success else False
     */
    public function delete(\XoopsObject $obj)
    {
        $id = $obj->getVar('id');

        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->db->prefix(XBS_MODGEN_TBL_CNF), $id);

        return $this->db->queryF($sql);
    }

    /**
     * Function: Count the number of Modules
     *
     * @param int $modid id of parent module
     * @return int number of modules
     * @version 1
     */
    public function countConfigs($modid)
    {
        $sql = sprintf('SELECT count(*) FROM %s WHERE modid = %u', $this->db->prefix(XBS_MODGEN_TBL_CNF), $modid);

        $result = $this->db->queryF($sql);

        $ret = $this->db->fetchRow($result);

        return $ret[0];
    }

    //end function countConfigs

    /**
     * return an array of Id, configName pairs for use in a select box
     *
     * @param int $modid id of parent module
     * @return array
     */
    public function getSelectList($modid)
    {
        $sql = sprintf('SELECT id, configname FROM %s WHERE modid = %u', $this->db->prefix(XBS_MODGEN_TBL_CNF), $modid);

        $result = $this->db->query($sql);

        $ret = [];

        while (false !== ($res = $this->db->fetchArray($result))) {
            $ret[$res['id']] = $res['configname'];
        }//end while

        return $ret;
    }

    /**
     * Return all config item objects for a module
     *
     * @param int $modid Module internal identifier
     * @return array Config objects
     */
    public function getAllConfigs($modid)
    {
        $sql = sprintf('SELECT id FROM %s WHERE modid = %u', $this->db->prefix(XBS_MODGEN_TBL_CNF), $modid);

        $result = $this->db->query($sql);

        $ret = [];

        while (false !== ($res = $this->db->fetchArray($result))) {
            $ret[] = $this->getAll($res['id']);
        }//end while

        return $ret;
    }
    //end function
} //end class ConfigHandler
