<?php
//HTTP請求類(單例模式)--過濾數據用
class Request
{
    private static $_instance = null;
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    //私有克隆
    private function __clone()
    {}
    //防止被反序列
    private function __wakeup()
    {}
    //私有構造
    private function __construct()
    {
        //過濾$_GET&$_POST
        Tool::setRequest();
    }

    //取得参数處理
    public function getParam(array $_param)
    {
        $_getParam = array();
        foreach ($_param as $_key => $_value) {
            if ($_key == 'in') {
                $_value = str_replace(',', "','", $_value);
            }
            $_getParam[] = $_value;
        }
        return $_getParam;
    }

    //取得新增和修改的字段
    public function filter(array $_fields)
    {
        $_selectData = array();
        // die(var_dump($_POST));
        if (Validate::isArray($_POST) && !Validate::isNullArray($_POST)) {
            $myts = \MyTextSanitizer::getInstance();
            foreach ($_POST as $_key => $_value) {
                if (Validate::inArray($_key, array_keys($_fields))) {
                    // 陣列就用json存
                    if ($_fields[$_key] == "json") {
                        $_value = json_encode($_value, JSON_UNESCAPED_UNICODE);
                    } else {
                        $_value = $myts->addSlashes($_value);
                    }
                    $_selectData[$_key] = $_value;
                }

            }
        }

        return $_selectData;
    }

}
