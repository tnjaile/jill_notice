<?php

namespace XoopsModules\Jill_notice;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Update
{

    public static function del_interface()
    {
        if (file_exists(XOOPS_ROOT_PATH . '/modules/jill_notice/interface_menu.php')) {
            unlink(XOOPS_ROOT_PATH . '/modules/jill_notice/interface_menu.php');
        }
    }
}
