<?php declare(strict_types=1);

namespace XoopsModules\Xbsmodgen\Form;

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
 * Create an edit form
 *
 * @package    XBS_MODGEN
 * @subpackage Form_Handling
 * @version    1
 */
class FormEdit extends \XoopsThemeForm
{
    /**
     * Constructor
     *
     * @param ModgenObject $obj        Handle to object to edit
     * @param string       $frmName    Name of form
     * @param string       $nextScript name of POST processing script to execute
     * @param string       $labelFlds  comma seperated list of field names to treat as lables rather than editable fields. Lable flds have a hidden field with the value that can be read by the POST processing script
     * @param null         $keyColName Name of key field to change name of
     * @param null         $keyFldName New name for key field
     */
    public function __construct($obj, $frmName, $nextScript, $labelFlds = '', $keyColName = null, $keyFldName = null)
    {
        parent::__construct($frmName, 'frm' . get_class($obj), $nextScript);

        $vars = $obj->getVars();
        $ele  = null;

        $changeKey = (isset($keyColName) && isset($keyFldName));

        $hasRequired = false;

        foreach ($vars as $key => $var) {
            //get the sanitized value for editing

            $value = $obj->getVar($key, 'edit');

            //change key column name if necessary

            if ($changeKey && ($key == $keyColName)) {
                $key = $keyFldName;
            }

            //construct a form element dependent on data type

            //check to see if we are a label field first

            if (mb_substr_count($labelFlds, $key) > 0) {
                $ele = new \XoopsFormLabel($var['frmName'], $value);

                $elehid = new \XoopsFormHidden($key, $value);

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
                        $ele = new \XoopsFormCheckBox($var['frmName'], $key, $value);
                        $ele->addOptionArray($var['options']);
                        break;
                    case XBS_FRM_DATETIME:
                        $ele = new \XoopsFormDateTime($var['frmName'], $key, (int)$var['frmParams'], $value);
                        break;
                    case XBS_FRM_FILE:
                        $ele = new \XoopsFormFile($var['frmName'], $key, (int)$var['maxlength']);
                        break;
                    case XBS_FRM_HIDDEN:
                        $ele = new \XoopsFormHidden($key, $value);
                        break;
                    case XBS_FRM_LABEL:
                        $ele = new \XoopsFormLabel($var['frmName'], $value);
                        break;
                    case XBS_FRM_PASSWORD:
                        $ele = new \XoopsFormPassword($var['frmName'], $key, (int)$var['frmParams'], $var['maxlength'], $value);
                        break;
                    case XBS_FRM_RADIO:
                        $ele = new \XoopsFormRadio($var['frmName'], $key, $value);
                        break;
                    case XBS_FRM_RADIOYN:
                        $ele = new \XoopsFormRadioYN($var['frmName'], $key, $value);
                        break;
                    case XBS_FRM_SELECT:
                        $params = explode(',', $var['frmParams']);
                        $ele    = new \XoopsFormSelect($var['frmName'], $key, $value, $params[0], $params[1]);
                        $ele->addOptionArray($var['options']);
                        break;
                    case XBS_FRM_CDMCOUNTRY:
                        $params = explode(',', $var['frmParams']);
                        $ele    = new Xbscdm\Form\FormSelectCountry($var['frmName'], $key, $value, $params[0], $params[1]);
                        break;
                    case XBS_FRM_CDMLANG:
                        $params = explode(',', $var['frmParams']);
                        $ele    = new Xbscdm\Form\FormSelectLanguage($var['frmName'], $key, $value, $params[0], $params[1]);
                        break;
                    case XBS_FRM_CDMCURRENCY:
                        $params = explode(',', $var['frmParams']);
                        $ele    = new Xbscdm\Form\FormSelectCurrency($var['frmName'], $key, $value, $params[0], $params[1]);
                        break;
                    case XBS_FRM_CDMSELECT:
                        $params = explode(',', $var['frmParams']);
                        $ele    = new Xbscdm\Form\FormSelect($params[0], $var['frmName'], $key, $value, $params[1], $params[2], $params[3]);
                        break;
                    case XBS_FRM_TEXTBOX:
                        $ele = new \XoopsFormText($var['frmName'], $key, $var['frmParams'], $var['maxlength'], $value);
                        break;
                    case XBS_FRM_TEXTAREA:
                        $params = explode(',', $var['frmParams']);
                        $ele    = new \XoopsFormTextArea($var['frmName'], $key, $value, $params[0], $params[1]);
                        break;
                    case XBS_FRM_DATESELECT:
                        $ele = new \XoopsFormTextDateSelect($var['frmName'], $key, $var['frmParams'], $value);
                        break;
                    default:
                        break;
                }//end switch
            }//end else

            $this->addElement($ele);
        }//end foreach
        unset($ele);
        $ftray = new FormElementTray(_AM_XBSMODGEN_BUTTONTRAY, false, false, false, true, true, false); //button tray
        $this->addElement($ftray);

        if ($hasRequired) {
            $reqmsg = new \XoopsFormLabel(null, _AM_XBSMODGEN_REQFLD);

            $this->addElement($reqmsg);
        }
    }
    //end constructor
}//end class
