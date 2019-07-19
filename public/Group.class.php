<?php
//群組類
class Group
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

            $needle_groups   = $xoopsUser->groups();
            $haystack_groups = $xoopsModuleConfig[$conf_name];
            //die(var_export($xoopsModuleConfig[$conf_name]) . $conf_name);
            foreach ($needle_groups as $key => $group) {
                if (in_array($group, $haystack_groups)) {
                    return true;
                }
            }
        }
        return false;
    }

    //抓偏好設定內的群組
    public static function get_config_group()
    {
        global $xoopsModule;
        $module_id      = $xoopsModule->getVar('mid');
        $config_handler = xoops_getHandler('config');
        $configs        = $config_handler->getConfigsByCat(0, $module_id);
        return $configs;
    }

    //抓取所有群組(除訪客外)
    public static function get_all_groups($filterOutKeys = array())
    {

        $member_handler = xoops_gethandler('member');
        $group_list     = $member_handler->getGroupList();
        // $filterOutKeys  = array(3);
        $group_list = array_diff_key($group_list, array_flip($filterOutKeys));
        return $group_list;
    }
    //抓取群組名
    public static function get_groupname($group_id)
    {
        $group_handler = xoops_gethandler('group');
        $groupname     = $group_handler->get($group_id)->name();
        return $groupname;
    }

}
