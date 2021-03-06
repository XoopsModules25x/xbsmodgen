<?php declare(strict_types=1);

namespace XoopsModules\Xbsmodgen;

use XoopsModules\Xbscdm;

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
 * XBS Modgen Object handler
 *
 * @package       XBS_MODGEN
 * @subpackage    Object
 * @copyright     Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
 */

/**
 * ModGen definitions
 */
require_once XOOPS_ROOT_PATH . '/modules/xbsmodgen/include/defines.php';

/**
 * Modgen common functions
 */
//require_once XBS_MODGEN_PATH . '/include/functions.php';

/**
 * Object handler for Xbsobject
 *
 * @subpackage XBS_MODGENSObject
 * @package    XBS_MODGEN
 */
class XbsobjectHandler extends Xbscdm\BaseHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db Handle to xoopsDb object
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db); //call ancestor constructor
        $this->classname = Xbsobject::class;  //set name of object that this handler handles
    }

    /**
     * Create a new Object object
     *
     * @access private
     * @return  Object object
     */
    public function _create()
    {
        return new Xbsobject();
    }

    //end function _create

    /**
     * Returns sql code to get a object data record
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
        return sprintf('SELECT * FROM %s WHERE id = %u', $this->db->prefix(XBSMODGEN_TBL_OBJ), $id);
    }

    /**
     * Get internal identifier (primary key) based on user visible code
     *
     * @param string|null $modname    Name of module
     * @param string|null $objectname Name of object item
     * @return int Internal identifier of module else false on failure
     */
    public function getKey($modname = null, $objectname = null)
    {
        $moduleHandler = \XoopsModules\Xbsmodgen\Helper::getInstance()->getHandler('Module');

        if ($modid = $moduleHandler->getKey($modname)) {
            $sql = sprintf('SELECT id FROM %s WHERE objname = %s AND modid = %u', $this->db->prefix(XBSMODGEN_TBL_OBJ), $this->db->quoteString($objectname), $modid);

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
     * Function: return sql to insert object to database
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
            'INSERT INTO %s (modid, objname, objdesc, objtype, objloc,  objoptions) VALUES (%u, %s, %s, %s, %s, %s)',
            $this->db->prefix(XBSMODGEN_TBL_OBJ),
            $modid,
            $this->db->quoteString($objname),
            $this->db->quoteString($objdesc),
            $this->db->quoteString($objtype),
            $this->db->quoteString($objloc),
            $this->db->quoteString($objoptions)
        );
    }

    /**
     * Function: return sql to update object to database
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
            'UPDATE %s SET objname =%s, objdesc = %s, objtype = %s, objloc = %s,  objoptions = %s WHERE id = %u',
            $this->db->prefix(XBSMODGEN_TBL_OBJ),
            $this->db->quoteString($objname),
            $this->db->quoteString($objdesc),
            $this->db->quoteString($objtype),
            $this->db->quoteString($objloc),
            $this->db->quoteString($objoptions),
            $id
        );
    }

    /**
     * Delete object item from the database
     *
     * OVERIDE ancestor
     *
     * @param \XoopsObject $obj Handle to object object
     * @return bool TRUE on success else False
     */
    public function delete(\XoopsObject $obj)
    {
        $id = $obj->getVar('id');

        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->db->prefix(XBSMODGEN_TBL_OBJ), $id);

        return $this->db->queryF($sql);
    }

    /**
     * Function: Count the number of Objects belonging to a module
     *
     * @param int $modid id of parent module
     * @return int number of modules
     * @version 1
     */
    public function countAllObjects($modid)
    {
        $sql = sprintf('SELECT count(*) FROM %s WHERE modid = %u', $this->db->prefix(XBSMODGEN_TBL_OBJ), $modid);

        $result = $this->db->queryF($sql);

        $ret = $this->db->fetchRow($result);

        return $ret[0];
    }

    //end function countObjects

    /**
     * Function: Count the number of Objects of a particular belonging to a module
     *
     * @param int    $modid id of parent module
     * @param string $otype type of object
     * @return int number of modules
     * @version 1
     */
    public function countTypeObjects($modid, $otype)
    {
        $sql = sprintf('SELECT count(*) FROM %s WHERE modid = %u AND objtype = %s', $this->db->prefix(XBSMODGEN_TBL_OBJ), $modid, $this->db->quoteString($otype));

        $result = $this->db->queryF($sql);

        $ret = $this->db->fetchRow($result);

        return $ret[0];
    }

    //end function countObjects

    /**
     * return an array of Id, objectName pairs for use in a select box
     *
     * @param int $modid id of parent module
     * @return array
     */
    public function getAllSelectList($modid)
    {
        $sql = sprintf('SELECT id, objectname FROM %s WHERE modid = %u', $this->db->prefix(XBSMODGEN_TBL_OBJ), $modid);

        $result = $this->db->query($sql);

        $ret = [];

        while (false !== ($res = $this->db->fetchArray($result))) {
            $ret[$res['id']] = $res['objname'];
        }//end while

        return $ret;
    }

    /**
     * return an array of Id, objectName pairs for use in a select box for objects of a certain type
     *
     * @param int    $modid id of parent module
     * @param string $type
     * @return array
     */
    public function getTypeSelectList($modid, $type)
    {
        $sql = sprintf('SELECT id, objectname FROM %s WHERE modid = %u AND objtype = %s', $this->db->prefix(XBSMODGEN_TBL_OBJ), $modid, $this->db->quoteString($type));

        $result = $this->db->query($sql);

        $ret = [];

        while (false !== ($res = $this->db->fetchArray($result))) {
            $ret[$res['id']] = $res['objname'];
        }//end while

        return $ret;
    }

    /**
     * Return all object item objects for a module
     *
     * @param int $modid Module internal identifier
     * @return array Object objects
     */
    public function getAllObjects($modid)
    {
        $sql = sprintf('SELECT id FROM %s WHERE modid = %u', $this->db->prefix(XBSMODGEN_TBL_OBJ), $modid);

        $result = $this->db->query($sql);

        $ret = [];

        while (false !== ($res = $this->db->fetchArray($result))) {
            $ret[] = $this->getAll($res['id']);
        }//end while

        return $ret;
    }

    //end function

    /**
     * Return all object item objects of a given type for a module
     *
     * @param int    $modid Module internal identifier
     * @param string $type
     * @return array Object objects
     */
    public function getTypeObjects($modid, $type)
    {
        $sql = sprintf('SELECT id FROM %s WHERE modid = %u AND objtype = %s', $this->db->prefix(XBSMODGEN_TBL_OBJ), $modid, $this->db->quoteString($type));

        $result = $this->db->query($sql);

        $ret = [];

        while (false !== ($res = $this->db->fetchArray($result))) {
            $ret[] = $this->getAll($res['id']);
        }//end while

        return $ret;
    }
    //end function
} //end class XbsobjectHandler
