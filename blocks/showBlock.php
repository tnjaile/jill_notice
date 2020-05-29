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
//引入系统配置文件
include_once XOOPS_ROOT_PATH . "/modules/jillbase/profile.inc.php";
//自動加載類
include_once XOOPS_ROOT_PATH . "/modules/jill_notice/configs/autoload.inc.php";
//區塊主函式 (jill_notice_show)
function jill_notice_show($options)
{
    $block = [];
    if (!empty($options[0])) {
        $_notice  = new NoticeModel();
        $_typeArr = $_notice->setType();
        foreach ($_typeArr as $type => $typename) {

            $_whereData = array("cate_sn='{$options[0]}'  && create_date<now() &&deadline>now()", "type='{$type}'", "status='1'");
            $_AllNotice = $_notice->show_block($_whereData);
            if (!empty($_AllNotice)) {
                $block['content'][$type] = $_AllNotice;
            }
        }

    }
    return $block;

}

//區塊編輯函式 (jill_notice_show_edit)
function jill_notice_show_edit($options)
{
    // $_cate    = new NoticeCateModel();
    // $_allCate = $_cate->findCateTitle();

    // $opt = "";
    // foreach ($_allCate['cates'] as $cate_sn => $cate_title) {
    //     $ckecked = ($cate_sn == $options[0]) ? "checked" : "";
    //     $opt .= "
    //         <span>
    //           <input type='radio' id='c{$cate_sn}' name='options[0]' value='{$cate_sn}' $ckecked><label for='c{$cate_sn}'>$cate_title</label>
    //         </span> ";
    // }
    // $form = "<table>
    //             <tr>
    //             <th>
    //                 <!--顯示分類-->
    //                 " . _MB_JILL_NOTICE_SHOWCATE . "
    //             </th>
    //             <td>
    //                 {$opt}
    //             </td>
    //             </tr>
    //         </table>";

    // return $form;
}
