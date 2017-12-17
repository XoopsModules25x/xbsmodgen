<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://xoops.org/>                             //
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
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    XBS Module generator (XBS_MODGEN)                                     //
// ------------------------------------------------------------------------- //

/** 
 * Classes used by XBS Module Generator system to present form data
 * 
 * @package XBS_MODGEN
 * @subpackage Form_Handling
 * @author Ashley Kitson http://xoobs.net
 * @copyright (c) 2004 Ashley Kitson, Great Britain
*/

//load CDM form object classes
if (file_exists(CDM_PATH . '/class/class.cdm.form.php')) {
	/**
	* CDM Form Objects
	*/
	require_once CDM_PATH . '/class/class.cdm.form.php';
} else {
	die('Unable to load CDM form object classes');
}

/**
* Create a Module selector 
*
* @package XBS_MODGEN
* @subpackage Form_Handling
* @version 1
*/
class XBS_MODGENFormSelectModule extends XoopsFormSelect {
	/**
	* Constructor
	*
	* @param	string	$caption	Caption
	* @param	string	$name       "name" attribute
	* @param	mixed	$value	    Pre-selected value (or array of them).
	* @param	int		$size	    Number of rows. "1" makes a drop-down-list
	*/
  function __construct($caption, $name, $value=null, $size=1) {
    parent::__construct($caption, $name, $value, $size);
    $orgHandler = xoops_getModuleHandler('XBS_MODGENModule');
    $res = $orgHandler->getSelectList();
    $this->addOptionArray($res);
  }
}//end class

/**
* Create a button tray 
*
* @package XBS_MODGEN
* @subpackage Form_Handling
* @version 1
*/
class XBS_MODGENElementTray extends XoopsFormElementTray {
    /**
     * Constructor
     *
     * @param string  $label     Element Tray Label
     * @param boolean $hasInsert tray has insert button
     * @param boolean $hasSubmit tray has submit button
     * @param boolean $hasEdit   tray has edit (this record) button
     * @param boolean $hasSave   tray has a save record button
     * @param boolean $hasCancel tray has cancel button
     * @param boolean $hasUse    tray has use (this record) button
     */
	function __construct($label,$hasInsert=false,$hasSubmit=true,$hasEdit = false,$hasSave = false,$hasCancel=true, $hasUse) {
		parent::__construct($label);
		if ($hasSubmit) {
			$submit = new XoopsFormButton('', 'submit', _AM_XBS_MODGEN_SUBMIT, 'submit');
			$this->addElement($submit);
		}
		if ($hasEdit) {
			$edit = new XoopsFormButton('', 'edit', _AM_XBS_MODGEN_EDIT, 'submit');
			$this->addElement($edit);
		}
		if ($hasSave) {
			$save = new XoopsFormButton('', 'save', _AM_XBS_MODGEN_SAVE, 'submit');
			$this->addElement($save);
		}
		if ($hasCancel) {
			$cancel = new XoopsFormButton('', 'cancel', _AM_XBS_MODGEN_CANCEL, 'submit');
			$this->addElement($cancel);
		}
		if ($hasInsert) {
			$insert = new XoopsFormButton('', 'insert', _AM_XBS_MODGEN_INSERT, 'submit');
			$this->addElement($insert);
		}
		if ($hasUse) {
			$use = new XoopsFormButton('', 'use', _AM_XBS_MODGEN_USE, 'submit');
			$this->addElement($use);
		}
	}//end constructor
}//end class

/**
* Create an edit form
*
* @package XBS_MODGEN
* @subpackage Form_Handling
* @version 1
*/
class XBS_MODGENEditForm extends XoopsThemeForm {
    /**
     * Constructor
     *
     * @param ModgenObject $obj        Handle to object to edit
     * @param string       $frmName    Name of form
     * @param string       $nextScript name of POST processing script to execute
     * @param string       $labelFlds  comma seperated list of field names to treat as lables rather than editable fields. Lable flds have a hidden field with the value that can be read by the POST processing script
     * @param string       $keyColName Name of key field to change name of
     * @param string       $keyFldName New name for key field
     */
	function __construct(&$obj,$frmName,$nextScript,$labelFlds='',$keyColName = null,$keyFldName = null) {
		
		parent::__construct($frmName, 'frm' . get_class($obj), $nextScript);
		$vars = $obj->getVars();
		$changeKey = (isset($keyColName) && isset($keyFldName));
		$hasRequired = false;
		foreach ($vars as $key => $var) {
			//get the sanitized value for editing
			$value = $obj->getVar($key,'edit');
			//change key column name if necessary
			if ($changeKey && ($key == $keyColName)) {
				$key = $keyFldName;
			}
			//construct a form element dependent on data type
			//check to see if we are a label field first
			if (substr_count($labelFlds,$key)>0) {
				$ele = new XoopsFormLabel($var['frmName'], $value);
				$elehid = new XoopsFormHidden($key, $value);
				$this->addElement($elehid);
				unset($elehid);
			} else {
				//else create an editable field
				//  first suffix required fieldnames with *
				if ($var['required']) {
					$var['frmName'] .= ' *';
					$hasRequired = true; //set flag
				}
				switch ($var['frmType']) {
					case XBS_FRM_CHECKBOX:
						$ele = new XoopsFormCheckBox($var['frmName'], $key, $value);
						$ele->addOptionArray($var['options']);
						break;
					case XBS_FRM_DATETIME:
						$ele = new XoopsFormDateTime($var['frmName'], $key, (int)$var['frmParams'], $value);
						break;
					case XBS_FRM_FILE:
						$ele = new XoopsFormFile($var['frmName'], $key, (int)$var['maxlength']);
						break;
					case XBS_FRM_HIDDEN:
						$ele = new XoopsFormHidden($key, $value);
						break;
					case XBS_FRM_LABEL:
						$ele = new XoopsFormLabel($var['frmName'], $value);
						break;
					case XBS_FRM_PASSWORD:
						$ele = new XoopsFormPassword($var['frmName'], $key, (int)$var['frmParams'], $var['maxlength'], $value);
						break;
					case XBS_FRM_RADIO:
						$ele = new XoopsFormRadio($var['frmName'], $key, $value);
						break;
					case XBS_FRM_RADIOYN:
						$ele = new XoopsFormRadioYN($var['frmName'], $key, $value);
						break;
					case XBS_FRM_SELECT:
						$params = explode(',',$var['frmParams']);
						$ele = new XoopsFormSelect($var['frmName'], $key, $value, $params[0], $params[1]);
						$ele->addOptionArray($var['options']);
						break;
					case XBS_FRM_CDMCOUNTRY:
						$params = explode(',',$var['frmParams']);
						$ele = new CDMFormSelectCountry($var['frmName'], $key, $value, $params[0], $params[1]);
						break;
					case XBS_FRM_CDMLANG:
						$params = explode(',',$var['frmParams']);
						$ele = new CDMFormSelectLanguage($var['frmName'], $key, $value, $params[0], $params[1]);
						break;
					case XBS_FRM_CDMCURRENCY:
						$params = explode(',',$var['frmParams']);
						$ele = new CDMFormSelectCurrency($var['frmName'], $key, $value, $params[0], $params[1]);
						break;
					case XBS_FRM_CDMSELECT:
						$params = explode(',',$var['frmParams']);
						$ele = new CDMFormSelect($params[0], $var['frmName'], $key, $value, $params[1], $params[2], $params[3]);
						break;
					case XBS_FRM_TEXTBOX:
						$ele = new XoopsFormText($var['frmName'], $key, $var['frmParams'], $var['maxlength'], $value);
						break;
					case XBS_FRM_TEXTAREA:
						$params = explode(',',$var['frmParams']);
						$ele = new XoopsFormTextArea($var['frmName'], $key, $value, $params[0], $params[1]);
						break;
					case XBS_FRM_DATESELECT:
						$ele = new XoopsFormTextDateSelect($var['frmName'], $key, $var['frmParams'], $value);
						break;
					default:
						break;
				}//end switch
			}//end else
			$this->addElement($ele);
			unset($ele);
		}//end foreach
		$ftray = new XBS_MODGENElementTray(_AM_XBS_MODGEN_BUTTONTRAY,false,false,false,true,true,false); //button tray
		$this->addElement($ftray);
		if ($hasRequired) {
			$reqmsg = new XoopsFormLabel(null,_AM_XBS_MODGEN_REQFLD);
			$this->addElement($reqmsg);
		}
	}//end constructor
}//end class

/**
* Create a Table with individual row edit capabilities
*
* @package XBS_MODGEN
* @subpackage Form_Handling
* @version 1
*/
class XBS_MODGENTableForm {
	/**
	 * Private variables
	 * @access private
	 */
	var $_title = '';			//title for table
	var $_cols = [];		//column names
	var $_rows = [];		//array of arrays, containing data for each column per row
	var $_hasInsert = false;	//Display a new record insert button
	var $_insertUrl = '';		//url to redirect user to if new record required
	var $_hasEdit = false;		//Display edit button for each row
	var $_editUrl = '';			//url to redirect user to edit a record
	var $_hasDelete = false;	//Display delete button for each row
	var $_deleteUrl = '';		//url to redirect user to delete a record
	var $_dispKey = 1;			//display key column (first column in table display)

	/**
	 * Constructor
	 * 
	 * For the three url parameters you should supply something like
	 *  http:/myserver.com/modules/mymod/admin/tableprocess.php?op=edit&id=
	 * i.e they are absolute urls.  Note trailing =.  The value of column 0 (KeyId)
	 * will be suffixed to the url string before processing
	 * 
	 * @param array $colNames names of columns [0 => rowKeyName, 1 => Col1name .. n => Colnname]
	 * @param string $title title of table if required
	 * @param boolean $dispKey display the row key as first column.  If false, you must still supply a column name as the first column in $colNames but it will be ignored and can safely be set to null or ''
	 * @param string $newUrl url to redirect to add a new record
	 * @param string $editUrl url to redirect to edit a record
	 * @param string $delUrl url to redirect to delete a record
	 */
	function __construct($colNames, $title = null, $dispKey = true, $newUrl = null, $editUrl = null, $delUrl = null) {
		$this->_title = $title;
		$this->_hasInsert = (null != $newUrl);
		$this->_insertUrl = $newUrl;
		$this->_hasEdit = (null != $editUrl);
		$this->_editUrl = $editUrl;
		$this->_hasDelete = (null != $delUrl);
		$this->_deleteUrl = $delUrl;
		$this->_dispKey = ($dispKey?0:1);
		if ($this->_hasEdit || $this->_hasDelete) {
			$colNames[] = _AM_XBS_MODGEN_ACTIONCOL;
		}
		$this->_cols = $colNames;
	}//end function constructor

	/**
	 * Add a row of data to the table
	 *
	 * @param array $row one row of data to display [0 => KeyId, 1 => Col1Data 2, n => ColnData]
	 */
	function addRow($row) {
		if ($this->_hasEdit) {
			$content = '<a href="'.$this->_editUrl.$row[0].'">'._AM_XBS_MODGEN_EDIT.'</a>';
			if ($this->_hasDelete) {
				$content .= ' - <a href="'.$this->_deleteUrl.$row[0].'">'._AM_XBS_MODGEN_DEL.'</a>';
			}
			$row[]=$content;
		} elseif ($this->_hasDelete) {
			$content = '<a href="'.$this->_deleteUrl.$row[0].'">'._AM_XBS_MODGEN_DEL.'</a>';
			$row[]=$content;
		}
		$this->_rows[] = $row;
		
	}//end function addRow
	
	/**
	 * output the table as html
	 * 
	 * @param boolean $render If true then echo html to output else return html to caller
	 * @return mixed string if $render = false, else void
	 */
	function display($render = true) {
		$numcols = count($this->_cols);
		$content = "\n\n<!-- Table Edit Display -->\n\n<table border='0' cellpadding='4' cellspacing='1' width='100%' class='outer'>";
		if ($this->_title) {
			$content .= '<caption><b>' . $this->_title . "</b></caption>\n";  //title
		}
		//set column names
		$content .="<tr align=\"center\">\n  ";
		for ($i=$this->_dispKey;$i<$numcols;$i++) {
			$content .= '<th>' . $this->_cols[$i] . '</th>';
		}
		$content .="\n</tr>\n";
		//display data
		$class = 'even';
		foreach ($this->_rows as $row) {
			$class = ('even' == $class ? 'odd' : 'even');
			$content .="<tr align='left' class=\"".$class."\">\n  ";
			for ($i=$this->_dispKey;$i<$numcols;$i++) {

				$content .= '<td>' . $row[$i] . '</td>';
			}
			$content .="\n</tr>\n";
		}
		//Put in an insert button if required
		if ($this->_hasInsert) {
			$content .= "<tr>\n  <td colspan=".$numcols . ' align="right"><form action="' . $this->_insertUrl . '" method="POST"><input type="SUBMIT" value="' . _AM_XBS_MODGEN_INSERT . "\"></form></td>\n</tr>\n";
		}
		$content .="</table>\n<!-- End Table Edit Display -->\n";
		if ($render) {
			echo $content;
		} else {
			return $content;
		}
	}//end function display
}//end class schedTableForm

