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
 * Data container class for a Modgen Object
 *
 * @package    XBS_MODGEN
 * @subpackage Base
 * @access     public
 */
class Xbsobject extends ModgenObject
{
    /**
     * constructor
     */
    public function __construct()
    {
        //objects don't have form field names set here as they are set

        //dynamically for each usage of the the object

        $this->initVar('modid', XOBJ_DTYPE_INT, null, true, null, null, null, XBS_FRM_TEXTBOX, '10', XBS_PAT_INT);
        $this->initVar('id', XOBJ_DTYPE_INT, null, true, null, null, null, XBS_FRM_TEXTBOX, '10', XBS_PAT_INT);
        $this->initVar('objtype', XOBJ_DTYPE_TXTBOX, null, true, 10, null, null, XBS_FRM_CDMSELECT, 'XOBJOTYPE,1,EN,cd_value', '/^(u|b|a)(script|tpl)|doc(help|install|system)|table|(u|a)menu$/');
        $this->initVar('objname', XOBJ_DTYPE_TXTBOX, null, true, 30, null, null, XBS_FRM_TEXTBOX, '30', null);
        $this->initVar('objdesc', XOBJ_DTYPE_TXTAREA, null, false, 255, null, null, XBS_FRM_TEXTAREA, '5,50', XBS_PAT_TEXT);
        $this->initVar('objloc', XOBJ_DTYPE_TXTBOX, null, true, 30, null, null, XBS_FRM_TEXTBOX, '30', "/^\/[._a-zA-Z\/]*$/");
        $this->initVar('objoptions', XOBJ_DTYPE_TXTAREA, null, false, null, null, null, XBS_FRM_TEXTAREA, '5,50');

        parent::__construct();
    }

    //end function

    /**
     * Set form names for object
     *
     * @param array $fNames array of names for each form field to display in format (fld => fldName..)
     */
    public function useFormNames($fNames)
    {
        foreach ($fNames as $key => $value) {
            $this->vars[$key]['frmName'] = $value;
        }
    }
    //end function
}//end class
