<?php
/**
 *
 * @authors Your Name (you@example.org)
 * @date    2017-11-16 11:38:28
 * @version $Id$
 */
//樣板檔前綴(舊式樣板寫法)
// define('TPL_FREFIX', substr($_SERVER["SCRIPT_NAME"], 9, -4));
//載入樣板檔(舊式樣板寫法)
// $xoopsOption['template_main'] = str_replace('/', "_", TPL_FREFIX) . '.tpl';
//載入檔頭
if (dirname($_SERVER["SCRIPT_NAME"]) == "/modules/" . basename(dirname(__DIR__))) {
	$xoopsOption['template_main'] = basename(dirname(__DIR__)) . '_index.tpl';
	include_once $_SERVER["DOCUMENT_ROOT"] . '/mainfile.php';
	include_once XOOPS_ROOT_PATH . "/header.php";
} else {
	$xoopsOption['template_main'] = basename(dirname(__DIR__)) . '_admin_main.tpl';
	include_once $_SERVER["DOCUMENT_ROOT"] . dirname($_SERVER["SCRIPT_NAME"]) . "/header.php";
}

//引入系统配置文件
include_once XOOPS_ROOT_PATH . "/modules/jillbase/profile.inc.php";
//自動加載類
include_once XOOPS_ROOT_PATH . "/modules/jill_notice/configs/autoload.inc.php";
include_once NOTICE_DIR . "/interface_menu.php";
