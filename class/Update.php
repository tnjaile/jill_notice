<?php

namespace XoopsModules\Jill_notice;

use XoopsModules\Tadtools\Utility;

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

    //檢查start是否存在
    public static function chk3()
    {
        global $xoopsDB;
        $sql    = "show columns from " . $xoopsDB->prefix("jill_notice ") . " where Field='start'";
        $result = $xoopsDB->query($sql);

        if (empty($result->num_rows)) {
            return true;
        }

        return false;
    }

    //檢查content欄位 Default是否存在
    public static function chk2()
    {
        global $xoopsDB;
        $sql    = "show columns from " . $xoopsDB->prefix("jill_notice ") . " where Field='content'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql);

        list($Field, $Type, $Null, $Key, $Default, $Extra) = $xoopsDB->fetchRow($result);

        if ($Null == "NO") {
            return true;
        } else {
            return false;
        }
    }

    //檢查title欄位 Default是否存在
    public static function chk1()
    {
        global $xoopsDB;
        $sql                                        = "show columns from " . $xoopsDB->prefix("jill_notice ") . " where Field='title'";
        $result                                     = $xoopsDB->query($sql) or Utility::web_error($sql);
        list($Field, $Type, $Key, $Default, $Extra) = $xoopsDB->fetchRow($result);

        if (empty($Default)) {
            return true;

        } else {
            return false;
        }
    }
    //修正title，改為NOT NULL DEFAULT ''
    public static function go_update1()
    {
        global $xoopsDB;
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_notice") . " CHANGE `title` `title` varchar(255) COLLATE 'utf8_general_ci' NOT NULL DEFAULT '' COMMENT '標題' AFTER `type` ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);

        return true;
    }

    //修正content欄位，改為NULL
    public static function go_update2()
    {
        global $xoopsDB;

        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_notice") . " CHANGE `content` `content` text COLLATE 'utf8_general_ci' NULL COMMENT '內文' AFTER `title` ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);
        return true;
    }

    //執行更新通過日期欄位
    public static function go_update3()
    {
        global $xoopsDB;
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_notice") . " ADD `start` datetime NOT NULL COMMENT '上架時間' ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);

        $sql = "select  `create_date`, `start`  from " . $xoopsDB->prefix("jill_notice") . " where
            `start`='0000-00-00 00:00:00'";
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
        while (list($create_date, $start) = $xoopsDB->fetchRow($result)) {
            $sql2 = "update " . $xoopsDB->prefix("jill_notice") . " set `start`='{$create_date}' where `start`='0000-00-00 00:00:00'";
            $xoopsDB->queryF($sql2) or Utility::web_error($sql2);
        }
        return true;
    }
}
