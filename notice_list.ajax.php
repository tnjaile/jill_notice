<?php
include_once "../../mainfile.php";
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');

define('MODULE_DIR', XOOPS_ROOT_PATH . "/modules/jill_notice");
//引入系统配置文件
require_once MODULE_DIR . '/configs/profile.inc.php';
require_once $GLOBALS['xoops']->path("/modules/jill_notice/configs/autoload.inc.php");

if (!$_SESSION['notice_adm']) {
    die(_MD_JILLNOTICE_ILLEGAL);
}

$status  = system_CleanVars($_REQUEST, 'status', 0, 'int');
$cate_sn = system_CleanVars($_REQUEST, 'cate_sn', '', 'int');

$_notice = new NoticeModel();

$_AllNotice = $_notice->notice_list(array("cate_sn='{$cate_sn}'", "status='{$status}'"));

$html = "";
foreach ($_AllNotice as $data) {
    $html .= "<tr id='tr_{$data['sn']}'><td>{$data['cate_title']}</td><td>{$data['list_file']}{$data['deadline']}</td><td>{$data['type_name']}</td><td><a href='pass.php?op=notice_show_one&sn={$data['sn']}'>{$data['title']}</a></td><td>
    {$data['uid_name']}</td><td id='status:{$data['sn']}' class='jq_select'>{$data['status_name']}</td><td><a href='javascript:delete_notice_func({$data['sn']});' class='btn btn-xs btn-danger'>" . _TAD_DEL . "</a><a href='pass.php?op=notice_form&sn={$data['sn']}' class='btn btn-xs btn-warning'>" . _TAD_EDIT . "</a></td></tr>";

}
echo $html;
