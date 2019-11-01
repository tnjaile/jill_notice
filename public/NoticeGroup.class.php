<?php
//群組類
class NoticeGroup
{
    //檢查是否具有預約權限
    public static function group_perm($conf_name = "")
    {
        global $xoopsUser, $xoopsModuleConfig, $isAdmin;
        if ($xoopsUser) {
            if ($isAdmin) {
                return true;
                exit;
            }

            $needle_groups = array_unique($xoopsUser->groups());
            // die(var_dump($needle_groups));
            $_cate = new NoticeCateModel();

            $haystack_groups = $_cate->findGroup('post_group');
            $filter_group    = array_unique(explode(',', implode(',', $haystack_groups)));

            // $haystack_groups = $xoopsModuleConfig[$conf_name];
            //die(var_export($xoopsModuleConfig[$conf_name]) . $conf_name);
            foreach ($needle_groups as $key => $group) {
                if (in_array($group, $filter_group)) {
                    return true;
                }
            }
        }
        return false;
    }

}
