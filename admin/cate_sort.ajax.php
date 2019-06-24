<?php
include '../../../include/cp_header.php';

$sort = 1;
foreach ($_POST['tr'] as $cate_sn) {
    $sql = "update " . $xoopsDB->prefix("jill_notice_cate") . " set `cate_sort`='{$sort}' where `cate_sn`='{$cate_sn}'";
    $xoopsDB->queryF($sql) or die(_MA_UPDATE_FAILED . " (" . date("Y-m-d H:i:s") . ")" . $sql);
    $sort++;
}

echo _MA_UPDATE_COMPLETED . " (" . date("Y-m-d H:i:s") . ")";
