<?php
use XoopsModules\Jill_notice\Update;
use XoopsModules\Tadtools\Utility;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

function xoops_module_update_jill_notice($module, $old_version)
{
    Update::del_interface();
    if (Update::chk1()) {
        Update::go_update1();
    }

    if (Update::chk2()) {
        Update::go_update2();
    }

    if (Update::chk3()) {
        Update::go_update3();
    }
    return true;
}
