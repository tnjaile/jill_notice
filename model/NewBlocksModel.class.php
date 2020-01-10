<?php
class NewBlocksModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        // 要顯示的欄位及欄位類型
        $this->_fields = array('bid' => 'int', 'mid' => 'int', 'func_num' => 'int', 'options' => 'string', 'name' => 'string', 'title' => 'string', 'content' => 'textarea', 'side' => 'int', 'weight' => 'int', 'visible' => 'int', 'block_type' => 'string', 'c_type' => 'string', 'isactive' => 'int', 'dirname' => 'string', 'func_file' => 'string', 'show_func' => 'string', 'edit_func' => 'string', 'template' => 'string', 'bcachetime' => 'int', 'last_modified' => 'int');
        // 要查詢的表
        $this->_tables = array(DB_PREFIX . "newblocks");
        list($this->_R['cate_title'],
            $this->_R['cate_sn'],
            $this->_R['read_group']
        ) = $this->getRequest()->getParam([
            isset($_POST['cate_title']) ? Tool::setFormString($_POST['cate_title'], "string") : null,
            isset($_POST['cate_sn']) ? Tool::setFormString($_POST['cate_sn'], "int") : null,
            isset($_POST['read_group']) ? Tool::setFormString($_POST['read_group'], "int") : null]);
    }

    public function newblocks_add($_sn)
    {
        global $xoopsModule;

        $_addData['mid']           = $xoopsModule->getVar('mid');
        $_addData['func_num']      = 0;
        $_addData['options']       = $_sn;
        $_addData['name']          = "臨時公告：" . $this->_R['cate_title'];
        $_addData['title']         = $this->_R['cate_title'];
        $_addData['content']       = "";
        $_addData['side']          = 0;
        $_addData['weight']        = 0;
        $_addData['visible']       = 1;
        $_addData['block_type']    = ($_sn == 1) ? "M" : "D";
        $_addData['c_type']        = "H";
        $_addData['isactive']      = 1;
        $_addData['dirname']       = "jill_notice";
        $_addData['func_file']     = "showBlock.php";
        $_addData['show_func']     = "jill_notice_show";
        $_addData['edit_func']     = "";
        $_addData['template']      = "jill_notice_show.tpl";
        $_addData['bcachetime']    = 0;
        $_addData['last_modified'] = time();
        $bid                       = parent::add($_addData);
        // 新增到block_module_link
        $this->_fields          = array('block_id' => 'int', 'module_id' => 'int');
        $this->_tables          = array(DB_PREFIX . "block_module_link");
        $_addData2['block_id']  = $bid;
        $_addData2['module_id'] = -1;
        parent::add($_addData2);
        // 新增群組權限group_permission
        $this->_fields = array('gperm_groupid' => 'int', 'gperm_itemid' => 'int', 'gperm_modid' => 'int', 'gperm_name' => 'string');
        $this->_tables = array(DB_PREFIX . "group_permission");
        foreach ($this->_R['read_group'] as $gperm_groupid) {
            $_addData3['gperm_groupid'] = $gperm_groupid;
            $_addData3['gperm_itemid']  = $bid;
            $_addData3['gperm_modid']   = 1;
            $_addData3['gperm_name']    = "block_read";
            parent::add($_addData3);
        }

        // 回復初始
        $this->_fields = array('bid' => 'int', 'mid' => 'int', 'func_num' => 'int', 'options' => 'string', 'name' => 'string', 'title' => 'string', 'content' => 'textarea', 'side' => 'int', 'weight' => 'int', 'visible' => 'int', 'block_type' => 'string', 'c_type' => 'string', 'isactive' => 'int', 'dirname' => 'string', 'func_file' => 'string', 'show_func' => 'string', 'edit_func' => 'string', 'template' => 'string', 'bcachetime' => 'int', 'last_modified' => 'int');
        $this->_tables = array(DB_PREFIX . "newblocks");
        return $bid;
    }

    public function newblocks_update($_sn)
    {
        global $xoopsModule;
        $_where    = array("dirname='jill_notice' && options={$_sn}");
        $_OneBlock = $this->findOne($_where);

        $_updateData['name']          = "臨時公告：" . $this->_R['cate_title'];
        $_updateData['title']         = $this->_R['cate_title'];
        $_updateData['last_modified'] = time();
        parent::update($_where, $_updateData);
        // 更新權限
        $this->_fields = array('gperm_groupid' => 'int', 'gperm_itemid' => 'int', 'gperm_modid' => 'int', 'gperm_name' => 'string');
        $this->_tables = array(DB_PREFIX . "group_permission");
        $_AllGroup     = parent::select(array('gperm_groupid' => 'int'), array('where' => array("gperm_itemid='{$_OneBlock['bid']}'")));

        $_groupids = $intersect = [];
        foreach ($_AllGroup as $value) {
            $_groupids[] = $value['gperm_groupid'];
        }

        foreach ($this->_R['read_group'] as $groupid) {
            if (in_array($groupid, $_groupids)) {
                // 交集的array()
                $intersect[] = $groupid;
            } else {
                $_addData3['gperm_groupid'] = $groupid;
                $_addData3['gperm_itemid']  = $_OneBlock['bid'];
                $_addData3['gperm_modid']   = 1;
                $_addData3['gperm_name']    = "block_read";
                parent::add($_addData3);
            }
        }
        // die(var_dump($intersect));
        // 刪除gperm_groupid多的

        $_diff = array_diff($_groupids, $intersect);
        // die(var_dump($intersect) . var_dump($_groupids) . var_dump($_diff));
        if (!empty($_diff)) {
            foreach ($_diff as $del_id) {
                parent::delete(array("gperm_groupid='{$del_id}' && gperm_itemid='{$_OneBlock['bid']}' ", 1));
            }
        }
        // 回復初始
        $this->_fields = array('bid' => 'int', 'mid' => 'int', 'func_num' => 'int', 'options' => 'string', 'name' => 'string', 'title' => 'string', 'content' => 'textarea', 'side' => 'int', 'weight' => 'int', 'visible' => 'int', 'block_type' => 'string', 'c_type' => 'string', 'isactive' => 'int', 'dirname' => 'string', 'func_file' => 'string', 'show_func' => 'string', 'edit_func' => 'string', 'template' => 'string', 'bcachetime' => 'int', 'last_modified' => 'int');
        $this->_tables = array(DB_PREFIX . "newblocks");
        return $_sn;
    }
    public function newblocks_delete()
    {
        $_where = array("dirname='jill_notice' && options={$this->_R['cate_sn']}");
        $_One   = $this->findOne($_where);
        if (!empty($_One)) {
            parent::delete($_where);
            // 刪除block_module_link
            $this->_tables = array(DB_PREFIX . "block_module_link");
            parent::delete(array("block_id='{$_One['bid']}'"));
            // 刪除權限group_permission(多筆)
            $this->_tables = array(DB_PREFIX . "group_permission");
            parent::delete(array("gperm_itemid='{$_One['bid']}'"), 1);
            // 回復
            $this->_tables = array(DB_PREFIX . "newblocks");
            return $_One['bid'];
        }
    }
    public function findOne($_whereData = array())
    {
        // 秀出此編號的詳細資訊
        $_One = parent::select($this->_fields, array('where' => $_whereData, 'limit' => '1'));
        return $_One[0];
    }
}
