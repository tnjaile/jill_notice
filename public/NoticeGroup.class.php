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

            $_cate = new NoticeCateModel();

            $haystack_groups = $_cate->findGroup('post_group');
            $filter_group    = array_unique(explode(',', implode(',', $haystack_groups)));

            foreach ($needle_groups as $key => $group) {
                if (in_array($group, $filter_group)) {
                    return true;
                }
            }
        }
        return false;
    }

}
