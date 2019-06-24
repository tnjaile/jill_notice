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

//區塊主函式 (jill_notice_show)
function jill_notice_show($options)
{
    global $xoopsDB;
    $cate_arr = array('text', 'textarea', 'url', 'img');
    foreach ($cate_arr as $cate) {
        $sql     = "select * from `" . $xoopsDB->prefix("jill_notice") . "` where `status`='1' && `cate`='{$cate}'order by `create_date` desc";
        $result  = $xoopsDB->query($sql) or web_error($sql);
        $i       = 0;
        $content = array();
        while ($all = $xoopsDB->fetchArray($result)) {
            $content[$i] = $all;
            $i++;
        }
        $block['content'][$cate] = $content;
    }

    // die(var_dump($block));
    return $block;
}

//區塊編輯函式 (jill_notice_show_edit)
function jill_notice_show_edit($options)
{

    $form = "
  <table>
  </table>
  ";
    return $form;
}
