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
 * XBS Module object handler
 * 
 * @package XBS_MODGEN
 * @subpackage Module
 * @author Ashley Kitson http://xoobs.net
 * @copyright (c) 2006 Ashley Kitson, Great Britain
*/

if (!defined('XOOPS_ROOT_PATH')) { 
  exit('Call to include XBS_MODGENModule.php failed as XOOPS_ROOT_PATH not defined');
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
 * Object handler for XBS_MODGENModule
 *
 * @subpackage XBS_MODGENModule
 * @package XBS_MODGEN
 */
class Xbs_ModgenXBS_MODGENModuleHandler extends CDMBaseHandler {

  /**
   * Constructor
   *
   * @param  xoopsDB &$db Handle to xoopsDb object
   */
  function Xbs_ModgenXBS_MODGENModuleHandler(&$db) {
    $this->CDMBaseHandler($db); //call ancestor constructor
    $this->classname = 'xbs_modgen_Module';  //set name of object that this handler handles
  }


  /** 
   * Create a new module object
   *
   * @access private
   * @return  xbs_modgen_Module object
   */

  function &_create() {
    $obj = new xbs_modgen_Module();
    return $obj;
  }//end function _create

  /**
   * Returns sql code to get a module data record
   *
   * OVERIDE ancestor
   *
   * @param   int $id internal id of the object. Internal code is a unique int value. 
   * @param   string $row_flag  default null (get all), Option(CDM_RSTAT_ACT, CDM_RSTAT_DEF, CDM_RSTAT_SUS)
   * @param   string $lang  default null (get all), Valid LANGUAGE code.  Will only return object of that language set
   * @return  string SQL string to get data
   */
  function &_get($id,$row_flag,$lang) { //overide in ancestor and supply the sql string to get the data
    $sql = sprintf("select * from %s where id = %u",$this->db->prefix(XBS_MODGEN_TBL_MOD),$id);
    return $sql;
  }
  

  /**
   * Get internal identifier (primary key) based on user visible code 
   *
   * @param string $modname Name of module
   * @return int Internal identifier of module else false on failure
   */
  function getKey($modname) {
  	$sql = sprintf("select id from %s where modname = %s",$this->db->prefix(XBS_MODGEN_TBL_MOD),$this->db->quoteString($modname));
    if ($result = $this->db->query($sql)) {
	  if ($this->db->getRowsNum($result)==1) {
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
  * @version 1
  * @param array $cleanVars module parameters array
  * @return string SQL insert string
  */
  function _ins_insert($cleanVars) {
    extract($cleanVars);
    $sql = sprintf("insert into %s (modname, modtag, hasadmin, hasuserside, hassearch, hasnotification, hascomments, moddir, moddesc, modcredits, modtargetdir) values (%s,%s,%u,%u,%u,%u,%u,%s,%s,%s,%s)",$this->db->prefix(XBS_MODGEN_TBL_MOD),$this->db->quoteString($modname), $this->db->quoteString($modtag), $hasadmin, $hasuserside, $hassearch, $hasnotification, $hascomments, $this->db->quoteString($moddir), $this->db->quoteString($moddesc), $this->db->quoteString($modcredits), $this->db->quoteString($modtargetdir));
/*    $sql = sprintf("insert into %s (modname, modtag, hasadmin, hasuserside, hassearch, hasnotification, hascomments, moddir, moddesc, modcredits, modtargetdir, fileowner) values (%s,%s,%u,%u,%u,%u,%u,%s,%s,%s,%s,%s)",$this->db->prefix(XBS_MODGEN_TBL_MOD),$this->db->quoteString($modname), $this->db->quoteString($modtag), $hasadmin, $hasuserside, $hassearch, $hasnotification, $hascomments, $this->db->quoteString($moddir), $this->db->quoteString($moddesc), $this->db->quoteString($modcredits), $this->db->quoteString($modtargetdir),$this->db->quoteString($fileowner));
*/
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
    //fixup for lastgen
    if ($lastgen<0 || $lastgen==null) {
    	$lastgen = time();
    } else {
    	$lastgen = intval($lastgen);
    }
    
  $sql = sprintf("update %s set modname=%s, modtag=%s, hasadmin=%u, hasuserside=%u, hassearch=%u, hasnotification=%u, hascomments=%u, moddir=%s, moddesc=%s, modcredits=%s, modtargetdir=%s, lastgen=FROM_UNIXTIME(%u) where id = %u",$this->db->prefix(XBS_MODGEN_TBL_MOD),$this->db->quoteString($modname), $this->db->quoteString($modtag), $hasadmin, $hasuserside, $hassearch, $hasnotification, $hascomments, $this->db->quoteString($moddir), $this->db->quoteString($moddesc), $this->db->quoteString($modcredits), $this->db->quoteString($modtargetdir),$lastgen,$id);
/*$sql = sprintf("update %s set modname=%s, modtag=%s, hasadmin=%u, hasuserside=%u, hassearch=%u, hasnotification=%u, hascomments=%u, moddir=%s, moddesc=%s, modcredits=%s, modtargetdir=%s, lastgen=FROM_UNIXTIME(%u), fileowner=%s where id = %u",$this->db->prefix(XBS_MODGEN_TBL_MOD),$this->db->quoteString($modname), $this->db->quoteString($modtag), $hasadmin, $hasuserside, $hassearch, $hasnotification, $hascomments, $this->db->quoteString($moddir), $this->db->quoteString($moddesc), $this->db->quoteString($modcredits), $this->db->quoteString($modtargetdir),$lastgen,$this->db->quoteString($fileowner),$id);
*/
    return $sql;
  }
  
 /**
   * Delete Module from the database
   *
   * This will also delete any child objects and config records
   * OVERIDE ancestor
   * 
   * @param Handle to module object
   * @return bool TRUE on success else False
   */
  function delete(&$obj) {
  	$id = $obj->getvar('id');
	$sql = sprintf("delete from %s where id = %u",$this->db->prefix(XBS_MODGEN_TBL_MOD),$id);
	$this->db->queryF($sql);
	$sql = sprintf("delete from %s where modid = %u",$this->db->prefix(XBS_MODGEN_TBL_CNF),$id);
	$this->db->queryF($sql);
	$sql = sprintf("delete from %s where modid = %u",$this->db->prefix(XBS_MODGEN_TBL_OBJ),$id);
	$this->db->queryF($sql);
  }
  
  /**
  * Function: Count the number of Modules
  *
  * @version 1
  * @return int number of modules
  */
	function countModules() {
		$sql = sprintf("SELECT count(*) from %s",$this->db->prefix(XBS_MODGEN_TBL_MOD));
		$result = $this->db->queryF($sql);
		$ret = $this->db->fetchRow($result);
		$ret = $ret[0];
		return $ret;
	}//end function countModules

 /**
   * return an array of Id, ModuleName pairs for use in a select box
   * 
   * @return array
   */
  function getSelectList() {
    $sql = sprintf("select id, modname from %s",$this->db->prefix(XBS_MODGEN_TBL_MOD));
    $result = $this->db->query($sql);
    $ret = array();
    while ($res = $this->db->fetchArray($result)) {
		$ret[$res['id']] = $res['modname'];
    }//end while
    return $ret;
  }

  /**
  * Function: return date and time of last generated module 
  *
  * Returns a descriptive string for display to user
  *
  * @version 1
  * @return string last mod generation description 
  */
  function getLastGen() {
  	$sql = sprintf("select modname, lastgen from %s where lastgen = (select max(lastgen) from %s) order by lastgen desc",$this->db->prefix(XBS_MODGEN_TBL_MOD),$this->db->prefix(XBS_MODGEN_TBL_MOD));
  	if ($result = $this->db->query($sql)) {
  		$res = $this->db->fetchArray($result);
  		if ($res['lastgen']!= "0000-00-00 00:00:00") {
  			$ret = sprintf(_MD_XBS_MODGEN_MSG1,$res['modname'],$res['lastgen']);
  		} else {
  			$ret = _MD_XBS_MODGEN_MSG2;
  		}
  	} else {
  		$ret = _MD_XBS_MODGEN_MSG2;
  	}
  	return $ret;
  }//end function getLastGen
  
} //end class Xbs_ModgenXBS_MODGENModuleHandler

?>