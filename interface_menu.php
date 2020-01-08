<?php
//判斷是否對該模組有管理權限
if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');
    if (!isset($_SESSION['notice_adm'])) {
        $_SESSION['notice_adm'] = $xoopsUser->isAdmin($module_id);
    }
    if (!isset($_SESSION['can_post'])) {
        $_SESSION['can_post'] = NoticeGroup::group_perm('post_group');
    }
} else {
    unset($_SESSION['can_post']);
}

$interface_menu[_MD_JILLNOTICE_SMNAME1] = "index.php";
$interface_icon[_MD_JILLNOTICE_SMNAME1] = "fa-chevron-right";

if ($_SESSION['notice_adm']) {
    $interface_menu[_MD_JILLNOTICE_SMNAME2] = "pass.php";
    $interface_icon[_MD_JILLNOTICE_SMNAME2] = "fa-chevron-right";
    $interface_menu[_TAD_TO_ADMIN]          = "admin/main.php";
    $interface_icon[_TAD_TO_ADMIN]          = "fa-sign-in";
}
