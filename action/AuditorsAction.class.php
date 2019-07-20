<?php
//管理員控制器(後臺首頁)
class AuditorsAction extends Action
{
    private $_cate = null;
    public function __construct()
    {
        parent::__construct();
        $this->_cate = new CateModel();
    }

    //載入資訊
    public function main()
    {
        if (isset($_GET['cate_sn'])) {
            $_user_menu = $this->get_users();
            $_OneCate   = $this->_cate->findOne();

            if (!empty($_OneCate[0]["auditor_group"])) {
                $_user_menu = array_diff($_user_menu, $_OneCate[0]['auditor_group']);
            }

            $this->_tpl->assign('user_menu', $_user_menu);
            $this->_tpl->assign('OneCate', $_OneCate[0]);
            $this->_tpl->assign('action', $_SERVER["PHP_SELF"]);
            $this->_tpl->assign('now_op', "set_auditors");
            //加入Token安全機制
            include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
            $token      = new \XoopsFormHiddenToken();
            $token_form = $token->render();
            $this->_tpl->assign("token_form", $token_form);
        }
    }

    //更新管理人員
    public function update_auditors()
    {
        if (isset($_POST['send'])) {
            //XOOPS表單安全檢查
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $error = implode("<br />", $GLOBALS['xoopsSecurity']->getErrors());
                redirect_header($_SERVER['PHP_SELF'], 3, $error);
            }

            $_message = $this->_cate->cate_update(array('auditors' => 'string'), 0) ? "修改成功!" : "修改失敗";

            redirect_header("main.php", 3, $_message);
            exit();
        }
    }
    public function get_users()
    {
        $member_handler = xoops_getHandler('member');
        $criteria       = new CriteriaCompo();
        $criteria->setSort('uname');
        $criteria->setOrder('ASC');
        $criteria->setLimit(2000);
        $criteria->setStart(0);
        $user_menu = $member_handler->getUserList($criteria);
        return $user_menu;
    }
}
