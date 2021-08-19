<?php
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;

class NoticeAction extends Action
{
    private $_notice = null;
    private $_cate   = null;
    public function __construct()
    {
        parent::__construct();

        $this->_notice = new NoticeModel();
        $this->_cate   = new NoticeCateModel();
        list($this->_F['sn'],
            $this->_F['files_sn']) = $this->getArry(array(
            isset($_REQUEST['sn']) ? Tool::setFormString($_REQUEST['sn'], "int") : null,
            isset($_REQUEST['files_sn']) ? Tool::setFormString($_REQUEST['files_sn'], "int") : null));
    }

    //頁面載入
    public function main()
    {
        global $xoopsUser;

        if (isset($_SESSION['can_post']) && $_SESSION['can_post']) {
            $uid = $xoopsUser->uid();
            if (isset($_GET['sn'])) {
                $_OneNotice = $this->_notice->findOne(array("uid='{$uid}' && sn='{$this->_F['sn']}'"));
                // die(var_dump($_OneNotice));
                $this->_tpl->assign('now_op', "notice_show_one");
                $this->_tpl->assign("OneNotice", $_OneNotice[0]);
            } else {
                //分頁
                parent::page(20, 10, $this->_notice);
                $_AllNotice = $this->_notice->notice_list(array("uid='{$uid}'"));
                $this->_tpl->assign('AllNotice', $_AllNotice);
                $this->_tpl->assign('now_op', "notice_list");

            }

            $sweet_alert = new SweetAlert();
            $sweet_alert->render('delete_notice_func',
                "{$_SERVER['PHP_SELF']}?op=delete&sn=", "sn");
            $this->_tpl->assign('can_notice', 1);
        } else {
            $this->_tpl->assign('now_op', "notice_list");
        }
        $this->_tpl->assign('action', $_SERVER['PHP_SELF']);
    }

    // 刪除
    public function delete()
    {
        global $xoopsUser;
        $uid = $xoopsUser->uid();

        if (isset($_GET['sn'])) {
            $_row = $this->_notice->notice_delete(array("uid='{$uid}' && sn='{$this->_F['sn']}'"));
        }
        header("location: {$_SERVER['PHP_SELF']}");
    }

    // 新增、編輯
    public function notice_form()
    {
        global $xoopsUser;
        $uid = $xoopsUser->uid();
        // 上傳
        $TadUpFiles = new TadUpFiles("jill_notice");

        if (isset($_POST['send'])) {
            //XOOPS表單安全檢查
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $error = implode("<br />", $GLOBALS['xoopsSecurity']->getErrors());
                redirect_header($_SERVER['PHP_SELF'], 3, $error);
            }
            if (strtotime($_POST['deadline']) < strtotime($_POST['start'])) {
                redirect_header($_SERVER['PHP_SELF'], 3, "下架日期比上架日期早，儲存失敗");
            }

            if (isset($_POST['next_op'])) {
                if ($_POST['next_op'] == "update") {
                    $_sn      = $this->_notice->notice_update(array("uid='{$uid}' && sn='{$this->_F['sn']}'"));
                    $_message = empty($_sn) ? "修改失敗" : "修改成功!";
                }
                if ($_POST['next_op'] == "add") {
                    if ($_sn == 1) {
                        $this->_newblocks->newblocks_update(1);
                    } elseif ($_sn > 1) {
                        $this->_newblocks->newblocks_add($_sn);
                    }
                    $_sn      = $this->_notice->notice_add();
                    $_message = empty($_sn) ? "新增失敗" : "新增成功!";
                }
                if (!empty($_sn)) {
                    if ($_POST['type'] == "img" || $_POST['type'] == "text" || $_POST['type'] == "url") {
                        $TadUpFiles->set_col("sn", $_sn);
                        // 單檔判斷
                        if ($_FILES['up_sn']['name'][0] != "") {
                            $TadUpFiles->del_files();
                        }
                        $TadUpFiles->upload_file('up_sn', '1280', '140', '', '', true, false);
                    }
                }

            }

            redirect_header($_SERVER['PHP_SELF'], 3, $_message);
            exit();
        }
        if (isset($_GET['sn'])) {
            $_OneNotice = $this->_notice->findOne(array("uid='{$uid}' && sn='{$this->_F['sn']}'"));
            if ($_OneNotice[0]['type'] == "url") {
                $_OneNotice[0]['content'] = strip_tags($_OneNotice[0]['content']);
            }

            // die(var_dump($_OneNotice));
            $TadUpFiles->set_col("sn", $_OneNotice[0]['sn']);
            $this->_tpl->assign('next_op', "update");
            $_type = $_OneNotice[0]['type'];

        } else {
            // 給定預設值
            $_OneNotice[0]['start'] = date("Y-m-d H:i:s", xoops_getUserTimestamp(time()));
            $this->_tpl->assign('typeArr', $this->_notice->setType());
            $_type = !isset($_GET['type']) ? 'text' : Tool::setFormString($_GET['type']);
            $this->_tpl->assign('next_op', "add");

        }
        $this->_tpl->assign('def_type', $_type);
        if ($_type == "ckeditor") {
            $_content = (empty($_OneNotice)) ? "" : $_OneNotice[0]['content'];
            $ck       = new CkEditor("jill_notice", "content", $_content);
            $ck->setHeight(400);
            $this->_tpl->assign('editor_content', $ck->render());
        }
        // die(var_dump($TadUpFiles));
        $up_sn_form = $TadUpFiles->upform(false, "up_sn", "1");
        $this->_tpl->assign('up_sn_form', $up_sn_form);
        // 分類選單
        $_allCate = $this->_cate->findCateTitle();
        $this->_tpl->assign('allCate', $_allCate['cates']);
        $this->_tpl->assign('status', json_encode($_allCate['status'], JSON_UNESCAPED_SLASHES));
        // die(var_dump(json_encode($_allCate['status']), JSON_UNESCAPED_SLASHES));
        //套用formValidator驗證機制
        $formValidator      = new FormValidator("#myForm", true);
        $formValidator_code = $formValidator->render();
        //加入Token安全機制
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $token      = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $this->_tpl->assign("token_form", $token_form);
        $this->_tpl->assign('OneNotice', $_OneNotice[0]);
        $this->_tpl->assign('now_op', "notice_form");
        $this->_tpl->assign('action', $_SERVER['PHP_SELF']);

    }

    // 下載
    public function tufdl()
    {
        $TadUpFiles = new TadUpFiles("jill_notice");
        $TadUpFiles->add_file_counter($this->_F['files_sn']);
        exit;
    }

}
