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
 * Data container class for a Modgen Configuration Record
 *
 * @package    XBS_MODGEN
 * @subpackage Base
 * @access     public
 */
class Config extends ModgenObject
{
    public function __construct()
    {
        $this->initVar('modid', XOBJ_DTYPE_INT, null, true, null, null, _AM_XBS_MODGEN_TBL_CFGMODID, XBS_FRM_TEXTBOX, '10', XBS_PAT_INT);

        $this->initVar('id', XOBJ_DTYPE_INT, null, true, null, null, _AM_XBS_MODGEN_TBL_CFGID, XBS_FRM_TEXTBOX, '10', XBS_PAT_INT);

        $this->initVar('configname', XOBJ_DTYPE_TXTBOX, null, true, 30, null, _AM_XBS_MODGEN_TBL_CFGNAME, XBS_FRM_TEXTBOX, '30', XBS_PAT_TEXT);

        $this->initVar('configdesc', XOBJ_DTYPE_TXTBOX, null, false, 255, null, _AM_XBS_MODGEN_TBL_CFGDESC, XBS_FRM_TEXTBOX, '50', XBS_PAT_TEXT);

        $this->initVar('configformtype', XOBJ_DTYPE_TXTBOX, 'TXTBOX', true, 6, null, _AM_XBS_MODGEN_TBL_CFGFTYPE, XBS_FRM_CDMSELECT, 'XOBJDTYPE,1,EN,cd_value');

        $this->initVar('configvaltype', XOBJ_DTYPE_TXTBOX, 'text', true, 6, null, _AM_XBS_MODGEN_TBL_CFGFVAL, XBS_FRM_CDMSELECT, 'XOBJVTYPE,1,EN,cd_value');

        $this->initVar('configlen', XOBJ_DTYPE_INT, '30', false, 3, null, _AM_XBS_MODGEN_TBL_CFGFLEN, XBS_FRM_TEXTBOX, '10', XBS_PAT_INT);

        $this->initVar('configdefault', XOBJ_DTYPE_TXTBOX, null, false, 60, null, _AM_XBS_MODGEN_TBL_CFGFDEF, XBS_FRM_TEXTBOX, '30', null);

        $this->initVar('configoptions', XOBJ_DTYPE_TXTAREA, null, false, null, null, _AM_XBS_MODGEN_TBL_CFGFOPT, XBS_FRM_TEXTAREA, '5,50', null);

        parent::__construct();
    }
    //end function
}//end class
