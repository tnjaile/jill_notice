<?php
//群組類
class NoticeGroup
{
    //檢查是否具有預約權限
    public static function group_perm()
    {
        global $xoopsUser, $xoopsModuleConfig;
        if ($xoopsUser) {
            if ($_SESSION['notice_adm']) {
                return true;
                exit;
            }

            $needle_groups = array_unique($xoopsUser->groups());

            $_cate           = new NoticeCateModel();
            $haystack_groups = $_cate->findGroup('post_group');
            // die(var_dump($haystack_groups));
            $filter_group = array_unique(explode(',', implode(',', $haystack_groups)));

            foreach ($needle_groups as $key => $group) {
                if (in_array($group, $filter_group)) {
                    return true;
                }
            }
        }
        return false;
    }

    // 判斷審核者
    public static function auditors_perm()
    {
        global $xoopsUser;

        $_SESSION['auditors'] = false;
        $_cate                = new NoticeCateModel();
        $_cates               = $_cate->findAuditors();
        $_auditors            = "";

        foreach ($_cates as $value) {
            if (empty($value['auditors'])) {
                if ($_SESSION['notice_adm']) {
                    $_auditors .= $value['cate_sn'] . ",";
                }
                continue;
            }
            $value['cate_sn'] = intval($value['cate_sn']);
            $haystack         = explode(',', $value['auditors']);
            if ($_SESSION['notice_adm']) {
                $_auditors .= $value['cate_sn'] . ",";
            } else {
                if (in_array($xoopsUser->uid(), $haystack)) {
                    $_auditors .= $value['cate_sn'] . ",";
                }
            }

        }
        $_SESSION['auditors'] = substr($_auditors, 0, -1);
    }
}
