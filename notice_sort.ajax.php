<?php
include_once "../../mainfile.php";

if (!$_SESSION['notice_adm']) {
    die(_MD_JILLNOTICE_ILLEGAL);
}
$sort = 1;
foreach ($_POST['tr'] as $sn) {
    $sql = "update " . $xoopsDB->prefix("jill_notice") . " set `sort`='{$sort}' where `sn`='{$sn}'";
    $xoopsDB->queryF($sql) or die(_MD_UPDATE_FAILED . " (" . date("Y-m-d H:i:s") . ")" . $sql);
    $sort++;
}

echo _MD_UPDATE_COMPLETED . " (" . date("Y-m-d H:i:s") . ")";
