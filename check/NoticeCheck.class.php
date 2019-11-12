<?php
//公告驗證類
class NoticeCheck extends Check {
	public function allCheck(Model &$_model, array $_param) {

		if (self::isNullString($_POST['title'])) {
			$this->_message[] = '標題不得為空';
			return false;
		}
		if (self::checkStrLength($_POST['title'], 2, 'min')) {
			$this->_message[] = '標題不得小於2位！';
			return false;
		}
		if (self::checkStrLength($_POST['title'], 20, 'max')) {
			$this->_message[] = '標題不得大於20位！';
			return false;
		}

		if ($_param['type'] == "url") {
			if (self::isNullString($_POST['content'])) {
				$this->_message[] = '網址不得為空';
				return false;
			}
			if (!self::checkUrl($_POST['content'])) {
				$this->_message[] = '網址格式不正確';
				return false;
			}
		}
		return true;
	}

}
