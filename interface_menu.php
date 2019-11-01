<?php
//判斷是否對該模組有管理權限
$isAdmin = $can_post = false;
if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');
    $isAdmin   = $xoopsUser->isAdmin($module_id);
    if (!isset($_SESSION['notice_adm'])) {
        $_SESSION['notice_adm'] = (empty($isAdmin)) ? false : true;
    }
    $can_post = NoticeGroup::group_perm('post_group');
}

$interface_menu[_MD_JILLNOTICE_SMNAME1] = "index.php";
$interface_icon[_MD_JILLNOTICE_SMNAME1] = "fa-chevron-right";

if ($_SESSION['notice_adm']) {
    $interface_menu[_MD_JILLNOTICE_SMNAME2] = "pass.php";
    $interface_icon[_MD_JILLNOTICE_SMNAME2] = "fa-chevron-right";
    $interface_menu[_TAD_TO_ADMIN]          = "admin/main.php";
    $interface_icon[_TAD_TO_ADMIN]          = "fa-sign-in";
}
