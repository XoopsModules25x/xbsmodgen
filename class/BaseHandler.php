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
 * Object handler for xbsmodgen objects
 *
 * @package    XBS_MODGEN
 * @subpackage Base
 * @abstract
 */
class BaseHandler extends \XoopsObjectHandler
{
    // Public Variables
    /**
     * Set in descendent constructor to name of object that this handler handles
     * @var string
     */

    public $classname;
    /**
     * Set in ancestor to name of unique ID generator tag for use with insert function
     * @var string
     */

    public $ins_tagname;
    // Private variables
    /**
     * most recent error number
     * @access private
     * @var int
     */

    public $_errno = 0;
    /**
     * most recent error string
     * @access private
     * @var string
     */

    public $_error = '';

    /**
     * Constructor
     *
     * @param xoopsDatabase &$db handle for xoops database object
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db);
    }

    /**
     * Set error information
     *
     * @param int    $errnum =0 Error number
     * @param string $errstr ='' Error Message
     */
    public function setError($errnum = 0, $errstr = '')
    {
        $this->_errno = $errnum;

        $this->_error = $errstr;
    }

    /**
     * Return last error number
     *
     * @return int
     */
    public function errno()
    {
        return $this->_errno;
    }

    /**
     * Return last error message
     *
     * @return  string
     */
    public function error()
    {
        return $this->_error;
    }

    /**
     * return last error number and message
     *
     * @return string
     */
    public function getError()
    {
        return 'Error No ' . $this->_errno . ' - ' . $this->_error;
    }

    /**
     * Must be overidden in ancestor to return a new object of the required kind
     *
     * @abstract
     * @return bool or False if no object created
     */
    public function _create()
    {
        //return new object() - descendent of XoopsObject

        return false;
    }

    /**
     * Create a new object
     *
     * Relies on _create to create the actual object
     *
     * @param bool $isNew =true create a new object and tell it is new.  If False then create object but set it as not new
     * @return bool else False if failure
     */
    public function create($isNew = true)
    {
        $obj = $this->_create();

        if ($isNew && $obj) { //if it is new and the object was created
            $obj->setNew();

            $obj->unsetDirty();
        } else {
            if ($obj) {         //it is not new (forced by caller, usually &getAll()) but obj was created
                $obj->unsetNew();

                $obj->unsetDirty();
            } else {
                $this->setError(-1, sprintf(_MD_xbs_modgen_ERR_2, $classname));

                return false;      //obj was not created so return False to caller.
            }
        }

        return $obj;
    }

    // end create function

    /**
     * Get data from the database and create a new object with it
     *
     * Abstract method. Overide in ancestor and supply the sql string to get the data
     *
     * @abstract
     * @param int $id internal id of the object. Internal code is a unique int value.
     * @return  string SQL string to get data
     */
    public function _get($id)
    {
        //overide in ancestor and supply the sql string to get the data
        return '';
    }

    /**
     * Get data for object given id.
     *
     * @param int $id data item internal identifier
     * @return object
     */
    public function get($id)
    {
        $test = (is_int($id) ? ($id > 0 ? true : false) : !empty($id) ? true : false); //test validity of id

        //    $id = intval($id);

        if ($test) {
            $obj = $this->create(false);

            if ($obj) {
                $sql = $this->_get($id);

                if ($result = $this->db->query($sql)) {
                    if (1 == $this->db->getRowsNum($result)) {
                        $obj->assignVars($this->db->fetchArray($result));

                        return $obj;
                    }

                    $this->setError(-1, sprintf(_MD_xbs_modgen_ERR_1, (string)$id));
                } else {
                    $this->setError($this->db->errno(), $this->db->error());
                }//end if
            }//end if - error value set in call to create()
        } else {
            $this->setError(-1, sprintf(_MD_xbs_modgen_ERR_1, (string)$id));
        }//end if
        return false; //default return
    }

    //end function &get

    /**
     * Get internal identifier (primary key) based on user visible code
     *
     * overide in ancestor to return the identifier
     *
     * @abstract
     * @param mixed Dependent on descendent class
     * @return object of required type
     */
    public function getKey()
    {
        return null;
    }

    /**
     * OVERIDE in ancestor to provide an INSERT string for insert function
     *
     * Use the following construct inside your descendent to get data for the
     * SQL string
     * <code>
     * extract($cleanVars);
     * </code>
     * @abstract
     * @param array $cleanVars of key=>value pairs of data for insert string
     * @return string SQL string to insert object data into database
     */
    public function _ins_insert($cleanVars)
    {
        return '';
    }

    /**
     * OVERIDE in ancestor to provide an UPDATE string for insert function
     *
     * Use the following construct inside your descendent to get data for the
     * SQL string
     * <code>
     * extract($cleanVars);
     * </code>
     * @abstract
     * @param array $cleanVars of key=>value pairs of data for insert string
     * @return string SQL string to update object data into database
     */
    public function _ins_update($cleanVars)
    {
        return '';
    }

    /**
     * Write an object back to the database
     *
     * Overide in ancestor only if you need to add extra process
     * before or after the insert.
     *
     * @param \XoopsObject $obj
     * @return  bool             True if successful
     */
    public function insert(\XoopsObject $obj)
    {
        if (!$obj->isDirty()) {
            return true;
        }    // if data is untouched then don't save
        // Set default values
        $obj->setRowInfo(); //set row edit infos ** you MUST call this prior to an update and prior to cleanVars**

        if ($obj->isNew()) {
            $obj->setVar('row_flag', xbs_modgen_RSTAT_ACT); //its a new code so it is 'Active'

            //next line not really required for mysql, but left in for future compatibility

            $obj->setVar('id', $this->db->genId($this->ins_tagname));
        }

        // set up 'clean' 2 element array of data items k=>v

        if (!$obj->cleanVars()) {
            return false;
        }

        //get the sql for insert or update

        $sql = ($obj->isNew() ? $this->_ins_insert($obj->cleanVars) : $this->_ins_update($obj->cleanVars));

        if (!$result = $this->db->queryF($sql)) {
            $this->setError($this->db->errno(), $this->db->error());

            return false;
        }

        $obj->unsetDirty(); //It has been saved so now it is clean

        if ($obj->isNew()) { //retrieve the new internal id for the code and store
            $id = $this->db->getInsertId();

            $obj->setVar('id', $id);

            $obj->unsetNew();  //it's been saved so it's not new anymore
        }

        return true;
    }

    //end function insert

    /**
     * return SQL string to delete object from database
     *
     * OVERIDE in ancestor to provide an UPDATE string for insert function
     * Use the following construct inside your descendent to get data for the
     * SQL string
     * <code>
     * extract($cleanVars);
     * </code>
     *
     * @abstract
     * @param array $cleanVars of key=>value pairs of data for insert string
     * @return string SQL string to update object data into database
     */
    public function _delete($cleanVars)
    {
        return '';
    }

    //end function

    /**
     * Delete object from the database
     *
     * @param \XoopsObject $obj
     * @return bool TRUE on success else False
     */
    public function delete(\XoopsObject $obj)
    {
        if (!$obj->cleanVars()) {
            return false;
        }

        $sql = $this->_delete($obj->cleanVars);

        if (!$this->db->queryF($sql)) {
            $this->setError($this->db->errno(), $this->db->error());

            return false;
        }

        return true;
    }
    //end function
} //end of class BaseHandler
