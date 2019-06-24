<?php
//驗證類
class Validate
{

    //判斷是否是數組
    public static function isArray($_array)
    {
        return is_array($_array) ? true : false;
    }

    //判斷數組是否有元素
    public static function isNullArray($_array)
    {
        return count($_array) == 0 ? true : false;
    }

    //判斷數組是否存在此元素
    public static function inArray($_data, $_array)
    {
        return in_array($_data, $_array) ? true : false;
    }

    //判斷字符串是否為空
    public static function isNullString($_string)
    {
        return empty($_string) ? true : false;
    }

    //判斷字符串長度是否合法
    public static function checkStrLength($_string, $_length, $_flag, $_charset = 'utf-8')
    {
        if ($_flag == 'min') {
            if (mb_strlen(trim($_string), $_charset) < $_length) {
                return true;
            }

            return false;
        } elseif ($_flag == 'max') {
            if (mb_strlen(trim($_string), $_charset) > $_length) {
                return true;
            }

            return false;
        } elseif ($_flag == 'equals') {
            if (mb_strlen(trim($_string), $_charset) != $_length) {
                return true;
            }

            return false;
        }
    }

    //判斷數據是否一致
    public static function checkStrEquals($_string, $_otherstring)
    {
        if (trim($_string) == trim($_otherstring)) {
            return true;
        }

        return false;
    }
    //判斷網址格式
    public static function checkUrl($_string)
    {
        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_string)) {
            return true;
        }
        return false;
    }
}
