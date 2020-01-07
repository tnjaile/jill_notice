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
        list($this->_R['cate_title']
        ) = $this->getRequest()->getParam(array(isset($_REQUEST['cate_title']) ? Tool::setFormString($_REQUEST['cate_title'], "string") : null));
    }

    public function newblocks_add($_sn)
    {
        global $xoopsModule;
        // die(var_dump($_POST));
        $_addData['mid']           = $xoopsModule->getVar('mid');
        $_addData['func_num']      = 0;
        $_addData['options']       = $_sn;
        $_addData['name']          = "臨時公告：" . $this->_R['cate_title'];
        $_addData['title']         = $this->_R['cate_title'];
        $_addData['content']       = "";
        $_addData['side']          = 0;
        $_addData['weight']        = 0;
        $_addData['visible']       = 0;
        $_addData['block_type']    = "D";
        $_addData['c_type']        = "H";
        $_addData['isactive']      = 1;
        $_addData['dirname']       = "jill_notice";
        $_addData['func_file']     = "showBlock.php";
        $_addData['show_func']     = "jill_notice_show";
        $_addData['edit_func']     = "jill_notice_show_edit";
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
        for ($i = 2; $i < 4; $i++) {
            $_addData3['gperm_groupid'] = $i;
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
}
