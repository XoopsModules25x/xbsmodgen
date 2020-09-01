<?php declare(strict_types=1);

namespace XoopsModules\Xbsmodgen\Form;

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
// URL:       http://xoobs.net			                                     //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    XBS Module generator (XBS_MODGEN)                                     //
// ------------------------------------------------------------------------- //

/**
 * Classes used by XBS Module Generator system to present form data
 *
 * @package       XBS_MODGEN
 * @subpackage    Form_Handling
 * @author        Ashley Kitson http://xoobs.net
 * @copyright (c) 2004 Ashley Kitson, Great Britain
 */


/**
 * Create a button tray
 *
 * @package    XBS_MODGEN
 * @subpackage Form_Handling
 * @version    1
 */
class FormElementTray extends \XoopsFormElementTray
{
    /**
     * Constructor
     *
     * @param string $label     Element Tray Label
     * @param bool   $hasInsert tray has insert button
     * @param bool   $hasSubmit tray has submit button
     * @param bool   $hasEdit   tray has edit (this record) button
     * @param bool   $hasSave   tray has a save record button
     * @param bool   $hasCancel tray has cancel button
     * @param bool   $hasUse    tray has use (this record) button
     */
    public function __construct($label, $hasInsert, $hasSubmit, $hasEdit, $hasSave, $hasCancel, $hasUse)
    {
        parent::__construct($label);

        if ($hasSubmit) {
            $submit = new \XoopsFormButton('', 'submit', _AM_XBSMODGEN_SUBMIT, 'submit');

            $this->addElement($submit);
        }

        if ($hasEdit) {
            $edit = new \XoopsFormButton('', 'edit', _AM_XBSMODGEN_EDIT, 'submit');

            $this->addElement($edit);
        }

        if ($hasSave) {
            $save = new \XoopsFormButton('', 'save', _AM_XBSMODGEN_SAVE, 'submit');

            $this->addElement($save);
        }

        if ($hasCancel) {
            $cancel = new \XoopsFormButton('', 'cancel', _AM_XBSMODGEN_CANCEL, 'submit');

            $this->addElement($cancel);
        }

        if ($hasInsert) {
            $insert = new \XoopsFormButton('', 'insert', _AM_XBSMODGEN_INSERT, 'submit');

            $this->addElement($insert);
        }

        if ($hasUse) {
            $use = new \XoopsFormButton('', 'use', _AM_XBSMODGEN_USE, 'submit');

            $this->addElement($use);
        }
    }
    //end constructor
}//end class
