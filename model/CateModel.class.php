<?php
class CateModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        // 要顯示的欄位及欄位類型
        $this->_fields = array('cate_sn' => 'int', 'cate_title' => 'string', 'cate_desc' => 'textarea', 'cate_sort' => 'int', 'post_group' => 'json', 'read_group' => 'json', 'auditors' => 'string');
        // 要查詢的表
        $this->_tables = array(DB_PREFIX . "jill_notice_cate");
        // 欄位檢查
        $this->_check = new CateCheck();
        // 過濾參數
        list(
            $this->_R['cate_sn'],
            $this->_R['cate_title'],
            $this->_R['cate_desc']
        ) = $this->getRequest()->getParam(array(
            isset($_REQUEST['cate_sn']) ? Tool::setFormString($_REQUEST['cate_sn'], "int") : null,
            isset($_REQUEST['cate_title']) ? Tool::setFormString($_REQUEST['cate_title'], "string") : null, isset($_REQUEST['cate_desc']) ? Tool::setFormString($_REQUEST['cate_desc']) : null));
    }

    public function cate_list()
    {
        $_ALLCate = parent::select($this->_fields, array('limit' => $this->_limit, 'order' => 'cate_sort DESC'));
        foreach ($_ALLCate as $key => $value) {
            if (!empty($value['post_group'])) {
                $post_group=array();
                foreach ($value['post_group'] as $group_id) {
                    $post_group[] = Group::get_groupname($group_id);
                }
                $_ALLCate[$key]['post_group'] = implode(" | ", $post_group);
                
            }
            if (!empty($value['read_group'])) {
                $read_group=array();
                foreach ($value['read_group'] as $group_id) {
                    $read_group[] = Group::get_groupname($group_id);
                }
                $_ALLCate[$key]['read_group'] = implode(" | ", $read_group);
                
            }
            if (!empty($value['auditors'])) {
                $auditors = explode(";", $value['auditors']);

                $auditor_uname = array();
                foreach ($auditors as $auditor) {
                    $auditor_uname[] = XoopsUser::getUnameFromId($auditor, 0);
                }
                $_ALLCate[$key]['auditors'] = implode(" | ", $auditor_uname);
            }
           
            
        }
        
        // die(var_dump($_ALLCate));
        return $_ALLCate;
    }

    public function cate_delete()
    {
        $_where = array("cate_sn='{$this->_R['cate_sn']}'");
        return parent::delete($_where);
    }

    public function cate_add()
    {
        if (!$this->_check->titleCheck($this)) {
            $this->_check->error();
        }

        $_addData = $this->getRequest()->filter($this->_fields);
        // 去除自動遞增
        unset($_addData['cate_sn']);
        $_addData['cate_sort'] = $this->getSort('cate_sort') + 1;
        return parent::add($_addData);
    }

    public function cate_update($_selectData = array(), $_ischeck = 1)
    {
        $_where = array("cate_sn='{$this->_R['cate_sn']}'");
        if (!$this->_check->oneCheck($this, $_where)) {
            $this->_check->error();
        }
        if (!empty($_ischeck)) {
            if (!$this->_check->titleCheck($this)) {
                $this->_check->error();
            }
        }

        $_selectData = empty($_selectData) ? $this->_fields : $_selectData;
        $_updateData = $this->getRequest()->filter($_selectData);
        return parent::update($_where, $_updateData);
    }
    public function findOne($_whereData = array())
    {
        $_where = array("cate_sn='{$this->_R['cate_sn']}'");
        if (!empty($_whereData)) {
            $_where = array_merge($_where, $_whereData);
        }
        //先驗證是否有此編號的資料
        if (!$this->_check->oneCheck($this, $_where)) {
            $this->_check->error();
        }

        // 秀出此編號的詳細資訊
        $_OneCate = parent::select($this->_fields, array('where' => $_where, 'limit' => '1'));
        if (!empty($_OneCate[0]['post_group'])) {
            foreach ($_OneCate[0]['post_group'] as $group_id) {
                $post_groupname[] = Group::get_groupname($group_id);
            }

            $_OneCate[0]['post_group_name'] = implode(" | ", $post_groupname);
        }
        if (!empty($_OneCate[0]['read_group'])) {
            foreach ($_OneCate[0]['read_group'] as $group_id) {
                $read_group[] = Group::get_groupname($group_id);
            }

            $_OneCate[0]['read_group_name'] = implode(" | ", $read_group);
        }
        if (!empty($_OneCate[0]['auditors'])) {
            $auditors = explode(";", $_OneCate[0]['auditors']);
            $auditor_uname = array();
            foreach ($auditors as $auditor) {
                $_OneCate[0]['auditor_group'][$auditor] = XoopsUser::getUnameFromId($auditor, 0);
                $auditor_uname[] = XoopsUser::getUnameFromId($auditor, 0);
            }
            $_OneCate[0]['auditors_name'] = implode(" | ", $auditor_uname);
        }
        // die(var_dump($_OneCate[0]));
        return $_OneCate;
    }

    public function allNum()
    {
        return parent::total();
    }

    // 產生分類選單
    public function findCateTitle()
    {
        $_cates = parent::select(array('cate_sn' => 'int', 'cate_title' => 'string','auditors' => 'string'));
        // die(var_dump($_cates));
        $_allCate = array();
        foreach ($_cates as $value) {
            $value['cate_sn']=intval($value['cate_sn']);
            $_allCate['cates'][$value['cate_sn']] = $value['cate_title'];
            // Notice是否啟用           
            $_allCate['status'][$value['cate_sn']]=(empty($value['auditors']))?1:0;
        }
        return $_allCate;
    }

}
