<?php
//管理員控制器(後臺首頁)
class AdminAction extends Action
{
    public function __construct()
    {
        parent::__construct();
    }

    //載入資訊
    public function main()
    {
        $configs    = Group::get_config_group();
        $group_list = Group::get_all_groups(array(3));

        $this->_tpl->assign('def_groups', $configs["notice_group"]);
        $this->_tpl->assign('group_list', $group_list);
        $this->_tpl->assign('action', $_SERVER["PHP_SELF"]);
        $this->_tpl->assign('now_op', "main_set_group");
    }

    //更新管理人員到偏好設定(欄位:管理員設定)
    public function update_xoops_config()
    {
        global $xoopsDB;
        if (!isset($_POST['notice_group'])) {
            return;
        }
        $conf_value = serialize($_POST['notice_group']);

        $sql = "update `" . $xoopsDB->prefix("config") . "` set `conf_value`='$conf_value' where `conf_name`='notice_group'";
        $xoopsDB->queryF($sql);

        redirect_header(XOOPS_URL . "/modules/jill_notice/index.php", 3, _MA_JILLNOTICE_SAVEOK);
    }
}
