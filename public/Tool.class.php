<?php
//工具類，封裝函数和算法等。
class Tool
{

    //取得客户端ip
    public static function getIP()
    {
        return $_SERVER["REMOTE_ADDR"];
    }

    //取得目前的時間
    public static function getDate()
    {
        //date_default_timezone_set('Asia/Taipei');
        return date('Y-m-d H:i:s');
    }

    //避免表單輸入特殊字符:a\dm<?"in
    public static function setFormString($_string, $_filter_typ = "")
    {
        if (!get_magic_quotes_gpc()) {
            if (Validate::isArray($_string)) {
                foreach ($_string as $_key => $_value) {
                    $_string[$_key] = self::setFormString($_value, $_filter_typ);
                }
            } else {
                switch ($_filter_typ) {
                    case 'date':
                        $_string = strtotime($_string);
                        break;
                    case 'string':
                        $_string = filter_var($_string, FILTER_SANITIZE_MAGIC_QUOTES);
                        break;
                    case 'int':
                        $_string = filter_var($_string, FILTER_SANITIZE_NUMBER_INT);
                        break;
                    default:
                        $_string = addslashes($_string);
                        break;
                }
            }
        }

        return $_string;
    }

    //表單下拉選單轉換
    public static function setFormItem($_data, $_key, $_value)
    {
        $_items = array();

        if (Validate::isArray($_data)) {

            foreach ($_data as $_v) {
                $_items[$_v->$_key] = $_v->$_value;
            }
        }
        return $_items;
    }

    //回上一頁
    public static function getPrevPage()
    {
        return empty($_SERVER["HTTP_REFERER"]) ? '###' : $_SERVER["HTTP_REFERER"];
    }

    //html過濾
    public static function setHtmlString($_data)
    {
        if (is_array($_data)) {
            foreach ($_data as $_key => $_value) {
                $_string[$_key] = self::setHtmlString($_value); //遞迴
            }
        } elseif (is_object($_data)) {
            $_string = new stdClass();
            foreach ($_data as $_key => $_value) {
                $_string->$_key = self::setHtmlString($_value); //遞迴
            }
            //die(var_dump($_string));
        } else {
            $_string = htmlspecialchars($_data);
        }
        return $_string;
    }

    //過濾
    public static function setRequest()
    {
        //用filter_var比較好
        if (isset($_REQUEST)) {
            $_REQUEST = Tool::setFormString($_REQUEST);
        }

    }
}
