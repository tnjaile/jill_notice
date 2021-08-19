<?php
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\SweetAlert;

//分類控制器(後臺分類)
class NoticeCateAction extends Action
{
    private $_cate      = null;
    private $_newblocks = null;
    private $_notice    = null;

    public function __construct()
    {
        parent::__construct();
        $this->_cate               = new NoticeCateModel();
        $this->_notice             = new NoticeModel();
        $this->_newblocks          = new NewBlocksModel();
        list($this->_F['cate_sn']) = $this->getArry(array(
            isset($_REQUEST['cate_sn']) ? Tool::setFormString($_REQUEST['cate_sn'], "int") : null));
    }

    //頁面載入
    public function main()
    {

        if (isset($_GET['cate_sn'])) {
            $_OneCate = $this->_cate->findOne();
            $this->_tpl->assign('now_op', "cate_show_one");
            $this->_tpl->assign("OneCate", $_OneCate[0]);
        } else {
            //分頁
            parent::page(20, 10, $this->_cate);

            $_AllCate = $this->_cate->cate_list();

            // die(var_dump($_AllCate));
            $this->_tpl->assign('AllCate', $_AllCate);
            $this->_tpl->assign('now_op', "cate_list");
        }

        $sweet_alert = new SweetAlert();
        $sweet_alert->render('delete_cate_func',
            "{$_SERVER['PHP_SELF']}?op=delete&cate_sn=", "cate_sn");

        if (file_exists(XOOPS_ROOT_PATH . "/modules/tad_blocks/blocks.php")) {
            $this->_tpl->assign('tad_blocks', 1);
        }
        $this->_tpl->assign('action', $_SERVER['PHP_SELF']);
    }

    // 刪除
    public function delete()
    {
        if (isset($_GET['cate_sn'])) {
            $_row = $this->_cate->cate_delete();
            // 一併刪除發布的公告
            $this->_notice->notice_delete(array("cate_sn='{$this->_F['cate_sn']}'"), 1);
            // 順道刪除區塊();
            $this->_newblocks->newblocks_delete();
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
                    $_sn = $this->_cate->cate_update();
                    if (!empty($_sn)) {
                        $this->_newblocks->newblocks_update($_sn);
                        $_message = "修改成功!";
                    } else {
                        $_message = "修改失敗!";
                    }
                }
                if ($_POST['next_op'] == "add") {
                    $_sn = $this->_cate->cate_add();
                    if (!empty($_sn)) {
                        if ($_sn == 1) {
                            $this->_newblocks->newblocks_update($_sn);
                        } else {
                            $this->_newblocks->newblocks_add($_sn);
                        }

                        $_message = "新增成功!";
                    } else {
                        $_message = "新增失敗";
                    }

                }
            }

            redirect_header($_SERVER['PHP_SELF'], 3, $_message);
            exit();
        }
        if (isset($_GET['cate_sn'])) {
            $_OneCate = $this->_cate->findOne();
            $this->_tpl->assign('next_op', "update");
            $this->_tpl->assign("OneCate", $_OneCate[0]);
        } else {
            $_OneCate['post_group'] = array(1);
            $_OneCate['read_group'] = array(2, 3);
            $this->_tpl->assign("OneCate", $_OneCate);
            $this->_tpl->assign('next_op', "add");
        }
        // die(var_dump($_OneCate[0]));
        $this->_tpl->assign("post_group", Group::get_all_groups(array(3)));
        $this->_tpl->assign("read_group", Group::get_all_groups());
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
