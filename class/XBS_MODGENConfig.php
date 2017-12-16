<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
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
// URL:       http://xoobs.net			                                     //
// Project:   The XOOPS Project (http://www.xoops.org/)                      //
// Module:    XBS Module Generator (XBS_MODGEN)                                     //
// ------------------------------------------------------------------------- //
/**
 * XBS Module Config object handler
 * 
 * @package XBS_MODGEN
 * @subpackage Config
 * @author Ashley Kitson http://xoobs.net
 * @copyright (c) 2006 Ashley Kitson, Great Britain
*/

if (!defined('XOOPS_ROOT_PATH')) { 
  exit('Call to include XBS_MODGENConfig.php failed as XOOPS_ROOT_PATH not defined');
}

/**
 * ModGen definitions
 */
require_once XOOPS_ROOT_PATH."/modules/xbs_modgen/include/defines.inc";

/**
 * Modgen common functions
 */
require_once XBS_MODGEN_PATH."/include/functions.inc";

/**
* ModGen base classes
*/
require_once XBS_MODGEN_PATH."/class/class.xbs_modgen.base.inc";

/**
 * CDM Base classes
 */
require_once(CDM_PATH."/class/class.cdm.base.php");

/**
 * Object handler for XBS_MODGENConfig
 *
 * @subpackage XBS_MODGENSConfig
 * @package XBS_MODGEN
 */
class Xbs_ModgenXBS_MODGENConfigHandler extends CDMBaseHandler {

  /**
   * Constructor
   *
   * @param  xoopsDB &$db Handle to xoopsDb object
   */
  function Xbs_ModgenXBS_MODGENConfigHandler(&$db) {
    $this->CDMBaseHandler($db); //call ancestor constructor
    $this->classname = 'xbs_modgen_Config';  //set name of object that this handler handles
  }


  /** 
   * Create a new Config object
   *
   * @access private
   * @return  xbs_modgen_Config object
   */

  function &_create() {
    $obj = new xbs_modgen_Config();
    return $obj;
  }//end function _create

  /**
   * Returns sql code to get a config data record
   *
   * OVERIDE ancestor
   *
   * @param   int $id internal id of the object. Internal code is a unique int value. 
   * @param   string $row_flag  default null (get all), Option(CDM_RSTAT_ACT, CDM_RSTAT_DEF, CDM_RSTAT_SUS)
   * @param   string $lang  default null (get all), Valid LANGUAGE code.  Will only return object of that language set
   * @return  string SQL string to get data
   */
  function &_get($id,$row_flag,$lang) { //overide in ancestor and supply the sql string to get the data
    $sql = sprintf("select * from %s where id = %u",$this->db->prefix(XBS_MODGEN_TBL_CNF),$id);
    return $sql;
  }
  

  /**
   * Get internal identifier (primary key) based on user visible code 
   *
   * @param string $modname Name of module
   * @param string $configname Name of config item
   * @return int Internal identifier of module else false on failure
   */
  function getKey($modname,$configname) {
  	$modHandler =& xoops_getmodulehandler("XBS_MODGENModule");
  	if ($modid = $modHandler->getKey($modname)) {
	  	$sql = sprintf("select id from %s where configname = %s and modid = %u",$this->db->prefix(XBS_MODGEN_TBL_CNF),$this->db->quoteString($modname),$modid);
	    if ($result = $this->db->query($sql)) {
		  if ($this->db->getRowsNum($result)==1) {
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
  * @version 1
  * @param array $cleanVars module parameters array
  * @return string SQL insert string
  */
  function _ins_insert($cleanVars) {
    extract($cleanVars);
    $sql = sprintf("insert into %s (modid, configname, configdesc, configformtype, configvaltype,  configlen, configdefault, configoptions) values (%u, %s, %s, %s, %s, %u, %s, %s)",$this->db->prefix(XBS_MODGEN_TBL_CNF),$modid, $this->db->quoteString($configname), $this->db->quoteString($configdesc), $this->db->quoteString($configformtype), $this->db->quoteString($configvaltype), $configlen, $this->db->quoteString($configdefault), $this->db->quoteString($configoptions));
    return $sql;
  }
  
  /**
  * Function: return sql to update module to database 
  *
  * OVERIDE ancestor
  *
  * @version 1
  * @param array $cleanVars module parameters array
  * @return string SQL insert string
  */
  function _ins_update($cleanVars) {
    extract($cleanVars);
  $sql = sprintf("update %s set configname =%s, configdesc = %s, configformtype = %s, configvaltype = %s,  configlen = %u, configdefault = %s, configoptions = %s where id = %u",$this->db->prefix(XBS_MODGEN_TBL_CNF),$this->db->quoteString($configname), $this->db->quoteString($configdesc), $this->db->quoteString($configformtype), $this->db->quoteString($configvaltype), $configlen, $this->db->quoteString($configdefault), $this->db->quoteString($configoptions),$id);
    return $sql;
  }
  
 /**
   * Delete config item from the database
   *
   * OVERIDE ancestor
   * 
   * @param xbs_modgen_Config $obj Handle to config object
   * @return bool TRUE on success else False
   */
  function delete(&$obj) {
  	$id = $obj->getvar('id');
	$sql = sprintf("delete from %s where id = %u",$this->db->prefix(XBS_MODGEN_TBL_CNF),$id);
	return $this->db->queryF($sql);
  }
  
  /**
  * Function: Count the number of Modules
  *
  * @param int $modid id of parent module
  * @version 1
  * @return int number of modules
  */
	function countConfigs($modid) {
		$sql = sprintf("SELECT count(*) from %s where modid = %u",$this->db->prefix(XBS_MODGEN_TBL_CNF),$modid);
		$result = $this->db->queryF($sql);
		$ret = $this->db->fetchRow($result);
		$ret = $ret[0];
		return $ret;
	}//end function countConfigs

 /**
   * return an array of Id, configName pairs for use in a select box
   * 
   * @param int $modid id of parent module
   * @return array
   */
  function getSelectList($modid) {
    $sql = sprintf("select id, configname from %s where modid = %u",$this->db->prefix(XBS_MODGEN_TBL_CNF),$modid);
    $result = $this->db->query($sql);
    $ret = array();
    while ($res = $this->db->fetchArray($result)) {
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
  function getAllConfigs($modid) {
  	$sql = sprintf("select id from %s where modid = %u",$this->db->prefix(XBS_MODGEN_TBL_CNF),$modid);
    $result = $this->db->query($sql);
    $ret = array();
    while ($res = $this->db->fetchArray($result)) {
		$ret[] = $this->getall($res['id']);
    }//end while
    return $ret;
  }//end function

} //end class Xbs_ModgenXBS_MODGENConfigHandler

?>