<?php
use XoopsModules\Tadtools\TadUpFiles;

if (!class_exists('XoopsModules\Tadtools\TadUpFiles')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}
class NoticeModel extends Model
{
    private $_TadUpFiles = null;
    public function __construct()
    {
        parent::__construct();

        $this->_TadUpFiles = new TadUpFiles("jill_notice");
        // 要顯示的欄位及欄位類型
        $this->_fields = array('sn' => 'int', 'create_date' => 'date', 'start' => 'date', 'deadline' => 'date', 'type' => 'string', 'title' => 'string', 'content' => 'textarea', 'uid' => 'int', 'status' => 'int', 'note' => 'textarea', 'sort' => 'int', 'cate_sn' => 'int');
        // 要查詢的表
        $this->_tables = array(DB_PREFIX . "jill_notice");
        // 欄位檢查
        $this->_check = new NoticeCheck();

        // 過濾參數
        list(
            $this->_R['sn'],
            $this->_R['type']
        ) = $this->getRequest()->getParam([
            isset($_REQUEST['sn']) ? Tool::setFormString($_REQUEST['sn'], "int") : null,
            isset($_POST['type']) ? Tool::setFormString($_POST['type'], "string") : null,
        ]);

    }

    public function notice_list($_whereData = array())
    {
        $_AllNotice = parent::select($this->_fields, array('where' => $_whereData, 'limit' => $this->_limit, 'order' => 'cate_sn,status,sort desc'));
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
            if ($value['type'] == 'img' || $value['type'] == 'text' || $value['type'] == 'url') {
                $this->_TadUpFiles->set_col("sn", $value['sn']);

                $_show_files = $this->_TadUpFiles->show_files('up_sn', true, 'small', false, false, null, null, false);

                $_AllNotice[$key]['list_file'] = $_show_files;
            }
        }
        // die(var_dump($_AllNotice));
        return $_AllNotice;
    }

    public function notice_delete($_whereData = array(), $_non_limit = 0)
    {
        $_where = (empty($_whereData)) ? array("sn='{$this->_R['sn']}'") : $_whereData;
        return parent::delete($_where, $_non_limit);
    }

    public function notice_add()
    {
        global $xoopsUser;

        // 檢查表單是否有填
        if (!$this->_check->allCheck($this, array('type' => "{$this->_R['type']}"))) {
            return $this->_check->error();
        }

        // json型態轉陣列(不在欄位的額外變數，不過濾)
        // $_status = json_decode(stripslashes($_POST['status']), true);
        $_status = json_decode($_POST['status_js'], true);
        // die(var_dump($_status));
        //過濾表單 $_POST
        $_addData = $this->getRequest()->filter($this->_fields);
        // die(var_dump($_POST));
        $_addData['sort'] = $this->getSort('sort', array("cate_sn='{$_addData['cate_sn']}'")) + 1;

        // 增加額外欄位
        $_addData['create_date'] = date("Y-m-d H:i:s", xoops_getUserTimestamp(time()));
        $_addData['start']       = (strtotime($_addData['start'])) ? $_addData['start'] : date("Y-m-d H:i:s", xoops_getUserTimestamp(time()));
        $_addData['uid']         = $xoopsUser->uid();
        $_addData['status']      = $_status[$_addData['cate_sn']];
        if ($this->_R['type'] == 'textarea') {
            $_addData["content"] = strip_tags($_addData["content"]);
        }
        // 去除自動遞增
        unset($_addData['sn']);
        return parent::add($_addData);
    }

    public function notice_update($_whereData = array())
    {
        $_where = (empty($_whereData)) ? array("sn='{$this->_R['sn']}'") : $_whereData;

        if (!$this->_check->oneCheck($this, $_where)) {
            return;
        }
        if (!$this->_check->allCheck($this, array('type' => "{$this->_R['type']}"))) {
            return $this->_check->error();
        }

        $_updateData          = $this->getRequest()->filter($this->_fields);
        $_updateData['start'] = (strtotime($_updateData['start'])) ? $_updateData['start'] : date("Y-m-d H:i:s", xoops_getUserTimestamp(time()));
        if ($this->_R['type'] == 'textarea') {
            $_updateData["content"] = strip_tags($_updateData["content"]);
        }
        parent::update($_where, $_updateData);
        return $this->_R['sn'];
    }
    public function findOne($_whereData = array())
    {
        $_where = (empty($_whereData)) ? array("sn='{$this->_R['sn']}'") : $_whereData;
        // 先驗證是否有此編號的資料
        if (!$this->_check->oneCheck($this, $_where)) {
            return;
        }

        // 秀出此編號的詳細資訊
        $_OneNotice = parent::select(array('sn' => 'int', 'create_date' => 'date', 'start' => 'date', 'deadline' => 'date', 'type' => 'string', 'title' => 'string', 'content' => 'ckeditor', 'uid' => 'int', 'status' => 'int', 'note' => 'textarea', 'sort' => 'int', 'cate_sn' => 'int'), array('where' => $_where, 'limit' => '1'));

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
        if ($_OneNotice[0]['type'] == 'img' || $_OneNotice[0]['type'] == 'text' || $_OneNotice[0]['type'] == 'url') {
            $this->_TadUpFiles->set_col("sn", $_OneNotice[0]['sn']);

            $_show_files = $this->_TadUpFiles->show_files('up_sn', true, 'file_name', false, false, null, null, false);

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
            case 'ckeditor':
                $_type_name = _MD_JILLNOTICE_TYPE4;
                break;
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
    // 設定類型
    public function setType()
    {
        $_typeArr = array('text' => _MD_JILLNOTICE_TYPE0, 'textarea' => _MD_JILLNOTICE_TYPE1, 'url' => _MD_JILLNOTICE_TYPE2, 'img' => _MD_JILLNOTICE_TYPE3, 'ckeditor' => _MD_JILLNOTICE_TYPE4);

        return $_typeArr;
    }
    // 區塊用
    public function show_block($_whereData = array())
    {
        global $xoTheme;
        $xoTheme->addStylesheet('modules/tadtools/css/iconize.css');

        $_AllNotice = parent::select(array('sn' => 'int', 'create_date' => 'date', 'start' => 'date', 'deadline' => 'date', 'type' => 'string', 'title' => 'string', 'content' => 'ckeditor', 'uid' => 'int', 'status' => 'int', 'note' => 'textarea', 'sort' => 'int', 'cate_sn' => 'int'), array('where' => $_whereData, 'order' => 'create_date desc,sort'));

        foreach ($_AllNotice as $key => $value) {
            if ($value['type'] == "img") {
                $this->_TadUpFiles->set_col("sn", $value['sn']);
                $_show_files                   = $this->_TadUpFiles->show_files('up_sn', true, '', false, false, null, null, false);
                $_AllNotice[$key]['list_file'] = strip_tags($_show_files, '<a>');
            } elseif ($value['type'] == "url") {
                $this->_TadUpFiles->set_col("sn", $value['sn']);
                $_AllNotice[$key]['list_file'] = $this->_TadUpFiles->get_pic_file();
<<<<<<< HEAD
                // $_AllNotice[$key]['content']   = strip_tags($value['content']);
                preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $value['content'], $result);
                $_AllNotice[$key]['content'] = $result['href'][0];

=======
                $_AllNotice[$key]['content']   = strip_tags($value['content']);
>>>>>>> 8e0008f5382b2a4150f266f3c597cb71454a7256
            } elseif ($value['type'] == 'text') {
                $this->_TadUpFiles->set_col("sn", $value['sn']);
                $_show_files = $this->_TadUpFiles->get_file(null);
                // $_AllNotice[$key]['list_file'] = strip_tags($_show_files, '<a>');
                $_AllNotice[$key]['list_file'] = $_show_files;
            }
        }
        // die(var_dump($_AllNotice));
        return $_AllNotice;
    }
}
