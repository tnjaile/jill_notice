<?php
//分類驗證類
class CateCheck extends Check
{
    public function titleCheck(Model $_model)
    {
        if (self::isNullString($_POST['cate_title'])) {
            $this->_message[] = '標題不得為空';
            $this->_flag      = false;
        }
        if (self::isNullArray($_POST['post_group'])) {
            $this->_message[] = '發布群組不得為空';
            $this->_flag      = false;
        }
        if (self::isNullArray($_POST['read_group'])) {
            $this->_message[] = '讀取群組不得為空';
            $this->_flag      = false;
        }
        return $this->_flag;
    }

}
