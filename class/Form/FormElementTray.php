<?php declare(strict_types=1);

namespace XoopsModules\Xbsmodgen\Form;

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
 * Classes used by XBS Module Generator system to present form data
 *
 * @package       XBS_MODGEN
 * @subpackage    Form_Handling
 * @copyright (c) 2004, Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
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
