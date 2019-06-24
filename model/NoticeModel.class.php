<?php
use XoopsModules\Tadtools\TadUpFiles;

class NoticeModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        // 要顯示的欄位及欄位類型
        $this->_fields = array('sn' => 'int', 'create_date' => 'date', 'deadline' => 'date', 'type' => 'string', 'title' => 'string', 'content' => 'textarea', 'uid' => 'int', 'status' => 'int', 'note' => 'textarea', 'sort' => 'int', 'cate_sn' => 'int');
        // 要查詢的表
        $this->_tables = array(DB_PREFIX . "jill_notice");
        // 欄位檢查
        $this->_check = new NoticeCheck();
        // 過濾參數
        list(
            $this->_R['sn'],
            $this->_R['deadline'],
            $this->_R['type'],
            $this->_R['title'],
            $this->_R['content'],
            $this->_R['note'],
            $this->_R['cate_sn']
        ) = $this->getRequest()->getParam(array(
            isset($_REQUEST['sn']) ? Tool::setFormString($_REQUEST['sn'], "int") : null, isset($_REQUEST['deadline']) ? Tool::setFormString($_REQUEST['deadline'], "date") : null, isset($_REQUEST['type']) ? Tool::setFormString($_REQUEST['type']) : null, isset($_REQUEST['title']) ? Tool::setFormString($_REQUEST['title']) : null, isset($_REQUEST['content']) ? Tool::setFormString($_REQUEST['content']) : null, isset($_REQUEST['note']) ? Tool::setFormString($_REQUEST['note']) : null, isset($_REQUEST['cate_sn']) ? Tool::setFormString($_REQUEST['cate_sn'], "int") : null));
    }

    public function notice_list($_whereData = array())
    {
        $_where = array();
        if (!empty($_whereData)) {
            $_where = $_whereData;
        }

        $_AllNotice = parent::select($this->_fields, array('where' => $_where, 'limit' => $this->_limit, 'order' => 'cate_sn,sort desc'));
        // 增加外鍵查詢欄
        $this->_tables = array(DB_PREFIX . "jill_notice_cate");

        foreach ($_AllNotice as $key => $value) {
            $_where                         = array("cate_sn='{$value['cate_sn']}'");
            $_CateTitle                     = parent::select(array('cate_title' => 'string'), array('where' => $_where, 'limit' => '1'));
            $_AllNotice[$key]['cate_title'] = $_CateTitle[0]['cate_title'];
            // 申請人員
            $_AllNotice[$key]['uid_name'] = XoopsUser::getUnameFromId($value['uid'], 1);
            //將 uid 編號轉換成使用者姓名（或帳號）
            if (empty($_AllNotice[$key]['uid_name'])) {
                $_AllNotice[$key]['uid_name'] = XoopsUser::getUnameFromId($value['uid'], 0);
            }
            //轉換status名稱
            $_AllNotice[$key]['status_name'] = $this->getStatusName($value['status']);
            $_AllNotice[$key]['type_name']   = $this->getTypeName($value['type']);

            // 檢查是否有檔案
            if ($value['type'] == 'img' || $value['type'] == 'text') {
                $TadUpFiles = new TadUpFiles("jill_notice");
                $TadUpFiles->set_col("sn", $value['sn']);

                $_show_files = $TadUpFiles->show_files('up_sn', true, 'small', false, false, null, null, false);

                $_AllNotice[$key]['list_file'] = $_show_files;
            }
        }
        // die(var_dump($_AllNotice));
        return $_AllNotice;
    }

    public function notice_delete($_whereData = array())
    {
        $_where = array("sn='{$this->_R['sn']}'");
        if (!empty($_whereData)) {
            $_where = array_merge($_where, $_whereData);
        }
        return parent::delete($_where);
    }

    public function notice_add()
    {
        global $xoopsUser;
        // 檢查表單是否有填
        if (!$this->_check->allCheck($this, array('type' => "{$this->_R['type']}"))) {
            $this->_check->error();
        }
        // 過濾表單$_POST
        $_addData = $this->getRequest()->filter(array_keys($this->_fields));

        $_addData['sort'] = $this->getSort('sort', array("cate_sn='{$_addData['cate_sn']}'")) + 1;

        // 增加額外欄位
        $_addData['create_date'] = date("Y-m-d H:i:s", xoops_getUserTimestamp(time()));
        $_addData['uid']         = $xoopsUser->uid();
        $_addData['status']      = '0';

        // 去除自動遞增
        unset($_addData['sn']);
        return parent::add($_addData);
    }

    public function notice_update($_whereData = array())
    {
        $_where = array("sn='{$this->_R['sn']}'");
        if (!empty($_whereData)) {
            $_where = array_merge($_where, $_whereData);
        }

        if (!$this->_check->oneCheck($this, $_where)) {
            $this->_check->error();
        }
        if (!$this->_check->allCheck($this, array('type' => "{$this->_R['type']}"))) {
            $this->_check->error();
        }

        $_updateData = $this->getRequest()->filter(array_keys($this->_fields));

        parent::update($_where, $_updateData);
        return $this->_R['sn'];
    }
    public function findOne($_whereData = array())
    {
        $_where = array("sn='{$this->_R['sn']}'");
        if (!empty($_whereData)) {
            $_where = array_merge($_where, $_whereData);
        }
        // 先驗證是否有此編號的資料
        if (!$this->_check->oneCheck($this, $_where)) {
            $this->_check->error();
        }

        // 秀出此編號的詳細資訊
        $_OneNotice                 = parent::select($this->_fields, array('where' => $_where, 'limit' => '1'));
        $_OneNotice[0]['type_name'] = $this->getTypeName($_OneNotice[0]['type']);
        // 增加外鍵查詢欄
        $this->_tables               = array(DB_PREFIX . "jill_notice_cate");
        $_where                      = array("cate_sn='{$_OneNotice[0]['cate_sn']}'");
        $_CateTitle                  = parent::select(array('cate_title' => 'string'), array('where' => $_where, 'limit' => '1'));
        $_OneNotice[0]['cate_title'] = $_CateTitle[0]['cate_title'];
        // 申請人員
        $_OneNotice[0]['uid_name'] = XoopsUser::getUnameFromId($_OneNotice[0]['uid'], 1);
        //將 uid 編號轉換成使用者姓名（或帳號）
        if (empty($_OneNotice[0]['uid_name'])) {
            $_OneNotice[0]['uid_name'] = XoopsUser::getUnameFromId($_OneNotice[0]['uid'], 0);
        }
        //轉換status名稱
        $_OneNotice[0]['status_name'] = $this->getStatusName($_OneNotice[0]['status']);

        // 檢查是否有檔案
        if ($_OneNotice[0]['type'] == 'img' || $_OneNotice[0]['type'] == 'text') {
            $TadUpFiles = new TadUpFiles("jill_notice");
            $TadUpFiles->set_col("sn", $_OneNotice[0]['sn']);

            $_show_files = $TadUpFiles->show_files('up_sn', true, 'file_name', false, false, null, null, false);

            $_OneNotice[0]['list_file'] = $_show_files;
        }
        return $_OneNotice;
    }

    public function allNum($_whereData = array())
    {
        return parent::total($_whereData);
    }

    //以$status取得是否啟用
    public function getStatusName($_status = 0)
    {
        switch ($_status) {
            case '1':
                $_statusName = _MD_JILLNOTICE_STATUS1;
                break;
            case '2':
                $_statusName = _MD_JILLNOTICE_STATUS2;
                break;

            default:
                $_statusName = _MD_JILLNOTICE_STATUS0;
                break;
        }
        return $_statusName;
    }
    //以$type取得類型
    public function getTypeName($_type = 'text')
    {
        switch ($_type) {
            case 'textarea':
                $_type_name = _MD_JILLNOTICE_TYPE1;
                break;
            case 'url':
                $_type_name = _MD_JILLNOTICE_TYPE2;
                break;
            case 'img':
                $_type_name = _MD_JILLNOTICE_TYPE3;
                break;
            default:
                $_type_name = _MD_JILLNOTICE_TYPE0;
                break;
        }
        return $_type_name;
    }
}
