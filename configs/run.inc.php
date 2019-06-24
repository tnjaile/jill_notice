<?php
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
    include_once $_SERVER["DOCUMENT_ROOT"] . dirname($_SERVER["SCRIPT_NAME"]) . "\header.php";
}
define('MODULE_DIR', XOOPS_ROOT_PATH . "/modules/" . basename(dirname(__DIR__)));
//引入系统配置文件
require_once MODULE_DIR . '/configs/profile.inc.php';
//自動加載類
require_once MODULE_DIR . "/configs/autoload.inc.php";
// require_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";--於各頁面use
include_once MODULE_DIR . "/interface_menu.php";
//資料表前綴
// define('DB_PREFIX', XOOPS_DB_PREFIX . "_");
