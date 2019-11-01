<?php
/**
 *
 * @authors tnjaile (you@example.org)
 * @date    2017-09-20 14:10:30
 * @version $Id$
 */
//單入口變簡單工廠模式
final class Factory
{

    private static $_obj = null;

    // 檔案產生就檢查有無資料庫物件
    public static function setModel()
    {
        $_class = substr(basename($_SERVER["SCRIPT_NAME"]), 0, -4);
        if (file_exists(MODULE_DIR . "/model/" . ucfirst($_class) . 'Model.class.php')) {
            eval('self::$_obj = new ' . ucfirst($_class) . 'Model();');
        }
        return self::$_obj;
    }

}
