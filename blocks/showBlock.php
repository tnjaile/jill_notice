<?php

/**
 * Jill Notice module
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Jill Notice
 * @since      2.5
 * @author     jill Lee
 * @version    $Id $
 **/
define('MODULE_DIR', XOOPS_ROOT_PATH . "/modules/" . basename(dirname(__DIR__)));
//引入系统配置文件
require_once MODULE_DIR . '/configs/profile.inc.php';
//自動加載類
require_once MODULE_DIR . "/configs/autoload.inc.php";
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
    $_Cate    = new CateModel();
    $_allCate = $_Cate->findCateTitle();

    $opt = "";
    foreach ($_allCate as $cate_sn => $cate_title) {
        $ckecked = ($cate_sn == $options[0]) ? "checked" : "";
        $opt .= "
            <span style='white-space:nowrap;'>
              <input type='radio' id='c{$cate_sn}' name='options[0]' value='{$cate_sn}' $ckecked><label for='c{$cate_sn}'>$cate_title</label>
            </span> ";
    }

    $form = "<table>
                <tr>
                <th>
                    <!--顯示分類-->
                    " . _MB_JILL_NOTICE_SHOWCATE . "
                </th>
                <td>
                    {$opt}
                </td>
                </tr>
            </table>";
    return $form;
}
