<?php
include_once "../../mainfile.php";
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');

if (!$_SESSION['auditors']) {
    redirect_header(XOOPS_URL, 3, _MD_JILLNOTICE_ERRORLOGION);
}
$value = system_CleanVars($_REQUEST, 'value', '', 'string');
$id    = system_CleanVars($_REQUEST, 'id', '', 'string');

list($col, $sn) = explode(':', $id);
$sql            = "update " . $xoopsDB->prefix("jill_notice") . " set $col='{$value}' where sn='{$sn}'";
// die($sql);
$xoopsDB->queryF($sql);
if ($col == 'status') {
    switch ($value) {
        case '1':
            $value = _MD_JILLNOTICE_STATUS1;
            break;
        case '2':
            $value = _MD_JILLNOTICE_STATUS2;
            break;

        default:
            $value = _MD_JILLNOTICE_STATUS0;
            break;
    }
}

echo $value;
