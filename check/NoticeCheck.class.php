<?php
//公告驗證類
class NoticeCheck extends Check
{
    public function allCheck(Model &$_model, array $_param)
    {

        if (self::isNullString($_POST['deadline'])) {
            $this->_message[] = '下架時間不得為空';
            $this->_flag      = false;
        }

        if ($_param['type'] == "ckeditor") {
            if (self::isNullString($_POST['content'])) {
                $this->_message[] = '內容不得為空';
                $this->_flag      = false;
            }
        } elseif ($_param['type'] == "url") {
            if (self::isNullString($_POST['content'])) {
                $this->_message[] = '網址不得為空';
                $this->_flag      = false;
            }
            if (!self::checkUrl($_POST['content'])) {
                $this->_message[] = '網址格式不正確';
                $this->_flag      = false;
            }
        } elseif ($_param['type'] == "textarea") {
            if (self::isNullString($_POST['content'])) {
                $this->_message[] = '內容不得為空';
                $this->_flag      = false;
            }
        } else {
            if (self::isNullString($_POST['title'])) {
                $this->_message[] = '標題不得為空';
                $this->_flag      = false;
            }
            if (self::checkStrLength($_POST['title'], 2, 'min')) {
                $this->_message[] = '標題不得小於2位！';
                $this->_flag      = false;
            }
            if (self::checkStrLength($_POST['title'], 40, 'max')) {
                $this->_message[] = '標題不得大於20位！';
                $this->_flag      = false;
            }
        }
        return $this->_flag;
    }

}
