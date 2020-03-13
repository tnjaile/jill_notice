<?php
use XoopsModules\Jill_notice\Update;
use XoopsModules\Tadtools\Utility;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

function xoops_module_update_jill_notice($module, $old_version)
{
    Update::del_interface();
    return true;
}
