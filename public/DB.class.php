<?php
class DB
{
    private $_db              = null;
    private static $_instance = null;

    protected static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    //私有克隆
    private function __clone()
    {}

    //私有構造
    private function __construct()
    {
        global $xoopsDB;
        $this->_db = $xoopsDB;
    }

    // 一個表或多個表查詢
    protected function selectData($_tables, array $_fileld, array $_param = array())
    {
        $_limit = $_order = $_where = '';
        if (Validate::isArray($_param) && !Validate::isNullArray($_param)) {
            $_limit = empty($_param['limit']) ? '' : 'LIMIT ' . $_param['limit'];
            $_order = empty($_param['order']) ? '' : 'ORDER BY ' . $_param['order'];
            $_where = empty($_param['where']) ? '' : 'where ' . implode(' && ', $_param['where']);
        }

        $_selectFields = implode(',', array_keys($_fileld));
        $_table        = implode(',', $_tables);

        $_sql = "SELECT $_selectFields FROM $_table $_where $_order $_limit";
        // die($_sql);
        $_result = $this->_db->query($_sql) or XoopsModules\Tadtools\Utility::web_error($_sql);

        $_output = array();
        $myts    = \MyTextSanitizer::getInstance();
        while ($_objs = $this->_db->fetchArray($_result)) {
            // die(var_dump($_objs));
            foreach ($_objs as $k => $v) {
                if ($_fileld[$k] == "int") {
                    $_objs[$k] = intval($v);
                } elseif ($_fileld[$k] == "textarea") {
                    $_objs[$k] = $myts->displayTarea($v, 0, 1, 0, 1, 0);
                } elseif ($_fileld[$k] == "ckedit") {
                    $_objs[$k] = $myts->displayTarea($v, 1, 1, 0, 1, 0);
                } else {
                    $_objs[$k] = $myts->htmlSpecialChars($v);
                }
            }
            $_output[] = $_objs;
        }
        return $_output;
    }

    //新增
    protected function addData($_tables, array $_addData)
    {
        $_addFields = array();
        $_addValues = array();
        foreach ($_addData as $_key => $_value) {
            $_addFields[] = $_key;
            $_addValues[] = $_value;
        }
        $_addFields = implode(',', $_addFields);
        $_addValues = implode("','", $_addValues);
        $_sql       = "INSERT INTO {$_tables[0]} ($_addFields) VALUES ('$_addValues')";
        // die($_sql);

        $_result = $this->_db->queryF($_sql) or XoopsModules\Tadtools\Utility::web_error($_sql);

        return $this->_db->getInsertId();
    }

    // 更新
    protected function updateData($_tables, array $_param, array $_updateData)
    {

        $_where   = 'where ' . implode(' && ', $_param);
        $_setData = "";
        foreach ($_updateData as $_key => $_value) {
            if (Validate::isArray($_value)) {
                $_setData .= "$_key=$_value[0],";
            } else {
                $_setData .= "$_key='$_value',";
            }
        }

        $_setData = substr($_setData, 0, -1);

        $_sql = "UPDATE $_tables[0] SET $_setData $_where LIMIT 1";
        // die($_sql);
        $_result = $this->_db->queryF($_sql) or XoopsModules\Tadtools\Utility::web_error($_sql);
        return $_result;
    }

    //删除
    protected function deleteData($_tables, array $_param)
    {
        $_where = 'where ' . implode(' && ', $_param);

        $_sql = "DELETE FROM $_tables[0] $_where LIMIT 1";

        $_result = $this->_db->queryF($_sql) or XoopsModules\Tadtools\Utility::web_error($_sql);

        return $this->_db->getAffectedRows();
    }

    //驗證一條數據
    protected function isOneData($_tables, array $_param)
    {
        $_where = '';
        // die(var_dump($_param));
        foreach ($_param as $_key => $_value) {
            //where條件不抓密碼
            if ($_key !== "pass") {
                $_where .= $_value . ' && ';
            }
        }
        $_where = 'WHERE ' . substr($_where, 0, -4);

        $_sql = "SELECT * FROM $_tables[0] $_where LIMIT 1";
        // die($_sql);

        $_result = $this->_db->query($_sql) or XoopsModules\Tadtools\Utility::web_error($_sql);

        //密碼驗證
        if (isset($_param['pass'])) {
            if (!!$_objs = $this->_db->fetchObject($_result)) {
                $pass = $_objs->pass;
                if (password_verify($_param['pass'], $pass)) {
                    return $this->_db->getAffectedRows();
                }
            }
        } else {
            return $this->_db->getAffectedRows();
        }

    }

    //總紀錄
    protected function totalNum($_tables, array $_param = array())
    {
        $_where = (empty($_param)) ? "" : 'where ' . implode(' && ', $_param);

        $_sql = "SELECT COUNT(*) as count FROM $_tables[0] $_where";
        // die($_sql);
        $result = $this->_db->query($_sql) or XoopsModules\Tadtools\Utility::web_error($_sql);

        list($_count) = $this->_db->fetchRow($result);
        return $_count;
    }

    //取得排序
    protected function getMaxSort($_tables, $_col, array $_param = array())
    {
        $_where = 'where ' . implode(' && ', $_param);

        $_sql = "SELECT max($_col) as sort FROM $_tables[0] $_where";

        $result = $this->_db->query($_sql) or XoopsModules\Tadtools\Utility::web_error($_sql);

        list($_sort) = $this->_db->fetchRow($result);
        return $_sort;
    }

}
