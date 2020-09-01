<?php declare(strict_types=1);

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
// Copyright: (c) 2006, Ashley Kitson                                        //
// URL:       http://xoobs.net                                               //
// Module License: GNU General Public License                                //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    XBS Module Generator (XBS_MODGEN)                              //
// ------------------------------------------------------------------------- //
/**
 * Xoops module Installation parameters
 *
 * This file conforms to the Xoops standard for the xoops_version.php file.
 * Constant declarations beginning _MI_ are contained in language/../modinfo.php
 *
 * @author        Ashley Kitson http://xoobs.net
 * @copyright (c) 2004, Ashley Kitson
 * @package       XBS_MODGEN
 * @version       1
 * @subpackage    Installation
 * @access        private
 * @global array Module Installation array as per Xoops
 */
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

global $modversion;
$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$modversion['version']       = 2.01;
$modversion['module_status'] = 'Beta 1';
$modversion['release_date']  = '2020/08/30';
$modversion['name']        = _MI_XBSMODGEN_NAME;
$modversion['description'] = _MI_XBSMODGEN_DESC;
$modversion['credits']     = 'Ashley Kitson<br>( http://xoobs.net/ )';
$modversion['author']      = 'Ashley Kitson';
//$modversion['help'] = "xbs_modgen_help.html";
$modversion['help']                = 'page=help';
$modversion['license']             = 'GNU GPL 2.0 or later';
$modversion['license_url']         = 'www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']            = 0;
$modversion['dirname']             = $moduleDirName;
$modversion['modicons16']          = 'assets/images/icons/16';
$modversion['modicons32']          = 'assets/images/icons/32';
$modversion['image']               = 'assets/images/logoModule.png';
$modversion['module_website_url']  = 'https://xoops.org';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '7.1';
$modversion['min_xoops']           = '2.5.10';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.5'];
$modversion['system_menu']         = 1;
$modversion['adminindex']          = 'admin/index.php';
$modversion['adminmenu']           = 'admin/menu.php';

// ------------------- Help files ------------------- //
$modversion['help']        = 'page=help';
$modversion['helpsection'] = [
    ['name' => _MI_XBSMODGEN_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_XBSMODGEN_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_XBSMODGEN_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_XBSMODGEN_SUPPORT, 'link' => 'page=support'],
];

$modversion['onUpdate']    = 'install_funcs.php';
$modversion['onInstall']   = 'install_funcs.php';
$modversion['onUninstall'] = 'install_funcs.php';

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'xbs_modgen_module';
$modversion['tables'][1] = 'xbs_modgen_object';
$modversion['tables'][2] = 'xbs_modgen_config';

// Main Menu
$modversion['hasMain'] = 0;

// Admin menu things
$modversion['hasAdmin']    = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

$modversion['hasSearch']       = 0;
$modversion['hasComments']     = 0;
$modversion['hasNotification'] = 0;

// XBS_MODGEN Configuration items

$modversion['config'][0]['name']        = 'xbs_modgen_author';
$modversion['config'][0]['title']       = '_MI_XBSMODGEN_CFG1NAME';
$modversion['config'][0]['description'] = '_MI_XBSMODGEN_CFG1DESC';
$modversion['config'][0]['formtype']    = 'text';
$modversion['config'][0]['valuetype']   = 'text';

$modversion['config'][1]['name']        = 'xbs_modgen_license';
$modversion['config'][1]['title']       = '_MI_XBSMODGEN_CFG2NAME';
$modversion['config'][1]['description'] = '_MI_XBSMODGEN_CFG2DESC';
$modversion['config'][1]['formtype']    = 'select';
$modversion['config'][1]['valuetype']   = 'text';
$modversion['config'][1]['default']     = 'GPL';
$modversion['config'][1]['options']     = ['GNU GPL' => 'GPL', 'GNU Library PL' => 'LGPL'];

$modversion['config'][2]['name']        = 'xbs_modgen_lang';
$modversion['config'][2]['title']       = '_MI_XBSMODGEN_CFG3NAME';
$modversion['config'][2]['description'] = '_MI_XBSMODGEN_CFG3DESC';
$modversion['config'][2]['formtype']    = 'select';
$modversion['config'][2]['valuetype']   = 'text';
$modversion['config'][2]['default']     = 'EN';
$modversion['config'][2]['options']     = [
    'AF - Afrikaans'      => 'AF',
    'AR - Arabic'         => 'AR',
    'BE - Belarussian'    => 'BE',
    'BG - Bulgarian'      => 'BG',
    'CA - Catalan'        => 'CA',
    'CS - Czech'          => 'CS',
    'DA - Danish'         => 'DA',
    'DE - German'         => 'DE',
    'EL - Greek'          => 'EL',
    'EN - English'        => 'EN',
    'ES - Spanish'        => 'ES',
    'ET - Estonian'       => 'ET',
    'EU - Basque'         => 'EU',
    'FA - Farsi'          => 'FA',
    'FI - Finnish'        => 'FI',
    'FO - Faroese'        => 'FO',
    'FR - French'         => 'FR',
    'GD - Gaelic'         => 'GD',
    'HE - Hebrew'         => 'HE',
    'HI - Hindi'          => 'HI',
    'HR - Croatian'       => 'HR',
    'HU - Hungarian'      => 'HU',
    'IN - Indonesian'     => 'IN',
    'IS - Icelandic'      => 'IS',
    'IT - Italian'        => 'IT',
    'JA - Japanese'       => 'JA',
    'JI - Yiddish'        => 'JI',
    'KO - Korean'         => 'KO',
    'LT - Lithuanian'     => 'LT',
    'LV - Lettish'        => 'LV',
    'MK - Macedonian'     => 'MK',
    'MS - Malay'          => 'MS',
    'MT - Maltese'        => 'MT',
    'NL - Dutch'          => 'NL',
    'NO - Norwegian'      => 'NO',
    'PL - Polish'         => 'PL',
    'PT - Portuguese'     => 'PT',
    'RM - Rhaeto-Romance' => 'RM',
    'RO - Romanian'       => 'RO',
    'RU - Russian'        => 'RU',
    'SK - Slovak'         => 'SK',
    'SL - Slovenian'      => 'SL',
    'SQ - Albanian'       => 'SQ',
    'SR - Serbian'        => 'SR',
    'SV - Swedish'        => 'SV',
    'SX - Sutu'           => 'SX',
    'TH - Thai'           => 'TH',
    'TN - Setsuana'       => 'TN',
    'TR - Turkish'        => 'TR',
    'TS - Tsonga'         => 'TS',
    'UK - Ukrainian'      => 'UK',
    'UR - Urdu'           => 'UR',
    'VI - Vietnamese'     => 'VI',
    'XH - Xhosa'          => 'XH',
    'ZH - Chinese'        => 'ZH',
    'ZU - Zulu'           => 'ZU',
];

$modversion['config'][3]['name']        = 'xbs_modgen_country';
$modversion['config'][3]['title']       = '_MI_XBSMODGEN_CFG4NAME';
$modversion['config'][3]['description'] = '_MI_XBSMODGEN_CFG4DESC';
$modversion['config'][3]['formtype']    = 'select';
$modversion['config'][3]['valuetype']   = 'text';
$modversion['config'][3]['default']     = 'GB';
$modversion['config'][3]['options']     = [
    'Andorra'                        => 'AD',
    'United Arab Emirates'           => 'AE',
    'Afghanistan'                    => 'AF',
    'Antigua and Barbuda'            => 'AG',
    'Anguilla'                       => 'AI',
    'Albania'                        => 'AL',
    'Armenia'                        => 'AM',
    'Netherlands Antilles'           => 'AN',
    'Angola'                         => 'AO',
    'Antartica'                      => 'AQ',
    'Argentina'                      => 'AR',
    'American Samoa'                 => 'AS',
    'Austria'                        => 'AT',
    'Australia'                      => 'AU',
    'Aruba'                          => 'AW',
    'Azerbaijan'                     => 'AZ',
    'Bosnia and Herzegowina'         => 'BA',
    'Barbados'                       => 'BB',
    'Belgium'                        => 'BE',
    'Burkina Faso'                   => 'BF',
    'Bulgaria'                       => 'BG',
    'Bahrain'                        => 'BH',
    'Burundi'                        => 'BI',
    'Benin'                          => 'BJ',
    'Bermuda'                        => 'BM',
    'Brunei Darussalam'              => 'BN',
    'Bolivia'                        => 'BO',
    'Brazil'                         => 'BR',
    'Bahamas'                        => 'BS',
    'Bhutan'                         => 'BT',
    'Bouvet Island'                  => 'BV',
    'Botswana'                       => 'BW',
    'Belarus'                        => 'BY',
    'Belize'                         => 'BZ',
    'Canada'                         => 'CA',
    'Cocos Island'                   => 'CC',
    'The Dem. Republic of the Congo' => 'CD',
    'Central African Republic'       => 'CF',
    'Congo'                          => 'CG',
    'Switzerland'                    => 'CH',
    "Cote D'Ivoire"                  => 'CI',
    'Cook Islands'                   => 'CK',
    'Chile'                          => 'CL',
    'Cameroon'                       => 'CM',
    'China'                          => 'CN',
    'Colombia'                       => 'CO',
    'Costa Rica'                     => 'CR',
    'Cuba'                           => 'CU',
    'Cape Verde'                     => 'CV',
    'Christmas Island'               => 'CX',
    'Cyprus'                         => 'CY',
    'Czech Republic'                 => 'CZ',
    'Bangladesh'                     => 'DB',
    'Germany'                        => 'DE',
    'Djibouti'                       => 'DJ',
    'Denmark'                        => 'DK',
    'Dominica'                       => 'DM',
    'Dominican Republic'             => 'DO',
    'Algeria'                        => 'DZ',
    'Ecuador'                        => 'EC',
    'Estonia'                        => 'EE',
    'Egypt'                          => 'EG',
    'Western Sahara'                 => 'EH',
    'Eritrea'                        => 'ER',
    'Spain'                          => 'ES',
    'Ethiopia'                       => 'ET',
    'Finland'                        => 'FI',
    'Fiji'                           => 'FJ',
    'Falkland Islands'               => 'FK',
    'Federated States of Micronesia' => 'FM',
    'Faeroe Islands'                 => 'FO',
    'France'                         => 'FR',
    'France, Metropolitan'           => 'FX',
    'Gabon'                          => 'GA',
    'Grenada'                        => 'GD',
    'Georgia'                        => 'GE',
    'French Guiana'                  => 'GF',
    'Ghana'                          => 'GH',
    'Gibraltar'                      => 'GI',
    'Greenland'                      => 'GL',
    'Gambia'                         => 'GM',
    'Guinea'                         => 'GN',
    'Guadelupe'                      => 'GP',
    'Equatorial Guinea'              => 'GQ',
    'Greece'                         => 'GR',
    'South Georgia and Sandwich Is.' => 'GS',
    'Guatemala'                      => 'GT',
    'Guam'                           => 'GU',
    'Guinea-Bissau'                  => 'GW',
    'Guyana'                         => 'GY',
    'Hong Kong'                      => 'HK',
    'Heard and Mc Donald Islands'    => 'HM',
    'Honduras'                       => 'HN',
    'Croatia'                        => 'HR',
    'Haiti'                          => 'HT',
    'Hungary'                        => 'HU',
    'Indonesia'                      => 'ID',
    'Ireland'                        => 'IE',
    'Israel'                         => 'IL',
    'India'                          => 'IN',
    'British Indian Ocean Territory' => 'IO',
    'Iraq'                           => 'IQ',
    'Iran'                           => 'IR',
    'Iceland'                        => 'IS',
    'Italy'                          => 'IT',
    'Jamaica'                        => 'JM',
    'Jordan'                         => 'JO',
    'Japan'                          => 'JP',
    'Kenya'                          => 'KE',
    'Kyrgyzstan'                     => 'KG',
    'Cambodia'                       => 'KH',
    'Kiribati'                       => 'KI',
    'Comoros'                        => 'KM',
    'Saint Kitts and Nevis'          => 'KN',
    'Korea, Democratic Republic of'  => 'KP',
    'Korea, Republic of'             => 'KR',
    'Kuwait'                         => 'KW',
    'Cayman Islands'                 => 'KY',
    'Kazakhstan'                     => 'KZ',
    'Lao People Democratic Republic' => 'LA',
    'Lebanon'                        => 'LB',
    'Saint Lucia'                    => 'LC',
    'Liechtenstein'                  => 'LI',
    'Sri Lanka'                      => 'LK',
    'Liberia'                        => 'LR',
    'Lesotho'                        => 'LS',
    'Lithuania'                      => 'LT',
    'Luxembourg'                     => 'LU',
    'Latvia'                         => 'LV',
    'Libyan Arab Jamahiriya'         => 'LY',
    'Morocco'                        => 'MA',
    'Monaco'                         => 'MC',
    'Moldova, Republic of'           => 'MD',
    'Madagascar'                     => 'MG',
    'Marshall Islands'               => 'MH',
    'Macedonia, Former Republic of'  => 'MK',
    'Mali'                           => 'ML',
    'Myanmar'                        => 'MM',
    'Mongolia'                       => 'MN',
    'Macau'                          => 'MO',
    'Northern Mariana Islands'       => 'MP',
    'Martinique'                     => 'MQ',
    'Mauritania'                     => 'MR',
    'Montserrat'                     => 'MS',
    'Malta'                          => 'MT',
    'Mauritius'                      => 'MU',
    'Maldives'                       => 'MV',
    'Malawi'                         => 'MW',
    'Mexico'                         => 'MX',
    'Malaysia'                       => 'MY',
    'Mozambique'                     => 'MZ',
    'Namibia'                        => 'NA',
    'New Caledonia'                  => 'NC',
    'Niger'                          => 'NE',
    'Norfolk Island'                 => 'NF',
    'Nigeria'                        => 'NG',
    'Nicaragua'                      => 'NI',
    'Netherlands'                    => 'NL',
    'Norway'                         => 'NO',
    'Nepal'                          => 'NP',
    'Nauru'                          => 'NR',
    'Niue'                           => 'NU',
    'New Zealand'                    => 'NZ',
    'Oman'                           => 'OM',
    'Panama'                         => 'PA',
    'Peru'                           => 'PE',
    'French Polynesia'               => 'PF',
    'Papua New Guinea'               => 'PG',
    'Philipines'                     => 'PH',
    'Pakistan'                       => 'PK',
    'Poland'                         => 'PL',
    'St Pierre and Miquelon'         => 'PM',
    'Pitcairn Island'                => 'PN',
    'Puerto Rico'                    => 'PR',
    'Portugal'                       => 'PT',
    'Palau'                          => 'PW',
    'Paraguay'                       => 'PY',
    'Qatar'                          => 'QA',
    'Reunion'                        => 'RE',
    'Romenia'                        => 'RO',
    'Russian Federation'             => 'RU',
    'Rwanda'                         => 'RW',
    'Saudi Arabia'                   => 'SA',
    'Solomon Islands'                => 'SB',
    'Seychelles'                     => 'SC',
    'Sudan'                          => 'SD',
    'Sweden'                         => 'SE',
    'Singapore'                      => 'SG',
    'St. Helena'                     => 'SH',
    'Slovenia'                       => 'SI',
    'Svalbard and Jan Mayen Islands' => 'SJ',
    'Slovakia'                       => 'SK',
    'Sierra Leone'                   => 'SL',
    'San Marino'                     => 'SM',
    'Senegal'                        => 'SN',
    'Somalia'                        => 'SO',
    'Suriname'                       => 'SR',
    'Sao Tome and Principe'          => 'ST',
    'El Salvador'                    => 'SV',
    'Syrian Arab Republic'           => 'SY',
    'Swaziland'                      => 'SZ',
    'Turks and Caicos Islands'       => 'TC',
    'Chad'                           => 'TD',
    'French Southern Territories'    => 'TF',
    'Togo'                           => 'TG',
    'Thailand'                       => 'TH',
    'Tajikistan'                     => 'TJ',
    'Tokelau Islands'                => 'TK',
    'Turkmenistan'                   => 'TM',
    'Tunisia'                        => 'TN',
    'Tonga Islands'                  => 'TO',
    'East Timor'                     => 'TP',
    'Turkey'                         => 'TR',
    'Trinidad and Tobago'            => 'TT',
    'Tuvalu'                         => 'TV',
    'Taiwan'                         => 'TW',
    'Tanzania, United Republic of'   => 'TZ',
    'Ukraine'                        => 'UA',
    'Uganda'                         => 'UG',
    'United Kingdom'                 => 'GB',
    'United States Minor Islands'    => 'UM',
    'United States of America'       => 'US',
    'Uruguay'                        => 'UY',
    'Uzbekistan'                     => 'UZ',
    'Holy See'                       => 'VA',
    'Saint Vincent and Grenadines'   => 'VC',
    'Venezuela'                      => 'VE',
    'Virgin Islands, British'        => 'VG',
    'Virgin Islands, USA'            => 'VI',
    'Vietnam'                        => 'VN',
    'Vanuatu'                        => 'VU',
    'Wallis and Futuna Islands'      => 'WF',
    'Samoa'                          => 'WS',
    'Yemen'                          => 'YE',
    'Mayotte'                        => 'YT',
    'Yugoslavia'                     => 'YU',
    'South Africa'                   => 'ZA',
    'Zimbabwe'                       => 'ZE',
    'Zambia'                         => 'ZM',
    'Zaire'                          => 'ZR',
];

$modversion['config'][4]['name']        = 'xbs_modgen_authurl';
$modversion['config'][4]['title']       = '_MI_XBSMODGEN_CFG5NAME';
$modversion['config'][4]['description'] = '_MI_XBSMODGEN_CFG5DESC';
$modversion['config'][4]['formtype']    = 'text';
$modversion['config'][4]['valuetype']   = 'text';

$modversion['config'][5]['name']        = 'xbs_modgen_contact';
$modversion['config'][5]['title']       = '_MI_XBSMODGEN_CFG6NAME';
$modversion['config'][5]['description'] = '_MI_XBSMODGEN_CFG6DESC';
$modversion['config'][5]['formtype']    = 'text';
$modversion['config'][5]['valuetype']   = 'text';
$modversion['config'][5]['default']     = 'author_email at some dot address';
