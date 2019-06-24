<?php
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;

//分類控制器(後臺分類)
class CateAction extends Action
{
    public function __construct()
    {
        parent::__construct();
    }

    //頁面載入
    public function main()
    {
        if (isset($_GET['cate_sn'])) {
            $_OneCate = $this->_model->findOne();
            $this->_tpl->assign('now_op', "cate_show_one");
            $this->_tpl->assign("OneCate", $_OneCate[0]);
        } else {
            //分頁
            parent::page(20, 10);

            $_AllCate = $this->_model->cate_list();

            // die(var_dump($_AllCate));
            $this->_tpl->assign('AllCate', $_AllCate);
            $this->_tpl->assign('now_op', "cate_list");
            // 排序
            $this->_tpl->assign('jquery', Utility::get_jquery(true));
        }

        $sweet_alert = new SweetAlert();
        $sweet_alert->render('delete_cate_func',
            "{$_SERVER['PHP_SELF']}?op=delete&cate_sn=", "cate_sn");
        $this->_tpl->assign('action', $_SERVER['PHP_SELF']);
    }

    // 刪除
    public function delete()
    {
        if (isset($_GET['cate_sn'])) {
            $_row = $this->_model->cate_delete();
        }
        header("location: {$_SERVER['PHP_SELF']}");
    }

    // 新增、編輯
    public function cate_form()
    {
        if (isset($_POST['send'])) {
            //XOOPS表單安全檢查
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $error = implode("<br />", $GLOBALS['xoopsSecurity']->getErrors());
                redirect_header($_SERVER['PHP_SELF'], 3, $error);
            }
            if (isset($_POST['next_op'])) {
                if ($_POST['next_op'] == "update") {
                    $_message = $this->_model->cate_update() ? "修改成功!" : "修改失敗";
                }
                if ($_POST['next_op'] == "add") {
                    $_message = $this->_model->cate_add() ? "新增成功!" : "新增失敗";
                }
            }

            redirect_header($_SERVER['PHP_SELF'], 3, $_message);
            exit();
        }
        if (isset($_GET['cate_sn'])) {
            $_OneCate = $this->_model->findOne();
            $this->_tpl->assign('next_op', "update");
            $this->_tpl->assign("OneCate", $_OneCate[0]);
        } else {
            $this->_tpl->assign('next_op', "add");
        }
        //套用formValidator驗證機制
        $formValidator      = new FormValidator("#myForm", true);
        $formValidator_code = $formValidator->render();
        //加入Token安全機制
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $token      = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $this->_tpl->assign("token_form", $token_form);
        $this->_tpl->assign('now_op', "cate_form");
        $this->_tpl->assign('action', $_SERVER['PHP_SELF']);

    }
}
