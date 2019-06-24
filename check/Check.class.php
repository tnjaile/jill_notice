<?php
//驗證基類--判斷驗證是否通過，默認通過
class Check extends Validate
{
    //判斷驗證是否通過，默認通過
    protected $_flag = true;
    //錯誤消息集
    protected $_message = array();
    private $_tpl       = null;

    public function __construct()
    {
    }

    public function oneCheck(Model $_model, array $_param)
    {
        if (!$_model->isOne($_param)) {
            $this->_message[] = '找不到指定的數據！';
            $this->_flag      = false;
        }
        return $this->_flag;
    }

    //驗證數據的合法性
    public function error($_url = '')
    {
        if (empty($_url)) {
            $_error = implode("<br>", $this->_message);
            redirect_header($_SERVER['PHP_SELF'], 3, $_error);
            exit();
        } else {
            redirect_header($_url, 3, "驗證指定數據成功");
        }
    }
}
