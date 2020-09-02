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
 * XBS Module object handler
 *
 * @package       XBS_MODGEN
 * @subpackage    Module
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

$helper = Helper::getInstance();
$helper->loadLanguage('main');

/**
 * Modgen common functions
 */
//require_once XBS_MODGEN_PATH . '/include/functions.php';

/**
 * Object handler for Module
 *
 * @subpackage Module
 * @package    XBS_MODGEN
 */
class ModuleHandler extends Xbscdm\BaseHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db Handle to xoopsDb object
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db); //call ancestor constructor
        $this->classname = 'Module';  //set name of object that this handler handles
    }

    /**
     * Create a new module object
     *
     * @access private
     * @return  Module object
     */
    public function _create()
    {
        return new Module();
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
        return sprintf('SELECT * FROM %s WHERE id = %u', $this->db->prefix(XBSMODGEN_TBL_MOD), $id);
    }

    /**
     * Get internal identifier (primary key) based on user visible code
     *
     * @param string|null $modname Name of module
     * @return int Internal identifier of module else false on failure
     */
    public function getKey($modname = null)
    {
        if (null !== $modname) {
            $sql = sprintf('SELECT id FROM %s WHERE modname = %s', $this->db->prefix(XBSMODGEN_TBL_MOD), $this->db->quoteString($modname));

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
            'INSERT INTO %s (modname, modtag, hasadmin, hasuserside, hassearch, hasnotification, hascomments, moddir, moddesc, modcredits, modtargetdir) VALUES (%s,%s,%u,%u,%u,%u,%u,%s,%s,%s,%s)',
            $this->db->prefix(XBSMODGEN_TBL_MOD),
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
            $this->db->prefix(XBSMODGEN_TBL_MOD),
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
        /*$sql = sprintf("update %s set modname=%s, modtag=%s, hasadmin=%u, hasuserside=%u, hassearch=%u, hasnotification=%u, hascomments=%u, moddir=%s, moddesc=%s, modcredits=%s, modtargetdir=%s, lastgen=FROM_UNIXTIME(%u), fileowner=%s where id = %u",$this->db->prefix(XBSMODGEN_TBL_MOD),$this->db->quoteString($modname), $this->db->quoteString($modtag), $hasadmin, $hasuserside, $hassearch, $hasnotification, $hascomments, $this->db->quoteString($moddir), $this->db->quoteString($moddesc), $this->db->quoteString($modcredits), $this->db->quoteString($modtargetdir),$lastgen,$this->db->quoteString($fileowner),$id);
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
    public function delete(\XoopsObject $obj)
    {
        $id = $obj->getVar('id');

        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->db->prefix(XBSMODGEN_TBL_MOD), $id);

        $this->db->queryF($sql);

        $sql = sprintf('DELETE FROM %s WHERE modid = %u', $this->db->prefix(XBSMODGEN_TBL_CNF), $id);

        $this->db->queryF($sql);

        $sql = sprintf('DELETE FROM %s WHERE modid = %u', $this->db->prefix(XBSMODGEN_TBL_OBJ), $id);

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
        $ret = false;
        $sql = sprintf('SELECT count(*) FROM %s', $this->db->prefix(XBSMODGEN_TBL_MOD));

        $result = $this->db->queryF($sql);

        $tmp = $this->db->fetchRow($result);
        if (false !== $tmp) {
            $ret = $tmp[0];
        }
        return $ret;
    }

    //end function countModules

    /**
     * return an array of Id, ModuleName pairs for use in a select box
     *
     * @return array
     */
    public function getSelectList()
    {
        $sql = sprintf('SELECT id, modname FROM %s', $this->db->prefix(XBSMODGEN_TBL_MOD));

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
        $sql = sprintf('SELECT modname, lastgen FROM %s WHERE lastgen = (SELECT max(lastgen) FROM %s) ORDER BY lastgen DESC', $this->db->prefix(XBSMODGEN_TBL_MOD), $this->db->prefix(XBSMODGEN_TBL_MOD));

        if ($result = $this->db->query($sql)) {
            $res = $this->db->fetchArray($result);

            if (isset($res['lastgen']) && '0000-00-00 00:00:00' != $res['lastgen']) {
                $ret = sprintf(_MD_XBSMODGEN_MSG1, $res['modname'], $res['lastgen']);
            } else {
                $ret = _MD_XBSMODGEN_MSG2;
            }
        } else {
            $ret = _MD_XBSMODGEN_MSG2;
        }

        return $ret;
    }
    //end function getLastGen
} //end class ModuleHandler
