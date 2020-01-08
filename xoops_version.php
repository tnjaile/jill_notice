<?php
/**
 * Jill Notice module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Jill Notice
 * @since      2.5
 * @author     jill Lee
 * @version    $Id $
 **/

$modversion = array();

//---模組基本資訊---//
$modversion['name']        = _MI_JILLNOTICE_NAME;
$modversion['version']     = '1.0';
$modversion['description'] = _MI_JILLNOTICE_DESC;
$modversion['author']      = _MI_JILLNOTICE_AUTHOR;
$modversion['credits']     = _MI_JILLNOTICE_CREDITS;
$modversion['help']        = 'page=help';
$modversion['license']     = 'GPL see LICENSE';
$modversion['image']       = "images/logo.png";
$modversion['dirname']     = basename(__DIR__);

//---模組狀態資訊---//
$modversion['status_version']      = '1.0';
$modversion['release_date']        = '2020-02-05';
$modversion['module_website_url']  = 'https://github.com/tnjaile/';
$modversion['module_website_name'] = _MI_JILLNOTICE_AUTHOR_WEB;
$modversion['module_status']       = 'release';
$modversion['author_website_url']  = 'https://github.com/tnjaile/';
$modversion['author_website_name'] = _MI_JILLNOTICE_AUTHOR_WEB;
$modversion['min_php']             = '7.0';
$modversion['min_xoops']           = '2.5.10';

//---paypal資訊---//
$modversion['paypal']                  = array();
$modversion['paypal']['business']      = 'tnjaile@gmail.com';
$modversion['paypal']['item_name']     = 'Donation :' . _MI_JILLNOTICE_AUTHOR;
$modversion['paypal']['amount']        = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---安裝設定---//
$modversion['onInstall']   = "include/onInstall.php";
$modversion['onUpdate']    = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1]        = "jill_notice";
$modversion['tables'][2]        = "jill_notice_cate";
$modversion['tables'][3]        = "jill_notice_files_center";

//---管理介面設定---//
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = "admin/main.php";
$modversion['adminmenu']  = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain']         = 1;
$i                             = 0;
$modversion['sub'][$i]['name'] = _MI_JILLNOTICE_SMNAME2;
$modversion['sub'][$i]['url']  = "pass.php";
//---樣板設定---//
$modversion['templates'][] = array('file' => 'jill_notice_admin_main.tpl', 'description' => 'jill_notice_admin_main.tpl');
$modversion['templates'][] = array('file' => 'jill_notice_index.tpl', 'description' => 'jill_notice_index.tpl');

//---區塊設定(後台已自動化)---//
$i                                       = 0;
$modversion['blocks'][$i]['file']        = 'showBlock.php';
$modversion['blocks'][$i]['name']        = _MI_JILL_NOTICE_SHOW_BLOCK_NAME;
$modversion['blocks'][$i]['description'] = _MI_JILL_NOTICE_SHOW_BLOCK_DESC;
$modversion['blocks'][$i]['show_func']   = 'jill_notice_show';
// $modversion['blocks'][$i]['edit_func']   = 'jill_notice_show_edit';
$modversion['blocks'][$i]['template'] = 'jill_notice_show.tpl';
$modversion['blocks'][$i]['options']  = '1';

//---偏好設定(後台已自動化)---//
// $i                                       = 0;
// $modversion['config'][$i]['name']        = 'notice_group';
// $modversion['config'][$i]['title']       = '_MI_JILLNOTICE_NOTICE_GROUP';
// $modversion['config'][$i]['description'] = '_MI_JILLNOTICE_NOTICE_GROUP_DESC';
// $modversion['config'][$i]['formtype']    = 'group_multi';
// $modversion['config'][$i]['valuetype']   = 'array';
// $modversion['config'][$i]['default']     = '1';
