<?php
/**
 * Jill Notice module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Jill Notice
 * @since      2.5
 * @author     jill Lee
 * @version    $Id $
 **/

use XoopsModules\Tadtools\Utility;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

function xoops_module_install_jill_notice(&$module)
{

    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/jill_notice");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/jill_notice/file");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/jill_notice/image");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/jill_notice/image/.thumbs");

    return true;
}
