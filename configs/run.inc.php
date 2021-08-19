<?php
/**
 *
 * @authors Your Name (you@example.org)
 * @date    2017-11-16 11:38:28
 * @version $Id$
 */
//載入檔頭
if (strpos($_SERVER["SCRIPT_NAME"], '/admin/') !== false) {
	$xoopsOption['template_main'] = basename(dirname(__DIR__)) . '_admin_main.tpl';
	include_once "header.php";
} else {
	$xoopsOption['template_main'] = basename(dirname(__DIR__)) . '_index.tpl';
	include_once '../../mainfile.php';
	include_once XOOPS_ROOT_PATH . "/header.php";
}
//引入系统配置文件
include_once XOOPS_ROOT_PATH . "/modules/jillbase/profile.inc.php";
//自動加載類
include_once XOOPS_ROOT_PATH . "/modules/jill_notice/configs/autoload.inc.php";
// include_once NOTICE_DIR . "/interface_menu.php";
include_once NOTICE_DIR . "/header.php";
