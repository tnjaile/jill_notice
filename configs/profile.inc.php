<?php

//資料表前綴
if (!defined('DB_PREFIX')) {
    define('DB_PREFIX', XOOPS_DB_PREFIX . "_");
}

/****分頁*****/
// 每頁顯示多少條
if (!defined('PAGE_SIZE')) {
    define('PAGE_SIZE', 1);
}
// 最多顯示10頁
if (!defined('PAGE_LIMIT')) {
    define('PAGE_LIMIT', 10);
}
